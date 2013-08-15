<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 用户管理工具方法
 */
class user_Core {
    private static $instance = NULL;

    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    
	/**
	 * 判断用户是否登录
	 */
	public static function logged_in()
	{
		$session = Session::instance();
		$user = $session->get('user');
		if($user)	
		{
			return $user;
		}else{
        	return FALSE;
		}
    }

	/**
	 * 用户登录验证
	 *
	 * @param  	string 	$email
	 * @param 	String 	$password
	 * @return 	Int 	user id
	 */
	public function login($email, $password, $type = 0)
	{
	    $field = 'lastname';
	    if ($type == 1)
	    {
	        $field = 'email';
	    }
	    
		$user = ORM::factory('user')
			->where($field, $email)
			->where('password',Mytool::hash($password))
			->where('active',1)
			->find();

		if($user->loaded)
		{
			return $user->id;
		}
		else
		{
			return 0;
		}
	}    
	
	
		/**
	 * 用户登录验证
	 *
	 * @param  	string 	$email
	 * @param 	String 	$password
	 * @return 	Int 	user id
	 */
	public function login_un_active($username, $password)
	{
	    $field = 'lastname';
	    
		$user = ORM::factory('user')
			->where($field, $username)
			->where('password',Mytool::hash($password))
			->where('active',0)
			->find();

		if($user->loaded)
		{
			return $user->id;
		}
		else
		{
			return 0;
		}
	}    
    
	/*
	 * 获取用户信息
	 * 
	 *  @param  	Int 	 用户id
	 *  @return 	array() 用户信息
	 */
	
	public function get($user_id) {
		$user = ORM::factory('user', $user_id);
		if ($user->loaded) {
			$userinfo = $user->as_array();
			if($userinfo['alipay_id'] != '' && $userinfo['alipay_id']  > 0) {
				$userinfo['lastname'] = $userinfo['real_name'];
				$userinfo['alipayfastlogin'] = true;
			}
		    return $userinfo;
		}
		return false;
	}

	
	/*
	 * 通过用户名获取用户信息
	 * 
	 *  @param  	Int 	 用户id
	 *  @return 	array() 用户信息
	 */
    public function get_search($lastname)
    {
        $user = ORM::factory('user');
        $result = $user->where('lastname', $lastname)->find();
        
        if ($user->loaded)
        {
            return $result->as_array();
        }
        else
        {
            return FALSE;
        }
    }
	
	/*
	 * 通过用户名和邮箱判断用户合法性
	 * 
	 * 
	 */
	 public function check_user($lastname,$email){
		 $user = ORM::factory('user');
		 $array = array(
			'lastname'	=>	$lastname,
			'email'	 	=>	$email
		 );

		 $result = $user->where($array)->find();

		 if($user->loaded)
		 {
			 return $result->as_array();
		 }else
		 {
			 			
			 return false;
		 }
	}
	
	
	/*
	 * 获取用户余额
	 * 
	 *  @param  	int 	 用户id
	 *  @return 	int 	余额
	 */
	public function get_user_money($user_id)
	{
	    $return = 0;
	    $money = $this->get_user_moneys($user_id);
	    
	    if (!empty($money))
	    {
	        $return = $money['all_money'];
	    }
	    return $return;
	}


	/*
	 * 获取用户所有余额
	 * 
	 *  @param  	int 	 用户id
	 *  @return 	array	
	 */
	public function get_user_moneys($user_id)
	{
	    $return = array();
	    $user = $this->get($user_id);
	    if (!empty($user))
	    {	
	    	if (isset($user['bonus_money'])) {
		        $return['user_money'] = $user['user_money'];
		        $return['bonus_money'] = empty($user['bonus_money']) ? 0 : $user['bonus_money'];
		        $return['free_money'] = empty($user['free_money']) ? 0 : $user['free_money'];
		        $return['all_money'] = $return['user_money'] + $return['bonus_money'] + $return['free_money'];
	    	}
	    	else {
	    		$return['all_money'] = $user['user_money'];
	    	}
	        return $return;
	    }
	    else
	    {
	        return $return;
	    }
	}
	
