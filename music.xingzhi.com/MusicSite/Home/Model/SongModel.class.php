<?php

namespace Home\Model;

use Think\Model;

/**
 * 歌曲实体类
 *
 * @author 邢志 2017年10月12日 下午9:20:28
 */
class SongModel extends Model {

	/**
	 * 数据表名称.
	 *
	 * @var string
	 */
	private $table_name = 'song';
	/**
	 * 删除歌曲信息
	 *
	 * @author 邢志 2017年10月4日上午9:33:38
	 * @param int $songid
	 *        	歌曲主键
	 * @return array
	 */
	public function deletesong($songid) {
		$db = M ( $this->table_name );
		return $db->where ( "id = %d", array (
				$songid
		) )->delete ();
	}
	/**
	 * 获取作词人
	 *
	 * @author 邢志 2017年9月24日 下午5:07:37
	 * @param int $row
	 *        	显示行
	 * @return array
	 */
	public function get_byword_list($row) {
		$sql = "SELECT byword, COUNT(0) as total FROM song WHERE byword != '' GROUP BY byword ORDER BY total DESC LIMIT 0, " . $row;
		$db = M ( $this->table_name );
		return $db->query ( $sql );
	}

	/**
	 * 检索歌曲总数量
	 *
	 * @param string $key
	 *        	关键词
	 * @return array
	 */
	public function search_song_total($key) {
		$key = trim ( $key );
		$db = M ( $this->table_name );
		$tsql = "SELECT count(0) as 'total' FROM song a INNER JOIN singer b ON b.id = a.singerid " . "INNER JOIN singeralbum c ON c.id = a.albumnid " . "WHERE b.singername LIKE '%" . $key . "%' OR a.songname LIKE '%" . $key . "%' OR a.byword LIKE '%" . $key . "%' OR a.bymusic LIKE '%" . $key . "%' OR a.bianqu LIKE '%" . $key . "%'";
		$array = $db->query ( $tsql );
		return $array;
	}

	/**
	 * 歌曲检索
	 *
	 * @param string $key
	 *        	关键词
	 * @param string $index
	 *        	索引页
	 * @param int $rows
	 *        	显示行
	 * @return array
	 */
	public function search_song($key, $index, $rows) {
		$key = trim ( $key );
		$db = M ( $this->table_name );
		$tsql = "SELECT a.id,a.singerid,a.albumnid,a.songname,a.byword,a.bymusic,a.bianqu,a.path,a.feat,a.notes,a.filetype,a.listentime, " . "b.singername, c.albumname, c.thumbnail " . "FROM song a INNER JOIN singer b ON b.id = a.singerid INNER JOIN singeralbum c ON c.id = a.albumnid " . "WHERE b.singername LIKE '%" . $key . "%' OR a.songname LIKE '%" . $key . "%' " . "OR a.byword LIKE '%" . $key . "%' OR a.bymusic LIKE '%" . $key . "%' OR a.bianqu LIKE '%" . $key . "%' " . "ORDER BY a.listentime DESC LIMIT " . ($index * $rows) . ", " . $rows . "";
		$array = $db->query ( $tsql );
		return $array;
	}

	/**
	 * 设置歌曲时长
	 *
	 * @param int $sid
	 *        	歌曲主键
	 * @param string $duration
	 *        	时长
	 * @return array
	 */
	public function set_song_duration($sid, $duration) {
		$db = M ( $this->table_name );
		$tsql = "update `" . $this->table_name . "` set `times` = " . $duration . " WHERE id = " . $sid;
		$result = $db->execute ( $tsql );
		return $result;
	}

	/**
	 * 获取最新的随机听歌记录.
	 */
	public function get_record_song($index, $rows) {
		$db = M ( $this->table_name );
		$tsql = "select DISTINCT b.*,c.singername from songlistenrecord a INNER JOIN song b ON b.id = a.songid INNER JOIN singer c ON c.id = b.singerid order by a.id DESC limit " . ($index * $rows) . "," . $rows;
		$array = $db->query ( $tsql );
		return $array;
	}

