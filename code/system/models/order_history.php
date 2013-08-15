<?php defined('SYSPATH') OR die('No direct access allowed.');

class Order_history_Model extends ORM {

	protected $belongs_to = array('order_status','site','order');

    public function validate(array & $array, $save = FALSE, & $errors) 
	{
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('order_id','required','numeric')
            ->add_rules('order_status','numeric')
            ->add_rules('status_flag','chars[order_status,pay_status,ship_status]')
            ->add_rules('pay_status','numeric')
            ->add_rules('ship_status','numeric')
            ->add_rules('manager_id', 'numeric')
            ->add_rules('manager_name', 'length[0,255]')
            ->add_rules('is_send_mail', 'numeric')
			->add_rules('content_user', 'length[0,65535]')
			->add_rules('content_admin', 'length[0,65535]')
            ->add_rules('time_use','required')
            ->add_rules('ip','numeric')
			->add_rules('result', 'length[0,255]');

        if(parent::validate($array, $save)) 
		{
            return TRUE;
        }
		else 
		{
            $errors =kohana::debug($array->errors());
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }

}