    /**
     * 用户注册处理
     * @param array $user
     * @param string $password
     */
	public static function register_process($user,$password)
	{
		//TODO add register log
		$return = 'register successfully';
		User_logService::instance($user['id'])->add('register',$return);
	  //  $data=array('user_money' => '100','free_money' => '100');
	//	self::edit($user['id'], $data);
		/* 注册邮件的参数结构 */
		$register_struct = array();
		$register_struct['user_id'] = $user['id'];
		$register_struct['password'] = $password;
		
//		mail::register($register_struct);
		
		//判断用户账号是否激活
		if($user['register_mail_active'])
		{
			user::login_process($user);
		}
	}
	
	/**
	 * 用户登录
	 * @param array $user
	 */
	public static function login_process($user)
	{
		$session = Session::instance();	
		$session->set('user',$user);

        $data = array();
        $data['id'] = $user['id'];
        $data['login_ip'] = Input::instance()->ip_address();
        $data['login_time'] = date('Y-m-d H:i:s',time());
        self::edit($data['id'], $data);
        
		//TODO add logining log
		$return = 'login successfully';
		UlogService::get_instance()->add($user['id'], 'login', $return);
	}
	
	public static function login_process_register($user)
	{
/*		$session = Session::instance();	
		$session->set('user',$user);*/
        $data = array();
        $data['id'] = $user['id'];
        $data['login_ip'] = Input::instance()->ip_address();
        $data['login_time'] = date('Y-m-d H:i:s',time());
        self::edit($data['id'], $data);
        
		//TODO add logining log
		//TODO add logining log
		$return = 'login successfully';
		UlogService::get_instance()->add($user['id'], 'login', $return);

	}

	/**
	 * edit user information
	 *
	 * @param   Array   $data
	 * @return 	Boolean
	 */
	public static function edit($uid, $data)
	{
		$uid = intval($uid);
		$user = ORM::factory('user', $uid);
		if($user->validate($data, TRUE))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}	
	
	
	/**
	 * 退出操作
	 */
	public static function logout_process()
	{
		$session = Session::instance();	
		$user = $session->get('user');
		$session->delete('user',NULL);
		//删除购物车中的相关信息
		$session->delete('coupon_code',NULL);
		$session->delete('cart',NULL);

		//TODO add logout log
		$return = 'logout successfully';
		UlogService::get_instance()->add($user['id'], 'logout', $return);
	}
	
	/**
	 * 用户找回密码
	 * @param int $user_id
	 * @param string $email
	 * @param string $token
	 */
	public static function find_password_process($user_id,$email,$username,$password){
		mail::find_password($user_id,$email,$username,$password);
	}
	
	/**
	 * 邮箱验证发送邮件
	 * @param int $user_id
	 * @param string $email
	 * @param string $token
	 */
	public static function check_email($user_id,$email,$key){
		mail::check_email($user_id,$email,$key);
	}
	
		/**
	 * 邮箱验证发送邮件
	 * @param int $user_id
	 * @param string $email
	 * @param string $token
	 */
	public static function check_register($uid,$email,$lastname,$key){
		mail::check_register($uid,$email,$lastname,$key);
	}
	
