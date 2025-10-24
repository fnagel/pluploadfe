<?php

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') || die();

call_user_func(static function ($packageKey) {
    $versionInformation = GeneralUtility::makeInstance(Typo3Version::class);
    // Only include user.tsconfig if TYPO3 version is below 13 so that it is not imported twice.
    if ($versionInformation->getMajorVersion() < 13) {
        ExtensionManagementUtility::addUserTSConfig(
            '@import "EXT:pluploadfe/Configuration/user.tsconfig"',
        );
    }

    // Add plugin
    ExtensionManagementUtility::addPItoST43(
        $packageKey,
        'Classes/Controller/Pi1Controller.php',
        '_pi1',
        'list_type',
        1
    );
    ExtensionManagementUtility::addTypoScript(
        'FelixNagel.Pluploadfe',
        'setup',
        'plugin.tx_pluploadfe_pi1.userFunc = FelixNagel\\Pluploadfe\\Controller\\Pi1Controller->main'
    );

    // Add records to the search
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['livesearch']['pluploadfe'] = 'tx_pluploadfe_config';
}, 'pluploadfe');
