<?php defined('SYSPATH') OR die('No direct access allowed.');

class Product_merge_Model extends ORM {
    /**
     * Validates and optionally saves a new user record from an array.
     *
     * @param  array    values to check
     * @param  boolean  save the record when validation succeeds
     * @return boolean
     */
	/**
    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('default_category_id','required','numeric')
            ->add_rules('feature_type_id','numeric')
            ->add_rules('name','required','length[1,255]')
            ->add_rules('name_url','required','length[1,255]')
            ->add_rules('name_cn','length[0,255]')
            ->add_rules('SKU','required','length[1,255]')
            ->add_rules('on_sale','required', 'numeric')
            ->add_rules('price','required', 'numeric')
            ->add_rules('market_price','required', 'numeric')
            ->add_rules('weight', 'numeric')
            ->add_rules('profit', 'numeric')
            ->add_rules('description', 'length[0,65535]')
            ->add_rules('description_short', 'length[0,65535]')
            ->add_rules('meta_title','length[0,255]')
            ->add_rules('meta_keywords','length[0,255]')
            ->add_rules('meta_description', 'length[0,65535]')
            ->add_rules('date_add','required','length[1,255]')
            ->add_rules('date_upd','required','length[1,255]');
        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
            return FALSE;
        }
    }
	*/

}