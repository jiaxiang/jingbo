<?php defined('SYSPATH') OR die('No direct access allowed.');

class Myorder_export_Core extends My{
    //对象名称(表名)
    protected $object_name = 'order_export';

    protected static $instances;
    protected $data = array();
	/**
     * 单实例方法
     * @param $id
     */
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
	 * get order_export select list
	 *
	 * @param array $in
	 * @return array
	 */
	public function select_list($in = NULL)
	{
		$list = array();

		$orm = ORM::factory('order_export');

		if(!empty($in))
		{
			$orm->in('manager_id',$in);
		}

		$list = $orm->select_list('id','name');

		return $list;
	}
	
    /**
     * 是否存在
     * @param <array> $args
     * @return <boolean>
     */
    public function exist($data)
    {
		$where = array();
        $where['manager_id']	=$data['manager_id'];
		$where['export_ids']	=$data['export_ids'];
		$count = ORM::factory('order_export')->where($where)->count_all();
        if($count > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * 名称是否存在
     * @param <array> $args
     * @return <boolean>
     */
    public function name_exist($data)
    {
		$where = array();
        $where['manager_id']	= $data['manager_id'];
		$where['name']	        = $data['name'];
		$count = ORM::factory('order_export')->where($where)->count_all();
        if($count>0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}
