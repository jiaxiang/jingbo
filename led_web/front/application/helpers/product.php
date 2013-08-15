<?php
defined('SYSPATH') or die('No direct script access.');

class Product_Core {
    
    const PRODUCTPIC_STANDARDS_ORIGINAL = 'o';
    const PRODUCTPIC_STANDARDS_TINY = 'ti';
    const PRODUCTPIC_STANDARDS_SQUARE = 'sq';
    const PRODUCTPIC_STANDARDS_THUMBNAIL = 't'; //120*120
    const PRODUCTPIC_STANDARDS_SMALL = 's';
    const PRODUCTPIC_STANDARDS_MIDDLE = 'm';
    const PRODUCTPIC_STANDARDS_LARGE = 'l';

    /**
     * get product permalink
     *
     * @param 	array 	产品数组
     * @param 	String 	product permalink
     */
    public static function permalink($id)
    {
        static $categorys = array ();
        
        $route_type = Myroute::instance()->type();
        
        $product_suffix = Myroute::instance()->get_action('product_suffix');
        $product_route = Myroute::instance()->get_action('product');
        try
        {
            $product = ProductService::get_instance()->get($id);
        } catch (MyRuntimeException $ex) {
            return '#';
        }
        
        if ($route_type == 3 && ! isset($categorys[$product['category']['id']]))
        {
            $categorys[$product['category']['id']] = $product['category'];
        }
        
        if ($route_type == 0)
        {
            // 0: none  get category and product with id
            $permalink = $product_route . '/' . $product['id'];
        }
        
        if ($route_type == 1 || $route_type == 4)
        {
            // 1: get  product with {product}/permalink
            // TODO
            $product['uri_name'] = $product['uri_name']?$product['uri_name']:$product['id'];
            $permalink = $product_route . '/' . urlencode($product['uri_name']);
        }
        
        if ($route_type == 2)
        {
            // 2: get category and product with {category_permalink}  and {category+permalink}/{product_permalink}
            //$category = Mycategory::instance ( $product_data ['default_category_id'] );
            $permalink = urlencode($product['category']['uri_name']) . "/" . urlencode($product['uri_name']);
        }
        
        if ($route_type == 3)
        {
            // 3: get category and prdouct with {category_permalink1}/.../{category_permalinkn} and {category_permalink1}/.../{category_permalinkn}/{product_permalink}
            $category_service = CategoryService::get_instance();
            $permalink = urlencode($product['category']['uri_name']);
            $category = $product['category'];
            while ($category['pid'] > 0)
            {
                try
                {
                    if (isset($categorys[$category['pid']]))
                    {
                        $category = $categorys[$category['pid']];
                    } else
                    {
                        $category = $category_service->get($category['pid']);
                        if (! isset($categorys[$category['id']]))
                        {
                            $categorys[$category['id']] = $category;
                        }
                    }
                } catch (MyRuntimeException $ex)
                {
                    continue;
                }
                $permalink = urlencode($category['uri_name']) . '/' . $permalink;
            }
            $permalink .= '/' . urlencode($product['uri_name']);
        }
        
        return url::base() . $permalink . $product_suffix;
    }

    public static function picurl($id, $stand = self::PRODUCTPIC_STANDARDS_THUMBNAIL)
    {
        $route_prefix = Kohana::config('attach.routePrefix');
        $route_mask_view = Kohana::config('attach.routeMaskViewProduct');
        $route_postfix = Kohana::config('attach.defaultPostfix');
        return ProductpicService::get_attach_url($route_prefix, $id, $stand, $route_postfix, $route_mask_view);
    }

