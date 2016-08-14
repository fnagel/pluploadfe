<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

call_user_func(function ($packageKey) {
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('
        options.saveDocNew.tx_pluploadtest_config=1
    ');

    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43(
        $packageKey, 'Classes/class.tx_pluploadfe_pi1.php', '_pi1', 'list_type', 1
    );

    $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include'][$packageKey] =
        'EXT:' . $packageKey . '/Classes/class.tx_pluploadfe_upload.php';

    // add records to the search
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['livesearch']['pluploadfe'] = 'tx_pluploadfe_config';

}, $_EXTKEY);