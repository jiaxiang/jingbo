<?php defined('SYSPATH') or die('No direct access allowed.');

class Payment_Controller extends Template_Controller {

    /**
     * 订单支付页面
     */
    public function billing($order_num = NULL){
        try {
            //$this->profiler = new Profiler;
            if (!$order_num){
                log::write('404_error', '404', __FILE__, __LINE__);
                url::redirect('404');
            }
            if(!$user = user::logged_in()){
                url::redirect(route::action('login') . "?redirect=" . url::current(TRUE));
            }
            //获取用户订单
            $order = Myorder::instance()->get_user_order_by_order_num($user['id'], $order_num);
            if (!$order)
            {
                log::write('404_error', '404', __FILE__, __LINE__);
                url::redirect('404');
            }
            $order = order::get_detail($order);
            //可用支付方式
            $payments = Mypayment::instance()->payments();            
    
            $session = Session::instance();
            if ($data = $session->get('data'))
            {
                $payment_id = $data['payment_id'];
                $address = array ();
                $address['billing_firstname'] = $data['billing_firstname'];
                $address['billing_lastname'] = $data['billing_lastname'];
                $address['billing_address'] = $data['billing_address'];
                $address['billing_zip'] = $data['billing_zip'];
                $address['billing_city'] = $data['billing_city'];
                $address['billing_country'] = $data['billing_country'];
                $address['billing_state'] = $data['billing_state'];
                $address['billing_phone'] = $data['billing_phone'];
                $address['billing_mobile'] = $data['billing_mobile'];
            } else {
                if (count($payments) > 0)
                {
                    foreach($payments as $payment)
                    {
                        $payment_id = $payment['id'];
                        break;
                    }
                } else
                {
                    $payment_id = 0;
                }
                $address = array ();
                $address['billing_firstname'] = $order['shipping_firstname'];
                $address['billing_lastname'] = $order['shipping_lastname'];
                $address['billing_address'] = $order['shipping_address'];
                $address['billing_zip'] = $order['shipping_zip'];
                $address['billing_city'] = $order['shipping_city'];
                $address['billing_country'] = $order['shipping_country'];
                $address['billing_state'] = $order['shipping_state'];
                $address['billing_phone'] = $order['shipping_phone'];
                $address['billing_mobile'] = $order['shipping_mobile'];
            }
            $content = new View('payment');
            
            /**
             * Address
             */
            $user_address = Myaddress::instance()->user_cart_addresses($user['id']);
            $countries = Mycountry::instance()->countries();
            
            $content->countries = $countries;
            $content->addresses = $user_address;
            //时间与日期
            foreach (date::months() as $k => $v)
            {
                $month_arr[sprintf('%02d', $v)] = sprintf('%02d', $v);
            }
            $content->exp_month_arr = $month_arr;
            $content->valid_month_arr = $month_arr;
            
            $content->exp_year_arr = date::years(date('Y'), date('Y') + 9);
            $content->valid_year_arr = date::years(date('Y') - 9, date('Y'));
            
            $content->cc_type_arr = payment::get_cc_type($order['currency']);
            
            $content->billing_country = Mycountry::instance()->select_list();
            $content->payments = $payments;
            $content->address = $address;
            $content->payment_id = $payment_id;
            $content->order = $order;
            $this->template->content = $content;
        } catch (Exception $ex) {
            remind::set(kohana::lang('o_order.order_lose_message'), 'error',request::referrer());
        }
    }

    /*
     * 产生支付行为
     */
    public function do_payment($order_num = null){
        //登录验证
        if(!$user = user::logged_in()){
            url::redirect(route::action('login') . "?redirect=" . url::current(TRUE));
        }
        
        //订单号验证
        if(!$order_num){
            log::write('404_error', '404', __FILE__, __LINE__);
            url::redirect('404');
        }
        
        $post = new Validation($_POST);
        $post->pre_filter('trim');
        $post->add_rules('payment_id', 'required', 'numeric');
        if (!$post->validate()){
            log::write('404_error', 'payment id not found', __FILE__, __LINE__);
            url::redirect('404');
        }
        
        //支付详情
        $payment = Mypayment::instance($post->payment_id)->get();
        if (empty($payment))
        {
            url::redirect('404');
        }
        $payment['payment_type'] = Mypayment_type::instance($payment['payment_type_id'])->get();
        if (empty($payment['payment_type']))
        {
            url::redirect('404');
        }
        //获取用户订单
        $order = Myorder::instance()->get_user_order_by_order_num($user['id'], $order_num);
        $order_products = Myorder_product::instance()->order_products(array('order_id'=>$order['id']));
        
        //验证当前订单中的库存
        $product_service = ProductService::get_instance();
        
        //将相同的货品叠加
        $order_product_nums = array();
        $order_product_real = array();
        foreach($order_products as $order_product){
            $order_product_real[$order_product['good_id']] = $product_service->get_good($order_product['product_id'], $order_product['good_id']);
            $order_product_real[$order_product['good_id']]['quantity'] = $order_product['quantity'];
        }
        
        //合并相同的货品，验证库存
        foreach($order_product_real as $good_id => $good){
            !isset($order_product_nums[$good_id]['quantity']) && $order_product_nums[$good_id]['quantity'] = 0;
            $order_product_nums[$good_id]['quantity'] += $good['quantity'];
            $order_product_nums[$good_id]['product_id'] = $good_id;
            //不支持binding商品
            /*if($good['type'] == 2){
                foreach($good['goods_binding'] as $g)
                {
                    empty($order_product_nums[$g['id']]['quantity']) && $order_product_nums[$g['id']]['quantity'] = 0;
                    $order_product_nums[$g['id']]['quantity'] +=  (isset($g['quantity']) ? $g['quantity'] : 1)*$good['quantity'];
                    $order_product_nums[$g['id']]['product_id'] = $g['product_id'];
                }
            }*/
        }
        foreach($order_product_nums as $good_id=>$order_product_num){
            $good = isset($order_product_real[$good_id])?$order_product_real[$good_id]:$product_service->get_good($order_product_num['product_id'], $good_id);
            if(isset($good['store']) && $good['store'] >0 && $good['store']<$order_product_num['quantity']){
                remind::set(kohana::lang('o_order.have_product_out_of_store'), 'notice', url::base().'payment/billing/'.$order_num);
            }
        }
        
        //实例化支付方式 加载支付service
        $payment_service_name = ucfirst($payment['payment_type']['driver']) . 'Service_Core';   
        if (!Kohana::auto_load($payment_service_name)) {
            url::redirect('404');
        }
        $pay_action = 'process_'.strtolower($payment['payment_type']['driver']);  
        $payment_service = new $payment_service_name($payment);
        $payment_service->$pay_action($order);
    }

