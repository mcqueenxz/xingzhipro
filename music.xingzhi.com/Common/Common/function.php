<?php
/**
 * 获取文件扩展名.
 * @author 邢志 2017年11月14日 上午11:06:53
 * @param string $filename 文件全路径.
 * @return string
 */
function get_file_ext($filename) {
	$start = strpos ( $filename, '.' );
	$lens = strlen ( $filename );
	return substr ( $filename, $start, $lens - 1 );
}

/**
 * 创建guid值.
 *
 * @author 邢志 2017年11月14日 上午11:08:23
 * @param number $format
 *        	格式化标识. 1 标识不带‘-’字符.
 * @return string
 */
function create_guid($format = 1) {
	$charid = strtolower ( md5 ( uniqid ( mt_rand (), true ) ) );
	$hyphen = ($format == 0) ? chr ( 45 ) : ""; // "-"
	$uuid = "" . // chr(123) "{"
	substr ( $charid, 0, 8 ) . $hyphen . substr ( $charid, 8, 4 ) . $hyphen . substr ( $charid, 12, 4 ) . $hyphen . substr ( $charid, 16, 4 ) . $hyphen . substr ( $charid, 20, 12 );
	return $uuid;
}

// 格式化时间-带毫秒
function format_date($format = 'u', $utimestamp = null) {
	if (is_null ( $utimestamp )) {
		$utimestamp = microtime ( true );
	}
	$timestamp = floor ( $utimestamp );
	$milliseconds = round ( ($utimestamp - $timestamp) * 1000000 );
	return date ( preg_replace ( '`(?<!\\\\)u`', $milliseconds, $format ), $timestamp );
}

/**
 * 获取上传文件信息
 *
 * @param string $objName
 * @return string
 */
function get_uploadfile_info($objName) {
	$info = array ();
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
	return json_encode ( array (
			'result' => $result
	) );
}

/**
 * 获取网络请求参数
 *
 * @param $key 参数KEY名称.
 */
function get_url_param($key) {
	$param = "";
	if (is_string ( $_REQUEST [$key] )) {
		$param = $_REQUEST [$key];
	}
	return $param;
}

/**
 * 获取MP3文件长度
 */
function get_mp3_timeout($file) {
	$player = new COM ( "WMPlayer.OCX" );
	$media = $player->newMedia ( $file );
	return $media->duration;
}

/**
 * 转化秒到时间
 *
 * @param int $seconds
 * @return string
 */
function change_time_type($seconds) {
	if ($seconds > 3600) {
		$hours = intval ( $seconds / 3600 );
		$minutes = $seconds % 3600;
		$time = $hours . ":" . gmstrftime ( '%M:%S', $minutes );
	} else {
		$time = gmstrftime ( '%H:%M:%S', $seconds );
	}
	return $time;
}

/**
 * 设置 window中文路径.
 *
 * @param string $path
 */
function set_iconv_winpath($path) {
	return iconv ( 'UTF-8', 'GB18030', $path );
}

/**
 * 获取中文首字母
 *
 * @param string $str
 * @return string
 */
