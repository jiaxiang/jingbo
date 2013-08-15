<?php
defined('SYSPATH') or die('No direct script access.');

class Site_Core {
    /**
     * 得到当前域名访问得到的站点ID
     */
    public static function id()
    {
        return Mysite::instance()->id();
    }
    
    /**
     * 得到当前站点的协议类型(http或者https)
     */
    public static function Protocol()
    {
        return Mysite::Instance()->https() ? "https" : "http";
    }
    
    /**
     * 设置当前的默认币种
     * @param string $currency_code
     */
    public function set_currency($currency_code)
    {
        $session = Session::instance();
        $session->set('currency_code', $currency_code);
    }
    
    /**
     * 得到当前的默认币种
     */
    public function get_currency()
    {
        $session = Session::instance();
        $currency_code = $session->get('currency_code');
        if(!$currency_code){
            $currency_code = site::default_currency();
            $session->set('currency_code', $currency_code);
        }
        return $currency_code;
    }
    
    /**
     * 得到当前站点设置的默认币种
     * @return string
     */
    public function default_currency()
    {
        $currency = Mysite::instance()->currency();
        foreach($currency as $code => $item){
            if($item['default'] == 1){
                return $code;
            }
        }
        return 'USD';
    }
    
    /**
     * 得到当前的币种的列表
     */
    public function currencies()
    {
        $currencies = Mysite::instance()->currency();
        return $currencies;
    }
    
    /**
     * 得到当前站点的SEO标题
     */
    public static function title()
    {
        $seo = Mysite::instance()->seo();
        if(isset($seo['title'])){
            return $seo['title'];
        }else{
            return "";
        }
    }
    
    /**
     * 得到当前站点的SEO关键字
     */
    public static function keywords()
    {
        $seo = Mysite::instance()->seo();
        if(isset($seo['keywords'])){
            return $seo['keywords'];
        }else{
            return "";
        }
    }
    
    /**
     * 得到当前站点的SEO meta_description
     */
    public static function description()
    {
        $seo = Mysite::instance()->seo();
        if(isset($seo['description'])){
            return $seo['description'];
        }else{
            return "";
        }
    }
    
    /**
     * 得到当前首页的SEO标题
     */
    public static function index_title()
    {
        $seo = Mysite::instance()->seo();
        if(isset($seo['index_title'])){
            return $seo['index_title'];
        }else{
            return "";
        }
    }
    
    /**
     * 得到当前首页的SEO keywords
     */
    public static function index_keywords()
    {
        $seo = Mysite::instance()->seo();
        if(isset($seo['index_keywords'])){
            return $seo['index_keywords'];
        }else{
            return "";
        }
    }
    
    /**
     * 得到当前站点首页的SEO meta_description
     */
    public static function index_description()
    {
        $seo = Mysite::instance()->seo();
        if(isset($seo['index_description'])){
            return $seo['index_description'];
        }else{
            return "";
        }
    }
    
    /**
     * 得到站点的SEO描述文字
     */
    public static function seowords()
    {
        $seo = Mysite::instance()->seo();
        if(isset($seo['seowords'])){
            return $seo['seowords'];
        }else{
            return "";
        }
    }
    
    /**
     * 得到站点的文案案列表
     */
    public static function docs($is_faq = true)
    {
        $doc_links = array ();
        if($is_faq == true)
            $doc_links[route::name('faq')] = route::action('faq');
        $docs = Mydoc::instance()->site_links();
        $links = array ();
        foreach($docs as $key => $item){
            $links[$key] = url::base() . $item;
        }
        $doc_links = array_merge($doc_links, $links);
        return $doc_links;
    }
    
    /**
     * 得到站点的菜单列表(只有URL参数)
     */
    public static function menu()
    {
    	$data = array ();
        $menu = Mysite::instance()->menu();
        if (!empty($menu))
        {
	        foreach($menu as $item){
	            //去除添加的导航中的/,获得url
	            switch($item['type'])
	            {
	        		case 1:
	            		$url = (substr($item['url'], 0, 1) === '/') ? substr($item['url'], 1) : $item['url'];
	            		break;
	        		case 2:
	        			$url = category::permalink($val['relation_id'],false);
	        			break;
	        		case 3:
	        			$url = Mydoc::instance($val['relation_id'])->get('permalink');
	        			break;
	            }
	            $target = "";
	            $item['target'] or $target = 'target="_blank"';
	            $parttern = '/^(http:|https:).+/';
	            if(preg_match($parttern, $url, $matches)){
	                $link = $url;
	            }else{
	                $link = url::base() . $url;
	            }
	            $data[] = '<a href="' . $link . '" ' . $target . '>' . $item['name'] . '</a>';
	        }
        }
        return $data;
    }
    