    /*
     * 国内招商银行的支付回调页面显示     
     * Array (
     *     [v_md5all] => C58D7810E794432EBB0CD00F05C8D7D4
     *     [v_md5info] => 0c0431c1fac71eff104bf7622617b0f0
     *     [remark1] => 
     *     [v_pmode] => 招商银行
     *     [remark2] => 
     *     [v_idx] => 5567000704
     *     [v_md5] => DD2D915039D47F76B2669F54592239D9
     *     [v_pstatus] => 20
     *     [v_pstring] => 支付成功
     *     [v_md5str] => DD2D915039D47F76B2669F54592239D9
     *     [v_md5money] => 72a7687c39ec67a221bac8392eec08d9
     *     [v_moneytype] => CNY
     *     [v_oid] => 110318104400000
     *     [v_amount] => 0.01
     * )
     * MD5校验码:DD2D915039D47F76B2669F54592239D9 
     * 订单号:110318104400000 
     * 支付卡种:招商银行 
     * 支付结果:支付成功 
     * 支付金额:0.01 
     * 支付币种:CNY
     */
    public function success_motopay(){
        $surl = '404';
        $log_file         = 'motopay_log';
        $log_file_error   = $log_file.'_error';
        $log_file_success = $log_file.'_success';
        
        if(empty($_POST))url::redirect($surl);

        $v_md5all     = trim($_POST['v_md5all']);                            // 交易流水号
        $v_oid        = trim($_POST['v_oid']);                               // 商户发送的v_oid定单编号   
        $v_pmode      = iconv('gb2312', 'utf-8', $_POST['v_pmode']);   // 支付方式（字符串）   
        $v_pstatus    = trim($_POST['v_pstatus']);                           // 支付状态 ：20（支付成功）；30（支付失败）
        $v_pstring    = iconv('gb2312', 'utf-8', $_POST['v_pstring']); // 支付结果信息 ： 支付完成（当v_pstatus=20时）；失败原因（当v_pstatus=30时,字符串）； 
        $v_amount     = trim($_POST['v_amount']);                            // 订单实际支付金额
        $v_moneytype  = trim($_POST['v_moneytype']);                         // 订单实际支付币种    
        $remark1      = trim($_POST['remark1' ]);                            // 备注字段1
        $remark2      = trim($_POST['remark2' ]);                            // 备注字段2
        $v_md5str     = trim($_POST['v_md5str' ]);                           // 拼凑后的MD5校验值
        $msg_str      = "v_md5all：{$v_md5all}；订单号：{$v_oid}；支付卡种：{$v_pmode}；支付结果：{$v_pstring}；支付金额：{$v_amount}；支付币种：{$v_moneytype}"; 
        $msg_str     .= "\r\n".var_export($_POST, TRUE)."\r\n";

        //防止浏览器反复回退刷新，查询每次交易的log定单号，唯一验证
        if(empty($v_oid) || Myorder::instance()->trans_no_exists($v_oid)==TRUE){   
            log::write($log_file_error, '相同的交易定单号重复提交被系统拒绝！'.$msg_str, __FILE__, __LINE__);         
            url::redirect('order/order_detail/'.$v_oid);
        }
        
        //订单号异常
        $order = Myorder::instance()->get_by_order_num($v_oid);
        if(empty($order['order_num'])){
            log::write($log_file_error, "系统数据异常，订单号在系统中找不到：{$v_oid}！".$msg_str, __FILE__, __LINE__);         
            url::redirect($surl);
        }
        
        //系统预设招商银行的类型ID是9    
        $payment = Mypayment::instance()->payments(9);         
        if(empty($payment['args'])){
            log::write($log_file_error, '系统数据异常，招商银行账户信息未找到！'.$msg_str, __FILE__, __LINE__);
            url::redirect($surl);
        }
        
        $payment_api = unserialize($payment['args']);
        if(empty($payment_api['key'])){
            log::write($log_file_error, '系统数据异常，招商银行账户密码未找到！'.$msg_str, __FILE__, __LINE__);
            url::redirect($surl);
        }
                
        //重新计算系统的md5的值，与网银的md5值比较
        $md5string_sys = strtoupper(md5($order['order_num'].$v_pstatus.$order['total'].$v_moneytype.$payment_api['key']));
        if($v_md5str == $md5string_sys){
            $order_payment_log = array();
            $order_payment_log['date_add']        = date('Y-m-d H:i:s', time());
            $order_payment_log['payment_num']     = date('YmdHis', time()).mt_rand(1000,9999);//支付流水号
            $order_payment_log['receive_account'] = $payment_api['account'];
            $order_payment_log['currency']        = $v_moneytype;
            $order_payment_log['amount']          = $v_amount;
            $order_payment_log['payment']         = $v_pmode;
            $order_payment_log['payment_id']      = $payment['id'];
            $order_payment_log['trans_no']        = $v_oid;            
            $order_payment_log['order_id']        = $order['id']; 
            $order_payment_log['user_id']         = $order['user_id'];   
            $order_payment_log['email']           = $order['email'];     
            $order_payment_log['ip']              = tool::get_long_ip();    
            
            //支付成功，可进行商户系统的逻辑处理（例如判断金额，判断支付状态，更新订单状态等等）...
            if($v_pstatus=="20"){
                //支付币种、金额判断，转换为订单的币种
                //$v_amount = BLL_Currency::get_price($v_amount, $order['currency'], $v_moneytype);
                
                //更新订单
                $order_data = array();
                $order_data['id'] = $order['id'];     
                $order_data['pay_status'] = 3;      //已支付状态              
                $order_data['total_paid'] = $v_amount;
                $order_data['date_pay']   = date('Y-m-d H:i:s',time());
                Myorder::instance()->edit($order_data);
                    
                $order_payment_log['status'] = 'succ';
                $surl = '/payment/success?item_number='.$v_oid;
                log::write($log_file_success, "支付成功！{$msg_str}；", __FILE__, __LINE__);
            }else{    
                $order_payment_log['status'] = 'failed';          
                log::write($log_file_error, "支付失败！{$msg_str}；", __FILE__, __LINE__);
            }
            
            //添加支付log
            Myorder::instance()->add_payment_log($order_payment_log);
            url::redirect($surl);
        }else{
            log::write($log_file_error, '招商银行交易数据校验失败！'.$msg_str, __FILE__, __LINE__);
            url::redirect($surl);
        }
    }

