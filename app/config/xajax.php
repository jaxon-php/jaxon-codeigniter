<?php

$config['app'] = array(
	// 'route' => '',
	// 'dir' => '',
	// 'namespace' => '',
	// 'excluded' => array(),
);
$config['lib'] = array(
	'core' => array(
		'language' => 'en',
		'encoding' => 'UTF-8',
		'prefix' => array(
			'class' => 'Xajax',
			'function' => 'xajax_',
		),
		'debug' => array(
			'on' => false,
			'verbose' => false,
		),
		'error' => array(
			'handle' => false,
		),
	),
	'js' => array(
		'lib' => array(
			// 'uri' => '',
		),
		'app' => array(
			// 'uri' => '',
			// 'dir' => '',
			'export' => false,
			'minify' => false,
			'options' => '',
		),
	),
);
