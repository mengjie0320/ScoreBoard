<?php
	define ('APP_DEBUG',true);
	define('APP_NAME','Cloud');
	define('APP_PATH','./Cloud/');
	// define('BIND_MODULE', 'Home');
	header('Content-type:application/javascript');
	header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT');
	require('./ThinkPHP/ThinkPHP.php');
