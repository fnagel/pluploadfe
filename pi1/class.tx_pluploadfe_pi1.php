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

require_once(PATH_tslib.'class.tslib_pibase.php');

/**
 * Plugin 'pluploadfe' for the 'pluploadfe' extension.
 *
 * @author	Felix Nagel <info@felixnagel.com>
 * @package	TYPO3
 * @subpackage	tx_pluploadfe
 */
class tx_pluploadfe_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_pluploadfe_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_pluploadfe_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'pluploadfe';	// The extension key.
	var $pi_checkCHash = true;

	/**
	 * The main method of the PlugIn
	 *
	 * @param string	$content: The plugin content
	 * @param array		$conf: The plugin configuration
	 * @return string	The content that is displayed on the website
	 */
	public function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$content = '';

		// set (localized) UID
		if (strlen($this->conf['uid']) > 0) {
			$this->uid = $this->conf['uid'];
		} else {
			$this->uid = ($this->cObj->data['_LOCALIZED_UID']) ? intval($this->cObj->data['_LOCALIZED_UID']) : intval($this->cObj->data['uid']);
		}

		// set config record uid
		if (strlen($this->conf['configUid']) > 0) {
			$this->configUid = $this->conf['configUid'];
		} else {
			$this->configUid = intval($this->cObj->data['tx_pluploadfe_config']);
		}

		$this->getUploadConfig();
		$this->getTemplateFile();

		if ($this->checkConfig()) {
			$this->renderFiles();
			$this->renderCode();
			$content = $this->getHTML();
		} else {
			$content = '<div style="border: 3px solid red; padding: 1em;"><strong>TYPO3 EXT:plupload Error</strong><br />Invalid configuration.</div>';
		}

		return $this->pi_wrapInBaseClass($content);
	}


	/**
	 * Checks config
	 *
	 * @return void
	 */
	protected function getUploadConfig() {
		$config = array();
		$select = 'extensions';
		$table = 'tx_pluploadfe_config';
		$where = 'uid = '. $this->configUid;
		$where  .= $GLOBALS['TSFE']->sys_page->enableFields($table);
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select, $table, $where, '', '', '');

		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			if (is_array($row)) {
				$this->config = $row;
			}
		}

		$GLOBALS['TYPO3_DB']->sql_free_result($res);
	}


	/**
	 * Checks config
	 *
	 * @return void
	 */
	protected function checkConfig() {
		$flag = false;

		if (strlen($this->uid) > 0 &&
			strlen($this->templateHtml) > 0 &&
			intval($this->configUid) > 0 &&
			is_array($this->config) &&
			strlen($this->config['extensions']) > 0
		) {
			$flag = true;
		} else {
			$this->handleError('Invalid configuration');
		}

		return $flag;
	}

	/**
	 * Function to parse the template
	 *
	 * @return void
	 */
	protected function renderFiles() {
		$template_files = $this->cObj->getSubpart($this->templateHtml, '###TEMPLATE_FILES###');
		$subpartArray = $this->getDefaultMarker();

		// TODO wont work
		// $GLOBALS['TSFE']->getPageRenderer()->addHeaderData($this->cObj->substituteMarkerArrayCached($template_files, $subpartArray));
		$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId] .= $this->cObj->substituteMarkerArrayCached($template_files, $subpartArray);
	}

	/**
	 * Function to parse the template
	 *
	 * @return void
	 */
	protected function renderCode() {
		// Extract subparts from the template
		$templateMain = $this->cObj->getSubpart($this->templateHtml, '###TEMPLATE_CODE###');

		// fill marker array
		$markerArray = $this->getDefaultMarker();
		$markerArray['###UPLOAD_FILE###'] = t3lib_div::getIndpEnv('TYPO3_SITE_URL') . 'index.php?eID=pluploadfe&configUid=' . $this->configUid;

		// replace markers in the template
		$content = $this->cObj->substituteMarkerArray($templateMain, $markerArray);

		// TODO wont work
		// $GLOBALS['TSFE']->getPageRenderer()->addJsInlineCode($this->prefixId . '_' . $this->uid, $content);
		$GLOBALS['TSFE']->setJS($this->prefixId . '_' . $this->uid, $content);
	}

	/**
	 * Function to parse the template
	 *
	 * @return void
	 */
	protected function getHTML() {
		// Extract subparts from the template
		$templateMain = $this->cObj->getSubpart($this->templateHtml, '###TEMPLATE_CONTENT###');

		// fill marker array
		$markerArray = $this->getDefaultMarker();
		$markerArray['###INFO_1###'] = $this->pi_getLL('info_1');
		$markerArray['###INFO_2###'] = $this->pi_getLL('info_2');

		// replace markers in the template
		$content = $this->cObj->substituteMarkerArray($templateMain, $markerArray);

		return $content;
	}

	/**
	 * Function to render the default marker
	 *
	 * @return void
	 */
	protected function getDefaultMarker() {
		$markerArray = array();
		$extensionsArray = t3lib_div::trimExplode(',', $this->config['extensions'], true);

		$markerArray['###UID###'] = $this->uid;
		$markerArray['###LANGUAGE###'] = $GLOBALS['TSFE']->config['config']['language'];
		$markerArray['###EXTDIR_PATH###'] = t3lib_extMgm::siteRelPath($this->extKey);
		$markerArray['###FILE_EXTENSIONS###'] = implode(',', $extensionsArray);

		return $markerArray;
	}

	/**
	 * Function to fetch the template file
	 *
	 * @return void
	 */
	protected function getTemplateFile() {
		$templateFile = (strlen(trim($this->conf['templateFile']))>0) ? trim($this->conf['templateFile']) : 'EXT:pluploadfe/res/template.html';

		// Get the template
		$this->templateHtml = $this->cObj->fileResource($templateFile);

		if (!$this->templateHtml) {
			$this->handleError('Error while fetching the template file: ' . $templateFile);
		}
	}

	/**
	 * Handles error output for frontend and TYPO3 logging
	 *
	 * @param	string	Message to output
	 * @return	void
	 * @see	t3lib::devLog()
	 * @see	t3lib_div::sysLog()
	 */
	protected function handleError($msg) {
		t3lib_div::sysLog($msg, $this->extKey, 3); // error

		// write dev log if enabled
		if ($GLOBALS['TYPO3_CONF_VARS']['SYS']['enable_DLOG']) {
			t3lib_div::devLog($msg, $this->extKey, 3); // fatal error
		}
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pluploadfe/pi1/class.tx_pluploadfe_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pluploadfe/pi1/class.tx_pluploadfe_pi1.php']);
}

?>