<?php

// 获取文件扩展名.
function get_file_ext($filename) {
    $start = strpos($filename, '.');
    $lens = strlen($filename);
    return substr($filename, $start, $lens - 1);
}

// 创建guid值.
function create_guid($format = 1) {
    // strtoupper
    $charid = strtolower(md5(uniqid(mt_rand(), true)));

    $hyphen = ($format == 0) ? chr(45) : ""; // "-"
    $uuid = "" . // chr(123) "{"
            substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
    return $uuid;
}

// 格式化时间-带毫秒
function format_date($format = 'u', $utimestamp = null) {
    if (is_null($utimestamp)) {
        $utimestamp = microtime(true);
    }
    $timestamp = floor($utimestamp);
    $milliseconds = round(($utimestamp - $timestamp) * 1000000);
    return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
}

/**
 * 获取上传文件信息
 * 
 * @param unknown $objName
 *        	文件file名称.
 * @return multitype:NULL
 */
function get_uploadfile_info($objName) {
    $info = array();
    // 原始文件名
    $info ['original_name'] = $_FILES [$objName] ['name'];
    // 临时图片路径
    $info ['temp_img'] = $_FILES [$objName] ['tmp_name'];
    // 图片大小
    $info ['img_size'] = $_FILES [$objName] ['size'];
    return $info;
}

/**
 * 输出json数组
 */
function outjson($result) {
    return json_encode(array(
        'result' => $result
    ));
}

/**
 * 获取网络请求参数
 * 
 * @param $key 参数KEY名称.        	
 */
function get_url_param($key) {
    $param = $_POST [$key];
    if (empty($param)) {
        $param = $_GET [$key];
        if (empty($param)) {
            $param = $_REQUEST [$key];
            if (empty($param)) {
                $param = "";
            }
        }
    }
    return $param;
}

/**
 * 获取MP3文件长度
 */
function get_mp3_timeout($file) {
    $player = new COM("WMPlayer.OCX");
    $media = $player->newMedia($file);
    return $media->duration;
}

/**
 * 转化秒到时间
 * 
 * @param unknown $seconds        	
 * @return string
 */
function change_time_type($seconds) {
    if ($seconds > 3600) {
        $hours = intval($seconds / 3600);
        $minutes = $seconds % 3600;
        $time = $hours . ":" . gmstrftime('%M:%S', $minutes);
    } else {
        $time = gmstrftime('%H:%M:%S', $seconds);
    }
    return $time;
}

/**
 * 设置 window中文路径.
 * @param unknown $path
 */
function set_iconv_winpath($path) {
    return iconv('UTF-8', 'GB18030', $path);
}
/**
 * 获取本机IP地址
 * @author 邢志 2018年6月25日 下午9:05:51
 */
function get_local_ip(){
	$ipadd = 'http://127.0.0.1';
	exec("ipconfig", $out, $stats);
	if (!empty($out)) {
		$ipadd = 'http://'.trim(explode(":",$out[39])[1]);
	}
	return $ipadd;
}
