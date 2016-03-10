<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_pluploadfe_config'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_pluploadfe_config']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,starttime,endtime,fe_group,upload_path,feuser_required'
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
				'default' => '0'
			)
		),
		'starttime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date',
				'default' => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => '8',
				'max' => '20',
				'eval' => 'date',
				'checkbox' => '0',
				'default' => '0',
				'range' => array(
					'upper' => mktime(3, 14, 7, 1, 19, 2038),
					'lower' => mktime(0, 0, 0, date('m') - 1, date('d'), date('Y'))
				)
			)
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.title',
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'max' => '255',
				'checkbox' => '',
				'eval' => 'trim',
			)
		),
		'upload_path' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pluploadfe/locallang_db.xml:tx_pluploadfe_config.upload_path',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'folder',
				'size' => '1',
				'maxitems' => '1',
				'eval' => 'required,nospace',
				'default' => 'fileadmin',
			)
		),
		'extensions' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pluploadfe/locallang_db.xml:tx_pluploadfe_config.extensions',
			'config' => array(
				'type' => 'text',
				'cols' => '50',
				'rows' => '10',
				'eval' => 'required,trim',
				'default' => 'jpeg,jpg,gif,png,zip,rar,7zip,gz',
			)
		),
		'feuser_required' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pluploadfe/locallang_db.xml:tx_pluploadfe_config.feuser_required',
			'config' => array(
				'type' => 'check',
				'default' => 1,
			)
		),
		'feuser_field' => array(
			'exclude' => 1,
			'displayCond' => 'FIELD:feuser_required:REQ:true',
			'label' => 'LLL:EXT:pluploadfe/locallang_db.xml:tx_pluploadfe_config.feuser_field',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('LLL:EXT:pluploadfe/locallang_db.xml:tx_pluploadfe_config.feuser_field.default', ''),
					array('LLL:EXT:pluploadfe/locallang_db.xml:tx_pluploadfe_config.feuser_field.username', 'username'),
					array('LLL:EXT:pluploadfe/locallang_db.xml:tx_pluploadfe_config.feuser_field.uid', 'uid'),
					array('LLL:EXT:pluploadfe/locallang_db.xml:tx_pluploadfe_config.feuser_field.realname', 'realName'),
					array('LLL:EXT:pluploadfe/locallang_db.xml:tx_pluploadfe_config.feuser_field.pid', 'pid'),
					array('LLL:EXT:pluploadfe/locallang_db.xml:tx_pluploadfe_config.feuser_field.lastlogin', 'lastlogin'),
				),
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'save_session' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pluploadfe/locallang_db.xml:tx_pluploadfe_config.save_session',
			'config' => array(
				'type' => 'check',
				'default' => 0,
			)
		),
		'obscure_dir' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pluploadfe/locallang_db.xml:tx_pluploadfe_config.obscure_dir',
			'config' => array(
				'type' => 'check',
				'default' => 0,
			)
		),
		'check_mime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pluploadfe/locallang_db.xml:tx_pluploadfe_config.check_mime',
			'config' => array(
				'type' => 'check',
				'default' => 1,
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title, upload_path, extensions, obscure_dir, feuser_required, feuser_field, save_session, check_mime')
	),
	'palettes' => array(
		'1' => array('showitem' => 'starttime, endtime')
	)
);

// Change to simple input for now
// @todo type=group & internal_type=folder is not available in TYPO3 7.5 and above
// see https://forge.typo3.org/issues/72369
if (version_compare(TYPO3_version, '7.5.0', '>=')) {
	$GLOBALS['TCA']['tx_pluploadfe_config']['columns']['upload_path']['config']['type'] = 'input';
	$GLOBALS['TCA']['tx_pluploadfe_config']['columns']['upload_path']['config']['size'] = '30';
	$GLOBALS['TCA']['tx_pluploadfe_config']['columns']['upload_path']['config']['max'] = '255';
}
