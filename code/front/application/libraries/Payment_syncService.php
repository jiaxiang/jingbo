<?php
defined ( 'SYSPATH' ) or die ( 'No direct access allowed.' );
/**
 * 支付信息同步
 * @author bin
 */
class Payment_syncService_Core {
	private $time_start;
	
	private static $instance = NULL;
	// 获取单态实例
	public static function instance() {
		if (self::$instance === null) {
			$classname = __CLASS__;
			self::$instance = new $classname ();
		}
		return self::$instance;
	}
	
	public function __construct() {
		$this->time_start = microtime ( TRUE );
	}
	
	/**
	 * 更新订单历史
	 */
	public function add_order_history(& $order_history_data, $remark = '') {
		//添加订单历史状态
		$time_stop = microtime ( TRUE );
		$order_history_data ['time_use'] = $time_stop - $this->time_start;
		$order_history_data ['content_admin'] = $remark;
		return Myorder_history::instance ()->add ( $order_history_data );
	}
	
	/**
	 * 支付后台取消支付
	 * @param $data array 订单同步的数据
	 * @param $order array 订单信息
	 * @param $order_history_data 订单历史信息
	 * @param $remark 订单备注
	 * @return boolean
	 */
	public function bizark_payment_cancel(& $data, & $order, & $order_history_data, $remark) {
		$cancel_reson = array ();
		$order_data = array ();
		
		$cancel_reson [4] = '支付平台取消订单';
		$cancel_reson [12] = '支付平台验证未通过';
		$cancel_reson [13] = '支付平台确认黑名单';
		
		$remark .= $cancel_reson [$data ['payment_status_id']] . "\r\n";
		
		$order_history_data ['order_status'] = 4;
		$order_history_data ['status_flag'] = 'order_status';
		
		$order_data ['order_status'] = 4;
		$order_data ['date_upd'] = date ( "Y-m-d H:i:s" );
		$return_order = Myorder::instance ( $order ['id'] )->edit ( $order_data );
		if ($return_order == false) {
			$order_history_data ['result'] = 'failure';
			$this->add_order_history ( $order_history_data, $remark );
			return false;
		} else {
			$order_history_data ['result'] = 'success';
			$this->add_order_history ( $order_history_data, $remark );
			return true;
		}
	}
	
	/**
	 * 支付后台准备退款
	 * @param $data array 订单同步的数据
	 * @param $order array 订单信息
	 * @param $order_history_data 订单历史信息
	 * @param $remark 订单备注
	 * @return boolean
	 */
	public function bizark_payment_refunding(& $data, & $order, & $order_history_data, $remark) {
		$unavalidate_pay_status = array (1, 4, 5, 6, 7 );
		$order_history_data ['pay_status'] = 4;
		$order_history_data ['status_flag'] = 'pay_status';
		
		if (! in_array ( $order ['pay_status'], $unavalidate_pay_status )) {
			$remark .= 'refunding' . "\r\n";
			$order_data = array ();
			$order_data ['pay_status'] = 4;
			$order_data ['date_upd'] = date ( "Y-m-d H:i:s" );
			$order_data ['total_paid'] = abs ( $order ['total'] - $data ['refund_amount'] );
			$return_order = Myorder::instance ( $order ['id'] )->edit ( $order_data );
			
			if ($return_order == false) {
				$order_history_data ['result'] = 'failure';
				$this->add_order_history ( $order_history_data, $remark );
				return false;
			} else {
				$order_history_data ['result'] = 'success';
				$this->add_order_history ( $order_history_data, $remark );
				return true;
			}
		} else {
			$order_history_data ['result'] = 'failure';
			$this->add_order_history ( $order_history_data, $remark );
			return false;
		}
	}
	
