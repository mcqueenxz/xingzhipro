<?php

namespace Home\Model;

use Think\Model;

class SingerModel extends Model {
	private $table_name = "singer";

	/**
	 * 获取歌手信息
	 *
	 * @param int $singerid
	 */
	public function get_singer($singerid) {
		$db = M ( $this->table_name );
		return $db->where ( 'id = %d', array (
				$singerid
		) )->select ();
	}

	/**
	 * 获取全部歌手信息
	 *
	 * @author 邢志 2017年10月2日下午8:08:07
	 */
	public function get_singer_list() {
		$db = M ( $this->table_name );
		$result = $db->query ( "SELECT a.*, 
                (SELECT COUNT(0) FROM song WHERE singerid = a.id) AS total
                FROM singer a 
                ORDER BY a.firstletter ASC " );
		return $result;
	}

	/**
	 * 新增歌手信息
	 *
	 * @param string $singername 名称
	 * @param string $gender 性别
	 * @param string $region 地区
	 */
	public function add_singer($singername, $gender, $region) {
		$data = array();
		$data ['singername'] = $singername; // 歌手名称
		$data ['gender'] = $gender; // 性别
		$data ['firstletter'] = getFirstCharter ( $singername ); // 获取首字母
		$data ['region'] = $region; // 所在地.

		$db = M ( $this->table_name );
		$result = $db->add ( $data );
		return $result;
	}
}