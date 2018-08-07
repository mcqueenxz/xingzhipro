<?php

return array(
    //'配置项'=>'配置值'
    'SESSION_AUTO_START' => true,
    'MODULE_ALLOW_LIST' => array('Home'),
    'DEFAULT_V_LAYER' => 'View', //设置默认视图层名称
    
    'DEFAULT_MODULE' => 'Home',
    'DEFAULT_CONTROLLER' => 'Reailwayinfo',
    
    //数据库配置
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'railwaydb', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => 'xingzhi', // 密码
    'DB_PORT' => 3306, // 端口
    'DB_PARAMS' => array(), // 数据库连接参数
    'DB_PREFIX' => '', // 数据库表前缀
    'DB_CHARSET' => 'utf8', // 字符集
    'DB_DEBUG' => TRUE, // 数据库调试模式 开启后可以记录SQL日志
    
    // Mongo 数据库配置
// 	'DB_TYPE' => 'mongo',
// 	'DB_HOST' => '127.0.0.1',
// 	'DB_NAME' => 'xingzhidb',
// 	'DB_USER' => '',
// 	'DB_PWD' => '',
// 	'DB_PORT' => '27017',
// 	'DB_PREFIX' => '',
// 	'DB_CHARSET' => 'utf8',
// 	'DB_DEBUG' => false,
		
    //图片域名.
    'IMGDOMAIN' => 'http://127.0.0.1:9002',

    //配置信息
    'NOPAGE' => '这是一条长路它没有终点.',
);
