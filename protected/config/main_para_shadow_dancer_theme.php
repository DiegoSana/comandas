<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Comandas',
        //'theme'=>'mobile',
	// preloading 'log' component
	'preload'=>array('log'),
        'theme'=>'shadow_dancer',
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
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'com22',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
                'image'=>array(
                    'class'=>'application.extensions.image.CImageComponent',
                    'driver'=>'GD',
                ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
                /*'user' => array(
                    'class' => 'WebUser',
                ),*/
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
                /*'clientScript'=>array(
                    'coreScriptPosition'=>CClientScript::POS_HEAD,
                    'packages'=>array(
                        'jquery'=>array(
                            'baseUrl'=>'plugins/jquery/1.11.2',
                            'js'=>array('jquery-1.11.2.min.js'),
                        )
                    ),
                ),*/
                'widgetFactory'=>array(
                    'widgets'=>array(
                        'CGridView'=>array(
                            'htmlOptions'=>array('cellspacing'=>'0','cellpadding'=>'0'),
                                                'itemsCssClass'=>'item-class',
                                                'pagerCssClass'=>'pager-class'
                        ),
                        'CJuiTabs'=>array(
                            'htmlOptions'=>array('class'=>'shadowtabs'),
                        ),
                        'CJuiAccordion'=>array(
                            'htmlOptions'=>array('class'=>'shadowaccordion'),
                        ),
                        'CJuiProgressBar'=>array(
                           'htmlOptions'=>array('class'=>'shadowprogressbar'),
                        ),
                        'CJuiSlider'=>array(
                            'htmlOptions'=>array('class'=>'shadowslider'),
                        ),
                        'CJuiSliderInput'=>array(
                            'htmlOptions'=>array('class'=>'shadowslider'),
                        ),
                        'CJuiButton'=>array(
                            'htmlOptions'=>array('class'=>'shadowbutton'),
                        ),
                        'CJuiButton'=>array(
                            'htmlOptions'=>array('class'=>'shadowbutton'),
                        ),
                        'CJuiButton'=>array(
                            'htmlOptions'=>array('class'=>'button green'),
                        ),
                    ),
                ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'diegohsanabria@gmail.com',
	),
);
