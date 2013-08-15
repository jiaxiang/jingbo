<?php defined('SYSPATH') OR die('No direct access allowed.');

class order_Core {
    /**
     * 添加新订单
     */
    public static function add($cart_data, $user, $currency){
        //订单产品存不存在
        if($cart_data['summary']['quantity'] <= 0){
            log::write('data_error', $cart_data, __FILE__, __LINE__);
            remind::set(kohana::lang('o_order.o_order_order_add_quantity'), 'error', url::base());
            //error log
            return FALSE;
        }
        
        //物流验证
        $carrier_id = '';
        $carrier_name = '';
        if(isset($cart_data['carrier']) && is_array($cart_data['carrier'])){
            try{
                $carrier_id = ',';
                $carrier_name = ',';
                foreach($cart_data['carrier'] as $key=>$value){
                    $delivery = DeliverycnService::get_instance()->get($value['carrier_id']);
                    $cart_data['carrier'][$key]['name'] = $delivery['name'];
                    $carrier_id .= $value['carrier_id'].',';
                    $carrier_name .= $delivery['name'].',';
                }
            } catch (MyRuntimeException $ex) {
                log::write('data_error', $cart_data, __FILE__, __LINE__);
                //error log
                return FALSE;
            }
            
            foreach($cart_data['carrier'] as $value){
                if (empty($value['name'])){
                    log::write('data_error', $value, __FILE__, __LINE__);
                    return FALSE;
                }
            }
        }
        
        //库存的验证，准备数据
        $good_cart_quantity = array();
        foreach($cart_data['cart_product'] as $type=>$goods){
            foreach($goods as $good){
                !isset($good_cart_quantity[$good['good_id']]['quantity']) && $good_cart_quantity[$good['good_id']]['quantity'] = 0;
                $good_cart_quantity[$good['good_id']]['quantity'] += $good['quantity'];
                $good_cart_quantity[$good['good_id']]['product_id'] = $good['product_id'];
                /*if($good['type'] == 2){
                    foreach($good['goods_binding'] as $g){
                        !isset($good_cart_quantity[$g['id']]['quantity']) && $good_cart_quantity[$g['id']]['quantity'] = 0;
                        $good_cart_quantity[$g['id']]['quantity'] +=  (isset($g['quantity']) ? $g['quantity'] : 1)*$good['quantity'];
                        $good_cart_quantity[$g['id']]['product_id'] = $g['product_id'];
                    }
                }*/
            }
        }
        //验证库存
        $product_service = ProductService::get_instance();
        foreach($good_cart_quantity as $good_id=>$data){
            $good = $product_service->get_good($data['product_id'], $good_id);
            if(!empty($good) && $good['store'] != -1 && $good['store']<$data['quantity']){
                Mycart::instance()->remove_carrier();
                remind::set($good['name'].kohana::lang('o_order.o_order_out_of_store'), 'error', '/cart');
            }
        }
        
        //生成订单号
        $order_num = '';
        do{
            $temp = date('YmdHis') .rand(0, 99999);
            
            $exist_data = array (); 
            $exist_data['order_num'] = $temp;
            if(!Myorder::instance()->exist($exist_data)){
                $order_num = $temp;
                break;
            }
          } while (1);
        
        //订单主信息
        $order_data = array ();
        $order_data['mark'] = isset($cart_data['message'])?$cart_data['message']:'';
        $order_data['order_num'] = $order_num;
        $order_data['user_id'] = $user['id'];
        $order_data['email'] = $user['email'];
        $order_data['total'] = $cart_data['summary']['current_total_discount_price'];
        $order_data['currency'] = $currency['code'];
        $order_data['conversion_rate'] = $currency['conversion_rate'] ? $currency['conversion_rate'] : 1;
        
        //物流原始金额以及物流价格记录
        $order_data['total_shipping_original'] = $cart_data['summary']['current_carrier_price'];
        $order_data['total_shipping'] = $cart_data['summary']['current_carrier_discount_price'];
        
        $order_data['total_discount'] = $cart_data['summary']['current_total_price'] - $cart_data['summary']['current_total_discount_price'];
        //购物车打折后的价格记录
        $order_data['total_products'] = $cart_data['summary']['current_discount_price'];
        //打折号以及打折优惠记录
        $order_data['discount_num'] = '';
        $order_data['total_coupon'] = 0;
        if(!empty($cart_data['discount'])){
            foreach($cart_data['discount'] as $discount){
                $order_data['discount_num'] .= $discount['coupon_code'];
                $order_data['total_coupon'] += $discount['current_discount'];
            }
        }
        //$order_data['total_coupon'] = $order_data['total_coupon'];
        $order_data['total_shipping_original'] = $cart_data['summary']['current_carrier_price'];
        if(!empty($cart_data['cart_shipping'])){
            $order_data['shipping_firstname'] = $cart_data['cart_shipping']['firstname'];
            $order_data['shipping_lastname'] = $cart_data['cart_shipping']['lastname'];
            $order_data['shipping_country'] = $cart_data['cart_shipping']['country'];
            $order_data['shipping_state'] = $cart_data['cart_shipping']['state'];
            $order_data['shipping_city'] = $cart_data['cart_shipping']['city'];
            $order_data['shipping_address'] = $cart_data['cart_shipping']['address'];
            $order_data['shipping_zip'] = $cart_data['cart_shipping']['zip'];
            $order_data['shipping_phone'] = $cart_data['cart_shipping']['phone'];
            $order_data['shipping_mobile'] = $cart_data['cart_shipping']['phone_mobile'];
        }
        if (!empty($cart_data['cart_billing'])){
            $order_data['billing_firstname'] = $cart_data['cart_billing']['firstname'];
            $order_data['billing_lastname'] = $cart_data['cart_billing']['lastname'];
            $order_data['billing_country'] = $cart_data['cart_billing']['country'];
            $order_data['billing_state'] = $cart_data['cart_billing']['state'];
            $order_data['billing_city'] = $cart_data['cart_billing']['city'];
            $order_data['billing_address'] = $cart_data['cart_billing']['address'];
            $order_data['billing_zip'] = $cart_data['cart_billing']['zip'];
            $order_data['billing_phone'] = $cart_data['cart_billing']['phone'];
            $order_data['billing_mobile'] = $cart_data['cart_billing']['phone_mobile'];
        }
        
        $order_data['pay_status'] = 1;
        $order_data['ship_status'] = 1;
        $order_data['user_status'] = 'null';
        $order_data['order_source'] = 'site';
        $order_data['order_status'] = 1;
        $order_data['total_real'] = $cart_data['summary']['total_discount_price'];
        $order_data['total_paid'] = 0;
        $order_data['trans_id'] = '';
        $order_data['ems_num'] = '';
        $order_data['carrier_id'] = $carrier_id;
        $order_data['carrier'] = $carrier_name;
        $order_data['supplier'] = '';
        $order_data['date_add'] = tool::get_date();
        $order_data['date_upd'] = tool::get_date();
        $order_data['ip'] = tool::get_long_ip();
        $order_data['active'] = 1;
        if(isset($cart_data['tax'])){
            $order_data['tax'] = $cart_data['tax'];
        }

        //添加订单，返回订单数据
        $order = Myorder::instance()->add($order_data);
        
        //添加订单产品信息
        if(!empty($cart_data['cart_product']['good']) && is_array($cart_data['cart_product']['good'])){
            foreach ($cart_data['cart_product']['good'] as $key => $rs) {
                //正常产品
                if (!empty($rs['product_id']) && $rs['status'] == 0) {
                    $order_product_detail_data = array ();
                    $order_product_detail_data['order_id'] = $order['id'];
                    $order_product_detail_data['product_type'] = $rs['type'];
                    /*if($rs['type']==2){
                        //捆绑商品
                        $order_product_detail_data['product_type'] = 3;
                    }*/
                    $order_product_detail_data['dly_status'] = 'storage';
                    //$order_product_detail_data['product_detail_type']   = 1;
                    $order_product_detail_data['product_id'] = $rs['product_id'];
                    $order_product_detail_data['good_id'] = $rs['good_id'];
                    $order_product_detail_data['quantity'] = $rs['quantity'];
                    $order_product_detail_data['price'] = $rs['current_price'];
                    $order_product_detail_data['discount_price'] = $rs['current_discount_price'];
                    $order_product_detail_data['subtotal'] = $rs['current_discount_price']*$rs['quantity'];
                    $order_product_detail_data['weight'] = $rs['weight'];
                    $order_product_detail_data['name'] = $rs['name'];
                    $order_product_detail_data['link'] = product::permalink($rs['product_id']);
                    $order_product_detail_data['brief'] = $rs['brief'];
                    $order_product_detail_data['SKU'] = $rs['SKU'];
                    
                    $order_product_detail_data['attribute_style'] = $rs['attribute'];
                    $order_product_detail_data['remark'] = $rs['remark'];
                    $order_product_detail_data['image'] = $rs['image'];
                    $order_product_detail_data['date_add'] = tool::get_date();
                    
                    if(isset($cart_data['carrier'][ $rs['delivery_category_id'] ]['carrier_id'])){
                        $order_product_detail_data['shipping_id'] = $cart_data['carrier'][ $rs['delivery_category_id'] ]['carrier_id'];
                    }elseif(isset($cart_data['carrier'][1])){
                        $order_product_detail_data['shipping_id'] = $cart_data['carrier'][1]['carrier_id'];
                    }else{
                        $order_product_detail_data['shipping_id'] = 0;
                    }
                    $order_product_detail_data['type'] = $rs['delivery_category_id'];
                    
                    if(isset($cart_data['summary_d'][ $rs['delivery_category_id'] ]['current_carrier_price'])){
                        $order_product_detail_data['shipping_cost'] = $cart_data['summary_d'][ $rs['delivery_category_id'] ]['current_carrier_price'];
                    }else{
                        $order_product_detail_data['shipping_cost'] = $cart_data['summary']['current_carrier_price'];
                    }
                    //添加订单产品详情
                    $order_product_detail = Myorder_product::instance()->add($order_product_detail_data);
                    
                    //下单成功即时减掉抢购商品的的库存
                    if($rs['is_rush']==1){
                        ProductService::get_instance()->update_product_rush_store($rs);
                    }
                    
                    /*
                    //配件
                    if(isset($rs['accessory'])&&is_array($rs['accessory']))
                    {
                        foreach($rs['accessory'] as $key2=>$rs2)
                        {
                            $order_product_detail        = array(); 
                            $order_product_detail_data['order_id']             = $order['id'];
                            $order_product_detail_data['order_product_id']     = $order_product['id'];
                            $order_product_detail_data['product_type']         = 1;
                            $order_product_detail_data['product_detail_type']  = 2;
                            $order_product_detail_data['product_id']           = $rs2['id'];
                            $order_product_detail_data['product_attribute_id'] = $rs2['attribute']['id'];
                            $order_product_detail_data['quantity']             = $rs2['quantity']*$rs['quantity'];
                            $order_product_detail_data['price']                = $rs2['attribute']['price'];
                            $order_product_detail_data['discount_price']       = $rs2['attribute']['discount_price'];
                            $order_product_detail_data['weight']               = $rs2['attribute']['weight'];
                            $order_product_detail_data['name']                 = $rs2['name'];
                            $order_product_detail_data['name_url']             = $rs2['name_url'];
                            $order_product_detail_data['SKU']                  = $rs2['SKU'];

                            $attribute_style_temp       = '';
                            foreach($rs2['attribute']['attribute'] as $key3=>$rs3)
                            {
                                $attribute_style_temp   = $rs3['group_name'].'-'.$rs3['name'].',';
                            }
                            $attribute_style_temp       = trim($attribute_style_temp,',');

                            $order_product_detail_data['attribute_style']      = $attribute_style_temp;
                            $order_product_detail_data['image_SKU']            = $rs2['default_image']['image'];
                            $order_product_detail_data['date_add']             = $cart_data['date_add'];
                            //添加订单产品详情
                            $order_product_detail = Myorder_product_detail::instance()->add($order_product_detail_data);
                        }
                    }
                     */
                } else {
                    //Error Log
                    continue;
                }
            }
        }
        //添加订单定制产品信息
        if (!empty($cart_data['cart_product']['custom']) && is_array($cart_data['cart_product']['custom']))
        {
            foreach ($cart_data['cart_product']['custom'] as $key => $rs)
            {
                //正常产品
                if (!empty($rs['product_id']) && $rs['status'] == 0)
                {
                    $order_product_detail_data = array ();
                    $order_product_detail_data['order_id'] = $order['id'];
                    //$order_product_detail_data['order_product_id']      = $order_product['id'];
                    $order_product_detail_data['product_type'] = 4;//定制产品
                    $order_product_detail_data['dly_status'] = 'storage';
                    //$order_product_detail_data['product_detail_type']   = 1;
                    $order_product_detail_data['product_id'] = $rs['product_id'];
                    $order_product_detail_data['good_id'] = $rs['good_id'];
                    $order_product_detail_data['quantity'] = $rs['quantity'];
                    $order_product_detail_data['price'] = $rs['current_price'];
                    $order_product_detail_data['discount_price'] = $rs['current_discount_price'];
                    $order_product_detail_data['subtotal'] = $rs['current_discount_price']*$rs['quantity'];
                    $order_product_detail_data['weight'] = $rs['weight'];
                    $order_product_detail_data['name'] = $rs['name'];
                    $order_product_detail_data['link'] = product::permalink($rs['product_id']);
                    $order_product_detail_data['brief'] = $rs['brief'];
                    $order_product_detail_data['SKU'] = $rs['SKU'];
                    
                    $order_product_detail_data['attribute_style'] = $rs['attribute'];
                    $order_product_detail_data['remark'] = $rs['remark'];
                    $order_product_detail_data['image'] = $rs['image'];
                    $order_product_detail_data['date_add'] = tool::get_date();
                    $order_product_detail_data['shipping_id'] = $cart_data[ $rs['carrier']['delivery_category_id'] ]['carrier_id'];
                    $order_product_detail_data['type'] = $rs['delivery_category_id'];
                    $order_product_detail_data['shipping_cost'] = $cart_data['summary_d'][ $rs['delivery_category_id'] ]['current_carrier_price'];
                    //添加订单产品详情
                    $order_product_detail = Myorder_product::instance()->add($order_product_detail_data);
                } 
                else
                {
                    //Error Log
                    continue;
                }
            }
        }
        
        //添加订单赠品品信息
        if (!empty($cart_data['cart_product']['gift']) && is_array($cart_data['cart_product']['gift']))
        {
            $gift_d = array();
            foreach ($cart_data['cart_product']['gift'] as $key => $rs){
                if (key_exists( $rs['delivery_category_id'],$gift_d )) {
                    $gift_d[ $rs['delivery_category_id'] ]['total_price']  += $rs['current_price'];
                    $gift_d[ $rs['delivery_category_id'] ]['total_weight'] += $rs['weight'];
                }else {
                    $gift_d[ $rs['delivery_category_id'] ] = array(
                        'total_price'  => $rs['current_price'],
                        'total_weight' => $rs['weight'],
                        'country'      => $cart_data['carrier'][ $rs['delivery_category_id'] ]['country'],
                        'delivery_id'  => $cart_data['carrier'][ $rs['delivery_category_id'] ]['carrier_id'],
                        );
                }
            }
            if (!empty($gift_d)) {
                foreach ($gift_d as $key => $gd){
                    $country = Mycountry::instance()->get_by_iso($gd['country']);
                    $country_id = $country['id'];
                    $condition = array(
                        'delivery_id'          => $gd['delivery_id'],        //物流ID
                        'country_id'           => $country_id,       //物流递送国家
                        'weight'               => $gd['total_weight'],       //订单重量
                        'total_price'          => $gd['total_price'],    //订单总价
                    );
                    $gift_d[$key]['delivery_price'] = Bll_delivery::get_delivery_price_by_condition($condition);
                }
            }
            //print_r($cart['cart_product']['gift']);
            foreach ($cart_data['cart_product']['gift'] as $key => $rs)
            {
                //赠品
                if (!empty($rs['product_id']))
                {
                    /*
                    $order_product_data      = array(); 
                    $order_product_data['order_id']        = $order['id'];
                    $order_product_data['product_type']    = 2;
                    $order_product_data['quantity']        = $rs['quantity'];
                    $order_product_data['price']           = $rs['price'];
                    $order_product_data['discount_price']  = $rs['discount_price'];
                    $order_product_data['name']            = $rs['info'];
                    $order_product_data['image_SKU']       = $rs['gift']['image'];

                    //添加订单产品(产品快照)
                    $order_product = Myorder_product::instance()->add($order_product_data);
                     */
                    
                    $order_product_detail_data = array (); 
                    $order_product_detail_data['order_id'] = $order['id'];
                    //$order_product_detail_data['order_product_id']     = $order_product['id'];
                    $order_product_detail_data['product_type'] = 2;
                    $order_product_detail_data['dly_status'] = 'storage';
                    //$order_product_detail_data['product_detail_type']  = 1;
                    $order_product_detail_data['product_id'] = $rs['product_id'];
                    $order_product_detail_data['good_id'] = $rs['good_id'];
                    $order_product_detail_data['quantity'] = $rs['quantity'];
                    $order_product_detail_data['price'] = $rs['current_price'];
                    $order_product_detail_data['discount_price'] = $rs['current_discount_price'];
                    $order_product_detail_data['subtotal'] = $rs['current_discount_price']*$rs['quantity'];
                    $order_product_detail_data['weight'] = $rs['weight'];
                    $order_product_detail_data['name'] = $rs['name'];
                    $order_product_detail_data['link'] = product::permalink($rs['product_id']);
                    $order_product_detail_data['brief'] = $rs['brief'];
                    $order_product_detail_data['SKU'] = $rs['SKU'];
                    
                    $order_product_detail_data['attribute_style'] = $rs['attribute'];
                    $order_product_detail_data['image'] = $rs['image'];
                    $order_product_detail_data['date_add'] = tool::get_date();
                    $order_product_detail_data['shipping_id'] = $cart_data['carrier'][ $rs['delivery_category_id'] ]['carrier_id'];
                    $order_product_detail_data['type'] = $rs['delivery_category_id'];
                    
                    if ( isset($cart_data['summary_d'][ $rs['delivery_category_id'] ]) ) {
                        $order_product_detail_data['shipping_cost'] = $cart_data['summary_d'][ $rs['delivery_category_id'] ]['current_carrier_price'];
                    }else {
                        $order_product_detail_data['shipping_cost'] = $gift_d[ $rs['delivery_category_id'] ]['delivery_price'];
                    }
                    
                    /*
                    print_r($order_product_detail_data); 
                    exit;
                     */
                    //添加订单产品详情
                    $order_product_detail = Myorder_product::instance()->add($order_product_detail_data);
                } else
                {
                    //Error Log
                    continue;
                }
            }
        }
        //订单打折log
        if (!empty($cart_data['promotion']) && is_array($cart_data['promotion']))
        {
            foreach ($cart_data['promotion'] as $key => $rs)
            {
                $data = $rs;
                if(isset($data['discount_type']) && isset($data['current_discount_value']) && $data['discount_type']!=0)
                {
                    $data['discount_value'] = $data['current_discount_value'];
                } 
                $data['order_id'] = $order['id'];
                $data['discount_type_id'] = $rs['pmts_id'];
                Myorder_discount_log::instance()->add($data);
            }
        }
        if (!empty($cart_data['discount']) && is_array($cart_data['discount']))
        {
            foreach ($cart_data['discount'] as $key => $rs)
            {
                $data = $rs;
                if(isset($data['discount_type']) && isset($data['discount_value']) && $data['discount_type']!=0)
                {
                    $data['discount_value'] = $data['discount_value'];
                } 
                $data['order_id'] = $order['id'];
                $data['discount_type_id'] = $rs['cpns_id'];
                Myorder_discount_log::instance()->add($data);
                //作废打折号                
                Mypromotion::instance()->expire_coupon($rs['coupon_code']);
            }
        
        }
        //添加订单留言
        if (isset($cart_data['message'])){
            $order_message_data = array (); 
            $order_message_data['order_id'] = $order['id'];
            $order_message_data['manager_id'] = 0;
            $order_message_data['type'] = 0;
            $order_message_data['message'] = $cart_data['message'];
            $order_message_data['ip'] = tool::get_str_ip();
            $order_message_data['date_add'] = tool::get_date();
            $order_message_data['active'] = 1;
            //订单留言信息
            Myorder_message::instance()->add($order_message_data);
        }
        
        mail::order_created($order_num);
        return $order_num;
    
    }

