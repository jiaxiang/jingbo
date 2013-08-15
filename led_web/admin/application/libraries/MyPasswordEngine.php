<?php
class MyPasswordEngine 
{
	private static $instance = null;
	
	private static $keyPool = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	
	public static function instance()
	{
		if (!isset(self::$instance))
		{
			$class = __CLASS__;
			self::$instance = new $class;
		}

		return self::$instance;
	}
    
	public function getRandomKey($keyLength)
	{
		$theKey = '';
		for($index =0; $index<$keyLength; $index++)
		{
			$theKey = $theKey.self::$keyPool[mt_rand(0, count(self::$keyPool)-1)];
		}
		return $theKey;
	}
}