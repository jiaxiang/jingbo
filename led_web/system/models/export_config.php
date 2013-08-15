<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: order_product.php 169 2009-12-21 02:13:58Z hjy $
 * $Author: hjy $
 * $Revision: 169 $
 */

class Export_config_Model extends ORM {

    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('filed','required','length[1,200]')
            ->add_rules('name','required','length[1,200')
            ->add_rules('show','required','length[1,200')
            ->add_rules('parent','length[0,200');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}

