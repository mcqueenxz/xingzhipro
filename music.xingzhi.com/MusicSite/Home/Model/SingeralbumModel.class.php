<?php

namespace Home\Model;

use Think\Model;
use Org\Util\Date;
/**
 * 歌手专辑实体类.
 * @author xingzhi 2018年8月6日下午5:42:28
 *
 */
class SingeralbumModel extends Model {
	/**
	 * 数据表.
	 * @author xingzhi 2018年8月6日下午5:42:39
	 * @var string
	 */
	private $table_name = 'singeralbum';
	/**
	 * 修改专辑信息
	 *
	 * @author 邢志 2017年11月11日 下午10:27:57
	 * @param int $albumnId 专辑主键
	 * @param string $issuetime 专辑时间日期.
	 */
	public function update_albumn($albumnId, $issuetime) {
		$db = M ( $this->table_name );
		return $db->execute( "UPDATE singeralbum SET issuetime = '%s' WHERE id = %d", 
				array( $issuetime, $albumnId ));
	}

	/**
	 * 获取专辑名称
	 *
	 * @param int $albumnid 专辑主键
	 * @return array
	 */
	public function get_ablumnname($albumnid) {
		$db = M ( $this->table_name );
		$array = $db->query ( 'select albumname from singeralbum where id = ' . $albumnid );
		return $array;
	}

	/**
	 * 获取专辑信息
	 *
	 * @param int $aid 专辑主键
	 * @return $array
	 */
	public function get_album_byid($aid) {
		$db = M ( $this->table_name );
		$array = $db->where ( " id = %d", array (
				$aid
		) )->select ();
		return $array;
	}

	/**
	 * 添加专辑信息
	 *
	 * @param string $albumname 专辑名称
	 * @param int $singerid 歌手主键
	 * @param int $issueyear 发行年份
	 * @param int $issuemonth 发行月份
	 * @param string $thumbnail 缩略图路径
	 * @param Date $issuetime 发行时间
	 * @param string $languages 专辑语言类型.国语 英语 粤语
	 */
	public function add_album($albumname, $singerid, $issueyear, $issuemonth, $thumbnail, $issuetime, $languages) {
		$data = array ();
		$data ['albumname'] = $albumname;
		$data ['singerid'] = $singerid;
		$data ['issueyear'] = $issueyear;
		$data ['issuemonth'] = $issuemonth;
		$data ['thumbnail'] = $thumbnail;
		$data ['issuetime'] = $issuetime;
		$data ['languages'] = $languages;
		$db = M ( $this->table_name );
		return $db->add ( $data );
	}
	/**
	 * 修改专辑信息
	 *
	 * @author 邢志 2018年6月9日 下午11:50:01
	 */
	public function updatealbumn($issuetime, $albumnId) {
		$db = M ( $this->table_name );
		return $db->execute ( "UPDATE singeralbum SET issueyear = '%d' WHERE id = %d", array (
				$issuetime,
				$albumnId
		) );
	}
	/**
	 * 通过歌手主键获取专辑信息
	 *
	 * @param int $singerid 歌手主键
	 */
	public function get_album_list($singerid, $index, $rows) {
		$db = M ( $this->table_name );
		$array = $db->where ( "singerid = %d", array (
				$singerid
		) )->order ( 'issueyear desc' )->limit ( ($rows * $index), $rows )->select ();
		return $array;
	}

	/**
	 * 获取所有专辑信息
	 * @author xingzhi 2018年8月6日下午5:40:59
	 * @param int $index 索引页
	 * @param int $rows 显示行.
	 * @return array
	 */
	public function get_album_lib($index, $rows) {
		$db = M ( $this->table_name );
		$array = $db->order ( 'issueyear desc' )->limit ( ($rows * $index), $rows )->select ();
		return $array;
	}
	/**
	 * 获取专辑按条件
	 *
	 * @author 邢志 2017年11月6日下午2:21:32
	 * @param int $year 1.一零年代. 2.零零年代. 3.九十年代. 4.八十年代. 5.七十年代; 6.六十年代; 7.五十年代;
	 */
	public function get_album_condition($year, $index, $rows) {
		$result = array ();
		$condition = "";
		switch ($year) {
			case 1 :
				$condition = "where a.issueyear >= 2010 AND a.issueyear <= 2019";
				break;
			case 2 :
				$condition = "where a.issueyear >= 2000 AND a.issueyear <= 2009";
				break;
			case 3 :
				$condition = "where a.issueyear >= 1990 AND a.issueyear <= 1999";
				break;
			case 4 :
				$condition = "where a.issueyear >= 1980 AND a.issueyear <= 1989";
				break;
			case 5 :
				$condition = "where a.issueyear >= 1970 AND a.issueyear <= 1979";
				break;
			default :
				$condition = "where 1=1 ";
				break;
		}

		$db = M ( $this->table_name );
		$result ['array'] = $db->query ( "select a.* from singeralbum a %s ORDER BY issueyear DESC LIMIT %d, %d", array (
				$condition,
				$index * $rows,
				$rows
		) );

		$result ['total'] = $db->query ( "select COUNT(0) as 'total' from singeralbum a %s ORDER BY issueyear DESC", array (
				$condition
		) );
		return $result;
	}

	/**
	 * 获取页数
	 */
	public function get_album_lib_count() {
		$db = M ( $this->table_name );
		$array = $db->count ( 'id' );
		return $array;
	}
}
