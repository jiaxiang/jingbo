<?php defined('SYSPATH') or die('No direct script access.');

	class money_card_Core {
		const M = 2;//彩金比点数
		private static $instance = NULL;
		public static function get_instance(){
	        if(self::$instance === null){
	            $classname = __CLASS__;
	            self::$instance = new $classname();
	        }
	        return self::$instance;
	    }
	    
	    /**
	     * 点卡充值
	     * Enter description here ...
	     * @param unknown_type $userid
	     * @param unknown_type $card_pw
	     */
		public function recharge_by_card($userid, $card_pw) {
			$is_use = $this->is_use_card($card_pw);
			if ($is_use == false) {
				return false;
			}
			else {
				$this->update_card($is_use['id']);
				$value = $is_use['value'];
				$userobj = user::get_instance();
				$score = $userobj->get_user_score($userid);
				$total_score = $score + $value;
				$userobj->update_user_score($userid, $total_score);
				/*
				$order_num = date('YmdHis').rand(0, 99999);
        		$moneys['USER_MONEY'] = $value;
        		$moneyobj = user_money::get_instance();
        		$moneyobj->add_money($userid, $value, $moneys, 1, $order_num, $lan['money'][24].'密码:'.$card_pw);
        		$userobj = user::get_instance();
        		$charge_order_num = $userobj->get_user_charge_order($userid, $value, '充值卡');
        		$userobj->charge_update($charge_order_num, 1, $card_pw);
        		*/
        		return true;
			}
		}
		
		/**
		 * 检查卡是否可用
		 * Enter description here ...
		 * @param unknown_type $card_pw
		 */
		public function is_use_card($card_pw) {
			$obj = ORM::factory('money_card');
			$obj->where('card_pw', $card_pw);
			$obj->where('status', 0);
			$obj->where('expire >=', date('Y-m-d'));
			$results = $obj->find(); 
			if($results->loaded){
				$return = $results->as_array();
			}
			else{
				$return = false;
			}
			return $return;
		}
		
		/**
		 * 根据卡号获取点卡信息
		 * Enter description here ...
		 * @param unknown_type $card_no
		 */
		public function get_card_by_no($card_no) {
			$obj = ORM::factory('money_card');
			$obj->where('card_id', $card_no);
			$results = $obj->find(); 
			if($results->loaded){
				$return = $results->as_array();
			}
			else{
				$return = false;
			}
			return $return;
		}
		
		/**
		 * 更新点卡状态
		 * Enter description here ...
		 * @param unknown_type $id
		 */
		public function update_card($id) {
			$query = 'update money_cards set status=1 where id="'.$id.'"';
			$db = Database::instance();
			$results = $db->query($query);
		}
		
		/**
		 * 点数兑换成彩金
		 * Enter description here ...
		 * @param unknown_type $userid
		 * @param unknown_type $score
		 */
		public function change_score($userid, $score) {
			$userobj = user::get_instance();
			$user_score = $userobj->get_user_score($userid);
			$score = intval($score);
			if ($score < 100 || $score > 1000 || $user_score < $score) {
				return false;
			}
			$change_money = $this->score_change_money($score);
			$remain_score = $user_score - ($change_money * self::M);
			$userobj = user::get_instance();
			$userobj->update_user_score($userid, $remain_score);
			$lan = Kohana::config('lan');
			$order_num = date('YmdHis').rand(0, 99999);
        	$moneys['USER_MONEY'] = $change_money;
        	$moneyobj = user_money::get_instance();
        	$moneyobj->add_money($userid, $change_money, $moneys, 1, $order_num, $lan['money'][24]);
        	$charge_order_num = $userobj->get_user_charge_order($userid, $change_money, '点数充值');
        	$userobj->charge_update($charge_order_num, 1, $score);
        	return true;
		}
		
		/**
		 * 点数兑换成彩金
		 * Enter description here ...
		 * @param unknown_type $score
		 */
		public function score_change_money($score) {
			$change_money = floor($score / self::M);
			return $change_money;
		}
		
		/**
		 * 显示状态
		 * Enter description here ...
		 * @param unknown_type $status
		 */
		public function show_card_status($status) {
			$r = '';
			switch($status) {
				case 0: $r = '未使用';break;
				case 1: $r = '已使用';break;
				default: $r = '未知';break;
			}
			return $r;
		}
	}
?>