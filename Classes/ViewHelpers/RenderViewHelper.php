<?php

namespace FelixNagel\Pluploadfe\ViewHelpers;

/**
 * This file is part of the "Pluploadfe" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class RenderViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('configUid', 'int', 'Pluploadfe record UID', true);
        $this->registerArgument('settings', 'array', 'Pluploadfe TypoScript object', true);
        $this->registerArgument('uid', 'string', 'Identifier in frontend (id attribute)', false, null);
    }

    public function render()
    {
        $settings = (array)$this->arguments['settings'];

        // Override configuration
        $settings['configUid'] = (int)$this->arguments['configUid'];
        if ($this->arguments['uid'] !== null) {
            $settings['uid'] = $this->arguments['uid'];
        }

        return $this->getContentObjectRenderer()->cObjGetSingle($settings['_typoScriptNodeValue'], $settings);
    }

    protected function getContentObjectRenderer(): ContentObjectRenderer
    {
        return $GLOBALS['TSFE']->cObj;
    }
}
