<?php defined('SYSPATH') OR die('No direct access allowed.');

class Myorder_refund_log_Core extends My{
	protected $data = array();
	protected $error = array();

	//对象名称(表名)
    protected $object_name = 'order_refund_log';
	
	private static $instances;
	public static function & instance($id = 0)
	{
		if (!isset(self::$instances[$id]))
		{
			$class = __CLASS__;
			self::$instances[$id] = new $class($id);
		}
		return self::$instances[$id];
	}
	
	/**
	 * 判断退款单号是否存在
	 * @param array $data
	 * @return boolean
	 */
    public function exist($data)
    {
		$to = array();
		$to = array(
			'where' => array(
				'refund_num'	=> $data['refund_num']
			
		));
		$count = $this->count($to);
        //TODO
        if($count>0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

	/**
	 * add a refund log
	 *
	 * @param Array $data
	 * @return Array
	 */
	public function add($data)
	{
		$orm_instance = ORM::factory($this->object_name);
		$errors = '';
		$refund_num = $this->get_refund_num();
		$data['refund_num'] = $refund_num;
		if($orm_instance->validate($data,TRUE,$errors))
		{
			$this->data = $orm_instance->as_array();
			return $orm_instance->id;
		}
		else
		{
			$this->error[] = $errors;
			return FALSE;
		}
	}

	/**
	 * create a refund_num
	 *
	 * @return varchar
	 */
	public function get_refund_num()
	{
		$refund_num = '';
		do{
			$temp = sprintf("%14.0f", (date("Ymd").rand(10000,99999)."2"));
			$exist_data = array();
			$exist_data['refund_num'] = $temp;
			if(!$this->exist($exist_data))
			{
				$refund_num = $temp;
				break;
			}
		}while(1);
		return $refund_num;
	}
}