	/**
	 * 支付后台退款同步
	 * @param $data array 订单同步的数据
	 * @param $order array 订单信息
	 * @param $order_history_data 订单历史信息
	 * @param $remark 订单备注
	 * @return boolean
	 */
	public function bizark_payment_refund(& $data, & $order, & $order_history_data, $remark) {
		$data ['payment_status_id'] = 6;
		if ($data ['payment_status_id'] == 5) {
			$remark .= 'Partly Refund';
		} elseif ($data ['payment_status_id'] == 6) {
			$remark .= 'Refund';
		} else {
			return false;
		}
		
		if ($order ['total_paid'] >= $data ['refund_amount']) {
			$unavalidate_pay_status = array (1, 6, 7 );
			if (! in_array ( $order ['pay_status'], $unavalidate_pay_status )) {
				$order_data ['pay_status'] = 3;
				$order_data ['date_upd'] = date ( "Y-m-d H:i:s" );
				$order_data ['total_paid'] = abs ( $order ['total_paid'] - $data ['refund_amount'] );

				$return_order = Myorder::instance ( $order ['id'] )->edit ( $order_data );
				
				$order_history_data ['pay_status'] = $data ['payment_status_id'];
				$order_history_data ['status_flag'] = 'pay_status';
				
				if ($return_order == false) {
					$order_history_data ['result'] = 'failure';
					$this->add_order_history ( $order_history_data, $remark );
					return false;
				} else {
					$order_history_data ['result'] = 'success';
					$this->add_order_history ( $order_history_data, $remark );
					
					/* 退款邮件 */
					$refund_struct = array ();
					$refund_struct ['order_num'] = $order ['order_num'];
					$refund_struct ['refund_amount'] = $data ['refund_amount'];
					mail::refund ( $refund_struct );
					
					//添加退款记录
					$order_refund_log_data = array ();
					$order_refund_log_data ['site_id'] = $order ['site_id'];
					$order_refund_log_data ['order_id'] = $order ['id'];
					$order_refund_log_data ['refund_amount'] = $data ['refund_amount'];
					$order_refund_log_data ['refund_method'] = 1;
					Myorder::instance ()->add_order_refund_log ( $order_refund_log_data );
					return true;
				}
			}
		} else {
			return false;
		}
	}
	
	/**
	 * 支付后台验证通过同步
	 * @param $data array 订单同步的数据
	 * @param $order array 订单信息
	 * @param $order_history_data 订单历史信息
	 * @param $remark 订单备注
	 * @return boolean
	 */
	public function bizark_payment_confirm(& $data, & $order, & $order_history_data, $remark) {
		/**
		 * 更新支付状态
		 */
		$order_data = array ();
		$unavalidate_pay_status = array (3, 4, 5, 6, 7 );
		
		if (! in_array ( $order ['pay_status'], $unavalidate_pay_status )) {
			$order_data ['pay_status'] = 3;
			if ($order ['total_paid'] <= 0) {
				$order_data ['total_paid'] = $order ['total'];
			}
			$order_data ['date_pay'] = date ( "Y-m-d H:i:s", time () );
			$order_data ['trans_id'] = $data['trans_id'];
			$order_data ['date_upd'] = date ( "Y-m-d H:i:s" );
			Myorder::instance ( $order ['id'] )->edit ( $order_data );
			
			$order_history_data ['pay_status'] = 3;
			$order_history_data ['status_flag'] = 'pay_status';
			$order_history_data ['result'] = 'success';
			$this->add_order_history ( $order_history_data, $remark );
		}
		
		/**
		 * 更新订单状态
		 */
		$order_data = array ();
		$unavalidate_order_status = array (2, 3, 4 );
		
		$order_history_data ['order_status'] = 2;
		$order_history_data ['status_flag'] = 'order_status';
		
		if (! in_array ( $order ['order_status'], $unavalidate_order_status )) {
			$order_data ['order_status'] = 2;
			$order_data ['date_upd'] = date ( "Y-m-d H:i:s" );
			$order_data ['date_verify'] = date ( "Y-m-d H:i:s", time () );
			
			$return_order = Myorder::instance ( $order ['id'] )->edit ( $order_data );
			if ($return_order) {
				$order_history_data ['result'] = 'success';
				$this->add_order_history ( $order_history_data, $remark );
				return true;
			} else {
				$order_history_data ['result'] = 'failure';
				$this->add_order_history ( $order_history_data, $remark );
				return false;
			}
		} else {
			$order_history_data ['result'] = 'failure';
			$this->add_order_history ( $order_history_data, $remark );
			return false;
		}
	}
}