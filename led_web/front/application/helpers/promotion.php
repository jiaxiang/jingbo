<?php defined ( 'SYSPATH' ) or die ( 'No direct script access.' );

class Promotion_Core{
    //为减少数据库查询，添加的一个静态变量，等同于library下的$instance
    protected static $product_promotion;

    /**
     * 得到产品的促销信息
     *      改动入参为产品信息 2010-06-09 10:08:08
     * 
     * @param array  $product
     * @return array
     */
    public static function product($product_id, $quantity=1)
    {
        if (!isset(self::$product_promotion[$product_id]))
        {
            self::$product_promotion[$product_id] = 
                Mypromotion::instance()->get_product_promotions($product_id, $quantity);
        }
        
        return self::$product_promotion[$product_id] ;
    }

    /**
     * 产品详情页促销计算
     *      新添加 2010-06-09 10:08:22
     *
     * @param array     $product
     * @param int       $quantity 
     * @return array
     */
    public static function product_detail($product,$quantity=1)
    {
        $product_promotion  = self::product($product['id'], $quantity);
        
        //default good price
        $product['discount_price']    = self::product_price($product_promotion,$product['price']); 

        //goods price
        if(!empty($product['goods']))
        {
            foreach($product['goods'] as $good_id=>$good)
            {
                $product['goods'][$good_id]['discount_price']   = self::product_price($product_promotion,$good['price']); 
            }
        }

        //促销文字信息 
        $product['promotions'] = self::product_view(Mypromotion::instance()->get_product_all_promotions($product['id']));

        return $product;
    }


    /**
     * 分类页产品促销计算
     *      新添加 2010-06-09 10:08:22
     *
     * @param array     $products
     * @return array
     */
    public static function category_products($products)
    {
        if(count($products))
        {
            foreach($products as $key=>$_product)
            {
                $products[$key]     = self::category_product($_product); 
            }
        }
        return $products;
    }


    /**
     * 分类页产品促销计算
     *      新添加 2010-06-09 10:08:22
     *
     * @param array     $product
     * @return array
     */
    public static function category_product($product)
    {
        $product_promotion  = self::product($product['id']); 

        //default good price
        $product['discount_price']    = self::product_price($product_promotion,$product['price']); 

        //促销标识
        $product['promotion_count']         = count($product_promotion);
        return $product;
    }

    /**
     * 计算产品的促销价格
     *      改动促销信息提取    2010-06-09 10:34:32
     *
     * @param array     $product_promotion
     * @param float     $price 
     * @param int       $quantity
     * @return float
     */
    public static function product_price($product_promotion, $price)
    {
        if(!empty($product_promotion) && is_array($product_promotion))
        {
            foreach($product_promotion as $key=>$rs)
    	    {
    		    switch($rs['pmts_id'])
    		    {
    			    case 1: // discount_category
    			    case 2: // discount_product_during
    			        if($rs['money_from']<=0&&$rs['money_to']>=0)
    			        {
    			        	$price  = Mypromotion::instance()->do_discount($price,$rs['discount_type'],$rs['discount_value']);
    			        }
    			        break;
    			    case 3: // discount_product_quantity_morethan
    			        	$price  = Mypromotion::instance()->do_discount($price,$rs['discount_type'],$rs['discount_value']);
    			        break;
    		    }
    	    }
        }
        return $price;
    }


    /**
     * 得到产品的促销信息,用于产品页显示
     *      改动促销信息提取 2010-06-09 10:33:11
     *      将产品信息提到入参 2010-06-11 09:25:00
     *
     * @param array     $promotions
     * @param array     $product
     * @return array 
     */
    public static function product_view($promotions)
    {
        $result                 = array();
        $dayTimestamp = 24*3600;
        
	    foreach($promotions as $promotion)
	    {
			foreach($promotion as $value)
			{
				$result[] = $value['description'].
	       			' ('.date('m/d',strtotime($value['time_begin'])).'--'.date('m/d',strtotime($value['time_end'])-$dayTimestamp).')';
			}
	    }
        return $result;
    }

    /**
     * 打折价格显示
     *
     * @param int       $discount_type
     * @param float     $discount_value
     * @return string 
     */
    public static function discount_view($discount_type,$discount_value)
    {
        $string     = '';
        $currency = BLL_Currency::get_base_by_site_id(site::id());
        $currency_sign = !empty($currency)?$currency['sign']:'';
        switch($discount_type)
        {
        case 0:
            $string     = ((1-$discount_value)*100).'% off'; 
            break;
        case 1:
            $string     = $currency_sign . Bll_Currency::get_price($discount_value) .' off';
            break;
        case 2:
            $string     = $currency_sign . Bll_Currency::get_price($discount_value); 
            break;
        }
        return $string;
    }

