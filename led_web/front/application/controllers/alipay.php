<?php
class Alipay_Controller extends Template_Controller {
	public function index() {
		$this->login();
	}
	
	public function login() {
		$userobj = user::get_instance();
		$is_login = $userobj->check_user_login();
		if ($is_login != false && $is_login > 0) {
			url::redirect('user/');
		}
		header('Content-Type: text/html; charset=UTF-8');
		$aliapy_config = Kohana::config('alipay_fastlogin_config');
	
		require_once(WEBROOT."application/libraries/alipayfastlogin/alipay_service.class.php");
	
		/**************************请求参数**************************/
	
		//选填参数//
	
		//防钓鱼时间戳
		$anti_phishing_key  = '';
		//获取客户端的IP地址，建议：编写获取客户端IP地址的程序
		$exter_invoke_ip = '';
		//注意：
		//1.请慎重选择是否开启防钓鱼功能
		//2.exter_invoke_ip、anti_phishing_key一旦被使用过，那么它们就会成为必填参数
		//3.开启防钓鱼功能后，服务器、本机电脑必须支持SSL，请配置好该环境。
		//示例：
		//$exter_invoke_ip = '202.1.1.1';
		//$ali_service_timestamp = new AlipayService($aliapy_config);
		//$anti_phishing_key = $ali_service_timestamp->query_timestamp();//获取防钓鱼时间戳函数
	
		/************************************************************/
	
		//构造要请求的参数数组
		$parameter = array(
				/* "service"			=> "alipay.auth.authorize",
					"target_service"	=> 'user.auth.quick.login',
	
		"partner"			=> trim($aliapy_config['partner']),
		"_input_charset"	=> trim(strtolower($aliapy_config['input_charset'])),
		"return_url"		=> trim($aliapy_config['return_url']), */
	
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip
		);
	
		//构造快捷登录接口
		$alipayService = new AlipayService($aliapy_config);
		$html_text = $alipayService->alipay_auth_authorize($parameter);
		echo $html_text;
	}
	
	public function return_url() {
		header('Content-Type: text/html; charset=UTF-8');
		$aliapy_config = Kohana::config('alipay_fastlogin_config');
		require_once(WEBROOT."application/libraries/alipayfastlogin/alipay_notify.class.php");
		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($aliapy_config);
		$verify_result = $alipayNotify->verifyReturn();
		if($verify_result) {//验证成功
			$userobj = user::get_instance();
			include WEBROOT.'config.inc.php';
			include WEBROOT.'uc_client/client.php';
			//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
			$alipay_user_id	= $_GET['user_id'];	//支付宝用户id
			$token		= $_GET['token'];	//授权令牌201205082ab1c6ac68694e89a8ddd21388636bfc
			$user_real_name = $_GET['real_name'];
			$username = 'Login_Alipay_'.$alipay_user_id;
			$uc_username = 'Login_Alipay_'.$alipay_user_id;
			$password = 'PassW0rd'.$alipay_user_id;
			$is_reg_user = $userobj->is_alipay_register($alipay_user_id);
			if ($is_reg_user == false) {
				$data = array();
				$data['email']      = '';
				$data['lastname']   = $username;
				$data['real_name']   = $user_real_name;
				$data['password']   = $password;
				$data['ip']         = Input::instance()->ip_address();         //tool::get_long_ip();
				$data['login_ip']   = $data['ip'];
				$data['login_time'] = date('Y-m-d H:i:s');
				$data['active']     = 1;
				$data['invite_user_id'] = 0;
				$data['from_domain'] = $_SERVER['HTTP_HOST'];
				$data['register_mail_active'] = 1;
				$data['alipay_id'] = $alipay_user_id;
				$user_id = $userobj->register($data);
				if ($user_id > 0) {
					$uid = uc_user_register($uc_username, $data['password'], $alipay_user_id.'@jingbo365.com');
					setcookie('yiwang_auth', '', -86400);
					if($uid > 0) {
						//注册成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
						setcookie('yiwang_auth', uc_authcode($uid."\t".$uc_username, 'ENCODE'));
						$ucsynlogin = uc_user_synlogin($uid);
						session_start();
						$_SESSION['ucsynlogin']= $ucsynlogin;
					}
					
					$user = $userobj->get($user_id);
					$userobj->login_process($user, $data['password']);
					url::redirect('user/');
				}
			}
			else {
				$user_id = $userobj->login($username, $password);
				if ($user_id > 0) {
					list($uid, $uc_username, $password, $email) = @uc_user_login($uc_username, $password);
					//$uid = 0;
					if (empty($uid))
					{
						$uid = 0;
					}
					setcookie('yiwang_auth', '', -86400);
					if($uid > 0) {
						//用户登陆成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
						setcookie('yiwang_auth', uc_authcode($uid."\t".$uc_username, 'ENCODE'));
						$ucsynlogin = uc_user_synlogin($uid);
						session_start();
						$_SESSION['ucsynlogin']= $ucsynlogin;
					}
					//Ucenter login end
					$user = $userobj->get($user_id);
					$userobj->login_process($user);
					url::redirect('user/');
				}
			}
			//etao专用
			if($_GET['target_url'] != "") {
				//程序自动跳转到target_url参数指定的url去
			}
		}
		else {
			//验证失败
			//如要调试，请看alipay_notify.php页面的verifyReturn函数，比对sign和mysign的值是否相等，或者检查$responseTxt有没有返回true
			echo "验证失败";
		}
	}
}
?>