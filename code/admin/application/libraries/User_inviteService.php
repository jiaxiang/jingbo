<?php defined('SYSPATH') OR die('No direct access allowed.');
class User_inviteService_Core{
    private static $instance = NULL;
    
    // 获取单态实例 
    public static function get_instance()
    {
        if(self::$instance === NULL)
        {
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    
    function select_list($sql) {
        if(empty($sql)) return  array();
        $rs = Database::instance()->query($sql)->result_array(false);
        return $rs;
    }
    
    function get_one($sql) {
        $rs = Database::instance()->query($sql)->result_array(false);
        return $rs[0];
    }

    function insert($set = NULL) {
        if(empty($set)) return false;
        return Database::instance()->insert('user_reward', $set);
    }
}