    /**
     * 订单详情
     */
    public static function get_detail($order){
        //取得币种的符号
        $currency = BLL_Currency::get($order['currency']);
        $order['currency_sign'] = !empty($currency)?$currency['sign']:'';
        //读取配置文件的信息
        $config = kohana::config('order');
        
        //        $order['order_status'] = Myorder_status::instance($order['pay_status'])->get();
        $order['order_history'] = Myorder_history::instance()->order_histories(array (
            'order_id' => $order['id'] 
        ));
        
        $order['order_message'] = Myorder_message::instance()->order_messages(array (
            'order_id' => $order['id'] 
        ));
        $order['order_product'] = Myorder_product::instance()->order_products(array (
            'order_id' => $order['id'] 
        ));
        
        //用户的礼品卡
        $order['order_giftcard'] = ORM::factory('user_giftcard')->where('order_id', $order['id'])->find()->as_array();

        $order['payment'] = Mypayment::instance($order['payment_id'])->get();
        $order['payment']['payment_type'] = Mypayment_type::instance($order['payment']['payment_type_id'])->get();
        //        print_r($order['order_history']);exit;
        foreach ($order['order_history'] as $key => $value)
        {
            $order_his = $order['order_history'][$key];
                if(!empty($config[$order_his['status_flag']])){
                    $order_status_temp = !empty($config[$order_his['status_flag']][$order_his[$order_his['status_flag']]]['front_name'])?
                                        $config[$order_his['status_flag']][$order_his[$order_his['status_flag']]]['front_name']:
                                        'Processing';
                } else {
                    $order_status_temp = 'Processing';
                }
            $order['order_history'][$key]['status'] = $order_status_temp;
        }
        //记录原始总原价
        $order['total_products'] = 0;
        $order['total_product_price'] = 0;   //购物车内所有商品的原价之和
        $order['total_product_discount_price'] = 0;  //享受的购物车内所有商品折扣金额之和
        $delivaries = $delivary_cats = array();
        foreach ($order['order_product'] as $key => $rs)
        {
            $order['total_products'] += $rs['quantity'];
            $rs['subtotal'] = $rs['price'] * $rs['quantity'];
            $order['order_product'][$key]['price'] = number_format($rs['price'], 2, '.', '');
            $order['order_product'][$key]['discount_price'] = number_format($rs['discount_price'], 2, '.', '');
            $order['order_product'][$key]['format_discount_price'] = $order['order_product'][$key]['discount_price'];
            
            //单个商品小记原价
            $order['order_product'][$key]['sub_total'] = number_format($rs['subtotal'], 2, '.', '');
            $order['order_product'][$key]['subtotal'] = $order['order_product'][$key]['sub_total'];
            $order['order_product'][$key]['format_sub_total'] = $order['order_product'][$key]['sub_total'];
            
            //单个商品小记打折价
            $order['order_product'][$key]['sub_discount_total'] = number_format($rs['subtotal'], 2, '.', '');
            //单个商品小记折扣金额
            $order['order_product'][$key]['sub_discount'] = 
                number_format($order['order_product'][$key]['sub_total'] - $order['order_product'][$key]['sub_discount_total'], 2, '.', '');
            //单个商品享受的折扣金额
            $order['order_product'][$key]['discount'] = number_format($rs['price'] - $rs['discount_price'], 2, '.', '');
            
            //add by gehaifeng
            if (isset($rs['type']) && !in_array($rs['type'],$delivary_cats) ) {
                $delivary_cats[] = $rs['type'];
                if ( !key_exists($rs['shipping_id'],$delivaries ) ) {
                    //对之前结构的兼容处理
                    if ($rs['shipping_id'] == 0) {
                        if ($order['carrier_id'] == 0) {
                            $delivaries[$rs['shipping_id']] = array(
                                'id'             => $order['carrier_id'],
                                'name'           => 'default',
                                'delay'          => '5-7 days',
                                'cat_id'          => '0',
                                'cat_name'       => 'default',
                                'delivery_price' => $order['total_shipping'],
                                'currency_sign'  => $order['currency_sign'],
                            );
                        }else {
                            $delivary = Bll_delivery::get_delivery($order['carrier_id']);
                            $delivaries[$rs['shipping_id']] = array(
                                'id'             => $delivary['id'],
                                'name'           => $delivary['name'],
                                'delay'          => $delivary['delay'],
                                'cat_id'          => $delivary['delivery_category_id'],
                                'cat_name'       => delivery_category::get_name_by_id($delivary['delivery_category_id']),
                                'delivery_price' => $delivary['total_shipping'],
                                'currency_sign'  => $order['currency_sign'],
                            );
                        }
                        
                    }
                    //对当前物流结构的处理
                    else {
                        $delivary = Bll_delivery::get_delivery($rs['shipping_id']);
                        $delivaries[$rs['shipping_id']] = array(
                            'id'             => $rs['shipping_id'],
                            'name'           => $delivary['name'],
                            'delay'          => $delivary['delay'],
                            'cat_id'          => $rs['type'],
                            'cat_name'       => delivery_category::get_name_by_id($rs['type']),
                            'delivery_price' => $rs['shipping_cost'],
                            'currency_sign'  => $order['currency_sign'],
                        );
                    }
                }else {
                    $delivaries[$rs['shipping_id']]['delivery_price'] += $rs['shipping_cost'];
                }
            }
            
            $order['total_product_price'] += $order['order_product'][$key]['sub_total'];
            $order['total_product_discount_price'] += $order['order_product'][$key]['sub_discount_total'];
        }
        $order['delivaries'] = array_values($delivaries);
        $order['total'] = number_format($order['total'], 2, '.', '');
        $order['format_total'] = $order['total'];
        
        $order['total_real'] = number_format($order['total_real'], 2, '.', '');
        $order['total_discount'] = number_format($order['total_discount'], 2, '.', '');
        $order['format_total_discount'] = $order['total_discount'];
        
        $order['total_paid'] = number_format($order['total_paid'], 2, '.', '');
        $order['total_coupon'] = isset($order['total_coupon'])?number_format($order['total_coupon'], 2, '.', ''):0;
        $order['total_products'] = number_format($order['total_products'], 2, '.', '');
        $order['total_product_price'] = number_format($order['total_product_price'], 2, '.', '');
        $order['format_total_products'] = $order['total_product_price'];
        $order['total_product_discount_price'] = number_format($order['total_product_discount_price'], 2, '.', '');
        $order['product_total_discount'] = number_format($order['total_product_price'] - $order['total_product_discount_price'], 2, '.', '');
        $order['total_shipping_original'] = isset($order['total_shipping_original'])?number_format($order['total_shipping_original'], 2, '.', ''):0;
        $order['total_shipping'] = number_format($order['total_shipping'], 2, '.', '');
        $order['format_total_shipping'] = $order['total_shipping'];
        $order['shipping_discount'] = number_format($order['total_shipping_original'] - $order['total_shipping'], 2, '.', '');
        $order['cart_discount'] = number_format($order['total_product_discount_price'] - $order['total_products'], 2, '.', '');
        return $order;
    }

