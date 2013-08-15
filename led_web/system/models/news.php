<?php defined('SYSPATH') OR die('No direct access allowed.');

class News_Model extends ORM {

	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save the record when validation succeeds
	 * @return boolean
	 */
	public function validate(array & $array, $save = FALSE)
	{
		$fields = parent::as_array();
		$array = array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('title', 'required', 'length[0,255]')
			->add_rules('content','required', 'length[0,65535]')
			->add_rules('order', 'numeric')
			->add_rules('click', 'numeric')
			->add_rules('classid', 'numeric')
			->add_rules('list1', 'numeric')
			->add_rules('list2', 'numeric')
			->add_rules('zxtj', 'numeric')
			->add_rules('indextj', 'numeric')
			->add_rules('newstj', 'numeric')
			->add_rules('zd', 'numeric')
			->add_rules('comefrom','required', 'length[0,200]')
			->add_rules('key','required', 'length[0,100]')		
			->add_rules('type','length[0,50]')
			->add_rules('issue','length[0,50]')
			->add_rules('number','length[0,100]')
			->add_rules('summary','length[0,200]')
			->add_rules('newpic','length[0,200]')				
			->add_rules('updated', 'length[0,255]')
			
			->add_rules('title_en', 'length[0,255]')
			->add_rules('content_en','length[0,65535]')
			->add_rules('comefrom_en', 'length[0,200]')
			->add_rules('key_en','length[0,100]')
			->add_rules('type_en','length[0,50]')
			->add_rules('issue_en','length[0,50]')
		;
		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}
} 

