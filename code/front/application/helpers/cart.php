<?php
defined('SYSPATH') or die('No direct script access.');

class cart_Core {
	
	/**
	 * 取得购物车中货品的数量
	 */
	public static function count()
	{
		$cart = CartService::instance()->get();
        if(!isset($cart['summary']['quantity'])){
            return 0;
        }
        return $cart['summary']['quantity'];
	}
	
	/**
	 * 取得购物车中货品的重量
	 */
	public static function weight()
	{
		$cart = CartService::instance()->get();
        if(!isset($cart['summary']['weight'])){
            return 0;
        }
        return $cart['summary']['weight'];
	}
	
	/**
	 * 得到一个方便cart view使用的数组格式
	 * 这样可以把原本在view里面写的大量if else判断转移
	 * 降低模板制作难度
	 *
	 * @param   Array	$cart_detail
	 * @return  Array	$cart_view
	 */
	public static function get_cart_view()
	{
		$cart_detail = BLL_Cart::get_cart();
        $cart_view = array (
            'product'=>array(),
            'product_d' => array(),
            'summary'=>array_merge(array('current_product_discount_price'=>0,
            'current_discount_price'=>0,
            'current_total_discount_price'=>0,
            'current_total_product_price'=>0,
            ),$cart_detail['summary']),
            'gift_lists'=>array(),
            'description'=>array(),
            'cart_product_category'=>array(),
        'summary_d'=>$cart_detail['summary_d']);
            $total_product_price = 0;
        if (!empty($cart_detail['cart_product']['good']) || !empty($cart_detail['cart_product']['custom']))
		{
			//正常商品
			if (!empty($cart_detail['cart_product']['good']) && is_array($cart_detail['cart_product']['good']))
			{
				foreach ($cart_detail['cart_product']['good'] as $key => $rs)
				{
					$product = array ();
					$product['type'] = 'product';
					$product['id'] = $product['product_id'] = $rs['product_id'];
					$product['good_id'] = $rs['good_id'];
					$product['name'] = $product['title'] = $rs['name'];
					$product['remark'] = $rs['remark'];
					$product['price'] = number_format($rs['current_price'], 2, '.', '');
					$product['discount_price'] = number_format($rs['current_discount_price'], 2, '.', '');
					$product['discount'] = number_format($rs['current_price'] - $rs['current_discount_price'], 2, '.', '');
					$product['quantity'] = $rs['quantity'];
					$product['product_name'] = 'good_cart[]';
					$product['quantity_name'] = 'good_' . $key;
					$product['key'] = $key;
					//小记原价
					$product['sub_total_original'] = number_format($rs['current_price'] * $rs['quantity'], 2, '.', '');
					$product['sub_total'] = number_format($rs['current_discount_price'] * $rs['quantity'], 2, '.', '');
					//折扣金额
					$product['sub_discount'] = number_format($product['sub_total_original'] - $product['sub_total'], 2, '.', '');
					
					$product['brief'] = $rs['brief'];
					$product['sku'] = $rs['SKU'];
					$product['link'] = product::permalink($rs['product_id']);
					$product['image'] = $rs['image'];
					$product['store'] = $rs['store']; //库存
					$product['delete_link'] = url::base() . 'cart/edit_product_quantity/good/' . $key . '/' . ($rs['quantity'] - 1);
					$product['add_link'] = url::base() . 'cart/edit_product_quantity/good/' . $key . '/' . ($rs['quantity'] + 1);
					$product['remove_link'] = url::base() . 'cart/delete/good/' . $key;
					
					if($rs['status'] != 1)
					{
						$total_product_price += $rs['current_price'] * $rs['quantity'];
					}
					
					$cart_view['product_d'][$rs['delivery_category_id']][] = $product;
                    $cart_view['product'][] = $product;
				}
			}
            
			//定制商品
			if (!empty($cart_detail['cart_product']['custom']) && is_array($cart_detail['cart_product']['custom']))
			{
				foreach ($cart_detail['cart_product']['custom'] as $key => $rs)
				{
					$product = array ();
					$product['type'] = 'product';
					$product['product_id'] = $rs['product_id'];
					$product['good_id'] = $rs['good_id'];
					$product['name'] = $product['title'] = $rs['name'];
					$product['remark'] = $rs['remark'];
					
					$product['price'] = number_format($rs['current_price'], 2, '.', '');
					$product['discount_price'] = number_format($rs['current_discount_price'], 2, '.', '');
					$product['discount'] = number_format($rs['current_price'] - $rs['current_discount_price'], 2, '.', '');
					
					$product['quantity'] = $rs['quantity'];
					$product['product_name'] = 'custom_cart[]';
					$product['quantity_name'] = 'custom_' . $key;
					$product['key'] = $key;
					
					//小记原价
					$product['sub_total_original'] = number_format($rs['current_price'] * $rs['quantity'], 2, '.', '');
					$product['sub_total'] = number_format($rs['current_discount_price'] * $rs['quantity'], 2, '.', '');
					//折扣金额
					$product['sub_discount'] = number_format($product['sub_total_original'] - $product['sub_total'], 2, '.', '');
					
					$product['brief'] = $rs['brief'];
					$product['sku'] = $rs['SKU'];
					$product['link'] = product::permalink($rs['product_id']);
					$product['image'] = $rs['image'];
					$product['store'] = $rs['store']; //库存
					$product['delete_link'] = url::base() . 'cart/edit_product_quantity/custom/' . $key . '/' . ($rs['quantity'] - 1);
					$product['add_link'] = url::base() . 'cart/edit_product_quantity/custom/' . $key . '/' . ($rs['quantity'] + 1);
					$product['remove_link'] = url::base() . 'cart/delete/custom/' . $key;
					
					if($rs['status'] != 1)
					{
						$total_product_price += $rs['current_price'] * $rs['quantity'];
					}
					$cart_view['product_d'][$rs['delivery_category_id']][] = $product;
					$cart_view['product'][] = $product;
				}
			}
            
			//gift结构
			if (!empty($cart_detail['cart_product']['gift']) && is_array($cart_detail['cart_product']['gift']))
			{
				foreach ($cart_detail['cart_product']['gift'] as $key => $rs)
				{
					$product = array ();
					$product['type'] = 'gift';
					$product['product_id'] = $rs['product_id'];
					$product['good_id'] = $rs['good_id'];
					$product['name'] = $product['title'] = $rs['name'];
					$product['remark'] = '';
					
					$product['price'] = number_format($rs['current_price'], 2, '.', '');
					$product['discount_price'] = number_format($rs['current_discount_price'], 2, '.', '');
					$product['discount'] = number_format($rs['current_price'] - $rs['current_discount_price'], 2, '.', '');
					
					$product['quantity'] = $rs['quantity'];
					
					//小记原价
					$product['sub_total_original'] = number_format($rs['current_price'] * $rs['quantity'], 2, '.', '');
					$product['sub_total'] = number_format($rs['current_discount_price'] * $rs['quantity'], 2, '.', '');
					//折扣金额
					$product['sub_discount'] = number_format($product['sub_total_original'] - $product['sub_total'], 2, '.', '');
					
					$product['store'] = $rs['store']; //库存
					$product['brief'] = $rs['brief'];
					$product['sku'] = $rs['SKU'];
					$product['link'] = product::permalink($rs['product_id']);
					$product['image'] = $rs['image'];
					$product['remove_link'] = url::base() . 'cart/gift_delete/' . $rs['good_id'] . '/' . $rs['pmt_id'];
					
					
					$total_product_price += $rs['current_price'] * $rs['quantity'];
					$cart_view['product'][] = $product;
					$cart_view['product_d'][$rs['delivery_category_id']][] = $product;
				}
			}
			//购物车内所有商品的原价之和
			$cart_detail['summary']['current_total_product_price'] = number_format($total_product_price, 2, '.', '');
			//产品的折扣总价
			$cart_detail['summary']['current_product_discount_price'] = number_format($cart_detail['summary']['current_product_discount_price'], 2, '.', '');
			//享受的购物车内所有商品折扣金额之和
			$cart_detail['summary']['current_product_total_discount'] = number_format($total_product_price - $cart_detail['summary']['current_product_discount_price'], 2, '.', '');
			//$cart_detail['discount'][]['coupon_code']   $cart_detail['discount'][]['current_discount']
			
			//总共应付金额  $cart_detail['summary']['current_total_discount_price']
			 $cart_detail['summary']['current_total_discount_price'] = number_format($cart_detail['summary']['current_total_discount_price'], 2, '.', '');
			//总共节省金额
			$cart_detail['summary']['current_total_discount'] = number_format($total_product_price - $cart_detail['summary']['current_total_discount_price'], 2, '.', '');
			//current_carrier_price  current_carrier_discount_price
			if(!empty($cart_detail['summary']['carrier_price']))
			{
				//享受的物流折扣金额
				$cart_detail['summary']['current_carrier_price'] = number_format($cart_detail['summary']['current_carrier_price'], 2, '.', '');
				$cart_detail['summary']['current_carrier_discount_price'] = number_format($cart_detail['summary']['current_carrier_discount_price'], 2, '.', '');
				$cart_detail['summary']['current_carrier_discount'] = number_format($cart_detail['summary']['current_carrier_price'] - $cart_detail['summary']['current_carrier_discount_price'], 2, '.', '');
				$cart_detail['summary']['current_total_discount'] = number_format($total_product_price + $cart_detail['summary']['current_carrier_price'] - $cart_detail['summary']['current_total_discount_price'], 2, '.', '');
			}
			//享受的购物车折扣金额
			$cart_detail['summary']['current_discount_cart'] = number_format($cart_detail['summary']['current_product_discount_price'] - $cart_detail['summary']['current_discount_price'], 2, '.', '');
			
			$cart_view['summary'] = $cart_detail['summary'];
			//取得折扣券
			$discount = array();
			if(!empty($cart_detail['discount']))
			{
				foreach($cart_detail['discount'] as $value)
				{
					$discount = $value;
					break;
				}
				$cart_detail['summary']['current_coupon_discount'] = number_format($discount['current_discount'], 2, '.', '');
			}
			
			//打折促销描述处理
			$cart_view['description'] = isset($cart_detail['description']) ? $cart_detail['description'] : array ();
			
			$cart_view['gift_lists'] = array ();
			if (!empty($cart_detail['gift_lists']) && is_array($cart_detail['gift_lists']))
			{
				foreach ($cart_detail['gift_lists'] as $key => $rs)
				{
					$gift['discount_price'] = number_format($rs['current_discount_price'], 2, '.', '');
					$gift['price'] = number_format($rs['current_price'], 2, '.', '');
					$gift['link'] = product::permalink($rs['product_id']);
					$gift['pmt_id'] = $rs['pmt_id'];
					$gift['sku'] = $rs['SKU'];
					$gift['image'] = $rs['image'];
					$gift['name'] = $rs['name'];
					$gift['product_id'] = $rs['product_id'];
					$gift['good_id'] = $rs['good_id'];
					$cart_view['gift_lists'][] = $gift;
				}
			}
			if (isset($cart_view['cart_shipping']['country']))
			{
				$cart_view['cart_shipping']['country_name'] = Mycountry::instance()->get_name_by_iso($cart_view['cart_shipping']['country']);
			}
			
			//购物车产品分类
			$cart_view['cart_product_category'] = $cart_detail['cart_product_category'];
			isset($cart_detail['ship_promotion_discount']) && $cart_view['ship_promotion_discount'] = $cart_detail['ship_promotion_discount'];
			
			//税费
		    if(!empty($cart_detail['tax']))
		    {
			    $cart_view['tax'] = $cart_detail['tax'];
		    }
            return $cart_view;
        }else{
            return false;
        }
	}
    public function get_summary_cart_view()
    {
        $cart = $this->get_cart_view();
        if(count($cart['summary_d']) <= 1 ){
            return $cart;
        }else{
            $products = array();
            foreach($cart['cart_product'] as $key=>$product){
                if(!isset($products[$product['delivery_category_id']])){
                    $products[$product['delivery_category_id']] = array();
                }
                $products[$product['delivery_category_id']][] = $product;
            }
            $cart['product_d'] = $products;
            return $cart;
        }
    }
    
