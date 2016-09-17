<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Change to simple input for TYPO3 7.5-7.6.10 and 8.0-8.3.1 as internal_type=folder is broken
// See https://forge.typo3.org/issues/72369
// @todo Make sure 8.3.2 includes needed fix!
if ((version_compare(TYPO3_version, '7.5.0', '>=') && version_compare(TYPO3_version, '7.6.10', '<=')) ||
	(version_compare(TYPO3_version, '8.0', '>=') && version_compare(TYPO3_version, '8.3.1', '<='))
) {
	$GLOBALS['TCA']['tx_pluploadfe_config']['columns']['upload_path']['config']['type'] = 'input';
	$GLOBALS['TCA']['tx_pluploadfe_config']['columns']['upload_path']['config']['size'] = '30';
	$GLOBALS['TCA']['tx_pluploadfe_config']['columns']['upload_path']['config']['max'] = '255';
}

// Compatibility for TYPO3 6.2
if (version_compare(TYPO3_version, '7.0', '<')) {
	$GLOBALS['TCA']['tx_pluploadfe_config']['ctrl']['dividers2tabs'] = TRUE;

	// Use old localization path
	$path = 'frontend/Resources/Private/Language';
	$GLOBALS['TCA']['tx_pluploadfe_config']['types']['0']['showitem'] =
		str_replace($path, 'cms', $GLOBALS['TCA']['tx_pluploadfe_config']['types']['0']['showitem']);
	$GLOBALS['TCA']['tx_pluploadfe_config']['palettes']['access']['showitem'] =
		str_replace($path, 'cms', $GLOBALS['TCA']['tx_pluploadfe_config']['palettes']['access']['showitem']);
}
