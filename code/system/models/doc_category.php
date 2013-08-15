<?php defined('SYSPATH') OR die('No direct access allowed.');

class Doc_category_Model extends ORM {

	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save the record when validation succeeds
	 * @return boolean
	 */
	public function validate(array $array, $save = FALSE, & $errors)
	{
		$fields = parent::as_array();
		$array = array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('parent_id', 'numeric')
			->add_rules('level_depth','numeric')
			->add_rules('cat_path','length[0,255]')
			->add_rules('is_leaf','length[0,255]')
			->add_rules('category_name','required','length[0,255]')
			->add_rules('p_order', 'numeric')
			->add_rules('doc_count', 'numeric')
			->add_rules('addon', 'length[0,65535]')
			->add_rules('child_count', 'numeric')
			->add_rules('active', 'numeric');

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

