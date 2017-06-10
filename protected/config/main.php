<?php

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Comandas.com.ar',
        'theme'=>'ace-master',
	// preloading 'log' component
	'preload'=>array('log'),
        'defaultController' => 'menu',
        'aliases' => array(
            // yiifoundation configuration
            'foundation' => 'application.extensions.yiifoundation',
        ),
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
        'language' => 'es',
	'modules'=>array(
                'wsafip'=>array(
                    //'class' => 'aplication.modules.wsafip.WsafipModule',
                    'components'=>array(
                        'wsaa'=>'wsafip.components.afip.WSAA',
                        'wsmtxca'=>'wsafip.components.afip.WSMTXCA',
                        'wsafipfactory'=>'wsafip.components.afip.WsAfipFactory'
                    )
                ),
                /*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'com22',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(
                'session' => array(
                   'cookieParams' => array('domain' => '.comandas.com.ar','path'=>'/'),
                ),
                'image'=>array(
                    'class'=>'application.extensions.image.CImageComponent',
                    'driver'=>'GD',
                ),
		'user'=>array(
                    // enable cookie-based authentication
                    'allowAutoLogin'=>true,
                    'identityCookie' => array(
                        'name' => '_identity',
                        'domain' => '.comandas.com.ar',
                        'path'=>'/'
                    ),
                    'loginUrl'=>array('site/home'),
		),
                'request'=>array(
                    'csrfCookie'=>array(
                        'name' => '_csrf',
                        'path' => '/',
                        'domain' => ".comandas.com.ar",
                    )
                ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(			
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
                                //'<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
                
		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
                /*'authManager'=>array(
                    'class'=>'CPhpAuthManager',
                    'defaultRoles'=>array('comensal'),
                ),*/
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
		'adminEmail'=>'info.comandas@gmail.com',
	),
);
