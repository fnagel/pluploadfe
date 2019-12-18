<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

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
    ['source' => 'EXT:pluploadfe/Resources/Public/Icons/Extension.png']
);
