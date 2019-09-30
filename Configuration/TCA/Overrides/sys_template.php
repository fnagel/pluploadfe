<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(function ($packageKey) {
    // Add static TS
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $packageKey,
        'Configuration/TypoScript/',
        'Plupload FE: default config'
    );
}, 'pluploadfe');
