<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

$config = parse_ini_file(dirname(__FILE__).'/config.ini', true);
$connconf = $config['mysql'];
$giiconf = $config['gii'];

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
return array(
	'language' => 'es',
	'theme'=>'bootstrap',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Dashboard Gestión Clientes',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.controllers.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>$giiconf["gii_password"],
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
			
		
		'clientScript'=>array(
			'packages'=>array(
				'highcharts'=>array(
					'baseUrl'=> "",
					'js'=>array('js/highcharts/highcharts.js', 
								'js/highcharts/highcharts-more.js',
								'js/highcharts/modules/exporting.js',
								'js/highcharts/modules/solid-gauge.src.js',
								),
				)
			),
		),
		
		'bootstrap'=>array(
				'class'=>'bootstrap.components.Bootstrap',
		),
		'user'=>array(
			// There you go, use our 'extended' version
			'class'=>'application.components.WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>false,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
	
		'db'=>array(
			'connectionString' => 'mysql:host='.$connconf['mysql_host'].';dbname='.$connconf['mysql_database'],
			'emulatePrepare' => true,
			'username' => $connconf['mysql_user'],
			'password' => $connconf['mysql_password'],
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);