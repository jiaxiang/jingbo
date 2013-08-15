<?php defined('SYSPATH') OR die('No direct access allowed.');

class Theme_Model extends ORM {

	public function validate(array & $array, $save = FALSE) {

		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('name','required','length[0,255]')
			->add_rules('grade','required','numeric')
			->add_rules('type','required','numeric')
			->add_rules('brief','length[0,65535]')
			->add_rules('config','length[0,65535]');

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

