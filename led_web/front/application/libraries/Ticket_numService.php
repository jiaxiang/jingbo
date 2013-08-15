<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ticket_numService_Core extends DefaultService_Core 
{
	/* 兼容php5.2环境 Start */
    private static $instance = NULL;
	   
    // 获取单态实例
    public static function get_instance()
    {
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }

    /*
     * 更新彩票表状态及奖金
     */
    public function update_ticket_zcsf($ticket_id,$bonus)
    {
        $obj = ORM::factory('ticket_num', $ticket_id);
        if ($obj->loaded)
        {
            $obj->status = 2; //更新为已兑奖
            $obj->bonus = $bonus;
            $obj->save();
            
            if ($obj->saved)
            {
                return TRUE;
            }
            else 
            {
                return FALSE;
            }
        }
        else 
        {
            return FALSE;
        }
    }

}
