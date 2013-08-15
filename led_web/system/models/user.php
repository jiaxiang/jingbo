<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: order_history.php 223 2010-01-08 01:19:27Z zzy $
 * $Author: zzy $
 * $Revision: 223 $
 */

class User_Model extends ORM {

	//protected $belongs_to = array('site');

    public function validate(array & $array, $save = FALSE, & $errors='') {
        $fields=parent::as_array();
        
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
			->add_rules('user_money','numeric')
			->add_rules('bonus_money','numeric')
			->add_rules('free_money','numeric')
			->add_rules('virtual_money','numeric')
            ->add_rules('active','numeric')
            ->add_rules('invite_user_id','numeric')
            ->add_rules('score','numeric')
            ->add_rules('register_mail_active','numeric')
            ->add_rules('level_id','numeric')
            ->add_rules('email','length[1,50]')
            ->add_rules('password', 'length[0,60]')
			->add_rules('draw_password', 'length[0,60]')
            ->add_rules('firstname','length[0,50]')
            ->add_rules('lastname', 'required' ,'length[0,50]')
			->add_rules('title','length[0,100]')
			
            ->add_rules('login_ip', 'length[1,20]')
            ->add_rules('ip', 'length[1,20]')
            ->add_rules('login_time', 'length[1,100]')
			->add_rules('remark','length[0,1024]')
			->add_rules('question','length[0,4]')
			->add_rules('answer','length[0,100]')
			
			->add_rules('real_name','length[1,50]')
			->add_rules('identity_card','length[15,18]')
			->add_rules('birthday','length[0,10]')
			->add_rules('sex','length[1]')
			->add_rules('address','length[0,300]')
			->add_rules('zip_code','length[0,10]')
			->add_rules('tel','length[0,200]')
			->add_rules('mobile','length[0,11]')
			
			->add_rules('province','length[0,100]')
			->add_rules('check_status','length[0,10]')
			->add_rules('city','length[0,200]')
			->add_rules('from_domain','length[0,500]')
        	->add_rules('alipay_id','length[0,20]');
			
        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}

