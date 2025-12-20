<?php

use FelixNagel\Pluploadfe\Controller\Pi1Controller;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

call_user_func(static function () {
    // Add plugin
    ExtensionManagementUtility::addTypoScript(
        'FelixNagel.Pluploadfe',
        'setup',
        'plugin.tx_pluploadfe_pi1 = USER
        plugin.tx_pluploadfe_pi1.userFunc = '. Pi1Controller::class.'->main'
    );

    // Add records to the search
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['livesearch']['pluploadfe'] = 'tx_pluploadfe_config';
});
