<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用入口文件
// 检测PHP环境
if (version_compare ( PHP_VERSION, '5.3.0', '<' ))
	die ( 'require PHP > 5.3.0 !' );
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define ( 'APP_DEBUG', True );
define ( 'HTML_CACHE_ON', false );

// 定义应用目录
define ( 'APP_PATH', './MusicSite/' );
// define('BIND_MODULE','Admin');
// 公共目录
define ( 'COMMON_PATH', './Common/' );
// 设置全局编码格式
header ( 'Content-Type:text/html; charset=utf-8' );
// 引入ThinkPHP入口文件
require '/ThinkPHP/ThinkPHP.php';
 