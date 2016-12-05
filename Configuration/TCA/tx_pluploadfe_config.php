<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

return array(
	'ctrl' =>  array(
        'title' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config',
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
        'typeicon_classes' => [
            'default' => 'extensions-pluploadfe-config',
        ],
        'requestUpdate' => 'feuser_required',
        'searchFields' => 'title,upload_path',
    ),
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
			'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.upload_path',
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
			'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.extensions',
			'config' => array(
				'type' => 'text',
				'rows' => '2',
				'eval' => 'required,trim',
				'default' => 'jpeg,jpg,gif,png,zip,rar,7zip,gz',
			)
		),
		'feuser_required' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.feuser_required',
			'config' => array(
				'type' => 'check',
				'default' => 1,
			)
		),
		'feuser_field' => array(
			'exclude' => 1,
			'displayCond' => 'FIELD:feuser_required:REQ:true',
			'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.feuser_field',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.feuser_field.default', ''),
					array('LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.feuser_field.username', 'username'),
					array('LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.feuser_field.uid', 'uid'),
					array('LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.feuser_field.name', 'name'),
					array('LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.feuser_field.fullname', 'fullname'),
					array('LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.feuser_field.pid', 'pid'),
					array('LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.feuser_field.lastlogin', 'lastlogin'),
				),
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'save_session' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.save_session',
			'config' => array(
				'type' => 'check',
				'default' => 0,
			)
		),
		'obscure_dir' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.obscure_dir',
			'config' => array(
				'type' => 'check',
				'default' => 0,
			)
		),
		'check_mime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.check_mime',
			'config' => array(
				'type' => 'check',
				'default' => 1,
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => '
			--div--;LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.tabs.general,
				title, feuser_required, save_session,

			--div--;LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.tabs.path,
				upload_path, feuser_field, obscure_dir,

			--div--;LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tx_pluploadfe_config.tabs.security,
				extensions, check_mime,

			--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.visibility;visibility,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.access;access'
		)
	),
	'palettes' => array(
		'visibility' => array(
			'showitem' => 'hidden',
		),
		'access' => array(
			'showitem' => '
				starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.starttime_formlabel,
				endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.endtime_formlabel,
				--linebreak--, fe_group;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.fe_group_formlabel'
		),
	)
);
