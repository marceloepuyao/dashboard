<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
$config = parse_ini_file(dirname(__FILE__).'/config.ini', true);
$connconf = $config['mysql'];
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
		
		'db'=>array(
			'connectionString' => 'mysql:host='.$connconf['mysql_host'].';dbname='.$connconf['mysql_database'],
			'emulatePrepare' => true,
			'username' => $connconf['mysql_user'],
			'password' => $connconf['mysql_password'],
			'charset' => 'utf8',
		),
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);