<?php

defined('TYPO3') || die('Access denied.');

call_user_func(function ($packageKey) {
    // Add static TS
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $packageKey,
        'Configuration/TypoScript/',
        'Plupload FE: default config'
    );
}, 'pluploadfe');
