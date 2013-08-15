<?php defined('SYSPATH') or die('No direct script access.');

class MyRealtime_contract_Core extends My
{
	//对象名称(表名)
    protected $object_name = 'ag_realtime_contract';
    
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
	public function realtime_contracts($limit,$offset)
	{
		$realtime_contracts = ORM::factory('ag_realtime_contract')	
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
	public function count_contracts()
	{
		return ORM::factory('ag_realtime_contract')->count_all();
	}
	public function count_contracts_with_condition($where=array())
	{
		return ORM::factory('ag_realtime_contract')->where($where)->count_all();
	}
	
	public function contract_exist($data)
	{
		$where = array();
		$where['user_id'] = $data['user_id'];
		$where['type'] = $data['type'];
		
		$count = ORM::factory('ag_realtime_contract')->where($where)->count_all();
		
        //TODO
        if($count > 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }
	}
	
	public function get_by_id($contract_id)
	{
		if(empty($contract_id)){
			return false;
		}
		$where = array();
		$where['id'] = $contract_id;
		$user = ORM::factory('ag_realtime_contract')->where($where)->find();
		if($user->loaded){
			return $user->as_array();
		}else{
			return false;
		}
	}

}

?>
