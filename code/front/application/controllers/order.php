<?php defined('SYSPATH') OR die('No direct access allowed.');

class Order_Controller extends Controller {

	//TODO fixed the name space
	public function detail($order_num=''){
		try {
			if(!$user = user::logged_in()){
				url::redirect(route::action('login')."?redirect=".url::current(TRUE));
			}
            $order_num = $order_num?$order_num:$this->input->get('order_num');
			$order = Myorder::instance()->get_user_order_by_order_num($user['id'], $order_num);
	        if(!$order){
	            url::redirect('404');
	        }
            
	        $config_order = kohana::config('order');
			$order = order::get_detail($order);
			$shipping_name_arr = array();
			foreach($order['order_product'] as $key=>$val){
                $val['shipping_id'] = isset($val['shipping_id'])?$val['shipping_id']:0;
				if ($val['shipping_id']==0){
					$order['order_product'][$key]['shipping_name'] = '参考订单物流';
				}else {
					if( !key_exists($val['shipping_id'], $shipping_name_arr) ){
						$order['order_product'][$key]['shipping_name'] = $shipping_name_arr[$val['shipping_id']] = DeliveryService::get_delivery_name($val['shipping_id']);
					}else {
						$order['order_product'][$key]['shipping_name'] = $shipping_name_arr[$val['shipping_id']];
					}
				}
			}
			if(!empty($shipping_name_arr)){
				$order['carrier'] = implode(' AND ',$shipping_name_arr);
			}
            
            include(APPTPL.'order_detail.html');
		} catch (Exception $exception) {
			remind::set(kohana::lang('o_order.order_lose_message'), 'error',request::referrer());
		}
	}

	public function add_message($id)
	{
		if(!$user = user::logged_in())
		{
			url::redirect(route::action('login')."?redirect=".url::current(TRUE));
		}

        if($_POST)
		{
			$post = new Validation($_POST);
			$post->pre_filter('trim');
			$post->add_rules('order_message','required','length[1,65536]');
			if (!($post->validate()))
			{
				$errors = $post->errors();
				log::write('form_error',$errors,__FILE__,__LINE__);
			}
			$order = Myorder::instance($id)->get();
			$data = array();
			$data['order_id']	= $order['id'];
			$data['message']	= strip_tags($post->order_message);
			$data['ip']			= tool::get_long_ip();
			$data['active']		= 1;

			if(Myorder_message::instance()->add($data))
			{
				remind::set(kohana::lang('o_order.o_order_add_message_success'), 'success',request::referrer());
			}
			else
			{
				remind::set(kohana::lang('o_order.o_order_add_message_failed'), 'error',request::referrer());
			}
        }
		exit;
	}

	public function ajax_edit_shipping_address($order_num)
	{
		if(!$user = user::logged_in())
		{
			url::redirect(route::action('login')."?redirect=".url::current(TRUE));
		}

		$order = Myorder::instance()->get_user_order_by_order_num($user['id'],$order_num);
        if(!$order)
		{
            url::redirect('404');
        }

		$this->template = new  View('shipping_address_edit');
		$this->template->countries = Mycountry::instance()->countries();
		$this->template->order = $order;
	}
    
	public function ajax_edit_billing_address($order_num)
	{
		if(!$user = user::logged_in())
		{
			url::redirect(route::action('login')."?redirect=".url::current(TRUE));
		}

		$order = Myorder::instance()->get_user_order_by_order_num($user['id'],$order_num);
        if(!$order)
		{
            url::redirect('404');
        }

		$this->template = new  View('billing_address_edit');
		$this->template->countries = Mycountry::instance()->countries();
		$this->template->order = $order;
	}
	public function do_edit($order_num)
	{
		if(!$user = user::logged_in())
		{
			url::redirect(route::action('login')."?redirect=".url::current(TRUE));
		}

		$order = Myorder::instance()->get_user_order_by_order_num($user['id'],$order_num);
        if(!$order)
		{
            url::redirect('404');
        }

        if($_POST)
		{

			$post = new Validation($_POST);
			$post->pre_filter('trim');
			if(isset($_POST['billing_firstname'])){
				$post->add_rules('billing_firstname', 'required', 'length[0,200]');
				$post->add_rules('billing_lastname', 'required','length[0,200]');
				$post->add_rules('billing_address', 'required', 'length[0,200]');
				$post->add_rules('billing_zip', 'required','length[0,200]');
				$post->add_rules('billing_city', 'required', 'length[0,200]');
				$post->add_rules('billing_state','length[0,200]');
				$post->add_rules('billing_country', 'required','length[0,200]');
				$post->add_rules('billing_phone', 'required','length[0,200]');
				$post->add_rules('billing_mobile','length[0,200]');
			}
			if(isset($_POST['shipping_firstname'])){
				$post->add_rules('shipping_firstname', 'required', 'length[0,200]');
				$post->add_rules('shipping_lastname', 'required','length[0,200]');
				$post->add_rules('shipping_address', 'required', 'length[0,200]');
				$post->add_rules('shipping_zip', 'required','length[0,200]');
				$post->add_rules('shipping_city', 'required', 'length[0,200]');
				$post->add_rules('shipping_state','length[0,200]');
//				$post->add_rules('shipping_country', 'required','length[0,200]');
				$post->add_rules('shipping_phone', 'required','length[0,200]');
				$post->add_rules('shipping_mobile','length[0,200]');
			}

			if (!($post->validate()))
			{
				$post_errors = $post->errors();
				$errors = '';
				foreach ($post_errors as $key => $val) {
					$errors.= $key.' failed rule '.$val.'<br>';
				}
				remind::set($errors,'error',request::referrer());
			}
			$data = $_POST;
			if(Myorder::instance($order['id'])->edit($data))
			{
				remind::set(kohana::lang('o_order.o_order_do_edit_success'),'success',request::referrer());
			}
			else
			{
				remind::set(kohana::lang('o_order.o_order_do_edit_error'),'error',request::referrer());
			}
        }
		exit;
	}
}
