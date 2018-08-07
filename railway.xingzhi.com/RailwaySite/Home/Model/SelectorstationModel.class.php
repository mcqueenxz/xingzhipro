<?php
namespace Home\Model;
use Think\Model;
class SelectorstationModel extends Model {
	/**
	 * 数据表名称
	 * @var string
	 */
	private $tablename = "selectorstation";
	/**
	 * 添加临时站点数据
	 * @param string $stationname 站点名称
	 * @param string $isshow 是否显示
	 */
	public function add_selectorstation($stationname, $isshow){
		$param['stationname'] = $stationname;
		$param['isshow'] = $isshow;
		$reailwaydb = M( $this->table_name );
		$rs = $reailwaydb->add($param);
		if($rs < 1){
			return array(
					'result' => 0,
					'msg' => '添加失败.' 
			);
		} else {
			return array(
					'result' => $rs,
					'msg' => $stationname. " 添加成功."
			);
		}
	}
	/**
	 * 获取所有站点信息
	 * @param int $isshow -1 表示不区分获取类型
	 */
	public function get_selectorstation($isshow = -1){
		$reailwaydb = M( $this->table_name );
		if($isshow == -1){
			return $reailwaydb->query("SELECT * FROM selectorstation");
		} else {
			return $reailwaydb->query("SELECT * FROM selectorstation WHERE isshow = %d", array($isshow));
		}
	}
}