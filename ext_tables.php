<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;

defined('TYPO3') || die();

// Add icons
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
