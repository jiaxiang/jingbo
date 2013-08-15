<?php defined('SYSPATH') OR die('No direct access allowed.');

class Mysite_link_Core extends My{
	protected $object_name = 'site_link';
	
	private static $instance;
	public static function & instance($id=0){
		if(!isset(self::$instance[$id])){
				$class = __CLASS__;
				self::$instance[$id] = new $class($id);
			}
		return self::$instance[$id];
		}
	
	
	
	}