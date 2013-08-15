<?php defined('SYSPATH') or die('No direct script access.');

class MyMonth_contract_detail_template_Core extends My
{
	//对象名称(表名)
    protected $object_name = 'ag_month_contract_dtl_template';
    
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
	public function dtl_templates($limit,$offset)
	{
		$realtime_contract_dtls = ORM::factory('ag_month_contract_dtl_template')	
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
	public function count_dtl_templates()
	{
		return ORM::factory('ag_month_contract_dtl_template')->count_all();
	}
	
	public function dtl_template_exist($data)
	{
		$where = array();
		$where['contract_id'] = $data['contract_id'];
		$where['type'] = $data['type'];
		
		$count = ORM::factory('ag_month_contract_dtl_template')->where($where)->count_all();
		
        //TODO
        if($count > 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }
	}
	
	public function get_by_id($dtl_templateId)
	{
		if(empty($dtl_templateId)){
			return false;
		}
		$where = array();
		$where['id'] = $dtl_templateId;
		$user = ORM::factory('ag_month_contract_dtl_template')->where($where)->find();
		if($user->loaded){
			return $user->as_array();
		}else{
			return false;
		}
	}

}

?>
