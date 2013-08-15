<?php defined('SYSPATH') or die('No direct script access.');

class MyMonth_contract_detail_Core extends My
{
	//对象名称(表名)
    protected $object_name = 'ag_month_contract_dtl';
    
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
	public function realtime_contract_dtls($limit,$offset)
	{
		$realtime_contract_dtls = ORM::factory('ag_month_contract_dtl')	
			->find_all($limit,$offset);
		$data = array();
		foreach($realtime_contract_dtls as $contractDetail)
		{
			$data[] = $contractDetail->as_array();
		}
		return $data;
	}
	/**
	 * 站点新闻数据
	 */
	public function count_contract_dtls()
	{
		return ORM::factory('ag_month_contract_dtl')->count_all();
	}
	
	public function contract_dtl_exist($data)
	{
		$where = array();
		$where['contract_id'] = $data['contract_id'];
		$where['type'] = $data['type'];
		
		$count = ORM::factory('ag_month_contract_dtl')->where($where)->count_all();
		
        //TODO
        if($count > 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }
	}
	
	public function get_by_id($contract_dtl_id)
	{
		if(empty($contract_dtl_id)){
			return false;
		}
		$where = array();
		$where['id'] = $contract_dtl_id;
		$user = ORM::factory('ag_month_contract_dtl')->where($where)->find();
		if($user->loaded){
			return $user->as_array();
		}else{
			return false;
		}
	}
	
	public function get_lowest_grade_by_id($contractId)
	{
		if(empty($contractId)){
			return false;
		}
		$where = array();
		$where['contract_id'] = $contractId;
		$where['grade'] = 1;
		$cttDtl = ORM::factory('ag_month_contract_dtl')->where($where)->find();
		if($cttDtl->loaded){
			return $cttDtl->as_array();
		}else{
			return false;
		}
	
	}
}

?>
