<?php

namespace Home\Controller;

use Think\Controller; 
use Home\Model\SingerModel;
use Home\Model\SingeralbumModel;
use Home\Model\SongModel;
use Org\Util\Redis;

class ApimusicController extends Controller {

	/**
	 * 缁撴灉鏁扮粍
	 *
	 * @var string
	 */
	private $result = array ();
	/**
	 * 瀵圭鐩樻瓕鏇查噸鍛藉悕
	 *
	 * @author 閭㈠織 2017骞�11鏈�26鏃� 涓嬪崍4:34:03
	 */
	public function renametodisk() {
		$tspan = get_url_param ( "tspan" );
		if (empty ( $tspan )) {
			echo "no" . time ();
		}
		// 浣嗗墠鏃堕棿 - 鏃堕棿鎴�
		if (time () - $tspan > 300) {
			echo 'ok' . (time () - $tspan);
		} else {
			echo '瓒呮椂';
		}
	}

	/**
	 * 鍒犻櫎姝屾洸淇℃伅
	 *
	 * @author 閭㈠織 2017骞�10鏈�4鏃ヤ笂鍗�9:29:04
	 */
	public function deletesong() {
		$songid = get_url_param ( 'sid' );
		if (empty ( $songid )) {
			$this->result ['result'] = 0;
			$this->result ['msg'] = '姝屾洸涓婚敭閿欒.';
		} else {
			$songdb = new SongModel ();
			$songarray = $songdb->get_song_byid ( $songid );
			if (! empty ( $songarray )) {
				$rs = $songdb->deletesong ( $songid );
				$this->result ['result'] = $rs;
				$path_root = C ( 'SAVE_ROOT_MUSIC_FILE' );
				// 鍦╱tf-8缂栫爜鏃讹紝瀵逛腑鏂囪矾寰勭殑鏂囦欢锛岄渶瑕佸厛鍋歡bk缂栫爜澶勭悊.
				$delresult = @unlink ( iconv ( 'utf-8', 'gbk', $path_root . $songarray [0] ['path'] ) );
				if ($delresult) {
					$this->result ['msg'] = '姝屾洸銆�' . $songarray [0] ['songname'] . '銆戝垹闄ゅ畬姣�.';
				} else {
					$this->result ['msg'] = '姝屾洸銆�' . $songarray [0] ['songname'] . '銆戝垹闄ゆ暟鎹�.浣嗘枃浠舵棤娉曞垹闄�.';
				}
			}
		}
		echo json_encode ( $this->result );
	}
	/**
	 * 鑾峰彇浣滆瘝浜轰俊鎭�
	 *
	 * @author 閭㈠織 2017骞�9鏈�24鏃� 涓嬪崍5:08:58
	 */
	public function get_byword() {
		$rows = get_url_param ( "rows" );
		$songdb = new SongModel ();
		$this->result ['result'] = $songdb->get_byword_list ( $rows );
		echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
	}

	/**
	 * 鑾峰彇姝屾洸
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
	 * 璁剧疆姝屾洸闀垮害瀛楁
	 */
	public function set_song_duration() {
		$sid = get_url_param ( "sid" );
		$duration = get_url_param ( "tims" );
		$songdb = new SongModel ();
		$this->result = $songdb->set_song_duration ( $sid, $duration );
		echo $this->get_result_array ( $this->result, '' );
	}

