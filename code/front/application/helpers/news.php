<?php defined('SYSPATH') or die('No direct script access.');

class News_Core
{
    /*
     * 首页调用列表
     * @param int $number 调用数量
     * @return array 新闻数组
     */
    public static function index_list($number)
    {
        $lists = array();
        $news_instance = Mynews::instance();
		$lists = $news_instance->index_list($number);
		return $lists;
    }
}