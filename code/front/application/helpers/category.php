<?php
defined('SYSPATH') or die('No direct script access.');

class Category_Core {
    /**
     * 获取分类链接
     *
     * @param 	int id 分类id
     * @return 	string 分类链接
     */
    public static function permalink($id,$absolute = true)
    {
        $route_type = Myroute::instance()->type();
        $category_service = CategoryService::get_instance();
        $category = $category_service->get($id);
        $category_route = Myroute::instance()->get_action('category');
        $category_suffix = Myroute::instance()->get_action('category_suffix');
        
        if($route_type == 0){
            // 0: none  get category and product with id
            $category_permalink = $category_route . '/' . $category['id'];
        }
        if($route_type == 1){
            // 1: get  product with {product}/permalink
            $category_permalink = $category_route . '/' . urlencode($category['uri_name']);
        }
        if($route_type == 2 || $route_type == 4){
            // 2: get category and product with {category_permalink}  and {category+permalink}/{product_permalink}
            $category_permalink = urlencode($category['uri_name']);
        }
        if($route_type == 3){
            // 3: get category and prdouct with {category_permalink1}/.../{category_permalinkn} and {category_permalink1}/.../{category_permalinkn}/{product_permalink}
            $parents = $category_service->get_parents_by_category_id($id);
            $category_permalink = '';
            foreach($parents as $category){
                if($category == end($parents)){
                    $category_permalink .= urlencode($category['uri_name']);
                }else{
                    $category_permalink .= urlencode($category['uri_name']) . '/';
                }
            }
        }
        
        if($absolute)
        {
        	return url::base() . $category_permalink . $category_suffix;
        }
        else 
        {
        	return $category_permalink . $category_suffix;
        }
    }
    
    /**
     * get category's crumb
     * 
     * @param 	Int 	category id
     * @return 	Array 	category's crumb
     */
    public static function crumb($id)
    {
        $crumb = CategoryService::get_instance()->get_parents_by_category_id($id);
        return $crumb;
    }
    
    public static function meta_title($id)
    {
        $category = CategoryService::get_instance()->get($id);
        return $category['meta_title'];
    }
    
    public static function meta_keywords($id)
    {
        $category = CategoryService::get_instance()->get($id);
        return $category['meta_keywords'];
    }
    
    public static function meta_description($id)
    {
        $category = CategoryService::get_instance()->get($id);
        return $category['meta_description'];
    }
    
    public static function name($id)
    {
        $category = CategoryService::get_instance()->get($id);
        return $category['title'];
    }
    
    /************************************************************************************/
    /*********************		分类列表信息						*********************/
    /************************************************************************************/
    /**
     * 得到一级分类
     *
     */
    public static function roots(){
        $roots = array ();
        $roots = CategoryService::get_instance()->get_roots();
        return $roots;
    }
    
    public static function tree($str, $sid = 0, $icon = '&nbsp;&nbsp;')
    {
        $tree = '';
        $category_service = CategoryService::get_instance();
        $categories = $category_service->load_all();
        if(!empty($categories)){
            $tree = tree::get_tree($categories, $str, 0, $sid, $icon);
        }
        return $tree;
    }
    
    /**
     * 得到当前分类子分类
     *
     * @return 	array  $childrens
     */
    public static function children($id)
    {
        $childrens = array ();
        $childrens = CategoryService::get_instance()->get_childrens_by_category_id($id);
        return $childrens;
    }
    
    public static function child($category_id)
    {
        $child = CategoryService::get_instance()->get_child_by_category_id($category_id);
        return $child;
    }
    
