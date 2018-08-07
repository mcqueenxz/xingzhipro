<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Home\Model;

use Think\Model;

/**
 * 歌曲试听记录表
 */
class SonglistenrecordModel extends Model {

	/**
	 * 试听记录表
	 *
	 * @var 
	 */
	private $table_name = 'songlistenrecord';

	/**
	 * 获取试听报表
	 *
	 * @param string $sdate
	 *        	开始日期
	 * @param string $edate
	 *        	结束日期
	 */
	public function get_report($sdate, $edate) {
		$tsql = "SELECT  max(songid) songid, songname, COUNT(songname) as 'total', 
            singername, max(id) id, max(addtime) addtime 
            FROM songlistenrecord 
            WHERE addtime BETWEEN '" . $sdate . " 00:00:00' AND '" . $edate . " 23:59:59' 
            GROUP BY songname,singername 
            ORDER BY total DESC, addtime DESC";
		$db = M ( $this->table_name );
		return $db->query ( $tsql );
	}

	/**
	 * 获取记录信息 通过歌曲主键
	 *
	 * @param int $songid 歌曲主键
	 * @param int $rows 获取行数
	 */
	public function get_record_song($songid, $rows) {
		$db = M ( $this->table_name );
		return $db->query ( 'SELECT * FROM songlistenrecord WHERE songid = ' . $songid . ' LIMIT ' . $rows );
	}

	/**
	 * 歌曲试听记录
	 *
	 * @param int $songid 歌曲主键
	 * @param string $songname 歌曲名称
	 * @param string $singername 歌手名称
	 */
	public function add_recoed($songid, $songname, $singername) {
		$data = array();
		$data ['songid'] = $songid;
		$data ['songname'] = $songname;
		$data ['singername'] = $singername;
		$data ['addtime'] = date ( 'Y-m-d H:i:s.u', time () );

		$db = M ( $this->table_name );
		$db->add ( $data );
	}
}
