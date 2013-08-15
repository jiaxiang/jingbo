<?php defined('SYSPATH') or die('No direct script access.');

class url extends url_Core {

	/**
	 * 得到当前URL中GET信息
	 *
	 * @param   boolean  include the query string
	 * @return  string
	 */
	public static function query_string()
	{
		return Router::$query_string;
	}
}
