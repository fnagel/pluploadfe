<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Add static TS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'pi1/static/', 'Plupload FE: default config');


// BE
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array(
	'LLL:EXT:pluploadfe/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif'
), 'list_type');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_pluploadfe_pi1_wizicon'] =
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'pi1/class.tx_pluploadfe_pi1_wizicon.php';
}


// Add config record
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pluploadfe_config');

$GLOBALS['TCA']['tx_pluploadfe_config'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:pluploadfe/locallang_db.xml:tx_pluploadfe_config',
		'label' => 'title',
		'label_alt' => 'upload_path',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) .
			'Configuration/TCA/tx_pluploadfe_config.php',
		'typeicon_classes' => [
			'default' => 'extensions-pluploadfe-config',
		],
		'requestUpdate' => 'feuser_required',
		'searchFields' => 'title,upload_path',
	),
);

// Use old icon path for TYPO3 6.2
// @todo Remove this when 6.2 is no longer relevant
if (version_compare(TYPO3_branch, '7.0', '<')) {
	$extensionPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY);
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
}

// ADD CONFIG FIELD TO TT_CONTENT
$tempColumns = array(
	'tx_pluploadfe_config' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:pluploadfe/locallang_db.xml:tt_content.tx_pluploadfe_config',
		'config' => array(
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'tx_pluploadfe_config',
			'foreign_table' => 'tx_pluploadfe_config',
			'size' => 1,
			'minitems' => 1,
			'maxitems' => 1,
			'wizards' => array(
				'suggest' => array(
					'type' => 'suggest',
				),
			),
		),
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'tx_pluploadfe_config';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_pi1'] = 'layout,select_key,pages,recursive';
