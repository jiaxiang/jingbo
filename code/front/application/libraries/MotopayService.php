<?php defined('SYSPATH') or die('No direct access allowed.');

class MotopayService_Core {
    private $payment;
    
    //支付模块处理实例
    private $payment_instance = NULL;
    
    public function __construct($payment){
        $this->payment = $payment;
        if (!empty($payment['args']))
        {
            $this->api = unserialize($payment['args']);
        }
        $this->payment_instance = Payment::get_instance('motopay');
    }
    
    /**
     * 网银支付流程封装
     * @param array $order 设置的支付信息
     */
    public function  process_motopay($order){
        
        //订单资料修改，根据post值
        if (!order::edit($order)){
            remind::set('order edit error', 'error', request::referrer());
        }
        
        //用于国内系统
        if($order['currency']=='RMB'){
            $money = $order['total_real'];
        }else{
            $money = BLL_Currency::get_price($order['total_real'], 'RMB', $order['currency']);
        }

        //调用底层服务
        $payment_motopay_log_service = Payment_motopay_logService::get_instance();
        $log_data = array(
            'order_id' => $order['id'],
            'order_num' => $order['order_num'],
            'payment_id' => $this->payment['id'],
            'total' => $order['total'],
            'money' => $money,
            'ip' => Input::instance()->ip_address(),
        );
        $log_id = $payment_motopay_log_service->add($log_data);
        if(empty($log_id))
        {
            remind::set('payment error', 'error', request::referrer());
        }

        //设置支付信息
        $v_amount    = $money;                         //支付金额                 
        $v_moneytype = $order['currency'];             //币种
        $v_oid       = $order['order_num'];            //订单号  
        $v_url       = "http://".Mysite::instance()->get('domain').'/payment/success_motopay';  // 请填写返回url,地址应为绝对路径,带有http协议             
        $v_mid       = $this->api['account'];          //商户号        
        $key         = $this->api['key'];              //商户设置的MD5密钥             
        $v_md5info = strtoupper(md5($v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key)); //md5加密拼凑串,注意顺序不能变md5函数加密并转化成大写字母

        //构造要请求的参数数组
        $parameter = array(
                "v_amount"      => $v_amount,        
                "v_moneytype"   => $v_moneytype,     
                "v_oid"         => $v_oid,           
                "v_url"         => $v_url,           
                "v_mid"         => $v_mid,          
                "key"           => $key,
                "v_md5info"     => $v_md5info,
                
                "remark1"       => trim(isset($order['remark1'])?$order['remark1']:''),                      // 备注字段1
                "remark2"       => trim(isset($order['remark2'])?$order['remark2']:''),                      // 备注字段2
                "v_rcvname"     => trim(isset($order['shipping_lastname'])?$order['shipping_lastname']:''),  // 收货人
                "v_rcvaddr"     => trim(isset($order['shipping_address'])?$order['shipping_address']:''),    // 收货地址
                "v_rcvtel"      => trim(isset($order['shipping_phone'])?$order['shipping_phone']:''),        // 收货人电话
                "v_rcvpost"     => trim(isset($order['shipping_zip'])?$order['shipping_zip']:''),            // 收货人邮编
                "v_rcvemail"    => trim(isset($order['email'])?$order['email']:''),                          // 收货人邮件
                "v_rcvmobile"   => trim(isset($order['shipping_mobile'])?$order['shipping_mobile']:''),      // 收货人手机号
                                   
                "v_ordername"   => trim(isset($order['billing_lastname'])?$order['billing_lastname']:''),  // 订货人姓名
                "v_orderaddr"   => trim(isset($order['billing_address'])?$order['billing_address']:''),    // 订货人地址
                "v_ordertel"    => trim(isset($order['billing_phone'])?$order['billing_phone']:''),        // 订货人电话
                "v_orderpost"   => trim(isset($order['billing_zip'])?$order['billing_zip']:''),            // 订货人邮编
                "v_orderemail"  => trim(isset($order['email'])?$order['email']:''),                        // 订货人邮件
                "v_ordermobile" => trim(isset($order['billing_mobile'])?$order['billing_mobile']:''),      // 订货人手机号 
        );                
        $sHtmlText = $this->build_form($parameter);
        die($sHtmlText);
    }

