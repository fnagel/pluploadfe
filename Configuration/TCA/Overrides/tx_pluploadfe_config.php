<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// Change to simple input for TYPO3 8.0-8.3 as internal_type=folder is broken
// See https://forge.typo3.org/issues/72369
if (version_compare(TYPO3_version, '8.0', '>=') &&
    version_compare(TYPO3_version, '8.3', '<=')
) {
    $GLOBALS['TCA']['tx_pluploadfe_config']['columns']['upload_path']['config']['type'] = 'input';
    $GLOBALS['TCA']['tx_pluploadfe_config']['columns']['upload_path']['config']['size'] = '30';
    $GLOBALS['TCA']['tx_pluploadfe_config']['columns']['upload_path']['config']['max'] = '255';
}

// Compatibility for TYPO3 < 8.5
if (version_compare(TYPO3_version, '8.5', '<')) {
    // Use old localization path
    $GLOBALS['TCA']['tx_pluploadfe_config']['columns']['hidden']['label'] = str_replace(
        'Resources/Private/Language/locallang_general.xlf:LGL.disable',
        'locallang_general.xml:LGL.hidden',
        $GLOBALS['TCA']['tx_pluploadfe_config']['columns']['hidden']['label']
    );
}
