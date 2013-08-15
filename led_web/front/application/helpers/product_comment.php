<?php
defined('SYSPATH') or die('No direct script access.');

class Product_comment_Core {

	public static function per_page()
	{
		$domain = str_replace('.','_',site::domain());
		$per_page = kohana::config('product.'.$domain.'.comment.per_page');
		empty($per_page) && $per_page = kohana::config('product.default.comment.per_page');
		$per_page = empty($per_page)?1:$per_page;
		return $per_page;
	}
}