<?php

namespace FelixNagel\Pluploadfe\Controller;

/**
 * This file is part of the "pluploadfe" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use FelixNagel\Pluploadfe\Exception\Exception;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Service\MarkerBasedTemplateService;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\Plugin\AbstractPlugin;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Plugin 'pluploadfe_pi1' for the 'pluploadfe' extension.
 */
class Pi1Controller extends AbstractPlugin
{
    /**
     * @var string
     */
    public $prefixId = 'tx_pluploadfe_pi1';

    /**
     * @var string
     */
    public $scriptRelPath = 'Classes/Controller/Pi1Controller.php';

    /**
     * @var string
     */
    public $extKey = 'pluploadfe';

    /**
     * @var bool
     */
    public $pi_checkCHash = true;

    /**
     * @var int
     */
    protected $configUid;

    /**
     * @var int
     */
    protected $uid;

    /**
     * @var string
     */
    protected $templateHtml;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var ObjectManager|null
     */
    protected $objectManager = null;

    /**
     * @var MarkerBasedTemplateService|null
     */
    protected $markerTemplateService = null;

    /**
     * The main method of the PlugIn.
     *
     * @param string $content : The plugin content
     * @param array  $conf    : The plugin configuration
     *
     * @return string The content that is displayed on the website
     */
    public function main($content, $conf)
    {
        $this->conf = $conf;
        $this->pi_setPiVarDefaults();
        $this->pi_loadLL('EXT:pluploadfe/Resources/Private/Language/locallang.xlf');

        // set (localized) UID
        $localizedUid = $this->cObj->data['_LOCALIZED_UID'];
        if (strlen($this->conf['uid']) > 0) {
            $this->uid = $this->conf['uid'];
        } else {
            $this->uid = (int)($localizedUid) ? $localizedUid : $this->cObj->data['uid'];
        }

        // set config record uid
        if (strlen($this->conf['configUid']) > 0) {
            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->conf);
            $this->configUid = $this->cObj->cObjGetSingle($this->conf['configUid'], $this->conf['configUid.']);
            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->configUid);
        } else {
            $this->configUid = (int)$this->cObj->data['tx_pluploadfe_config'];
        }

        $this->getUploadConfig();
        $this->getTemplateFile();
        $this->checkConfig();

        $this->renderCode();

        return $this->pi_wrapInBaseClass($this->getHtml());
    }

    /**
     * Checks config.
     */
    protected function getUploadConfig()
    {
        $select = 'extensions';
        $table = 'tx_pluploadfe_config';
        $where = $this->getTsFeController()->sys_page->enableFields($table);

        $this->config = BackendUtility::getRecord($table, $this->configUid, $select, $where, false);
    }

    /**
     * Checks config.
     *
     * @return bool
     */
    protected function checkConfig()
    {
        if (strlen($this->uid) > 0 &&
            strlen($this->templateHtml) > 0 &&
            intval($this->configUid) > 0 &&
            is_array($this->config) &&
            strlen($this->config['extensions']) > 0
        ) {
            return true;
        }

        throw new Exception('Invalid configuration');
    }

    /**
     * Function to parse the template.
     */
    protected function renderCode()
    {
        // Extract subparts from the template
        $templateMain = $this->getMarkerTemplateService()->getSubpart($this->templateHtml, '###TEMPLATE_CODE###');

        // fill marker array
        $markerArray = $this->getDefaultMarker();
        $markerArray['###UPLOAD_FILE###'] = GeneralUtility::getIndpEnv('TYPO3_SITE_URL').
            'index.php?tx_pluploadfe='.$this->configUid;

        // replace markers in the template
        $content = $this->getMarkerTemplateService()->substituteMarkerArray($templateMain, $markerArray);

        $this->getPageRenderer()->addJsFooterInlineCode(
            $this->prefixId.'_'.$this->uid,
            $content
        );
    }

    /**
     * Function to parse the template.
     *
     * @return string
     */
    protected function getHtml()
    {
        // Extract subparts from the template
        $templateMain = $this->getMarkerTemplateService()->getSubpart($this->templateHtml, '###TEMPLATE_CONTENT###');

        // fill marker array
        $markerArray = $this->getDefaultMarker();
        $markerArray['###INFO_1###'] = $this->pi_getLL('info_1');
        $markerArray['###INFO_2###'] = $this->pi_getLL('info_2');

        // replace markers in the template
        $content = $this->getMarkerTemplateService()->substituteMarkerArray($templateMain, $markerArray);

        return $content;
    }

    /**
     * Function to render the default marker.
     *
     * @return array
     */
    protected function getDefaultMarker()
    {
        $markerArray = [];
        $extensionsArray = GeneralUtility::trimExplode(',', $this->config['extensions'], true);
        $maxFileSizeInBytes = GeneralUtility::getMaxUploadFileSize() * 1024;

        $markerArray['###UID###'] = $this->uid;
        $markerArray['###LANGUAGE###'] = $this->getTsFeController()->config['config']['language'];
        $markerArray['###EXTDIR_PATH###'] = GeneralUtility::getIndpEnv('TYPO3_SITE_URL').
            PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath($this->extKey));
        $markerArray['###FILE_EXTENSIONS###'] = implode(',', $extensionsArray);
        $markerArray['###FILE_MAX_SIZE###'] = $maxFileSizeInBytes;

        return $markerArray;
    }

    /**
     * Function to fetch the template file.
     */
    protected function getTemplateFile()
    {
        $templateFile = (strlen(trim($this->conf['templateFile'])) > 0) ?
            trim($this->conf['templateFile']) : 'EXT:pluploadfe/Resources/Private/Templates/template.html';

        // Get the template
        $this->templateHtml = file_get_contents($this->sanitizeTemplateFile($templateFile));

        if (!$this->templateHtml) {
            throw new Exception('Error while fetching the template file: '.$templateFile);
        }
    }

    /**
     * @param $templateFile
     * @return string
     */
    protected function sanitizeTemplateFile($templateFile)
    {
        /* @var $filePathSanitizer \TYPO3\CMS\Frontend\Resource\FilePathSanitizer */
        $filePathSanitizer = $this->getObjectManager()->get(\TYPO3\CMS\Frontend\Resource\FilePathSanitizer::class);
        $templateFile = $filePathSanitizer->sanitize($templateFile);

        return $templateFile;
    }

    /**
     * Get page renderer.
     *
     * @return \TYPO3\CMS\Core\Page\PageRenderer
     */
    protected function getPageRenderer()
    {
        // Don't use the object manager due to core bug:
        // https://github.com/TYPO3/TYPO3.CMS/commit/cffb6e0fc6b4664dab7bd1838da6125787fffc26

        return GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
    }

    /**
     * @return MarkerBasedTemplateService
     */
    protected function getMarkerTemplateService()
    {
        if ($this->markerTemplateService === null) {
            $this->markerTemplateService = $this->getObjectManager()->get(MarkerBasedTemplateService::class);
        }

        return $this->markerTemplateService;
    }

    /**
     * @return ObjectManager
     */
    protected function getObjectManager()
    {
        if ($this->objectManager === null) {
            $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        }

        return $this->objectManager;
    }

    /**
     * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    protected static function getTsFeController()
    {
        return $GLOBALS['TSFE'];
    }
}
