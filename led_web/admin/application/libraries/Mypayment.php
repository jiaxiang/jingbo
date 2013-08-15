<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: As_payment.php 168 2009-12-21 02:04:12Z wdf $
 * $Author: wdf $
 * $Revision: 168 $
 */

class Mypayment_Core extends My{
	protected $object_name = 'payment';
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
     * Construct load payment data
     *
     * @param Int $id
     */
    public function __construct($id)
    {
        $this->_load($id);
    }
    /**
     * load payment data
     *
     * @param Int $id
     */
    private function _load($id)
    {
        $id = intval($id);

        $payment = ORM::factory('payment',$id);
        $this->data = $payment->as_array();
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
		$orm = ORM::factory('payment');
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
            $list[$key]['payment_type'] = Mypayment_type::instance($rs->payment_type_id)->get();
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
		$orm = ORM::factory('payment');
		if(!empty($where))
		{
			$orm->where($where);
		}
        $count = $orm->count_all();
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
    public function payments($where=NULL,$orderby=NULL,$limit=100,$offset=0)
    {
        $list = $this->_data($where,$orderby,$limit,$offset);
        return $list;
    }
    /**
     * 得到支付类型的详情
     * @return <array>
     */
    public function get($key=NULL)
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
        $payment = ORM::factory('payment');

        $errors = '';
        if($payment->validate($data ,TRUE ,$errors))
        {
            $this->data = $payment->as_array();
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

        $payment = ORM::factory('payment',$id);
        if(!$payment->loaded)
        {
            return FALSE;
        }
        //TODO
        $errors = '';
        if($payment->validate($data ,TRUE ,$errors))
        {
            $this->data = $payment->as_array();
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    /**
     * 支付是否存在
     * @param <array> $args
     * @return <boolean>
     */
    public function payment_exist($data)
    {
		$where = array();
        $where['payment_type_id']	=$data['payment_type_id'];
		//$where['manager_id']		=$data['manager_id'];
		$where['account']			=$data['account'];
		$count = $this->count($where);
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
     * 更改支付排序
     *
     * @param int       $id             分类ID
     * @param string    $position       排序方向
     * @return boolean
     */
    public function position($id,$position)
    {
        $payment=ORM::factory('payment')
            ->where('id',$id)
            ->find();
        if($payment->loaded){
            if($position=='up'){
                $payment->position = $payment->position-3;
            }else{
                $payment->position = $payment->position+3;
            }
            $payment->save();

            $orm_list= ORM::factory('payment')
                ->where(array('manager_id'=>$payment->manager_id))
                ->orderby(array('position'=>'ASC'))
                ->find_all() ;
            foreach( $orm_list as $key=>$rs){
                if($rs->position<>$key*2+1){
                    $rs->position = $key*2+1;
                    $rs->save();
                }
            }
            return TRUE;
        }else{
            $error          = '支付 '.$id.' 数据不存在';
            Mylog::instance()->error($error,__FILE__,__LINE__);
            return FALSE;
        }
    }
    
    /**
     * 设置菜单的排序项
     * @param int $id 菜单ID
     * @param int $order 排序项
     * return bool
     */
    public function set_order($id ,$order)
    {
        $where = array('id'=>$id);
        $obj = ORM::factory('payment')->where($where)->find();
        if($obj->loaded)
        {
            $obj->position = $order;
            return $obj->save();
        }
        return false;
    }
}
?>