	/**
	 * 鏈�杩戣瘯鍚瓕鏇�
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
				// 浠庢暟鎹簱涓鍙�
				$this->result ['result'] = $songdb->get_record_song ( $index, $rows );
				$redisdb->setHash ( C ( 'PRIM_KEY_SONG' ), C ( 'RECORD_SONGS' ), json_encode ( $this->result ) );
				$values = $redisdb->getHashValueByKey ( C ( 'PRIM_KEY_SONG' ), C ( 'RECORD_SONGS' ) );
			}
			echo get_url_param ( 'callback' ) . "(" . $values . ")";
		}
	}

	/**
	 * 鑾峰彇鏈�鏂扮殑姝屾洸
	 *
	 * @author 閭㈠織 2017骞�7鏈�27鏃� 涓嬪崍9:45:14
	 */
	public function get_new_song() {
		$index = get_url_param ( 'index' );
		$rows = get_url_param ( 'rows' );
		$songdb = new SongModel ();
		$this->result ['result'] = $songdb->get_song ( $index, $rows, "id" );
		echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
	}

	/**
	 * 鑾峰彇鐑棬鐐瑰嚮姝屾洸
	 */
	public function get_hot_song() {
		//$index = get_url_param ( 'index' );
		$rows = get_url_param ( 'rows' );

		if (C ( 'REDIS_ISOPEN' )) {
			$redisdb = new Redis ( C ( 'REDIS_HOST' ), C ( 'REDIS_PORT' ), C ( 'REDIS_AUTH' ) );
			$values = $redisdb->getHashValueByKey ( C ( 'PRIM_KEY_SONG' ), C ( 'HOST_SONGS' ) );
			// 楠岃瘉Redis 涓槸鍚﹀瓨鏈夌紦瀛樻暟鎹�.
			if (strlen ( $values ) <= 0) {
				$songdb = new SongModel ();
				$this->result ['result'] = $songdb->get_hot_song ( $rows );
				$redisdb->setHash ( C ( 'PRIM_KEY_SONG' ), C ( 'HOST_SONGS' ), json_encode ( $this->result ) );
				// 璁剧疆缂撳瓨鍒楄〃鐨勬湁鏁堟椂闂�.
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
	 * 鑾峰彇涓撹緫鍒楄〃
	 *
	 * @author xingzhi 2018骞�8鏈�5鏃ヤ笅鍗�6:06:50
	 * @param int $index
	 *        	绱㈠紩椤�
	 * @param int $rows
	 *        	鏄剧ず琛�
	 * @param int $year
	 *        	骞翠唤鍊�.
	 */
	public function album_library($index, $rows, $year) {
		// 鑾峰彇涓撹緫鍒楄〃.
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
	 * 鑾峰彇缁撴灉鏁扮粍
	 *
	 * @param string $value
	 *        	缁撴灉鍊�
	 * @param string $msg
	 *        	淇℃伅
	 */
	private function get_result_array($value, $msg) {
		$result = array (
				'result' => $value,
				'msg' => $msg
		);
		return $result;
	}

	/**
	 * 淇敼姝屾洸璇曞惉娆℃暟.
	 *
	 * @author 閭㈠織 2017骞�6鏈�27鏃� 涓嬪崍9:49:54
	 */
	public function set_song_listentime() {
		$songid = get_url_param ( 'songid' );
		$songdb = new SongModel ();
		$this->result = $songdb->update_song_listentime ( $songid );
		echo $this->get_result_array ( $this->result, '' );
	}

	/**
	 * 闅忔満鑾峰彇姝屾洸淇℃伅
	 *
	 * @author 閭㈠織 2017骞�6鏈�15鏃� 涓嬪崍9:49:15
	 */
	public function get_song_random() {
		$songid = get_url_param ( 'sid' );
		$songtype = get_url_param ( 'songtype' );
		if (empty ( $songtype ))
			$songtype = 1;
		$songdb = new SongModel ();
		$this->result ['result'] = $songdb->get_song_random ( $songid, $songtype );
		// 淇敼姝屾洸璇曞惉娆℃暟.
		$songdb->update_song_listentime ( $this->result ['result'] [0] ['id'] );
		echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
	}

	/**
	 * 鏂板姝屾洸淇℃伅
	 *
	 * @author 閭㈠織 2017骞�6鏈�8鏃� 涓嬪崍8:25:12
	 */
	public function add_song() {
		$array = array (
				'result' => 0,
				'msg' => ''
		);
		// 鍙傛暟
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
		// 鑾峰彇婕斿敱鑰呬俊鎭�
		$singerdb = new SingerModel ();
		$singer = $singerdb->get_singer ( $singerid );
		// 鑾峰彇涓撹緫淇℃伅
		$albumndb = new SingeralbumModel ();
		$album = $albumndb->get_album_byid ( $albumnid );
		// 濡傛灉鏂囦欢瀛樺湪鏃�.
		if (! empty ( $_FILES ['filedata'] )) {
			// 鍘熷鏂囦欢鍚�
			$original = $_FILES ['filedata'] ['name'];
			// 涓存椂鍥剧墖璺緞
			$temp_file = $_FILES ['filedata'] ['tmp_name'];
			// 鍥剧墖澶у皬
			$file_size = $_FILES ['filedata'] ['size'];
			// 鏂囦欢鎵╁睍鍚�
			$file_ex = pathinfo ( $original, PATHINFO_EXTENSION );
			// 淇濆瓨鏂囦欢
			$save_root = C ( 'SAVE_ROOT_MUSIC_FILE' );
			$save_dir = '/' . $singer [0] ['singername'] . '/' . $album [0] ['albumname'] . '/';
			// 鍒涘缓鏂囦欢澶�.
			if (! is_dir ( set_iconv_winpath ( $save_root . $save_dir ) )) {
				mkdir ( set_iconv_winpath ( $save_root . $save_dir ), 0777, true );
			}
			$path = $save_dir . $songname . '.' . $file_ex;
			// 闊抽鏂囦欢绉掓暟
			$times = get_mp3_timeout ( $temp_file );
		} else {
			$times = 0;
		}
		// 娣诲姞鏁版嵁
		$songdb = new SongModel ();
		$is_exists_data = $songdb->get_song_more_conditon ( $singerid, $albumnid, $songname );
		if (! empty ( $is_exists_data )) {
			$array ['msg'] = '姝屾洸宸插瓨鍦�.';
			$array ['result'] = 0;
			echo json_encode ( $array );
			exit ();
		}
		// 鎻掑叆鏁版嵁搴�
		$rs = $songdb->add_song ( $singerid, $albumnid, $songname, $byword, $bymusic, $bianqu, $times, $songword, $path, $file_size, strtolower ( $file_ex ), $feat, $notes, $songtype );
		// 濡傛灉鏁版嵁搴撴坊鍔犳垚鍔�.
		if ($rs > 0) {
			if (! empty ( $_FILES ['filedata'] )) {
				// 楠岃瘉鏄惁鏄痯ost鍙Щ鍔ㄧ殑鏂囦欢.
				if (is_uploaded_file ( $temp_file )) {
					$rs = move_uploaded_file ( $temp_file, set_iconv_winpath ( $save_root . $path ) );
					if ($rs) {
						$array ['msg'] = '姝屾洸銆�' . $songname . '銆戞坊鍔犳垚鍔�.';
						$array ['result'] = 1;
					} else {
						$array ['msg'] = '姝屾洸銆�' . $songname . '銆戞暟鎹坊鍔犳垚鍔�.浣嗘枃浠剁Щ鍔ㄥけ璐�.';
						$array ['result'] = 0;
					}
				} else {
					// 濡傛灉鏃犳硶绉诲姩鏃�.鍒欏敖蹇冨鍒�.
					if (! copy ( $temp_file, set_iconv_winpath ( $save_root . $path ) )) {
						$array ['msg'] = '鏂囦欢澶嶅埗澶辫触.';
					} else {
						$array ['msg'] = '澶嶅埗鎴愬姛.';
					}
				}
			} else {
				if ($rs) {
					$array ['msg'] = '淇℃伅娣诲姞瀹屾瘯.';
					$array ['result'] = 1;
				}
			}
		}
		echo json_encode ( $array );
	}

	/**
	 * 鑾峰彇姝屾洸淇℃伅
	 *
	 * @author 閭㈠織 2017骞�6鏈�24鏃� 涓嬪崍4:57:33
	 */
	public function get_song_info() {
		$songid = get_url_param ( 'songid' );
		// 鑾峰彇姝屾洸淇℃伅
		$songdb = new SongModel ();
		$song = $songdb->get_song_byid ( $songid );
		// 淇敼姝屾洸璇曞惉娆℃暟.
		// $songdb->update_song_listentime($songid);
		// 澧炲姞璇曞惉璁板綍
		$this->add_song_record ( $song );
// 		if (C ( 'REDIS_ISOPEN' )) {
// 			// 浠庢暟鎹簱涓鍙栧悗鍐欏叆Redis
// 			$redisdb = new Redis ( C ( 'REDIS_HOST' ), C ( 'REDIS_PORT' ), C ( 'REDIS_AUTH' ) );
// 			$this->result ['result'] = $songdb->get_record_song ( 0, 15 );
// 			$redisdb->setHash ( C ( 'PRIM_KEY_SONG' ), C ( 'RECORD_SONGS' ), json_encode ( $this->result ) );
// 			// 璁剧疆缂撳瓨鍒楄〃鐨勬湁鏁堟椂闂�.
// 			$redisdb->setKeyExpire ( C ( 'PRIM_KEY_SONG' ), C ( 'REDIS_EXPIRE' ) );
// 		}
		$this->result ['result'] = $song;
		$this->result ['result'] [0] ['times'] = change_time_type ( $song [0] ['times'] );
		echo json_encode ( $this->result );
	}

	/**
	 * 澧炲姞璇曞惉璁板綍
	 *
	 * @param string $song
	 *        	姝屾洸淇℃伅鏁版嵁
	 */
	private function add_song_record($song) {
		// 鑾峰彇姝屾墜淇℃伅
		$singerdb = new \Home\Model\SingerModel ();
		$singer = $singerdb->get_singer ( $song [0] ['singerid'] );
		// 澧炲姞璁板綍鎿嶄綔
		$db = new \Home\Model\SonglistenrecordModel ();
		$db->add_recoed ( $song [0] ['id'], $song [0] ['songname'], $singer [0] ['singername'] );
	}

	/**
	 * 鑾峰彇姝屾洸鍒楄〃
	 * @author xingzhi 2018骞�8鏈�6鏃ヤ笂鍗�9:33:50
	 * @param int $albumnId 涓撹緫涓婚敭id
	 */
	public function get_song_list($albumnId) {
		$songdb = new SongModel ();
		$this->result ['code'] = 0;
		$this->result ['msg'] = "Success";
		$this->result ['result'] = $songdb->get_song_list($albumnId);
		echo get_url_param ('callback')."(".json_encode($this->result).")";
	}

	/**
	 * 涓婁紶鍥剧墖
	 *
	 * @author 閭㈠織 2017骞�6鏈�24鏃� 涓嬪崍4:19:15
	 */
	public function upload_albumn() {
		$singerid = get_url_param ( "sid" );
		$albumname = get_url_param ( "albumname" );
		$issueyear = get_url_param ( "issueyear" ); // 鍙戣骞翠唤
		$issuetime = get_url_param ( "issuetime" );
		$languages = get_url_param ( "languages" ); // 璇█绫诲瀷
		$issuemonth = get_url_param ( "issuemonth" ); // 鍙戣鏈堜唤

		if (empty ( $issuetime )) {
			$issuetime = $issueyear . date ( '-m-d' );
		}

		// 鍘熷鏂囦欢鍚�
		$original = $_FILES ['filedata'] ['name'];
		// 涓存椂鍥剧墖璺緞
		$temp_img = $_FILES ['filedata'] ['tmp_name'];
		// 鍥剧墖澶у皬
		//$img_size = $_FILES ['filedata'] ['size'];
		// 鏂囦欢鎵╁睍鍚�
		$file_ex = get_file_ext ( $original );
		// 鏂囦欢鍚�
		$file_name = create_guid () . $file_ex;

		$save_root = C ( 'SAVE_ROOT_IMAGE_MUSIC' );
		$dir_path = '/' . date ( 'Ym' ) . '/';
		// 鍒涘缓涓嶅瓨鍦ㄧ殑鏂囦欢澶�
		if (! is_dir ( $save_root . $dir_path )) {
			mkdir ( $save_root . $dir_path, 0777, true );
		}
		// 璋冪敤Model灞傝繘琛屾暟鎹坊鍔�.
		$albumndb = new SingeralbumModel ();
		$rs = $albumndb->add_album ( $albumname, $singerid, $issueyear, $issuemonth, $dir_path . $file_name, $issuetime, $languages );
		$this->result ['code'] = $rs;
		if ($rs > 0) {
			$movers = move_uploaded_file ( $temp_img, $save_root . $dir_path . $file_name );
			if ($movers) {
				$this->result ['msg'] = '涓撹緫銆�' . $albumname . '銆戜笂浼犳垚鍔�.';
			} else {
				$this->result ['msg'] = '鏁版嵁涓婁紶鎴愬姛.灏侀潰鍥剧墖绉诲姩澶辫触.';
			}
		} else {
			$this->result ['code'] = 0;
			$this->result ['msg'] = $albumname . "鏁版嵁涓婁紶澶辫触";
		}

		echo json_encode ( $this->result );
	}

	/**
	 * 鑾峰彇涓撹緫鍒楄〃
	 *
	 * @author 閭㈠織 2017骞�6鏈�24鏃� 涓嬪崍4:21:36
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
	 * 鑾峰彇姝屾墜鍒楄〃
	 *
	 * @author 閭㈠織 2017骞�6鏈�24鏃� 涓嬪崍4:55:23
	 */
	public function get_singer_list() {
		$singerdb = new SingerModel ();
		$array = $singerdb->get_singer_list ();
		$this->result ['result'] = $array;
		echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
	}
	/**
	 * 娣诲姞姝屾墜淇℃伅
	 * @author 閭㈠織 2017骞�6鏈�24鏃� 涓嬪崍3:23:41
	 */
	public function add_singer() {
		$singername = trim ( get_url_param ( 'singername' ) );
		if (empty ( $singername )) {
			$this->result ['msg'] = '姝屾墜鍚嶇О蹇呴』濉啓.';
		} else {
			$gender = trim ( get_url_param ( 'gender' ) );
			$region = trim ( get_url_param ( 'region' ) );
			$singerdb = new SingerModel ();
			$this->result ['code'] = $singerdb->add_singer ( $singername, $gender, $region );
			if ($this->result ['code'] < 1) {
				$this->result ['msg'] = '娣诲姞姝屾墜' . $singername . '澶辫触.';
			} else {
				$this->result ['msg'] = '娣诲姞姝屾墜' . $singername . '鎴愬姛.';
			}
		}
		echo json_encode ( $this->result );
	}
	/**
	 * 鑾峰彇涓撹緫鍒楄〃
	 * @author xingzhi 2018骞�8鏈�5鏃ヤ笂鍗�11:13:24
	 * @param int $albumId 涓撹緫涓婚敭.
	 */
	public function get_sineralbum($albumId) {
		$singeralbum = new SingeralbumModel ();
		$result = $singeralbum->get_album_byid ( $albumId );
		$this->result ['result'] = $result;
		$this->result ['code'] = 0;
		$this->result ['msg'] = '璇锋眰涓撹緫鎺ュ彛鎴愬姛.';
		echo get_url_param ( 'callback' ) . "(" . json_encode ( $this->result ) . ")";
	}
}
