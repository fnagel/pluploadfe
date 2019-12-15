<?php

return [
    'frontend' => [
        'felixnagel/pluploadfe/eid' => [
            'target' => \FelixNagel\Pluploadfe\Middleware\Upload::class,
            'after' => [
                'typo3/cms-frontend/authentication',
            ]
        ],
    ],
];
