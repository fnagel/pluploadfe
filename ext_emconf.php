<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "pluploadfe".
 *
 * Auto generated 04-01-2014 00:01
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'Plupload for FE',
    'description' => 'Provides an API and a FE plugin for using plupload, a highly usable and advanced upload handler.',
    'category' => 'plugin',
    'author' => 'Felix Nagel',
    'author_email' => 'info@felixnagel.com',
    'state' => 'stable',
    'version' => '8.0.1-dev',
    'constraints' => [
        'depends' => [
            'php' => '8.2.0-8.3.99',
            'typo3' => '12.4.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [
            'mailfiles' => '',
            'plupload_powermail' => '',
        ],
    ],
];
