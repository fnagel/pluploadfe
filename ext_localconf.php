<?php

use FelixNagel\Pluploadfe\Controller\Pi1Controller;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

call_user_func(static function () {
    // Add plugin
    ExtensionManagementUtility::addTypoScript(
        'FelixNagel.Pluploadfe',
        'setup',
        '# Setting PluploadFE plugin TypoScript
		tt_content.pluploadfe_pi1 =< lib.contentElement
		tt_content.pluploadfe_pi1.templateName = Generic
		tt_content.pluploadfe_pi1.20 = USER
		tt_content.pluploadfe_pi1.20.userFunc = '. Pi1Controller::class.'->main',
        'defaultContentRendering'
    );

    // Add records to the search
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['livesearch']['pluploadfe'] = 'tx_pluploadfe_config';
});
