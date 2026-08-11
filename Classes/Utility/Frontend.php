<?php

namespace FelixNagel\Pluploadfe\Utility;

/**
 * This file is part of the "pluploadfe" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * General utility class.
 */
class Frontend implements SingletonInterface
{
    public static function getSiteUrl(): string
    {
        return static::getNormalizedParams()->getSiteUrl();
    }

    public static function getNormalizedParams(): NormalizedParams
    {
        return static::getRequest()->getAttribute('normalizedParams');
    }

    protected static function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}
