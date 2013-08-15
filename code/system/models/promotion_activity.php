<?php defined('SYSPATH') OR die("No direct access allowed.");

class Promotion_activity_Model extends ORM
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
            			->add_rules('pmta_name','required', 'length[0,255]')
            			->add_rules('pmta_time_begin', 'length[1,200]')
            			->add_rules('pmta_time_end', 'length[1,200]')
            			->add_rules('meta_title', 'required', 'length[0,255]')
            			->add_rules('frontend_description', 'length[0,65535]')
            			->add_rules('banner', 'length[0,255]');
        
        if ( parent::validate($array, $save) ) {
            return TRUE;
        } else {
            $errors = $array->errors();
            return FALSE;
        }
    }
}
