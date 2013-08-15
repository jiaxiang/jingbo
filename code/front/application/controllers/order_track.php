<?php
defined('SYSPATH') or die('No direct access allowed.');
class Order_track_Controller extends Controller
{
	private $order_track_view;

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// $this->profiler = new Profiler;
		$order_track_arr = array();
		if($_POST)
		{
			$order_track_arr = array(
			    'email'=>'',
			    'order_num'=>'',
			    'user_show'=>'',
			    'ems_num'=>'',
			    'content_user'=>''
			);
			$email = $this->input->post('email');
			$order_num = $this->input->post('order_num');
			$where = array();
			$where['email'] = $email;
			$where['order_num'] = $order_num;
			$where['order_status !='] = '4';
			$orders = Myorder::instance()->orders($where);
			$config = kohana::config('order');
			if(count($orders))
			{
				$order_track_arr['email'] = $orders[0]['email'];
				$order_track_arr['order_num'] = $orders[0]['order_num'];
				$order_track_arr['user_show'] = $config['pay_status'][$orders[0]['pay_status']]['front_name'];
				$order_track_arr['user_show'] .= '&nbsp;|&nbsp;'.$config['ship_status'][$orders[0]['ship_status']]['front_name'];
				if($orders[0]['ems_num'])
				{
					$order_track_arr['ems_num'] = $orders[0]['ems_num'];
					$where = array();
					$where['order_id'] = $orders[0]['id'];
					$where['status_flag'] = 'ship_status';
					$where['ship_status'] = '4';
					
					$order_history = Myorder_history::instance()->order_histories($where);
					if(!empty($order_history))
					{
					   $order_track_arr['content_user'] = $order_history[0]['content_user'];
					}
				}
			}
			else
			{
				remind::set(kohana::lang('o_order_track.o_order_track_index_no_order'), 'notice',request::referrer());
			}
		}

		$this->order_track_view = new View("order_track");
		$this->order_track_view->order_track = $order_track_arr;
		$this->order_track_view->render(TRUE);
	}
}