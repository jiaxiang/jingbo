<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: order_history.php 223 2010-01-08 01:19:27Z zzy $
 * $Author: zzy $
 * $Revision: 223 $
 */

class Payment_jump_return_log_Model extends ORM {

	protected $belongs_to = array('site');

    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('pay_id','required','numeric')
            ->add_rules('verify_code','length[0,200]')
            ->add_rules('order_num','required','length[1,200]')
            ->add_rules('amount','length[0,200]')

            ->add_rules('trans_id','length[0,200]')
            ->add_rules('message','length[0,200]')
            ->add_rules('avs','length[0,200]')
            ->add_rules('api','length[0,200]')
            ->add_rules('status','length[0,200]')
            ->add_rules('order_status_id','numeric')
            ->add_rules('billing_firstname','length[0,200]')
            ->add_rules('billing_lastname','length[0,200]')
            ->add_rules('billing_address','length[0,200]')
            ->add_rules('billing_zip','length[0,200]')
            ->add_rules('billing_city','length[0,200]')
            ->add_rules('billing_state','length[0,200]')
            ->add_rules('billing_country','length[0,200]')
            ->add_rules('billing_phone','length[0,200]')
            ->add_rules('billing_ip','length[0,200]')
            ->add_rules('billing_email','length[0,200]')
            ->add_rules('post','length[0,20000]');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors =kohana::debug($array->errors());
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}

