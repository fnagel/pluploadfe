<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Change to simple input for buggy TYPO3 versions
// see https://forge.typo3.org/issues/72369
if (version_compare(TYPO3_version, '7.5.0', '>=')) {
	$GLOBALS['TCA']['tx_pluploadfe_config']['columns']['upload_path']['config']['type'] = 'input';
	$GLOBALS['TCA']['tx_pluploadfe_config']['columns']['upload_path']['config']['size'] = '30';
	$GLOBALS['TCA']['tx_pluploadfe_config']['columns']['upload_path']['config']['max'] = '255';
}
