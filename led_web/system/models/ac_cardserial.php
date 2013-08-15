<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ac_cardserial_Model extends ORM 
{
	const FLAG_CLOSE     = 0;
	const FLAG_UNCREATED = 2;
	const FLAG_CREATED   = 4;
	const FLAG_LOCKED    = 6;
	
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('code',        'required', 'length[0,20]')
			->add_rules('name',        'required', 'length[0,100]')
			->add_rules('preflag',     'required', 'numeric')
			->add_rules('flag',        'required', 'numeric')
			->add_rules('apdtime',     'required', 'length[0,100]')
			->add_rules('updtime',     'required', 'length[0,100]')
			->add_rules('bgnnum',      'required', 'numeric')
			->add_rules('endnum',      'required', 'numeric')
			->add_rules('cardtype',    'required', 'numeric')
			->add_rules('points',      'required', 'numeric')
			->add_rules('permoneyrmb', 'required', 'numeric')
			->add_rules('permoneyjpy', 'required', 'numeric')
			->add_rules('percost',     'required', 'numeric');
			
		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>
