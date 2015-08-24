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

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Plupload for FE',
	'description' => 'Provides an API and a FE plugin for using plupload, a highly usable and advanced upload handler.',
	'category' => 'plugin',
	'author' => 'Felix Nagel',
	'author_email' => 'info@felixnagel.com',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '1',
	'createDirs' => '',
	'clearCacheOnLoad' => 1,
	'version' => '1.2.2-dev',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.0-7.4.99',
			'cms' => '',
		),
		'conflicts' => array(),
		'suggests' => array(
			'mailfiles' => '',
		),
	),
);

?>