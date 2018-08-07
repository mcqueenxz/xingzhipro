<?php

namespace Home\Controller;

use Think\Controller;
use Home\Model\SingeralbumModel;
use Home\Model\SingerModel;
use Home\Model\SongModel;
use Home\Model\MusicModel;

/**
 * *
 * 音乐控制层
 *
 * @author 邢志 2018年8月3日上午10:20:42
 *        
 */
class MusicController extends Controller {

	/**
	 * 歌曲页面
	 *
	 * @author 邢志 2018年8月3日上午10:20:20
	 */
	public function song() {
		$songid = get_url_param ( 'sid' );
		$this->assign ( "IMGDOMAIN", C ( 'IMGDOMAIN' ) );
		$this->assign ( "MUSICDOMAIN", C ( 'MUSICDOMAIN' ) );
		$this->assign ( "sid", $songid );
		$this->display ( 'song' );
	}
	/**
	 * 检索歌曲页面.
	 *
	 * @author 邢志 2017年7月31日 下午4:56:03
	 */
	public function search_song() {
		$key = get_url_param ( "key" );
		$this->assign ( "key", $key );
		$songdb = new SongModel ();
		$song_total = $songdb->get_song_total ();
		$this->assign ( "song_total", $song_total );
		$this->display ( 'search_song' );
	}

