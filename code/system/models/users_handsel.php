<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: order_history.php 223 2010-01-08 01:19:27Z zzy $
 * $Author: zzy $
 * $Revision: 223 $
 */

class Users_handsel_Model extends ORM {

	//protected $belongs_to = array('site');

    public function validate(array & $array, $save = FALSE, & $errors='') {
        $fields=parent::as_array();
        
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('uid','length[1,11]')
            ->add_rules('identity_card','length[15,18]')
            ->add_rules('mobile','length[0,11]')
            ->add_rules('email','length[1,50]')
            ->add_rules('ip', 'length[1,20]')
			->add_rules('real_name','length[1,50]')
			->add_rules('lastname','length[0,50]');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}

