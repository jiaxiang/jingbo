<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: order_history.php 223 2010-01-08 01:19:27Z zzy $
 * $Author: zzy $
 * $Revision: 223 $
 */

class Contact_us_Model extends ORM {

	protected $belongs_to = array('site');

    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('status', 'numeric')
            ->add_rules('is_receive', 'numeric')
            ->add_rules('from_user_id', 'numeric')
            ->add_rules('to_user_id', 'numeric')
            ->add_rules('email', 'email')
            ->add_rules('name','length[0,200]')
            ->add_rules('message','length[0,2048]')
            ->add_rules('return_message','length[0, 2048]')
            ->add_rules('ip', 'numeric')
            ->add_rules('active','numeric');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}