	/**
	 * 获取歌曲列表
	 *
	 * @param int $index
	 *        	索引页
	 * @param int $rows
	 *        	显示行
	 * @param string $sortfield
	 *        	排序字段
	 */
	public function get_song($index, $rows, $sortfield) {
		$db = M ( $this->table_name );
		$tsql = "select b.singername, a.* from song a INNER JOIN singer b ON b.id = a.singerid ORDER BY a." . $sortfield . " DESC LIMIT " . ($rows * $index) . ", " . $rows;
		$array = $db->query ( $tsql );
		return $array;
	}

	/**
	 * 获取热门歌曲
	 */
	public function get_hot_song($rows) {
		$db = M ( $this->table_name );
		$array = $db->query ( "select b.singername, a.* from song a " . "INNER JOIN singer b ON b.id = a.singerid ORDER BY a.listentime DESC LIMIT " . $rows );
		return $array;
	}

	/**
	 * 获取当前歌曲总数量
	 */
	public function get_song_total() {
		$songdb = M ( $this->table_name );
		$array = $songdb->query ( 'SELECT COUNT(0) AS \'total\' FROM ' . $this->table_name );
		$total = 0;
		foreach ( $array as $item ) {
			$total = $item ['total'];
		}
		return $total;
	}

	/**
	 * 修改歌曲试听次数
	 *
	 * @param int $songid
	 *        	歌曲主键
	 */
	public function update_song_listentime($songid) {
		$songdb = M ( $this->table_name );
		$result = $songdb->execute ( 'UPDATE song SET listentime = listentime + 1 WHERE id = ' . $songid );
		return $result;
	}

	/**
	 * 编辑歌曲信息
	 *
	 * @param int $songid 歌曲主键
	 * @param string $songname 歌曲名称
	 * @param string $byword 作词
	 * @param string $bymusic 作曲
	 * @param string $bianqu 编曲
	 * @param string $feat 合唱者
	 * @param string $notes 备注信息
	 * @param string $songword 歌词
	 * @return array
	 */
	public function editor_song($songid, $songname, $byword, $bymusic, $bianqu, $feat, $notes, $songword) {
		$data = array ();
		// 参数
		$data ['songname'] = $songname;
		$data ['byword'] = $byword;
		$data ['bymusic'] = $bymusic;
		$data ['bianqu'] = $bianqu;
		$data ['songname'] = $songname;
		$data ['feat'] = $feat;
		$data ['editortime'] = date ( 'Y-m-d H:i:s.u', time () );
		$data ['notes'] = $notes;
		$data ['songword'] = $songword;
		// 执行数据库
		$songdb = M ( $this->table_name );
		return $songdb->where ( 'id = %d', array (
				$songid
		) )->save ( $data );
	}

