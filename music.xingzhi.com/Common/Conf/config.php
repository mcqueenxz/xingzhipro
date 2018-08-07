<?php

// '配置项'=>'配置值'
return array (
		'SESSION_AUTO_START' => true, // 开启SESSION
		                               // 伪静态后缀
		'URL_HTML_SUFFIX' => 'shtml',
		'DEFAULT_V_LAYER' => 'View', // 设置默认视图层名称

		// Mysql 数据库配置.
		'DB_TYPE' => 'mysql', // 数据库类型
		'DB_HOST' => '127.0.0.1', // 服务器地址
		'DB_NAME' => 'musicdb', // 数据库名
		'DB_USER' => 'root', // 用户名
		'DB_PWD' => 'xingzhi', // 密码
		'DB_PORT' => 3306, // 端口
		'DB_PARAMS' => array (), // 数据库连接参数
		'DB_PREFIX' => '', // 数据库表前缀
		'DB_CHARSET' => 'utf8', // 字符集
		'DB_DEBUG' => TRUE, // 数据库调试模式 开启后可以记录SQL日志
		                     // Mongo 数据库配置
		                     // 'DB_TYPE' => 'mongo',
		                     // 'DB_HOST' => '127.0.0.1',
		                     // 'DB_NAME' => 'xingzhidb',
		                     // 'DB_USER' => '',
		                     // 'DB_PWD' => '',
		                     // 'DB_PORT' => '27017',
		                     // 'DB_PREFIX' => '',
		                     // 'DB_CHARSET' => 'utf8',
		                     // 'DB_DEBUG' => false,

		// Mongo 配置
		'MONGO_HOST' => '127.0.0.1',
		'MONGO_PORT' => '27017',
		'MONGO_DBNAME' => 'xingzhidb',

		// Redis 配置
		'REDIS_HOST' => '127.0.0.1',
		'REDIS_PORT' => 6379,
		'REDIS_AUTH' => 'xingzhi',
		'REDIS_ISOPEN' => false, // 是否开启Redis缓存.

		// 端口
		'PORTS' => '9001',

		// 图片域名.
		'IMGDOMAIN' => 'http://127.0.0.1:9001/albumnpic',
		// 歌曲文件域名.
		'MUSICDOMAIN' => 'http://127.0.0.1:9001',

		// 存储 音乐图片 路径.
		'SAVE_ROOT_IMAGE_MUSIC' => 'E:/www2/music/albumnpic',
		// 存储 音乐文件 路径.
		'SAVE_ROOT_MUSIC_FILE' => 'E:/www2/music',

		// 缩略图宽高比例.
		'THUMBNAIL_WIDTH' => 210,
		'THUMBNAIL_HEIGHT' => 262,
		'SHOW_ROWS' => 18,

		// 无数据配置信息
		'NOPAGE' => '这是一条长路它没有终点.',

		// 允许访问的模块
		'MODULE_ALLOW_LIST' => array (
				'Home'
		),

		// 默认访问模块.
		'DEFAULT_CONTROLLER' => 'Music',
		// 加密权限KEY.
		'ALC_PASSWD_KEY' => 'MUSIC',

		/**
		 * *********Redis 缓存节点Key*********************
		 */
		'PRIM_KEY_SONG' => 'songdatas',
		'HOST_SONGS' => 'HOST_SONGS',
		'RECORD_SONGS' => 'RECORD_SONGS'
);
