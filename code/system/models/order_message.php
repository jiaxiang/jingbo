<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: order_refund_log.php 169 2009-12-21 02:13:58Z hjy $
 * $Author: hjy $
 * $Revision: 169 $
 */

class Order_message_Model extends ORM {

	protected $belongs_to = array('order','site','manager');

    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
			->add_rules('order_id', 'required', 'numeric')
            ->add_rules('manager_id', 'numeric')
            ->add_rules('type','numeric')
            ->add_rules('message','length[0,2000]')
            ->add_rules('ip','numeric', 'required')
            ->add_rules('active','numeric');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors =$array->errors();
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }

}

