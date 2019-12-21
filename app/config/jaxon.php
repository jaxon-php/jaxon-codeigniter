<?php

$config['app'] = [
    'directories' => [
        rtrim(APPPATH, '/') . '/jaxon/app' => [
            'namespace' => '\\Jaxon\\App',
            // 'separator' => '', // '.' or '_'
            // 'protected.' => [],
        ],
    ],
];
$config['lib'] = [
    'core' => [
        'language' => 'en',
        'encoding' => 'UTF-8',
        'request' => [
            'uri' => 'jaxon/process',
        ],
        'prefix' => [
            'class' => '',
        ],
        'debug' => [
            'on' => false,
            'verbose' => false,
        ],
        'error' => [
            'handle' => false,
        ],
    ],
    'js' => [
        'lib' => [
            // 'uri' => '',
        ],
        'app' => [
            // 'uri' => '',
            // 'dir' => '',
            'export' => false,
            'minify' => false,
            'options' => '',
        ],
    ],
];
