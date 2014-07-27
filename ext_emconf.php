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
	'shy' => '',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.2.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.5.0-6.0.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'privacyguard' => '',
		),
	),
	'_md5_values_when_last_written' => 'a:74:{s:9:"ChangeLog";s:4:"dcd7";s:12:"ext_icon.gif";s:4:"3ef1";s:17:"ext_localconf.php";s:4:"871f";s:14:"ext_tables.php";s:4:"9732";s:14:"ext_tables.sql";s:4:"4d1c";s:29:"icon_tx_pluploadfe_config.gif";s:4:"5757";s:13:"locallang.xml";s:4:"0cd9";s:16:"locallang_db.xml";s:4:"9225";s:7:"tca.php";s:4:"872e";s:14:"doc/manual.sxw";s:4:"01ed";s:34:"lib/class.tx_pluploadfe_upload.php";s:4:"a885";s:14:"pi1/ce_wiz.gif";s:4:"76e8";s:31:"pi1/class.tx_pluploadfe_pi1.php";s:4:"c6d5";s:39:"pi1/class.tx_pluploadfe_pi1_wizicon.php";s:4:"2610";s:17:"pi1/locallang.xml";s:4:"e0fc";s:17:"res/template.html";s:4:"d1ea";s:24:"res/plupload/license.txt";s:4:"7514";s:22:"res/plupload/readme.md";s:4:"cf0d";s:24:"res/plupload/js/moxie.js";s:4:"3529";s:28:"res/plupload/js/moxie.min.js";s:4:"540b";s:25:"res/plupload/js/Moxie.swf";s:4:"ddfc";s:25:"res/plupload/js/Moxie.xap";s:4:"cbb0";s:31:"res/plupload/js/plupload.dev.js";s:4:"7c76";s:36:"res/plupload/js/plupload.full.min.js";s:4:"f363";s:31:"res/plupload/js/plupload.min.js";s:4:"c60a";s:26:"res/plupload/js/i18n/bs.js";s:4:"d541";s:26:"res/plupload/js/i18n/cs.js";s:4:"e1eb";s:26:"res/plupload/js/i18n/cy.js";s:4:"57b6";s:26:"res/plupload/js/i18n/da.js";s:4:"83ef";s:26:"res/plupload/js/i18n/de.js";s:4:"85a0";s:26:"res/plupload/js/i18n/el.js";s:4:"34b7";s:26:"res/plupload/js/i18n/en.js";s:4:"5c86";s:26:"res/plupload/js/i18n/es.js";s:4:"e4d0";s:26:"res/plupload/js/i18n/et.js";s:4:"d24f";s:26:"res/plupload/js/i18n/fa.js";s:4:"ed2b";s:26:"res/plupload/js/i18n/fi.js";s:4:"9b6e";s:26:"res/plupload/js/i18n/fr.js";s:4:"4af3";s:26:"res/plupload/js/i18n/hr.js";s:4:"1ff3";s:26:"res/plupload/js/i18n/hu.js";s:4:"0338";s:26:"res/plupload/js/i18n/hy.js";s:4:"3f83";s:26:"res/plupload/js/i18n/it.js";s:4:"5cbb";s:26:"res/plupload/js/i18n/ja.js";s:4:"457d";s:26:"res/plupload/js/i18n/ka.js";s:4:"185b";s:26:"res/plupload/js/i18n/ko.js";s:4:"9e4a";s:26:"res/plupload/js/i18n/lt.js";s:4:"52ea";s:26:"res/plupload/js/i18n/lv.js";s:4:"7bd7";s:26:"res/plupload/js/i18n/nl.js";s:4:"11fd";s:26:"res/plupload/js/i18n/pl.js";s:4:"efae";s:29:"res/plupload/js/i18n/pt_BR.js";s:4:"0b84";s:26:"res/plupload/js/i18n/ro.js";s:4:"a7cb";s:26:"res/plupload/js/i18n/ru.js";s:4:"6979";s:26:"res/plupload/js/i18n/sk.js";s:4:"8b15";s:26:"res/plupload/js/i18n/sr.js";s:4:"e747";s:26:"res/plupload/js/i18n/sv.js";s:4:"620f";s:29:"res/plupload/js/i18n/th_TH.js";s:4:"a22e";s:26:"res/plupload/js/i18n/tr.js";s:4:"a461";s:29:"res/plupload/js/i18n/uk_UA.js";s:4:"1595";s:29:"res/plupload/js/i18n/zh_CN.js";s:4:"22b7";s:62:"res/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js";s:4:"4899";s:66:"res/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js";s:4:"cb27";s:67:"res/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css";s:4:"d356";s:57:"res/plupload/js/jquery.plupload.queue/img/backgrounds.gif";s:4:"cffe";s:62:"res/plupload/js/jquery.plupload.queue/img/buttons-disabled.png";s:4:"8c98";s:53:"res/plupload/js/jquery.plupload.queue/img/buttons.png";s:4:"a346";s:52:"res/plupload/js/jquery.plupload.queue/img/delete.gif";s:4:"c717";s:50:"res/plupload/js/jquery.plupload.queue/img/done.gif";s:4:"75ef";s:51:"res/plupload/js/jquery.plupload.queue/img/error.gif";s:4:"0451";s:54:"res/plupload/js/jquery.plupload.queue/img/throbber.gif";s:4:"c366";s:54:"res/plupload/js/jquery.plupload.queue/img/transp50.png";s:4:"6579";s:56:"res/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js";s:4:"aecb";s:60:"res/plupload/js/jquery.ui.plupload/jquery.ui.plupload.min.js";s:4:"a433";s:61:"res/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css";s:4:"b493";s:50:"res/plupload/js/jquery.ui.plupload/img/loading.gif";s:4:"b3d5";s:51:"res/plupload/js/jquery.ui.plupload/img/plupload.png";s:4:"163a";}',
	'suggests' => array(
	),
);

?>