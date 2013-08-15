<?php defined('SYSPATH') or die('No direct script access.');

class Myextract_amount_Core extends My
{
	//对象名称(表名)
    protected $object_name = 'extract_amount';

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
	
	
    
}

