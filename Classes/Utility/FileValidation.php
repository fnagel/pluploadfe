<?php

namespace FelixNagel\Pluploadfe\Utility;

/**
 * This file is part of the "pluploadfe" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Resource\Security\FileNameValidator;
use FelixNagel\Pluploadfe\Exception\InvalidArgumentException;
use FelixNagel\Pluploadfe\Statics\MimeTypes;

/**
 * FileValidation.
 */
class FileValidation
{
    /**
     * Checks file extension.
     *
     * @param string $fileName Filename to check
     * @param string $allowedExtensions CSV list of allowed file extensions
     */
    public static function checkFileExtension($fileName, $allowedExtensions)
    {
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $extensions = GeneralUtility::trimExplode(',', $allowedExtensions, true);

        // check if file extension is allowed (configuration record)
        if (!in_array($fileExtension, $extensions)) {
            throw new InvalidArgumentException('File extension is not allowed.');
        }

        // check if file extension is allowed on this TYPO3 installation
        if (!GeneralUtility::makeInstance(FileNameValidator::class)->isValid($fileName)) {
            throw new InvalidArgumentException('File extension is not allowed on this TYPO3 installation.');
        }
    }

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

        if (function_exists('exec') && function_exists('escapeshellarg')
			&& ($tempMime = trim(@exec('file -bi '.@escapeshellarg($filePath))))
		) {
            return $tempMime;
        }

        if (function_exists('pathinfo') && ($pathinfo = @pathinfo($filePath))
			&& (in_array($pathinfo['extension'], MimeTypes::$imageTypes) && $size = getimagesize($filePath))
		) {
            return $size['mime'];
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
