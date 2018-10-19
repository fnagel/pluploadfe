<?php

namespace FelixNagel\Pluploadfe\Statics;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011-2018 Felix Nagel <info@felixnagel.com>
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

/**
 * MimeTypes
 */
class MimeTypes
{
    /**
     * @var array
     */
    static public $imageTypes = array(
        'gif',
        'jpeg',
        'jpg',
        'png',
        'swf',
        'psd',
        'bmp',
        'tiff',
        'tif',
        'jpc',
        'jp2',
        'jpx',
        'jb2',
        'swc',
        'iff',
        'wbmp',
        'xbm',
        'ico',
    );

    /**
     * @var array
     */
    static public $mimeTypes = array(
        '3dmf' => array('x-world/x-3dmf'),
        '3dm' => array('x-world/x-3dmf'),
        '7z' => array('application/x-7z-compressed', 'application/zip'),
        'avi' => array('video/x-msvideo'),
        'ai' => array('application/postscript'),
        'bin' => array('application/octet-stream', 'application/x-macbinary'),
        'bmp' => array('image/bmp'),
        'cab' => array('application/x-shockwave-flash'),
        'c' => array('text/plain'),
        'c++' => array('text/plain'),
        'class' => array('application/java'),
        'css' => array('text/css'),
        'csv' => array('text/comma-separated-values'),
        'cdr' => array('application/cdr'),
        'doc' => array('application/msword'),
        'dot' => array('application/msword'),
        'docx' => array('application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
        'dotx' => array('application/vnd.openxmlformats-officedocument.wordprocessingml.template'),
        'dwg' => array('application/acad'),
        'eps' => array('application/postscript'),
        'exe' => array('application/octet-stream'),
        'gif' => array('image/gif'),
        'gz' => array('application/gzip'),
        'gtar' => array('application/x-gtar'),
        'f4v' => array('video/mp4'),
        'flv' => array('video/x-flv'),
        'fh4' => array('image/x-freehand'),
        'fh5' => array('image/x-freehand'),
        'fhc' => array('image/x-freehand'),
        'help' => array('application/x-helpfile'),
        'hlp' => array('application/x-helpfile'),
        'html' => array('text/html'),
        'htm' => array('text/html'),
        'ico' => array('image/x-icon'),
        'imap' => array('application/x-httpd-imap'),
        'inf' => array('application/inf'),
        'jpe' => array('image/jpeg'),
        'jpeg' => array('image/jpeg'),
        'jpg' => array('image/jpeg'),
        'js' => array('application/x-javascript'),
        'java' => array('text/x-java-source'),
        'latex' => array('application/x-latex'),
        'log' => array('text/plain'),
        'm3u' => array('audio/x-mpequrl'),
        'midi' => array('audio/midi'),
        'mid' => array('audio/midi'),
        'mov' => array('video/quicktime'),
        'mp3' => array('audio/mpeg'),
        'm4v' => array('video/mp4'),
        'mp4' => array('video/mp4', 'audio/mp4', 'audio/m4a'),
        'mpeg' => array('video/mpeg'),
        'mpg' => array('video/mpeg'),
        'mp2' => array('video/mpeg'),
        'ogg' => array('video/ogg', 'application/ogg', 'audio/ogg'),
        'ogm' => array('video/ogg'),
        'ogv' => array('video/ogg'),
        'odt' => array('application/vnd.oasis.opendocument.text', 'application/x-vnd.oasis.opendocument.text'),
        'odp' => array('application/vnd.oasis.opendocument.presentation'),
        'ods' => array('application/vnd.oasis.opendocument.spreadsheet'),
        'phtml' => array('application/x-httpd-php'),
        'php' => array('application/x-httpd-php'),
        'pdf' => array('application/pdf'),
        'pgp' => array('application/pgp'),
        'png' => array('image/png'),
        'pps' => array('application/mspowerpoint', 'application/vnd.ms-powerpoint'),
        'ppt' => array('application/mspowerpoint', 'application/vnd.ms-powerpoint'),
        'pptx' => array('application/vnd.openxmlformats-officedocument.presentationml.presentation'),
        'ppz' => array('application/mspowerpoint'),
        'pot' => array('application/mspowerpoint'),
        'ps' => array('application/postscript'),
        'qt' => array('video/quicktime'),
        'qd3d' => array('x-world/x-3dmf'),
        'qd3' => array('x-world/x-3dmf'),
        'qxd' => array('application/x-quark-express'),
        'rar' => array('application/x-rar-compressed'),
        'ra' => array('audio/x-realaudio'),
        'ram' => array('audio/x-pn-realaudio'),
        'rm' => array('audio/x-pn-realaudio'),
        'rtf' => array('text/rtf'),
        'spr' => array('application/x-sprite'),
        'sprite' => array('application/x-sprite'),
        'stream' => array('audio/x-qt-stream'),
        'swf' => array('application/x-shockwave-flash'),
        'svg' => array('text/xml-svg'),
        'sgml' => array('text/x-sgml'),
        'sgm' => array('text/x-sgml'),
        'tar' => array('application/x-tar'),
        'tiff' => array('image/tiff'),
        'tif' => array('image/tiff'),
        'tgz' => array('application/x-compressed'),
        'tex' => array('application/x-tex'),
        'txt' => array('text/plain'),
        'vob' => array('video/x-mpg'),
        'wav' => array('audio/x-wav'),
        'webm' => array('video/webm'),
        'wrl' => array('model/vrml', 'x-world/x-vrml'),
        'xla' => array('application/msexcel', 'application/vnd.ms-excel'),
        'xlt' => array('application/msexcel', 'application/vnd.ms-excel'),
        'xls' => array('application/msexcel', 'application/vnd.ms-excel'),
        'xlsx' => array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
        'xltx' => array('application/vnd.openxmlformats-officedocument.spreadsheetml.template'),
        'xlc' => array('application/vnd.ms-excel'),
        'xml' => array('text/xml'),
        'zip' => array('application/x-zip-compressed', 'application/x-zip', 'application/zip'),
    );
}
