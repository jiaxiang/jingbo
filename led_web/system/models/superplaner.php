<?php defined('SYSPATH') OR die('No direct access allowed.');

class Superplaner_Model extends ORM 
{
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('user_id', 'required', 'numeric')
			->add_rules('lastname', 'length[0,50]')
			->add_rules('realname', 'length[0,20]')
			->add_rules('mobile', 'length[0,20]')
			->add_rules('tel', 'length[0,20]')
			->add_rules('qq', 'length[0,20]')
			->add_rules('createtime', 'required', 'length[0,100]')
			->add_rules('starttime', 'length[0,100]')
			->add_rules('flag', 'numeric')
			->add_rules('agent_type', 'numeric')
			->add_rules('up_agent_id', 'numeric')
			->add_rules('invite_code', 'length[0,50]')
			->add_rules('note', 'length[0,255]');
			

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>