	/**
	 * 随机获取歌曲信息
	 *
	 * @author 邢志 2017年7月8日 下午8:38:25
	 * @param int $songid
	 *        	歌曲主键
	 * @param int $songtype
	 *        	歌曲类型
	 * @return NULL
	 */
	public function get_song_random($songid, $songtype) {
		$songdb = M ( $this->table_name );
		$array = null;
		if (empty ( $songid )) {
			$tsql = "SELECT song.*, 
				(SELECT singername from singer a WHERE a.id = song.singerid)  as singername,
				(SELECT albumname from singeralbum b WHERE b.id = song.albumnid)  as albumname,
				(SELECT thumbnail from singeralbum b WHERE b.id = song.albumnid)  as thumbnail 
				FROM song WHERE (filetype = 'mp3' OR filetype = 'm4a') AND songtype = " . $songtype . " ORDER BY RAND() LIMIT 1";

			// var_dump( $tsql );

			// 随机获取歌曲
			$array = $songdb->query ( $tsql );
		} else {
			// 根据id获取指定歌曲.
			$array = $songdb->query ( "SELECT song.*, 
				(SELECT singername from singer a WHERE a.id = song.singerid)  as singername,
				(SELECT albumname from singeralbum b WHERE b.id = song.albumnid)  as albumname,
				(SELECT thumbnail from singeralbum b WHERE b.id = song.albumnid)  as thumbnail 
				FROM song WHERE song.id = " . $songid );
		}
		return $array;
	}

	/**
	 * 获取歌曲信息
	 *
	 * @param int $singerid
	 *        	歌手主键
	 * @param int $albumnid
	 *        	专辑主键
	 * @param string $songname
	 *        	歌曲名称
	 * @return array
	 */
	public function get_song_more_conditon($singerid, $albumnid, $songname) {
		$songdb = M ( $this->table_name );
		$array = $songdb->where ( "singerid=%d and albumnid=%d and songname='%s'", array (
				$singerid,
				$albumnid,
				$songname
		) )->select ();
		return $array;
	}

	/**
	 * 通过歌曲主键获取歌曲信息
	 *
	 * @param int $songid
	 *        	歌曲主键
	 * @return array
	 */
	public function get_song_byid($songid) {
		$songdb = M ( $this->table_name );
		return $songdb->query ( "SELECT a.*,b.albumname,b.issueyear,c.singername FROM song a INNER JOIN singeralbum b ON b.id = a.albumnid INNER JOIN singer c ON c.id = a.singerid WHERE a.id = " . $songid );
	}

	/**
	 * 获取歌曲列表
	 *
	 * @author 邢志 2017年6月8日 下午4:21:24
	 * @param int $aid
	 *        	专辑主键id
	 * @return array
	 */
	public function get_song_list($aid) {
		$songdb = M ( $this->table_name );
		return $songdb->where ( "albumnid = %d", array (
				$aid
		) )->select ();
	}

	/**
	 * 添加歌曲信息
	 *
	 * @param int $singerid
	 *        	歌手主键
	 * @param int $albumnid
	 *        	专辑主键
	 * @param string $songname
	 *        	歌手名称
	 * @param string $byword
	 *        	作词
	 * @param string $bymusic
	 *        	作曲
	 * @param string $bianqu
	 *        	编曲
	 * @param string $times
	 *        	时长
	 * @param string $songword
	 *        	歌词
	 * @param string $path
	 *        	路径
	 * @param string $filesize
	 *        	文件大小
	 * @param string $filetype
	 *        	文件类型
	 * @param string $feat
	 *        	合唱者信息
	 * @param string $notes
	 *        	备注信息
	 * @param string $songtype
	 *        	歌曲类型：1.歌曲.2.音乐.
	 * @return string
	 */
	public function add_song($singerid, $albumnid, $songname, $byword, $bymusic, $bianqu, $times, $songword, $path, $filesize, $filetype, $feat, $notes, $songtype) {
		$data = array ();
		$data ['singerid'] = $singerid;
		$data ['albumnid'] = $albumnid;
		$data ['songname'] = $songname;
		$data ['byword'] = $byword;
		$data ['bymusic'] = $bymusic;
		$data ['bianqu'] = $bianqu;
		$data ['times'] = $times;
		$data ['songword'] = $songword;
		$data ['path'] = $path;
		$data ['filesize'] = $filesize;
		$data ['filetype'] = $filetype;
		$data ['feat'] = $feat;
		$data ['addtime'] = date ( 'Y-m-d H:i:s.u', time () );
		$data ['editortime'] = date ( 'Y-m-d H:i:s.u', time () );
		$data ['listentime'] = 0; // 试听次数
		$data ['notes'] = $notes;
		$data ['songtype'] = $songtype;
		$songdb = M ( $this->table_name );
		return $songdb->add ( $data );
	}
}
