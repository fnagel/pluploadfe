<?php

namespace FelixNagel\Pluploadfe\Controller;

/**
 * This file is part of the "pluploadfe" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use FelixNagel\Pluploadfe\Exception\Exception;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Page\PageRenderer;

/**
 * Plugin 'pluploadfe_pi1' for the 'pluploadfe' extension.
 */
class Pi1Controller extends AbstractPlugin
{
    protected string $prefixId = 'tx_pluploadfe_pi1';

    protected string $scriptRelPath = 'Classes/Controller/Pi1Controller.php';

    protected string $extKey = 'pluploadfe';

    protected int $configUid;

    protected string $uid;

    protected string $templateHtml;

    protected ?array $config = [];

    /**
     * The main method of the PlugIn.
     */
    public function main(string $content, array $conf): string
    {
        $this->conf = $conf;
        $this->pi_loadLL('EXT:pluploadfe/Resources/Private/Language/locallang.xlf');

        // Set config record uid
        if (isset($this->conf['configUid']) && $this->conf['configUid'] !== '') {
            $this->configUid = (int) $this->conf['configUid'];
        } else {
            // @extensionScannerIgnoreLine
            $this->configUid = (int) $this->cObj->data['tx_pluploadfe_config'];
        }

        // Set identifier
        if (isset($this->conf['uid']) && $this->conf['uid'] !== '') {
            $this->uid = (string) $this->conf['uid'];
        } else {
            $this->uid = (string) $this->configUid;
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
        // @extensionScannerIgnoreLine
        $where = static::getTsFeController()->sys_page->enableFields($table);

        $this->config = BackendUtility::getRecord($table, $this->configUid, $select, $where, false);
    }

    /**
     * Checks config.
     */
    protected function checkConfig(): bool
    {
        if ($this->uid !== '' &&
            $this->templateHtml !== '' &&
            $this->configUid > 0 &&
            is_array($this->config) &&
            $this->config['extensions'] !== ''
        ) {
            return true;
        }

        throw new Exception('Invalid configuration');
    }

    /**
     * Function to parse the template.
     */
    protected function renderCode(): void
    {
        // Extract subparts from the template
        // @extensionScannerIgnoreLine
        $templateMain = $this->templateService->getSubpart($this->templateHtml, '###TEMPLATE_CODE###');

        // Fill marker array
        $markerArray = $this->getDefaultMarker();
        $markerArray['###UPLOAD_FILE###'] = GeneralUtility::getIndpEnv('TYPO3_SITE_URL').
            'index.php?tx_pluploadfe='.$this->configUid;

        // Replace markers in the template
        // @extensionScannerIgnoreLine
        $content = $this->templateService->substituteMarkerArray($templateMain, $markerArray);

        // Add JS code
        $this->getPageRenderer()->addJsFooterInlineCode(
            $this->prefixId.'_'.$this->uid,
            $content,
            useNonce: true
        );

        // Add JS localization
        $this->getPageRenderer()->addInlineLanguageLabelFile(
            'EXT:pluploadfe/Resources/Private/Language/locallang.js.xlf'
        );
    }

    /**
     * Function to parse the template.
     */
    protected function getHtml(): string
    {
        // Extract subparts from the template
        // @extensionScannerIgnoreLine
        $templateMain = $this->templateService->getSubpart($this->templateHtml, '###TEMPLATE_CONTENT###');

        // Fill marker array
        $markerArray = $this->getDefaultMarker();
        $markerArray['###INFO_1###'] = $this->pi_getLL('info_1');
        $markerArray['###INFO_2###'] = $this->pi_getLL('info_2');

        // Replace markers in the template
        // @extensionScannerIgnoreLine
        return $this->templateService->substituteMarkerArray($templateMain, $markerArray);
    }

    /**
     * Function to render the default marker.
     */
    protected function getDefaultMarker(): array
    {
        $markerArray = [];
        $extensionsArray = GeneralUtility::trimExplode(',', $this->config['extensions'], true);
        $maxFileSizeInBytes = (GeneralUtility::getMaxUploadFileSize() * 1024) - 1024;
        /* @var SiteLanguage $siteLanguage */
        $siteLanguage = $GLOBALS['TYPO3_REQUEST']->getAttribute('language');

        $markerArray['###UID###'] = $this->uid;
        $markerArray['###LANGUAGE###'] = $siteLanguage->getTypo3Language();
        $markerArray['###EXTDIR_PATH###'] = GeneralUtility::getIndpEnv('TYPO3_SITE_URL').
            PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath($this->extKey));
        $markerArray['###FILE_EXTENSIONS###'] = implode(',', $extensionsArray);
        $markerArray['###FILE_MAX_SIZE###'] = $maxFileSizeInBytes;

        return $markerArray;
    }

    /**
     * Function to fetch the template file.
     */
    protected function getTemplateFile(): void
    {
        $templateFile = (array_key_exists('templateFile', $this->conf) && strlen(trim($this->conf['templateFile'])) > 0) ?
            trim($this->conf['templateFile']) : 'EXT:pluploadfe/Resources/Private/Templates/template.html';

        // Get the template
        $this->templateHtml = file_get_contents($this->sanitizeTemplateFile($templateFile));

        if (!$this->templateHtml) {
            throw new Exception('Error while fetching the template file: '.$templateFile);
        }
    }

    protected function sanitizeTemplateFile(string $file): string
    {
        $sanitizedFile = GeneralUtility::getFileAbsFileName($file);

        if (empty($sanitizedFile)) {
            throw new Exception('Invalid template file: '.$file);
        }

        return $sanitizedFile;
    }

    protected function getPageRenderer(): PageRenderer
    {
        return GeneralUtility::makeInstance(PageRenderer::class);
    }

    protected static function getTsFeController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
