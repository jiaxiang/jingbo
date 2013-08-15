<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ac_openbill_Model extends ORM 
{
	const FLAG_DELETED = 0;
	const FLAG_NEW     = 2;
	
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('num',         'required', 'length[0,20]')
			->add_rules('user_id',     'required', 'numeric')
			->add_rules('flag',        'required', 'numeric')
			->add_rules('issueid',     'numeric')
			->add_rules('channelid',   'numeric')
			->add_rules('channelcode', 'length[0,20]')
			->add_rules('bgnnum',      'numeric')
			->add_rules('endnum',      'numeric')
			->add_rules('moneys',      'required', 'numeric')
			->add_rules('des',         'length[0,255]')
			->add_rules('apdtime',     'required', 'length[0,100]')
			->add_rules('updtime',     'required', 'length[0,100]');

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			d($errors, true);
			return FALSE;
		}
	}
}

?>
