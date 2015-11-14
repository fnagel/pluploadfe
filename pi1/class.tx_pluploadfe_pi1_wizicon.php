<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011-2014 Felix Nagel <info@felixnagel.com>
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Class that adds the wizard icon.
 *
 * @author    Felix Nagel <info@felixnagel.com>
 * @package    TYPO3
 * @subpackage    tx_pluploadfe
 */
class tx_pluploadfe_pi1_wizicon {

	/**
	 * Processing the wizard items array
	 *
	 * @param    array $wizardItems : The wizard items
	 * @return   array Modified array with wizard items
	 */
	public function proc($wizardItems) {
		$localization = $this->includeLocalLang();

		$wizardItems['plugins_tx_pluploadfe_pi1'] = array(
			'icon' => ExtensionManagementUtility::extRelPath('pluploadfe') . 'pi1/ce_wiz.gif',
			'title' => $GLOBALS['LANG']->getLLL('pi1_title', $localization),
			'description' => $GLOBALS['LANG']->getLLL('pi1_plus_wiz_description', $localization),
			'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=pluploadfe_pi1'
		);

		return $wizardItems;
	}

	/**
	 * Reads the [extDir]/locallang.xml and returns the $LOCAL_LANG array found in that file.
	 *
	 * @return   array The array with language labels
	 */
	protected function includeLocalLang() {
		$llFile = ExtensionManagementUtility::extPath('pluploadfe') . 'locallang.xml';
		$localization = GeneralUtility::readLLfile($llFile, $GLOBALS['LANG']->lang);

		return $localization;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pluploadfe/pi1/class.tx_pluploadfe_pi1_wizicon.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pluploadfe/pi1/class.tx_pluploadfe_pi1_wizicon.php']);
}
