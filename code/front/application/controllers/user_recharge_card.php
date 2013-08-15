<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_recharge_card_Controller extends Template_Controller {
	
	public function recharge() {
		$userobj = user::get_instance();
		$userobj->check_login();
		if(isset($_POST['card_pw']) && isset($this->_user['id']) && $this->_user['id'] > 0) {
			$money_card_obj = money_card::get_instance();
			$card_pw = $_POST['card_pw'];
			$r = $money_card_obj->recharge_by_card($this->_user['id'], $card_pw);
		}
		if (isset($r)) {
			if ($r == false) {
				$result = '充点失败，点卡已使用或已过期！';
			}
			else {
				$user_score = $userobj->get_user_score($this->_user['id']);
				//$user_money = $userobj->get_user_money($this->_user['id']);
				$result = '充点成功，可用点数：'.$user_score.'点，<a href="user_recharge_card/change">马上去兑换彩金</a>！';
			}
		}
		else {
			$result = null;
		}
		$view = new View('user/recharge_card');
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$view->set('site_config', $data['site_config']);
		$view->set_global('_user',$this->_user);
		$view->set_global('result',$result);
        $view->set_global('_nav', 'recharge_card');
        $view->render(TRUE);
	}
	
	public function change() {
		$userobj = user::get_instance();
		$userobj->check_login();
		$money_card_obj = money_card::get_instance();
		$data = array();
		$data['user_score'] = $this->_user['score'];
		$data['change_money'] = $money_card_obj->score_change_money($this->_user['score']);
		if(isset($_POST['change_score']) && isset($this->_user['id']) && $this->_user['id'] > 0) {
			$change_score = $_POST['change_score'];
			$r = $money_card_obj->change_score($this->_user['id'], $change_score);
		}
		if (isset($r)) {
			$user_score = $userobj->get_user_score($this->_user['id']);
			$user_money = $userobj->get_user_money($this->_user['id']);
			$result_user_change = $money_card_obj->score_change_money($user_score);
			if ($r == false) {
				$result_msg = '请输入正确的点数！';
			}
			else {
				$result_msg = '彩金兑换成功，余额：￥'.$user_money.'，可用点数：'.$user_score.'点！';
			}
			$result = array('msg'=>$result_msg,'user_score'=>$user_score,'user_change'=>$result_user_change);
		}
		else {
			$result = null;
		}
		$data['result'] = $result;
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
		$view = new View('user/recharge_card_change', $data);
		$view->set_global('_user',$this->_user);
		//$view->set_global('result',$result);
        $view->set_global('_nav', 'recharge_card_change');
        $view->render(TRUE);
	}
	
	public function search() {
		$userobj = user::get_instance();
		$userobj->check_login();
		if(isset($_POST['card_id']) && isset($this->_user['id']) && $this->_user['id'] > 0) {
			$money_card_obj = money_card::get_instance();
			$card_id = $_POST['card_id'];
			$r = $money_card_obj->get_card_by_no($card_id);
		}
		if (isset($r)) {
			if ($r == false) {
				$result = '该卡号不存在！';
			}
			else {
				$result['card_id'] = $r['card_id'];
				$result['status'] = $money_card_obj->show_card_status($r['status']);
				$result['value'] = $r['value'];
				$result['expire'] = $r['expire'];
			}
		}
		else {
			$result = null;
		}
		$view = new View('user/recharge_card_search');
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$view->set('site_config', $data['site_config']);
		$view->set_global('_user',$this->_user);
		$view->set_global('result',$result);
        $view->set_global('_nav', 'recharge_card_search');
        $view->render(TRUE);
	}
}
?>