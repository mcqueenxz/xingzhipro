<?php

namespace Home\Controller;

use Think\Controller;
use Home\Model\SingerModel;
use Home\Model\SingeralbumModel;
use Home\Model\SongModel;
use Org\Util\Redis;

class ApimusicController extends Controller {

	/**
	 * 结果数组
	 *
	 * @var string
	 */
	private $result = array ();
	/**
	 * 对磁盘歌曲重命名
	 *
	 * @author 邢志 2017年11月26日 下午4:34:03
	 */
	public function renametodisk() {
		$tspan = get_url_param ( "tspan" );
		if (empty ( $tspan )) {
			echo "no" . time ();
		}
		// 但前时间 - 时间戳
		if (time () - $tspan > 300) {
			echo 'ok' . (time () - $tspan);
		} else {
			echo '超时';
		}
	}

	/**
	 * 删除歌曲信息
	 *
	 * @author 邢志 2017年10月4日上午9:29:04
	 */
	public function deletesong() {
		$songid = get_url_param ( 'sid' );
		if (empty ( $songid )) {
			$this->result ['result'] = 0;
			$this->result ['msg'] = '歌曲主键错误.';
		} else {
			$songdb = new SongModel ();
			$songarray = $songdb->get_song_byid ( $songid );
			if (! empty ( $songarray )) {
				$rs = $songdb->deletesong ( $songid );
				$this->result ['result'] = $rs;
				$path_root = C ( 'SAVE_ROOT_MUSIC_FILE' );
				// 在utf-8编码时，对中文路径的文件，需要先做gbk编码处理.
				$delresult = @unlink ( iconv ( 'utf-8', 'gbk', $path_root . $songarray [0] ['path'] ) );
				if ($delresult) {
					$this->result ['msg'] = '歌曲【' . $songarray [0] ['songname'] . '】删除完毕.';
				} else {
					$this->result ['msg'] = '歌曲【' . $songarray [0] ['songname'] . '】删除数据.但文件无法删除.';
				}
			}
		}
		echo json_encode ( $this->result );
	}
	/**
	 * 获取作词人信息
	 *
	 * @author 邢志 2017年9月24日 下午5:08:58
	 */
	public function get_byword() {
		$rows = get_url_param ( "rows" );
		$songdb = new SongModel ();
		$this->result ['result'] = $songdb->get_byword_list ( $rows );
		echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
	}

	/**
	 * 获取歌曲
	 */
	public function search_song() {
		$key = get_url_param ( "key" );
		$index = get_url_param ( "index" );
		$rows = get_url_param ( "rows" );
		$songdb = new SongModel ();
		$this->result ['result'] = $songdb->search_song ( $key, $index, $rows );
		$this->result ['total'] = $songdb->search_song_total ( $key ) [0] ['total'];
		echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
	}

	/**
	 * 设置歌曲长度字段
	 */
	public function set_song_duration() {
		$sid = get_url_param ( "sid" );
		$duration = get_url_param ( "tims" );
		$songdb = new SongModel ();
		$this->result = $songdb->set_song_duration ( $sid, $duration );
		echo $this->get_result_array ( $this->result, '' );
	}

	/**
	 * 最近试听歌曲
	 */
	public function get_record_song() {
		$index = get_url_param ( 'index' );
		$rows = get_url_param ( 'rows' );
		$songdb = new SongModel ();
		if (! C ( 'REDIS_ISOPEN' )) {
			$this->result ['result'] = $songdb->get_record_song ( $index, $rows );
			echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
		} else {
			$redisdb = new Redis ( C ( 'REDIS_HOST' ), C ( 'REDIS_PORT' ), C ( 'REDIS_AUTH' ) );
			$values = $redisdb->getHashValueByKey ( C ( 'PRIM_KEY_SONG' ), C ( 'RECORD_SONGS' ) );
			if (strlen ( $values ) <= 0) {
				// 从数据库中读取
				$this->result ['result'] = $songdb->get_record_song ( $index, $rows );
				$redisdb->setHash ( C ( 'PRIM_KEY_SONG' ), C ( 'RECORD_SONGS' ), json_encode ( $this->result ) );
				$values = $redisdb->getHashValueByKey ( C ( 'PRIM_KEY_SONG' ), C ( 'RECORD_SONGS' ) );
			}
			echo get_url_param ( 'callback' ) . "(" . $values . ")";
		}
	}

	/**
	 * 获取最新的歌曲
	 *
	 * @author 邢志 2017年7月27日 下午9:45:14
	 */
	public function get_new_song() {
		$index = get_url_param ( 'index' );
		$rows = get_url_param ( 'rows' );
		$songdb = new SongModel ();
		$this->result ['result'] = $songdb->get_song ( $index, $rows, "id" );
		echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
	}

