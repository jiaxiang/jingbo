<?php defined('SYSPATH') OR die('No direct access allowed.');

class Feature_group_type_Model extends ORM {
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
            ->add_rules('type','required','length[1,255]')
            ->add_rules('feature_group_id','required','numeric')
            ->add_rules('description','length[0,255]')
            ->add_rules('active','numeric');
        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
            return FALSE;
        }
    }
}
?>
