<?php defined('SYSPATH') or die('No direct script access.');

class Brand_Core {
    /*
     * 首页调用品牌列表
     */
    public static function index_list()
    {
        return BrandService::get_instance()->get_brands();
    }
}