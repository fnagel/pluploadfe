<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_pluploadfe_config'] = array(
	'ctrl' => $TCA['tx_pluploadfe_config']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,starttime,endtime,fe_group,upload_path,feuser_required'
	),
	'feInterface' => $TCA['tx_pluploadfe_config']['feInterface'],
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
				'default' => 1,
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
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title, upload_path, extensions, feuser_required, save_session, obscure_dir, check_mime')
	),
	'palettes' => array(
		'1' => array('showitem' => 'starttime, endtime')
	)
);
?>