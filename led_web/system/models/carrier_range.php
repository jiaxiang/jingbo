<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: order_history.php 223 2010-01-08 01:19:27Z zzy $
 * $Author: zzy $
 * $Revision: 223 $
 */

class Carrier_range_Model extends ORM {

	protected $belongs_to = array('site','carrier');

    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('id','numeric')
            ->add_rules('carrier_id','required','numeric')
            ->add_rules('parameter_from','required','numeric')
            ->add_rules('parameter_to','required','numeric')
            ->add_rules('shipping','required','numeric')
            ->add_rules('position','required','numeric');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}

