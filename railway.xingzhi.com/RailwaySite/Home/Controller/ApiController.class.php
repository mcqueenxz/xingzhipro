<?php

namespace Home\Controller;

use Think\Controller;
use Home\Model\ReailwayinfoModel;
use Home\Model\SelectorstationModel;

class ApiController extends Controller {

    // 添加火车票信息
    public function add_ticket() {
        $ticketdb = new ReailwayinfoModel ();
        $array = $ticketdb->add_reailwayinfo(
                get_url_param('SStation'), get_url_param('EStation'), get_url_param('BeginTime'), get_url_param("Amount"), get_url_param("BAmount"), get_url_param('Notes'), get_url_param('ReailwayCode'), get_url_param('SeatNum'), get_url_param('BuyStation'), '', get_url_param('ReailwayNum'), get_url_param('ReailwayType'), get_url_param('ReailwaySeatType'));

        echo json_encode($array);
    }
    /**
     * 
     */
    public function get_selectorstation(){
    	$stationdb = new SelectorstationModel();
    	echo json_encode( $stationdb->get_selectorstation() );
    }

}
