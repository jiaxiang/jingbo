<?php defined('SYSPATH') OR die('No direct access allowed.');

class Myorder_discount_log_Core extends My{
    //对象名称(表名)
    protected $object_name = 'order_discount_log';

    protected static $instances;
    protected $data = array();
	/**
     * 单实例方法
     * @param $id
     */
    public static function & instance($id = 0)
    {
        if (!isset(self::$instances[$id]))
        {
            $class = __CLASS__;
            self::$instances[$id] = new $class($id);
        }
        return self::$instances[$id];
    }
}