    /**
     * 检查打折活动ID   取得一个促销活动的id
     * @return int 
     */
    public static function check_promotion_activity() {
        return Mypromotion::instance()->get_promotion_activity_id();
    }



    /**
     * 检查打折活动ID
     *
     * @return int 
     */
    public static function promotion_action() {
        $promotion_activity_id      = Mypromotion::instance()->get_promotion_activity_id();
        $action                     = Myroute::instance()->get_action('promotion');
        return '/'.$action.'/'.$promotion_activity_id;
    }


    /**
     * 检查产品是否有促销信息
     */
    public static function check_product($product_id)
    {
        $promotion  = self::product($product_id); 
        return count($promotion);
    }


//TODO

    /**
     * 得到运费的打折信息
     *
     * @param int $site_id
     * @return array
     */
//    public static function shipping($cart_detail)
//    {
//        $param['cart']      = Mypromotion::instance()->convert_cart($cart_detail);
//        $param['date']      = date('Y-m-d h:i:s',time());
//        $param['coupon_code']       = isset($cart_detail['session_cart']['cart_discount'])?$cart_detail['session_cart']['cart_discount']:'';
//        $result             = Mypromotion::instance($param)->get_shipping_promotions();
//        //购物车信息覆盖
//        if(isset($result['shipping_fee']))
//        {
//            $cart_detail['summary']['carrier_price']    = $result['shipping_fee'];
//            $cart_detail['promotions']                  = array_merge($cart_detail['promotions'],$result['promotions']);
//        }
//
//        $cart_detail['summary']['discount_price']       = $cart_detail['summary']['carrier_price']+$cart_detail['summary']['discount_cart_price'];
//
//        return $cart_detail;
//    }

    /**
     * 得到运费的打折信息
     *
     * @return array
     */
//    public static function carrier($cart_detail,$carriers)
//    {
//        $param['cart']          = Mypromotion::instance()->convert_cart($cart_detail);
//        $param['date']          = date('Y-m-d h:i:s',time());
//        $param['coupon_code']   = isset($cart_detail['session_cart']['cart_discount'])?$cart_detail['session_cart']['cart_discount']:'';
//        $promotion_shipping     = Mypromotion::instance($param)->get_shipping_promotions();
//        if(isset($promotion_shipping['shipping_fee']))
//        {
//            foreach($carriers as $key=>$rs)
//            {
//               $carriers[$key]['shipping_discount']    = $promotion_shipping['shipping_fee'];
//            }
//        }
//        return $carriers;
//    }




    /**
     * 得到运费的打折信息
     *
     * @return array
     */
//    public static function get_shipping_promotion($cart_detail)
//    {
//        $param['cart']      = Mypromotion::instance()->convert_cart($cart_detail);
//        $param['date']      = date('Y-m-d h:i:s',time());
//        $param['coupon_code']       = isset($cart_detail['session_cart']['cart_discount'])?$cart_detail['session_cart']['cart_discount']:'';
//        $result             = Mypromotion::instance($param)->get_shipping_promotions();
//        return $result;
//    }


    /**
     * 检查打折号是否满中订单优惠条件
     */
    public static function check_coupon_condition($coupon_code)
    {
//        return CartService::instance()->check_coupon_condition();
        return BLL_Cart::check_coupon_condition();
    }


    /**
     * 得到促销后的价格
     * 
     * @param $price 原价格
     * @param $discount_type 打折类型（百分比，减去，减到）
     * @param $discount_value 打折值
     */
    public static function discount_price($price, $discount_type, $discount_value) {
        return Mypromotion::instance()->do_discount($price, $discount_type, $discount_value);	
    }