function getFirstCharter($str) {
	if (empty ( $str )) {
		return '';
	}
	$fchar = ord ( $str {0} );
	if ($fchar >= ord ( 'A' ) && $fchar <= ord ( 'z' )) {
		return strtoupper ( $str {0} );
	}
	$s1 = iconv ( 'UTF-8', 'gb2312', $str );
	$s2 = iconv ( 'gb2312', 'UTF-8', $s1 );
	$s = $s2 == $str ? $s1 : $str;
	$asc = ord ( $s {0} ) * 256 + ord ( $s {1} ) - 65536;
	if ($asc >= - 20319 && $asc <= - 20284) {
		return 'A';
	}
	if ($asc >= - 20283 && $asc <= - 19776) {
		return 'B';
	}
	if ($asc >= - 19775 && $asc <= - 19219) {
		return 'C';
	}
	if ($asc >= - 19218 && $asc <= - 18711) {
		return 'D';
	}
	if ($asc >= - 18710 && $asc <= - 18527) {
		return 'E';
	}
	if ($asc >= - 18526 && $asc <= - 18240) {
		return 'F';
	}
	if ($asc >= - 18239 && $asc <= - 17923) {
		return 'G';
	}
	if ($asc >= - 17922 && $asc <= - 17418) {
		return 'H';
	}
	if ($asc >= - 17417 && $asc <= - 16475) {
		return 'J';
	}
	if ($asc >= - 16474 && $asc <= - 16213) {
		return 'K';
	}
	if ($asc >= - 16212 && $asc <= - 15641) {
		return 'L';
	}
	if ($asc >= - 15640 && $asc <= - 15166) {
		return 'M';
	}
	if ($asc >= - 15165 && $asc <= - 14923) {
		return 'N';
	}
	if ($asc >= - 14922 && $asc <= - 14915) {
		return 'O';
	}
	if ($asc >= - 14914 && $asc <= - 14631) {
		return 'P';
	}
	if ($asc >= - 14630 && $asc <= - 14150) {
		return 'Q';
	}
	if ($asc >= - 14149 && $asc <= - 14091) {
		return 'R';
	}
	if ($asc >= - 14090 && $asc <= - 13319) {
		return 'S';
	}
	if ($asc >= - 13318 && $asc <= - 12839) {
		return 'T';
	}
	if ($asc >= - 12838 && $asc <= - 12557) {
		return 'W';
	}
	if ($asc >= - 12556 && $asc <= - 11848) {
		return 'X';
	}
	if ($asc >= - 11847 && $asc <= - 11056) {
		return 'Y';
	}
	if ($asc >= - 11055 && $asc <= - 10247) {
		return 'Z';
	}
	return null;
}
function unescape($str) {
	$ret = '';
	$len = strlen ( $str );
	for($i = 0; $i < $len; $i ++) {
		if ($str [$i] == '%' && $str [$i + 1] == 'u') {
			$val = hexdec ( substr ( $str, $i + 2, 4 ) );
			if ($val < 0x7f) {
				$ret .= chr ( $val );
			} else if ($val < 0x800) {
				$ret .= chr ( 0xc0 | ($val >> 6) ) . chr ( 0x80 | ($val & 0x3f) );
			} else {
				$ret .= chr ( 0xe0 | ($val >> 12) ) . chr ( 0x80 | (($val >> 6) & 0x3f) ) . chr ( 0x80 | ($val & 0x3f) );
			}
			$i += 5;
		} elseif ($str [$i] == '%') {
			$ret .= urldecode ( substr ( $str, $i, 3 ) );
			$i += 2;
		} else {
			$ret .= $str [$i];
		}
	}
	return $ret;
}
/**
 * 加密解密函数
 *
 * @param string $string
 *        	需要加密的字符串
 * @param string $operation
 *        	模式：E表示加密，D表示解密
 * @param string $key
 *        	密匙
 * @return string
 */
function encrypt($string, $operation, $key = '') {
	$key = md5 ( $key );
	$key_length = strlen ( $key );
	$string = $operation == 'D' ? base64_decode ( $string ) : substr ( md5 ( $string . $key ), 0, 8 ) . $string;
	$string_length = strlen ( $string );
	$rndkey = $box = array ();
	$result = '';
	for($i = 0; $i <= 255; $i ++) {
		$rndkey [$i] = ord ( $key [$i % $key_length] );
		$box [$i] = $i;
	}
	for($j = $i = 0; $i < 256; $i ++) {
		$j = ($j + $box [$i] + $rndkey [$i]) % 256;
		$tmp = $box [$i];
		$box [$i] = $box [$j];
		$box [$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i ++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box [$a]) % 256;
		$tmp = $box [$a];
		$box [$a] = $box [$j];
		$box [$j] = $tmp;
		$result .= chr ( ord ( $string [$i] ) ^ ($box [($box [$a] + $box [$j]) % 256]) );
	}
	if ($operation == 'D') {
		if (substr ( $result, 0, 8 ) == substr ( md5 ( substr ( $result, 8 ) . $key ), 0, 8 )) {
			return substr ( $result, 8 );
		} else {
			return '';
		}
	} else {
		return str_replace ( '=', '', base64_encode ( $result ) );
	}
}
/**
 * 获取本机IP地址
 *
 * @author 邢志 2018年6月25日 下午9:05:51
 */
function get_local_ip() {
	$ipadd = 'http://127.0.0.1';
	exec ( "ipconfig", $out, $stats );
	if (! empty ( $out )) {
		$ipadd = 'http://' . trim ( explode ( ":", $out [8] ) [1] );
	}
	return $ipadd;
}
