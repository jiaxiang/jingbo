<?php defined('SYSPATH') OR die('No direct access allowed.');

class Myorder_history_Core extends My
{
	//表名
	protected $object_name = 'order_history';
	//数据成员记录单体数据
	protected $data = array();
	//记录Service中的错误信息
	protected $error = array();

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
	 * edit a order history
	 *
	 * @param Int $id
	 * @param Array $data
	 * @return Array
	 */
	public function edit($data)
	{
		$id = $this->data['id'];
		//EDIT
		$order_history = ORM::factory('order_history',$id);
		if(!$order_history->loaded)
		{
			return FALSE;
		}
		//TODO
		if($order_history->validate($data ,TRUE ,$errors = ''))
		{
			$this->data = $order_history->as_array();
			return TRUE;
		}
		else
		{
			$this->errors = $errors;
			return FALSE;
		}
	}
}
