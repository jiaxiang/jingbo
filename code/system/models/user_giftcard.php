<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: order_history.php 223 2010-01-08 01:19:27Z zzy $
 * $Author: zzy $
 * $Revision: 223 $
 */

class User_giftcard_Model extends ORM {

    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('status','numeric')
            ->add_rules('need_invoice','numeric')
            ->add_rules('invoice_type','numeric')
            ->add_rules('product_id','numeric')
            ->add_rules('price','numeric')
            ->add_rules('password','required','length[1,20]')
            ->add_rules('mobile','required','length[0,11]')
            ->add_rules('invoice_title', 'length[0,100]')
            ->add_rules('invoice_memo', 'length[0,255]');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}

