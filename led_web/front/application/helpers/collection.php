<?php
defined('SYSPATH') or die('No direct script access.');

class Collection_Core {
    /**
     * 获取产品专题链接
     *
     * @param 	int $id 产品专题id
     * @return 	string
     */
    public static function permalink($id)
    {
        $permalink = 'collection/' . $id;
        return url::base() . $permalink;
    }
    
    /**
     * 首页一次调用一个产品专题
     *
     * @param int $index 产品专题顺序
     * @param int $product_number 产品数量
     * @return array 产品专题数据数组
     */
    public static function index_one($index, $product_number){
        return CollectionService::get_instance()->index_one($index, $product_number);
    }
    
    /**
     * 首页一次性调用多个产品专题
     *
     * @param int $number 产品专题个数
     * @param int $product_number 每个产品专题调用产品数量
     * @return array 产品专题数据数组
     */
    public static function index_tab($number,$product_number)
    {
        $site_id = Mysite::instance()->id();
        $collection_service = CollectionService::get_instance();
        $result = $collection_service->index_tab($site_id, $number, $product_number);
        return $result;
    }
}
