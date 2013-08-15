<?php defined('SYSPATH') OR die('No direct access allowed.');
class mems{
    private static $instance = null;
	public static $host = '127.0.0.1'; /* 连接主机地址 */
	public static $port = 11211;	   /* 连接主机端口 */
    public static $flag = MEMCACHE_COMPRESSED;
    public static $expire;

    public static function &instance($config = array()){
        if(!isset(self::$instance)){
            self::$host = empty($config['host'])?self::$host:$config['host'];
            self::$port = empty($config['port'])?self::$port:$config['port'];
            self::$flag = empty($config['flag'])?self::$flag:$config['flag'];
            self::$expire = empty($config['expire'])?self::$expire:$config['expire'];
            self::$instance = new Memcache($config);
            try{
                @self::$instance->pconnect(self::$host, self::$port);
            } catch (Exception $e) {
                return false;
            }
        }
        return self::$instance;
    }

}
