<?php defined('SYSPATH') OR die('No direct access allowed.');

class Product_comment_Model extends ORM {
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
            ->add_rules('product_id','required','numeric')
            ->add_rules('title','required','length[1,10]')
            ->add_rules('name','required','length[1,255]')
            ->add_rules('email','required','length[1,255]')
            ->add_rules('grade','required', 'numeric')
            ->add_rules('content', 'length[1,65535]')
            ->add_rules('date_add','required','length[1,255]')
            ->add_rules('date_upd','required','length[1,255]')
            ->add_rules('ip','required', 'numeric')
            ->add_rules('active','required', 'numeric');
        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
            return FALSE;
        }
    }


}
?>
