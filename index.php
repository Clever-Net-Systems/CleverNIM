<?php

// This is test mode (YII_DEBUG & YII_TRACE_LEVEL are removed in production mode)
defined('YII_DEBUG') or define('YII_DEBUG', true);
// This is online mode (set to false to enable fetching jQuery locally)
defined('YII_ONLINE') or define('YII_ONLINE', true);
// Specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

$yii = YII_DEBUG ? dirname(__FILE__) . '/framework/yii.php' : dirname(__FILE__) . '/framework/yiilite.php';
$config = dirname(__FILE__) . '/config/main.php';

require_once($yii);
Yii::createWebApplication($config)->run();
