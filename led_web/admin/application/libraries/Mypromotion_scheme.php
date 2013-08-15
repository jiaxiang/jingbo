<?php defined('SYSPATH') OR die("No direct access allowed.");

class Mypromotion_scheme_Core extends My
{
	protected $object_name = "promotion_scheme";
	protected static $instances;
	//protected $orm_instance = NULL;
	//protected $data = array();
	
	public static function & instance($id=0)
	{
		if(!isset(self::$instances[$id]))
		{
			$class=__CLASS__;
			self::$instances[$id]=new $class($id);
		}
		return self::$instances[$id];
	}

}