    public static function pic_url($products)
    {
        foreach ($products as $key => $product)
        {
            if (empty($product['default_image_id']) && !empty($product['goods_productpic_relation_struct']))
            {
                $product['default_image_id'] = '';
                $productpic_relation_struct = json_decode($product['goods_productpic_relation_struct'], TRUE);
                if(isset($productpic_relation_struct['items']))
                {
                    $pic_id = array_shift($productpic_relation_struct['items']);
                    $pic = ProductpicService::get_instance()->get($pic_id);
                    if(isset($pic['image_id']))$product['default_image_id'] = $pic['image_id'];
                }
            }
            /*foreach (Kohana::config('attach.sizePresets') as $type => $value)
            {
	            $products[$key]['picurl_'.$type] = self::picurl($product['default_image_id'], $type);
	            //$products[$key]['picurl_ti'] = product::picurl($product['default_image_id'], product::PRODUCTPIC_STANDARDS_TINY);
	            //$products[$key]['picurl_sq'] = product::picurl($product['default_image_id'], product::PRODUCTPIC_STANDARDS_SQUARE);
	            //$products[$key]['picurl_t'] = product::picurl($product['default_image_id'], product::PRODUCTPIC_STANDARDS_THUMBNAIL);
	            //$products[$key]['picurl_s'] = product::picurl($product['default_image_id'], product::PRODUCTPIC_STANDARDS_SMALL);
	            //$products[$key]['picurl_m'] = product::picurl($product['default_image_id'], product::PRODUCTPIC_STANDARDS_MIDDLE);
	            //$products[$key]['picurl_l'] = product::picurl($product['default_image_id'], product::PRODUCTPIC_STANDARDS_LARGE);
            }*/
            $products[$key]['picurl'] =  self::picurl($product['default_image_id'], '');
            $products[$key]['picurl_live'] = substr($products[$key]['picurl'], 0, -(1+strlen(Kohana::config('attach.defaultPostfix'))) );
        }
        return $products;
    }

    /**
     * 添加到wishlist链接
     */
    public static function wishlist_href($product_id)
    {
        $view_html = "";
        $view_html = url::base() . "wishlist/add/" . $product_id;
        return $view_html;
    }

    /**
     * 根据产品ID获取产品的批发数据
     * 
     * @param $product_id  产品ID
     * @return array
     */
    public function wholesales($product_id)
    {
        return Product_wholesaleService::get_instance()->get($product_id);
    }

    /**
     * 计算打折差价
     */
    public static function save_price($product)
    {
    	$diff = BLL_Currency::get_price($product['price'] - $product['discount_price']);
        return $diff;
    }

    /**
     * 计算打折比例
     */
    public static function price_rate($product)
    {
        if ($product['price'] == 0)
        {
            $rate = 0;
        } else
        {
            $rate = round(($product['price'] - $product['discount_price']) / $product['price'] * 100);
        }
        return $rate;
    }

    /**
     * 获取最近浏览产品数据
     * @param $number
     * @return array
     */
    public static function recently_viewed($number)
    {
        $recently_product_ids = array ();
        $recently_viewed = cookie::get('recently_viewed');
        if (! empty($recently_viewed))
        {
            $recently_product_ids = json_decode($recently_viewed, true);
        }
        $recently_products = array ();
        if (! empty($recently_product_ids))
        {
            $recently_product_ids = array_slice($recently_product_ids, 0, $number);
            foreach ($recently_product_ids as $recently_product_id)
            {
                try
                {
                    $recently_product = promotion::category_product(ProductService::get_instance()->get($recently_product_id));
                } catch (MyRuntimeException $ex)
                {
                    continue;
                }
                if ($recently_product['discount_price'] != $recently_product['price'] && $recently_product['price'] != 0)
                {
                    $recently_product['save_rate'] = number_format((1 - $recently_product['discount_price'] / $recently_product['price']) * 100, 2);
                } else {
                    $recently_product['save_rate'] = '0';
                }
                $recently_product['price'] = BLL_Currency::get_price($recently_product['price']);
                $recently_product['discount_price'] = BLL_Currency::get_price($recently_product['discount_price']);
                $recently_product['market_price'] = BLL_Currency::get_price($recently_product['market_price']);
                $recently_products[] = $recently_product;
            }
        }
        return $recently_products;
    }
    
    public function get_lowest_price($product_id)
    {
    	try
    	{
    		$lowest    = 0;
	    	$wholesale = NULL;
	    	
	    	foreach ((array)Product_wholesaleService::get_instance()->get($product_id) as $record)
	    	{
	    		if (is_null($wholesale) OR $wholesale['value'] > $record['value'])
	    		{
	    			$wholesale = $record;
	    		}
	    	}
	    	
	    	if (!is_null($wholesale))
	    	{
		    	$product = ProductService::get_instance()->get($product_id);
		    	$lowest  = Mypromotion::instance()->do_discount($product['price'], $wholesale['type'], $wholesale['value']);
		    	$lowest  = BLL_Currency::get_price($lowest);
	    	}
	    	
	    	return $lowest;
    	} catch (MyRuntimeException $ex) {
    		return 0;
    	}
    }
}