    /**
     * 根据链接,类型数组过滤得到搜索条件数组
     */
    public static function url_analyze($url, $classify)
    {
        $search = array ();
        if(!empty($url) && preg_match('/[baf]/i', $url)){
            if(preg_match_all('/_b,((\d+,)*\d+)/i', $url, $match)){
                $brand_ids = preg_replace('/_b,((\d+,)*\d+)/i', '\\1', $match[0][0]);
                $brand_ids = explode(',', $brand_ids);
                foreach($brand_ids as $brand_id){
                    if(array_key_exists($brand_id, $classify['brands'])){
                        $search['b'][] = $brand_id;
                    }
                }
            }
            if(preg_match_all('/_a\d+,((\d+,)*\d+)/i', $url, $match)){
                foreach($match[0] as $val){
                    $attribute_id = preg_replace('/_a(\d+),((\d+,)*\d+)/i', '\\1', $val);
                    if(array_key_exists($attribute_id, $classify['attributes'])){
                        $option_ids = preg_replace('/_a\d+,((\d+,)*\d+)/i', '\\1', $val);
                        $option_ids = explode(',', $option_ids);
                        foreach($option_ids as $option_id){
                            if(array_key_exists($option_id, $classify['attributes'][$attribute_id]['options'])){
                                $search['a'][$attribute_id][] = $option_id;
                            }
                        }
                    }
                }
            }
            if(preg_match_all('/_f\d+,((\d+,)*\d+)/i', $url, $match)){
                foreach($match[0] as $val){
                    $feature_id = preg_replace('/_f(\d+),((\d+,)*\d+)/i', '\\1', $val);
                    if(array_key_exists($feature_id, $classify['features'])){
                        $option_ids = preg_replace('/_f\d+,((\d+,)*\d+)/i', '\\1', $val);
                        $option_ids = explode(',', $option_ids);
                        foreach($option_ids as $option_id){
                            if(array_key_exists($option_id, $classify['features'][$feature_id]['options'])){
                                $search['f'][$feature_id][] = $option_id;
                            }
                        }
                    }
                }
            }
        }
        return $search;
    }
    
    /*
     * 根据search数组获取过滤链接
     * @param array $search
     */
    public static function get_url($search)
    {
        $url = '';
        if(isset($search['b']) && !empty($search['b'])){
            $url .= '_b,' . implode(',', $search['b']);
        }
        if(isset($search['a']) && !empty($search['a'])){
            foreach($search['a'] as $attribute_id => $options){
                $url .= '_a' . $attribute_id . ',';
                $url .= implode(',', $options);
            }
        }
        if(isset($search['f']) && !empty($search['f'])){
            foreach($search['f'] as $feature_id => $options){
                $url .= '_f' . $feature_id . ',';
                $url .= implode(',', $options);
            }
        }
        return $url;
    }
    
