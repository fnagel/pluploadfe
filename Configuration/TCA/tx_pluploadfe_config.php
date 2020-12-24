<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

return [
    'ctrl' => [
        'title' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config',
        'label' => 'title',
        'label_alt' => 'upload_path',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'typeicon_classes' => [
            'default' => 'extensions-pluploadfe-config',
        ],
        'requestUpdate' => 'feuser_required',
        'searchFields' => 'title,upload_path',
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,starttime,endtime,fe_group,upload_path,feuser_required',
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => '1',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
            ],
        ],
        'title' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'checkbox' => '',
                'eval' => 'trim',
            ],
        ],
        'upload_path' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.upload_path',
            'config' => [
                'type' => 'group',
                'internal_type' => 'folder',
                'size' => 1,
                'maxitems' => 1,
                'eval' => 'required,nospace',
                'default' => 'fileadmin',
            ],
        ],
        'extensions' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.extensions',
            'config' => [
                'type' => 'text',
                'rows' => 2,
                'eval' => 'required,trim',
                'default' => 'jpeg,jpg,gif,png,zip,rar,7zip,gz',
            ],
        ],
        'feuser_required' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_required',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
            'onChange' => 'reload',
        ],
        'feuser_field' => [
            'exclude' => 1,
            'displayCond' => 'FIELD:feuser_required:REQ:true',
            'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field.default', ''],
                    ['LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field.username', 'username'],
                    ['LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field.uid', 'uid'],
                    ['LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field.name', 'name'],
                    ['LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field.fullname', 'fullname'],
                    ['LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field.pid', 'pid'],
                    ['LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field.lastlogin', 'lastlogin'],
                ],
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'save_session' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.save_session',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'obscure_dir' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.obscure_dir',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'check_mime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.check_mime',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => '
			--div--;LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.tabs.general,
				title, feuser_required, save_session,

			--div--;LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.tabs.path,
				upload_path, feuser_field, obscure_dir,

			--div--;LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.tabs.security,
				extensions, check_mime,

			--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.visibility;visibility,
				--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.access;access',
        ],
    ],
    'palettes' => [
        'visibility' => [
            'showitem' => 'hidden',
        ],
        'access' => [
            'showitem' => '
				starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.starttime_formlabel,
				endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.endtime_formlabel,
				--linebreak--, fe_group;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.fe_group_formlabel',
        ],
    ],
];
