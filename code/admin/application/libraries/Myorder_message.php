<?php defined('SYSPATH') OR die('No direct access allowed.');

class Myorder_message_Core extends My{
	protected $object_name = 'order_message';
	protected $data = array();
	protected $errors = NULL;

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
	 * Construct load order data
	 *
	 * @param Int $id
	 */
	public function __construct($id)
	{
		$this->_load($id);
	}

	/**
	 * load order data
	 *
	 * @param Int $id
	 */
	private function _load($id)
	{
		$id = intval($id);

		$order_message = ORM::factory('order_message',$id)->as_array();
		$this->data = $order_message;
	}

	/**
	 * get order message data
	 *
	 * @param Array $where
	 * @param Array $orderby
	 * @param Int $limit
	 * @param Int $offset
	 * @param Int $in
	 * @return Array
	 */
	private function _data($where = NULL,$orderby = NULL,$limit = 0,$offset = 100)
	{
		$list = array();

		$orm = ORM::factory('order_message');
		if(!empty($where))
		{
			$orm->where($where);
		}

		if(!empty($orderby))
		{
			$orm->orderby($orderby);
		}

		$orm_list = $orm->find_all($limit,$offset);

        $list = array();
		foreach($orm_list as $key=>$rs)
		{
            $list[$key] = $rs->as_array();
            $list[$key]['manager'] = Mymanager::instance($rs->manager_id)->get();
		}

		return $list;
	}

	/**
	 * get the total number
	 *
	 * @param Array $where
	 * @param Array $in
	 * @return Int
	 */
	function count($where=NULL)
	{
		$orm = ORM::factory('order_message');
		if(!empty($where))
		{
			$orm->where($where);
		}
		$count = $orm->count_all();
		return $count;
	}

	/**
	 * 有留言的订单量
	 * @param Array $where
	 * @param Array $in
	 */
	function count_order($field = 'order_id')
	{
		//$sql = "SELECT count(distinct($field)) as count
					//FROM order_messages
					//WHERE $site_str";
		$sql = "SELECT count(distinct(om.$field)) as count
					FROM order_messages om left join orders o 
					on om.order_id = o.id where o.order_status != 4 ";
		$res=Database::instance()->query($sql)->result_array(FALSE);
		return $res[0]['count'];
	}

	/**
	 * list order message
	 *
	 * @param Array $where
	 * @param Array $orderby
	 * @param Int $limit
	 * @param Int $offset
	 * @param Int $in
	 * @return Array
	 */
	public function order_messages($where=NULL,$orderby=NULL,$limit=100,$offset=0)
	{
		$list = $this->_data($where,$orderby,$limit,$offset);
		return $list;
	}

	/**
	 * get order message data
	 *
	 * @return Array
	 */
	public function get($key = NULL)
	{
		if(empty($key))
		{
			return $this->data;
		}
		else
		{
			if(isset($this->data[$key]))
			{
				return $this->data[$key];
			}
			else
			{
				return NULL;
			}
		}
	}

	/**
	 * add a order message
	 *
	 * @param Int $id
	 * @param Array $data
	 * @return Array
	 */
	public function add($data)
	{
		//ADD
		$order_message = ORM::factory('order_message');
		//TODO
		if($order_message->validate($data ,TRUE ,$errors = ''))
		{
			$this->data = $order_message->as_array();
			return TRUE;
		}
		else
		{
			$this->errors = $errors;
			return FALSE;
		}
	}

	/**
	 * edit a order message
	 *
	 * @param Int $id
	 * @param Array $data
	 * @return Array
	 */
	public function edit($data)
	{
		$id = $this->data['id'];
		//EDIT
		$order_message = ORM::factory('order_message',$id);
		if(!$order_message->loaded)
		{
			return FALSE;
		}
		//TODO
		if($order_message->validate($data ,TRUE ,$errors = ''))
		{
			$this->data = $order_message->as_array();
			return TRUE;
		}
		else
		{
			$this->errors = $errors;
			return FALSE;
		}
	}

	/**
	 * get errors
	 */
	public function errors()
	{
		return $this->errors;
	}
}
