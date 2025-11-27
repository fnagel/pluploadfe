<?php

use FelixNagel\Pluploadfe\Controller\Pi1Controller;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') || die();

call_user_func(static function () {
    $versionInformation = GeneralUtility::makeInstance(Typo3Version::class);

    // @todo Remove this when TYPO3 12 is no longer relevant!
    // Only include user.tsconfig if TYPO3 version is below 13 so that it is not imported twice.
    if ($versionInformation->getMajorVersion() < 13) {
        // @extensionScannerIgnoreLine
        ExtensionManagementUtility::addUserTSConfig(
            '@import "EXT:pluploadfe/Configuration/user.tsconfig"',
        );
    }

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
