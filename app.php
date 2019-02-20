<?php
	define ('APP_DEBUG',true);
	define('APP_NAME','App');
	define('APP_PATH','./App/');
	// define('BIND_MODULE', 'Home');
	// require('./ThinkPHP/ThinkPHP.php');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT');
	require('./ThinkPHP/ThinkPHP.php');