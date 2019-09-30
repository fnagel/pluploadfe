<?php

namespace FelixNagel\Pluploadfe\Eid;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011-2019 Felix Nagel <info@felixnagel.com>
 *  (c) 2016 Daniel Wagner
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Utility\EidUtility;
use FelixNagel\Pluploadfe\Exception\AuthenticationException;
use FelixNagel\Pluploadfe\Exception\InvalidArgumentException;
use FelixNagel\Pluploadfe\Utility\Filesystem;
use FelixNagel\Pluploadfe\Utility\FileValidation;

/**
 * This class uploads files.
 *
 * @todo translate error messages
 */
class Upload
{
    /**
     * @var bool
     */
    private $chunkedUpload = false;

    /**
     * @var \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
     */
    private $feUserObj = null;

    /**
     * @var array
     */
    private $config = [];

    /**
     * @var string
     */
    private $uploadPath = '';

    /**
     * @param ServerRequestInterface $request the current request object
     * @param ResponseInterface $response the available response
     * @return ResponseInterface the modified response
     */
    public function processRequest(ServerRequestInterface $request, ResponseInterface $response)
    {
        /* @var $response HtmlResponse */
        $response = $response->withHeader('Content-Type', 'application/json; charset=utf-8');
        $response = $response->withHeader('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
        $response = $response->withHeader('Last-Modified', gmdate('D, d M Y H:i:s').' GMT');
        $response = $response->withHeader('Pragma', 'no-cache');
        $response = $response->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
        $response = $response->withAddedHeader('Cache-Control', 'post-check=0, pre-check=0');

        try {
            $this->main();
            // Return JSON-RPC response if upload process is successfully finished
            $response->getBody()->write('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
            return $response;
        } catch (AuthenticationException $exception) {
            $response->getBody()->write($this->getErrorResponseContent($exception));
            return $response->withStatus(403);
        } catch (InvalidArgumentException $exception) {
            $response->getBody()->write($this->getErrorResponseContent($exception));
            return $response->withStatus(410);
        } catch (\Exception $exception) {
            $response->getBody()->write($this->getErrorResponseContent($exception));
            return $response->withStatus(404);
        }
    }

    /**
     * Handles incoming upload requests.
     */
    public function main()
    {
        // Get configuration record
        $this->config = $this->getUploadConfig();
        $this->processConfig();
        $this->checkUploadConfig();

        // Check for valid FE user
        if ($this->config['feuser_required']) {
            if ($this->getFeUser()->user['username'] == '') {
                throw new AuthenticationException('TYPO3 user session expired.');
            }
        }

        // One file or chunked?
        $this->chunkedUpload = (isset($_REQUEST['chunks']) && intval($_REQUEST['chunks']) > 1);

        // Check file extension
        FileValidation::checkFileExtension($this->getFileName(), $this->config['extensions']);

        // Get upload path
        $this->uploadPath = $this->getUploadDir(
            $this->config['upload_path'],
            $this->getUserDirectory(),
            $this->config['obscure_dir']
        );
        Filesystem::createFolder($this->uploadPath);

        $this->uploadFile();
    }

    /**
     * Get FE user object.
     *
     * @return \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
     */
    protected function getFeUser()
    {
        if ($this->feUserObj === null) {
            $this->feUserObj = EidUtility::initFeUser();
        }

        return $this->feUserObj;
    }

    /**
     * Get sub directory based upon user data.
     *
     * @return string
     */
    protected function getUserDirectory()
    {
        $record = $this->getFeUser()->user;
        $field = $this->config['feuser_field'];

        switch ($field) {
            case 'name':
            case 'username':
                $directory = $record[$field];
                break;

            case 'fullname':
                $parts = [$record['first_name'], $record['middle_name'], $record['last_name']];
                $directory = implode('_', array_values(array_filter($parts)));
                break;

            case 'uid':
            case 'pid':
                $directory = (string) $record[$field];
                break;

            case 'lastlogin':
                try {
                    $date = new \DateTime('@'.$record[$field]);
                    $date->setTimezone(new \DateTimeZone(date_default_timezone_get()));
                    $directory = strftime('%Y%m%d-%H', $date->format('U'));
                } catch (\Exception $exception) {
                    $directory = 'checkTimezone';
                }
                break;

            default:
                $directory = '';
        }

        return preg_replace('/[^0-9a-zA-Z\-\.]/', '_', $directory);
    }

    /**
     * Get JSON for error messages
     *
     * @param \Exception $exception
     * @return string
     */
    protected function getErrorResponseContent(\Exception $exception)
    {
        $output = [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ],
            'id' => '',
        ];

        return json_encode($output);
    }

    /**
     * Gets the plugin configuration.
     */
    protected function checkUploadConfig()
    {
        if (!count($this->config)) {
            throw new InvalidArgumentException('Configuration record not found or invalid.');
        }

        if (!strlen($this->config['extensions'])) {
            throw new InvalidArgumentException('Missing allowed file extension configuration.');
        }

        if (!Filesystem::isPathValid($this->config['upload_path'])) {
            throw new InvalidArgumentException('Upload directory not valid.');
        }
    }

    /**
     * Gets the plugin configuration.
     *
     * @return array
     */
    protected function getUploadConfig()
    {
        $configUid = intval(GeneralUtility::_GP('configUid'));

        // config id given?
        if (!$configUid) {
            throw new InvalidArgumentException('No config record ID given.');
        }

        // Init TCA for record retrieval (needed for TYPO3 8.x)
        EidUtility::initTCA();

        $select = 'upload_path, extensions, feuser_required, feuser_field, save_session, obscure_dir, check_mime';
        $table = 'tx_pluploadfe_config';
        $where = $table.'.hidden = 0';
        $where .= ' AND '.$table.'.starttime <= '.$GLOBALS['SIM_ACCESS_TIME'];
        $where .= ' AND ('.$table.'.endtime = 0 OR '.$table.'.endtime > '.$GLOBALS['SIM_ACCESS_TIME'].')';

        $config = BackendUtility::getRecord($table, $configUid, $select, $where, true);

        return $config;
    }

    /**
     * Process the configuration.
     *
     * @return void
     */
    protected function processConfig()
    {
        // Make sure FAL references work
        $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
        $this->config['upload_path'] = $resourceFactory
            ->retrieveFileOrFolderObject($this->config['upload_path'])
            ->getPublicUrl();

        // Make sure no user based path is added when there is no user available
        if (!$this->config['feuser_required']) {
            $this->config['feuser_field'] = '';
        }
    }

    /**
     * Gets the uploaded file name from request.
     *
     * @return string
     */
    protected function getFileName()
    {
        $filename = uniqid('file_');

        if (isset($_REQUEST['name'])) {
            $filename = $_REQUEST['name'];
        } elseif (!empty($_FILES)) {
            $filename = $_FILES['file']['name'];
        }

        return preg_replace('/[^\w\._]+/', '_', $filename);
    }

    /**
     * Checks and creates the upload directory.
     *
     * @param string $path
     * @param string $subDirectory
     * @param bool   $obscure
     *
     * @return string
     */
    protected function getUploadDir($path, $subDirectory = '', $obscure = false)
    {
        if ($this->chunkedUpload) {
            $chunkedPath = $this->getSessionData('chunk_path');
            if ($chunkedPath && file_exists($chunkedPath.DIRECTORY_SEPARATOR.$this->getFileName().'.part')) {
                return $chunkedPath;
            } else {
                // Reset session
                $this->saveDataInSession(null, 'chunk_path');
            }
        }

        // Make sure we have no trailing slash
        $path = GeneralUtility::dirname($path);

        // Subdirectory
        if ($subDirectory) {
            $path = $path.DIRECTORY_SEPARATOR.$subDirectory;
        }

        // Obscure directory
        if ($obscure) {
            $path = $path.DIRECTORY_SEPARATOR.Filesystem::getRandomDirName(20);
        }

        return $path;
    }

    /**
     * Handles file upload.
     *
     * Copyright 2013, Moxiecode Systems AB
     * Released under GPL License.
     *
     * License: http://www.plupload.com/license
     * Contributing: http://www.plupload.com/contributing
     */
    protected function uploadFile()
    {
        // Get additional parameters
        $chunk = isset($_REQUEST['chunk']) ? intval($_REQUEST['chunk']) : 0;
        $chunks = isset($_REQUEST['chunks']) ? intval($_REQUEST['chunks']) : 0;

        // Clean the fileName for security reasons
        $filePath = $this->uploadPath.DIRECTORY_SEPARATOR.$this->getFileName();

        // Open temp file
        if (!$out = @fopen("{$filePath}.part", $chunks ? 'ab' : 'wb')) {
            throw new InvalidArgumentException('Failed to open output stream.', 102);
        }

        if (!empty($_FILES)) {
            if ($_FILES['file']['error'] || !is_uploaded_file($_FILES['file']['tmp_name'])) {
                throw new InvalidArgumentException('Failed to move uploaded file.', 103);
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES['file']['tmp_name'], 'rb')) {
                throw new InvalidArgumentException('Failed to open input stream.', 101);
            }
        } else {
            if (!$in = @fopen('php://input', 'rb')) {
                throw new InvalidArgumentException('Failed to open input stream.', 101);
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename($filePath.'.part', $filePath);
            $this->processFile($filePath);
        }

        // save chunked upload dir
        if ($this->chunkedUpload) {
            $this->saveDataInSession($this->uploadPath, 'chunk_path');
        }
    }

    /**
     * Process uploaded file.
     *
     * @param string $filePath
     *
     * @params string $filePath
     */
    protected function processFile($filePath)
    {
        if ($this->config['check_mime']) {
            // we already checked if the file extension is allowed,
            // so we need to check if the mime type is adequate.
            // if mime type is not allowed: remove file
            if (!FileValidation::checkMimeType($filePath)) {
                @unlink($filePath);
                throw new InvalidArgumentException('File mime type is not allowed.');
            }
        }

        GeneralUtility::fixPermissions($filePath);

        if ($this->config['save_session']) {
            $this->saveFileInSession($filePath);
        }
    }

    /**
     * Store file in session.
     *
     * @param string $filePath
     * @param string $key
     */
    protected function saveFileInSession($filePath, $key = 'files')
    {
        $currentData = $this->getSessionData($key);

        if (!is_array($currentData)) {
            $currentData = [];
        }

        $currentData[] = $filePath;

        $this->saveDataInSession($currentData, $key);
    }

    /**
     * Store session data.
     *
     * @param mixed  $data
     * @param string $key
     */
    protected function saveDataInSession($data, $key = 'data')
    {
        $this->getFeUser()->setAndSaveSessionData('tx_pluploadfe_'.$key, $data);
    }

    /**
     * Get session data.
     *
     * @param string $key
     *
     * @return mixed
     */
    protected function getSessionData($key = 'data')
    {
        return $this->getFeUser()->getSessionData('tx_pluploadfe_'.$key);
    }
}
