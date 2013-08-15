<?php defined('SYSPATH') OR die("No direct access allowed.");

class Coupon_Model extends ORM
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
            			->add_rules('cpn_name','required', 'length[0,255]')
            			->add_rules('cpn_prefix','required', 'length[0,255]')
            			->add_rules('cpn_gen_quantity', 'length[0,255]')
            			->add_rules('cpn_key', 'length[0,255]')
            			->add_rules('used_times', 'length[0,255]')
            			->add_rules('cpn_type','required', 'length[0,255]')
            			->add_rules('with_pmt','required', 'length[0,255]')
            			->add_rules('cpn_time_begin', 'required', 'length[1,200]')
            			->add_rules('cpn_time_end', 'required', 'length[1,200]')
            			->add_rules('disabled', 'required', 'numeric');
        
        if ( parent::validate($array, $save) ) {
            return TRUE;
        } else {
            $errors = $array->errors();
            return FALSE;
        }
    }
}