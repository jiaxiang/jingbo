<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: order_history.php 223 2010-01-08 01:19:27Z zzy $
 * $Author: zzy $
 * $Revision: 223 $
 */

class Order_return_log_Model extends ORM {
    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
			->add_rules('return_num','required','length[1,200]')
            ->add_rules('order_id','required','numeric')
			->add_rules('manager_id','required','numeric')
            ->add_rules('carrier_id','numeric')
			->add_rules('email','required','length[0,255]')
            ->add_rules('currency','length[0,20]')
            ->add_rules('total_shipping','numeric')
            ->add_rules('content_admin','length[0,1000]')
            ->add_rules('content_user','length[0,1000]')
            ->add_rules('return_status_id','required','length[0,20]')
			->add_rules('return_data','required','length[0,1024]')
			->add_rules('date_add','length[1,200]');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors =kohana::debug($array->errors());
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}

