<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: order_history.php 223 2010-01-08 01:19:27Z zzy $
 * $Author: zzy $
 * $Revision: 223 $
 */

class Carrier_Model extends ORM {

	protected $belongs_to = array('site');

    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('name','required','length[1,200]')
            ->add_rules('url','length[0,200]')
            ->add_rules('delay','required','length[0,200]')
            ->add_rules('type','required','numeric')
            ->add_rules('price','numeric')
            ->add_rules('country_relative','required','numeric')
            ->add_rules('position','numeric')
            ->add_rules('active','required','numeric');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}