	/**
	 * 获取热门点击歌曲
	 */
	public function get_hot_song() {
		//$index = get_url_param ( 'index' );
		$rows = get_url_param ( 'rows' );

		if (C ( 'REDIS_ISOPEN' )) {
			$redisdb = new Redis ( C ( 'REDIS_HOST' ), C ( 'REDIS_PORT' ), C ( 'REDIS_AUTH' ) );
			$values = $redisdb->getHashValueByKey ( C ( 'PRIM_KEY_SONG' ), C ( 'HOST_SONGS' ) );
			// 验证Redis 中是否存有缓存数据.
			if (strlen ( $values ) <= 0) {
				$songdb = new SongModel ();
				$this->result ['result'] = $songdb->get_hot_song ( $rows );
				$redisdb->setHash ( C ( 'PRIM_KEY_SONG' ), C ( 'HOST_SONGS' ), json_encode ( $this->result ) );
				// 设置缓存列表的有效时间.
				$redisdb->setKeyExpire ( C ( 'PRIM_KEY_SONG' ), C ( 'REDIS_EXPIRE' ) );
				$values = $redisdb->getHashValueByKey ( C ( 'PRIM_KEY_SONG' ), C ( 'HOST_SONGS' ) );
			}
			echo get_url_param ( 'callback' ) . "(" . $values . ")";
		} else {
			$songdb = new SongModel ();
			$this->result ['result'] = $songdb->get_hot_song ( $rows );
			echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
		}
	}

	/**
	 * 获取专辑列表
	 *
	 * @author xingzhi 2018年8月5日下午6:06:50
	 * @param int $index
	 *        	索引页
	 * @param int $rows
	 *        	显示行
	 * @param int $year
	 *        	年份值.
	 */
	public function album_library($index, $rows, $year) {
		// 获取专辑列表.
		$albumdb = new SingeralbumModel ();
		$array = $albumdb->get_album_condition ( $year, $index, $rows );
		$total = $array ['total'] [0] ['total'];
		$this->result = array (
				'result' => $array ['array'],
				'msg' => '',
				'total' => $total
		);
		echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
	}

	/**
	 * 获取结果数组
	 *
	 * @param string $value
	 *        	结果值
	 * @param string $msg
	 *        	信息
	 */
	private function get_result_array($value, $msg) {
		$result = array (
				'result' => $value,
				'msg' => $msg
		);
		return $result;
	}

	/**
	 * 修改歌曲试听次数.
	 *
	 * @author 邢志 2017年6月27日 下午9:49:54
	 */
	public function set_song_listentime() {
		$songid = get_url_param ( 'songid' );
		$songdb = new SongModel ();
		$this->result = $songdb->update_song_listentime ( $songid );
		echo $this->get_result_array ( $this->result, '' );
	}

	/**
	 * 随机获取歌曲信息
	 *
	 * @author 邢志 2017年6月15日 下午9:49:15
	 */
	public function get_song_random() {
		$songid = get_url_param ( 'sid' );
		$songtype = get_url_param ( 'songtype' );
		if (empty ( $songtype ))
			$songtype = 1;
		$songdb = new SongModel ();
		$this->result ['result'] = $songdb->get_song_random ( $songid, $songtype );
		// 修改歌曲试听次数.
		$songdb->update_song_listentime ( $this->result ['result'] [0] ['id'] );
		echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
	}

