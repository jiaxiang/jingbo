<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ac_cardissueserial_Model extends ORM 
{
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('issuetime',   'required', 'length[0,100]')
			->add_rules('checkuserid', 'required', 'numeric')
			->add_rules('checkuser',   'required', 'length[0,50]')
			->add_rules('channelid',   'required', 'numeric')
			->add_rules('channelcode', 'required', 'length[0,20]')
			->add_rules('mailcost',    'required', 'numeric')
			->add_rules('bgnnum',      'required', 'numeric')
			->add_rules('endnum',      'required', 'numeric')
			->add_rules('billid',      'required', 'numeric');
			
		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>
