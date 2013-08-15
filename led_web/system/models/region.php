<?php defined('SYSPATH') OR die('No direct access allowed.');

class Region_Model extends ORM {
    
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
            ->add_rules('package','length[1,255]')
            ->add_rules('local_name','required','length[1,255]')
            ->add_rules('en_name', 'length[1,255]')
            ->add_rules('p_region_id','numeric')
            ->add_rules('position','numeric')
            ->add_rules('region_grade','numeric')
            ->add_rules('region_path','length[1,255]')
            ->add_rules('disabled','length[1,20]');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
            return FALSE;
        }
    }
}
