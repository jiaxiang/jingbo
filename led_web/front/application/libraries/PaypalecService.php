<?php
defined('SYSPATH') or die('No direct access allowed.');
class PaypalecService_Core {
    private $payment;
    private $api = array ();
    //支付模块处理实例
    private $payment_instance = NULL;

    public function __construct($payment)
    {
        $this->payment = $payment;
        if (! empty($payment['args'])) {
            $this->api = unserialize($payment['args']);
        }
        $this->payment_instance = Payment::get_instance('paypalec');
    }

    /**
     * 支付流程
     * @param array $msg 设置的支付信息
     */
    public function ec_step1($msg)
    {
        //设置支付信息
        $fileds = array (
            'USER' => $this->api['account'], 
            'PWD' => $this->api['passwd'], 
            'SIGNATURE' => $this->api['signature'], 
            'SUBMITURL' => $this->api['submit_url'], 
            'VERSION' => $this->api['version'], 
            'RETURNURL' => url::base(false, site::protocol()) . "payment/paypalec_respond", 
            'CANCELURL' => url::base() . "cart", 
            'NOTIFYURL' => url::base() . "payment/paypal_ipn", 
            'HDRIMG' => url::base(false, site::protocol()) . "images/logo.gif", 
            'CURRENCYCODE' => $msg['currency'], 
            'AMT' => $msg['amount'] 
        );
        $fileds['JUMPURL'] = ! empty($this->api['jump_url']) ? $this->api['jump_url'] : '';
        $this->payment_instance->set($fileds); //设置支付信息
        try {
            $this->payment_instance->do_ec();
        } catch (MyRuntimeException $ex) {
            $msg = $ex->getMessage();
            $session = Session::instance();
            $session->set_flash('message', $msg);
            url::redirect(url::base() . "payment/success");
        }
    }

    public function process($order)
    {
        //设置支付信息
        $fileds = array (
            'USER' => $this->api['account'], 
            'PWD' => $this->api['passwd'], 
            'SIGNATURE' => $this->api['signature'], 
            'SUBMITURL' => $this->api['submit_url'], 
            'VERSION' => $this->api['version'], 
            'NOTIFYURL' => url::base() . "payment/paypal_ipn", 
            'INVNUM' => $order['order_num'], 
            'CURRENCYCODE' => $order['currency'], 
            'AMT' => $order['total'] 
        );
        $this->payment_instance->set($fileds); //设置支付信息
        $res_array = $this->payment_instance->handle();
        if (! $res_array) {
            url::redirect('404');
        }
        if (stristr($res_array['ACK'], 'SUCCESS')) {
            //{因为有pp ipn的存在，这里不用修改订单状态，如果一定要修改丁单状态，请把代码写到这个地方}
            $success = "Thanks for your payment!";
            $session = Session::instance();
            $session->set_flash('message', $success);
            url::redirect(url::base() . "payment/success?item_number=".$order['order_num']);
        } else {
            $success = $res_array['L_LONGMESSAGE0'];
            $session = Session::instance();
            $session->set_flash('message', $success);
			Kohana::log('paypal ec failed',print_r($res_array,true));
            url::redirect(url::base() . "payment/success");
        }
    }
}