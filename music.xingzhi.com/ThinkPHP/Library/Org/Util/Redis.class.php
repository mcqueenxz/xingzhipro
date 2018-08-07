<?php

namespace Org\Util;

class Redis {

	/**
	 * redis 数据对象.
	 *
	 * @var unknown
	 */
	private static $redisdb;

	/**
	 * Redis 初始化
	 *
	 * @author 邢志 2017年10月11日 下午10:16:09
	 * @param unknown $host
	 *        	地址
	 * @param unknown $port
	 *        	端口号
	 * @param string $auth
	 *        	权限口令
	 */
	public function __construct($host, $port, $auth = '') {
		if (empty ( $redisdb )) {
			self::$redisdb = new \Redis ();
			// 创建 redis 连接
			self::$redisdb->connect ( $host, $port );
			// Redis权限码
			if (! empty ( $auth ))
				self::$redisdb->auth ( $auth );
		}
	}
	/**
	 * 是否成功
	 *
	 * @author 邢志 2017年10月11日 下午10:46:41
	 */
	public function isping() {
		$value = self::$redisdb->ping ();
		if ($value == "") {
			return false;
		}
	}
	/**
	 * 设置键生命周期
	 *
	 * @author 邢志 2017年11月14日 上午11:35:09
	 * @param unknown $key
	 * @param unknown $time
	 */
	public function setKeyExpire($key, $time) {
		// 设置失效时间.
		self::$redisdb->expire ( $key, $time );
	}
	/**
	 * 获取失效时间
	 *
	 * @author 邢志 2017年11月14日 上午11:29:07
	 */
	public function getKeyTime($key) {
		return self::$redisdb->ttl ( $key );
	}
	/**
	 * 获取字符串数据
	 *
	 * @param string $key
	 *        	获取Redis的key键名
	 */
	public function getString($key) {
		return self::$redisdb->get ( $key );
	}
	/**
	 * 设置字符串
	 *
	 * @param string $key
	 *        	键名
	 * @param string $value
	 *        	值
	 */
	public function setString($key, $value) {
		self::$redisdb->set ( $key, $value );
	}

	/**
	 * 从List左侧存储数据
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function setListLeftPush($key, $value) {
		self::$redisdb->lpush ( $key, $value );
	}
	/**
	 * 从List右侧取出数据.
	 *
	 * @param string $key
	 */
	public function getListRightPop($key) {
		return self::$redisdb->rpop ( $key );
	}
	/**
	 * 获取列表数据长度
	 *
	 * @param string $key
	 *        	键
	 */
	public function getListLength($key) {
		return self::$redisdb->lsize ( $key );
	}
	/**
	 * 设置Hash值.
	 *
	 * @param string $prim_key
	 *        	主键
	 * @param string $key
	 *        	键
	 * @param string $value
	 *        	值
	 * @return 返回1,如果存在会替换原有的值,返回0,失败返回0
	 */
	public function setHash($prim_key, $key, $value) {
		return self::$redisdb->hset ( $prim_key, $key, $value );
	}
	/**
	 * 获取Hash中所有的 key
	 *
	 * @param string $prim_key
	 * @param string $key
	 * @return array 返回key的数组
	 */
	public function getHashKeyAll($prim_key) {
		return self::$redisdb->hkeys ( $prim_key );
	}
	/**
	 * 获取Hash中所有的 value
	 *
	 * @param string $prim_key
	 * @return array 返回value的数组.
	 */
	public function getHashValueAll($prim_key) {
		return self::$redisdb->hvals ( $prim_key );
	}
	/**
	 * 获取 Hash 所有 Key 和 Value
	 *
	 * @param unknown $prim_key
	 */
	public function getHashKeyAndValueAll($prim_key) {
		return self::$redisdb->hgetall ( $prim_key );
	}
	/**
	 * 通过主键和键获取值
	 *
	 * @param unknown $prim_key
	 *        	主键
	 * @param unknown $key
	 *        	键
	 * @return 返回值
	 */
	public function getHashValueByKey($prim_key, $key) {
		return self::$redisdb->hget ( $prim_key, $key );
	}
	/**
	 * 获取Redis Hash 中key的数量
	 *
	 * @param string $prim_key
	 *        	主键key.
	 */
	public function getHashKeyCount($prim_key) {
		return self::$redisdb->hlen ( $prim_key );
	}
	/**
	 * 删除指定Hash Key
	 *
	 * @param unknown $prim_key
	 *        	主键key
	 * @param unknown $key
	 *        	key
	 * @return 如果表不存在或key不存在则返回false.
	 */
	public function deleteHashKey($prim_key, $key) {
		return self::$redisdb->hdel ( $prim_key, $key );
	}
	/**
	 * 通过指定的Keys获取值
	 *
	 * @param unknown $prim_key
	 * @param unknown $key
	 */
	public function getHashValueByKeys($prim_key, $key) {
		return self::$redisdb->hmget ( $prim_key, $key );
	}
}