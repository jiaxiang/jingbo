<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: As_payment_type.php 168 2009-12-21 02:04:12Z wdf $
 * $Author: wdf $
 * $Revision: 168 $
 */

class Mypayment_type_Core extends My{
    protected $object_name = 'payment_type';
    protected $data = array();
    protected static $instances;
    public static function instance($id = 0)
    {
        if (!isset(self::$instances[$id]))
        {
            $class = __CLASS__;
            self::$instances[$id] = new $class($id);
        }
        return self::$instances[$id];
    }
    /**
     * Construct load payment_api data
     *
     * @param Int $id
     */
    public function __construct($id)
    {
        $this->_load($id);
    }
    /**
     * load payment_api data
     *
     * @param Int $id
     */
    private function _load($id)
    {
        $id = intval($id);

        $payment_type = ORM::factory('payment_type',$id);
        $this->data = $payment_type->as_array();
    }

    /**
     * 当前支付类型列表
     *
     * @param Array $where
     * @param Array $orderby
     * @param Int $limit
     * @param Int $offset
     * @return Array
     */
    private function _data($where,$orderby,$limit,$offset)
    {
		$orm = ORM::factory('payment_type');
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
		}
		return $list;
    }
    /**
     * 指定条件的支付类型的数量
     * @param <string|array> $where
     * @return <int>
     */
    public function count($where=NULL)
    {
        if(empty($where))
        {
            $where = array('1=1');
        }

        $payment_type = ORM::factory('payment_type');
        $count = $payment_type
            ->where($where)
            ->count_all();
        return $count;
    }
    /**
     * 当前支付类型列表
     *
     * @param Array $where
     * @param Array $orderby
     * @param Int $limit
     * @param Int $offset
     * @return Array
     */
    public function payment_types($where=NULL,$orderby=NULL,$limit=100,$offset=0)
    {
        $list = $this->_data($where,$orderby,$limit,$offset);
        return $list;
    }
    /**
     * 得到支付类型的详情
     * @return <array>
     */
    public function get($key = NULL)
    {
        if(empty($key))
        {
            return $this->data;
        }
        else
        {
            return isset($this->data[$key])?$this->data[$key]:NULL;
        }

    }
    /**
     * 添加支付类型
     * @param <array> $data
     * @return <array|string>
     */
    public function add($data)
    {
        $payment_type = ORM::factory('payment_type');

        $errors = '';
        if($payment_type->validate($data ,TRUE ,$errors))
        {
            $this->data = $payment_type->as_array();
            return TRUE;
        }else {
            return FALSE;
        }
    }
    /**
     * 更新支付类型的信息
     * @param <array> $args
     * @return <boolean>
     */
    public function edit($data)
    {
        $id = $this->data['id'];

        $payment_type = ORM::factory('payment_type',$id);
        if(!$payment_type->loaded)
        {
            return FALSE;
        }
        //TODO
        $errors = '';
        if($payment_type->validate($data ,TRUE ,$errors))
        {
            $this->data = $payment_type->as_array();
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
	/**
	 * get select list
	 *
	 * @param array $in_array
	 * @return array
	 */
	public function select_list($in_array = NULL)
	{
		$list = array();
        $orm   = ORM::factory('payment_type');
		if(!empty($in_array))
		{
		    $orm->in('id',$in_array);
		}
		return $orm->select_list('id','name');
	}

}
?>
