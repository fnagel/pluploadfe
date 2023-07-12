<?php

defined('TYPO3') || die('Access denied.');

return [
    'ctrl' => [
        'title' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config',
        'label' => 'title',
        'label_alt' => 'upload_path',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
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
        'searchFields' => 'title,upload_path',
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
                'type' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
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
                'default' => '',
            ],
        ],
        'upload_path' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.upload_path',
            'config' => [
                'type' => 'folder',
                'size' => 1,
                'maxitems' => 1,
                'required' => true,
                'eval' => 'nospace',
                'default' => 'fileadmin',
            ],
        ],
        'extensions' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.extensions',
            'config' => [
                'type' => 'text',
                'rows' => 2,
                'required' => true,
                'eval' => 'trim',
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
                    [
                        'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field.default',
                        'value' => '',
                    ],
                    [
                        'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field.username',
                        'value' => 'username',
                    ],
                    [
                        'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field.uid',
                        'value' => 'uid',
                    ],
                    [
                        'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field.name',
                        'value' => 'name',
                    ],
                    [
                        'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field.fullname',
                        'value' => 'fullname',
                    ],
                    [
                        'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field.pid',
                        'value' => 'pid',
                    ],
                    [
                        'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xlf:tx_pluploadfe_config.feuser_field.lastlogin',
                        'value' => 'lastlogin',
                    ],
                ],
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'default' => '',
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
