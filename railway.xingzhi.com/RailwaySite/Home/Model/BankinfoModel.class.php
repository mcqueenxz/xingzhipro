<?php
namespace Home\Model;
use Think\Model;
/**
 * 银行信息表
 * @author 邢志 2017年11月25日 下午4:30:55
 */
class BankinfoModel extends  Model {
	
	/**
	 * 表名称.
	 */
	private $table_name = "bankinfo";
	private $result = array();
	/**
	 * 添加银行卡信息
	 * @author 邢志 2017年11月25日 下午4:32:02
	 * @param unknown $bankname 银行卡名称
	 * @param unknown $bankcode 银行卡编号
	 */
	public function addbankinfo($bankname, $bankcode){
		$param['bankname'] = $bankname;
		$param['bankcode'] = $bankcode;
		$db = M( $this->table_name );
		$res = $db->add($param);
		$this->result['result'] = $res;
		if($res > 0){
			$this->result['msg'] = "添加成功";
		} else {
			$this->result['msg'] = "添加失败";
		}
		return $this->result;
	}
	/**
	 * 获取银行卡信息列表
	 * @author 邢志 2017年11月25日 下午8:09:15
	 */
	public function getbankinfo(){
		$sql = "SELECT * FROM bankinfo";
		$db = M( $this->table_name );
		return $db->query($sql);
	}
	
}