<?php
	define ('APP_DEBUG',true);
	define('APP_NAME','SBoard');
	define('APP_PATH','./SBoard/');
	// define('BIND_MODULE', 'Home');RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
	header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT');
	require('./ThinkPHP/ThinkPHP.php');