    /************************************************************************************/
    /*********************     购物车批发处理                       *********************/
    /************************************************************************************/
    /**
     * author zhubin
     * 计算批发打折信息
     * param $cart_datail  array
     */
//    public static function whole_sale($cart_datail)
//    {
//    	//判断是否启用产品批发功能
//    	if(!Mysite::instance()->get('is_wholesale'))
//    	{
//            return $cart_datail;
//    	}
//        $products = array();//初始化产品数组
//        $wholeService = Product_wholesaleService::get_instance();
//        //得出产品列表
//        foreach($cart_datail['cart_product']['product'] as $key=>$product)
//        {
//        	$product_id = $product['product']['product_id'];
//            !isset($products[$product_id]) && $products[$product_id] = array();
//            !isset($products[$product_id]['is_wholesale']) && 
//                $products[$product_id]['is_wholesale'] = $product['product']['is_wholesale'];
//            !isset($products[$product_id]['lowest_wholesale_num']) && 
//                $products[$product_id]['lowest_wholesale_num'] = $product['product']['lowest_wholesale_num'];
//            !isset($products[$product_id]['count']) && 
//                $products[$product_id]['count'] = 0;
//            $products[$product_id]['count'] += $product['quantity'];
//        }
//        //计算产品的批发价格
//        foreach($products as $key=>$product){
//            if($product['is_wholesale']){
//                if($product['lowest_wholesale_num'] <= $product['count']){
//                    $products[$key]['price'] = $wholeService->get_price($key,$product['count']);
//                    $products[$key]['status'] = 0;//添加成功
//                }else{
//                    if($product['is_wholesale'] == 1){
//                       $products[$key]['price'] = $wholeService->get_price($key,$product['count']);
//                       $products[$key]['status'] = 1;//可以零售，但是没有达到批发数量
//                       
//                    }
//                    if($product['is_wholesale'] == 2){
//                       $products[$key]['status'] = 2; //禁止零售，没有达到批发数量
//                    }
//                }
//            }
//        }
//        //更新货品的价格
//        foreach($cart_datail['cart_product']['product'] as $key=>$product)
//        {
//            //过滤出可以批发的产品
//            $product_id = $product['product']['product_id'];
//            if(isset($products[$product_id]) && $products[$product_id]['is_wholesale'])
//            {
//                if($products[$product_id]['status'] == 0)
//                {
//                    $discount_price = promotion::discount_price($product['discount_price'],$products[$product_id]['price']['type'],
//                                                                $products[$product_id]['price']['value']);
//                    $cart_datail['cart_product']['product'][$key]['discount_price'] = $discount_price;
//                    $cart_datail['cart_product']['product'][$key]['product']['discount_price'] = $discount_price;
//                    
//                    //页面上的提示信息
//                    !isset($cart_datail['whole_sale']) && $cart_datail['whole_sale'] = array();
//                    !isset($cart_datail['whole_sale'][$product_id]) &&
//                        $cart_datail['whole_sale'][$product_id] = array(
//                                'discount_type'     => $products[$product_id]['price']['type'],
//                                'discount_value'    => $products[$product_id]['price']['value'],
//                                'description'       => $cart_datail['cart_product']['product'][$key]['product']['product_name'].' wholesale.',
//                            );
//                        
//                }
////                if($products[$product_id]['status'] == 1){
////                    !isset($cart_datail['status']) && $cart_datail['status'] = array();
////                    !isset($cart_datail['status'][$product_id]) &&
////                    $cart_datail['status'][$product_id] = 
////                                            array('product_name'=>$product['product']['product_name'],
////                                                  'status' => 1,
////                                                  'type'   => $wholeService->get_price($product_id,$cart_datail['cart_product']['product'][$key]['product']['lowest_wholesale_num']),
////                                                  'num'    => $cart_datail['cart_product']['product'][$key]['product']['lowest_wholesale_num'],
////                                                  );
////                }
//                    //数量没有达到批发数量并且，该产品禁止零售,
//                if($products[$product_id]['status'] == 2)
//                {
//                    !isset($cart_datail['status']) && $cart_datail['status'] = array();
//                    !isset($cart_datail['status'][$product_id]) &&
//                    $cart_datail['status'][$product_id] = 
//                                            array('product_name'=>$product['product']['product_name'],
//                                                  'status' => 2,
//                                                  'type'   => $wholeService->get_price($product_id,$cart_datail['cart_product']['product'][$key]['product']['lowest_wholesale_num']),
//                                                  'num'    => $cart_datail['cart_product']['product'][$key]['product']['lowest_wholesale_num'],
//                                                  );
//                    unset($cart_datail['cart_product']['product'][$key]);
//                }
//            }
//        }
//        $cart_datail = cart::update_cartsummary($cart_datail);
//        return $cart_datail;
//    }


}
