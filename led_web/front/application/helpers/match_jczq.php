<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 竞彩足球
 */
class match_jczq_Core {
    private static $instance = NULL;

    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    
    
	/**
	 * 更新或添加信息
	 *
	 * @param  	string 	$email
	 * @param 	String 	$password
	 * @return 	Int 	user id
	 */
	public function update_spf($data)
	{
	    $obj = ORM::factory('match_jczq_spf');
	    
	    if (!$obj->validate($data))
	        return FALSE;
	    
		$obj->where('match_num', $data['match_num'])
			->where('match_id', $data['match_id'])
			->where('pool_id', $data['pool_id'])
			->find();
        
		if($obj->loaded)
		{
            $obj->comb = $data['comb'];
		    $obj->update_time = $data['update_time'];
		}
		else
		{
		    $obj->match_num = $data['match_num'];
		    $obj->match_id = $data['match_id'];
		    $obj->pool_id = $data['pool_id'];
            $obj->goalline = $data['goalline'];
            $obj->comb = $data['comb'];
            $obj->update_time = $data['update_time'];
		}
		$obj->save();
	}    
    
}