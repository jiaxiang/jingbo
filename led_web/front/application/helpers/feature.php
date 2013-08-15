<?php
defined('SYSPATH') or die('No direct script access.');

class Feature_Core {
    /*
     * 首页调用特性
     */
    public static function get($index)
    {
        $site_id = Mysite::instance()->id();
        $service = FeatureService::get_instance();
        $result = $service->index_one($site_id, $index);
	return $result;
    }
}
