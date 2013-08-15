<?php
defined('SYSPATH') or die('No direct script access.');

class Attribute_Core {
    /*
     * 首页调用规格
     */
    public static function get($index)
    {
        $site_id = Mysite::instance()->id();
        $service = AttributeService::get_instance();
    	$result = $service->index_one($site_id, $index);
    	return $result;
    }
}