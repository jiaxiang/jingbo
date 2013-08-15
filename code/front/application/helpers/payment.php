<?php defined('SYSPATH') or die('No direct script access.');
class Payment_Core {
    /*
     * get cc type information
     *
     * @param     <int> $site_id
     * @param     <str> $currency
     * @return     Array
     */
    public static function get_cc_type($currency)
    {
        $cc_type_arr = array('Visa'=>'Visa','MasterCard'=>'MasterCard','Amex'=>'Amex','Maestro'=>'Maestro','Solo'=>'Solo','Discover'=>'Discover');
        return $cc_type_arr;
    }
    
    /**
     * 往支付网关发送数据
     * 用于pp支付或者其他跳转支付的验证流程
     * 参数是order数组等等
     * 注意pay_id必须
     */
    public static function send_payment_detail($order,$pay_id,$secure_code,$submit_url)
    {

        //$post_url = "https://www.backstage-gateway.com/pp";
        $post_url = $submit_url;
        $post_var = "order_num=".$order['order_num']
                        ."&order_amount=".$order['total']
                        ."&order_currency=".$order['currency']
                        ."&billing_firstname=".$order['billing_firstname']
                        ."&billing_lastname=".$order['billing_lastname']
                        ."&billing_address=".$order['billing_address']
                        ."&billing_zip=".$order['billing_zip']
                        ."&billing_city=".$order['billing_city']
                        ."&billing_state=".$order['billing_state']
                        ."&billing_country=".$order['billing_country']
                        ."&billing_telephone=".$order['billing_phone']
                        ."&billing_ip_address=".long2ip($order['ip'])
                        ."&billing_email=".$order['email']
                        ."&shipping_firstname=".$order['shipping_firstname']
                        ."&shipping_lastname=".$order['shipping_lastname']
                        ."&shipping_address=".$order['shipping_address']
                        ."&shipping_zip=".$order['shipping_zip']
                        ."&shipping_city=".$order['shipping_city']
                        ."&shipping_state=".$order['shipping_state']
                        ."&shipping_country=".$order['shipping_country']
                        ."&trans_id=".$order['trans_id']
                        ."&secure_code=".$secure_code
                        ."&site_id=".$pay_id;
        $result            = tool::curl_pay($post_url,$post_var);
        $error_msg = '';
        $is_serialization = tool::check_serialization($result,$error_msg);
        $res = null;
        if($is_serialization)
        {
            $result = stripcslashes($result);
            $res = unserialize($result);
        }
        if(is_array($res)){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 图片按钮返回
     */
    public static function cart_payment_images()
    {
        $payments = Mypayment::instance()->from_cart_payments();
        $cart_payment_images = '';
        foreach($payments as $key=>$rs)
        {
            $cart_payment_images .= html::anchor( url::base(false,site::protocol()).'payment/paypalec_payment?pid='.$rs['id'] , html::image(array('src' => $rs['payment_type']['image_url']) ,array('alt' => $rs['payment_type']['name'])));
        }
        return $cart_payment_images;
    }
}