	/**
	 * 新增歌曲信息
	 *
	 * @author 邢志 2017年6月8日 下午8:25:12
	 */
	public function add_song() {
		$array = array (
				'result' => 0,
				'msg' => ''
		);
		// 参数
		$singerid = get_url_param ( "sid" );
		$albumnid = get_url_param ( "aid" );
		$songname = trim ( get_url_param ( "songname" ) );
		$byword = get_url_param ( "byword" );
		$bymusic = empty ( get_url_param ( "bymusic" ) ) ? "" : get_url_param ( "bymusic" );
		$bianqu = empty ( get_url_param ( "bianqu" ) ) ? "" : get_url_param ( "bianqu" );
		$feat = get_url_param ( 'feat' );
		$notes = get_url_param ( 'notes' );
		$songword = get_url_param ( "songword" );
		$songtype = get_url_param ( "songtype" );
		if (empty ( $songtype ))
			$songtype = 1;
		// 获取演唱者信息
		$singerdb = new SingerModel ();
		$singer = $singerdb->get_singer ( $singerid );
		// 获取专辑信息
		$albumndb = new SingeralbumModel ();
		$album = $albumndb->get_album_byid ( $albumnid );
		// 如果文件存在时.
		if (! empty ( $_FILES ['filedata'] )) {
			// 原始文件名
			$original = $_FILES ['filedata'] ['name'];
			// 临时图片路径
			$temp_file = $_FILES ['filedata'] ['tmp_name'];
			// 图片大小
			$file_size = $_FILES ['filedata'] ['size'];
			// 文件扩展名
			$file_ex = pathinfo ( $original, PATHINFO_EXTENSION );
			// 保存文件
			$save_root = C ( 'SAVE_ROOT_MUSIC_FILE' );
			$save_dir = '/' . $singer [0] ['singername'] . '/' . $album [0] ['albumname'] . '/';
			// 创建文件夹.
			if (! is_dir ( set_iconv_winpath ( $save_root . $save_dir ) )) {
				mkdir ( set_iconv_winpath ( $save_root . $save_dir ), 0777, true );
			}
			$path = $save_dir . $songname . '.' . $file_ex;
			// 音频文件秒数
			$times = get_mp3_timeout ( $temp_file );
		} else {
			$times = 0;
		}
		// 添加数据
		$songdb = new SongModel ();
		$is_exists_data = $songdb->get_song_more_conditon ( $singerid, $albumnid, $songname );
		if (! empty ( $is_exists_data )) {
			$array ['msg'] = '歌曲已存在.';
			$array ['result'] = 0;
			echo json_encode ( $array );
			exit ();
		}
		// 插入数据库
		$rs = $songdb->add_song ( $singerid, $albumnid, $songname, $byword, $bymusic, $bianqu, $times, $songword, $path, $file_size, strtolower ( $file_ex ), $feat, $notes, $songtype );
		// 如果数据库添加成功.
		if ($rs > 0) {
			if (! empty ( $_FILES ['filedata'] )) {
				// 验证是否是post可移动的文件.
				if (is_uploaded_file ( $temp_file )) {
					$rs = move_uploaded_file ( $temp_file, set_iconv_winpath ( $save_root . $path ) );
					if ($rs) {
						$array ['msg'] = '歌曲【' . $songname . '】添加成功.';
						$array ['result'] = 1;
					} else {
						$array ['msg'] = '歌曲【' . $songname . '】数据添加成功.但文件移动失败.';
						$array ['result'] = 0;
					}
				} else {
					// 如果无法移动时.则尽心复制.
					if (! copy ( $temp_file, set_iconv_winpath ( $save_root . $path ) )) {
						$array ['msg'] = '文件复制失败.';
					} else {
						$array ['msg'] = '复制成功.';
					}
				}
			} else {
				if ($rs) {
					$array ['msg'] = '信息添加完毕.';
					$array ['result'] = 1;
				}
			}
		}
		echo json_encode ( $array );
	}

	/**
	 * 获取歌曲信息
	 *
	 * @author 邢志 2017年6月24日 下午4:57:33
	 */
	public function get_song_info() {
		$songid = get_url_param ( 'songid' );
		// 获取歌曲信息
		$songdb = new SongModel ();
		$song = $songdb->get_song_byid ( $songid );
		// 修改歌曲试听次数.
		// $songdb->update_song_listentime($songid);
		// 增加试听记录
		$this->add_song_record ( $song );
// 		if (C ( 'REDIS_ISOPEN' )) {
// 			// 从数据库中读取后写入Redis
// 			$redisdb = new Redis ( C ( 'REDIS_HOST' ), C ( 'REDIS_PORT' ), C ( 'REDIS_AUTH' ) );
// 			$this->result ['result'] = $songdb->get_record_song ( 0, 15 );
// 			$redisdb->setHash ( C ( 'PRIM_KEY_SONG' ), C ( 'RECORD_SONGS' ), json_encode ( $this->result ) );
// 			// 设置缓存列表的有效时间.
// 			$redisdb->setKeyExpire ( C ( 'PRIM_KEY_SONG' ), C ( 'REDIS_EXPIRE' ) );
// 		}
		$this->result ['result'] = $song;
		$this->result ['result'] [0] ['times'] = change_time_type ( $song [0] ['times'] );
		echo json_encode ( $this->result );
	}

	/**
	 * 增加试听记录
	 *
	 * @param string $song
	 *        	歌曲信息数据
	 */
	private function add_song_record($song) {
		// 获取歌手信息
		$singerdb = new \Home\Model\SingerModel ();
		$singer = $singerdb->get_singer ( $song [0] ['singerid'] );
		// 增加记录操作
		$db = new \Home\Model\SonglistenrecordModel ();
		$db->add_recoed ( $song [0] ['id'], $song [0] ['songname'], $singer [0] ['singername'] );
	}

