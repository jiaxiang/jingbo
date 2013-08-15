<?php defined('SYSPATH') or die('No direct script access.');

class MyRealtime_contract_template_Core extends My
{
	//对象名称(表名)
    protected $object_name = 'ag_realtime_contract_template';
    
	private static $instances;
	public static function & instance($id = 0)
	{
		if (!isset(self::$instances[$id]))
		{
			$class = __CLASS__;
			self::$instances[$id] = new $class($id);
		}

		return self::$instances[$id];
	}
	
	/**
	 * 得到站点新闻列表
	 */
	public function templates($limit,$offset)
	{
		$realtime_contracts = ORM::factory('ag_realtime_contract_template')	
			->find_all($limit,$offset);
		$data = array();
		foreach($realtime_contracts as $contract)
		{
			$data[] = $contract->as_array();
		}
		return $data;
	}
	/**
	 * 站点新闻数据
	 */
	public function count_templates()
	{
		return ORM::factory('ag_realtime_contract_template')->count_all();
	}
	
	public function template_exist($data)
	{
		$where = array();
		$where['id'] = $data['id'];
		
		$count = ORM::factory('ag_realtime_contract_template')->where($where)->count_all();
		
        //TODO
        if($count > 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }
	}
	
	public function get_by_id($templateId)
	{
		if(empty($templateId)){
			return false;
		}
		$where = array();
		$where['id'] = $templateId;
		$user = ORM::factory('ag_realtime_contract_template')->where($where)->find();
		if($user->loaded){
			return $user->as_array();
		}else{
			return false;
		}
	}

}

?>
