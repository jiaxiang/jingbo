<?php defined('SYSPATH') OR die('No direct access allowed.');

class Tt_Model extends ORM {

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
            ->add_rules('key','required','length[1,200]')
            ->add_rules('created','required','length[1,255]')
            ->add_rules('file',  'required', 'length[1,65535]')
            ->add_rules('type', 'required', 'length[1,255]')
            ->add_rules('memo','length[0,255]');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
            return FALSE;
        }
    }
}
?>
