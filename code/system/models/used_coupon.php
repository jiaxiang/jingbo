<?php defined('SYSPATH') OR die("No direct access allowed.");

class Used_coupon_Model extends ORM
{
    /**
     * Validates and optionally saves a new user record from an array.
     *
     * @param  array    values to check
     * @param  boolean  save the record when validation succeeds
     * @return boolean
     */
    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields = parent::as_array();
        $array = array_merge($fields, $array);
        
        $array = Validation::factory($array)
            			->pre_filter('trim')
            			->add_rules('cpn_id', 'required', 'length[0,255]')
            			->add_rules('serial_no', 'required', 'length[0,255]')
            			->add_rules('used_at', 'required', 'length[0,255]');
        
        if ( parent::validate($array, $save) ) {
            return TRUE;
        } else {
            $errors = $array->errors();
            return FALSE;
        }
    }
}