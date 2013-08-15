<?php defined('SYSPATH') OR die('No direct access allowed.');


class Extract_amount_Model extends ORM {
	  	
    public function validate(array & $array, $save = FALSE)
	{

		$fields = parent::as_array();
		$array = array_merge($fields,$array);
		
		$array = Validation::factory($array)
            ->pre_filter('trim')	
			->add_rules('money','length[0,50]')      
			->add_rules('poundage','numeric')       
            ->add_rules('tq_name','length[0,50]')
			->add_rules('content','length[1,200]')
			->add_rules('order_num','length[0,300]')
			->add_rules('type', 'length[0,20]')
			->add_rules('deductible', 'length[0,20]')
			->add_rules('paytime', 'length[0,100]')
			->add_rules('user_id','length[0,20]');
		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}

}