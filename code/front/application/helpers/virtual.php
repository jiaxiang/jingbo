<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 前台虚拟分类
 * @author fan.chongyuan
 */
class Virtual_Core {
    /**
     * 获取虚拟分类链接
     *
     * @param 	int $id 虚拟分类id
     * @return 	string
     */
    public static function permalink($id)
    {
        $permalink = 'virtual/' . $id;
        return url::base() . $permalink;
    }
    
    /**
     * 首页调用一个虚拟分类
     *
     * @param int $index 虚拟分类顺序
     * @param int $number 产品数量
     * @return array 虚拟分类数据数组
     */
    public static function index_one($index, $number)
    {
        $site_id = Mysite::instance()->id();
        $filter_service = Alias_filterService::get_instance();
        $result = $filter_service->index_one($site_id, $index, $number);
        return $result;
    }
    
    /**
     * 首页一次调用多个虚拟分类
     *
     * @param int $number 虚拟分类个数
     * @param int $product_number 产品数量
     * @return array 虚拟分类数据数组
     */
    public static function index_tab($number, $product_number)
    {
        $site_id = Mysite::instance()->id();
        $filter_service = Alias_filterService::get_instance();
        $result = $filter_service->index_tab($site_id, $number, $product_number);
        return $result;
    }
    
    /**
     * 首页调用一级子虚拟分类
     *
     * @param int $index 虚拟分类顺序
     * @return array 子虚拟分类数据数组
     */
    public static function children($level, $index)
    {
        $result = array ();
        $site_id = Mysite::instance()->id();
        $filter_service = Alias_filterService::get_instance();
        $result = $filter_service->index_children($site_id, $level, $index);
        return $result;
    }

}
