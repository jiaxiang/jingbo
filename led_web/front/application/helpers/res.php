<?php defined('SYSPATH') or die('No direct script access.');

//by steve(chowhwei@gmail.com) on Dec 2, 2010
class Res_Core {	
	public static function url_base()
	{
		//img1~img12.bizark.cn
		static $_counter = 0;
		if(isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && ($_SERVER["HTTP_X_FORWARDED_PROTO"] == 'https')){
			$https = 'https';
		}else{
			$https = 'http';
		}
		
		if($https == 'http'){
			if(isset($_SERVER["HTTP_X_HTTPS"]) && ($_SERVER["HTTP_X_HTTPS"] == '1')){
				$https = 'https';
			}			
		}
		if(isset($_SERVER["SERVER_ADDR"]) && (preg_match("/\b192.168.4.\b/i", $_SERVER["SERVER_ADDR"]))){
			return($https . '://' . $_SERVER['HTTP_HOST']);
		}
		//return($https . '://' . $_SERVER['HTTP_HOST']);
		return($https . '://img' . ($_counter++ % 4 + 1) . '.bizark.cn');
	}
	
	public static function url_image()
	{
		if(isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && ($_SERVER["HTTP_X_FORWARDED_PROTO"] == 'https')){
			$https = 'https';
		}else{
			$https = 'http';
		}
		
		if($https == 'http'){
			if(isset($_SERVER["HTTP_X_HTTPS"]) && ($_SERVER["HTTP_X_HTTPS"] == '1')){
				$https = 'https';
			}			
		}
		if(isset($_SERVER["SERVER_ADDR"]) && (preg_match("/\b192.168.4.\b/i", $_SERVER["SERVER_ADDR"]))){
			return($https . '://' . $_SERVER['HTTP_HOST'] . '/images');
		}
		$base = self::url_base();
		//return($https . '://' . $_SERVER['HTTP_HOST'] . '/images/');
		return($base . '/images/' . site::id());		
	}
}
