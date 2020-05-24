<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(function ($packageKey) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'.$packageKey.'/Configuration/TSconfig/page.tsconfig">'
    );

    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('
        options.saveDocNew.tx_pluploadtest_config=1
    ');

    // Add plugin
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43(
        $packageKey,
        'Classes/Controller/Pi1Controller.php',
        '_pi1',
        'list_type',
        1
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
        'FelixNagel.Pluploadfe',
        'setup',
        'plugin.tx_pluploadfe_pi1.userFunc = FelixNagel\\Pluploadfe\\Controller\\Pi1Controller->main'
    );

    // add records to the search
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['livesearch']['pluploadfe'] = 'tx_pluploadfe_config';
}, 'pluploadfe');
