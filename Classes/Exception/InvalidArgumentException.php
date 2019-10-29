<?php

namespace FelixNagel\Pluploadfe\Exception;

/**
 * This file is part of the "pluploadfe" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */


class InvalidArgumentException extends \InvalidArgumentException
{
    protected $code = 100;
}
