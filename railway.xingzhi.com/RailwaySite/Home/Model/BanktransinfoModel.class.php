<?php
namespace Home\Model;
use Think\Model;
/**
 * 银行转账记录表.
 * @author 邢志 2017年11月25日 下午8:00:47
 */
class BanktransinfoModel extends  Model{
	
	/**
	 * 表名称.
	 */
	private $table_name = "banktransinfo";
	private $result = array();
	/**
	 * 添加银行记录信息
	 * @author 邢志 2017年11月25日 下午8:04:13
	 * @param unknown $cardinfonum 银行卡号
	 * @param unknown $transtype 支付类型
	 * @param unknown $transmoney 金额
	 * @param unknown $notes 备注
	 * @param unknown $transtime 时间
	 */
	public function addtransinfo($cardinfonum, $transtype, $transmoney, $notes, $transtime) {
		$param['cardinfonum'] = $cardinfonum;
		$param['transtype'] = $transtype;
		$param['transmoney'] = $transmoney;
		$param['notes'] = $notes;
		$param['transtime'] = $transtime;
		
		$db = M( $this->table_name );
		$res = $db->add($param);
		$this->result['result'] = $res;
		if($res > 0){
			$this->result['msg'] = '添加成功.';
		} else {
			$this->result['msg'] = '添加失败.';
		}
	}
}