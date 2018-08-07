<?php

namespace Home\Controller;

use Think\Controller;
use Home\Model\SongModel;
use Home\Model\MusicModel;

class CmsController extends Controller {
	public function index() {

		// $path = iconv('utf-8', 'gbk', 'D:\www\music\Enya\Dark Sky Island\黄粱梦1.mp3');
		// $newname = iconv('utf-8', 'gbk', 'D:\www\music\Enya\Dark Sky Island\黄粱梦2.mp3');
		// $this->SetRenameFile();

		// 执行更名做操.
		// var_dump(@rename($path, $newname));
		// var_dump(@unlink($path)) ;
		// $redisdb = new Redis(C('REDIS_HOST'), C('REDIS_PORT'), C('REDIS_AUTH'));
		// echo $redisdb->getKeyTime(C('PRIM_KEY_SONG'));
		//echo phpinfo ();
		// 增加数据到MongoDB.
		$mongo = new MusicModel();
		$songModel = $mongo->queryone(38132);
		if(!is_null($songModel))
			var_dump($songModel);
		//$mongo->insert ( $songid, $songword );

		// $m = new MongoClient();
	}
	public function SetRenameFile() {
		$musicdb = new SongModel ();
		$array = $musicdb->get_song ( 0, 10, 'id' );
		var_dump ( $array );
	}
}