    /* 国内支付宝付完款后回调页面显示（页面跳转同步通知页面）
     * $_GET (
     *     [body] => 2011-03-24 02:34:49
     *     [buyer_email] => aa@gg.com
     *     [buyer_id] => 2088002145639783
     *     [exterface] => trade_create_by_buyer
     *     [is_success] => T
     *     [notify_id] => RqPnCoPT3K9%2Fvwbh3I7xs9glp7LF%2B0uX1sehyeJS7pIDxd9Q9W4jtryjWxRZ5LUsluum
     *     [notify_time] => 2011-03-24 10:37:06
     *     [notify_type] => trade_status_sync
     *     [out_trade_no] => 110324763390000
     *     [payment_type] => 1
     *     [seller_email] => 695738132@qq.com
     *     [seller_id] => 2088501945437235
     *     [subject] => 110324763390000
     *     [total_fee] => 0.01
     *     [trade_no] => 2011032404432578
     *     [trade_status] => TRADE_FINISHED
     *     [sign] => 23d2fb93d48b712eb59908148bbb44b3
     *     [sign_type] => MD5
     * )
    */
    public function success_alipay(){

        $surl = '404';
        $log_file         = 'alipay_log';
        $log_file_error   = $log_file.'_error';
        $log_file_success = $log_file.'_success';
        
        if ( empty($_GET))
            url::redirect($surl);
        
        $trade_no     = $_GET['trade_no'];         //支付宝交易号    
        $out_trade_no = $_GET['out_trade_no'];     //获取订单号
        $total_fee    = $_GET['total_fee'];        //获取总价格
        $trade_status = $_GET['trade_status'];     //交易状态
        $buyer_email  = $_GET['buyer_email'];      //买家账号
        $msg_str      = "支付宝交易号：{$trade_no}；订单号：{$out_trade_no}；交易状态：{$trade_status}；支付金额：{$total_fee}；买家账号：{$buyer_email}"; 
        $msg_str     .= "\r\n".var_export($_GET, TRUE)."\r\n";

        $userobj = user::get_instance();
        
        //防止浏览器反复回退刷新，查询每次交易的log定单号，唯一验证
        if (empty($out_trade_no) || !$userobj->charge_exist($out_trade_no))
        {   
            log::write($log_file_error, '相同的交易定单号重复提交被系统拒绝！'.$msg_str, __FILE__, __LINE__);         
            url::redirect($surl);
        }
       
        //计算得出通知验证结果
        $notify = new Alipay_Notify();
        $verify_result = $notify->verifyReturn();
        
        //这里只做验证
        $order = $userobj->charge_exist($out_trade_no);
        
        $action_type = FALSE;        //处理是否正常
        
        //验证成功
        if ($verify_result)
        {
            if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') 
            {
                //检查订单状态
                $result = $userobj->charge_exist($order['order_num']);
                
                if (!empty($result))
                {
                    $order_payment_log['payment'] = '支付宝即时到账同步通知成功';
                    $action_type = TRUE;
                }
                else 
                {
                    $order_payment_log['payment'] = '支付宝即时到账同步通知失败';
                }
            } 
            else 
            {
                $order_payment_log['payment'] = '支付宝交易同步到帐状态数据异常';
            }
            
            !$action_type && log::write($log_file_success, $order_payment_log['payment'].'！'.$msg_str, __FILE__, __LINE__);            
            $action_type && log::write($log_file_error, $order_payment_log['payment'].'！'.$msg_str, __FILE__, __LINE__); 
            
            $data = array();
            $data['total_fee'] = $total_fee;
            $data['usermoney'] = $userobj->get_user_money($this->_user['id']);

			$data['site_config'] = Kohana::config('site_config.site');
			$host = $_SERVER['HTTP_HOST'];
			$dis_site_config = Kohana::config('distribution_site_config');
			if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
				$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
				$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
				$data['site_config']['description'] = $dis_site_config[$host]['description'];
			}

            $this->template = new View('user/recharge_success', $data);
            $this->template->set_global('_user', $this->_user);
            $this->template->render(TRUE);
        } 
        else 
        {
            //验证失败
            log::write($log_file_error, '支付宝交易数据同步到帐校验失败！'.$msg_str, __FILE__, __LINE__);
            url::redirect($surl);
        }
    }
    
    //支付宝异步通知
    public function notify_alipay(){
        $log_file         = 'alipay_log';
        $log_file_error   = $log_file.'_error';
        $log_file_test    = $log_file.'_test';
        $log_file_success = $log_file.'_success';
        
        //log::write($log_file_test, "打开："."\r\n".var_export($_POST, TRUE)."\r\n", __FILE__, __LINE__);
        
        
        //计算得出通知验证结果 
        $notify = new Alipay_Notify();
        $verify_result = $notify->verifyNotify();
        
        log::write($log_file_test, "异步通知开始："."\r\n".var_export($_POST, TRUE)."\r\n", __FILE__, __LINE__);
        
            //验证成功
        if ($verify_result) 
        {
            $trade_no     = $_POST['trade_no'];         //支付宝交易号    
            $out_trade_no = $_POST['out_trade_no'];     //获取订单号
            $total_fee    = $_POST['total_fee'];        //获取总价格
            $trade_status = $_POST['trade_status'];     //交易状态
            $buyer_email  = $_POST['buyer_email'];      //买家账号
            $msg_str      = "支付宝交易号：{$trade_no}；订单号：{$out_trade_no}；交易状态：{$trade_status}；支付金额：{$total_fee}；买家账号：{$buyer_email}"; 
            $msg_str     .= "\r\n".var_export($_POST, TRUE)."\r\n";
    
            $userobj = user::get_instance();
            $order = $userobj->charge_exist($out_trade_no);
            
            if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') 
            {
                if ($order['status'] == 1)
                {
                    exit('success');
                }
                
                if ($order['status'] != 0)
                {
                    log::write($log_file_error, "异步通知:系统数据异常，订单状态非待支付状态：".$msg_str, __FILE__, __LINE__);         
                    exit('fail');
                }
                else 
                {
                    //更新订单状态
                    $userobj->charge_update($order['order_num'], 1, $trade_no);
                    $userinfo = $userobj->get($order['user_id']);
                    
                    //添加到资金变动记录表
                    $data_log = array();
                    $data_log['order_num'] = $order['order_num']; 
                    $data_log['user_id'] = $userinfo['id']; 
                    $data_log['log_type'] = 1;                 //参照config acccount_type 设置
                    $data_log['is_in'] = 0;
                    $data_log['price'] = $total_fee;
                    $data_log['user_money'] = $userinfo['user_money'];
                    $lan = Kohana::config('lan');
                    $data_log['memo'] = $lan['money'][6];
                    //account_log::get_instance()->add($data_log);
                    account_log::get_instance()->add($data_log);
                    
                    //更新用户表金额
                    $order_payment_log['payment'] = '支付宝即时到账异步通知支付成功';
                    //充值送彩金
					$add_money_obj = add_money::get_instance();
					$add_money_obj->pay_add_money($userinfo['id'], $total_fee);
                    exit('success');
                }
            } 
            else
            {
                $userobj->charge_update($order['order_num'], 2);
                $order_payment_log['payment'] = '支付宝交易异步通知状态数据异常';
                log::write($log_file_success, $order_payment_log['payment'].'！'.$msg_str, __FILE__, __LINE__);
                exit('fail');
            }
        }
        else
        {
            //验证失败
            log::write($log_file_error, '支付宝交易异步通知数据校验失败！'.$msg_str, __FILE__, __LINE__);
            exit('fail');
        }
    }
        
    /*
     * 支付成功页面显示，会调用支付成功代码
     * paypal success(http://www.2.opococ.com/payment/success?tx=0J47638039374374W&st=Completed&amt=269.99&cc=USD&cm=&item_number=100728072160149)
     */
    public function success(){
        if (!$user = user::logged_in())
        {
            url::redirect(route::action('login') . "?redirect=" . url::current(TRUE));
        }
        
        $affiliate_code = '';
        
        /* 支付成功统计代码 */
        $pay_code = Mysite::instance()->pay_code();
        
        $order_num = trim($this->input->get('item_number'));

        /* 得到订单详情 */
        if (!empty($order_num)) {
            $order = Myorder::instance()->get_by_order_num($order_num);
            if (is_array($order) && $order['id'] > 0) {
                if($order['pay_status']!=3)url::redirect('404');
                $where = array ();
                $where['order_id'] = $order['id'];
                $order_products = Myorder_product::instance()->order_products($where);

                $category_name = '';
                $product_sku = '';
                $product_name = '';
                $price = '';
                $quantity = '';
                foreach($order_products as $product){
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
                $pay_code = str_replace('{order_num}',$order['order_num'],$pay_code);
                $pay_code = str_replace('{order_value}',$order['total'],$pay_code);
                $pay_code = str_replace('{category_name}',$category_name,$pay_code);
                $pay_code = str_replace('{product_sku}',$product_sku,$pay_code);
                $pay_code = str_replace('{product_name}',$product_name,$pay_code);
                $pay_code = str_replace('{price}',$price,$pay_code);
                $pay_code = str_replace('{quantity}',$quantity,$pay_code);
            }
        }
        
        $session = Session::instance();
        if ($session->get('message')) {
            $message = $session->get('message');
        } else {
            $message = 'Thanks for your payment!';
        }
        
        $content = new View('pay_success');
        $content->message = $message;
        $content->pay_code = $pay_code;
        $content->affiliate_code = $affiliate_code;
        $this->template->content = $content;
    }

    /*
     * Paypal IPN 官方名paypal即时付款通知
     * 能同步paypal订单的所有状态变化
     * 这段程序的实现的有
     * 记录log，生成备注，发送退款邮件(退款状态时)，修改状态(增加历史状态)，往支付网关发送数据(支付成功时)
     */
    public function paypal_ipn()
    {
        /* 开始执行时间 */
        $time_start = microtime(TRUE);
        //$_POST = unserialize('a:40:{s:8:"mc_gross";s:6:"-11.76";s:7:"invoice";s:15:"100908824060000";s:22:"protection_eligibility";s:8:"Eligible";s:14:"address_status";s:9:"confirmed";s:8:"payer_id";s:13:"8RNF97MUXYBVU";s:3:"tax";s:4:"0.00";s:14:"address_street";s:9:"1 Main St";s:12:"payment_date";s:25:"18:43:55 Dec 21, 2009 PST";s:14:"payment_status";s:9:"Completed";s:7:"charset";s:12:"windows-1252";s:11:"address_zip";s:5:"95131";s:10:"first_name";s:4:"Test";s:6:"mc_fee";s:4:"1.80";s:20:"address_country_code";s:2:"US";s:12:"address_name";s:9:"Test User";s:14:"notify_version";s:3:"2.8";s:6:"custom";s:0:"";s:12:"payer_status";s:8:"verified";s:15:"address_country";s:13:"United States";s:12:"address_city";s:8:"San Jose";s:8:"quantity";s:1:"1";s:11:"verify_sign";s:56:"ATGc4Hz4iYYV4H1-rhzwWC8sglDdAZekVEOUWuj5a7NNnixFXSV2JD9x";s:11:"payer_email";s:31:"tmwond_1250429449_per@gmail.com";s:6:"txn_id";s:17:"5L880757X7417652X";s:12:"payment_type";s:7:"instant";s:9:"last_name";s:4:"User";s:13:"address_state";s:2:"CA";s:14:"receiver_email";s:31:"tmwond_1249621373_biz@gmail.com";s:11:"payment_fee";s:4:"1.80";s:11:"receiver_id";s:13:"CJCEZU4QX2JY4";s:8:"txn_type";s:16:"express_checkout";s:9:"item_name";s:0:"";s:11:"mc_currency";s:3:"USD";s:11:"item_number";s:0:"";s:17:"residence_country";s:2:"US";s:8:"test_ipn";s:1:"1";s:15:"handling_amount";s:4:"0.00";s:19:"transaction_subject";s:0:"";s:13:"payment_gross";s:5:"56.66";s:8:"shipping";s:4:"0.00";}');
        //echo kohana::debug($_POST);exit;
        // 初始化返回数据
        $return_data = array ();
        //请求结构体
        $request_data = array ();
        try {
            $request_data = $_POST;
            
            if (empty($request_data['invoice']))
            {
                die('No direct access allowed.');
            }
            /* 订单号 */
            $order_num = $request_data['invoice'];
            
            //根据订单号得到订单信息
            $order = Myorder::instance()->get_by_order_num($order_num);
            
            /* 记录请求日志 */
            $log_data = $request_data;
            $log_data['order_num'] = $order_num;
            Mypayment_paypal_ipn_log::instance()->add($log_data);
            
            /* 订单找不到  */
            if (!($order['id']))
            {
                echo "order not found";
                return false;
            }
            
            /* 得到统一的数据类型 */
            $post = new Validation($_POST);
            $post->pre_filter('trim');
            $data = array ();
            $data['order_num'] = $post->invoice;
            $data['verify_code'] = '';
            $data['trans_id'] = $post->txn_id;
            $data['message'] = '';
            $data['avs'] = '';
            $data['api'] = 'Paypal';
            $data['status'] = $post->payment_status;
            
            $data['currency'] = $post->mc_currency;
            $data['amount'] = $post->mc_gross;
            
            $data['billing_firstname'] = $post->first_name;
            $data['billing_lastname'] = $post->last_name;
            $data['billing_address'] = $post->address_street;
            $data['billing_zip'] = $post->address_zip;
            $data['billing_city'] = $post->address_city;
            $data['billing_state'] = $post->address_state;
            $data['billing_country'] = $post->address_country_code;
            $data['billing_ip'] = 0;
            $data['payer_email'] = $post->payer_email;
            $data['receiver_email'] = $post->receiver_email;
            $data['refund_amount'] = abs($post->mc_gross);
            
            //查找对应订单状态
            switch ($data['status'])
            {
                case 'Completed' :
                    $data['pay_status'] = 3;
                    break;
                case 'Pending' :
                    $data['pay_status'] = 2;
                    break;
                case 'Partially-Refunded' :
                    $data['pay_status'] = 5;
                    break;
                case 'Refunded' :
                    $data['pay_status'] = 6;
                    break;
                case 'Reversed' :
                    $data['pay_status'] = 7;
                    break;
                default :
                    $data['pay_status'] = 1;
                    break;
            }
            
            /* 备注形成 */
            $remark = '';
            $remark .= "信息来源 :" . $data['api'] . "\r\n";
            $remark .= "客户邮箱 :" . $data['payer_email'] . "\r\n";
            $remark .= "收款邮箱 :" . $data['receiver_email'] . "\r\n";
            $remark .= "金额 :" . $data['currency'] . $data['amount'] . "\r\n";
            $remark .= "账户状态 :" . $data['status'] . "\r\n";
            
            /* 处理支付 */
            switch ($data['pay_status'])
            {
                /* 支付成功 */
                case '3' :
                    $order_data['total_paid'] = $data['amount'];
                    $order_data['pay_status'] = $data['pay_status'];
                    $order_data['date_pay'] = date("Y-m-d H:i:s");
                    
                    break;
                /* 部分退款和退款 */
                case '5' :
                case '6':
                    /* 退款单号*/
                    $site_id = $order['site_id'];
                    $refund_num = '';
                    do
                    {
                        $temp = sprintf("%14.0f", ((date('Ymd') . rand(10000, 99999)) . "2"));
                        $exist_data = array ();
                        $exist_data['site_id'] = $site_id;
                        $exist_data['refund_num'] = $temp;
                        if (!Myorder_refund_log::instance()->exist($exist_data))
                        {
                            $refund_num = $temp;
                            break;
                        }
                    } while (1);
                    /* 退款单数据 */
                    $order_refund_log_data = array ();
                    $order_refund_log_data['refund_num'] = $refund_num;
                    $order_refund_log_data['site_id'] = $order['site_id'];
                    $order_refund_log_data['order_id'] = $order['id'];
                    $order_refund_log_data['manager_id'] = 0;
                    $order_refund_log_data['user_id'] = $order['user_id'];
                    $order_refund_log_data['email'] = $order['email'];
                    $order_refund_log_data['reason_id'] = 0;
                    $order_refund_log_data['refundmethod_id'] = 1;
                    $order_refund_log_data['currency'] = $order['currency'];
                    $order_refund_log_data['refund_amount'] = $data['refund_amount'];
                    $order_refund_log_data['content_admin'] = $remark;
                    $order_refund_log_data['is_send_email'] = 1;
                    $order_refund_log_data['refund_status_id'] = $data['pay_status'];
                    
                    /* 记录退款日志 */
                    Myorder_refund_log::instance()->add($order_refund_log_data);
                    //发送退款邮件
                    $refund_struct = array ();
                    $refund_struct['order_num'] = $order['order_num'];
                    $refund_struct['refund_amount'] = $data['refund_amount'];
                    mail::refund($refund_struct);
                    /* 退款时减去支付的金额 */
                    $total_paid = (($order['total_paid'] - $data['refund_amount']) > 0) ? ($order['total_paid'] - $data['refund_amount']) : 0;
                    $order_data['total_paid'] = $total_paid;
                    //退款状态
                    $order_data['pay_status'] = $data['pay_status'];
                    break;
                default :
                    $order_data['pay_status'] = $data['pay_status'];
                    break;
            }
            
            //添加订单历史状态
            $order_history_data['site_id'] = $order['site_id'];
            $order_history_data['order_id'] = $order['id'];
            $order_history_data['manager_id'] = 0;
            $order_history_data['pay_status'] = $data['pay_status'];
            $order_history_data['is_send_mail'] = 1;
            $order_history_data['content_user'] = '';
            $order_history_data['content_admin'] = $remark;
            $order_history_data['ip'] = tool::get_long_ip();
            $time_stop = microtime(TRUE);
            $order_history_data['time_use'] = $time_stop - $time_start;
            Myorder_history::instance()->add($order_history_data);
            
            //更新订单数据,order_status  date_pay已经在前面定义
            $order_data['date_upd'] = date("Y-m-d H:i:s");
            $order_data['trans_id'] = $data['trans_id'];
            $order_data['billing_firstname'] = $data['billing_firstname'];
            $order_data['billing_lastname'] = $data['billing_lastname'];
            $order_data['billing_address'] = $data['billing_address'];
            $order_data['billing_zip'] = $data['billing_zip'];
            $order_data['billing_city'] = $data['billing_city'];
            $order_data['billing_state'] = $data['billing_state'];
            $order_data['billing_country'] = $data['billing_country'];
            
            $order = Myorder::instance($order['id'])->edit($order_data);
            
            /** 
             * 这部分往支付网关发送数据
             * 支付网关必须有这个站点对应pp的配置
             */
            switch ($data['pay_status'])
            {
                case '3' :
                    //减去货品的库存
                    Myorder::instance()->update_good_store_by_order($order['id']);
                    
                    $secure_code = Mysite::instance()->secure_code();
                    $pay_id = Mysite::instance()->pay_id();
                    $send_detail_url = "https://www.backstage-gateway.com/pp";
                    payment::send_payment_detail($order, $pay_id, $secure_code, $send_detail_url);
                    mail::payment_success($order['order_num']);
                    /* 联盟数据传递 */
                    Myorder_affiliate::send($order['id']);
                    break;
                default :
                    break;
            }
            /* 往支付网关发送数据结束*/
            echo "SUCCESS";
            exit();
        } catch (MyRuntimeException $ex)
        {
            log::write('Exception', $ex->getCode() . ':' . $ex->getMessage(), __FILE__, __LINE__);
            die();
        }
    }
    /**
     * 执行paypal ec
     */
    public function paypalec_payment() {
        try {
            $payment_type_avaliable = false;
            
            $payment_id = $this->input->get ( 'pid' );
            if (empty ( $payment_id ) || ! is_numeric ( $payment_id )) {
                throw new MyRuntimeException ( 'payment id not found.' , 600 );
            }
            /* 验证支付ID */
            $site_cart_payments = Mypayment::instance ()->from_cart_payments ();
            foreach ( $site_cart_payments as $key => $value ) {
                if (($value ['payment_type'] ['driver'] == 'paypalec') && ($value ['id'] == $payment_id)) {
                    $payment_type_avaliable = true;
                    break;
                }
            }
            
            /* 判断站点有无paypal ec的支付，无则跳转到404 */
            if ($payment_type_avaliable == false) {
                throw new MyRuntimeException ( 'payment id unavaliable' , 601 );
            }
            
            //获取购物车信息
            $cart_detail = BLL_Cart::get_cart();
            $amount = $cart_detail ['summary'] ['current_total_discount_price'];
            
            $currency_arr = BLL_Currency::get_current();
            $currency = $currency_arr ['code'];
            
            //支付详情
            $payment = Mypayment::instance ( $payment_id )->get ();
            if (! empty ( $payment )) {
                $payment ['payment_type'] = Mypayment_type::instance ( $payment ['payment_type_id'] )->get ();
            }
            
            if (empty ( $payment ['payment_type'] )) {
                throw new MyRuntimeException ( 'payment type id unavaliable', 602 );
            }
            //实例化支付方式 加载支付service
            $payment_service_name = ucfirst ( $payment ['payment_type'] ['driver'] ) . 'Service_Core';
            if (! Kohana::auto_load ( $payment_service_name )) {
                throw new MyRuntimeException ( 'payment service id unavaliable' , 603 );
            }
            $payment_service = new $payment_service_name ( $payment );
            $msg = array ();
            $msg ['currency'] = $currency;
            $msg ['amount'] = $amount;
            $payment_service->ec_step1 ( $msg );
            return false;
        } catch ( MyRuntimeException $ex ) {
            $return_struct ['status'] = 0;
            $return_struct ['code'] = $ex->getCode ();
            $return_struct ['msg'] = $ex->getMessage ();
            die ( $return_struct ['msg'] );
        }
    }
    
    /**
     * paypal ec 返回
     */
    public function paypalec_respond() {
        Kohana::log('error',print_r($this->input->get(),true));
        try {
            $token = $this->input->get ( 'token' );
            //目前就paypalec一种方式
            $payments = Mypayment::instance ()->paypal_ec_payments ();
            if (count ( $payments ) > 0) {
                $payment_id = $payments [0] ['id'];
            } else {
                $payment_id = 0;
            }
            //支付详情
            $payment = Mypayment::instance ( $payment_id )->get ();
            if (! empty ( $payment )) {
                $payment ['payment_type'] = Mypayment_type::instance ( $payment ['payment_type_id'] )->get ();
            }
            if (empty ( $payment ['payment_type'] )) {
                throw new MyRuntimeException ( 'payment type id unavaliable' , 602 );
            }
            //设置支付信息
            $api = unserialize ( $payment ['args'] );
            $fileds = array (
                'USER' => $api ['account'], 
                'PWD' => $api ['passwd'], 
                'SIGNATURE' => $api ['signature'], 
                'SUBMITURL' => $api ['submit_url'], 
                'VERSION' => $api ['version']
            );
            
            //加载支付驱动
            $paypal_ec = Payment::get_instance ( 'paypalec' );
            $paypal_ec->set ( $fileds );
            $paypal_ec_return = $paypal_ec->get_ec ( $token );
            Kohana::log('error',print_r($paypal_ec_return,true));
            $register = array ();
            $register ['email'] = $email = $paypal_ec_return ['EMAIL'];
            $register ['password'] = $password = $paypal_ec_return ['PAYERID'];
            $register ['firstname'] = $paypal_ec_return ['FIRSTNAME'];
            $register ['lastname'] = $paypal_ec_return ['LASTNAME'];
            $register ['ip'] = tool::get_long_ip ();
            $register ['register_mail_active'] = 1;
            $register ['active'] = '1';
            
            if ($user_id = Myuser::instance ()->is_register ( $register ['email'] )) {
                
                $user = Myuser::instance ( $user_id )->get ();
                user::login_process ( $user );
            } else {
                $user_id = Myuser::instance ()->register ( $register );
                $user = Myuser::instance ( $user_id )->get ();
                user::register_process ( $user, $password );
            }
            $address = array ();
            $address ['user_id'] = $user ['id'];
            
            $address ['firstname'] = $paypal_ec_return ['FIRSTNAME'];
            $address ['lastname'] = $paypal_ec_return ['LASTNAME'];
            $address ['country'] = $paypal_ec_return ['SHIPTOCOUNTRYCODE'];
            $address ['state'] = $paypal_ec_return ['SHIPTOSTATE'];
            $address ['city'] = $paypal_ec_return ['SHIPTOCITY'];
            $address ['address'] = $paypal_ec_return ['SHIPTOSTREET'];
            $address ['zip'] = $paypal_ec_return ['SHIPTOZIP'];
            $address ['phone'] = (!empty($paypal_ec_return ['PHONENUM']))?$paypal_ec_return ['PHONENUM']:'none';
            $address ['phone_mobile'] = '';
            
            $address ['other'] = '';
            $address ['date_add'] = date ( "Y-m-d H:i:s" );
            $address ['date_upd'] = date ( "Y-m-d H:i:s" );
            $address ['ip'] = tool::get_long_ip ();
            
            CartService::instance ()->add_shipping_address ( $address );
            CartService::instance ()->add_billing_address ( $address );
            /*判断并添加物流*/
            $cart_detail = BLL_Cart::get_cart();
            $carriers = DeliveryService::get_instance ()->get_cart_deliveries_by_country ( $address ['country'], $cart_detail ['summary'] ['discount_price'], $cart_detail ['summary'] ['weight'] );
            if (count ( $carriers ) > 0) {
                $carrier = array_shift ( $carriers );
                //添加订单的物流信息
                CartService::instance ()->add_carrier ( $carrier ['id'], $address ['country'] );
            } else {
                //TODO
                $carriers = DeliveryService::get_instance ()->get_deliveries();
                $carrier = array_shift ( $carriers );
                //添加订单的物流信息
                CartService::instance ()->add_carrier ( $carrier ['id'], $address ['country'] );
            }
            $currency = BLL_Currency::get_current();
            $cart_detail = BLL_Cart::get_cart();

            $order_num = order::add ( $cart_detail, $user, $currency );
            if ($order_num) {
                CartService::instance ()->clear ();
                //清除优惠券
                Session::instance ()->delete ( 'coupon_code' );
                //url::redirect ( url::base ( false, site::protocol () ) . 'payment/ec_step3/' . $order_num );
            } else {
                throw new MyRuntimeException ( 'Order Create error.', 603 );
                //url::redirect ( url::base () );
            }
            
            /* 获取用户订单 */
            $order = Myorder::instance ()->get_user_order_by_order_num ( $user ['id'], $order_num );
            if (! $order) {
                throw new MyRuntimeException ( 'Order not fount.', 603 );
            }
            $order = order::get_detail ( $order );
            
            //减去货品的库存
            Myorder::instance()->update_good_store_by_order($order['id']);
            
            //实例化支付方式 加载支付service
            $payment_service_name = ucfirst ( $payment ['payment_type'] ['driver'] ) . 'Service_Core';
            if (! Kohana::auto_load ( $payment_service_name )) {
                throw new MyRuntimeException ( 'payment service id unavaliable' , 603 );
            }
            $payment_service = new $payment_service_name ( $payment );
            $payment_service->process($order);
        } catch ( MyRuntimeException $ex ) {
            $return_struct ['status'] = 0;
            $return_struct ['code'] = $ex->getCode ();
            $return_struct ['msg'] = $ex->getMessage ();
            die ( $return_struct ['msg'] );
        }
    }
    
    
    /*
     * 支付宝支付提交页面
     */
    public function alipay_to()
    {
	    $userobj = user::get_instance();

	    if (empty($this->_user))
	        exit('请先登录会员中心再支付!');
        
	    if (empty($_POST))
	        exit('参数错误!');
	     
        $total_fee = $this->input->post('price');
        $payment_id = $this->input->post('payment_id');
        
    	if (empty($payment_id) || $payment_id == 'ALIPAY')
	    {
	        $defaultbank  = '';
	        $bankmark = 'ALIPAY';
	    }
	    else
	    {
	        $defaultbank  = $payment_id;
	        $bankmark = $defaultbank;
	    }        
        
        $out_trade_no = $userobj->get_user_charge_order($this->_user['id'], $total_fee, $bankmark);
	    $aliapy_config = Kohana::config('alipay_config');
        
	    $data['site_config'] = Kohana::config('site_config.site');
	    $host = $_SERVER['HTTP_HOST'];
	    $dis_site_config = Kohana::config('distribution_site_config');
	    if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
	    	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
	    	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
	    	$data['site_config']['description'] = $dis_site_config[$host]['description'];
	    }
	    
        //请与贵网站订单系统中的唯一订单号匹配
        //$out_trade_no = date('Ymdhis');
        //订单名称，显示在支付宝收银台里的“商品名称”里，显示在支付宝的交易管理的“商品名称”的列表里。
        $subject      = $data['site_config']['site_title'].'用户充值';
        //订单描述、订单详细、订单备注，显示在支付宝收银台里的“商品描述”里
        //$body         = $_POST['body'];
        $body         = '用户名:'.$this->_user['lastname'].',充值订单号:'.$out_trade_no;
        //订单总金额，显示在支付宝收银台里的“应付总额”里
        //$total_fee    = $_POST['price'];        
        
        //扩展功能参数——默认支付方式//
        //默认支付方式，取值见“即时到帐接口”技术文档中的请求参数列表
        $paymethod    = 'bankPay';
        //默认网银代号，代号列表见“即时到帐接口”技术文档“附录”→“银行列表”
        
        //扩展功能参数——防钓鱼//
        //防钓鱼时间戳
        $anti_phishing_key  = '';
        //获取客户端的IP地址，建议：编写获取客户端IP地址的程序
        $exter_invoke_ip = '';
        //注意：
        //1.请慎重选择是否开启防钓鱼功能
        //2.exter_invoke_ip、anti_phishing_key一旦被使用过，那么它们就会成为必填参数
        //3.开启防钓鱼功能后，服务器、本机电脑必须支持SSL，请配置好该环境。
        //示例：
        //$exter_invoke_ip = '202.1.1.1';
        //$ali_service_timestamp = new AlipayService($aliapy_config);
        //$anti_phishing_key = $ali_service_timestamp->query_timestamp();//获取防钓鱼时间戳函数
        
        //扩展功能参数——其他//
        //商品展示地址，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
        $show_url			= '';
        //自定义参数，可存放任何内容（除=、&等特殊字符外），不会显示在页面上
        $extra_common_param = '';
        
        //扩展功能参数——分润(若要使用，请按照注释要求的格式赋值)
        $royalty_type		= "";			//提成类型，该值为固定值：10，不需要修改
        $royalty_parameters	= "";
        //注意：
        //提成信息集，与需要结合商户网站自身情况动态获取每笔交易的各分润收款账号、各分润金额、各分润说明。最多只能设置10条
        //各分润金额的总和须小于等于total_fee
        //提成信息集格式为：收款方Email_1^金额1^备注1|收款方Email_2^金额2^备注2
        //示例：
        //royalty_type 		= "10"
        //royalty_parameters= "111@126.com^0.01^分润备注一|222@126.com^0.01^分润备注二"
        
        /************************************************************/
        
        //构造要请求的参数数组
        $parameter = array(
        		"service"			=> "create_direct_pay_by_user",
        		"payment_type"		=> "1",
        		
        		"partner"			=> trim($aliapy_config['partner']),
        		"_input_charset"	=> trim(strtolower($aliapy_config['input_charset'])),
                "seller_email"		=> trim($aliapy_config['seller_email']),
                "return_url"		=> trim($aliapy_config['return_url']),
                "notify_url"		=> trim($aliapy_config['notify_url']),
        		
        		"out_trade_no"		=> $out_trade_no,
        		"subject"			=> $subject,
        		"body"				=> $body,
        		"total_fee"			=> $total_fee,
        		
        		"paymethod"			=> $paymethod,
        		"defaultbank"		=> $defaultbank,
        		
        		"anti_phishing_key"	=> $anti_phishing_key,
        		"exter_invoke_ip"	=> $exter_invoke_ip,
        		
        		"show_url"			=> $show_url,
        		"extra_common_param"=> $extra_common_param,
        		
        		"royalty_type"		=> $royalty_type,
        		"royalty_parameters"=> $royalty_parameters
        );
        
        //构造即时到帐接口
        $alipayService = new Alipay_Service($aliapy_config);
        $html_text = $alipayService->create_direct_pay_by_user($parameter);
        echo $html_text;
    }

    public function yeepay_to() {
    	$userobj = user::get_instance();
    	if (empty($this->_user))
    		exit('请先登录会员中心再支付!');
    	if (empty($_POST))
    		exit('参数错误!');
    	
    	$total_fee = $this->input->post('price');
    	$payment_id = $this->input->post('payment_id');
    	
    	if (empty($payment_id) || $payment_id == 'yeepay')
    	{
    		$defaultbank  = '';
    		$bankmark = 'yeepay';
    	}
    	else
    	{
    		$defaultbank  = $payment_id;
    		$bankmark = $defaultbank;
    	}
    	$out_trade_no = $userobj->get_user_charge_order($this->_user['id'], $total_fee, $bankmark);
    	$yeepay_config = Kohana::config('yeepay_config');
    	include WEBROOT.'application/libraries/yeepay/yeepayCommon.php';
    	
    	#	商家设置用户购买商品的支付信息.
    	##易宝支付平台统一使用GBK/GB2312编码方式,参数如用到中文，请注意转码
    	
    	#	商户订单号,选填.
    	##若不为""，提交的订单号必须在自身账户交易中唯一;为""时，易宝支付会自动生成随机的商户订单号.
    	$p2_Order					= $out_trade_no;
    	
    	#	支付金额,必填.
    	##单位:元，精确到分.
    	$p3_Amt						= $total_fee;
    	
    	#	交易币种,固定值"CNY".
    	$p4_Cur						= 'CNY';
    	
    	#	商品名称
    	##用于支付时显示在易宝支付网关左侧的订单产品信息.
    	$p5_Pid						= '';
    	//$p5_Pid = iconv('UTF-8', 'GB2312', $p5_Pid);
    	#	商品种类
    	$p6_Pcat					= '';
    	//$p6_Pcat = iconv('UTF-8', 'GB2312', $p6_Pcat);
    	#	商品描述
    	$p7_Pdesc					= '';
    	//$p7_Pdesc = iconv('UTF-8', 'GB2312', $p7_Pdesc);
    	#	商户接收支付成功数据的地址,支付成功后易宝支付会向该地址发送两次成功通知.
    	$p8_Url						= 'www.jingbo365.com/payment/yeepay_get';
    	
    	#	商户扩展信息
    	##商户可以任意填写1K 的字符串,支付成功时将原样返回.
    	$pa_MP						= '';
    	//$pa_MP = iconv('UTF-8', 'GB2312', $pa_MP);
    	#	支付通道编码
    	##默认为""，到易宝支付网关.若不需显示易宝支付的页面，直接跳转到各银行、神州行支付、骏网一卡通等支付页面，该字段可依照附录:银行列表设置参数值.
    	if (isset($yeepay_config['bank_pd_frpid'][$bankmark])) {
    		$pd_FrpId = $yeepay_config['bank_pd_frpid'][$bankmark];
    	}
    	else {
    		$pd_FrpId = '';
    	}
    	//$pd_FrpId					= $_REQUEST['pd_FrpId'];
    	
    	#	应答机制
    	##默认为"1": 需要应答机制;
    	$pr_NeedResponse	= "1";
    	
    	#调用签名函数生成签名串
    	$hmac = getReqHmacString($p2_Order,$p3_Amt,$p4_Cur,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pd_FrpId,$pr_NeedResponse);
    	$html = '
    	<html>
<head>
<title>To YeePay Page</title>
</head>
<body onLoad="document.yeepay.submit();">
<form name="yeepay" action="'.$reqURL_onLine.'" method="post">
<input type="hidden" name="p0_Cmd"					value="'.$p0_Cmd.'">
<input type="hidden" name="p1_MerId"				value="'.$p1_MerId.'">
<input type="hidden" name="p2_Order"				value="'.$p2_Order.'">
<input type="hidden" name="p3_Amt"					value="'.$p3_Amt.'">
<input type="hidden" name="p4_Cur"					value="'.$p4_Cur.'">
<input type="hidden" name="p5_Pid"					value="'.$p5_Pid.'">
<input type="hidden" name="p6_Pcat"					value="'.$p6_Pcat.'">
<input type="hidden" name="p7_Pdesc"				value="'.$p7_Pdesc.'">
<input type="hidden" name="p8_Url"					value="'.$p8_Url.'">
<input type="hidden" name="p9_SAF"					value="'.$p9_SAF.'">
<input type="hidden" name="pa_MP"					value="'.$pa_MP.'">
<input type="hidden" name="pd_FrpId"				value="'.$pd_FrpId.'">
<input type="hidden" name="pr_NeedResponse"	value="'.$pr_NeedResponse.'">
<input type="hidden" name="hmac"						value="'.$hmac.'">
</form>
</body>
</html>
    	';
    	echo $html;
    }
    
    public function yeepay_get() {
    	$surl = '404';
    	$log_file         = 'yeepay_log';
    	$log_file_error   = $log_file.'_error';
    	$log_file_success = $log_file.'_success';
    	d($_GET);
    	if ( empty($_GET))
    		url::redirect($surl);
    	include WEBROOT.'application/libraries/yeepay/yeepayCommon.php';
    	
    	#	只有支付成功时易宝支付才会通知商户.
    	##支付成功回调有两次，都会通知到在线支付请求参数中的p8_Url上：浏览器重定向;服务器点对点通讯.
    	
    	#	解析返回参数.
    	$return = getCallBackValue($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
    	
    	#	判断返回签名是否正确（True/False）
    	$bRet = CheckHmac($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
    	#	以上代码和变量不需要修改.
    	 
    	#	校验码正确.
    	if($bRet){
    	if($r1_Code=="1"){
    	
    	#	需要比较返回的金额与商家数据库中订单的金额是否相等，只有相等的情况下才认为是交易成功.
    	#	并且需要对返回的处理进行事务控制，进行记录的排它性处理，在接收到支付结果通知后，判断是否进行过业务逻辑处理，不要重复进行业务逻辑处理，防止对同一条交易重复发货的情况发生.
    	
    	if($r9_BType=="1"){
    	echo "交易成功";
    	echo  "<br />在线支付页面返回";
    	}elseif($r9_BType=="2"){
    	#如果需要应答机制则必须回写流,以success开头,大小写不敏感.
    		echo "success";
    		echo "<br />交易成功";
    		echo  "<br />在线支付服务器返回";
    	}
    	}
    	
    	}else{
    	echo "交易信息被篡改";
    	}
    	
    }
    
}
