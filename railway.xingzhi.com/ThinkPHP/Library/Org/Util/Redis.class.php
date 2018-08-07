<?php

namespace Org\Util;

class Redis {
    /**
     * Redis 实体对象
     * @var type 
     */
    private $redisdb = null;
    
    /**
     * 连接 Redis
     * @param type $host IP地址
     * @param type $port 端口
     * @param type $auth 权限登录密码.
     */
    public function _connect($host, $port, $auth){
        $redis = new \Redis();
        $conn = $redis->connect($host, $port);
        if($conn != NULL || $conn){
            $redis->auth($auth);
            $this->redisdb = $redis;
            
            return true;
        }
        return false;
    }
    /**
     * 从列表左侧增加数据
     * @param type $key 键
     * @param type $value 值
     * @return type
     */
    public function set_redis_list($key, $value){
        $num = $this->redisdb->lPush($key, $value);
        return $num;
    }
    /**
     * 
     * @param type $key
     * @param type $value
     */
    public function get_redis_list($key){
        $list = $this->redisdb->rpop($key);
        //$list = $this->redisdb->lrange($key, 0, -1);
        return $list;
    }
}