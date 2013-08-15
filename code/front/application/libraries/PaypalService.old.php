<?php
defined('SYSPATH') or die('No direct access allowed.');
class PaypalService_Core {
    private $payment;
    //支付模块处理实例
    private $payment_instance = NULL;

    public function __construct($payment)
    {
        $this->payment = $payment;
        $this->payment_instance = Payment::get_instance('paypal');
    }

    /**
     * 支付流程封装
     * @param array $order 设置的支付信息
     */
    public function process_paypal($order){
        $time_start = microtime(TRUE);
        //订单资料修改，根据post值
        if (! order::edit($order)) {
            remind::set('order edit error', 'error', request::referrer());
        }
        //$order = order::get_detail($order);
        
        $logo = Mysite::instance()->get('logo');
        //设置支付信息
        $fileds = array (
            'item_number' => $order['order_num'], 
            'invoice' => $order['order_num'], 
            'amount' => $order['total'], 
            'currency_code' => $order['currency'], 
            'item_name' => $order['order_num'], 
            'image_url' => url::base(false,site::protocol()). $logo, 
            'cancel_return' => url::base().'user/orders', 
            'return' => url::base().'payment/success',  //成功返回地址
            'notify_url' => url::base().'payment/paypal_ipn',  //ipn地址
        );
        $fileds['business'] = ! empty($this->payment['account']) ? $this->payment['account'] : '';
        $fileds['submit_url'] = ! empty($this->payment['payment_type']['submit_url']) ? $this->payment['payment_type']['submit_url'] : '';
        
        /*执行支付*/
        $this->payment_instance->set($fileds); //设置支付信息
        $this->payment_instance->handle();
        return false;
    }
    
    /**
     * 支付流程封装
     * @param array $order 设置的支付信息
     */
    public function process($order)
    {
        $time_start = microtime(TRUE);
        //订单资料修改，根据post值
        if (! order::edit($order))
        {
            remind::set('order edit error', 'error', request::referrer());
        }
        //$order = order::get_detail($order);
        
        $logo = Mysite::instance()->get('logo');
        //设置支付信息
        $fileds = array (
            'item_number' => $order['order_num'], 
            'invoice' => $order['order_num'], 
            'amount' => $order['total'], 
            'currency_code' => $order['currency'], 
            'item_name' => $order['order_num'], 
            'image_url' => url::base(false,site::protocol()).'images/G/' . $logo, 
            'cancel_return' => url::base().'user/orders', 
            'return' => url::base().'payment/success',  //成功返回地址
            'notify_url' => url::base().'payment/paypal_ipn',  //ipn地址
        );
        $fileds['business'] = ! empty($this->payment['account']) ? $this->payment['account'] : '';
        $fileds['submit_url'] = ! empty($this->payment['payment_type']['submit_url']) ? $this->payment['payment_type']['submit_url'] : '';
        /*执行支付*/
        $this->payment_instance->set($fileds); //设置支付信息
        $this->payment_instance->handle();
        return false;
    }

}