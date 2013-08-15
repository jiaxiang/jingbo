<?php defined('SYSPATH') OR die('No direct access allowed.');

class Order_success_Controller extends Controller {

	public function index(){
        $user_addres = array();
		try {
	    	$order_num = $this->input->get('order_num', '');
			if(empty($order_num)){
				remind::set(kohana::lang('o_step.o_step_index_cart_empty'), 'error', '/');
			}
			if(!$user = user::logged_in()){
				url::redirect('/register'."?redirect=".url::current(TRUE));
			}
            $order = Myorder::instance()->get_by_order_num($order_num);
			if(empty($order['order_num'])){
				remind::set(kohana::lang('o_step.order_empty'), 'error', '/');
			}
            
            //可用支付方式
            $payments = Mypayment::instance()->payments();
			include(APPTPL."cart_success.html");
		}catch (Exception $ex){
			remind::set(kohana::lang('o_order.order_lose_message'), 'error', '/error404');
		}
	}

}
