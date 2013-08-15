<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ag_settle_realtime_Model extends ORM 
{
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('rcid', 'required', 'digt')
			->add_rules('type', 'required', 'digt')
			->add_rules('settletime', 'length[0,100]')
			->add_rules('agent_type', 'digt')
			->add_rules('user_id', 'required', 'numeric')
			->add_rules('flag', 'digt')
			->add_rules('rate', 'numeric')
			->add_rules('fromamt', 'numeric')
			->add_rules('taxrate', 'numeric')
			->add_rules('bonusbeforetax', 'numeric')
			->add_rules('bonus', 'numeric');
			
		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>