	/**
	 * 获取歌曲列表
	 * @author xingzhi 2018年8月6日上午9:33:50
	 * @param int $albumnId 专辑主键id
	 */
	public function get_song_list($albumnId) {
		$songdb = new SongModel ();
		$this->result ['code'] = 0;
		$this->result ['msg'] = "Success";
		$this->result ['result'] = $songdb->get_song_list($albumnId);
		echo get_url_param ('callback')."(".json_encode($this->result).")";
	}

	/**
	 * 上传图片
	 *
	 * @author 邢志 2017年6月24日 下午4:19:15
	 */
	public function upload_albumn() {
		$singerid = get_url_param ( "sid" );
		$albumname = get_url_param ( "albumname" );
		$issueyear = get_url_param ( "issueyear" ); // 发行年份
		$issuetime = get_url_param ( "issuetime" );
		$languages = get_url_param ( "languages" ); // 语言类型
		$issuemonth = get_url_param ( "issuemonth" ); // 发行月份

		if (empty ( $issuetime )) {
			$issuetime = $issueyear . date ( '-m-d' );
		}

		// 原始文件名
		$original = $_FILES ['filedata'] ['name'];
		// 临时图片路径
		$temp_img = $_FILES ['filedata'] ['tmp_name'];
		// 图片大小
		//$img_size = $_FILES ['filedata'] ['size'];
		// 文件扩展名
		$file_ex = get_file_ext ( $original );
		// 文件名
		$file_name = create_guid () . $file_ex;

		$save_root = C ( 'SAVE_ROOT_IMAGE_MUSIC' );
		$dir_path = '/' . date ( 'Ym' ) . '/';
		// 创建不存在的文件夹
		if (! is_dir ( $save_root . $dir_path )) {
			mkdir ( $save_root . $dir_path, 0777, true );
		}
		// 调用Model层进行数据添加.
		$albumndb = new SingeralbumModel ();
		$rs = $albumndb->add_album ( $albumname, $singerid, $issueyear, $issuemonth, $dir_path . $file_name, $issuetime, $languages );
		$this->result ['code'] = $rs;
		if ($rs > 0) {
			$movers = move_uploaded_file ( $temp_img, $save_root . $dir_path . $file_name );
			if ($movers) {
				$this->result ['msg'] = '专辑【' . $albumname . '】上传成功.';
			} else {
				$this->result ['msg'] = '数据上传成功.封面图片移动失败.';
			}
		} else {
			$this->result ['code'] = 0;
			$this->result ['msg'] = $albumname . "数据上传失败";
		}

		echo json_encode ( $this->result );
	}

	/**
	 * 获取专辑列表
	 *
	 * @author 邢志 2017年6月24日 下午4:21:36
	 */
	public function get_album_list() {
		$singerId = get_url_param ( 'sid' );
		$index = get_url_param ( 'index' );
		$rows = get_url_param ( 'rows' );
		$albumdb = new SingeralbumModel ();
		$this->result ['result'] = $albumdb->get_album_list ( $singerId, $index, $rows );
		$this->result ['msg'] = '';
		echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
	}

	/**
	 * 获取歌手列表
	 *
	 * @author 邢志 2017年6月24日 下午4:55:23
	 */
	public function get_singer_list() {
		$singerdb = new SingerModel ();
		$array = $singerdb->get_singer_list ();
		$this->result ['result'] = $array;
		echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
	}
	/**
	 * 添加歌手信息
	 * @author 邢志 2017年6月24日 下午3:23:41
	 */
	public function add_singer() {
		$singername = trim ( get_url_param ( 'singername' ) );
		if (empty ( $singername )) {
			$this->result ['msg'] = '歌手名称必须填写.';
		} else {
			$gender = trim ( get_url_param ( 'gender' ) );
			$region = trim ( get_url_param ( 'region' ) );
			$singerdb = new SingerModel ();
			$this->result ['code'] = $singerdb->add_singer ( $singername, $gender, $region );
			if ($this->result ['code'] < 1) {
				$this->result ['msg'] = '添加歌手' . $singername . '失败.';
			} else {
				$this->result ['msg'] = '添加歌手' . $singername . '成功.';
			}
		}
		echo json_encode ( $this->result );
	}
	/**
	 * 获取专辑列表
	 * @author xingzhi 2018年8月5日上午11:13:24
	 * @param int $albumId 专辑主键.
	 */
	public function get_sineralbum($albumId) {
		$singeralbum = new SingeralbumModel ();
		$result = $singeralbum->get_album_byid ( $albumId );
		$this->result ['result'] = $result;
		$this->result ['code'] = 0;
		$this->result ['msg'] = '请求专辑接口成功.';
		echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
	}
}
