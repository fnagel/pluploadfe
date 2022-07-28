<?php

namespace FelixNagel\Pluploadfe\ViewHelpers;

/**
 * This file is part of the "Pluploadfe" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class RenderViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('configUid', 'int', 'Pluploadfe record UID', true);
        $this->registerArgument('settings', 'array', 'Pluploadfe TypoScript object', true);
        $this->registerArgument('uid', 'string', 'Identifier in frontend (id attribute)', false, null);
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $settings = (array)$arguments['settings'];

        // Override configuration
        $settings['configUid'] = (int)$arguments['configUid'];
        if ($arguments['uid'] !== null) {
            $settings['uid'] = $arguments['uid'];
        }

        return static::getContentObjectRenderer()->cObjGetSingle($settings['_typoScriptNodeValue'], $settings);
    }

    protected static function getContentObjectRenderer(): ContentObjectRenderer
    {
        return $GLOBALS['TSFE']->cObj;
    }
}
