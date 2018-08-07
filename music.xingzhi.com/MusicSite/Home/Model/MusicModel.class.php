<?php

namespace Home\Model;

use Think\Model;

/**
 * Mongo 模型类
 *
 * @author xingzhi 2018年8月4日下午6:59:57
 *        
 */
class MusicModel extends Model {
	private $_host = "mongodb://";
	private $_port = "";
	private $_dbname = "";
	private $_db = null;
	private $_mongodb = null;
	private $collects = null;
	/**
	 * 构造函数
	 *
	 * @author xingzhi 2018年8月4日下午7:04:20
	 */
	public function __construct() {
		$this->_port = C ( 'MONGO_PORT' );
		$this->_host = $this->_host.C( 'MONGO_HOST' ).":".$this->_port;
		$this->_dbname = C ( 'MONGO_DBNAME' );
		$this->_mongodb = new \MongoClient ($this->_host);
		$this->_db = $this->_mongodb->selectDB ($this->_dbname);
		$this->collects = $this->_db->songword;
	}
	/**
	 * 新增歌词数据.
	 *
	 * @author xingzhi 2018年8月4日下午7:15:11
	 * @param int $songId
	 * @param string $songWord
	 * @return boolean true|false
	 */
	public function insert($songId, $songWord) {
		// $this->collects
		$document = array (
				'SongId' => $songId,
				'SongWord' => $songWord
		);
		return $this->collects->insert( $document );
	}
	/**
	 * 根据歌曲主键id获取数据.
	 *
	 * @author xingzhi 2018年8月4日下午7:47:30
	 */
	public function queryone($songId) {
		$result = $this->collects->findOne(array('SongId' => "$songId"));
		return $result;
	}
	/**
	 * 修改歌词数据
	 * @author xingzhi 2018年8月5日下午9:25:36
	 * @param int $songId 歌曲id
	 * @param string $songWord 歌词
	 */
	public function update($songId, $songWord){
		return $this->collects->update(
				array('SongId'=>"$songId"),
				array('$set'=>array("SongWord"=>"$songWord"))
		);
	}
}
