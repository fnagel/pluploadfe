<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// Add static TS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY, 'Configuration/TypoScript/', 'Plupload FE: default config'
);

// Add page TS config
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'.$_EXTKEY.'/Configuration/TypoScript/pageTsConfig.ts">'
);

// Add plugin
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
    'FelixNagel.Pluploadfe',
    'setup',
    'plugin.tx_pluploadfe_pi1.userFunc = FelixNagel\\Pluploadfe\\Controller\\Pi1Controller->main'
);

// Add config record
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pluploadfe_config');

// Add icons
/* @var $iconRegistry \TYPO3\CMS\Core\Imaging\IconRegistry */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'extensions-pluploadfe-config',
    \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
    ['source' => 'EXT:pluploadfe/Resources/Public/Icons/icon_tx_pluploadfe_config.gif']
);
$iconRegistry->registerIcon(
    'extensions-pluploadfe-wizard',
    \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
    ['source' => 'EXT:pluploadfe/Resources/Public/Icons/plugin.png']
);
