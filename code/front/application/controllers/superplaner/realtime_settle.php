<?php defined('SYSPATH') OR die('No direct access allowed.');
class Realtime_settle_Controller extends Template_Controller {
	/**
	 * 超级发单人即时结算过程
	 */
	public function auto_settle() {
		$obj = Superplaner_Realtime_contract::instance();
		$realtime_contract_data = $obj->get_all_data();
		$realtime_contract_data_count = count($realtime_contract_data);
		if ($realtime_contract_data_count > 0) {
			for ($i = 0; $i < $realtime_contract_data_count; $i++) {
				$userid = $realtime_contract_data[$i]['user_id'];
				$type = $realtime_contract_data[$i]['type'];
				$rate = $realtime_contract_data[$i]['rate'];
				$lasttime = $realtime_contract_data[$i]['starttime'];
				$rcid = $realtime_contract_data[$i]['id'];
				$plan_basic_obj = Plans_basicService::get_instance();
				$plan_basic_data = $plan_basic_obj->get_hemai_data($userid, $type, $lasttime);
				$total_money = 0;
				$basic_id_array = array();
				$plan_basic_info = array();
				$plan_basic_data_count = count($plan_basic_data);
				$plan_son_id = array();
				$plan_son_order_num = array();
				if ($plan_basic_data_count > 0) {
d($plan_basic_data, false);
					for ($j = 0; $j < $plan_basic_data_count; $j++) {
						$basic_id = $plan_basic_data[$j]['id'];
						$basic_id_array[] = $basic_id;
						$order_num = $plan_basic_data[$j]['order_num'];
						$ticket_type = $plan_basic_data[$j]['ticket_type'];
						$plan_money = 0;
						switch ($ticket_type) {
							case 1 :
								$plan_obj = Plans_jczqService::get_instance();
								$plan_data = $plan_obj->get_by_order_id($order_num);
								$plan_money = $plan_data['total_price'];
								$plan_id = $plan_data['id'];
								$plan_son_data = $plan_obj->get_son_by_pid($plan_id);
								foreach ($plan_son_data as $key => $val) {
									$plan_son_order_num[] = $val['basic_id'];
								}
								break;
							case 2 :
								$plan_obj = Plans_sfcService::get_instance();
								$plan_data = $plan_obj->get_by_basic_id($order_num);
								$plan_money = $plan_data['price'];
								$plan_id = $plan_data['id'];
								$plan_son_data = $plan_obj->get_son_by_pid($plan_id);
								foreach ($plan_son_data as $key => $val) {
									$plan_son_order_num[] = $val['basic_id'];
								}
								break;
							case 6 :
								$plan_obj = Plans_jclqService::get_instance();
								$plan_data = $plan_obj->get_by_order_id($order_num);
								$plan_money = $plan_data['total_price'];
								$plan_id = $plan_data['id'];
								$plan_son_data = $plan_obj->get_son_by_pid($plan_id);
								foreach ($plan_son_data as $key => $val) {
									$plan_son_order_num[] = $val['basic_id'];
								}
								break;
							case 7 :
								$plan_obj = Plans_bjdcService::get_instance();
								$plan_data = $plan_obj->get_by_order_id($order_num);
								$plan_money = $plan_data['total_price'];
								$plan_id = $plan_data['id'];
								$plan_son_data = $plan_obj->get_son_by_pid($plan_id);
								foreach ($plan_son_data as $key => $val) {
									$plan_son_order_num[] = $val['basic_id'];
								}
								break;
							case 8 :
								$plan_obj = Plans_lotty_orderService::get_instance();
								$plan_data = $plan_obj->get_by_basic_id($order_num);
								$plan_money = $plan_data['total_price'];
								$plan_id = $plan_data['id'];
								$plan_son_data = $plan_obj->get_son_by_pid($plan_id);
								foreach ($plan_son_data as $key => $val) {
									$plan_son_id[] = $val['pbid'];
								}
								break;
							default:break;
						}
						$total_money += $plan_money;
						$plan_basic_info[$j]['order_num'] = $order_num;
						$plan_basic_info[$j]['ticket_type'] = $ticket_type;
						$plan_basic_info[$j]['money'] = $plan_money;
					}
				}
				$after_money = $total_money * $rate;
d($after_money, false);
//d($plan_son_id, false);
//d($plan_son_order_num);
				if ($after_money > 0) {
					$moneys['BONUS_MONEY'] = $after_money;
					$lan = Kohana::config('lan');
					$moneyobj = user_money::get_instance();
					$order_num = date('YmdHis').rand(0, 99999);
					$flagret = $moneyobj->add_money($userid, $after_money, $moneys, 13, $order_num, $lan['money'][25]);
					if ($flagret < 0) {
						return false;
					}
					else {
						$settle_rpt_data = array(
							'rcid' => $rcid,
							'type' => $type,
							'settletime' => date('Y-m-d H:i:s'),
							//'agent_type' => 0,
							'user_id' => $userid,
							'flag' => 2,
							//'taxflag' => 2,
							'rate' => $rate,
							'fromamt' => $total_money,
							//'taxrate' => 0,
							//'bonusbeforetax' => $after_money,
							'bonus' => $after_money,
							'date_add' => date('Y-m-d H:i:s'),
						);
						$settlerealtimerptDao = Superplaner_settlerealtimerpt::instance();
						$settle_rpt_id = $settlerealtimerptDao->add($settle_rpt_data);
d($settle_rpt_id, false);
						if ($settle_rpt_id > 0) {
							$flag = 0;
							$plan_basic_info_count = count($plan_basic_info);
							if ($plan_basic_info_count > 0) {
d($plan_basic_info, false);
								for ($j = 0; $j < $plan_basic_info_count; $j++) {
									$settle_rpt_dtl_data = array(
										'masterid' => $settle_rpt_id,
										'order_num' => $plan_basic_info[$j]['order_num'],
										'settletime' => date('Y-m-d H:i:s'),
										'user_id' => $userid,
										'rcid' => $rcid,
										'agentid' => $userid,
										'ticket_type' => $plan_basic_info[$j]['ticket_type'],
										'flag' => 2,
										'rate' => $rate,
										'fromamt' => $plan_basic_info[$j]['money'],
									);
									$settlerealtimerptdtlDao = Superplaner_settlerealtimerptdtl::instance();						
									$settle_rpt_dtl_id = $settlerealtimerptdtlDao->add($settle_rpt_dtl_data);
d($settle_rpt_dtl_id, false);
									if ($settle_rpt_dtl_id > 0) {
										$flag ++;
									}
								}
							}
							if ($flag == count($plan_basic_info)) {
								//更新订单状态
								$plan_basic_obj->update_settle_status($basic_id_array);
								//更新子订单状态
								if (count($plan_son_id) > 0) {
									$plan_basic_obj->update_settle_status($plan_son_id);
								}
								if (count($plan_son_order_num) > 0) {
									$plan_basic_obj->update_settle_status_order_num($plan_son_order_num);
								}
							}
						}
					}
				}
			}
		}
		else {
			echo '0';
		}
	}
}
?>