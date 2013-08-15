<?php defined('SYSPATH') OR die('No direct access allowed.');

class Domain_Model extends ORM {
    protected $belongs_to = array('domain_api','manager','site');
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
			->add_rules('sld','required','length[1,255]')
			->add_rules('tld','required','length[1,255]')
			->add_rules('reg_year','required','numeric')
			->add_rules('manager_id','required','numeric')
			->add_rules('domain_api_id','required','numeric');

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}
