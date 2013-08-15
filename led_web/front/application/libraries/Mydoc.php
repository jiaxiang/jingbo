<?php defined('SYSPATH') or die('No direct script access.');


class Mydoc_Core extends My{
	
	//对象名称
	protected $object_name = 'doc';
	
	private static $instance;
	public static function & instance($id=0){
		
		if(!isset(self::$instance['id'])){
			$class = __CLASS__;
			self::$instance[$id] = new $class($id);
		}
			return self::$instance[$id];
	}
	
	public function list_doc_num($query_assoc){
		$list = $this->lists($query_assoc);
		return $list;
	}
	
	/*
	 * 根据网址调出相关信息
	 */
	public function get_by_url($url)
	{  
	    $obj = ORM::factory('doc')->where('permalink', $url)->find();
	    if ($obj->loaded)
	    {
	        $result = $obj->as_array();
	        return $result;
	    }
	    else 
	    {
	        return FALSE;
	    }
	}

}