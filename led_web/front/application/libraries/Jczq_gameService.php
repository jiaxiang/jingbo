<?php defined('SYSPATH') OR die('No direct access allowed.');

class Jczq_gameService_Core extends DefaultService_Core {
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
    
    /*
     * 获得星期几日期数
     * 
     * @param $id  日期编号
     * @return array
     */
    public function get_week($id)
    {
        $id = intval($id);
        
        if (empty($id) || $id > 7 || $id <= 0)
            return false;

        $arrweek =  array();
        $arrweek[1] = '周一';
        $arrweek[2] = '周二';
        $arrweek[3] = '周三';
        $arrweek[4] = '周四';
        $arrweek[5] = '周五';
        $arrweek[6] = '周六';
        $arrweek[7] = '周日';
        
        return  $arrweek[$id];  
    }
    
    /*
     * 根据输入参数返回比赛结果
     */
    public function get_game_result($id)
    {
        $id = intval($id);
        
        if (empty($id) || $id > 3 || $id < 0 )
            return false;

        $result =  array();
        $result[3] = '胜';
        $result[1] = '平';
        $result[0] = '负';

        return  $result[$id];  
    }    
}
