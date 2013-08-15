<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: order_history.php 223 2010-01-08 01:19:27Z zzy $
 * $Author: zzy $
 * $Revision: 223 $
 */

class Payment_status_return_log_Model extends ORM {

	protected $belongs_to = array('site','order_status');

    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('pay_id','required','numeric')
            ->add_rules('secure_code','length[0,200]')
            ->add_rules('order_num','required','length[1,200]')
            ->add_rules('order_status_id','required','numeric')
            ->add_rules('payment_status_id','required','numeric')
            ->add_rules('trans_id','length[0,200]')
            ->add_rules('admin_employee_name','length[0,200]')
            ->add_rules('context','length[0,20000]')
            ->add_rules('api','length[0,200]')
            ->add_rules('refund_amount','numeric')
            ->add_rules('currency','length[0,200]');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors =kohana::debug($array->errors());
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}

