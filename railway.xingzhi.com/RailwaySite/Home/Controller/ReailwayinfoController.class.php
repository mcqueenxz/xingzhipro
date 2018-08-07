<?php

namespace Home\Controller;

use Think\Controller;
use Home\Model\ReailwayinfoModel;

class ReailwayinfoController extends Controller {

    public function index() {
        $stime = get_url_param('stime');
        if (empty($stime)) {
            $stime = date('Y') . '-01-01';
        }
        $etime = get_url_param('etime');
        if (empty($etime)) {
            $etime = date('Y-m-d');
        }
        $reailwaydb = new ReailwayinfoModel ();
        $result = $reailwaydb->get_reailwayinfo_list_date($stime, $etime);
        $this->assign("reailway", $result);
        $this->assign("ipadd",get_local_ip());
        $this->display("index");
    }

    public function addticket() {
        $this->display("addticket");
    }
    /**
     * 获取火车信息说明.
     */
    public function get_reailwayinfo_notes() {
        $rid = get_url_param('rid');
        $ticket = new ReailwayinfoModel ();
        $tickeinfo = $ticket->get_reailwayinfo_byid($rid);
        echo json_encode($tickeinfo);
    }
}
