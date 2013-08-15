<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: order_refund_log.php 169 2009-12-21 02:13:58Z hjy $
 * $Author: hjy $
 * $Revision: 169 $
 */

class Order_refund_log_Model extends ORM {

	protected $belongs_to = array('site','order');

    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
			->add_rules('refund_num','required','length[1,200]')
            ->add_rules('order_id','required','numeric')
            ->add_rules('user_id','required','numeric')
			->add_rules('manager_id','required','numeric')
			->add_rules('email','length[0,255]')
            ->add_rules('reason_id','numeric')
            ->add_rules('refundmethod_id','numeric')
            ->add_rules('currency','length[0,20]')
			->add_rules('refund_status_id','required','numeric')
            ->add_rules('content_user','length[0,1000]')
            ->add_rules('content_admin','length[0,1000]')
            ->add_rules('refund_amount','required','length[0,200]')
			->add_rules('is_send_email','numeric')
			->add_rules('date_add','length[0,1000]');


        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors =kohana::debug($array->errors());
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}

