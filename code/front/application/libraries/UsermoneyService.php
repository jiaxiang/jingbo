<?php defined('SYSPATH') or die('No direct script access.');
class UsermoneyService_Core extends DefaultService_Core 
{
    private static $instance = NULL;

    /*
     * 获取单例
     */
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }

    
    /*
     * 更新用户金额
     * 
     * @param  int  用户id
     * @param  float  用户当前余额
     * @param  float  添加钱
     * @param  int  类型
     * @return int	新余额
     */
    public function update($user_id, $user_money, $add_money, $type)
    {
        try
        {    
            $data = array();
            $data['uid'] = intval($user_id);
            $data['user_money'] = floatval($user_money);
            $add_money = floatval($add_money);
            $data['type'] = intval($type);
            
            if (empty($data['uid']))
                return  FALSE;
    
            $data['income'] = 0;
            $data['expenditure'] = 0;
    
            if ($add_money < 0)
            {
                $data['expenditure'] = $add_money;
            } 
            else 
            {
                $data['income'] = $add_money;
            }
            
            $data['balance']= $data['user_money'] + ($add_money);
            $momeyobj = ORM::factory('user_money_detail');
            
        	if($momeyobj->validate($data))
    		{
    			$momeyobj->save();
    			return $data['balance'];
    		}
    		else
    		{
    			return FALSE;
		    }
        }
        catch (MyRuntimeException $ex) 
        {
            return FALSE;
            //throw new MyRuntimeException('', 404);
        }
    }

    
	public function add($user_id, $type, $return = 'success')
	{
	    $user_id = intval($user_id);
	    if ($user_id <= 0)
	        return FALSE;
	    
		if($user_log_type = ORM::factory('ulog_type')->where('type', $type)->find())
		{
			$user_log = ORM::factory('ulog');
			$user_log->user_id = $user_id;
			$user_log->type_id = $user_log_type->id;
			$user_log->method = serialize(array('url' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"], 'method' => $_SERVER['REQUEST_METHOD']));
			$user_log->return = $return;
			$user_log->ip = Input::instance()->ip_address();
			$user_log->time = time();
			$user_log->save();
		}
	}
}




