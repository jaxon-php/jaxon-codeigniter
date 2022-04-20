<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Jaxon extends BaseConfig
{
    public $app = [
        'directories' => [
            rtrim(APPPATH, '/') . '/jaxon/ajax' => [
                'namespace' => '\\Jaxon\\Ajax',
                // 'separator' => '', // '.' or '_'
                // 'protected.' => [],
            ],
        ],
    ];

    public $lib = [
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
}