	/**
	 * 专辑列表
	 */
	public function album_lib() {
		$this->assign ( "IMGDOMAIN", C ( 'IMGDOMAIN' ) );
		$this->assign ( "ipadd", get_local_ip () );
		$songdb = new SongModel ();
		$song_total = $songdb->get_song_total ();
		$this->assign ( "song_total", $song_total );

		$this->display ( 'album_lib' );
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
	 * 歌曲编辑页
	 */
	public function editsong() {
		// 参数
		$songid = get_url_param ( 'songid' );
		$op = get_url_param ( 'op' );
		// 获取歌曲信息
		$songdb = new SongModel ();
		$song = $songdb->get_song_byid ( $songid );
		// $song_path = C('SAVE_ROOT_MUSIC_FILE').$song[0]['path'];
		if (empty ( $op )) {
			$this->assign ( 'song', $song );
			$this->assign ( 'songid', $songid );
			$this->display ( 'editsong' );
		} else {
			$songname = get_url_param ( 'songname' );
			$byword = get_url_param ( 'byword' );
			$bymusic = get_url_param ( 'bymusic' );
			$bianqu = get_url_param ( 'bianqu' );
			$feat = get_url_param ( 'feat' );
			$notes = get_url_param ( 'notes' );
			$songword = get_url_param ( 'songword' );
			// 修改数据
			$value = $songdb->editor_song ( $songid, $songname, $byword, $bymusic, $bianqu, $feat, $notes, $songword );
			// 增加数据到MongoDB.
			$mongo = new MusicModel ();
			$songModel = $mongo->queryone($songid);
			if(is_null($songModel)){
				$mongo->insert( $songid, $songword );
			} else {
				$mongo->update($songid, $songword);
			}
			// if($value > 0) {
			// //重命名文件.
			// rename($song_path, $songname);
			// }
			$result = array (
					"result" => $value
			);
			echo json_encode ( $result );
		}
	}

	/**
	 * 随机试听页面
	 */
	public function play_random() {
		$songid = get_url_param ( 'sid' );
		$this->assign ( "IMGDOMAIN", C ( 'IMGDOMAIN' ) );
		$this->assign ( "MUSICDOMAIN", C ( 'MUSICDOMAIN' ) );
		$songdb = new SongModel ();
		$song_total = $songdb->get_song_total ();
		$this->assign ( "song_total", $song_total );
		$this->assign ( "sid", $songid );

		$this->display ( 'play_random' );
	}

	/**
	 * 音乐播放页面
	 */
	public function play() {
		$songid = get_url_param ( 'songid' );
		// 获取歌曲信息
		$songdb = new SongModel ();
		$song = $songdb->get_song_byid ( $songid );
		$this->add_song_record ( $song );
		// 获取专辑信息
		$albumdb = new SingeralbumModel ();
		$album = $albumdb->get_album_byid ( $song [0] ['albumnid'] );
		$this->assign ( "aid", $song [0] ['albumnid'] );
		// 获取歌手信息
		$singerdb = new SingerModel ();

		$singer = $singerdb->get_singer ( $song [0] ['singerid'] );
		$this->assign ( "singername", $singer [0] ['singername'] );
		$this->assign ( 'albumname', $album [0] ['albumname'] );
		$this->assign ( 'thumbnail', C ( 'IMGDOMAIN' ) . $album [0] ['thumbnail'] );
		$this->assign ( 'songname', $song [0] ['songname'] );
		$this->assign ( 'byword', $song [0] ['byword'] );
		$this->assign ( 'bymusic', $song [0] ['bymusic'] );
		$this->assign ( 'bianqu', $song [0] ['bianqu'] );
		$this->assign ( 'times', change_time_type ( $song [0] ['times'] ) );
		$this->assign ( "songurl", C ( 'MUSICDOMAIN' ) . $song [0] ['path'] );
		$this->assign ( "MUSICDOMAIN", C ( 'MUSICDOMAIN' ) );
		$this->assign ( "songid", $songid );
		// 展示页面
		$this->display ( "play" );
	}

	/**
	 * 新增歌曲
	 */
	public function addsong() {
		$singerid = get_url_param ( 'sid' );
		$albumnid = get_url_param ( 'aid' );

		$this->assign ( 'sid', $singerid );
		$this->assign ( 'aid', $albumnid );

		$this->display ( "addsong" );
	}

	/**
	 * 歌曲列表
	 */
	public function songlist() {
		$singerid = get_url_param ( 'sid' );
		$albumnid = get_url_param ( 'aid' );
		$songdb = new SongModel ();
		$song_total = $songdb->get_song_total ();
		$this->assign ( "song_total", $song_total );
		// 歌手
		$singdb = new SingerModel ();
		$singer = $singdb->get_singer ( $singerid );
		// 专辑
		$albumdb = new SingeralbumModel ();
		$albumn = $albumdb->get_album_byid ( $albumnid );

		$this->assign ( "singer", $singer );
		$this->assign ( "MUSICDOMAIN", C( 'MUSICDOMAIN' ) );
		$this->assign ( "IMGDOMAIN", C( 'IMGDOMAIN' ) );
		$this->assign ( "albumname", $albumn[0]['albumname'] );
		$this->assign ( "aid", $albumnid );
		$this->assign ( "sid", $singerid );
		$this->display ( "songlist" );
	}

	/**
	 * 添加专辑
	 */
	public function add_albumn() {
		$singerid = get_url_param ( 'sid' );
		$this->assign ( "singerid", $singerid );
		$this->display ( "add_albumn" );
	}

	/**
	 * 获取专辑列表
	 */
	public function albumn_list() {
		$singerid = get_url_param ( 'sid' );
		// 获取歌手信息
		$singerdb = new SingerModel ();
		$singer = $singerdb->get_singer ( $singerid );
		$this->assign ( "singername", $singer [0] ['singername'] );
		$this->assign ( "singerid", $singerid );
		$this->assign ( 'IMGDOMAIN', C ( 'IMGDOMAIN' ) );
		$songdb = new SongModel ();
		$song_total = $songdb->get_song_total ();
		$this->assign ( "song_total", $song_total );
		$this->display ( "albumn_list" );
	}

	/**
	 * 歌手列表
	 */
	public function index() {
		$songdb = new SongModel ();
		$song_total = $songdb->get_song_total ();
		$this->assign ( "song_total", $song_total );
		$this->assign ( "ipadd", get_local_ip () );
		$this->display ( "index" );
	}
	/**
	 * 歌手列表
	 */
	public function singerlist() {
		$songdb = new SongModel ();
		$song_total = $songdb->get_song_total ();
		$this->assign ( "song_total", $song_total );
		$this->assign ( "ipadd", get_local_ip () );
		$this->display ( "singerlist" );
	}

	/**
	 * 新增歌手信息
	 */
	public function addsinger() {
		$this->display ( "addsinger" );
	}
}
