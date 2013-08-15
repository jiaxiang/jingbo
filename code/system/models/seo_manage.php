<?php defined('SYSPATH') OR die('No direct access allowed.');

class Seo_manage_Model extends ORM {
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
            ->add_rules('parent_id','required','numeric')
            ->add_rules('meta_title','length[0,255]')
            ->add_rules('meta_keywords','length[0,255]')
            ->add_rules('meta_description', 'length[0,65535]');
        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
            return FALSE;
        }
    }
}
?>
