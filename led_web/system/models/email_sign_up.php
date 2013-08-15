<?php defined('SYSPATH') OR die('No direct access allowed.');

class Email_sign_up_Model extends ORM {
    protected $belongs_to = array('site');
    /**
     * Validates and optionally saves a new record from an array.
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
            ->add_rules('email','required','length[0,255]')
            ->add_rules('firstname','length[0,50]')
            ->add_rules('lastname','length[0,50]')
			->add_rules('birthday','length[0,50]')
            ->add_rules('ip','length[0,50]')
            ->add_rules('active', 'numeric');

		if(parent::validate($array, $save)) 
		{
            return TRUE;
		}
		else
		{
            $errors =kohana::debug($array->errors());
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}
?>
