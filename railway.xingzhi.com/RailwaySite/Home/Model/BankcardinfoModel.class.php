<?php
namespace Home\Model;
use Think\Model;

class BankcardinfoModel extends Model {
	/**
	 * 表名称.
	 */
	private $table_name = "bankcardinfo";
	private $result = array();
	/**
	 * 添加卡信息
	 * @author 邢志 2017年11月25日 下午4:25:09
	 * @param unknown $cardnum 卡号
	 * @param unknown $opendate 开卡日期
	 * @param unknown $bankname 银行支行名称
	 * @param unknown $banksgin 银行标识
	 */
	public function addcardinfo($cardnum, $opendate, $bankname, $banksgin){
		//参数处理
		$param['cardnum'] = trim($cardnum) ;
		$param['opendate'] = trim($opendate);
		$param['bankname'] = trim($bankname);
		$param['banksgin'] = trim($banksgin);
		
		$bankdb = M( $this->table_name );
		$res = $bankdb->add($param);
		$this->result['result'] = $res;
		if($res > 0){
			$this->result['msg'] = '添加成功.';
		} else {
			$this->result['msg'] = '添加失败.';
		}
	}
	/**
	 * 通过银行号与标识号获取信息
	 * @author 邢志 2017年11月25日 下午7:55:44
	 * @param unknown $cardnum
	 * @param unknown $banksgin
	 */
	public function getcardinfo($cardnum, $banksgin){
		$sql = "SELECT * FROM `bankcardinfo` WHERE `cardnum` = '%s' AND `banksgin` = '%s'";
		$db = M( $this->table_name );
		return $db->query($sql, array($cardnum, $banksgin));
	}
	/**
	 * 获取银行卡列表
	 * @author 邢志 2017年11月25日 下午8:26:53
	 */
	public function getcardinfolist(){
		$sql = "SELECT * FROM `bankcardinfo` ";
		$db = M( $this->table_name );
		return $db->query($sql);
	}
}