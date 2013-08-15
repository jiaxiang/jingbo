<?php defined('SYSPATH') OR die("No direct access allowed.");

class Promotion_Model extends ORM
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
            			->add_rules('pmts_id', 'required', 'numeric')
            			->add_rules('pmta_id', 'required', 'numeric')
            			->add_rules('time_begin', 'required', 'length[0,65535]')
            			->add_rules('time_end', 'required', 'length[0,65535]')
            			->add_rules('related_ids', 'length[0,65535]')
            			->add_rules('money_from', 'numeric')
            			->add_rules('money_to', 'numeric')
            			->add_rules('pmt_description','required', 'length[0,255]')
            			->add_rules('pmt_des_extra', 'length[0,65535]')
            			->add_rules('discount_type', 'numeric')
            			->add_rules('price', 'numeric')
            			->add_rules('quantity_from', 'numeric')
            			->add_rules('quantity_to', 'numeric')
            			->add_rules('gift_related_ids', 'length[0,65535]')
            			->add_rules('disabled', 'numeric');
            
        if ( parent::validate($array, $save) ) {
            return TRUE;
        } else {
            $errors = $array->errors();
            return FALSE;
        }
    }
}
