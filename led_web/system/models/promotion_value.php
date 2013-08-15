<?php defined("SYSPATH") or die("No direct access allowed.");

class Promotion_value_Model extends ORM
{
   /**
     * Validates and optionally saves a new user record from an array.
     *
     * @param  array    values to check
     * @param  boolean  save the record when validation succeeds
     * @return boolean
     */
    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);
        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('promotion_id','required','numeric')
            ->add_rules('discount_type','numeric')
            ->add_rules('discount_value', 'numeric')
            ->add_rules('int_1', 'numeric')
			->add_rules('int_2', 'numeric')
			->add_rules('int_3', 'numeric')
			->add_rules('float_1', 'numeric')
			->add_rules('float_2', 'numeric'); 
        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
            return FALSE;
        }
    }


	
}