    public static function get_classify_data($url, $search, $classify){
        $url_all = preg_replace('/_b,(\d+,)*\d+/i', '', $url);
        foreach($classify['brands'] as $brand_id => $val){
            if(preg_match('/_b,(\d+,)*\d+/i', $url)){
                $url_brand = preg_replace('/_b,(\d+,)*\d+/i', '_b,' . $val['id'], $url);
            }else{
                $url_brand = $url . '_b,' . $val['id'];
            }
            $classify['brands'][$brand_id]['url'] = $url_brand;
            $classify['brands'][$brand_id]['selected'] = 0;
            if(isset($search['b']) && !empty($search['b'])){
                if(in_array($brand_id, $search['b'])){
                    $classify['brands'][$brand_id]['url'] = $url_all;
                    $classify['brands'][$brand_id]['selected'] = 1;
                }
            }
        }
        foreach($classify['attributes'] as $attribute_id => $val){
            $url_all = preg_replace('/_a' . $attribute_id . ',(\d+,)*\d+/i', '', $url);
            foreach($val['options'] as $option_id => $option){
                //生成链接
                if(preg_match('/_a' . $attribute_id . ',(\d+,)*\d+/i', $url)){
                    $url_attribute_option = preg_replace('/_a' . $attribute_id . ',(\d+,)*\d+/i', '_a' . $attribute_id . ',' . $option_id, $url);
                }else{
                    $url_attribute_option = $url . '_a' . $attribute_id . ',' . $option_id;
                }
                $classify['attributes'][$attribute_id]['options'][$option_id]['url'] = $url_attribute_option;
                $classify['attributes'][$attribute_id]['options'][$option_id]['selected'] = 0;
                //判断是否选中
                if(isset($search['a'][$attribute_id]) && !empty($search['a'][$attribute_id])){
                    if(in_array($option_id, $search['a'][$attribute_id])){
                        $classify['attributes'][$attribute_id]['options'][$option_id]['url'] = $url_all;
                        $classify['attributes'][$attribute_id]['options'][$option_id]['selected'] = 1;
                    }
                }
                //判断显示类型
                if(isset($val['meta_struct']['type'])){
                    $classify['attributes'][$attribute_id]['type'] = $val['meta_struct']['type'];
                    if($val['meta_struct']['type'] == 2){
                        if($option['meta_struct']['image'][2] == 'default'){
                            //默认图片
                            $picurl = '/images/attrbute_def.gif';
                        }else{
                            $picurl = $option['meta_struct']['image'][2];
                        }
                        $classify['attributes'][$attribute_id]['options'][$option_id]['picurl'] = $picurl;
                    }
                }
            }
        }
        foreach($classify['features'] as $feature_id => $val){
            $url_all = preg_replace('/_f' . $feature_id . ',(\d+,)*\d+/i', '', $url);
            foreach($val['options'] as $option_id => $option){
                if(preg_match('/_f' . $feature_id . ',(\d+,)*\d+/i', $url)){
                    $url_feature_option = preg_replace('/_f' . $feature_id . ',(\d+,)*\d+/i', '_f' . $feature_id . ',' . $option_id, $url);
                }else{
                    $url_feature_option = $url . '_f' . $feature_id . ',' . $option_id;
                }
                $classify['features'][$feature_id]['options'][$option_id]['url'] = $url_feature_option;
                $classify['features'][$feature_id]['options'][$option_id]['selected'] = 0;
                if(isset($search['f'][$feature_id]) && !empty($search['f'][$feature_id])){
                    if(in_array($option_id, $search['f'][$feature_id])){
                        $classify['features'][$feature_id]['options'][$option_id]['url'] = $url_all;
                        $classify['features'][$feature_id]['options'][$option_id]['selected'] = 1;
                    }
                }
            }
        }
        return $classify;
    }
    
    /** 
     * 获取附件url 
     * @param $prefix 
     * @param $attachment_id 
     * @param $stand 
     * @param $postfix 
     */
    public static function get_attach_url($attachment_id = 0, $stand = 'ti', $prefix = NULL, $postfix = NULL, $mask = NULL)
    {
        $current_prefix = $prefix == NULL ? Kohana::config('attach.routePrefix') : $prefix;
        $presets = Kohana::config('attach.sizePresets');
        $current_preset_string = !empty($presets[$stand]) ? '_' . $presets[$stand] : '';
        $current_postfix = $postfix == NULL ? Kohana::config('attach.defaultPostfix') : $postfix;
        $current_postfix_string = !empty($current_postfix) ? '.' . $current_postfix : '';
        $current_mask_string = $mask == NULL ? Kohana::config('attach.routeMaskViewCategory') : $mask;
        return $current_prefix . str_replace(array (
            '#id#', 
            '#preset#', 
            '#postfix#' 
        ), array (
            $attachment_id, 
            $current_preset_string, 
            $current_postfix_string 
        ), $current_mask_string);
    }
    
    public static function pic_url($category)
    {
        $category['picurl_o'] = self::get_attach_url($category['pic_attach_id'], 'o');
        $category['picurl_ti'] = self::get_attach_url($category['pic_attach_id'], 'ti');
        $category['picurl_sq'] = self::get_attach_url($category['pic_attach_id'], 'sq');
        $category['picurl_t'] = self::get_attach_url($category['pic_attach_id'], 't');
        $category['picurl_s'] = self::get_attach_url($category['pic_attach_id'], 's');
        $category['picurl_m'] = self::get_attach_url($category['pic_attach_id'], 'm');
        $category['picurl_l'] = self::get_attach_url($category['pic_attach_id'], 'l');
        return $category;
    }
}
