<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_levelService_Core extends DefaultService_Core {
    /* 兼容php5.2环境 Start */
    private static $instance = NULL;
    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    public static $user_levels;
    
    public function check_exist_score($score,$except_id = 0)
    {
        if(!site::id())
        {
            return false;
        }else{
            $query_struct = array(
                'where'=>array(
                    'score'         => $score,
                    'is_special'=>0,
                ),
            );
            if($except_id !== 0)
            {
                $query_struct['where']['id!=']=$except_id;
            }
            $user_levels = $this->index($query_struct);
            return !empty($user_levels); 
        }
    }
    
    public function check_exist_name($name,$except_id = 0)
    {
        if(!site::id())
        {
            return false;
        }else{
            $query_struct = array(
                'where'=>array(
                    'name'         => $name,
                    'is_special'=>0,
                ),
            );
            if($except_id !== 0)
            {
                $query_struct['where']['id!=']=$except_id;
            }
            $user_levels = $this->index($query_struct);
            return !empty($user_levels); 
        }
    }
}