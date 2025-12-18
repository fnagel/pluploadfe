<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die('Access denied.');

call_user_func(static function ($packageKey) {
    $extensionName = GeneralUtility::underscoredToLowerCamelCase($packageKey);
    $pluginSignature = strtolower($extensionName).'_pi1';

    // Add plugin
    ExtensionManagementUtility::addPlugin([
        'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:pi1_title',
        'description' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:pi1_plus_wiz_description',
        'value' => $packageKey.'_pi1',
        'icon' => 'extensions-pluploadfe-wizard',
        'group' => 'plugins',
    ]);

    // Add column
    $tempColumns = [
        'tx_pluploadfe_config' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tt_content.tx_pluploadfe_config',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_pluploadfe_config',
                'foreign_table' => 'tx_pluploadfe_config',
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                    ],
                ],
            ],
        ],
    ];

    ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns);
    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        'tx_pluploadfe_config,',
        $pluginSignature,
        'after:header',
    );
}, 'pluploadfe');
