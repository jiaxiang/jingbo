<?php defined('SYSPATH') or die('No direct access allowed.');

class  PaypalService_Core{

    private $payment;
    private $api;
    
    public $gateway;           //网关地址
    public $_key;              //安全校验码
    public $mysign;            //签名结果
    public $sign_type;         //签名类型
    public $parameter;         //需要签名的参数数组
    public $_input_charset;    //字符编码格式

    /**构造函数
    *从配置文件及入口文件中初始化变量
    */
    public function __construct($payment){
        $this->payment = $payment;
        if (!empty($payment['args']) && is_string($payment['args'])){
            $payment['args'] = unserialize($payment['args']);
        }
        $this->api        = $payment['args'];
        $this->gateway    = $this->api['submit_url'];
        $this->_key       = $this->api['key'];
        $this->sign_type  = 'MD5';        
    }

    /**
     * 支付宝支付流程封装
     * @param array $order 设置的支付信息
     */
    public function  process_paypal($order){
        
        //订单资料修改，根据post值
        if (!order::edit($order)){
            remind::set('order edit error', 'error', request::referrer());
        }
        
        $order['money'] = $order['total_real'];
        
        //订单支付日志
        /*$payment_motopay_log_service = Payment_motopay_logService::get_instance();
        $log_data = array(
            'order_id'    => $order['id'],
            'order_num'   => $order['order_num'],
            'payment_id'  => $this->payment['id'],
            'total'       => $order['total'],
            'money'       => $order['money'],
            'ip'          => $order['ip'],
        );
        $log_id = $payment_motopay_log_service->add($log_data);
        if(empty($log_id)){
            return false;
        }
        */
        $parameter = $this->build_parameter($order);
        $preParameter = $this->para_filter($parameter);
        
        //得到从字母a到z排序后的签名参数数组       
        $this->parameter = $this->arg_sort($preParameter);   
        
        //获得签名结果
        $this->mysign = $this->build_mysign($this->parameter, $this->_key, $this->sign_type);
        $sHtmlText = $this->build_form();
        die($sHtmlText);
    }    

    /* 构造表单提交HTML
     * return 表单提交HTML文本
     * GET POST方式传递（GET与POST二必选一）
     */
    function build_form($get=false) {
        $sHtml = "<html><body><form id='paypalsubmit' name='paypalsubmit' action='".$this->gateway."' method='".($get==true?'get':'post')."'>";
        
        $arrpara = $this->parameter;    
              
        foreach($arrpara as $key => $val) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

        $sHtml .= "<input type='hidden' name='amount' value='".$arrpara['total_fee']."'>";
        $sHtml .= "<input type='hidden' name='item_name' value='".$arrpara['out_trade_no']."'>";
        $sHtml .= "<input type='hidden' name='currency_code' value='CNY'>";
        //$sHtml .= "<input type='hidden' name='business' value='".$arrpara['seller_email']."'>";
        $sHtml .= "<input type='hidden' name='sign' value='".$this->mysign."'/>";
        $sHtml .= "<input type='hidden' name='sign_type' value='".$this->sign_type."'/>";        
        $sHtml .= "</form>";
        
        $sHtml .= "<script>document.getElementById('paypalsubmit').submit();</script>";
        $sHtml .= "</body></html>";
        return $sHtml;
    }
    
    //创建接口参数
    private function build_parameter($order, $now=1){        
        //必填参数 以下参数是需要通过下单时的订单数据传入进来获得
        $out_trade_no = $order['order_num'];    //请与贵网站订单系统中的唯一订单号匹配
        $subject      = $order['order_num'];    //订单名称，显示在支付宝收银台里的“商品名称”里，显示在支付宝的交易管理的“商品名称”的列表里。
        $body         = date('Y-m-d H:i:s');    //订单描述、订单详细、订单备注，显示在支付宝收银台里的“商品描述”里
        $price        = $order['money'];        //订单总金额，显示在支付宝收银台里的“应付总额”里

        $siteurl    = url::base(false,site::protocol());
        $show_url   = $siteurl.'order/order_detail/'.$out_trade_no; //订单详细页面
        $return_url = $siteurl.'payment/success_paypal';            // 请填写返回url,地址应为绝对路径,带有http协议  
        $notify_url = $siteurl.'payment/notify_paypal';
        
        //扩展功能参数——默认支付方式
        $pay_mode = isset($_POST['pay_bank'])?$_POST['pay_bank']:'directPay';
        if ($pay_mode == "directPay") {
            $paymethod    = "directPay"; //默认支付方式，四个值可选：bankPay(网银); cartoon(卡通); directPay(余额); CASH(网点支付)
            $defaultbank  = "";
        } else {
            $paymethod    = "bankPay";  //默认支付方式，四个值可选：bankPay(网银); cartoon(卡通); directPay(余额); CASH(网点支付)
            $defaultbank  = $pay_mode;  //默认网银代号，代号列表见http://club.alipay.com/read.php?tid=8681379
        }        

        //构造即时到帐要请求的参数数组，无需改动
        if($now==1)return array(
                "service"            => "create_direct_pay_by_user",    //即时到帐接口名称，不需要修改
                "payment_type"       => "1",                           //交易类型，不需要修改

                //获取配置$this->api中的值
                "partner"           => $this->api['partner'],
                "seller_email"      => $this->api['account'],
                "return_url"        => $return_url,
                "notify_url"        => $notify_url,
                "_input_charset"    => 'utf-8',
                "show_url"          => $show_url,
                    
                //从订单数据中动态获取到的必填参数
                "out_trade_no"      => $out_trade_no,
                "subject"           => $subject,
                "body"              => $body,
                "total_fee"         => $price,

                //扩展功能参数——网银提前
                "paymethod"         => $paymethod,
                "defaultbank"       => $defaultbank,

                //扩展功能参数——防钓鱼
                //"anti_phishing_key" => '',
                "exter_invoke_ip"     => Input::instance()->ip_address(),
            );
    }
     
