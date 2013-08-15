<?php defined('SYSPATH') or die('No direct script access.');

class Remind_Core
{
    public static $remind_type = array(
				'error',
				'notice',
				'note',
				'success',
				'cart',
			);
	public static $default_remind_type = 'error';
	public static $is_first = true;
	
	public static function set($data, $type='', $url=NULL)
	{
		//如果提醒数据为空则不提醒
		if(!$data)
		{
			return false;
		}
		//判断并设置提醒类别
    	if(!in_array($type, self::$remind_type))
    	{
    		$type = self::$default_remind_type;
    	}
    	//取得当前的remind
    	$session = Session::instance();
        $remind_data    = $session->get_once('remind');
        //判断是否为第一次访问，防止多次刷新
        if(self::$is_first)
        {
        	$remind_data = null;
        	self::$is_first = false;
        }
        //设置提醒信息
        if(empty($remind_data) or empty($remind_data[$type]))
        {
        	$remind_data[$type] =  array_values((array)$data);
        }else{
        	$remind_data[$type] = array_merge($remind_data[$type], array_values((array)$data));
        }
        $session->set_flash('remind', $remind_data);
		if($url===false)
		{
			$url = '/';
		}
		if($url)
		{
            url::redirect($url);
        }
	}

	public static function get()
	{
		$session = Session::instance();
		return $session->get_once('remind');
	}

	/**
	 * 页面中小功能挂件模板
	 *
	 * @param String $style 模板文件名
	 * @return void
	 */
	public static function widget()
	{
        $remind_data = self::get();
        if(!empty($remind_data) && is_array($remind_data))
        {
	        foreach($remind_data as $type=>$data)
	        {
	        	//判断并设置提醒类别
		    	if(!in_array($type, self::$remind_type))
		    	{
		    		$type = self::$default_remind_type;
		    	}
		        if($data)
		        {
		            Widget::factory('remind',array('remind'=>(array)$data))->render($type);
		        }
	        }
        }
	}

}