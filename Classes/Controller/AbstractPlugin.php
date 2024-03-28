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

use TYPO3\CMS\Core\Localization\Locales;
use TYPO3\CMS\Core\Localization\LocalizationFactory;
use TYPO3\CMS\Core\Service\MarkerBasedTemplateService;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
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
     * Local Language content
     */
    protected array $LOCAL_LANG = [];

    /**
     * Flag that tells if the locallang file has been fetch (or tried to
     * be fetched) already.
     */
    protected bool $LOCAL_LANG_loaded = false;

    /**
     * Pointer to the language to use.
     */
    protected string $LLkey = 'default';

    /**
     * Pointer to alternative fall-back language to use.
     */
    protected string $altLLkey = '';

    /**
     * Should normally be set in the main function with the TypoScript content passed to the method.
     *
     * $conf[LOCAL_LANG][_key_] is reserved for Local Language overrides.
     * $conf[userFunc] reserved for setting up the USER / USER_INT object. See TSref
     */
    protected array $conf = [];

    protected ?MarkerBasedTemplateService $templateService;

    public function __construct()
    {
        $this->templateService = GeneralUtility::makeInstance(MarkerBasedTemplateService::class);

        // @extensionScannerIgnoreLine
        $this->LLkey = $this->getLanguage()->getTypo3Language();

        $locales = GeneralUtility::makeInstance(Locales::class);
        if ($locales->isValidLanguageKey($this->LLkey)) {
            $alternativeLanguageKeys = $locales->getLocaleDependencies($this->LLkey);
            $alternativeLanguageKeys = array_reverse($alternativeLanguageKeys);
            $this->altLLkey = implode(',', $alternativeLanguageKeys);
        }
    }

    protected function getLanguage(): SiteLanguage
    {
        return $GLOBALS['TYPO3_REQUEST']->getAttribute('language');
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
    public function pi_wrapInBaseClass($str)
    {
        return '<div class="' . str_replace('_', '-', $this->prefixId) . '">' . $str . '</div>';
    }

    /***************************
     *
     * Localization, locallang functions
     *
     **************************/
    /**
     * Returns the localized label of the LOCAL_LANG key, $key
     *
     * @param string $key The key from the LOCAL_LANG array for which to return the value.
     * @param string $alternativeLabel Alternative string to return IF no value is found set for the key, neither for the local language nor the default.
     * @return string The value from LOCAL_LANG.
     */
    public function pi_getLL($key, $alternativeLabel = '')
    {
        $word = null;
        if (!empty($this->LOCAL_LANG[$this->LLkey][$key][0]['target'])) {
            $word = $this->LOCAL_LANG[$this->LLkey][$key][0]['target'];
        } elseif ($this->altLLkey) {
            $alternativeLanguageKeys = GeneralUtility::trimExplode(',', $this->altLLkey, true);
            foreach ($alternativeLanguageKeys as $languageKey) {
                if (!empty($this->LOCAL_LANG[$languageKey][$key][0]['target'])) {
                    // Alternative language translation for key exists
                    $word = $this->LOCAL_LANG[$languageKey][$key][0]['target'];
                    break;
                }
            }
        }
        
        if ($word === null) {
            if (!empty($this->LOCAL_LANG['default'][$key][0]['target'])) {
                // Get default translation (without charset conversion, english)
                $word = $this->LOCAL_LANG['default'][$key][0]['target'];
            } else {
                // Return alternative string or empty
                $word = $alternativeLabel;
            }
        }
        
        return $word;
    }

    /**
     * Loads local-language values from the file passed as a parameter or
     * by looking for a "locallang" file in the
     * plugin class directory ($this->scriptRelPath).
     * Also locallang values set in the TypoScript property "_LOCAL_LANG" are
     * merged onto the values found in the "locallang" file.
     * Supported file extensions xlf
     *
     * @param string $languageFilePath path to the plugin language file in format EXT:....
     */
    public function pi_loadLL($languageFilePath = '')
    {
        if ($this->LOCAL_LANG_loaded) {
            return;
        }

        if ($languageFilePath === '' && $this->scriptRelPath) {
            $languageFilePath = 'EXT:' . $this->extKey . '/' . PathUtility::dirname($this->scriptRelPath) . '/locallang.xlf';
        }
        
        if ($languageFilePath !== '') {
            $languageFactory = GeneralUtility::makeInstance(LocalizationFactory::class);
            $this->LOCAL_LANG = $languageFactory->getParsedData($languageFilePath, $this->LLkey);
            $alternativeLanguageKeys = GeneralUtility::trimExplode(',', $this->altLLkey, true);
            foreach ($alternativeLanguageKeys as $languageKey) {
                $tempLL = $languageFactory->getParsedData($languageFilePath, $languageKey);
                if ($this->LLkey !== 'default' && isset($tempLL[$languageKey])) {
                    $this->LOCAL_LANG[$languageKey] = $tempLL[$languageKey];
                }
            }
            
            // Overlaying labels from TypoScript (including fictitious language keys for non-system languages!):
            if (isset($this->conf['_LOCAL_LANG.'])) {
                foreach ($this->conf['_LOCAL_LANG.'] as $languageKey => $languageArray) {
                    // Remove the dot after the language key
                    $languageKey = substr($languageKey, 0, -1);
                    // Don't process label if the language is not loaded
                    if (is_array($languageArray) && isset($this->LOCAL_LANG[$languageKey])) {
                        foreach ($languageArray as $labelKey => $labelValue) {
                            if (!is_array($labelValue)) {
                                $this->LOCAL_LANG[$languageKey][$labelKey][0]['target'] = $labelValue;
                            }
                        }
                    }
                }
            }
        }
        
        $this->LOCAL_LANG_loaded = true;
    }
}
