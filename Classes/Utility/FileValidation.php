<?php

namespace FelixNagel\Pluploadfe\Utility;

/**
 * This file is part of the "pluploadfe" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use FelixNagel\Pluploadfe\Exception\InvalidArgument\InvalidFileExtensionException;
use FelixNagel\Pluploadfe\Statics\MimeTypes;
use TYPO3\CMS\Core\Resource\Security\FileNameValidator;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
    public static function checkFileExtension(string $fileName, string $allowedExtensions): void
    {
        $extension = self::getExtension($fileName);
        $extensions = GeneralUtility::trimExplode(',', $allowedExtensions, true);

        // check if file extension is allowed (configuration record)
        if (!in_array($extension, $extensions)) {
            throw new InvalidFileExtensionException('File extension is not allowed.');
        }

        // check if file extension is allowed on this TYPO3 installation
        if (!GeneralUtility::makeInstance(FileNameValidator::class)->isValid($fileName)) {
            throw new InvalidFileExtensionException('File extension is not allowed on this TYPO3 installation.');
        }
    }

    /**
     * Retrieves MIME type from given file.
     */
    protected static function getMimeType(string $filePath): string
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
     */
    public static function checkMimeType(string $filePath): bool
    {
        $flag = false;
        $extension = self::getExtension($filePath);

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

    protected static function getExtension(string $filePath): string
    {
        return strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    }
}
