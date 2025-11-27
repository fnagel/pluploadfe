<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace FelixNagel\Pluploadfe\Controller;

use Psr\Http\Message\RequestInterface;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Service\MarkerBasedTemplateService;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Old school base class of frontend plugins.
 *
 * @deprecated Some legacy functionality straight from the TYPO3 v12 core.
 *
 * See \TYPO3\CMS\Frontend\Plugin\AbstractPlugin
 */
abstract class AbstractPlugin
{
    protected ?ContentObjectRenderer $cObj = null;

    /**
     * Should be same as classname of the plugin, used for CSS classes, variables
     */
    protected string $prefixId;

    /**
     * Path to the plugin class script relative to extension directory, eg. 'pi1/class.tx_newfaq_pi1.php'
     */
    protected string $scriptRelPath;

    /**
     * Extension key.
     */
    protected string $extKey;

    /**
     * Path to localization file.
     */
    protected string $localizationFile;

    /**
     * Should normally be set in the main function with the TypoScript content passed to the method.
     *
     * $conf[LOCAL_LANG][_key_] is reserved for Local Language overrides.
     * $conf[userFunc] reserved for setting up the USER / USER_INT object. See TSref
     */
    protected array $conf = [];

    protected ?MarkerBasedTemplateService $templateService;
    protected ?LanguageService $languageService;

    public function __construct()
    {
        $this->templateService = GeneralUtility::makeInstance(MarkerBasedTemplateService::class);
        $this->languageService = GeneralUtility::makeInstance(LanguageServiceFactory::class)->createFromSiteLanguage(
            // @extensionScannerIgnoreLine
            $this->getLanguage()
        );
    }

    /**
     * This setter is called when the plugin is called from UserContentObject (USER)
     * via ContentObjectRenderer->callUserFunction().
     */
    public function setContentObjectRenderer(ContentObjectRenderer $cObj): void
    {
        $this->cObj = $cObj;
    }

    /**
     * Wraps the input string in a <div> tag with the class attribute set to the prefixId.
     * All content returned from your plugins should be returned through this function so all content
     * from your plugin is encapsulated in a <div>-tag nicely identifying the content of your plugin.
     *
     * @param string $str HTML content to wrap in the div-tags with the "main class" of the plugin
     * @return string HTML content wrapped, ready to return to the parent object.
     */
    public function pi_wrapInBaseClass($str): string
    {
        return '<div class="' . str_replace('_', '-', $this->prefixId) . '">' . $str . '</div>';
    }

    /**
     * Returns the localized label
     */
    public function pi_getLL(string $key): string
    {
       return $this->languageService->sL('LLL:'.$this->localizationFile.':'.$key);
    }

    protected function getRequest(): RequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }

    protected function getLanguage(): SiteLanguage
    {
        return $this->getRequest()->getAttribute('language');
    }
}
