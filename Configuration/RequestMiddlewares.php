<?php

use FelixNagel\Pluploadfe\Middleware\Upload;

return [
    'frontend' => [
        'felixnagel/pluploadfe/eid' => [
            'target' => Upload::class,
            'after' => [
                'typo3/cms-frontend/authentication',
            ],
            'before' => [
                'typo3/cms-frontend/base-redirect-resolver',
                'typo3/cms-redirects/redirecthandler',
                // @todo Remove fallback when TYPO3 10 is no longer needed
                'typo3/cms-frontend/site-resolver',
            ],
        ],
    ],
];