    /**
     * 得到站点的菜单列表(站点只有一级导航)
     */
    public static function menu_items()
    {
    	$data = array ();
    	
        $menu = Mysite::instance()->menu();
        if (!empty($menu))
        {
	        foreach($menu as $key => $item){
	            //去除添加的导航中的/,获得url
	            switch($item['type'])
	            {
	        		case 3:
	        			$url = Mydoc::instance($item['relation_id'])->get('permalink');
	            		break;
	        		case 2:
	        			$url = category::permalink($item['relation_id'], false);
	        			break;
	        		case 1:
	        		default:
	            		$url = (substr($item['url'], 0, 1) === '/') ? substr($item['url'], 1) : $item['url'];
	        			break;
	            }
	            $target = "";
	            $item['target'] or $target = 'target="_blank"';
	            $parttern = '/^(http:|https:).+/';
	            if(preg_match($parttern, $url, $matches)){
	                $link = $url;
	                if(url::base().url::current() == $url || url::base() == $url){
	                    $data[$key]['selected'] = 1;
	                }
	            }else{
	                $link = url::base() . $url;
	                if(url::current() == $url || url::current() == $url . 'site'){
	                    $data[$key]['selected'] = 1;
	                }
	            }
	            $data[$key]['link'] = $link;
	            $data[$key]['target'] = $target;
	            $data[$key]['name'] = $item['name'];
	        }
        }
        
        return $data;
    }
    
    /**
     * 得到站点的导航(包含html代码的多级导航)
     */
    public static function current_menus()
    {
        return Mysite::instance()->menus();
    }

	/**
	 *  得到导航数组树
	 * @param array 
	 * @param string
	 * @return string
	 */
    public function get_menus_array($menus, $myid = 0)
    {
        $newarr = array ();
        $tmparr = array();
        if (is_array($menus)) {
            foreach ($menus as $key => $a) 
            {
                if ($a['parent_id'] == $myid) 
                {
                    $tmparr[$a['id']] = $a;
                }
            }
        }
        if (!empty($tmparr) && is_array($tmparr)) 
        {
            foreach ($tmparr as $key=>$a) 
            {
                $newarr[$key] = $a;
	            //去除添加的导航中的/,获得url
	        	switch($newarr[$key]['type'])
	            {
	        		case 1:
	            		$newarr[$key]['url'] = (substr($newarr[$key]['url'], 0, 1) === '/') ? substr($newarr[$key]['url'], 1) : $newarr[$key]['url'];
	            		break;
	        		case 2:
	        			$newarr[$key]['url'] = category::permalink($newarr[$key]['relation_id'],false);
	        			break;
	        		case 3:
	        			$newarr[$key]['url'] = Mydoc::instance($newarr[$key]['relation_id'])->get('permalink');
	        			break;
	            }
                $newarr[$key]['aim'] = '';
                $a['target'] or $newarr[$key]['aim'] = 'target="_blank"';
                $newarr[$key]['children'] = self::get_menus_array($menus, $a['id']);
            }
        }
        return $newarr;
    }
    
	/**
	 *  递归实现导航的无限级
	 * @param array 
	 * @param string
	 * @return string
	 */
	function get_unlimited_menus($menus = array())
	{
	    $html = '';
		if(count($menus) > 0)
		{
			$html = '<ul>';
			foreach($menus as $_menu)
			{
				$html .= "<li>";
				$html .= "<a href='".url::base().$_menu['url']."' ".$_menu['aim'].">".$_menu['name']."</a>";
				if(count($_menu['children'])>0)
				{
					$html .= self::get_unlimited_menus($_menu['children']);
				}
				$html .= "</li>";
			}
			$html .= '</ul>';
		}
		return $html;
	}
    