    /**
     * 订单烈表
     */
    public static function get_list($orders)
    {
        foreach ($orders as $key => $rs)
        {
            self::order_data_format($orders[$key]);
            $orders[$key]['data_add'] = $rs['date_add'];
            $orders[$key]['detail_link'] = '<a href="' . url::base() . 'order/order_detail/' . $rs['order_num'] . '">' . $rs['order_num'] . '</a>';
            $currency =  BLL_Currency::get($rs['currency']);

            $orders[$key]['currency_sign'] = !empty($currency)?$currency['sign']:'';            
            $orders[$key]['order_status_show'] = $rs['order_status']['user_show'];
            if ($rs['pay_status'] == 1)
            {
                $orders[$key]['to_pay_link'] = '<a href="' . url::base(false, site::protocol()) . 'payment/billing/' . $rs['order_num'] . '">to pay</a>';
            } else
            {
                $orders[$key]['to_pay_link'] = '&nbsp;';
            }
        }
        return $orders;
    }
    
    /**
     * 转换订单金额的格式
     * @param array $order
     * @param int $decimal
     */
    public function order_data_format(&$order, $decimal = 2)
    {
        //订单的价格的处理
        $fields = array('total', 'total_products', 'total_shipping', 'total_discount', 
            'total_real', 'total_paid', 'total_coupon', 'total_shipping_original', 'total_coupon');
        foreach($order as $field=>$value)
        {
            if(in_array($field, $fields))
            {
                if($field == 'total')
                {
                    $order['format_total'] = number_format($order[$field], $decimal, '.', ',');
                }
                else
                {
                    $order[$field] = number_format($order[$field], $decimal, '.', '');
                }
            }
        }
    }
    /**
     * 编辑订单
     */
    public function edit(&$order)
    {
        if ($_POST)
        {
            
            //非法字符的过滤
            tool::filter_strip_tags($_POST);
            
            $post = new Validation($_POST);
            $post->pre_filter('trim');
            if (isset($_POST['billing_firstname']))
            {
                $post->add_rules('billing_firstname', 'required', 'length[0,200]');
                $post->add_rules('billing_lastname', 'required', 'length[0,200]');
                $post->add_rules('billing_address', 'required', 'length[0,200]');
                $post->add_rules('billing_zip', 'required', 'length[0,200]');
                $post->add_rules('billing_city', 'required', 'length[0,200]');
                $post->add_rules('billing_state', 'length[0,200]');
                $post->add_rules('billing_country', 'required', 'length[0,200]');
                $post->add_rules('billing_phone', 'required', 'length[0,200]');
                $post->add_rules('billing_mobile', 'length[0,200]');
            }
            if (isset($_POST['shipping_firstname']))
            {
                $post->add_rules('shipping_firstname', 'required', 'length[0,200]');
                $post->add_rules('shipping_lastname', 'required', 'length[0,200]');
                $post->add_rules('shipping_address', 'required', 'length[0,200]');
                $post->add_rules('shipping_zip', 'required', 'length[0,200]');
                $post->add_rules('shipping_city', 'required', 'length[0,200]');
                $post->add_rules('shipping_state', 'length[0,200]');
                $post->add_rules('shipping_country', 'required', 'length[0,200]');
                $post->add_rules('shipping_phone', 'required', 'length[0,200]');
                $post->add_rules('shipping_mobile', 'length[0,200]');
            }
            
            if(isset($_POST['order_message'])){
                $post->add_rules('order_message', 'length[0,200]');
                //验证不通过，返回
                if(!($post->validate())){
                    $post_errors = $post->errors();
                    $errors = '';
                    foreach ($post_errors as $key => $val){
                        $errors .= $key . kohana::lang('o_order.o_order_order_edit') . $val . '<br/>';
                    }
                    remind::set($errors, 'error',request::referrer());
                }
            }
            
            //加入用户地址表
            if (isset($_POST['shipping_firstname']))
            {
                $address_data = array (); 
                $address_data['order_id'] = $order['id'];
                $address_data['message'] = $post->order_message;
                $address_data['ip'] = tool::get_long_ip();
                $address_data['active'] = 1;
                
                $address_data['firstname'] = $post->shipping_firstname;
                $address_data['lastname'] = $post->shipping_lastname;
                $address_data['address'] = $post->shipping_address;
                $address_data['zip'] = $post->shipping_zip;
                $address_data['city'] = $post->shipping_city;
                $address_data['country'] = $post->shipping_country;
                $address_data['state'] = $post->shipping_state;
                $address_data['phone'] = $post->shipping_phone;
                $address_data['phone_mobile'] = $post->shipping_mobile;
                
                $address_id = $post->address_id;
                if ($address_id){
                    Myaddress::instance($address_id)->edit($order['user_id'], $address_data);
                } else {
                    Myaddress::instance()->add($order['user_id'], $address_data);
                }
            }
            //加入订单留言
            if(!empty($post->order_message)){
                $order_message_data = array (); 
                $order_message_data['order_id'] = $order['id'];
                $order_message_data['message'] = $post->order_message;
                $order_message_data['ip'] = tool::get_long_ip();
                $order_message_data['active'] = 1;
                
                Myorder_message::instance()->add($order_message_data);
            }
            
            $data = $_POST; 
            if ($order = Myorder::instance($order['id'])->edit($data))
            {
                return true;
            } else
            {
                return false;
            }
        }
    }
    
    public static function order_detail($order_num)
    {
        if(!$user = user::logged_in())
        {
            url::redirect(route::action('login')."?redirect=".url::current(TRUE));
        }
        $order = Myorder::instance()->get_user_order_by_order_num($user['id'],$order_num);
        
    } 
    
}
