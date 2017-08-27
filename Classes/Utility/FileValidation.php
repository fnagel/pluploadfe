<?php

namespace TYPO3\Pluploadfe\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011-2017 Felix Nagel <info@felixnagel.com>
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

use TYPO3\Pluploadfe\Statics\MimeTypes;

/**
 * FileValidation.
 */
class FileValidation
{
    /**
     * Retrieves MIME type from given file.
     *
     * @param string $filePath
     *
     * @return string
     */
    public static function getMimeType($filePath)
    {
        if (function_exists('finfo_open')) {
            $info = @finfo_open(FILEINFO_MIME);
            if ($info) {
                $tempMime = @finfo_file($info, $filePath);
                finfo_close($info);
                if ($tempMime) {
                    return $tempMime;
                }
            }
        }

        if (function_exists('mime_content_type')) {
            return mime_content_type($filePath);
        }

        if (function_exists('exec') && function_exists('escapeshellarg')) {
            if (($tempMime = trim(@exec('file -bi '.@escapeshellarg($filePath))))) {
                return $tempMime;
            }
        }

        if (function_exists('pathinfo')) {
            if (($pathinfo = @pathinfo($filePath))) {
                if (in_array($pathinfo['extension'], MimeTypes::$imageTypes) && $size = getimagesize($filePath)) {
                    return $size['mime'];
                }
            }
        }

        // Fallback default which is totally insecure
        return $_FILES['file']['type'];
    }

    /**
     * Checks the given mime type.
     *
     * @param string $filePath
     *
     * @return bool
     */
    public static function checkMimeType($filePath)
    {
        $flag = false;
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if (array_key_exists($extension, MimeTypes::$mimeTypes)) {
            $mimeType = explode(';', self::getMimeType($filePath));

            // Check if mime type fits the given file extension
            if (in_array($mimeType[0], MimeTypes::$mimeTypes[$extension])) {
                $flag = true;
            }
        } else {
            // Fallback for unusual file types
            $flag = true;
        }

        return $flag;
    }
}
