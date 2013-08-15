<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Model extends ORM {
	protected $has_many = array("roles");
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
			->add_rules('name','required','length[1,200]')
			->add_rules('flag','required','length[1,200]')
			->add_rules('order', 'numeric')
			->add_rules('active', 'numeric')
			->add_rules('memo', 'length[0,255]');

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}
?>
