<?php

// Load common config
$commonconfig = require(dirname(__FILE__) . '/common.php');

$localconfig = array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'CleverNIM',
	'homeUrl' => '/tag/admin',
	'components' => array(
		'db' => array(
			'connectionString' => 'mysql:host=localhost;dbname=clevernim',
			'username' => 'clevernim',
			'password' => 'clevernim',
		),
		'puppetdb' => array(
			'connectionString' => 'pgsql:host=10.0.2.15;dbname=puppetdb',
			'username' => 'puppetdb',
			'password' => 'puppetdb',
			'class' => 'CDbConnection',
		),
	),

	'params' => array(
		'adminEmail' => '',
		'ldap' => array(
			'version' => 3,
			'host' => '',
			'port' => 389,
			'base' => '',
			'start_tls' => true,
		),
	),
);

// Merge common and local configuaration
return merge_config($commonconfig, $localconfig);
