<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011-2013 Felix Nagel <info@felixnagel.com>
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

if (!defined ('PATH_typo3conf')) die ();

require_once(PATH_tslib . 'class.tslib_eidtools.php');

/**
 * This class uploads files
 *
 * @todo translate error messages
 * @author	Felix Nagel <info@felixnagel.com>
 * @package	TYPO3
 * @subpackage	tx_plupload
 */
class tx_pluploadfe_upload {

    private $imageTypes = array(
		'gif',
		'jpeg',
		'jpg',
		'png',
		'swf',
		'psd',
		'bmp',
		'tiff',
		'tif',
		'jpc',
		'jp2',
		'jpx',
		'jb2',
		'swc',
		'iff',
		'wbmp',
		'xbm',
		'ico'
	);

	private $mimeTypes = array (
		'3dmf'		=> array( 'x-world/x-3dmf' ),
		'3dm'		=> array( 'x-world/x-3dmf' ),
		'7z'		=> array( 'application/x-7z-compressed', 'application/zip' ),
		'avi'		=> array( 'video/x-msvideo' ),
		'ai'		=> array( 'application/postscript' ),
		'bin'		=> array( 'application/octet-stream', 'application/x-macbinary' ),
		'bmp'		=> array( 'image/bmp' ),
		'cab'		=> array( 'application/x-shockwave-flash' ),
		'c'			=> array( 'text/plain' ),
		'c++'		=> array( 'text/plain' ),
		'class'		=> array( 'application/java' ),
		'css'		=> array( 'text/css' ),
		'csv'		=> array( 'text/comma-separated-values' ),
		'cdr'		=> array( 'application/cdr' ),
		'doc'		=> array( 'application/msword' ),
		'dot'		=> array( 'application/msword' ),
		'docx'		=> array( 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ),
		'dotx'		=> array( 'application/vnd.openxmlformats-officedocument.wordprocessingml.template' ),
		'dwg'		=> array( 'application/acad' ),
		'eps'		=> array( 'application/postscript' ),
		'exe'		=> array( 'application/octet-stream' ),
		'gif'		=> array( 'image/gif' ),
		'gz'		=> array( 'application/gzip' ),
		'gtar'		=> array( 'application/x-gtar' ),
		'f4v'		=> array( 'video/mp4' ),
		'flv'		=> array( 'video/x-flv' ),
		'fh4'		=> array( 'image/x-freehand' ),
		'fh5'		=> array( 'image/x-freehand' ),
		'fhc'		=> array( 'image/x-freehand' ),
		'help'		=> array( 'application/x-helpfile' ),
		'hlp'		=> array( 'application/x-helpfile' ),
		'html'		=> array( 'text/html' ),
		'htm'		=> array( 'text/html' ),
		'ico'		=> array( 'image/x-icon' ),
		'imap'		=> array( 'application/x-httpd-imap' ),
		'inf'		=> array( 'application/inf' ),
		'jpe'		=> array( 'image/jpeg' ),
		'jpeg'		=> array( 'image/jpeg' ),
		'jpg'		=> array( 'image/jpeg' ),
		'js'		=> array( 'application/x-javascript' ),
		'java'		=> array( 'text/x-java-source' ),
		'latex'		=> array( 'application/x-latex' ),
		'log'		=> array( 'text/plain' ),
		'm3u'		=> array( 'audio/x-mpequrl' ),
		'midi'		=> array( 'audio/midi' ),
		'mid'		=> array( 'audio/midi' ),
		'mov'		=> array( 'video/quicktime' ),
		'mp3'		=> array( 'audio/mpeg' ),
		'm4v'		=> array( 'video/mp4' ),
		'mp4'		=> array( 'video/mp4', 'audio/mp4', 'audio/m4a' ),
		'mpeg'		=> array( 'video/mpeg' ),
		'mpg'		=> array( 'video/mpeg' ),
		'mp2'		=> array( 'video/mpeg' ),
		'ogg'		=> array( 'video/ogg', 'application/ogg', 'audio/ogg' ),
		'ogm'		=> array( 'video/ogg' ),
		'ogv'		=> array( 'video/ogg' ),
		'odt'		=> array( 'application/vnd.oasis.opendocument.text', 'application/x-vnd.oasis.opendocument.text' ),
		'odp'		=> array( 'application/vnd.oasis.opendocument.presentation' ),
		'ods'		=> array( 'application/vnd.oasis.opendocument.spreadsheet' ),
		'phtml'		=> array( 'application/x-httpd-php' ),
		'php'		=> array( 'application/x-httpd-php' ),
		'pdf'		=> array( 'application/pdf' ),
		'pgp'		=> array( 'application/pgp' ),
		'png'		=> array( 'image/png' ),
		'pps'		=> array( 'application/mspowerpoint', 'application/vnd.ms-powerpoint' ),
		'ppt'		=> array( 'application/mspowerpoint', 'application/vnd.ms-powerpoint' ),
		'pptx'		=> array( 'application/vnd.openxmlformats-officedocument.presentationml.presentation' ),
		'ppz'		=> array( 'application/mspowerpoint' ),
		'pot'		=> array( 'application/mspowerpoint' ),
		'ps'		=> array( 'application/postscript' ),
		'qt'		=> array( 'video/quicktime' ),
		'qd3d'		=> array( 'x-world/x-3dmf' ),
		'qd3'		=> array( 'x-world/x-3dmf' ),
		'qxd'		=> array( 'application/x-quark-express' ),
		'rar'		=> array( 'application/x-rar-compressed' ),
		'ra'		=> array( 'audio/x-realaudio' ),
		'ram'		=> array( 'audio/x-pn-realaudio' ),
		'rm'		=> array( 'audio/x-pn-realaudio' ),
		'rtf'		=> array( 'text/rtf' ),
		'spr'		=> array( 'application/x-sprite' ),
		'sprite'	=> array( 'application/x-sprite' ),
		'stream'	=> array( 'audio/x-qt-stream' ),
		'swf'		=> array( 'application/x-shockwave-flash' ),
		'svg'		=> array( 'text/xml-svg' ),
		'sgml'		=> array( 'text/x-sgml' ),
		'sgm'		=> array( 'text/x-sgml' ),
		'tar'		=> array( 'application/x-tar' ),
		'tiff'		=> array( 'image/tiff' ),
		'tif'		=> array( 'image/tiff' ),
		'tgz'		=> array( 'application/x-compressed' ),
		'tex'		=> array( 'application/x-tex' ),
		'txt'		=> array( 'text/plain' ),
		'vob'		=> array( 'video/x-mpg' ),
		'wav'		=> array( 'audio/x-wav' ),
		'webm'		=> array( 'video/webm' ),
		'wrl'		=> array( 'model/vrml', 'x-world/x-vrml' ),
		'xla'		=> array( 'application/msexcel', 'application/vnd.ms-excel' ),
		'xlt'		=> array( 'application/msexcel', 'application/vnd.ms-excel' ),
		'xls'		=> array( 'application/msexcel', 'application/vnd.ms-excel' ),
		'xlsx'		=> array( 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ),
		'xltx'		=> array( 'application/vnd.openxmlformats-officedocument.spreadsheetml.template' ),
		'xlc'		=> array( 'application/vnd.ms-excel' ),
		'xml'		=> array( 'text/xml' ),
		'zip'		=> array( 'application/x-zip-compressed', 'application/x-zip', 'application/zip' ),
	);

