<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ac_card_Model extends ORM 
{
	const FLAG_CLOSE   = 0;
	const FLAG_UNISSUE = 2;
	const FLAG_ISSUED  = 4;
	const FLAG_OPEN    = 6;
	const FLAG_USED    = 8;
	
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('cardpass',       'length[0,20]')
			->add_rules('mgrnum',         'required', 'numeric')
			->add_rules('cardserialid',   'required', 'numeric')
			->add_rules('cardserialcode', 'required', 'length[0,20]')
			->add_rules('points',         'required', 'numeric')
			->add_rules('preflag',        'required', 'numeric')
			->add_rules('flag',           'required', 'numeric')
			->add_rules('apdtime',        'length[0,100]')
			->add_rules('updtime',        'length[0,100]')
			->add_rules('opentime',       'length[0,100]')
			->add_rules('moneyrmb',       'required', 'numeric')
			->add_rules('moneyjpy',       'required', 'numeric')
			->add_rules('salecost',       'required', 'numeric')
			->add_rules('issueid',        'required', 'numeric')
			->add_rules('issuetime',      'length[0,100]')
			->add_rules('openid',         'required', 'numeric')
			->add_rules('opentime',       'length[0,100]');
			

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>
