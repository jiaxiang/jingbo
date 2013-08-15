<?php defined('SYSPATH') OR die('No direct access allowed.');

class Site_detail_Model extends ORM {

    protected $belongs_to = array('site');

    /**
     * Validates and optionally saves a new user record from an array.
     *
     * @param  array    values to check
     * @param  boolean  save the record when validation succeeds
     * @return boolean
     */
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
        $fields = parent::as_array();
        $array = array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('page_count','required','numeric')
            ->add_rules('css', 'length[1,65535]')
            ->add_rules('https', 'numeric');

		if(parent::validate($array, $save)) 
		{
            return TRUE;
		}
		else
		{
            $errors = $array->errors();
            return FALSE;
        }
    }
}
?>
