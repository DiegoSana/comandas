<?php

// change the following paths if necessary
$yii='/var/www/yii_framework/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
define('DEFAULT_SUBDOMINIO', 'www');
define('DEFAULT_URL', 'http://'.DEFAULT_SUBDOMINIO.'.comandas.com.ar');

ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_DEPRECATED);

require_once($yii);
Yii::createWebApplication($config)->run();
?>
