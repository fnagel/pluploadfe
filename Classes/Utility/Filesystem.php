<?php

namespace TYPO3\Pluploadfe\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Felix Nagel <info@felixnagel.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\Pluploadfe\Exception\InvalidArgumentException;

/**
 * Filesystem.
 */
class Filesystem
{
    /**
     * Check if path is allowed and valid.
     *
     * @param $path
     * @return bool
     */
    public static function isPathValid($path)
    {
        return (strlen($path) > 0 && GeneralUtility::isAllowedAbsPath(PATH_site.$path));
    }

    /**
     * Create upload folder.
     *
     * @param string $uploadPath
     */
    public static function createFolder($uploadPath)
    {
        if (file_exists($uploadPath)) {
            return;
        }

        // Create target dir
        try {
            GeneralUtility::mkdir_deep(PATH_site, $uploadPath);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Failed to create upload directory.');
        }
    }

    /**
     * Generate random string.
     *
     * @param int $length
     * @return string
     */
    public static function getRandomDirName($length = 10)
    {
        $set = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIKLMNPQRSTUVWXYZ0123456789';
        $string = '';

        for ($i = 1; $i <= $length; ++$i) {
            $string .= $set[mt_rand(0, (strlen($set) - 1))];
        }

        return $string;
    }
}