    /**生成签名结果
     *$array要签名的数组
     *return 签名结果字符串
    */
    public function build_mysign($sort_array, $key, $sign_type = "MD5") {
        $prestr = $this->create_linkstring($sort_array);         //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = $prestr.$key;                                 //把拼接后的字符串再与安全校验码直接连接起来
        $mysgin = $this->sign($prestr,$sign_type);               //把最终的字符串签名，获得签名结果
        return $mysgin;
    }

    /* 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * $array 需要拼接的数组
     * return 拼接完成以后的字符串
     */
    public function create_linkstring($array) {
        $arg  = array();
        foreach($array as $key => $val){
            $arg[] = $key."=".$val;
        }
        return implode('&', $arg);
    }

    /* 除去数组中的空值和签名参数
     * $parameter 签名参数组
     * return 去掉空值与签名参数后的新签名参数组
     */
    public function para_filter($parameter) {
        $para = array();
        foreach($parameter as $key => $val){
            if($key == "sign" || $key == "sign_type" || $val == "")continue;
            $para[$key] = $parameter[$key];
        }
        return $para;
    }

    /* 对数组排序
     * $array 排序前的数组
     * return 排序后的数组
     */
    public function arg_sort($array) {
        ksort($array);
        reset($array);
        return $array;
    }

    /**签名字符串
     * $prestr 需要签名的字符串
     * return 签名结果
     */
    public function sign($prestr,$sign_type) {
        $sign='';
        if($sign_type == 'MD5') {
            $sign = md5($prestr);
        }else {
            die("支付宝暂不支持".$sign_type."类型的签名方式，请先使用MD5签名方式");
        }
        return $sign;
    }

    // 日志消息,把支付宝返回的参数记录下来
    public function  log_result($word) {
        //log::write('alipay_return_data', "执行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n", __FILE__, __LINE__);
        /*$fp = fopen("log.txt","a");
        flock($fp, LOCK_EX) ;
        fwrite($fp,"执行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
        flock($fp, LOCK_UN);
        fclose($fp);*/
    }
    
    /* 实现多种字符编码方式
     * $input 需要编码的字符串
     * $_output_charset 输出的编码格式
     * $_input_charset 输入的编码格式
     * return 编码后的字符串
     */
    public function charset_encode($input,$_output_charset ,$_input_charset) {
        $output = "";
        if(!isset($_output_charset) )$_output_charset  = $_input_charset;
        if($_input_charset == $_output_charset || $input ==null ) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
        } elseif(function_exists("iconv")) {
            $output = iconv($_input_charset,$_output_charset,$input);
        } else die("sorry, you have no libs support for charset change.");
        return $output;
    }

    /* 实现多种字符解码方式
     * $input 需要解码的字符串
     * $_output_charset 输出的解码格式
     * $_input_charset 输入的解码格式
     * return 解码后的字符串
     */
    public function charset_decode($input,$_input_charset ,$_output_charset) {
        $output = "";
        if(!isset($_input_charset) )$_input_charset  = $_input_charset ;
        if($_input_charset == $_output_charset || $input ==null ) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
        } elseif(function_exists("iconv")) {
            $output = iconv($_input_charset,$_output_charset,$input);
        } else die("sorry, you have no libs support for charset changes.");
        return $output;
    }

    /**用于防钓鱼，调用接口query_timestamp来获取时间戳的处理函数
    注意：由于低版本的PHP配置环境不支持远程XML解析，因此必须服务器、本地电脑中装有高版本的PHP配置环境。建议本地调试时使用PHP开发软件
    *$partner 合作身份者ID
    *return 时间戳字符串
    */
    public function query_timestamp($partner) {
        $URL = "https://mapi.alipay.com/gateway.do?service=query_timestamp&partner=".$partner;
        $encrypt_key = "";
        $doc = new DOMDocument();
        $doc->load($URL);
        $itemEncrypt_key = $doc->getElementsByTagName( "encrypt_key" );
        $encrypt_key = $itemEncrypt_key->item(0)->nodeValue;
        return $encrypt_key;
    }
    
}