    static public function get_ship_promotion_script($cart_view)
    {
    	$return_str = '';
    	$return_str .= '<script type="text/javascript">';
    	if(empty($cart_view['ship_promotion_discount']) || !is_array($cart_view['ship_promotion_discount'])){
    		$return_str .= 'var ship_promotion_arr = '.json_encode(array()).';';
    	}else{
    		$return_struct = array();
    	    foreach($cart_view['ship_promotion_discount'] as $key=>$cart_ship_promotion)
	    	{
	    		$return_struct[$key]['discount_type'] = $cart_ship_promotion['discount_type'];
	    		$return_struct[$key]['discount_value'] = $cart_ship_promotion['discount_value'];
	    		$return_struct[$key]['current_discount_value'] = $cart_ship_promotion['current_discount_value'];
	    	}
	    	$return_str .= 'var ship_promotion_arr = '.json_encode($return_struct).';';
    	}
    	$summary_info = isset($cart_view['summary']) && is_array($cart_view['summary']) ? $cart_view['summary'] : array();
    	$return_str .= 'var cart_summary_arr = '.json_encode($summary_info).';';
    	$return_str .= '</script>';

    	return $return_str;
    }
    static public function do_discount_script()
    {
		return '<script type="text/javascript">
    		function do_discount(price, promotion_info)
    		{
    			var return_price = 0;
    			switch(promotion_info[\'discount_type\'])
    			{
    				case 0:
    					return_price = price * promotion_info[\'current_discount_value\'];
    					break;
    				case 1:
    					return_price = price - promotion_info[\'current_discount_value\'];   				
    					break;
    				case 2:
    					return_price = promotion_info[\'current_discount_value\'];
    					break;
    				default:
    					return_price = price;
    					break;
    			}
    			return_price *= 100;
    			return_price = Math.round(return_price)/100;
    			if(return_price.toString().indexOf(\'.\') != -1)
    			{
    				var str_arr = return_price.toString().split(".");
    				var length = str_arr[1].length;
    				if(length == 0){
    					return_price += \'00\';
    				}else if(length == 1) {
    					return_price += \'0\';
    				}
    			}else{
    				return_price += \'.00\';
    			}
    			return return_price;
    		}
    	</script>';
    }
}