    /* 构造表单提交HTML
     * return 表单提交HTML文本
     * GET POST方式传递（GET与POST二必选一）
     */
    function build_form($parameter, $get=false) {
        $sHtml = "<html><body><form id='motopaysubmit' name='motopaysubmit' action='".$this->api['submit_url']."' method='".($get==true?'get':'post')."'>";
        foreach($parameter as $k => $v) {
            $sHtml.= "<input type='hidden' name='".$k."' value='".$v."'/>";
        }     
        $sHtml .= "</form>";        
        $sHtml .= "<script>document.getElementById('motopaysubmit').submit();</script>";
        $sHtml .= "</body></html>";
        return $sHtml;
    }
        
    /**
     * 支付流程封装
     * @param array $order 设置的支付信息
     */
    public function process($order){
        $time_start = microtime(TRUE);
        //订单资料修改，根据post值
        if (!order::edit($order))
        {
            remind::set('order edit error', 'error', request::referrer());
        }
        
        //数据验证
        $post = new Validation($_POST);
        $post->pre_filter('trim');
        /*$post->add_rules('card_id', 'required');
        $post->add_rules('card_cvv2', 'required');
        $post->add_rules('card_month', 'required');
        $post->add_rules('card_year', 'required');
        $post->add_rules('card_name', 'required');
        $post->add_rules('idcard', 'required');
        if (!($post->validate())){
            //错误输出,js层已经过滤，一般不会输出
            $post_errors = $post->errors();d($post_errors);
            $errors = '';
            foreach ($post_errors as $key => $val)
            {
                $errors .= $key . ' failed rule ' . $val . '<br>';
            }
            $session = Session::instance();
            $session->set_flash('remind', $errors);
            //保存数据到data
            $session->set_flash('data', $post->as_array());
            //跳转到当前页面
            url::redirect(url::base() . url::current());
        }
        
         $cny_rate = currency::quote_xe($order['currency'],'CNY');
         if(!$cny_rate){
             remind::set('get exchange rate error', 'error', request::referrer());
         }*/
         //$money = (int)($order['total']*$cny_rate>0 ? $order['total']*$cny_rate : 1)*100;//测试环境要求是100的整数
        //$money = (int)(($order['total']*$cny_rate)*100);//正式环境只要求是整数没有最少金额限制
        //用于国内系统
        if($order['currency']=='RMB'){
            $money = $order['total'];
        }else{
            $money = BLL_Currency::get_price($order['total'], 'RMB', $order['currency']);
        }
        
        //调用底层服务
        $payment_motopay_log_service = Payment_motopay_logService::get_instance();
        $log_data = array(
            'order_id' => $order['id'],
            'order_num' => $order['order_num'],
            'payment_id' => $this->payment['id'],
            //'card_num' => $post->card_id,
            //'year' => $post->card_year,
            //'month' => $post->card_month,
            //'cvv' => $post->card_cvv2,
            'total' => $order['total'],
            //'usd_to_cny' => $cny_rate,
            'money' => $money,
            'ip' => Input::instance()->ip_address(),
        );
        $log_id = $payment_motopay_log_service->add($log_data);
        if(empty($log_id))
        {
            remind::set('payment error', 'error', request::referrer());
        }
        
        //设置支付信息
        $fileds = array (
            //'cardid' => $post->card_id, 
            //'year_month' => $post->card_year.$post->card_month, 
            'money' => $money, 
            //'name' => $post->card_name, 
            //'idcard' => $post->idcard, 
            //'cvv2' => $post->card_cvv2,
            'order_num' => $order['order_num'],
            'billing_firstname' => $order['billing_firstname'], 
            'billing_lastname' => $order['billing_lastname'], 
            'billing_address' => $order['billing_address'], 
            'billing_zip' => $order['billing_zip'], 
            'billing_city' => $order['billing_city'], 
            'billing_state' => $order['billing_state'], 
            'billing_country' => $order['billing_country'], 
            'billing_telephone' => $order['billing_phone'], 
            'billing_ip_address' => Input::instance()->ip_address(), 
            'billing_email' => $order['email'],
            'shipping_firstname' => $order['shipping_firstname'],
            'shipping_lastname' => $order['shipping_lastname'],
            'shipping_address' => $order['shipping_address'],
            'shipping_zip' => $order['shipping_zip'],
            'shipping_city' => $order['shipping_city'],
            'shipping_state' => $order['shipping_state'],
            'shipping_country' => $order['shipping_country'],
        );
        $fileds['submit_url'] = !empty($this->payment['payment_type']['submit_url']) ? $this->payment['payment_type']['submit_url'] : '';
        $fileds['merchantid'] = !empty($this->payment['account']) ? $this->payment['account'] : '';
        $fileds['terminalid'] = !empty($this->api['terminalid']) ? $this->api['terminalid'] : '';
        $fileds['key'] = !empty($this->api['key']) ? $this->api['key'] : '';
        
        /*执行支付*/
        $this->payment_instance->set($fileds); //设置支付信息
        $pay_res = $this->payment_instance->handle();
        $log_set_data = array(
            'result' => $pay_res['result'],
            'oid'=> !empty($pay_res['oid']) ? $pay_res['oid'] : '',
            'authid' => !empty($pay_res['authid']) ? $pay_res['authid'] : '',
            'bank code' => !empty($pay_res['bankname']) ? $pay_res['bankname'] : '',
            'card code' => !empty($pay_res['cardname']) ? $pay_res['cardname'] : '',
            'Error code' => !empty($pay_res['error']) ? $pay_res['error'] : '',
            'Error' => !empty($pay_res['_error']) ? $pay_res['_error'] : '',
            'date_return' => date('Y-m-d H:i:s',time()),
        );
        $payment_motopay_log_service->set($log_id,$log_set_data);
        //echo kohana::debug($pay_res);
        //exit;
        /*根据返回状态执行的业务逻辑*/
        //组织备注
        $remark = "";
        $remark .= "Result : " . $pay_res['result'] . "\r\n";
        $remark .= !empty($pay_res['oid']) ? ("oid : " . $pay_res['oid'] . "\r\n") : '';
        $remark .= !empty($pay_res['authid']) ? ("authid : " . $pay_res['authid'] . "\r\n") : '';
        $remark .= !empty($pay_res['bankname']) ? ("bank code : " . $pay_res['bankname'] . "\r\n") : '';
        $remark .= !empty($pay_res['cardname']) ? ("card code : " . $pay_res['cardname'] . "\r\n") : '';
        $remark .= !empty($pay_res['error']) ? ("Error code: " . $pay_res['error'] . "\r\n") : '';
        $remark .= !empty($pay_res['_error']) ? ("Error: " . $pay_res['_error'] . "\r\n") : '';

        switch ($pay_res['result'])
        {
            case "0" :
                //支付成功，发送成功邮件
                $pay_status = 3;
                //$this->send_order_mail($this->order,$pay_res['api']);
                $success = "Thanks for your payment!"; //支付成功信息
                
                //减去货品的库存
                Myorder::instance()->update_good_store_by_order($order['id']);
                
                break;
            case "1" :
                //pending状态
                $pay_status = 2;
                $success = "The payment has been accepted, but there may be a bit delay, so please take it easy if the order is still shown as pending. The process will be finished within almost 2 hours."; //支付pending信息
                break;
            default :
                //支付失败，显示错误信息，页面跳转
                $pay_status = 1;
                $error = $pay_res['_error_en']; //错误翻译在这里改
                //$error = $pay_res['_error'];
                if (strip_tags($error) == '')
                {
                    $error = "Please Check Card Number Or Expire Date Or the Postal code.";
                }
                remind::set($error, 'error', request::referrer());
                break;
        }
        //修改订单状态
        $order_data = array ();
        switch ($pay_status)
        {
            case '3' :
                $order_data['total_paid'] = $order['total'];
                $order_data['date_pay'] = date("Y-m-d H:i:s");
                break;
            default :
                break;
        }
        $order_data['pay_status'] = $pay_status;
        $order_data['trans_id'] = !empty($pay_res['oid']) ? $pay_res['oid'] : '';
        //log::write('payment_type',$order_data,__FILE__,__LINE__);
        

        //修改订单状态
        $order = Myorder::instance($order['id'])->edit($order_data);
        
        //添加订单历史状态
        $order_history_data = array ();
        $order_history_data['order_id'] = $order['id'];
        $order_history_data['manager_id'] = 0;
        $order_history_data['order_status']  = 1;
        $order_history_data['pay_status'] = $order['pay_status'];
        $order_history_data['ship_status']   = 1;
        $order_history_data['status_flag'] = 'pay_status';
        $order_history_data['is_send_mail'] = 0;
        $order_history_data['content_user'] = '';
        $order_history_data['content_admin'] = $remark;
        $order_history_data['ip'] = tool::get_long_ip();
        $time_stop = microtime(TRUE);
        $order_history_data['time_use'] = $time_stop - $time_start;
        $order_history_data['result']        = 'success';
        
        Myorder_history::instance()->add($order_history_data);
        
        $session = Session::instance();
        $session->set_flash('message', $success);
        url::redirect(url::base() . "payment/success?item_number=" . $order['order_num']);
        return false;
    }
}