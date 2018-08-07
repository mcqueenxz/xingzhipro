<?php

namespace Home\Model;

use Think\Model;

/**
 * 火车票信息网
 *
 * @author Administrator
 *        
 */
class ReailwayinfoModel extends Model {

	/**
	 * 列车表名称.
	 * @author 邢志 2018年8月2日上午11:11:46
	 * @var string
	 */
    private $table_name = "reailwayinfo";

    /**
     * 通过主键获取车票信息
     * @author 邢志 2018年8月2日上午11:12:12
     * @param int $rid
     * @return mixed
     */
    public function get_reailwayinfo_byid($rid) {
        $reailwaydb = M($this->table_name);
        $result = $reailwaydb->query("SELECT * FROM " . $this->table_name . " WHERE id = %d", array(
            $rid
                ));
        return $result;
    }

    /**
     * 通过 始发站 终到站 发车时间 和 车次查询
     * @author 邢志 2018年8月2日上午11:12:27
     * @param string $sstation 起始站
     * @param string $estation 终到站
     * @param string $begintime 起始时间
     * @param string $reailwaycode 列车编号
     * @return mixed
     */
    public function get_reailwayinfo_param($sstation, $estation, $begintime, $reailwaycode) {
        $reailwaydb = M($this->table_name);
        return $reailwaydb->query("SELECT id, sstation, estation, addtime, begintime, 
				amount, bamount, notes, reailwaycode, seatnum, 
				buystation, ticketpic, reailwaynum, reailwaytype, reailwayseattype 
				FROM reailwayinfo 
				WHERE sstation = '%s' 
				AND estation = '%s' 
				AND reailwaycode = '%s'  
				AND begintime = '%s' ", array(
                    $sstation,
                    $estation,
                    $reailwaycode,
                    $begintime
                ));
    }

    /**
     * 获取火车票数据
     */
    public function get_reailwayinfo_list_date($starDate, $endDate) {
        $reailwaydb = M($this->table_name);
        return $reailwaydb->query("SELECT * FROM reailwayinfo WHERE begintime BETWEEN '" . $starDate . " 00:00:00' and '" . $endDate . " 23:59:59' ORDER BY begintime DESC");
    }
    /**
     * 添加火车票信息
     * @author 邢志 2018年8月2日上午11:15:11
     * @param string $sstation 起始站
     * @param string $estation 终到站
     * @param string $begintime 发车时间
     * @param string $amount 乘车金额
     * @param string $bamount 额外支付金额
     * @param string $notes 备注
     * @param string $reailwaycode 火车车次
     * @param string $seatnum 座位号
     * @param string $buystation 车票购买站
     * @param string $ticketpic 车票图片
     * @param string $reailwaynum 车厢号
     * @param string $reailwaytype 火车类型. G.高铁 D.动车 Z.直达 T.特快 K.快速 QT.其它
     * @param string $reailwayseattype 特等 一等 二等 高级 软卧 硬卧 动卧 高级 软座 硬座 无座
     * @return number[]|string[]|number[]|string[]|mixed[]|boolean[]|unknown[]
     */
    public function add_reailwayinfo($sstation, $estation, $begintime, $amount, $bamount, $notes, $reailwaycode, $seatnum, $buystation, $ticketpic, $reailwaynum, $reailwaytype, $reailwayseattype) {
        $result = array(
            'result' => 0,
            'msg' => ''
        );
        
        $reailway_data = $this->get_reailwayinfo_param($sstation, $estation, $begintime, $reailwaycode);
        if (!empty($reailway_data)) {
            $result ['msg'] = '不能重复录入数据.';
            return $result;
        }
        $param ['sstation'] = $sstation;
        $param ['estation'] = $estation;
        $param ['addtime'] = date('Y-m-d H:i:s', time());
        $param ['begintime'] = $begintime;
        $param ['amount'] = empty($amount) ? 0 : $amount;
        $param ['bamount'] = empty($bamount) ? 0 : $bamount;
        $param ['notes'] = $notes;
        $param ['reailwaycode'] = $reailwaycode;
        $param ['seatnum'] = $seatnum;
        $param ['buystation'] = $buystation;
        $param ['ticketpic'] = $ticketpic;
        $param ['reailwaynum'] = $reailwaynum;
        $param ['reailwaytype'] = $reailwaytype;
        $param ['reailwayseattype'] = $reailwayseattype;
        $reailwaydb = M($this->table_name);
        $rs = $reailwaydb->add($param);
        $result ['result'] = $rs;
        if ($rs < 1) {
            $result ['msg'] = '添加失败.';
        } else {
            $result ['msg'] = '添加成功.';
        }
        return $result;
    }

}
