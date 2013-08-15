<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: order_history.php 223 2010-01-08 01:19:27Z zzy $
 * $Author: zzy $
 * $Revision: 223 $
 */

class Payment_Model extends ORM {

	protected $belongs_to = array('payment_type','manager');
    protected $has_and_belongs_to_many = array('sites');

    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('payment_type_id','required','numeric')
            ->add_rules('manager_id','required','numeric')
            ->add_rules('active', 'numeric')
            ->add_rules('account','length[0,200]')
            ->add_rules('args', 'length[0,65535]');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors =kohana::debug($array->errors());
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}

