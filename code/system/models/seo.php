<?php defined('SYSPATH') OR die('No direct access allowed.');

class Seo_Model extends ORM {

	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save the record when validation succeeds
	 * @return boolean
	 */
	public function validate(array & $array, $save = FALSE)
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('title',  'length[0,255]')
			->add_rules('description',  'length[0,1024]')
			->add_rules('keywords',  'length[0,1024]')
			->add_rules('index_title',  'length[0,255]')
			->add_rules('index_description',  'length[0,1024]')
			->add_rules('index_keywords',  'length[0,1024]')
			->add_rules('seowords',  'length[0,1024]' );

		if(parent::validate($array, $save))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
} 