    /**
     * 站点产品列表每页显示产品的数量
     */
    public static function page_count()
    {
        $page_count = Mysite::instance()->get('page_count');
        if($page_count){
            return $page_count;
        }else{
            return 12;
        }
    }
    
    /**
     * 站点的FAQ的列表
     */
    public static function faqs()
    {
        return Mysite::instance()->faqs();
    }
    
    /**
     * 站点邮箱
     */
    public static function email()
    {
        return Mysite::instance()->get('site_email');
    }
    
    /**
     * 站点的安全码
     */
    public static function secure_code()
    {
        return Mysite::instance()->secure_code();
    }
    
    /**
     * SEO统计代码ID
     */
    public static function stat_code_id()
    {
        return Mysite::instance()->secure_code_id();
    }
    
    /**
     * SEO统计代码
     */
    public static function stat_code()
    {
        return Mysite::instance()->get('stat_code');
    }
    
    /**
     * statking统计代码ID
     */
    public static function statking_id()
    {
        return Mysite::instance()->get('statking_id');
    }
    
    /**
     * statking统计代码
     */
    public static function statking_code()
    {
        return Mysite::instance()->get('statking_code');
    }
    
    /**
     * 支付代码
     */
    public static function pay_code()
    {
        return Mysite::instance()->get('pay_code');
    }
    
    /**
     * 站点域名
     */
    public static function domain()
    {
        return Mysite::instance()->get('domain');
    }
    
    /**
     * livechat code
     */
    public static function livechat()
    {
        return Mysite::instance()->get('livechat');
    }
    
	/**
     * copyright设置
     */
    public static function copyright()
    {
        $copyright = Mysite::instance()->get('copyright');
        $year   = date('Y');
        $month  = date("m");
        $day    = date("d");
        $domain = Mysite::instance()->get('title')? Mysite::instance()->get('title'):self::domain();
        $copyright = str_replace('{year}',$year,$copyright);
        $copyright = str_replace('{month}',$month,$copyright);
        $copyright = str_replace('{day}',$day,$copyright);
        $copyright = str_replace('{domain}',$domain,$copyright);
        return $copyright;
    }
    
    /**
     * twitter链接
     */
    public static function twitter()
    {
        return Mysite::instance()->get('twitter');
    }
    
    /**
     * facebook链接
     */
    public static function facebook()
    {
        return Mysite::instance()->get('facebook');
    }
    
    /**
     * youtube链接
     */
    public static function youtube()
    {
        return Mysite::instance()->get('youtube');
    }
    
    /**
     * trustwave代码/链接
     */
    public static function trustwave()
    {
        return Mysite::instance()->get('trustwave');
    }
    
    /**
     * macfee代码
     */
    public static function macfee()
    {
        return Mysite::instance()->get('macfee');
    }

    /**
     * 全局头部代码
     */
    public static function head_code()
    {
        return Mysite::instance()->get('head_code');
    }
    
    /**
     * 全局底部代码
     */
    public static function body_code()
    {
        return Mysite::instance()->get('body_code');
    }
    
    /**
     * 首页特殊代码
     */
    public static function index_code()
    {
    	return Mysite::instance()->get('index_code');
    }
    
    /**
     * 产品页代码
     */
    public static function product_code()
    {
        return Mysite::instance()->get('product_code');
    }
    
    /**
     * 支付页代码
     */
    public static function payment_code($order)
    {
    	$payment_code = Mysite::instance()->get('payment_code');
    	
        /* 得到订单详情*/
    	$category_name = '';
        $product_sku = '';
        $product_name = '';
        $price = '';
        $quantity = '';
        foreach($order['order_product'] as $product)
        {
        	$cate = array();
        	$product_data = ProductService::get_instance()->get($product['product_id']);
        	$cate = CategoryService::get_instance()->get($product_data['category_id']);
        	$c_name = $cate['title'];
        	$category_name .= $c_name.',';
        	$product_sku .= $product['SKU'].',';
        	$product_name .= $product_data['title'].',';
        	$price .= $product['discount_price'].',';
        	$quantity .= $product['quantity'].',';
        }
        $category_name = trim($category_name,',');
        $product_sku = trim($product_sku,',');
        $product_name = trim($product_name,',');
        $price = trim($price,',');
        $quantity = trim($quantity,',');
        
        /* 支持的变量替换*/
        $payment_code = str_replace('{order_num}',$order['order_num'],$payment_code);
        $payment_code = str_replace('{order_value}',$order['total_real'],$payment_code);
        $payment_code = str_replace('{category_name}',$category_name,$payment_code);
        $payment_code = str_replace('{product_sku}',$product_sku,$payment_code);
        $payment_code = str_replace('{product_name}',$product_name,$payment_code);
        $payment_code = str_replace('{price}',$price,$payment_code);
        $payment_code = str_replace('{quantity}',$quantity,$payment_code);
        return $payment_code;
    }
    
