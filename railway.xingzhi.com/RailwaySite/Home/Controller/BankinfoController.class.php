<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\BankinfoModel;
use Home\Model\BankcardinfoModel;
/**
 * 银行记录控制层
 * @author 邢志 2017年11月25日 下午4:19:02
 */
class BankinfoController extends Controller {
	/**
	 * 银行列表/默认页
	 * @author 邢志 2017年11月25日 下午4:51:35
	 */
	public function index(){
		$bank = new BankinfoModel();
		$list = $bank->getbankinfo();
		$this->assign("bankinfo", $list);
		$this->display('index');
	}
	/**
	 * 银行卡列表
	 * @author 邢志 2017年11月25日 下午8:25:42
	 */
	public function cardlist(){
		$bankinfo = new BankcardinfoModel();
		//$bankinfo->q
	}
	/**
	 * 新增银行卡信息
	 * @author 邢志 2017年11月25日 下午4:51:49
	 */
	public function addbankinfo(){
		
		$tspan = get_url_param('tspam');
		if(!empty($tspan)){
			
		}
		$this->assign('tspan',time());
		$this->display('addbankinfo');
	}
	/**
	 * 新增交易记录
	 * @author 邢志 2017年11月25日 下午8:05:15
	 */
	public function addtransinfo() {
		
		$this->display('addtransinfo');
	}
	
}