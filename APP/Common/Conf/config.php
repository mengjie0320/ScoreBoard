<?php
return array(
    //'配置项'=>'配置值'
	'DB_TYPE'   => 'mysqli', // 数据库类型
	'DB_HOST'   => '127.0.0.1', // 服务器地址
	'DB_NAME'   => 'scoreboard', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => '1851432302',  // 密码
	'DB_PORT'   => '3306', // 端口
	//'DB_PREFIX' => 'ip_', // 数据库表前缀
	'SHOW_PAGE_TRACE' =>false,  //
	'SHOW_ERROR_MSG' =>    false,
	'ERROR_MESSAGE'  =>    '发生错误！',
	'URL_HTML_SUFFIX'=>'html|shtml|xml',
	'URL_DENY_SUFFIX' => 'pdf|ico|png|gif|jpg',
    'URL_ROUTER_ON' => true, // url路由开关
	// 'MODULE_ALLOW_LIST' => array('Home','Car','Admin','Install','User', 'Api'), // 允许访问的模块
	// 'URL_MODEL' => '2', //URL模式
	/* 缩短路径 */
	// 'URL_ROUTE_RULES' => array('/^index$/i' => 'Index/index'),
	'HTML_CACHE_ON'     =>    true, 
	// 开启静态缓存
	'HTML_CACHE_TIME'   =>    60,   
	// 全局静态缓存有效期（秒）
	'HTML_FILE_SUFFIX'  =>    '.html', 
	// 设置静态缓存文件后缀
	//'HTML_CACHE_RULES'  =>     array(  // 定义静态缓存规则     // 定义格式1 数组方式     '静态地址'    =>     array('静态规则', '有效期', '附加规则'),      // 定义格式2 字符串方式     '静态地址'    =>     '静态规则', )
    'DB_SQL_BUILD_CACHE' => true,//数据库缓存配置
    'DB_SQL_BUILD_QUEUE' => 'xcache',//数据库缓存配置
    'DB_SQL_BUILD_LENGTH' => 20, //数据库缓存配置
);