    /**
     * 站点LOGO
     */
    public static function logo($w=220, $h=80)
    {
        $logo = Mysite::instance()->get('logo');
        $site_title = Mysite::instance()->get('site_title');
        $domain = Mysite::instance()->get('domain');
        $str = 'shopKT';
        if(empty($logo)){
            if(empty($site_title)){
                $str = $domain;
            }else{
                $str = $site_title;
            }
        }else{
            $logo = str_replace("logo.", "logo_{$w}x{$h}.", $logo);
            if(empty($site_title)){
                $str = '<img src="' . $logo . '" alt="' . $domain . '"/>';
            }else{
                $str = '<img src="' . $logo . '" alt="' . $site_title . '"/>';
            }
        }
        return $str;
    }
    
    /**
     * 友情链接列表
     */
    public static function links()
    {
        $links = Mysite::instance()->links();
        return $links;
    }
    
    /**
     * 得到动态配置的标签
     */
    public static function label($key = null, $prefix = '/att/theme/')
    {
        if(empty($key)){
            return null;
        }
        $site = Mysite::instance()->get();
        $site_theme_config_struct = Mysite::instance()->get('theme_config');
        if(!empty($site_theme_config_struct)){
            $site_theme_configs = unserialize($site_theme_config_struct);
        }
        $config = array ();
        //模板详情
        $theme = Mytheme::instance($site['theme'])->get();
        //模板配置
        $theme_configs = empty($theme['config']) ? null : unserialize($theme['config']);
        if(isset($site_theme_configs['val'][$key])){
            $name = isset($site_theme_configs['name'][$key]) ? $site_theme_configs['name'][$key] : null;
            $val = isset($site_theme_configs['val'][$key]) ? $site_theme_configs['val'][$key] : null;
            $type = isset($site_theme_configs['type'][$key]) ? $site_theme_configs['type'][$key] : null;
            $description = isset($site_theme_configs['desc'][$key]) ? $site_theme_configs['desc'][$key] : null;
            //$prefix = '/images/site/';
        }elseif(isset($theme_configs['val'][$key])){
            $name = isset($theme_configs['name'][$key]) ? $theme_configs['name'][$key] : null;
            $val = isset($theme_configs['val'][$key]) ? $theme_configs['val'][$key] : null;
            $type = isset($theme_configs['type'][$key]) ? $theme_configs['type'][$key] : null;
            $description = isset($theme_configs['desc'][$key]) ? $theme_configs['desc'][$key] : null;
            //$prefix = '/theme/';
        }else{
            return '';
        }
        if(!empty($description)){
            $url = isset($description['url']) ? $description['url'] : '';
            $alt = isset($description['alt']) ? $description['alt'] : '';
        }
        //返回结果串
        $result_str = '';
        if(!empty($val)){
            switch($type){
                //图片
                case 2:
                    $imgurl = $prefix.'theme'.$site['theme'].str_replace('_','',$key);
                    if(isset($description['url']) && !empty($description['url'])){
                        $result_str = '<a href="' . $url . '"><img src="' . $imgurl . '" alt="' . $alt . '"/></a>';
                    }else{
                        $result_str = '<img src="' . $imgurl . '" alt="' . $alt . '"/>';
                    }
                    break;
                //文本和链接信息
                case 3:
                    $result_str = url::base() . $val;
                    break;
                default:
                    $result_str = $val;
                    break;
            }
            return $result_str;
        }else{
            return '';
        }
    }
}