    /**
     * author zhubin
     * 根据注册项信息生成相应的html代码
     * @param $user_profile array  注册项信息
     * @param $class  string  css属性
     * return string
     */
    public static function show_view($user_attribute, $class=array())
    {
    	//补充css类选择器
        $default_class=array('text'=>'','select'=>'','radio'=>'','checkbox'=>'',
                            'required'=>'','numeric'=>'','string'=>'','numeric_string'=>'');
		$class = array_merge($default_class,$class);
        $type = kohana::config('user_attribute_type.attribute.'.$user_attribute['attribute_type']);
        $user_attribute['attribute_name'] = str_replace(' ','_',$user_attribute['attribute_name']);
        $html = '';
        if(!is_array($type['form']) && !empty($type['form']))
        {
            switch($type['form'])
            {
                case 'text':
                	$cla = $class[$type['form']];
                	if($user_attribute['attribute_required'])
                	{
                         $cla = $class[$type['form']].' '.$class['required'];
                	}
                	$name = $user_attribute['attribute_name'].'_'.$user_attribute['id'];
                	$attribute_type_arr = explode('.', $user_attribute['attribute_type']);
                	
                    if($attribute_type_arr[0] == 'time')
		            {//对时间的处理
		            	$html .= '<input type="'.$type['form'].'" name="'.$name.'" id="'.$name.'" class="'.$cla.'" value="'.$user_attribute['user_attribute_value'].'"/>';
	                    if($type['item'] == 'datepicker')
			            {
			            	$date_form = str_replace('_','-',$attribute_type_arr[1]);
			                $html .= "
			                <script type=\"text/javascript\">
			                $(document).ready(function(){
			                    $(\"#$name\").datepicker({
			                        changeMonth: true,
			                        changeYear: true,
			                        yearRange:\"1950:".date('Y',time())."\",
			                        dateFormat: \"$date_form\"
			                    });
			                });
			                </script>
			                ";
			            }
		            }else if($attribute_type_arr[0] == 'input'){
		              switch($attribute_type_arr[1])
		              {
		                  case 'numeric':
		                  	$cla .= ' '.$class['numeric'];
		                  	
		                  	break;
		                  case 'string':
		                  	$cla .= ' '.$class['string'];
		                  	break;
		                  case 'numeric_string':
		                  	$cla .= ' '.$class['numeric_string'];
		                  	break;
		                  default:
		                  	break;
		              }
		              $html .= '<input type="'.$type['form'].'" name="'.$name.'" id="'.$name.'" class="'.$cla.' length255" value="'.$user_attribute['user_attribute_value'].'"/>';
		            }else{
		            $html .= '<input type="'.$type['form'].'" name="'.$name.'" id="'.$name.'" class="'.$cla.' length255" value="'.$user_attribute['user_attribute_value'].'"/>';
		            }
                    break;
                case 'select':
                	$cla = $class[$type['form']];
                    if($user_attribute['attribute_required'])
                    {
                         $cla = $class[$type['form']].' '.$class['required'];
                    }
                    $attribute_options = explode(',', trim($user_attribute['attribute_option'], ','));
                    $name = $user_attribute['attribute_name'].'_'.$user_attribute['id'];
                    $html .= '<select name="'.$name.'"  class="'.$cla.'">';
                    foreach($attribute_options as $attribute_option)
                    {
                    	$selected = '';
                    	if($attribute_option==$user_attribute['user_attribute_value'])
                    	{
                    	   $selected='selected="selected"';
                    	}
                        $html .= '<option value="'.$attribute_option.'" '.$selected.'>'.$attribute_option.'</option>';
                    }
                    $html .= "</select>";

                    break;
                case 'radio':
                    $cla = $class[$type['form']];
                    if($user_attribute['attribute_required'])
                    {
                         $cla = $class[$type['form']].' '.$class['required'];
                    }
                    $name = $user_attribute['attribute_name'].'_'.$user_attribute['id'];
                    $attribute_options = explode(',', trim($user_attribute['attribute_option'], ','));
                    foreach($attribute_options as $attribute_option)
                    {
                        $checked = '';
                        if($attribute_option==$user_attribute['user_attribute_value'])
                        {
                           $checked='checked="true"';
                        }
                        $html .= $attribute_option.'<input type="'.$type['form'].'" name="'.$name.'" value="'.$attribute_option.'" '.$checked.' class="'.$cla.'"/>';
                    }
                    break;
                case 'checkbox':
                    $cla = $class[$type['form']];
                    if($user_attribute['attribute_required'])
                    {
                         $cla = $class[$type['form']].' '.$class['required'];
                    }
                    $name = $user_attribute['attribute_name'].'_'.$user_attribute['id'];
                    $attribute_options = explode(',', trim($user_attribute['attribute_option'], ','));
                    foreach($attribute_options as $attribute_option)
                    {
                        $checked = '';
                        if(!empty($user_attribute['user_attribute_value']))
                        {
	                        foreach($user_attribute['user_attribute_value'] as $option_value)
	                        {
		                        if($attribute_option==$option_value)
		                        {
		                           $checked='checked="true"';
		                           break;
		                        }
	                        }
                        }
                        $html .=$attribute_option.'<input type="'.$type['form'].'" name="'.$name.'[]" value="'.$attribute_option.'" '.$checked.' class="'.$cla.'"/>';
                    }
                    break;
                default:
                    break;
            }
        }
        return $html;
    }
    
    /**
     * 取得用户的等级
     */
    public static function user_level()
    {
    	$session = Session::instance();
    	$user = $session->get('user');
    	if(empty($user))
    	{
    		return false;
    	}else{
    		$user_level = User_levelService::get_instance()->get_level($user['level_id']);
    		return !empty($user_level['name'])?$user_level['name']:'';
    	}
    }
    
    /**
     * 取得用户的积分
     */
    public static function user_score()
    {
    	$session = Session::instance();
    	$user = $session->get('user');
    	if(empty($user))
    	{
    		return false;
    	}else{
    		return floor($user['score']);
    	}
    }
    
    
    /*
     * 更新用户资金  将返回用户总金额
     * @param	int	   $user_id   用户id
     * @param	array  $user_moneys 资金包 
     * @return  bool   true or false
     */
    public function update_moneys($user_id, $user_moneys)
    {
        try
        {
            $user_id = intval($user_id);
            
            if ( empty($user_id))
                return  FALSE;
                
                $userobj = ORM::factory('user', $user_id);
            	if ($userobj->loaded)
		        {
		            $userobj->user_money = $user_moneys['user_money'];
		            $userobj->bonus_money = $user_moneys['bonus_money'];
		            $userobj->free_money = $user_moneys['free_money'];
		            
		            $userobj->save();
		            if ($userobj->saved)
		            {
		                return TRUE;
		            }
		            else
		            {
		                return FALSE;
		            }
		        }
        }
        catch (MyRuntimeException $ex) 
        {
            return FALSE;
            //throw new MyRuntimeException('', 404);
        }
    }
    

    /*
     * 更新用户金额
     * 
     */
    public function update_money($user_id, $add_money)
    {
        try
        {
            $user_id = intval($user_id);
            
            if ( empty($user_id))
                return  FALSE;
                
                $userobj = ORM::factory('user', $user_id);
            	if ($userobj->loaded)
		        {
		            $userobj->user_money = $add_money;
		            $userobj->save();
		            if ($userobj->saved)
		            {
		                return TRUE;
		            }
		            else
		            {
		                return FALSE;
		            }
		        }
        }
        catch (MyRuntimeException $ex) 
        {
            return FALSE;
            //throw new MyRuntimeException('', 404);
        }                
                
                
    } 
    
    


	/**
	 * user register
	 *
	 * @param 	Array 	register data
	 * @return 	Int  	user id
	 */
	public function register($data)
	{
		$user = ORM::factory('user');
		$data['password'] = Mytool::hash($data['password']);
		if($user->validate($data, FALSE))
		{
			$user->save();
			return $user->id;
		}
		else
		{
			return FALSE;
		}
	}
    
	/**
	 * is the user reigstered?
	 *
	 * @param 	String 	email
	 * @return 	boolean|user id
	 */
	public function is_register($check, $type = 0)
	{
	    $field = 'email';
	    if ($type == 1)
	        $field = 'lastname';

		$user = ORM::factory('user')
			->where($field, $check)
			->find();
			
		//print $user->last_query();	

		if($user->loaded)
		{
			return $user->id;
		}
		else
		{
			return 0;
		}
	}
    
	
	/*
	 * 检查是否登录带提示
	 */
	public function check_login()
	{
	    $check = $this->check_user_login();
	    if (empty($check))
	    {
	        url::redirect('user/login?redirect='.url::current(TRUE));
	    }
	}
	
	
	/*
	 * 检查是否登录
	 */
	public  function check_user_login()
	{
	    $user = Session::instance()->get('user');
	    
	    //print_r($user);
	    
	    if (empty($user))
	    {
	        return FALSE;
	    }
	    else 
	    {
	        $user = $this->get($user['id']);
	        
	        if (empty($user))
	        {
	            return FALSE;
	        }
	        else
	        {
    	        if ($user['active'] != 1)
    	        {   
    	            $this->logout_process();
    	            return FALSE;
    	        }
    	        else 
    	        {
    	            return $user['id'];
    	        }	            
	        }
	    }
	}


    /**
	 * 验证用户密码
	 *
	 * @param 	Str $password
	 * @return 	Boolean
	 */
	public function check_password($uid, $password)
	{
	    $user = ORM::factory('user')
			->where('id', $uid)
			->where('password',tool::hash($password))
			->find();
		if($user->loaded)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}	
	
	//验证用户提现密码
	public function check_draw_password($uid, $password)
	{
		$user = ORM::factory('user')
				->where('id',$uid)
				->where('draw_password',tool::hash($password))
				->find();
		
		if($user->loaded)
		{
			return true;
		}else{
			return false;
			}
	}
	
	/**
	 * update user password
	 *
	 * @param 	Str 	$password
	 * @return 	Int 	user id | 0
	 */
	public function update_password($uid, $password)
	{
		$user = ORM::factory('user', $uid);
		if($user->loaded)
		{
			$user->password = tool::hash($password);
			$user->save();
			$this->data = $user->as_array();
			return $user->id;
		}
		else
		{
			return 0;
		}
	}
	
	//更新用户提现密码
	public function update_draw_password($uid, $password)
	{
		$userobj = ORM::factory('user', $uid);
		
		print $password;
		
		if($userobj->loaded)
		{
			$userobj->draw_password = tool::hash($password);
			$userobj->save();
		    return $userobj->id;
		}
		else
		{
			return 0;
		}
	}
	
	/**
	 * 更新用户密码保护信息
	 * Enter description here ...
	 * @param int $uid
	 * @param int $question
	 * @param string $answer
	 * @return true/false
	 */
	public function update_password_protection($uid, $question, $answer) {
		$return = false;
		$user = ORM::factory('user', $uid);
		if ($user->loaded) {
			$user->question = $question;
			$user->answer = $answer;
			$user->save();
			if ($user->saved == true) {
				$this->data = $user->as_array();
				$return = true;
			}
		}
		return $return;
	}
	
	/**
	 * 更新用户信息
	 * Enter description here ...
	 * @param int $uid
	 * @param array $data
	 * @return true/false
	 */
	public function update_user_info($uid, $data) {
		$return = false;
		$user = ORM::factory('user', $uid);
		if ($user->loaded) {
			$user->real_name = $data['real_name'];
			$user->email = $data['email'];
			$user->identity_card = $data['identity_card'];
			$user->sex = $data['sex'];
			$user->address = $data['address'];
			$user->zip_code = $data['zip_code'];
		//	$user->tel = $data['tel'];
			$user->mobile = $data['mobile'];
			$user->birthday = $data['birthday'];
			$user->save();
			if ($user->saved == true) {
				$this->data = $user->as_array();
				$return = true;
			}
		}
		return $return;
	}
	
	/**
	 * 更新用户身份认证信息
	 * Enter description here ...
	 * @param unknown_type $userid
	 * @param unknown_type $order_no
	 * @param unknown_type $data
	 */
	public function update_user_auth($userid, $order_no, $data, $auth) {
		$return = false;
		$user = ORM::factory('user', $userid);
		if ($user->loaded) {
			$user->auth_order_no = $order_no;
			$user->real_name = $data['real_name'];
			$user->identity_card = $data['identity_card'];
			$user->is_auth = $auth;
			$user->save();
			if ($user->saved == true) {
				$this->data = $user->as_array();
				$return = true;
			}
		}
		return $return;
	}
	
	/**
	 * 更新用户状态
	 * Enter description here ...
	 * @param int $uid
	 * @param array $data
	 * @return true/false
	 */
	public function update_user($uid, $data) {
		$return = false;
		$user = ORM::factory('user', $uid);
		if ($user->loaded) {
			$user->active = $data['active'];
			$user->save();
			if ($user->saved == true) {
				$this->data = $user->as_array();
				$return = true;
			}
		}
		return $return;
		
	}
	
	
		/**
	 * 更新用户信息
	 * Enter description here ...
	 * @param int $uid
	 * @param array $data
	 * @return true/false
	 */
	public function update_user_free_money($uid, $data) {
		$return = false;
		$user = ORM::factory('user', $uid);
		if ($user->loaded) {
		//	$user->user_money = $data['user_money'];
			$user->free_money = $data['free_money'];
		//	$user->title = $data['free_money'];
		//	$data=array('user_money' => '100','free_money' => '100');
			$user->save();
			if ($user->saved == true) {
				$this->data = $user->as_array();
				$return = true;
			}
		}
		return $return;
	}
	
		/**
	 * 更新用户信息
	 * Enter description here ...
	 * @param int $uid
	 * @param array $data
	 * @return true/false
	 */
	public function update_question_info($uid, $data) {
		$return = false;
		$user = ORM::factory('user', $uid);
		if ($user->loaded) {
			$user->question = $data['question'];
			$user->answer = $data['answer'];
			$user->save();
			if ($user->saved == true) {
				$this->data = $user->as_array();
				$return = true;
			}
		}
		return $return;
	}
	
	
	/*
	 * 用户支付并返回订单号
	 * @param $user_id int 
	 * @param $price int
	 * @return string 订单号
	 */
	public function get_user_charge_order($user_id, $price, $bankname = NULL)
	{
	    $obj = ORM::factory('user_charge_order');
	    $ordernum = '';
        do
        {
            $ordernum = date('YmdHis') .rand(0, 99999);
            if(!$this->charge_exist($ordernum))
                break;
        }
        while (1);
        
        $obj->status = 0;
        $obj->user_id = $user_id;
        $obj->money = $price;
        $obj->bankname = $bankname;
        $obj->order_num = $ordernum;
        $obj->ip = tool::get_str_ip();
        $obj->save();
        
        return $ordernum;	    
	    
	}
    
    /*
     * 检查订单号,存在则返回订单信息
     * @param $order_num string 订单号
     * @return true or false
     */
    public function charge_exist($order_num)
    {
        $obj = ORM::factory('user_charge_order');
        $result = $obj->where('order_num', $order_num)->find();
        
        if ($obj->loaded)
        {
            return $result->as_array();
        }
        else
        {
            return FALSE;
        }
    }	
	
    
    /*
     * 更新订单状态,诸如充值成功或失败
     * @param order_num string 订单号
     * @return status 状态 0,1,2
     */
    public function charge_update($order_num, $status, $ret_order_num = NULL)
    {
        $obj = ORM::factory('user_charge_order');
        $result = $obj->where('order_num', $order_num)->find();
        
        if ($obj->loaded)
        {
            $obj->status = $status;
            $obj->ret_order_num = $ret_order_num;
            $obj->ret_time = tool::get_date();
            $obj->save();
        }
        else
        {
            return FALSE;
        }
    }
    
    
    /*
     * 统计统一ip注册数量
     * 
     */
    public function get_count_ip($ip)
    {
        $obj = ORM::factory('user');
        $obj->where("ip", $ip)->where('check_status', 2);
        return $obj->count_all();
    }
	
    /*
	* 用户资料修改验证邮箱
	*/
    public function validator_email($email){
		$session = Session::instance();
		$user = $session->get('user');
		$userinfo = self::get($user['id']);
		if($email!=$userinfo['email'])
		{
		  $isReg = self::is_register($email); 
		  if($isReg)
		  {
			   return false;  
		  }
		}
		return true;
	}
	public function chkinvitecode($invitecode)
    {
    	$agentDao = Myagent::instance();
		$t_agent = $agentDao->get_by_invitecode($invitecode);
		return $t_agent;
    }
	/*
	* 用户邀请码输入加入代理
	*/
    public function invitecodeinput($invitecode, $p_user_id = null)
    {
    	$invitecode = trim($invitecode);
    	if (empty($invitecode)){
    		return 1;
    	}
    	if (empty($p_user_id)){
	    	$session = Session::instance();
			$user = $session->get('user');
			$userinfo = self::get($user['id']);
	    	$p_user_id = $user['id'];
    	}
//d('asdf',false);    	
		$where = array();
		$agentDao = Myagent::instance();
//d($invitecode,false);
		$t_agent = $agentDao->get_by_invitecode($invitecode);
//d($t_agent,false);
		if (!$t_agent){
			return 1;
		}
		$relDao = Myrelation::instance();
		$t_oldrel = $relDao->get_by_clientid($p_user_id,2);
		$t_oldrel2 = $relDao->get_by_agentid_userid($t_agent['user_id'], $p_user_id);
	
		if ($t_oldrel){
			return 9;
			if ($t_oldrel['agentid'] == $t_agent['user_id']){
				return 3;
			}
			$t_oldrel['flag'] = 3;
			$t_oldrel['date_end'] = date('Y-m-d H:i:s',time());
			$relDao->edit($t_oldrel);
		}
		if ($t_oldrel2){
			$t_oldrel2['flag'] = 2;
			$t_oldrel2['date_add'] = date('Y-m-d H:i:s',time());
			$t_oldrel2['date_end'] = '2080-01-01 00:00:00';
			$relDao->edit($t_oldrel2);
		}else{
			$t_newrel = array();
			$t_newrel['agentid'] = $t_agent['user_id'];
			$t_newrel['user_id'] = $p_user_id;
			$t_newrel['flag'] = 2;
			$t_newrel['date_add'] = date('Y-m-d H:i:s',time());
			$t_newrel['adminid'] = 0;
			$retxx = $relDao->add($t_newrel);
			if (!retxx){
				return 5;
			}
		}
		return 0;
	}
	
	/**
	 * 更新用户点数
	 * Enter description here ...
	 * @param unknown_type $userid
	 * @param unknown_type $score
	 */
	public function update_user_score($user_id, $score) {
		$user_id = intval($user_id);
		if (empty($user_id)) {
			return  FALSE;
		}
		$userobj = ORM::factory('user', $user_id);
		if ($userobj->loaded) {
			$userobj->score = $score;
			$userobj->save();
			if ($userobj->saved) {
				return TRUE;
			}
			else {
				return FALSE;
			}
		}
	}
	
	/**
	 * 获得用户点数
	 * Enter description here ...
	 * @param unknown_type $user_id
	 */
	public function get_user_score($user_id)
	{
	    $return = 0;
	    $user = $this->get($user_id);
	    if (!empty($user))
	    {
	        $return = $user['score'];
	    }
	    return $return;
	}
	
	/**
	 * 更新用户虚拟资金
	 * @param unknown_type $user_id
	 * @param unknown_type $add_money
	 */
	public function update_virtual_money($user_id, $add_money)
	{
		try
		{
			$user_id = intval($user_id);
	
			if ( empty($user_id))
				return  FALSE;
	
			$userobj = ORM::factory('user', $user_id);
			if ($userobj->loaded)
			{
				$userobj->virtual_money = $add_money;
				$userobj->save();
				if ($userobj->saved)
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
		}
		catch (MyRuntimeException $ex)
		{
			return FALSE;
			//throw new MyRuntimeException('', 404);
		}
	}
	
	public function is_alipay_register($alipay_id) {
		$user = ORM::factory('user')
		->where('alipay_id', $alipay_id)
		->find();
		if($user->loaded)
		{
			return $user->id;
		}
		else
		{
			return false;
		}
	}
	
	public function email_available($email) {
		if (!ereg("^([a-zA-Z0-9\._-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+",$email)) {
			return false;
		}
		list($Username, $Domain) = split("@",$email);
		$MXHost = array();
		if(getmxrr($Domain, $MXHost)) {
			//d($MXHost);
			return true;
		}
		else {
			if(fsockopen($Domain, 25, $errno, $errstr, 30)) {
				return true;
			}
			else {
				return false;
			}
		}
	}
	
}