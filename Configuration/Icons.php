<?php

use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;

return [
    'extensions-pluploadfe-config' => [
        'provider' => BitmapIconProvider::class,
        'source' => 'EXT:pluploadfe/Resources/Public/Icons/icon_tx_pluploadfe_config.gif',
    ],
    'extensions-pluploadfe-wizard' => [
        'provider' => BitmapIconProvider::class,
        'source' => 'EXT:pluploadfe/Resources/Public/Icons/Extension.png',
    ],
];
