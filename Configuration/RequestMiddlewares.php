<?php

return [
    'frontend' => [
        'felixnagel/pluploadfe/eid' => [
            'target' => \FelixNagel\Pluploadfe\Middleware\Upload::class,
            'after' => [
                'typo3/cms-frontend/authentication',
            ],
            'before' => [
                // @todo Remove fallback when TYPO3 9.2-10.3 is no longer needed
                version_compare(TYPO3_version, '10.3', '<=')
                    ? 'typo3/cms-frontend/site' : 'typo3/cms-frontend/site-resolver',
            ],
        ],
    ],
];
