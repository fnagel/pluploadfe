<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;

defined('TYPO3') || die();

// Add config record
ExtensionManagementUtility::allowTableOnStandardPages('tx_pluploadfe_config');

// Add icons
/* @var $iconRegistry \TYPO3\CMS\Core\Imaging\IconRegistry */
$iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
$iconRegistry->registerIcon(
    'extensions-pluploadfe-config',
    BitmapIconProvider::class,
    ['source' => 'EXT:pluploadfe/Resources/Public/Icons/icon_tx_pluploadfe_config.gif']
);
$iconRegistry->registerIcon(
    'extensions-pluploadfe-wizard',
    BitmapIconProvider::class,
    ['source' => 'EXT:pluploadfe/Resources/Public/Icons/Extension.png']
);
