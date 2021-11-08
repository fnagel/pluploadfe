<?php

namespace FelixNagel\Pluploadfe\Middleware;

/**
 * This file is part of the "pluploadfe" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use FelixNagel\Pluploadfe\Exception\AuthenticationException;
use FelixNagel\Pluploadfe\Exception\InvalidArgumentException;
use FelixNagel\Pluploadfe\Utility\Filesystem;
use FelixNagel\Pluploadfe\Utility\FileValidation;

/**
 * This class uploads files.
 *
 * @todo translate error messages
 */
class Upload implements MiddlewareInterface
{
    private bool $chunkedUpload = false;

    /**
     * @var \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
     */
    private $feUserObj = null;

    private array $config = [];

    private string $uploadPath = '';

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $configUid = $request->getParsedBody()['tx_pluploadfe'] ?? $request->getQueryParams()['tx_pluploadfe'] ?? null;

        if ($configUid === null) {
            return $handler->handle($request);
        }

        // @todo TSFE->fe_user is a fallback for TYPO3 9.x
        $this->feUserObj = $request->getAttribute('frontend.user', $GLOBALS['TSFE']->fe_user);
        $this->config = $this->getUploadConfig((int) $configUid);

        $response = new JsonResponse([], 200, [
            'Expires' => 'Mon, 26 Jul 1997 05:00:00 GMT',
            'Last-Modified' => gmdate('D, d M Y H:i:s').' GMT',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
        ]);

        try {
            $this->handleUpload();
            // Return JSON-RPC response if upload process is successfully finished
            $response->setPayload([
                'jsonrpc' => '2.0',
                'result' => null,
                'id' => 'id',
            ]);
            return $response;
        } catch (AuthenticationException $exception) {
            $response->setPayload($this->getErrorResponseContent($exception));
            return $response->withStatus(403);
        } catch (InvalidArgumentException $exception) {
            $response->setPayload($this->getErrorResponseContent($exception));
            return $response->withStatus(410);
        } catch (\Exception $exception) {
            $response->setPayload($this->getErrorResponseContent($exception));
            return $response->withStatus(404);
        }
    }

    /**
     * Handles incoming upload requests.
     */
    public function handleUpload()
    {
        $this->processConfig();
        $this->checkUploadConfig();

        // Check for valid FE user
        if ($this->config['feuser_required'] && $this->getFeUser()->user['username'] == '') {
            throw new AuthenticationException('TYPO3 user session expired.');
        }

        // One file or chunked?
        $this->chunkedUpload = (isset($_REQUEST['chunks']) && (int) $_REQUEST['chunks'] > 1);

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

        return preg_replace('#[^0-9a-zA-Z\-\.]#', '_', $directory);
    }

    /**
     * Get JSON for error messages
     *
     * @return array
     */
    protected function getErrorResponseContent(\Exception $exception)
    {
        return [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ],
            'id' => '',
        ];
    }

    /**
     * Gets the plugin configuration.
     */
    protected function checkUploadConfig()
    {
        if (count($this->config) === 0) {
            throw new InvalidArgumentException('Configuration record not found or invalid.');
        }

        if ((string) $this->config['extensions'] === '') {
            throw new InvalidArgumentException('Missing allowed file extension configuration.');
        }

        if (!Filesystem::isPathValid($this->config['upload_path'])) {
            throw new InvalidArgumentException('Upload directory not valid.');
        }
    }

    /**
     * Gets the plugin configuration.
     *
     * @param int $configUid
     *
     * @return array
     */
    protected function getUploadConfig($configUid)
    {
    	$context = GeneralUtility::makeInstance(Context::class);
        $select = 'upload_path, extensions, feuser_required, feuser_field, save_session, obscure_dir, check_mime';
        $table = 'tx_pluploadfe_config';
        $where = $table.'.hidden = 0';
        $where .= ' AND '.$table.'.starttime <= '.$context->getPropertyFromAspect('date', 'timestamp');
        $where .= ' AND ('.$table.'.endtime = 0 OR '.$table.'.endtime > '.$context->getPropertyFromAspect('date', 'timestamp').')';

        return BackendUtility::getRecord($table, (int) $configUid, $select, $where, true);
    }

    /**
     * Process the configuration.
     *
     * @return void
     */
    protected function processConfig()
    {
        // Make sure FAL references work
        $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
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

        return preg_replace('#[^\w\._]+#', '_', $filename);
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
        if ($subDirectory !== '') {
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
        $chunk = isset($_REQUEST['chunk']) ? (int) $_REQUEST['chunk'] : 0;
        $chunks = isset($_REQUEST['chunks']) ? (int) $_REQUEST['chunks'] : 0;

        // Clean the fileName for security reasons
        $filePath = $this->uploadPath.DIRECTORY_SEPARATOR.$this->getFileName();

        // Open temp file
        if (!$out = @fopen(sprintf('%s.part', $filePath), $chunks !== 0 ? 'ab' : 'wb')) {
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
        } elseif (!$in = @fopen('php://input', 'rb')) {
            throw new InvalidArgumentException('Failed to open input stream.', 101);
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
