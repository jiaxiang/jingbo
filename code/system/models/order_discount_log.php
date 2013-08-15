<?php defined('SYSPATH') OR die('No direct access allowed.');

class Order_discount_log_Model extends ORM {
    /**
     * Validates and optionally saves a new user record from an array.
     *
     * @param  array    values to check
     * @param  boolean  save the record when validation succeeds
     * @return boolean
     */
    public function validate(array & $array, $save = FALSE, & $errors)
	{
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('order_id','required','numeric')
            ->add_rules('discount_type_id','required','numeric')
            ->add_rules('discount_type','required','numeric')
            ->add_rules('discount_value','required','numeric')
            ->add_rules('description','length[0,255]')
            ->add_rules('reference','length[,200000]');

        if(parent::validate($array, $save))
		{
            return TRUE;
        }
		else
		{
            $errors = $array->errors();
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}

