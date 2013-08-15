<?php defined('SYSPATH') OR die('No direct access allowed.');

$front_path =  WEBROOT;
include $front_path.'config.inc.php';
include $front_path.'include/db_mysql.class.php';
$db = new dbstuff;
$db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
include $front_path.'uc_client/client.php';

class User_Controller extends Template_Controller {

    /**
    * 用户中心首页
    */
	public function index()
	{	    
		$a = urldecode($_COOKIE['a']);
		$page_type="index";
		//$get_data['start_time']=date("Y-m-d")." 00:00:00";//开始时间			
	 	//$get_data['end_time']=date("Y-m-d")." 23:59:59";//结束时间
	 	$get_data['type'] = "notend";
		$this->plan_list($page_type, $get_data ,$a);
    }
	
	public function winning()
	{
		$page_type="index";
		$get_data['type']="bonus";//中奖
		$this->plan_list($page_type, $get_data);	
    } 	
	     
	/**
	 * 注册会员
	 */
	public function register($invitecode)
	{
//		$user = Session::instance()->get('user');
		$error = NULL;
        if(isset($user['email']))
        {
            remind::set('您已经登录到系统了', 'success', url::base().'user/');
        }	    
		
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );        
        
    	$data['site_config'] = Kohana::config('site_config.site');
    	$host = $_SERVER['HTTP_HOST'];
    	$dis_site_config = Kohana::config('distribution_site_config');
    	if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
    		$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
    		$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
    		$data['site_config']['description'] = $dis_site_config[$host]['description'];
    	}
    	
	    if($_POST)
	    {
	        try {	    
	        	$reg_enable = false;
	        	$reg_last_time = Session::instance()->get('reg_last_time');
	        	//d(time() - $reg_last_time);
	        	if ($reg_last_time == false) {
	        		$reg_enable = true;
	        	}
	        	else {
	        		if (time() - $reg_last_time >= 3600) {
	        			$reg_enable = true;
	        		}
	        	}
	        	
	        	/* if ($reg_enable == false) {
	        		remind::set('您注册过于频繁，请休息一会！', 'error', request::referrer());
	        		return;
	        	} */
	        	
                Session::instance()->set('user_reg', $_POST);
                $invite_user_id = (int)Session::instance()->get('invite_user_id');
            	tool::filter_strip_tags($_POST);
                $redirect = $this->input->get('redirect', request::referrer());
                $secoder = $this->input->post('secode');
                $request_data = $this->input->post();
                $return_data = array();    
                
				include_once WEBROOT.'application/libraries/recaptchalib.php';
	        	$privatekey = "6Lfq09sSAAAAAOOOotM4q8VqyNO0wFCORg9MfoGn";
				$resp = recaptcha_check_answer ($privatekey,
				                              $_SERVER["REMOTE_ADDR"],
				                              $_POST["recaptcha_challenge_field"],
				                              $_POST["recaptcha_response_field"]);
				
				if (!$resp->is_valid) {
				  // What happens when the CAPTCHA was entered incorrectly
				  //die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
				  //     "(reCAPTCHA said: " . $resp->error . ")");
					remind::set('验证码错误，请重新输入！', 'error', request::referrer());
					return;
				} else {
					//die('ke');
    				$refuse_ipaddr = Kohana::config('site_config.refuse_ipaddr');
    			    $userobj = user::get_instance();
                    $data = array();
                    $data['email']      = $this->input->post('email');
                    $data['lastname']   = $this->input->post('lastname');
                    $data['password']   = $this->input->post('password');
                    $data['ip']         = Input::instance()->ip_address();
                    if (in_array($data['ip'], $refuse_ipaddr)) {
                    	remind::set('注册出错！', 'error', request::referrer());
	        			return;
                    }
                    //d($data['ip']);
                    $ip_arr = explode('.', $data['ip']);
                    array_pop($ip_arr);
                    $network_24 = implode('.', $ip_arr).'.';
                    //d($network_24);
                    $refuse_network24 = Kohana::config('site_config.refuse_network_24');
                    if (in_array($network_24, $refuse_network24)) {
                    	remind::set('网络注册出错！', 'error', request::referrer());
                    	return;
                    }
                    $data['login_ip']   = $data['ip'];
                    $data['login_time'] = date('Y-m-d H:i:s');
                    $data['active']     = 0;
                    $data['invite_user_id'] = $invite_user_id;
                    $data['from_domain'] = $_SERVER['HTTP_HOST'];
    				//d($data);
    			    if ($userobj->is_register($data['lastname'], 1))
                    {
                        $error = '用户名已被注册';
                    }
                    //验证该注册邮箱是否被注册过
                    elseif ($userobj->is_register($data['email']))
                    {
                        $error = '邮箱已被注册';
                    }
                    else
                    {
                    	//$data['email'] = 'asdsaa@gmail.com';
                    	if ($userobj->email_available($data['email']) == false) {
                    		remind::set('邮箱不存在！', 'error', request::referrer());
                    		return;
                    	}
                    	
                        //默认为激活,且发送注册邮件
                        $site_register_mail_active = 1;
        	            $data['register_mail_active'] = 1;
						
        	            //储存用户信息
                        if($user_id = $userobj->register($data))
                        {	
                        	Session::instance()->set('reg_last_time', time());
							//发送邮件验证地址
							$userobj = user::get_instance();
							$rand_num = rand(100000,999999);
							$data['email']      = $this->input->post('email');
							$data['lastname']   = $this->input->post('lastname');
							$data['password']   = $this->input->post('password');
							
							//$key = Mytool::hash($user_id.Mytool::hash($data['password']));
							$mail_check_pwd = Kohana::config('site_config.site.register_mail_check_pwd');
							$key = Mytool::hash(Mytool::hash($data['password']).$mail_check_pwd);
							$userobj->check_register($user_id,$data['email'], $data['lastname'], $key);
						
                            Session::instance()->delete('user_reg');
                            if ($invite_user_id>0)
                            {
                                Session::instance()->delete('invite_user_id');
                                cookie::delete('invite_user_id');
                            }
    						
							//register start
							$uid = uc_user_register($data['lastname'], $data['password'], $data['email']);
							if($uid <= 0) {
								if($uid == -1) {
								}
							} else {
								$username  = $this->input->post('lastname');
								$password  = $this->input->post('password');
								$email  = $this->input->post('email');
							}
							if($username) {
								//注册成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
								setcookie('yiwang_auth', uc_authcode($uid."\t".$username, 'ENCODE'));
								$ucsynlogin = uc_user_synlogin($uid);
							}
							
							//add to ag_relations
                        	if (empty($invitecode)){
                        		$invitecode = $this->input->post('invitecode');
                        	}
                        	if (empty($invitecode)){
                        		$invitecode = $this->getfirsthoststr();
                        	}
							if (!empty($invitecode) && !empty($user_id)){
	                        	$retxx = $userobj->invitecodeinput($invitecode, $user_id);
							}
							//d($retxx,false);
//							if ($retxx == 0){
//								$notice='操作成功！';
//							}else if($retxx == 1){
//								$notice='操作失败:'.'该邀请码无效';
//							}else if($retxx == 2){
//								$notice='操作失败';
//							}else if($retxx == 3){
//								$notice='已经成功。';
//							}else if($retxx == 5){
//								$notice='操作失败。[5]';
//							}else if($retxx == 9){
//								$notice='暂时不能更换邀请码，请联系管理员。[9]';
//							}
							//register end
							
                        	$user = $userobj->get($user_id);
                            $userobj->login_process_register($user, $data['password']);
                            
                            $data['site_config'] = Kohana::config('site_config.site');
                            $host = $_SERVER['HTTP_HOST'];
                            $dis_site_config = Kohana::config('distribution_site_config');
                            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
                            	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
                            	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
                            	$data['site_config']['description'] = $dis_site_config[$host]['description'];
                            }
    	                    //显示注册成功页面
    	                    $view = new View('user/reg_email');
    	                    $view->set('site_config', $data['site_config']);
							$view->set('ucsynloginaaa',$ucsynlogin);
    	                    $view->set('username', $user['lastname']);
							$view->set('email',$data['email']);
    	                    $view->render(TRUE);
    	                    exit;
                        }
                        else
                        {
                            $error = '注册时发生了一个错误!';
                        }
                    }
                }
                
    			//验证验证码
                /* secoder_cn::$seKey = 'front.secodercn.reg_secoder';
    			if(secoder_cn::check($secoder) == false) {
    				remind::set('验证码出错！', 'error', request::referrer());
    				return;
    			}
    			else  */
                
                //* 补充&修改返回结构体 */
                $return_struct['status'] = 1;
                $return_struct['code']   = 200;
                $return_struct['msg']    = '';
                $return_struct['content']= $return_data;                
	        }
	        catch(MyRuntimeException $ex)
	        {
                $this->_ex($ex, $return_struct, $request_data);
            }                
	    }
	    
	    //设置异常警告
	    $remind_data = remind::get();
	    if($remind_data){
	    	$data['remind_data'] = $remind_data;
	    }
	    
	    $view = new View('user/register');
	    $view->set('site_config', $data['site_config']);
	    $view->set('remind_data', $data['remind_data']);
	    $view->set('error', $error);
	    $view->set('post', $_POST);
	    $view->set('invitecode', $invitecode);
      	$view->render(TRUE);
    }
    
    public function register_action() {
    	
    }
    /**
	 * 注册会员
	 */
	public function reg($invitecode)
	{
//		$user = Session::instance()->get('user');
		$error = NULL;
		
        if(isset($user['email']))
        {
            remind::set('您已经登录到系统了', 'success', url::base().'user/');
        }	    

    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );        
        
    	$data['site_config'] = Kohana::config('site_config.site');
    	$host = $_SERVER['HTTP_HOST'];
    	$dis_site_config = Kohana::config('distribution_site_config');
    	if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
    		$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
    		$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
    		$data['site_config']['description'] = $dis_site_config[$host]['description'];
    	}
    	
	    if($_POST)
	    {
//	    	d($invitecode,false);
	        try {	    
                Session::instance()->set('user_reg', $_POST);
                $invite_user_id = (int)Session::instance()->get('invite_user_id');
            	tool::filter_strip_tags($_POST);
                $redirect = $this->input->get('redirect', request::referrer());
                $secoder = $this->input->post('secode');
                $request_data = $this->input->post();
                $return_data = array();    
    			//验证验证码
                secoder::$seKey = 'front.secoder.reg_secoder';
				
    			if(secoder::check($secoder) != $secoder)
    			{
    				 $error = '验证码错误';
					 $view = new View('user/register');
					 $view->set('error', $error);
					 $view->set('post', $_POST);
					 $view->render(TRUE);
					 header("Location: /user/register");
					 exit;
    			}
    			else
    			{	
    			    $userobj = user::get_instance();
                    $data = array();
                    $data['email']      = $this->input->post('email');
                    $data['lastname']   = $this->input->post('lastname');
                    $data['password']   = $this->input->post('password');
                    //$data['invitecode']   = $this->input->post('invitecode');
                    $data['ip']         = Input::instance()->ip_address();         //tool::get_long_ip();
                    $data['login_ip']   = $data['ip'];
                    $data['login_time'] = date('Y-m-d H:i:s');
                    $data['active']     = 0;
                    $data['invite_user_id'] = $invite_user_id;
    
    			    if ($userobj->is_register($data['lastname'], 1))
                    {
                        $error = '用户名已被注册';
                    }
                    //验证该注册邮箱是否被注册过
                    elseif ($userobj->is_register($data['email']))
                    {
                        $error = '邮箱已被注册';
                    }
                    else
                    {
                        //默认为激活,且发送注册邮件
                        $site_register_mail_active = 1;
        	            $data['register_mail_active'] = 1;
						
        	            //储存用户信息
                        if($user_id = $userobj->register($data))
                        {	
						
							//发送邮件验证地址
							$userobj = user::get_instance();
							$rand_num = rand(100000,999999);
							$data['email']      = $this->input->post('email');
							$data['lastname']   = $this->input->post('lastname');
							$data['password']   = $this->input->post('password');
							
							//$key = Mytool::hash($user_id.Mytool::hash($data['password']));
							$mail_check_pwd = Kohana::config('site_config.site.register_mail_check_pwd');
							$key = Mytool::hash(Mytool::hash($data['password']).$mail_check_pwd);
							$userobj->check_register($user_id,$data['email'], $data['lastname'], $key);
						
                            Session::instance()->delete('user_reg');
                            if ($invite_user_id>0)
                            {
                                Session::instance()->delete('invite_user_id');
                                cookie::delete('invite_user_id');
                            }
    						
							//register start
							$uid = uc_user_register($data['lastname'], $data['password'], $data['email']);
							if($uid <= 0) {
								if($uid == -1) {
								/*	echo '用户名不合法';
								} elseif($uid == -2) {
									echo '包含要允许注册的词语';
								} elseif($uid == -3) {
									echo '用户名已经存在';
								} elseif($uid == -4) {
									echo 'Email 格式有误';
								} elseif($uid == -5) {
									echo 'Email 不允许注册';
								} elseif($uid == -6) {
									echo '该 Email 已经被注册';
								} else {
									echo '未定义';*/
								}
							} else {
								$username  = $this->input->post('lastname');
								$password  = $this->input->post('password');
								$email  = $this->input->post('email');
							}
							if($username) {
								//注册成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
								setcookie('yiwang_auth', uc_authcode($uid."\t".$username, 'ENCODE'));
								$ucsynlogin = uc_user_synlogin($uid);
							}
                        	//add to ag_relations
                        	if (empty($invitecode)){
                        		$invitecode = $this->input->post('invitecode');
                        	}
                        	if (empty($invitecode)){
                        		$invitecode = $this->getfirsthoststr();
                        	}
//                        d($invitecode,false);
							if (!empty($invitecode) && !empty($user_id)){
//                        d('xxx',false);
	                        	$retxx = $userobj->invitecodeinput($invitecode, $user_id);
							}
							//d($retxx,false);
//							if ($retxx == 0){
//								$notice='操作成功！';
//							}else if($retxx == 1){
//								$notice='操作失败:'.'该邀请码无效';
//							}else if($retxx == 2){
//								$notice='操作失败';
//							}else if($retxx == 3){
//								$notice='已经成功。';
//							}else if($retxx == 5){
//								$notice='操作失败。[5]';
//							}else if($retxx == 9){
//								$notice='暂时不能更换邀请码，请联系管理员。[9]';
//							}
							
							//register end
							
                        	$user = $userobj->get($user_id);
                            $userobj->login_process_register($user, $data['password']);
                            
    	                    //显示注册成功页面
    	                    $view = new View('user/reg_email');
							$view->set('ucsynloginaaa',$ucsynlogin);
    	                    $view->set('username', $user['lastname']);
							$view->set('email',$data['email']);
    	                    $view->render(TRUE);
    	                    exit;
                        }
                        else
                        {
                            $error = '注册时发生了一个错误!';
                        }
                    }
                }
                
                //* 补充&修改返回结构体 */
                $return_struct['status'] = 1;
                $return_struct['code']   = 200;
                $return_struct['msg']    = '';
                $return_struct['content']= $return_data;                
	        }
	        catch(MyRuntimeException $ex)
	        {
                $this->_ex($ex, $return_struct, $request_data);
            }                
	    }
	    $view = new View('user/register2');
	    $view->set('site_config', $data['site_config']);
	    $view->set('error', $error);
	    $view->set('post', $_POST);
	    $view->set('invitecode', $invitecode);
        $view->render(TRUE);
    }
	
	public function reg_success()
	{
		$data['site_config'] = Kohana::config('site_config.site');
		$user = user::get_instance();
		$key = $this->input->get('key');
		$user_id = $this->input->get('id');
		$userinfo = $user->get($user_id);
        
		$mail_check_pwd = Kohana::config('site_config.site.register_mail_check_pwd');
		
		//if (Mytool::hash($user_id.$userinfo['password']) == $key)
		if (Mytool::hash($userinfo['password'].$mail_check_pwd) == $key)
		{
    		$uid = $this->input->get('id');
    		$username = $this->input->get('u'); 
    		$username = urldecode($username);  
    		if ($userinfo['level_id'] > 0) {
    			$user->update_user($uid,array('active'=>1));
    			if ($userinfo['virtual_money'] == 0) {
    				$user->update_virtual_money($uid, 10000);
    			}
    		}
    		
    		/* $uid = uc_user_register($userinfo['lastname'], $userinfo['password'], $userinfo['email']);
    		if($uid <= 0) {
    		
    		} else {
    			$username  = $userinfo['lastname'];
    			$password  = $userinfo['password'];
    			$email  = $userinfo['email'];
    		}
    		if($username) {
    			//注册成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
    			setcookie('yiwang_auth', uc_authcode($uid."\t".$username, 'ENCODE'));
    			$ucsynlogin = uc_user_synlogin($uid);
    		} */
    		
    		$view = new View('user/reg_success', $data);
    		$view->set_global('_username',$username);
    		$view->render(TRUE);
		}
		else
		{
		    url::redirect('/error404');
		}
	}
        
    /*
     * 登录
     */
    public function login() 
    {
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

        $data = array('code' => -1);
        $ajax = $this->input->get('ajax',0);
        $request_data = $this->input->post();
		$user = Session::instance()->get('user');
		
		$datainfo['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$datainfo['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$datainfo['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$datainfo['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
		$return_data = array();
		$login_error = NULL;
      
        if(isset($user['email'])){
            remind::set('您已经登录到系统了', 'success', url::base().'/user/');
        }

        if($_POST){
		    try {
				
                $email = $this->input->post('username');
                $password = $this->input->post('password');
                $secode = $this->input->post('secode');
				$secode_time = $this->input->post('secode_time');
                $redirect = 'user/';
                if(!empty($secode_time)){
                    secoder::$seKey = 'front.secoder.login_secoder?_='.$secode_time;
				}
				else{
				     secoder::$seKey = 'front.secoder.login_secoder';
				}
				$check = secoder::check($secode);
			
                $userobj = user::get_instance();
                //验证验证码
    			if(empty($password) || empty($email) || $check!=$secode)
    			{
                    if ($ajax == 1)
                    {
                        if ($check!=$secode)
                        {
                            exit("<script type=\"text/javascript\">try{parent.acceptLoginMsg('验证码错误');}catch(e) {document.domain = location.host.split('.').slice(-2).join('.');parent.acceptLoginMsg('验证码错误');};</script>");
                        }
                        else 
                        {
                            exit("<script type=\"text/javascript\">try{parent.acceptLoginMsg('录入信息错误');}catch(e) {document.domain = location.host.split('.').slice(-2).join('.');parent.acceptLoginMsg('录入信息错误');};</script>");
                        }
                    }
                    else
                    {
                        if($check!=$secode)
                        {
							$this->template = new View('user/login', $datainfo);
							$this->template->ok = '验证码有误';
							$this->template->render(TRUE);
							exit;
                        }
                        else
                        {	
							$this->template = new View('user/login', $datainfo);
							$this->template->ok = '录入信息错误';
							$this->template->render(TRUE);
							exit;
                            //remind::set('录入信息错误', 'error', route::action('login'));
                        }
                    }
                }
				elseif($user_id = $userobj->login_un_active($email, $password))
				{
					$data['notice'] = '您的账户还没有激活，请进入注册邮箱激活帐号!';
					$this->template = new View('user/login', $data);
					$this->template->render(TRUE);
					exit;
				}
				
                elseif($user_id = $userobj->login($email, $password))
                {
				
					//Ucenter login start
					$username = $this->input->post('username');
					$password = $this->input->post('password');		

				    list($uid, $username, $password, $email) = @uc_user_login($username, $password);
					//$uid = 0;
					
				    if (empty($uid))
				    {
				        $uid = 0;
				    }
				    
					setcookie('yiwang_auth', '', -86400);
					if($uid > 0) {
						//用户登陆成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
						setcookie('yiwang_auth', uc_authcode($uid."\t".$username, 'ENCODE'));
						$ucsynlogin = uc_user_synlogin($uid);
						
						session_start();
						$_SESSION['ucsynlogin']= $ucsynlogin;
						//d($uid);
						/*$ucsynlogin = urlencode ( $ucsynlogin );
						setcookie('a',$ucsynlogin);*/
					}
					//Ucenter login end
					
                    $user = $userobj->get($user_id);
                    $userobj->login_process($user);
                    
                    if ($ajax == 1)
                    {
                        exit("<script type=\"text/javascript\">try{parent.acceptLoginMsg(0);}catch(e) {document.domain = location.host.split('.').slice(-2).join('.');parent.acceptLoginMsg(0);};</script>");
                    
                    }
                    else
                    {
						url::redirect('/user/');
                        
                    }
                }
                else
                {
                    if($ajax == 1)
                    {
                        exit("<script type=\"text/javascript\">try{parent.acceptLoginMsg('用户名或密码错误');}catch(e) {document.domain = location.host.split('.').slice(-2).join('.');parent.acceptLoginMsg('用户名或密码错误');};</script>"); 
                    }
                    else
                    {
                        if ($redirect)
                        {	
							$this->template = new View('user/login', $datainfo);
							$this->template->ok = '用户名或密码有误';
							$this->template->render(TRUE);
							exit;
                           // remind::set('登录失败', 'error', route::action('login').'?redirect=' . $redirect);
                        }
                        else
                        {	$this->template = new View('user/login', $datainfo);
							$this->template->ok = '用户名或密码有误';
							$this->template->render(TRUE);
							exit;
                            //remind::set('登录失败', 'error', route::action('login'));
                        }
                    }
                    $login_error = '登录失败';
                }                
							
                //*补充&修改返回结构体 */
                $return_struct['status'] = 1;
                $return_struct['code']   = 200;
                $return_struct['msg']    = '';
                $return_struct['content']= $return_data;
				
            }
            catch(MyRuntimeException $ex)
            {
                $this->_ex($ex, $return_struct, $request_data);
            }
        }
        $this->template = new View('user/login', $datainfo);
		$this->template->ok = '';
		$this->template->render(TRUE);
    }
    
    
    
	/**
	 * 编辑用户个人信息
	 */
	public function profile() {
		$userobj = user::get_instance();
		$userobj->check_login();
		$ok=1;
		if($_POST){
			if (empty($_POST['birthday']))
			{
			    unset($_POST['birthday']);
			}
			
			if (!empty($_POST['error_email']))
			{
			    unset($_POST['error_email']);
			}
		
			if(!$userobj->validator_email($_POST['email'])){
			   	$error['email'] = 1;
			}
			if(count($error)==0)
			{
				if ($userobj->edit($this->_user['id'], $this->input->post()))
				{
					$ok=2;
				}
			}
		}
		
		$view = new View('user/profile');
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$view->set('site_config', $data['site_config']);
		
		$userinfo = $userobj->get($this->_user['id']);
		$view->set_global('userinfo', $userinfo);
		$view->set_global('_user',$this->_user);
		$view->set_global('_ok',$ok);
		$view->set_global('error',$error);
        $view->set_global('_nav', 'profile');
        $view->render(TRUE);
		
	}

	/**
	 * 实名信息认证
	 */
	public function user_auth() {
		$userobj = user::get_instance();
		$userobj->check_login();
		$userinfo = $userobj->get($this->_user['id']);
		//$ok = 1;
		$error = false;
		if($_POST){
			require_once WEBROOT.'application/libraries/smt_gongan_validator/alipay_config.php';
			require_once WEBROOT.'application/libraries/smt_gongan_validator/class/alipay_service.php';
			///////////////////////请求参数///////////////////
			$query = 0;
			if ($userinfo['auth_order_no'] != null && $userinfo['is_auth'] == 1) {
				if ($userinfo['real_name'] != $_POST['real_name'] || $userinfo['identity_card'] != $_POST['identity_card']) {
					$query = 0;
				}
				else {
					$query = 1;
				}
			}
			
			$service_array = array('smt_gongan_verifyid_validator', 'smt_gongan_verifyid_query');
			//认证流水号，保证其唯一性
			if ($query == 1) {
				$partner_serial_no = $userinfo['auth_order_no'];
			}
			else {
				$partner_serial_no = date('YmdHis').rand(0, 9999).$userinfo['id'];
			}
			
			//身份证号码
			$cert_no		= $_POST['identity_card'];
			
			//身份证上的姓名
			$cert_name		= $_POST['real_name'];
			
			/////////////////////////////////////////////////
			//构造要请求的参数数组
			$parameter = array(
					//接口名称，不需要修改
			        "service"			=> $service_array[$query],
			
			        //获取配置文件(alipay_config.php)中的值
			        "partner"			=> $partner,
			        "_input_charset"	=> $_input_charset,
			
			        //请求参数
			        "partner_serial_no"	=> $partner_serial_no,
			        "cert_no"			=> $cert_no,
					"cert_name"			=> $cert_name
			);
			
			//构造请求函数
			$alipay = new alipay_service($parameter,$key,$sign_type);
			
			//无XML远程解析
			//$sHtmlText = $alipay->build_form();
			//echo $sHtmlText;
			
			//含XML远程解析
			//注意：
			//1、配置环境须支持DOMDocument，一般PHP5的配置环境支持
			//2、配置环境须支持须支持SSL
			$url = $alipay->create_url();
			//var_dump($url);
			$doc = new DOMDocument();
			$r = $doc->load($url);
			if ($r == false) {
				$error = '认证失败，请稍候再试';
			}
			else {
				$is_success = $doc->getElementsByTagName( "is_success" )->item(0)->nodeValue;
				$nodeError = "";
				$nodeIs_success = "";
				$nodeError_code = "";
				$nodeError_message = "";
				if ($is_success == 'T'){
					//是否认证成功，T-成功；F-失败
					$nodeIs_success = $doc->getElementsByTagName( "is_success" )->item(1)->nodeValue;
					
					if ($nodeIs_success == 'F') {
						//失败错误码
						$nodeError_code = $doc->getElementsByTagName( "error_code" )->item(0)->nodeValue;
						//错误描述
						$nodeError_message = $doc->getElementsByTagName( "error_message" )->item(0)->nodeValue;
						$error = $nodeError_message;
					}
					else {
						if ($query == 1) {
							$nodeStatus = $doc->getElementsByTagName( "status" )->item(0)->nodeValue;
							if ($nodeStatus == 'GONGAN_VERIFY_SUCCESS') {
								$error = 'ok';
							}
							else {
								$error = $nodeStatus;
							}
						}
						else {
							$error = 'ok';
						}
					}
				}
				else{
					//获取错误代码 error
					$nodeError = $doc->getElementsByTagName( "error" )->item(0)->nodeValue;
					$error = $nodeError;
				}
			}
			$cert_realname = $doc->getElementsByTagName( "cert_name" )->item(0)->nodeValue;
			$cert_idno = $doc->getElementsByTagName( "cert_no" )->item(0)->nodeValue;
			if ($error == 'ok') {
				$error = '身份验证成功！';
				$auth = 2;
			}
			else {
				$auth = 1;
			}
			$data = array();
			$data['real_name'] = $cert_realname;
			$data['identity_card'] = $cert_idno;
			$userobj->update_user_auth($userinfo['id'], $partner_serial_no, $data, $auth);
			$userinfo['real_name'] = $cert_realname;
			$userinfo['identity_card'] = $cert_idno;
			$userinfo['is_auth'] = $auth;
		}
		$view = new View('user/user_auth');
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$view->set('site_config', $data['site_config']);
		
		$view->set_global('userinfo', $userinfo);
		$view->set_global('_user',$this->_user);
		//$view->set_global('_ok',$ok);
		$view->set_global('error',$error);
        $view->set_global('_nav', 'user_auth');
        $view->render(TRUE);
	}
	
	/**
	 * 检查用户旧密码
	 */
	public function password_old(){
		$userobj = user::get_instance();
		$userobj->check_login();
		$current_password = $this->input->post('current_password');
		if(!$userobj->check_password($this->_user['id'], $current_password))
			{
				echo 1;
				exit;
			}else{
				echo 2;
				exit;
			}
	}
	
	/*
	 * 修改用户密码
	 */
	public function password()
	{
		$userobj = user::get_instance();
		$userobj->check_login();
        
		if($_POST) {
			$password = $this->input->post('password');
			$oldpassword = $this->input->post('current_password');
			$password_confirm = $this->input->post('password_confirm');
			$username = $this->_user['lastname'];	

			if( $userobj->update_password($this->_user['id'] ,$password) ) {
				//ucenter 修改密码 start
				
				$ucresult = uc_user_edit($username, $oldpassword, $password);
				
				//ucenter 修改密码结束
				user::logout_process();
				remind::set('成功更改密码，您需要重新登录', 'success', route::action('login'));
				
				
			}else 
			{
				$notice = '密码修改失败，请正确填写信息!';
				$view = new View('user/password');
				$view->set_global('_user',$this->_user);
				$view->set_global('_nav','password_protection');
				$view->set_global('notice',$notice);
				$view->render(TRUE);
				exit;
			}
		}
        $view = new View('user/password');
        
        $data['site_config'] = Kohana::config('site_config.site');
        $host = $_SERVER['HTTP_HOST'];
        $dis_site_config = Kohana::config('distribution_site_config');
        if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
        	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
        	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
        	$data['site_config']['description'] = $dis_site_config[$host]['description'];
        }
        $view->set('site_config', $data['site_config']);
        
        $view->set_global('_user', $this->_user);
        $view->set_global('_nav', 'password');
        $view->render(TRUE);
	}
	
	
	/**
     * 退出功能
     */
    public function logout() {		
        
		setcookie('yiwang_auth', '', -86400);
		$ucsynlogout = uc_user_synlogout();
	//	echo $ucsynlogout;
		$_SESSION['logout'] = $ucsynlogout;

		user::logout_process();
		
        //$alnum = text::random('alnum');
        //remind::set('您已成功退出', 'success','/?' . $alnum);
        remind::set('您已成功退出', 'success','/');	
    }
    
    /*
     * ajax判断是否登录
     */
    public function ajax_check_login()
    {
        $userobj = user::get_instance();
        $check = $userobj->check_user_login();
        if ($check)
        {
            exit('true');
        }
        else 
        {
            exit('false');
        }
    }

    /*
     * ajax输出会员信息值
     */
    public function ajax_user_money()
    {
        $arrret = array();
        $arrret['userName'] = '';
        $arrret['userMoney'] = '0.00';
        $arrret['serverTime'] = date('Y-m-d H:i:s', time());
        $arrret['userType'] = '';
        $arrret['outstanding_plan'] = '';
    
        $userobj = user::get_instance();
        $check = $userobj->check_user_login();

        if ($check)
        {
            $user = $userobj->get($check);
            $arrret['userName'] = $user['lastname'];
            $moneys = $userobj->get_user_moneys($user['id']);
            
            $arrret['userMoney'] = $moneys['all_money'];
            $arrret['money_user'] = $moneys['user_money'];
            $arrret['money_bonus'] = $moneys['bonus_money'];
            $arrret['money_free'] = $moneys['free_money'];
            
            $arrret['outstanding_plan'] = Plans_basicService::get_instance()->get_count_notend($this->_user['id']);
        }
        exit(json_encode($arrret));
    }
    
    /*
     * ajax输出会员虚拟信息值
    */
    public function ajax_user_virtual_money()
    {
    	$arrret = array();
    	$arrret['userName'] = '';
    	$arrret['userMoney'] = '0.00';
    	$arrret['serverTime'] = date('Y-m-d H:i:s', time());
    	$arrret['userType'] = '';
    	$arrret['outstanding_plan'] = '';
    
    	$userobj = user::get_instance();
    	$check = $userobj->check_user_login();
    
    	if ($check)
    	{
    		$user = $userobj->get($check);
    		$arrret['userName'] = $user['lastname'];
    		$arrret['userMoney'] = $user['virtual_money'];
    		$arrret['outstanding_plan'] = Plans_basicService::get_instance()->get_count_notend($this->_user['id']);
    	}
    	exit(json_encode($arrret));
    }
    
    /*
     * ajax检查用户名是否注册
     */
    public function ajax_check_name($back, $username, $type = 1)
    {
        $arrret = array();
        $arrret['code'] = 0;
        $arrret['msg'] = '';
        
        $typename = $type == 1 ? '用户名' : 'Email';
        
        if (user::get_instance()->is_register($username, $type))
        {
            $arrret['code'] = -1;
            $arrret['msg'] = '该'.$typename.'已存在!';
        }
        else
        {
            $arrret['code'] = 1;
        }
        exit($back.'('.json_encode($arrret).')');
    }
    
    
/*
     * ajax检查用户名是否注册2zz
     */
    public function ajax_checkname()
    {
    	$get_data = $this->input->get();
        $arrret = array();
        $arrret['code'] = 0;
        $arrret['msg'] = '';
        
        if(isset($get_data['lastname'])){
          $type = 1;
          $typename = '用户名';
          $username = $get_data['lastname'];
        }
        
        if (user::get_instance()->is_register($username, $type))
        {
            exit('false');
        }
        else
        {
            exit('true');
        }
        
    }

	public function password_protection(){
		$user = user::get_instance();
		$uid = $this->_user['id'];
		$userinfo = $user->get($uid);
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
		if($_POST)
		{
			$user->edit($uid,$_POST);
			$view = new View('user/password_protection',$data);
			$view->set_global('userinfo',$userinfo);
			$view->set_global('_user', $this->_user);
			$view->set_global('notice',$notice);
			$view->set_global('_nav', 'password_protection');
			$view->render(TRUE);
			exit;
		}
		$data['passwordquestion'] = kohana::config('passwordquestion');
		$view = new View('user/password_protection',$data);
		$view->set_global('userinfo',$userinfo);
		$view->set_global('_user', $this->_user);
		$view->set_global('notice',$notice);
		$view->set_global('_nav', 'password_protection');
		$view->render(TRUE);
	}
	
	public function invitecode($icode){
		$user = user::get_instance();
		$uid = $this->_user['id'];
		$userinfo = $user->get($uid);
		$arrret = array();
        
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
		if(!empty($icode) || $_POST)
		{
			if (empty($icode)){
				$icode = $this->input->post('icode');
			}
			$retxx = $user->invitecodeinput($icode);
//d($retxx,false);
			if ($retxx == 0){
				$notice='操作成功！';
			}else if($retxx == 1){
				$notice='操作失败:'.'该邀请码无效';
			}else if($retxx == 2){
				$notice='操作失败';
			}else if($retxx == 3){
				$notice='已经成功。';
			}else if($retxx == 5){
				$notice='操作失败。[5]';
			}else if($retxx == 9){
				$notice='暂时不能更换邀请码，请联系管理员。[9]';
			}
			$view = new View('user/invitecode',$data);
			$view->set_global('userinfo',$userinfo);
			$view->set_global('_user', $this->_user);
			$view->set_global('notice',$notice);
			$view->set_global('_nav', 'invitecode');
			$view->render(TRUE);
			exit;
		}
		$data['passwordquestion'] = kohana::config('passwordquestion');
		$view = new View('user/invitecode',$data);
		$view->set_global('userinfo',$userinfo);
		$view->set_global('_user', $this->_user);
		$view->set_global('notice',$notice);
		$view->set_global('_nav', 'invitecode');
		$view->render(TRUE);
	}
	
	public function getpassword(){
		$user = user::get_instance();
		if($_POST)
		{
		  $lastname = $this->input->post('lastname');
		  $email = $this->input->post('email');
		  setcookie('username',$lastname);
		  setcookie('email',$email);
		  $userinfo = $user->check_user($lastname,$email);
		  
		  if($userinfo != FALSE )
		  {
			  $user_id = $userinfo['id'];
			  setcookie('user_id',$user_id);
			  $token = '';
			  $rand_num = rand(100000,999999);//该随机数存储的是新的密码
			  $user->update_password($user_id,$rand_num);
			  $user->find_password_process($user_id,$email,$lastname,$rand_num);
			  //ucenter 修改密码 start
			  	$username = $lastname;
				$newpassword = $rand_num;
				echo 'username='.$username.'<br>';
				echo 'password='.$newpassword;
				$ucresult = uc_user_edit($username,'', $newpassword,'',1);
				
				if($ucresult == -1) {
					echo '旧密码不正确';
				} elseif($ucresult == -4) {
					echo 'Email 格式有误';
				} elseif($ucresult == -5) {
					echo 'Email 不允许注册';
				} elseif($ucresult == -6) {
					echo '该 Email 已经被注册';
				}
				//ucenter 修改密码结束
			  url::redirect('/user/find_success');
		  }else
		  {
			  $notice = '用户名或者邮箱不正确!';
		  }
		}
		$view = new View('user/forgot');
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$view->set('site_config', $data['site_config']);
		
		$view->set_global('_user', $this->_user);
        $view->set_global('_nav', 'forgot');
		$view->set_global('notice',$notice);
		$view->render(TRUE);
	}
	
	public function find_success(){
		if($_POST)
		{
			$user_id = $_COOKIE['user_id'];
			$lastname = $_COOKIE['username'];
			$email = $_COOKIE['email'];
			$rand_num = rand(100000,999999);
			$user->update_password($user_id,$rand_num);
			$user->find_password_process($user_id,$email,$lastname,$rand_num);
			url::redirect('/user/find_success');
		}
		$view = new View('user/find_success');
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$view->set('site_config', $data['site_config']);
		
		$view->set_global('_user', $this->_user);
        $view->set_global('_nav', 'forgot');
		$view->render(TRUE);
	}
	
	//短信发送 url 匹配	
	public function sms_curl($url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_TIMEOUT, 3);//超时时间
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($curl);
		curl_close($curl);
		return $data;
	}
	
	public function send_sms($mobile)
	{
		$user = user::get_instance();
		$clr = $user->check_user_login();
		if ($clr == false) {
			die('login');
		}
		else {
			$userinfo = $user->get($clr);
			if ($userinfo['check_status'] == 2) {
				die('false');
			}
		}
		if (isset($_SESSION['CHK_GET_CJ']) && $_SESSION['CHK_GET_CJ'] == 'LOCK') {
			die('lock');
		}
		$site_config = $this->_site_config; 
		$sms_config = Kohana::config('sms');
		$rand_num = rand(100000,999999);
	//	$_mobile = $this->input->post('phone_num');
		//发送短信验证码
		$content = '短信验证码是：'.$rand_num.'，请在填写到网站上完成验证。 【'.$site_config['site_config']['site_title'].'-上海竞搏】';
		$post_data = "sname=".$sms_config['sname']."&spwd=".$sms_config['spwd']."&scorpid="."&sprdid=".$sms_config['sprdid']."&sdst=".$mobile."&smsg=".rawurlencode($content);
		$target = $sms_config['url'];
		$this->sms_curl($target.$post_data);
    	$_SESSION['ran_num'] = $rand_num;
    	$_SESSION['CHK_GET_CJ'] = 'LOCK';
	}
	
	//彩金申请 验证 模块开始	
	public function check_mobi_email(){
		$limit_money = 50;
		$user = user::get_instance();
		$user->check_login();
        $data = $user->get($this->_user['id']);
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
	    $action_open = TRUE;
		$maxipcount = 1;
		$ip_count = $user->get_count_ip($data['ip']);
		$ip_config = Kohana::config('ip');
		$_SESSION['CHK_GET_CJ'] = 'UNLOCK';
		$handsel = handsel::get_instance();
		$handsel_info = $handsel->get(1);
		if ($data['is_auth'] != 2) {
			$action_open = -2;
			$uid = $this->_user['id'];
			$data['user'] = $user->get($uid);
			$view = new View('user/check_mobi_email', $data);
			$view->set_global('action_open', $action_open);
			$view->set_global('_user',$this->_user);
			$view->set_global('_nav','check_mobi_email');
			$view->render(TRUE);
			exit;
		}
		if ($handsel_info['status'] == 0)
		{
		    $action_open = 0;
			$uid = $this->_user['id'];
			$data['user'] = $user->get($uid);
			$view = new View('user/check_mobi_email', $data);
			$view->set_global('action_open', $action_open);
			$view->set_global('_user',$this->_user);
			$view->set_global('_nav','check_mobi_email');
			$view->render(TRUE);
			exit;
		}
		elseif($handsel_info['end_time'] < date("Y-m-d") || date("Y-m-d") < $handsel_info['start_time'] )
		{
		    $action_open = 1;
			$uid = $this->_user['id'];
			$data['user'] = $user->get($uid);
			$view = new View('user/check_mobi_email', $data);
			$view->set_global('action_open', $action_open);
			$view->set_global('_user',$this->_user);
			$view->set_global('_nav','check_mobi_email');
			$view->render(TRUE);
			exit;
		}
		/*elseif ( !(in_array($data['ip'],$ip_config)) && $ip_count > $maxipcount)
		{
		    $action_open = 2;
			$uid = $this->_user['id'];
			$data['user'] = $user->get($uid);
			$view = new View('user/check_mobi_email', $data);
			$view->set_global('action_open', $action_open);
			$view->set_global('_user',$this->_user);
			$view->set_global('_nav','check_mobi_email');
			$view->render(TRUE);
			exit;
		}*/
		elseif ($data['check_status'] == 2)
		{
		    $action_open = 4;
			$uid = $this->_user['id'];
			$data['user'] = $user->get($uid);
			$view = new View('user/check_mobi_email', $data);
			$view->set_global('action_open', $action_open);
			$view->set_global('_user',$this->_user);
			$view->set_global('_nav','check_mobi_email');
			$view->render(TRUE);
			exit;
		}
		elseif ($data['check_status'] == 3)
		{
		    $action_open = 10;
			$uid = $this->_user['id'];
			$data['user'] = $user->get($uid);
			$view = new View('user/check_mobi_email', $data);
			$view->set_global('action_open', $action_open);
			$view->set_global('_user',$this->_user);
			$view->set_global('_nav','check_mobi_email');
			$view->render(TRUE);
			exit;
		}
		else
		{
			$action_open = -1;
		}
		
		
		if($data['check_status'] == 0)
		{ //check_status = 0
			if($_POST)
			{
				//手机验证码验证
				if($_SESSION['ran_num'] != $this->input->post('code'))
				{
					$notice = '手机验证码填写错误,请刷新页面后重新验证!';
					$uid = $this->_user['id'];
					$data['user'] = $user->get($uid);
					$view = new View('user/check_mobi_email', $data);
					$view->set_global('action_open', $action_open);
					$view->set_global('_user',$this->_user);
					$view->set_global('_nav','check_mobi_email');
					$view->set_global('notice',$notice);
					$view->render(TRUE);
					exit;
				}
		
				$uid = $this->_user['id'];
				$data = $user->get($uid);

				$user_handsel = users_handsel::get_instance();
				$identity_card = $this->input->post('identity_card');
				$email = $this->input->post('email');
				$mobile = $this->input->post('mobile');
				
				$idc_flag = $user_handsel->check_idc_email_mobile('identity_card',$identity_card);
				$email_flag = $user_handsel->check_idc_email_mobile('email',$email);
				$mobile_flag = $user_handsel->check_idc_email_mobile('mobile',$mobile);
				//$ip_flag = $user_handsel->check_idc_email_mobile('ip',$data['ip']);
				
				$data['user'] = $user->get($uid);
				$view = new View('user/check_mobi_email', $data);
				$view->set_global('_user',$this->_user);
				$view->set_global('_nav','check_mobi_email');
				if($idc_flag)
				{
					//身份证重复
					$action_open = 5;
					$view->set_global('action_open', $action_open);
					$view->render(TRUE);
					exit;
				}elseif($email_flag)
				{
					//邮箱重复
					$action_open = 6;
					$view->set_global('action_open', $action_open);
					$view->render(TRUE);
					exit;
				}elseif ($mobile_flag)
				{
					//手机号码重复
					$action_open = 7;
					$view->set_global('action_open', $action_open);
					$view->render(TRUE);
					exit;
				}
				/*elseif ($ip_flag)
				{
					//Ip重复
					$action_open = 8;
					$view->set_global('action_open', $action_open);
					$view->render(TRUE);
					exit;
				}*/
				elseif($_COOKIE['handsel_cookie'] == 'http://www.jingbo365.com')
				{
					//cookie一直，则不通过验证
					$action_open = 9;
					$view->set_global('action_open', $action_open);
					$view->render(TRUE);
					exit;
				}
				else
				{
				
				}
				/**
				 * 至少充值金额
				 */
				if( $data['user_money'] >= $limit_money )
				{

					//更新用户信息
					$real_name = $this->input->post('real_name');
					$identity_card = $this->input->post('identity_card');
					$email = $this->input->post('email');
					$mobile = $this->input->post('mobile');
					
					$real_name = !empty($real_name) ? $real_name : NULL;
					$identity_card = !empty($identity_card) ? $identity_card : NULL;
					$email = !empty($email) ? $email : NULL;
					$mobile = !empty($mobile) ? $mobile : NULL;
					
					if(!empty($real_name))
					{
						$_POST['real_name'] = $real_name;
					}
					if(!empty($identity_card))
					{
						$_POST['identity_card'] = $identity_card;
					}
					if(!empty($email))
					{
						$_POST['email'] = $email;
					}
					if(!empty($mobile))
					{
						$_POST['mobile'] = $mobile;
					}
					$user->edit($uid,$_POST);
					
					//添加验证通过的用户到彩金表
					$_POST['id'] = $uid;
					$_POST['lastname'] = $data['lastname'];
					$_POST['ip'] = $data['ip'];
					$handsel_data = array(
								'uid'	=>	intval($uid),
								'identity_card'	=>	$identity_card,
								'email'	=>	$email,
								'mobile'	=>	$mobile,
								'real_name'	=>	$real_name,
								'lastname'	=>	$data['lastname'],
								'ip'		=>	$data['ip']
					);
					tool::filter_strip_tags($handsel_data);
					$user_handsel->handsel_add($handsel_data);
					
					//彩金人工审核start  0为自动通过，1为人工审核
					$handsel = handsel::get_instance();
					$handsel_info = $handsel->get(1);
					if($handsel_info['check'] == 0)
					{
						//钱>5 且之前一次都没有领过彩金 check_status = 0
						$user->edit($uid,array('check_status'=>2));
						$mobile_flag = 1;
						
						//彩金赠送开始						
						$handsel = handsel::get_instance();
						$handsel_info = $handsel->get(1);						
						user_money::get_instance()->update_money(0, $this->_user['id'], $handsel_info['total'], 7, date('YmdHis').rand(0, 99999), 'FREE_MONEY', '赠送彩金');
						
						//account_log::get_instance()->add($data_log);
						//彩金赠送结束
						
						//验证信息通过后设置cookie
						setcookie('handsel_cookie','http://www.jingbo365.com',time()+3600*24*7);
					}else
					{
						$user->edit($uid,array('check_status'=>3));
						$action_open = 10;
						$uid = $this->_user['id'];
						$data['user'] = $user->get($uid);
						$view = new View('user/check_mobi_email', $data);
						$view->set_global('action_open', $action_open);
						$view->set_global('_user',$this->_user);
						$view->set_global('_nav','check_mobi_email');
						$view->render(TRUE);
						exit;
					}
					//end 彩金人工审核结束
	
					$view = new View('user/check_end', $data);
					$view->set_global('action_open', $action_open);
					$view->set_global('_user',$this->_user);
					$view->set_global('_mobile_flag',$mobile_flag);
					$view->set_global('_nav','check_end');
					$view->render(TRUE);
					exit;
				}else
				{
					$action_open = 3;
					$uid = $this->_user['id'];
					$data = $user->get($uid);
					
					//更新用户信息
					$real_name = $this->input->post('real_name');
					$identity_card = $this->input->post('identity_card');
					$email = $this->input->post('email');
					$mobile = $this->input->post('mobile');
					
					$real_name = !empty($real_name) ? $real_name : NULL;
					$identity_card = !empty($identity_card) ? $identity_card : NULL;
					$email = !empty($email) ? $email : NULL;
					$mobile = !empty($mobile) ? $mobile : NULL;
					
					if(!empty($real_name))
					{
						$_POST['real_name'] = $real_name;
					}
					if(!empty($identity_card))
					{
						$_POST['identity_card'] = $identity_card;
					}
					if(!empty($email))
					{
						$_POST['email'] = $email;
					}
					if(!empty($mobile))
					{
						$_POST['mobile'] = $mobile;
					}
					$user->edit($uid,$_POST);
					
					//添加验证通过的用户到彩金表
					$_POST['id'] = $uid;
					$_POST['lastname'] = $data['lastname'];
					$_POST['ip'] = $data['ip'];
					$handsel_data = array(
								'uid'	=>	intval($uid),
								'identity_card'	=>	$identity_card,
								'email'	=>	$email,
								'mobile'	=>	$mobile,
								'real_name'	=>	$real_name,
								'lastname'	=>	$data['lastname'],
								'ip'		=>	$data['ip']
					);
					tool::filter_strip_tags($handsel_data);
					$user_handsel->handsel_add($handsel_data);
					
					$user->edit($uid,array('check_status'=>1));
					$mobile_flag = 1;
				}
			}
		}
		elseif( $data['check_status'] == 1 )
		{
			if($_COOKIE['handsel_cookie'] == 'http://www.jingbo365.com')
			{
				//cookie一直存在，则不通过验证
				$action_open = 9;
				$data['user'] = $user->get($uid);
				$view = new View('user/check_mobi_email', $data);
				$view->set_global('_user',$this->_user);
				$view->set_global('_nav','check_mobi_email');
				$view->set_global('action_open', $action_open);
				$view->render(TRUE);
				exit;
			}
			//check_status = 1
			if( $data['user_money'] >= $limit_money )
			{//check_status = 1 user_money>=5
				$uid = $this->_user['id'];
				$data = $user->get($uid);
				
				//彩金人工审核start  0为自动通过，1为人工审核
				$handsel = handsel::get_instance();
				$handsel_info = $handsel->get(1);
				if($handsel_info['check'] == 0)
				{
					//彩金赠送开始						
					$handsel = handsel::get_instance();
					$handsel_info = $handsel->get(1);
					user_money::get_instance()->update_money(0, $this->_user['id'], $handsel_info['total'], 7, date('YmdHis').rand(0, 99999), 'FREE_MONEY', '赠送彩金');
					//account_log::get_instance()->add($data_log);
					//彩金赠送结束
					
					//充值成功后改变check_stutas状态为2
					$uid = $this->_user['id'];
					$data = $user->get($uid);
					$user->edit($uid,array('check_status'=>2));
					$action_open = 4;
					
					//验证信息通过后设置cookie
					setcookie('handsel_cookie','http://www.jingbo365.com',time()+3600*24*7);
				}else
				{
					$user->edit($uid,array('check_status'=>3));
					$action_open = 10;
					$uid = $this->_user['id'];
					$data['user'] = $user->get($uid);
					$view = new View('user/check_mobi_email', $data);
					$view->set_global('action_open', $action_open);
					$view->set_global('_user',$this->_user);
					$view->set_global('_nav','check_mobi_email');
					$view->render(TRUE);
					exit;
				}
				//end 彩金人工审核结束
				
				$view = new View('user/check_end', $data);
				$view->set_global('action_open', $action_open);
				$view->set_global('_user',$this->_user);
				$view->set_global('_mobile_flag',$mobile_flag);
				$view->set_global('_nav','check_mobi_email');
				$view->render(TRUE);
				exit;
			}else
			{ //check_status = 1 user_money < 5
				$action_open = 3;
			}
		}
		else
		{
			$action_open = 4;
			$uid = $this->_user['id'];
			$data['user'] = $user->get($uid);
			$view = new View('user/check_mobi_email', $data);
			$view->set_global('action_open', $action_open);
			$view->set_global('_user',$this->_user);
			$view->set_global('_nav','check_mobi_email');
			$view->render(TRUE);
		}
		
		$uid = $this->_user['id'];
		$data['user'] = $user->get($uid);
		$view = new View('user/check_mobi_email', $data);
		$view->set_global('action_open', $action_open);
		$view->set_global('_user',$this->_user);
		$view->set_global('_nav','check_mobi_email');
		$view->render(TRUE);
	}
	//彩金申请 验证 模块结束	
	
	public function check_end()
	{
		$user = user::get_instance();
		$view->set_global('_user',$this->_user);
		$view->set_global('_nav','check_end');
		$view->render(TRUE);
	}

    /*
     * ajax检查用户名是否注册
     */
    public function ajax_check_rancode($back, $randcode)
    {
        $arrret = array();
        $arrret['code'] = 0;
        $arrret['msg'] = '';

        secoder::$seKey = 'front.secoder.reg_secoder';
        $flag = secoder::check($randcode);
        if ($flag == $randcode)
        {
            $arrret['code'] = 1;
        }
        else 
        {
            $arrret['code'] = -1;
            $arrret['msg'] = '验证码错误!';
        }
        exit($back.'('.json_encode($arrret).')');
    }  
      
    /*
     * ajax检查用户名是否注册2zz
     */
    public function ajax_checkrancode()
    {
    	$get_data=$this->input->get();
    	if(!isset($get_data['secode'])){
          exit('false');
    	}else{
    	 $randcode = $get_data['secode'];
    	}
    	
        $arrret = array();
        $arrret['code'] = 0;
        $arrret['msg'] = '';

        secoder::$seKey = 'front.secoder.reg_secoder';
        $flag = secoder::check($randcode);
        if ($flag == $randcode)
        {
            exit('true');
        }
        else 
        {
           exit('false');
        }
        
    }    
    
    public function ajax_checkrancode_cn() {
    	$get_data=$this->input->get();
    	if(!isset($get_data['secode'])){
    		exit('false');
    	}else{
    		$randcode = $get_data['secode'];
    	}
    	 
    	$arrret = array();
    	$arrret['code'] = 0;
    	$arrret['msg'] = '';
    
    	secoder_cn::$seKey = 'front.secodercn.reg_secoder';
    	$flag = secoder_cn::check($randcode);
    	if ($flag == true)
    	{
    		exit('true');
    	}
    	else
    	{
    		exit('false');
    	}
    
    }

	/**
	 * 修改收款信息
	 */
	public function collection()
	{
		$userobj = user::get_instance();
		$userobj->check_login();
			    
        $view = new View('user/capital_changes');
        $userobj = user::get_instance();
        $view->set_global('_user', $this->_user);
        $view->set_global('_nav', 'capital_changes');
        $view->render(TRUE);
	}	
	
	/**
	 * 投注记录
	 */
	public function betting()
	{
		$userobj = user::get_instance();
		$userobj->check_login();	    
	    
		$page_type="betting";
		$get_data['start_time'] = $this->input->get('start_time');		
		$get_data['end_time'] = $this->input->get('end_time');				
		$get_data['type'] = $this->input->get('type');	
		$get_data['ticket_type'] = intval($this->input->get('ticket_type'));					
		$get_data['plan_status'] = $this->input->get('plan_status');
		$this->plan_list($page_type,$get_data);
		
	}

	public function today_bets()
	{
		$userobj = user::get_instance();
		$userobj->check_login();
			    
		$page_type="today_bets";
		$get_data['start_time']=date("Y-m-d")." 00:00:00";//开始时间			
	 	$get_data['end_time']=date("Y-m-d")." 23:59:59";//结束时间							
		$this->plan_list($page_type,$get_data);
	}
	
	public function game_over()
	{
		$page_type="index";
		$get_data['type']="end";//已结投注
		$this->plan_list($page_type, $get_data);
	}

	/**
	 * 今日投注
	 */
	public function plan_list($page_type, $get_data ,$a)
	{
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );
	    
        try 
        {
    		$userobj = user::get_instance();
    		$userobj->check_login();
    		$get_page = intval($this->input->get('page'));
    		$page = !empty( $get_page ) ? intval($get_page) : "1";//页码
    		$total_rows=!empty( $page_size ) ? intval($page_size) : "10";//第页显示条数		

            //初始化默认查询结构体 
            $query_struct_default = array (
                'where' => array (
                    'user_id' => $this->_user['id'],
                    'date_add > ' => date("Y-m-d H:i:s", mktime (0,0,0,date("m")-6,date("d"),date("Y"))
                    )
                ),
                'orderby' => array (
                    'id' => 'DESC' 
                ),
                'limit' => array (
                    'per_page' => $total_rows,
                    'page' => 1
                )
            );
            
            if(!empty($get_data['start_time']))
    		{
    		     $time_stamp = strtotime($get_data['start_time']);
    			 $query_struct_default['where']['date_add >'] = date("Y-m-d H:i:s", 
    			                                 mktime (0,0,0,date("m", $time_stamp), 
    			                                 date("d", $time_stamp), 
    			                                 date("Y", $time_stamp))); //开始时间					
    		}
    		if(!empty($get_data['end_time']))
    		{    
    		     $time_stamp = strtotime($get_data['end_time']);
    			 $query_struct_default['where']['date_add <'] = date("Y-m-d H:i:s", 
    			                                 mktime (0,0,0,date("m", $time_stamp), 
    			                                 date("d", $time_stamp)+1, 
    			                                 date("Y", $time_stamp))); //结束时间
    		}
    		if(!empty($get_data['ticket_type']))
    		{
    			 $query_struct_default['where']['ticket_type'] = $get_data['ticket_type'];	//彩种					
    		}
    		if($get_data['type'] == "win")                    //中奖
    		{
    			 $query_struct_default['where']['status'] = array(4,5);
    		}
    		elseif($get_data['type'] == "start")              //我发起
    		{
    			 $query_struct_default['where']['start_user_id'] = $this->_user['id'];		
    		}
    		elseif($get_data['type'] == "join")               //我参与
    		{
    		     unset($query_struct_default['where']['start_user_id']);
    			 $query_struct_default['where']['start_user_id <>'] = $this->_user['id'];
    		}
    		elseif($get_data['type'] == "end")                //己结投注
    		{
    		     $query_struct_default['where']['status'] = array(3,4,5,6);
    		}
    		elseif($get_data['type'] == "notend")             //未结投注 
    		{
    		     $query_struct_default['where']['status'] = array(0,1,2);
    		}
    		elseif($get_data['type'] == "bonus")              //最近中奖
    		{
    		     $query_struct_default['where']['status'] = array(4,5);
    		}
    		
    		if ($get_data['plan_status'] >= 0) {
    			if ($get_data['plan_status'] == 99) {
					$query_struct_default['where']['status'] = array(4,5);
    			}
    			else {
    				$query_struct_default['where']['status'] = $get_data['plan_status'];
    			}
    		}
    		/* 搜索功能 */
    		$search_arr      = array('id','order_num');
    		$search_value    = $this->input->get('search_value');
    		$search_type     = $this->input->get('search_type');
    		$where_view      = array();
    		if($search_arr)
    		{
    			foreach($search_arr as $value)
    			{
    				if($search_type == $value && strlen($search_value) > 0)
    				{
    					 $query_struct_default['like'][$value] = $search_value;
    				}
    			}
    			$where_view['search_type'] = $search_type;
    			$where_view['search_value'] = $search_value;
    		}
    		
    		//d($query_struct_default);
    		
    		
    		$request_data = $this->input->get();
            
            //初始化当前查询结构体 
            $query_struct_current = array();
                    
            //设置合并默认查询条件到当前查询结构体 
            $query_struct_current = array_merge($query_struct_current, $query_struct_default);
    
            //列表排序
            $orderby_arr = array (
                0 => array (
                    'id' => 'DESC' 
                ), 
                1 => array (
                    'id' => 'ASC' 
                ),
            );
            $orderby = controller_tool::orderby($orderby_arr);
            // 排序处理 
            if(isset($request_data['orderby']) && is_numeric($request_data['orderby'])){
                $query_struct_current['orderby'] = $orderby;
            }
            $query_struct_current['orderby'] = $orderby;
            
            //每页条目数
            controller_tool::request_per_page($query_struct_current, $request_data);
            
            //调用服务执行查询
            $plan_basicobj = Plans_basicService::get_instance();
            $return_data['count'] = $plan_basicobj->count($query_struct_current);        //统计数量
            
    		if($page_type == "today_bets") {
        		$config['base_url'] = "user/today_bets";	
        	}
        	elseif($page_type=="betting") {
        		$config['base_url'] = "user/betting";	
        	}
        	else {
        	    $query_struct_default['where']['status'] = array(0,1,2);
        	}
    		
    		$config['total_items'] = $return_data['count'];     //总数量
    		$config['query_string']  = 'page';
    		$config['items_per_page']  = $total_rows;	    //每页显示多少第		
    		$config['uri_segment']  = $page;                //当前页码	
    		$config['directory']  = "";                     //当前页码            
            
    		/* 调用分页 */
    		$this->pagination = new Pagination($config);
            $query_struct_current['limit']['page'] = $this->pagination->current_page;
                        
            $return_data['list'] = $plan_basicobj->query_assoc($query_struct_current);
            
            $return_data['ticket_type'] = Kohana::config('ticket_type');

            $planobj = plan::get_instance();
            $i = 0;
            $use_money = 0;
            $my_bonus = 0;
            $users = array();
            foreach ($return_data['list'] as $rowlist)
            {                
                $planobj->get_result($return_data['list'][$i], FALSE);
                //if(empty($return_data['list'][$i]['detail']))
                //    unset($return_data['list'][$i]);
                $users[$return_data['list'][$i]['start_user_id']] = $return_data['list'][$i]['start_user_id'];
                $use_money += $return_data['list'][$i]['plan_my_money'];
                $my_bonus += $return_data['list'][$i]['bonus'];
                $i++;
            }
            $hz_data = array('c'=>$i, 'use_money'=>$use_money, 'my_bonus'=>$my_bonus);
            //d($hz_data);
            //用户信息
            foreach ($users as $keyuser => $rowuser)
            {
                $users[$keyuser] = user::get_instance()->get($keyuser);
            }
            
            $return_data['users'] = $users;
            unset($users);
            
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;

    		$ticket_type = Kohana::config('ticket_type');
    		
    		$data['site_config'] = Kohana::config('site_config.site');
    		$host = $_SERVER['HTTP_HOST'];
    		$dis_site_config = Kohana::config('distribution_site_config');
    		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
    			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
    			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
    			$data['site_config']['description'] = $dis_site_config[$host]['description'];
    		}
    		//d($return_data['list']);
            $view = new View('user/plan_list', $return_data);
            $userobj = user::get_instance();    
            $view->set_global('_user', $this->_user);
            //$view->set('data_list', $data_list);
            $view->set('ticket_type', $ticket_type);
			$view->set('a',$a);
			$view->set('site_config', $data['site_config']);
			$view->set('hz_data',$hz_data);
			$view->set('ucsynlogin',$_SESSION['ucsynlogin']);
            $view->set_global('get_data', $get_data);
            $view->set_global('_nav', $page_type);
            
            $view->render(TRUE);
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        } 
        
	}

	/**
	 * 充值
	 */
	public function recharge()
	{
		$userobj = user::get_instance();
		$userobj->check_login();
		$this->_user['user_money'] = $userobj->get_user_money($this->_user['id']);
		$data = $this->_site_config;
		$data['pay_banks'] = Kohana::config('pay_banks');
        $view = new View('user/recharge', $data);
        $userobj = user::get_instance();
        $view->set_global('_user', $this->_user);
        $view->set_global('_nav', 'recharge');
        $view->render(TRUE);
	}
	
	/**
	 * 易宝充值
	 */
	public function recharge_yee() {
		$userobj = user::get_instance();
		$userobj->check_login();
		$this->_user['user_money'] = $userobj->get_user_money($this->_user['id']);
		$data = $this->_site_config;
		$data['pay_banks'] = Kohana::config('yeepay_pay_banks');
		$view = new View('user/recharge_yeepay', $data);
		$userobj = user::get_instance();
		$view->set_global('_user', $this->_user);
		$view->set_global('_nav', 'recharge');
		$view->render(TRUE);
	}


	/**
	 * 编辑用户体现密码
	 */
	public function withdrawals_password($action = NULL)
	{
		$userobj = user::get_instance();
		$userobj->check_login();
		$this->_user = user::get($this->_user['id']);
		$data = array();
		
		if ($action == 'checkold')
		{
		    $old_draw_password = $this->input->get('old_draw_password');
		    
		    if (empty($old_draw_password))
		    {
		        echo 0;
		        return;
		    }
		    elseif (tool::hash($old_draw_password) != $this->_user['draw_password']) 
		    {
		        echo 0;
		        return;
		    }
		    else 
		    {
		        echo 1;
		        return;
		    }
		    return ;
		}
		
		if($_POST){
		    $post = $this->input->post();
		    
		    if (!empty($this->_user['draw_password']))
            {
                if (tool::hash($post['old_draw_password']) != $this->_user['draw_password'])
                {                    
                    echo 0;
                    return;
                }
            }
    	                
            if ($userobj->update_draw_password($this->_user['id'], $post['draw_password']))
            {
                echo 1;
                return;
            }
            else
            {
                echo 2;
                return;
            }
		}
		
		
		$data['set_draw_password'] = TRUE;
		if (empty($this->_user['draw_password']))
		{
		    $data['set_draw_password'] = FALSE;
		}		
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
        $view = new View('user/withdrawals_password', $data);
        $userobj = user::get_instance();
        $view->set_global('_user', $this->_user);
        $view->set_global('_nav', 'withdrawals_password');
        $view->render(TRUE);
	}	
	
		
	/**
	 * 提现
	 */
	public function withdrawals()
	{
		$userobj = user::get_instance();
		$userobj->check_login();
		$user_bank = User_bankService::get_instance();
		$user_draw_moeny = User_draw_moneyService::get_instance();
		
		//$this->_user = user::get($this->_user['id']);
		$user_moneys = $userobj->get_user_moneys($this->_user['id']);
		
		$data = array();
        
		//可以提款的金额:本金+彩金
		$data['min_draw_money'] = Kohana::config('site_config.site.min_draw_money');
		$data['max_draw_money'] = Kohana::config('site_config.site.max_draw_money');
		$data['max_day_draw_count'] = Kohana::config('site_config.site.max_day_draw_count');
		$data['draw_money_ratio'] = Kohana::config('site_config.site.draw_money_ratio');
		$data['draw_money_fee'] = Kohana::config('site_config.site.draw_money_fee');
		
		$data['bankinfo'] = Kohana::config('bank');

		//可提现金额
		$data['draw_money'] = $user_moneys['user_money'] + $user_moneys['bonus_money'];		
		
		//是否录入身份证信息
		$set_identity_card = TRUE;
		if (empty($this->_user['identity_card']))
		{
		    $set_identity_card = FALSE;
		}

		//是否设置了提现密码
		$set_drawpassword = TRUE;
		if (empty($this->_user['draw_password']))
		{
		    $set_drawpassword = FALSE;
		}
		
	    //银行列表
		$data['banks'] = $user_bank->get_results_by_uid($this->_user['id']);
		$set_bank = TRUE;
		if (empty($data['banks']))
		{
		    $set_bank = FALSE;
		}
		
		$notices = array();
		if (!$set_identity_card || !$set_drawpassword || !$set_bank)
		{
		    $notices['set_identity_card'] = $set_identity_card;
		    $notices['set_drawpassword'] = $set_drawpassword;
		    $notices['set_bank'] = $set_bank;
		}

		$data['user_day_count'] = $user_draw_moeny->get_day_count($this->_user['id']);
		
		$msgnotice['showmsg'] = FALSE;
		$msgnotice['msg'] = '';
		$msgnotice['url'] = '';
		
		//提交表单
        if ($_POST)
        {
            $msgnotice['confirm'] = FALSE;
            $password = $this->input->post('password');
            $money = $this->input->post('money');
            $bank_id = $this->input->post('bank_name');
            $agreesubmit = $this->input->post('agreesubmit');
                        
			//提现扣款的顺序为:奖金->本金

    		//统计累计成功消费多少本金数额
			$planobj = plan::get_instance();
    		$arrmoney = $planobj->get_all_win_money($this->_user['id']);
    		$user_use_money = $arrmoney['USER_MONEY'];
    				
    		//统计累计本金充值数额
    		$user_money_obj = user_money::get_instance();
    		$arrmoney = $user_money_obj->get_user_recharge_money($this->_user['id']);
    		$user_all_recharge_money = $arrmoney['USER_MONEY'];
	
    		//检查提现中本金所占数额
    		$user_recharge_money = 0;
    		$user_recharge_money = $user_moneys['bonus_money'] - $money;
    		
    		if ($user_recharge_money < 0)
    		{
    		    $user_recharge_money *= -1;
    		}
    		else 
    		{
    		    $user_recharge_money = 0;
    		}
    		    		
			$user_draw_money_ratio = $user_use_money / $user_all_recharge_money * 100; //消费比率
            $user_recharge_fee = 0;
            
            if ($user_recharge_money > 0 && $user_draw_money_ratio < $data['draw_money_ratio'])
            {
                $user_recharge_fee = $user_recharge_money * $data['draw_money_fee'] / 100; //手续费
            }
                        			
            //检查余额
            if ($money > $data['draw_money'])
            {
		        $msgnotice['showmsg'] = TRUE;
		        $msgnotice['msg'] = '提取金额不能大于当前可提现金额';
		        $msgnotice['url'] = '/user/withdrawals';
            }
            //检查提现密码
            elseif($this->_user['draw_password'] != tool::hash($password))
            {
		        $msgnotice['showmsg'] = TRUE;
		        $msgnotice['msg'] = '提现密码输入错误';
		        $msgnotice['url'] = '/user/withdrawals';   
            }
            //检查当日申请次数
            elseif ($data['user_day_count'] > $data['max_day_draw_count'])
            {
		        $msgnotice['showmsg'] = TRUE;
		        $msgnotice['msg'] = '您今日提款已达到最多次数,请改日再申请!';
		        $msgnotice['url'] = '/user/';                   
            }
            //检查是否设置银行
            elseif (!$set_bank)
            {
		        $msgnotice['showmsg'] = TRUE;
		        $msgnotice['msg'] = '必须先设置取款信息才可以进行此操作!';
		        $msgnotice['url'] = '/user/withdrawals_info';                   
            }
            //检查是否设置提款密码
            elseif (empty($this->_user['draw_password']))
            {
		        $msgnotice['showmsg'] = TRUE;
		        $msgnotice['msg'] = '必须先设置提现密码才可以进行此操作!';
		        $msgnotice['url'] = '/user/withdrawals_password';                   
            }  
            //检查提现额度是否超出
            elseif ($money > $data['max_draw_money'])
            {
		        $msgnotice['showmsg'] = TRUE;
		        $msgnotice['msg'] = '大额取款请联络客服人员!';
		        $msgnotice['url'] = '/user/withdrawals';
            }
            //提示扣除手续费
            elseif (empty($agreesubmit) && $user_recharge_fee > 0)
            {
                $msgnotice['confirm'] = TRUE;
		        $msgnotice['showmsg'] = TRUE;
		        $msgnotice['money'] = $money;
		        $msgnotice['password'] = $password;
		        $msgnotice['bank_id'] = $bank_id;
		        $msgnotice['msg'] = '您的提现金额累计消费金额与累计存入金额比率小于'.$data['draw_money_ratio'].'%，将扣除手续费：'.sprintf("%01.1f", $user_recharge_fee).'元，确定要提现吗?';
		        $msgnotice['url'] = '/user/withdrawals?agree=yes';
            }
            //检查余额是否有足够的手续费
            elseif ($data['draw_money'] < ($user_recharge_fee + $money))
            {
	            $msgnotice['showmsg'] = TRUE;
	            $msgnotice['msg'] = '您的可提现余额小于提款金额与手续费的总和：'.sprintf("%01.1f", ($user_recharge_fee + $money)).'，请修改您的提现金额!';
	            $msgnotice['url'] = '/user/withdrawals';
            }
            //通过则入库
            else 
            {
                //提现金额
    			$withdrawals_moneys = array();
    			$withdrawals_moneys['USER_MONEY'] = 0;    
    			$withdrawals_moneys['BONUS_MONEY'] = 0;    
    			$withdrawals_moneys['FREE_MONEY'] = 0;
    			
    			//手续费
    			$fee_moneys = array();
    			$fee_moneys['USER_MONEY'] = 0;    
    			$fee_moneys['BONUS_MONEY'] = 0;    
    			$fee_moneys['FREE_MONEY'] = 0;
    			
                $user_recharge_money = 0;
    		    $user_recharge_money = $user_moneys['bonus_money'] - $money;
    		
    		    if ($user_recharge_money < 0)
    		    {
    		        $user_recharge_money *= -1;
    		        $withdrawals_moneys['USER_MONEY'] = $user_recharge_money; 
    		        $withdrawals_moneys['BONUS_MONEY'] = $user_moneys['bonus_money'];
    		    }
    		    else 
    		    {
    		        $withdrawals_moneys['USER_MONEY'] = 0;
    		        $withdrawals_moneys['BONUS_MONEY'] = $money;
    		    }
    		    
    		    //当手续费>0时 手续费只能从本金上扣除
    		    if ($user_recharge_fee > 0)
    		    {    		        
    		        $fee_moneys['USER_MONEY'] = $user_recharge_fee;
    		    }
                
                $data_db = array();
                $data_db['user_id'] = $this->_user['id'];
                $data_db['money'] = $money;
                $data_db['truename'] = $this->_user['real_name'];
               
                $bank_result = $user_bank->get($bank_id);
                
                $data_db['bank_name'] = $data['bankinfo'][$bank_result['bank_name']];
                $data_db['account'] = $bank_result['account'];
                $data_db['province'] = $bank_result['province'];
                $data_db['city'] = $bank_result['city'];
                $data_db['bank_found'] = $bank_result['bank_found'];
                
                $json_other = array();
                $json_other['withdrawals_moneys'] = $withdrawals_moneys;
                $json_other['fee_moneys'] = $fee_moneys;
                
                $data_db['other'] = json_encode($json_other);
                $data_db['status'] = 0;
                                
                if ($user_draw_moeny->add($data_db))
                {
                    $order_num = date('YmdHis').rand(0, 99999);
                    $lan = Kohana::config('lan');
                    $user_money_obj->minus_money($this->_user['id'], $money, $withdrawals_moneys, 4, $order_num, $lan['money'][12]);
                    if ($user_recharge_fee > 0)
                    {
                        $user_money_obj->minus_money($this->_user['id'], $user_recharge_fee, $fee_moneys, 4, $order_num, $lan['money'][19]);
                    }
		            $msgnotice['showmsg'] = TRUE;
		            $msgnotice['msg'] = '提现申请成功，您可以在“取款记录”中查看您的金额变化状况';
		            $msgnotice['url'] = '/user/atm_records';
                }
                else
                {
		            $msgnotice['showmsg'] = TRUE;
		            $msgnotice['msg'] = '提现申请失败,系统发生了一个意外情况!';
		            $msgnotice['url'] = '/user/withdrawals';
                }
            }
        }
        
        $data['site_config'] = Kohana::config('site_config.site');
        $host = $_SERVER['HTTP_HOST'];
        $dis_site_config = Kohana::config('distribution_site_config');
        if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
        	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
        	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
        	$data['site_config']['description'] = $dis_site_config[$host]['description'];
        }
        
        //$this->_user['user_money'] = $userobj->get_user_money($this->_user['id']);
		$view = new View('user/withdrawals', $data);
		$view->set('set_bank', $set_bank);
		$view->set('msgnotice', $msgnotice);
		$view->set('notices', $notices);
		$view->set_global('_user', $this->_user);
		//$view->set_global('user_money', $this->_user['user_money']);
		$view->set_global('_nav', 'withdrawals');
		$view->render(TRUE);
	}
	
	/**
	 * 修改取款信息
	 */
	public function withdrawals_info($action = NULL, $current_id = 0)
	{
		$userobj = user::get_instance();
		$userobj->check_login();
		
		$user_bank = User_bankService::get_instance();
		//$this->_user = user::get($this->_user['id']);
		
		$data = array();
		$data['submit_ok'] = FALSE;
		$data['submit_msg'] = '已成功添加!';
		
		//提交表单
        if ($_POST)
        {
            $post = $this->input->post();
        	if ($action == 'sub_bank')
		    {
		        
		        //检测帐号是否存在
		        if ($user_bank->exist($post['account'], $this->_user['id']))
		        {
		            $data['submit_ok'] = TRUE;
		            $data['submit_msg'] = '此帐号已被添加过了!';
		        }
		        else 
		        {
		            $password = tool::hash($post['password']);
		            
		            //检查取款密码
		            if ($password != $this->_user['draw_password'])
		            {
		                $data['submit_ok'] = TRUE;
		                $data['submit_msg'] = '提现密码输入错误!';
		            }
		            else 
		            {
    		            $post['user_id'] = $this->_user['id'];
        		        $post['bank_type'] = 1;    //默认为银行
        		        
        		        if ($flag = $user_bank->add($post))
        		        {
        		            $data['submit_ok'] = TRUE;
        		        }
        		        else
        		        {
        		            $data['submit_ok'] = TRUE;
        		            $data['submit_msg'] = '提交时发生了一个错误!';
        		        }		            
		            }
		        }
		    }
        }
        
        $current_id = intval($current_id);
        if (!empty($current_id))
        {
            $result = $user_bank->get($current_id);            
            if ($result['user_id'] == $this->_user['id'])
            {
                if ($action == 'delete')
                {
                    $user_bank->delete_one($current_id);
                }
                elseif ($action == 'default')
                {
                     $user_bank->set_default($current_id, $this->_user['id']);
                }
            }
        }
        
        $data['bankinfo'] = Kohana::config('bank');
		$userobj = user::get_instance();
		
		//资料是否完善
	    $set_profile = TRUE;    
		if (empty($this->_user['real_name']) || empty($this->_user['identity_card']))
		{
		    $set_profile = FALSE;
		}
		
		//是否设置了体现密码
		$set_drawpassword = TRUE;
		if (empty($this->_user['draw_password']))
		{
		    $set_drawpassword = FALSE;
		}
		
		//银行列表
		$data['results'] = $user_bank->get_results_by_uid($this->_user['id']);
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
		$view = new View('user/withdrawals_info', $data);
		$view->set('set_profile', $set_profile);
		$view->set('set_drawpassword', $set_drawpassword);
		$view->set_global('_user', $this->_user);
		$view->set_global('user_money', $this->_user['user_money']);
		$view->set_global('_nav', 'withdrawals_info');
		$view->render(TRUE);
	} 
	 
	
	/**
	 * 充值记录
	 */
	public function recharge_records()
	{
		$userobj = user::get_instance();
		$userobj->check_login();	    
	    
	    $this->_user['user_money'] = user::get_instance()->get_user_money($this->_user['id']);
        $return_data = $this->account_logs('/user/recharge_records/', 1, array('price'));
        
        $return_data['site_config'] = Kohana::config('site_config.site');
        $host = $_SERVER['HTTP_HOST'];
        $dis_site_config = Kohana::config('distribution_site_config');
        if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
        	$return_data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
        	$return_data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
        	$return_data['site_config']['description'] = $dis_site_config[$host]['description'];
        }
        
        $view = new View('user/recharge_records', $return_data);
        $view->set_global('_user', $this->_user);
        $view->set_global('_nav', 'recharge_records');
        $view->render(TRUE);
	}
	
	
	/**
	 * 取款记录
	 */
	public function atm_records() 
	{
		$userobj = user::get_instance();
		$userobj->check_login();
	    $this->_user['user_money'] = user::get_instance()->get_user_money($this->_user['id']);
	    $return_data = $this->account_logs('/user/atm_records/', 4, array('price'));
	    
	    $return_data['site_config'] = Kohana::config('site_config.site');
	    $host = $_SERVER['HTTP_HOST'];
	    $dis_site_config = Kohana::config('distribution_site_config');
	    if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
	    	$return_data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
	    	$return_data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
	    	$return_data['site_config']['description'] = $dis_site_config[$host]['description'];
	    }
	    
        $view = new View('user/atm_records', $return_data);
        $view->set_global('_user', $this->_user);
        $view->set_global('_nav', 'atm_records');
        $view->render(TRUE);
	}
	
	/**
	 * @author wunan
	 * @return null
	 * 获得可取消体提现列表
	 */
	public function atm_records_esc() 
	{
		$userobj = user::get_instance();
		$userobj->check_login();
		$atm_records_esc = new View('user/atm_records_esc');
		$query_struct_link = array(
		'where'		=>array('status'=>0,'user_id'=>$this->_user['id']),
		'limit'		=>array('per_page'=>100,'offset'=>0)
		);
		$list = User_draw_money::instance()->lists($query_struct_link);
		$atm_records_esc->set('list',$list);
		
		$return_data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$return_data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$return_data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$return_data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$atm_records_esc->set('site_config',$return_data['site_config']);
		$atm_records_esc->render(TRUE);
	}
	
	/**
	 * @author wunan
	 * 获得可取消体提现列表
	 */
	public function atm_esc()
	{
        if (empty($_POST))
        {
            remind::set(Kohana::lang('o_global.bad_request'),'user/atm_records_esc');
        }
        
        $request_data = $this->input->post();
        
        if (empty($request_data['order_ids']))
        {
            remind::set(Kohana::lang('o_global.bad_request'),'user/atm_records_esc');
        }
        
        $id = $request_data['order_ids'][0];
        $user_draw_moeny = User_draw_moneyService::get_instance();
        $user_draw_moeny->atm_esc($id,$this->_user['lastname'],$this->_user['id']);
        remind::set("取消提现成功",'success','user/atm_records_esc');
	}	
	
	
	/**
	 * 资金变动明细
	 */
	public function capital_changes() 
	{
		$userobj = user::get_instance();
		$userobj->check_login();
		$this->_user['user_money'] = $userobj->get_user_money($this->_user['id']);
	    $return_data = $this->account_logs('/user/capital_changes/', 0, array('price'), TRUE);
	    
	    $return_data['site_config'] = Kohana::config('site_config.site');
	    $host = $_SERVER['HTTP_HOST'];
	    $dis_site_config = Kohana::config('distribution_site_config');
	    if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
	    	$return_data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
	    	$return_data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
	    	$return_data['site_config']['description'] = $dis_site_config[$host]['description'];
	    }
	    
        $view = new View('user/capital_changes', $return_data);
        $view->set_global('_user', $this->_user);
        $view->set_global('_nav', 'capital_changes');
        $view->render(TRUE);
	}
	
	
	/**
	 * 充值记录公用
	 */
	public function account_logs($base_url, $log_type = NULL, $sums = array('price'), $logall = FALSE)
	{	
	    $timelimit = date("Y-m-d H:i:s", mktime (0,0,0,date("m")-3,date("d"),  date("Y")));
        //初始化默认查询结构体 
        $query_struct_default = array (
            'where' => array (
                'user_id' => $this->_user['id'],
                'add_time >= ' => $timelimit
            ), 
            'orderby' => array (
                'id' => 'DESC' 
            ), 
            'limit' => array (
                'per_page' => 10,
                'page' => 1
            )
        );

        if (!empty($log_type))
        {
            $query_struct_default['where']['log_type'] = $log_type;
        }
                
        $request_data = $this->input->get();
        $timebeg = $this->input->get('begintime');
		$timeend = $this->input->get('endtime');
		        
		if (!empty($timebeg))
		{   
		    $query_struct_default['where']['add_time >='] = $timebeg;
		}
		else 
		{
		    !$logall && $query_struct_default['where']['add_time >='] = date("Y-m-d H:i:s", time()-7*24*3600);
		}
		
	    if (!empty($timeend))
		{
		    $query_struct_default['where']['add_time <='] = $timeend;
		}
        
        //初始化当前查询结构体 
        $query_struct_current = array ();
                
        //设置合并默认查询条件到当前查询结构体 
        $query_struct_current = array_merge($query_struct_current, $query_struct_default);

        //列表排序
        $orderby_arr = array (
            0 => array (
                'id' => 'DESC' 
            ), 
            1 => array (
                'id' => 'ASC' 
            ),
        );
        $orderby = controller_tool::orderby($orderby_arr);
        // 排序处理 
        if(isset($request_data['orderby']) && is_numeric($request_data['orderby'])){
            $query_struct_current['orderby'] = $orderby;
        }
        $query_struct_current['orderby'] = $orderby;

        //d($query_struct_current);
        
        //求和统计结构体需要放在controller_tool操作之前
        $sum_struct_current = $query_struct_current;
        $sum_struct['in'] = $query_struct_current;
        $sum_struct['out'] = $query_struct_current;
        $sum_struct['recharge'] = $query_struct_current; 
        $sum_struct['recharge']['where']['log_type'] = array(1, 6);
        
        
        $sum_struct['in']['where']['is_in'] = 0;
        $sum_struct['out']['where']['is_in'] = 1;
        $sum_struct['out']['recharge']['log_type'] = 1;
        
        //每页条目数
        controller_tool::request_per_page($query_struct_current, $request_data);
        
        //调用服务执行查询
        $acobj = Account_logService::get_instance();
        $return_data['count'] = $acobj->count($query_struct_current);    //统计数量
        $return_data['incount'] = $acobj->count($sum_struct['in']);      //统计数量 
        $return_data['outcount'] = $acobj->count($sum_struct['out']);    //统计数量
        $return_data['rechargecount'] = $acobj->count($sum_struct['recharge']);    //统计数量
                
        
        if (!empty($sums))
        {
            $return_data['sum'] = $acobj->query_sum($sum_struct_current, $sums); //求和统计
            
            if (empty($log_type))
            {
                $sum_struct_current['where']['is_in'] = 1;
                $return_data['outsum'] = $acobj->query_sum($sum_struct_current, array('price')); //求和统计
            
                $sum_struct_current['where']['is_in'] = 0;
                $return_data['insum'] = $acobj->query_sum($sum_struct_current, array('price')); //求和统计                
            }
            elseif ($log_type == 4)  //取款记录
            {
                $sum_struct_current['where']['is_in'] = 1;
                $return_data['outsum'] = $acobj->query_sum($sum_struct_current, array('price')); //求和统计
            }
        }
        
        // 模板输出 分页
        $this->pagination = new Pagination(array (
            'base_url' => $base_url,
            'query_string' => 'page',
            //'uri_segment' => 'page',
            'total_items' => $return_data['count'],
            'items_per_page' => $query_struct_current['limit']['per_page'],
            'directory' => '',
        ));

        $query_struct_current['limit']['page'] = $this->pagination->current_page;
        $return_data['list'] = $acobj->query_assoc($query_struct_current);
        
        $account_type = Kohana::config('acccount_type');
                
        $i = 0;
        foreach ($return_data['list'] as $rowlist)
        {
            $return_data['list'][$i] = $rowlist;
            $return_data['list'][$i]['type_name'] = empty($account_type[$rowlist['log_type']]) ? '' : $account_type[$rowlist['log_type']]; 
            $i++;
        }
                
        return $return_data;
        
	}	

	/**
	 * 虚拟资金变动明细
	 */
	public function virtual_capital_changes()
	{
		$userobj = user::get_instance();
		$userobj->check_login();
		$this->_user['user_money'] = $this->_user['virtual_money'];
		$return_data = $this->account_virtual_logs('/user/virtual_capital_changes/', 0, array('price'), TRUE);
		 
		$return_data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$return_data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$return_data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$return_data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		 
		$view = new View('user/virtual_capital_changes', $return_data);
		$view->set_global('_user', $this->_user);
		$view->set_global('_nav', 'capital_changes');
		$view->render(TRUE);
	}
	
	
	/**
	 * 虚拟记录
	 */
	public function account_virtual_logs($base_url, $log_type = NULL, $sums = array('price'), $logall = FALSE)
	{
		$timelimit = date("Y-m-d H:i:s", mktime (0,0,0,date("m")-3,date("d"),  date("Y")));
		//初始化默认查询结构体
		$query_struct_default = array (
				'where' => array (
						'user_id' => $this->_user['id'],
						'add_time >= ' => $timelimit
				),
				'orderby' => array (
						'id' => 'DESC'
				),
				'limit' => array (
						'per_page' => 10,
						'page' => 1
				)
		);
	
		if (!empty($log_type))
		{
			$query_struct_default['where']['log_type'] = $log_type;
		}
	
		$request_data = $this->input->get();
		$timebeg = $this->input->get('begintime');
		$timeend = $this->input->get('endtime');
	
		if (!empty($timebeg))
		{
			$query_struct_default['where']['add_time >='] = $timebeg;
		}
		else
		{
			!$logall && $query_struct_default['where']['add_time >='] = date("Y-m-d H:i:s", time()-7*24*3600);
		}
	
		if (!empty($timeend))
		{
			$query_struct_default['where']['add_time <='] = $timeend;
		}
	
		//初始化当前查询结构体
		$query_struct_current = array ();
	
		//设置合并默认查询条件到当前查询结构体
		$query_struct_current = array_merge($query_struct_current, $query_struct_default);
	
		//列表排序
		$orderby_arr = array (
				0 => array (
						'id' => 'DESC'
				),
				1 => array (
						'id' => 'ASC'
				),
		);
		$orderby = controller_tool::orderby($orderby_arr);
		// 排序处理
		if(isset($request_data['orderby']) && is_numeric($request_data['orderby'])){
			$query_struct_current['orderby'] = $orderby;
		}
		$query_struct_current['orderby'] = $orderby;
	
		//d($query_struct_current);
	
		//求和统计结构体需要放在controller_tool操作之前
		$sum_struct_current = $query_struct_current;
		$sum_struct['in'] = $query_struct_current;
		$sum_struct['out'] = $query_struct_current;
		$sum_struct['recharge'] = $query_struct_current;
		$sum_struct['recharge']['where']['log_type'] = array(1, 6);
	
	
		$sum_struct['in']['where']['is_in'] = 0;
		$sum_struct['out']['where']['is_in'] = 1;
		$sum_struct['out']['recharge']['log_type'] = 1;
	
		//每页条目数
		controller_tool::request_per_page($query_struct_current, $request_data);
	
		//调用服务执行查询
		$acobj = Account_virtual_logService::get_instance();
		$return_data['count'] = $acobj->count($query_struct_current);    //统计数量
		$return_data['incount'] = $acobj->count($sum_struct['in']);      //统计数量
		$return_data['outcount'] = $acobj->count($sum_struct['out']);    //统计数量
		$return_data['rechargecount'] = $acobj->count($sum_struct['recharge']);    //统计数量
	
	
		if (!empty($sums))
		{
			$return_data['sum'] = $acobj->query_sum($sum_struct_current, $sums); //求和统计
	
			if (empty($log_type))
			{
				$sum_struct_current['where']['is_in'] = 1;
				$return_data['outsum'] = $acobj->query_sum($sum_struct_current, array('price')); //求和统计
	
				$sum_struct_current['where']['is_in'] = 0;
				$return_data['insum'] = $acobj->query_sum($sum_struct_current, array('price')); //求和统计
			}
			elseif ($log_type == 4)  //取款记录
			{
				$sum_struct_current['where']['is_in'] = 1;
				$return_data['outsum'] = $acobj->query_sum($sum_struct_current, array('price')); //求和统计
			}
		}
	
		// 模板输出 分页
		$this->pagination = new Pagination(array (
				'base_url' => $base_url,
				'query_string' => 'page',
				//'uri_segment' => 'page',
				'total_items' => $return_data['count'],
				'items_per_page' => $query_struct_current['limit']['per_page'],
				'directory' => '',
		));
	
		$query_struct_current['limit']['page'] = $this->pagination->current_page;
		$return_data['list'] = $acobj->query_assoc($query_struct_current);
	
		$account_type = Kohana::config('acccount_type');
	
		$i = 0;
		foreach ($return_data['list'] as $rowlist)
		{
			$return_data['list'][$i] = $rowlist;
			$return_data['list'][$i]['type_name'] = empty($account_type[$rowlist['log_type']]) ? '' : $account_type[$rowlist['log_type']];
			$i++;
		}
	
		return $return_data;
	
	}
	
	/**
	 *	@author wunan
	 * @return null
	 * 读取银行列表 
	 */
	public function showByAjax(){ 
		$province = $this->input->post('pro');
		$bank = $this->input->post('bank');
		$city = $this->input->post('city');
		$Branch = $this->input->post('Branch');
		if(empty($province)&&empty($bank)&&empty($city)&&empty($Branch)){
			$userobj = user::get_instance();
			$userobj->check_login();
			$rs = User_bankService::get_instance();
			$rs = $rs->getBankListAjax();
			$rs = json_encode($rs);	
			echo $rs;
		}
		if(!empty($province)){
			
			$userobj = user::get_instance();
			$userobj->check_login();
			$rs = User_bankService::get_instance();
			$rs = $rs->getBankListAjax($province);
			//var_dump($rs);die();
			$rs = json_encode($rs);	
			echo $rs;
		}
		if(!empty($bank)){
			
			$userobj = user::get_instance();
			$userobj->check_login();
			$rs = User_bankService::get_instance();
			$list = Kohana::config('bank');
			$rs = $rs->getBankListAjax(null,$bank);
			//var_dump($rs);die();
			$i=0;
			foreach($rs as $a){
				foreach($list as $key=>$b){
					if($a==$b){
						$rs1[$i][id]=$key;
						$rs1[$i][name]=$a;
						$i++;
					}
				}
			} 
			$rs = json_encode($rs1);	
			echo $rs;
		}

		if(!empty($Branch)||$Branch=="0"){		
			$userobj = user::get_instance();
			$userobj->check_login();
			$list = Kohana::config('bank');
			$Branch=$list[$Branch];
			$rs = User_bankService::get_instance();
			$rs = $rs->getBankListAjax(null,$city,$Branch);
			//var_dump($rs);die();
			$rs = json_encode($rs);	
			echo $rs;
		}
	}	
	
	function getfirsthoststr(){
		$domainxx = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ?
                 $_SERVER['HTTP_X_FORWARDED_HOST'] :
                 (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
		switch ($domainxx) {
			case 'caipiao.xiaolinhouse.com': return 'xlhouse'; 
			default:break;
		}
		$x = explode(".", $domainxx);
		if (empty($x)) return '';
		if (count($x)==3){
			if ($x[0] == 'www') return '';
			if ($x[0] == 'jingbo365') return '';
			return $x[0];
		}else
			return '';
	}
	
	public function testip() {
		echo Input::instance()->ip_address();
	}
	
}