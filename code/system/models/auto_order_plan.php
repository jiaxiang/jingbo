<?php defined('SYSPATH') OR die('No direct access allowed.');

class Auto_order_plan_Model extends ORM {
	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save the record when validation succeeds
	 * @return boolean
	 */
	public static $instance = NULL;

    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }

    public function validate(array & $array, $save = FALSE)
	{
		$fields = parent::as_array();
		
		$array = array_merge($fields, $array);
		
		$array = Validation::factory($array)
			->pre_filter('trim');

		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}


	
}
