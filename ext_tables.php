<?php

defined('TYPO3') || die();

// Add config record
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pluploadfe_config');

// Add icons
/* @var $iconRegistry \TYPO3\CMS\Core\Imaging\IconRegistry */
$iconRegistry = TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'extensions-pluploadfe-config',
    TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
    ['source' => 'EXT:pluploadfe/Resources/Public/Icons/icon_tx_pluploadfe_config.gif']
);
$iconRegistry->registerIcon(
    'extensions-pluploadfe-wizard',
    TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
    ['source' => 'EXT:pluploadfe/Resources/Public/Icons/Extension.png']
);
