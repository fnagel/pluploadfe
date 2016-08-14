<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Add static TS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY, 'Configuration/TypoScript/', 'Plupload FE: default config'
);

// Add page TS config
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/TypoScript/pageTsConfig.ts">'
);

// Add plugin
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array(
	'LLL:EXT:pluploadfe/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif'
), 'list_type');

// Add config record
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pluploadfe_config');


// Use old icon path for TYPO3 6.2
// @todo Remove this when 6.2 is no longer relevant
if (version_compare(TYPO3_branch, '7.0', '<')) {
	$extensionPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY);
	\TYPO3\CMS\Backend\Sprite\SpriteManager::addSingleIcons(array(
		'wizard' => $extensionPath . 'pi1/ce_wiz.gif',
	), 'pluploadfe');
	\TYPO3\CMS\Backend\Sprite\SpriteManager::addSingleIcons(array(
		'config' => $extensionPath . 'icon_tx_pluploadfe_config.gif',
	), 'pluploadfe');
} else {
	/* @var $iconRegistry \TYPO3\CMS\Core\Imaging\IconRegistry */
	$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
	$iconRegistry->registerIcon(
		'extensions-pluploadfe-config',
		\TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
		['source' => 'EXT:pluploadfe/icon_tx_pluploadfe_config.gif']
	);
    $iconRegistry->registerIcon(
		'extensions-pluploadfe-wizard',
		\TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
		['source' => 'EXT:pluploadfe/pi1/ce_wiz.gif']
	);
}

