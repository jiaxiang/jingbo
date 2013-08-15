<?php
class Card_Controller extends Template_Controller 
{
	private $userDao      = null;
	private $userMoneyDao = null;
	private $cardDao      = null;
	private $cardLogDao   = null;
	private $cardChargeLogDao   = null;
	
	public function __construct()
	{
		parent::__construct();
//        role::check('distribution_system_manage');
		$this->userDao      = user::get_instance();
		$this->userMoneyDao = user_money::get_instance();
		$this->cardDao      = MyCard_Core::instance();
		$this->cardLogDao   = MyCardLog_Core::instance();
		$this->cardChargeLogDao = MyCardChargeLog_Core::instance();
	}
	
	public function recharge() 
	{
		$user = $this->userDao->get($this->_user['id']);
		
		if ($_POST) 
		{
			$postData = $_POST;
			$postData['mgrnum']   = $_POST['mgrNum'];
			$postData['password'] = $_POST['passWord'];
			
			// Check the params
			$theCard = $this->cardDao->get_by_mgrnum($postData['mgrnum']);
			if ($theCard == null) {
//				remind::set('你输入的是无效卡号', 'error', request::referrer());
				remind::set(Kohana::lang('o_global.bad_request'), 'error', request::referrer());
				return;
			}
			if ($theCard['cardpass'] != $postData['password']) {
				remind::set('密码错误', 'error', request::referrer());
				return;
			}
			if ($theCard['flag'] != Ac_card_Model::FLAG_OPEN) {
				remind::set('你输入的是无效卡号,如一直出现此情况，请联系你的点卡提供商', 'error', request::referrer());
				return;
			}
			
			// update the user's balance
			$return = $this->userMoneyDao->add_money($user['id'], 
													$theCard['moneyrmb'], 
													array('USER_MONEY'=>$theCard['moneyrmb'],), 
													1, 
													$theCard['mgrnum'], 
													'用户点卡冲值');
			if ($return <= 0) {
				remind::set('充值失败,'.$return, 'error', request::referrer());
				return;
			}
			
			// update the card flag
			$updData = array();
			$updData['id'] = $theCard['id'];
			$updData['flag'] = Ac_card_Model::FLAG_USED;
			$updData['updtime'] = date('Y-m-d H:i:s', time());
			if(($this->cardDao->edit($updData)) == false)
			{
				remind::set(Kohana::lang('o_global.update_error'), 'error', request::referrer());
				return;
			}
			
			$aCardChargeLog = array();
			$aCardChargeLog['userid']      = $user['id'];
			$aCardChargeLog['cardnum']     = $theCard['mgrnum'];
			$aCardChargeLog['chargetime']  = date('Y-m-d H:i:s', time());
			$aCardChargeLog['user_money']  = $this->_user['user_money'];
			$aCardChargeLog['bonus_money'] = $this->_user['bonus_money'];
			$aCardChargeLog['free_money']  = $this->_user['free_money'];
			$this->cardChargeLogDao->add($aCardChargeLog);
			
			// add card log
			$aLog = array();
			$aLog['userid']   = $user['id'];
			$aLog['apdtime']  = date('Y-m-d H:i:s', time());
			$aLog['target']   = Ac_cardlog_Model::TARGET_CARD;
			$aLog['targetid'] = $theCard['id'];
			$aLog['action']   = Ac_cardlog_Model::ACTION_CHANGE;
			$aLog['detail']   = 'The card has been used: '.$theCard['id'];
			$this->cardLogDao->add($aLog);
			
			remind::set(Kohana::lang('o_global.add_success'),'success', 'card/recharge');
			return;
		}
		
		$data = array();
		//设置异常警告
		$remind_data = remind::get();
		if($remind_data){
			$data['remind_data'] = $remind_data;
		}
		
        $view = new View('user/card_recharge', $data);
		$view->set_global('_user', $this->_user);
		$view->set_global('_nav', 'card_recharge');
		$view->render(TRUE);
	}
	
}
?>