	/**
	 * Handles incoming upload requests
	 *
	 * @return	void
	 */
	public function main() {
		// HTTP headers for no cache etc
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');

		$this->config = $this->getUploadConfig();
		if (!count($this->config)) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Configuration record not found or invalid."}, "id" : ""}');
		}

		// check file extension
		$this->checkFileExtension();

		// check, create and set upload path
		$this->upload_path = $this->getUploadDir($this->config['upload_path'], $this->config['obscure_dir']);

		// init fe user if needed
		if ($this->config['feuser_required'] || $this->config['save_session']) {
			$this->feUserObj = tslib_eidtools::initFeUser();
		}

		// check for valid FE user
		if ($this->config['feuser_required']) {
			if ($this->feUserObj->user['username'] == '') {
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "TYPO3 user session expired."}, "id" : ""}');
			}
		}

		$this->uploadFile();
	}

	/**
	 * Gets the plugin configuration
	 *
	 * @return array
	 */
	protected function getUploadConfig() {
		$configUid = intval(t3lib_div::_GP('configUid'));

		// config id given?
		if (!$configUid) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "No config record ID given."}, "id" : ""}');
		}

		tslib_eidtools::connectDB();

		$config = array();
		$select = 'upload_path, extensions, feuser_required, save_session, obscure_dir, check_mime';
		$table = 'tx_pluploadfe_config';
		$where = 'uid = '. $configUid;
		$where .= ' AND deleted = 0';
		$where .= ' AND hidden = 0';
		$where .= ' AND starttime <= ' . $GLOBALS['SIM_ACCESS_TIME'];
		$where .= ' AND ( endtime = 0 OR endtime > ' . $GLOBALS['SIM_ACCESS_TIME'] . ')';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select, $table, $where, '', '', '');

		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			if (is_array($row)) {
				$config = $row;
			}
		}

		$GLOBALS['TYPO3_DB']->sql_free_result($res);

		return $config;
	}

	/**
	 * Checks file extension
	 * Script ends here when bad filename is given
	 *
	 * @todo Check for extension via config file
	 *
	 * @return void
	 */
	protected function checkFileExtension() {
		if (!strlen($this->config['extensions'])) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Missing allowed file extension configuration."}, "id" : ""}');
		}

		$fileName = $this->getFileName();
		$this->fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
		$extensions = t3lib_div::trimExplode(",", $this->config['extensions'], true);

		// check if file extension is allowed (configuration record)
		if (in_array($this->fileExtension, $extensions)) {
			// check if file extension is allowed on this TYPO3 installation
			if (!t3lib_div::verifyFilenameAgainstDenyPattern($fileName)) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "File extension is not allowed on this TYPO3 installation."}, "id" : ""}');
			}
		} else {
			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "File extension is not allowed."}, "id" : ""}');
		}
	}

	/**
	 * Gets the uploaded file name from request
	 *
	 * @return string
	 */
	protected function getFileName() {
		if (isset($_REQUEST["name"])) {
			return $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			return $_FILES["file"]["name"];
		} else {
			return uniqid("file_");
		}
	}

	/**
	 * Checks and creates the upload directory
	 *
	 * @params string $path
	 * @params boolean $obscure
	 *
	 * @return string
	 */
	protected function getUploadDir($path, $obscure = false) {
		// check if path is allowed and valid
		if (strlen($path) > 0 && t3lib_div::isAllowedAbsPath(PATH_site . $path) && t3lib_div::validPathStr($path)) {
			// make sure we have no trailing slash
			$path = t3lib_div::dirname($path);

			// obscure directory
			if ($obscure) {
				$path = $path . DIRECTORY_SEPARATOR . $this->getRandomDirName(20);
			}

			// check if upload path exists
			if (!file_exists($path)) {
				// create target dir
				if (t3lib_div::mkdir_deep(PATH_site, $path)) {
					// mkdir_deep: If error, returns error string.
					die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to create upload directory."}, "id" : ""}');
				}
			}
		} else {
			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Upload directory not valid."}, "id" : ""}');
		}

		return $path;
	}

	/**
	 * Handles file upload
	 *
	 * Copyright 2013, Moxiecode Systems AB
	 * Released under GPL License.
	 *
	 * License: http://www.plupload.com/license
	 * Contributing: http://www.plupload.com/contributing
	 *
	 * @return void
	 */
	protected function uploadFile() {
		// Get additional parameters
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._]+/', '_', $this->getFileName());
		$filePath = $this->upload_path . DIRECTORY_SEPARATOR . $fileName;

		// Open temp file
		if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
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
			rename("{$filePath}.part", $filePath);
			$this->processFile($filePath);
		}

		// Return JSON-RPC response if upload process is successfully finished
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}

	/**
	 * Process uploaded file
	 *
	 * @params string $filepath
	 *
	 * @return void
	 */
	protected function processFile($filepath) {
		if ($this->config['check_mime']) {
			// if mime type is not allowed: remove file
			if (!$this->checkMimeType($this->fileExtension, $filepath)) {
				@unlink($filepath);
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "File mime type is not allowed."}, "id" : ""}');
			}
		}

		t3lib_div::fixPermissions($filepath);
		if ($this->config['save_session'] && $this->feUserObj) {
			$this->updateSession($filepath);
		}
	}

	/**
	 * Store session data
	 *
	 * @params string $filepath
	 * @params string $key
	 *
	 * @return void
	 */
	protected function updateSession($filepath, $key = 'tx_pluploadfe_files') {
		$currentData = $this->feUserObj->getKey('ses', $key);

		if (!is_array($currentData)) {
			$currentData = array();
		}

		$currentData[] = t3lib_div::getIndpEnv('TYPO3_SITE_URL') . $filepath;

		$this->feUserObj->setKey('ses', $key, $currentData);
		$this->feUserObj->storeSessionData();
	}

	/**
	 * Generate random string
	 *
	 * @params integer $length

	 * @return string
	 */
	protected function getRandomDirName($length = 10) {
		$set = "abcdefghijklmnopqrstuvwxyzABCDEFGHIKLMNPQRSTUVWXYZ0123456789";
		$string = "";

		for ($i = 1; $i <= $length; $i++) {
			$string .= $set[mt_rand(0, (strlen($set) -1 ))];
		}

		return $string;
	}

	/**
	 * Retrieves MIME type from given file
	 *
	 * @todo Make EM check for mime type getters
	 *
	 * @params string $filepath
	 *
	 * @return void
	 */
	protected function getMimeType($filepath) {
		// set default which is totally insecure
		$mimeType = $_FILES['file']['type'];

		if (function_exists('finfo_open')) {
            $finfo = @finfo_open(FILEINFO_MIME);
			if ($finfo) {
				if ($tempMime = @finfo_file($finfo, $filepath)) {
					$mimeType = $tempMime;
				}
				finfo_close($finfo);
			}
		} elseif (function_exists('mime_content_type')) {
			$mimeType = mime_content_type($filepath);
			die($mimeType);
        } elseif (function_exists('exec') && function_exists('escapeshellarg')) {
            if ($tempMime = trim(@exec('file -bi ' . @escapeshellarg($filepath)))) {
                $mimeType = $tempMime;
            }
        } elseif (function_exists('pathinfo')){
            if ($pathinfo = @pathinfo($filepath)) {
                if (in_array($pathinfo['extension'], $this->imageTypes) && getimagesize($file)){
                    $size = getimagesize($filepath);
                    $mimeType = $size['mime'];
                }
			}
		}

		return $mimeType;
	}

	/**
	 * checks mime type
	 * we alredy checked if the file extension is allowed,
	 * so we need to check if the mime type is adequate
	 *
	 * @params string $sentExt
	 * @params string $filepath
	 *
	 * @return boolean
	 */
	protected function checkMimeType($sentExt, $filepath) {
		$flag = false;

		if (array_key_exists($sentExt, $this->mimeTypes)) {
			$mimeType = explode(";", $this->getMimeType($filepath));
			// check if mime type fits the given file extension
			if (in_array($mimeType[0], $this->mimeTypes[$sentExt])) {
				$flag = true;
			}
		} else {
			// fallback for unusual file types
			$flag = true;
		}

		return $flag;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pluploadfe/lib/class.tx_plupload_upload.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pluploadfe/lib/class.tx_plupload_upload.php']);
}

if (!(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_FE)) {
	die ();
} else {
	$upload = t3lib_div::makeInstance('tx_pluploadfe_upload');
	$upload->main();
}

?>