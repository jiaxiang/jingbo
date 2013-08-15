<?php defined('SYSPATH') OR die('No direct access allowed.');

class Myorder_product_Core {
    private $data = array();
    private $orm_form = 'order_product';
    private $errors = NULL;

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
     * Construct load order_product data
     *
     * @param Int $id
     */
    public function __construct($id)
    {
        $this->_load($id);
    }

    /**
     * load order_product data
     *
     * @param Int $id
     */
    private function _load($id)
    {
        $id = intval($id);

        $data = ORM::factory($this->orm_form,$id)->as_array();
        $this->data = $data;
    }

    /**
     * get order_product data
     *
     * @param Array $where
     * @param Array $orderby
     * @param Int $limit
     * @param Int $offset
     * @param Int $in
     * @return Array
     */
    private function _data($where = NULL,$in=NULL,$orderby = NULL,$limit = 0,$offset = 100)
    {
        $list = array();

        $orm = ORM::factory($this->orm_form);
        if(!empty($where))
        {
            $orm->where($where);
        }

        if(!empty($in))
        {
            //$orm->in('site_id',$in);
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
     * list order_product
     *
     * @param Array $where
     * @param Array $orderby
     * @param Int $limit
     * @param Int $offset
     * @param Int $in
     * @return Array
     */
    public function order_products($where=NULL,$in=NULL,$orderby=NULL,$limit=100,$offset=0)
    {
        $list = $this->_data($where,$in,$orderby,$limit,$offset);
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
        $orm = ORM::factory($this->orm_form);
        if(!empty($where))
        {
            $orm->where($where);
        }
        $count = $orm->count_all();
        return $count;
    }

    /**
     * list order_product
     *
     * @param Array $where
     * @param Array $orderby
     * @param Int $limit
     * @param Int $offset
     * @param Int $in
     * @return Array
     */
    public function order_product_details($where=NULL,$in=NULL,$orderby=NULL,$limit=100,$offset=0)
    {
        $list = $this->_data($where,$in,$orderby,$limit,$offset);
        return $list;
    }
    
    /*
     * 根据订单号得到订单的所有商品
     * 
     * @param int $order_id
     * @return array
     */
    public function get_order_products_by_order_id($order_id=0)
    {
        if($order_id<=0)
        {
            return false;
        }
        $order_products = ORM::factory('order_product')->where('order_id',$order_id)->find_all();
        $data = array();
        foreach($order_products as $item)
        {
            $data[] = $item->as_array();
        }
        return $data;
    }
    
    /**
     * 更新订单货品物流投递状态
     * 
     * @param int $order_product_id 订单商品ID
     * @param string $status 'storage','shipping','return','customer','returned' 订单物流投递状态
     */
    public function update_dly_status_by_order_product_id($order_product_id=0,$status='storage')
    {
        if($order_product_id<=0)
        {
            return false;
        }
        $order_product = ORM::factory('order_product',$order_product_id);
        if($order_product->loaded)
        {
            $order_product->dly_status = $status;
            $order_product->save();
            return $order_product->saved;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 根据订单商品ID退货
     * 
     * @param int $order_product_id
     * @param int $return_num
     * @return boolean
     */
    public function return_by_order_product_id($order_product_id=0,$return_num=0)
    {
        if($order_product_id<=0 || $return_num<=0)
        {
            return false;
        }
        $order_product = ORM::factory('order_product',$order_product_id);
        $sendnum = $order_product->sendnum;
        if($sendnum < $return_num)
        {
            return false;
        }
        $order_product->sendnum = $order_product->sendnum-$return_num;
        $order_product->save();
        if($order_product->saved==TRUE)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 根据货品ID发货
     * 
     * @prame int $good_id 货品ID
     * @param int $order_id 订单ID
     * @return boolean
     */
    public function ship_by_order_product_id($order_product_id=0,$sendnum=0)
    {
        if($order_product_id<=0 || $sendnum<=0)
        {
            return false;
        }
        $order_product = ORM::factory('order_product',$order_product_id);
        //商品可发货数量
        $order_product_sendnum = $order_product->quantity - $order_product->sendnum;
        if($sendnum > $order_product_sendnum)
        {
            return false;
        }
        $order_product->sendnum = $order_product->sendnum+$sendnum;
        $order_product->save();
        if($order_product->saved==TRUE)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * get order_product data
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
     * add a order_product
     *
     * @param Int $id
     * @param Array $data
     * @return Array
     */
    public function add($data)
    {
        //ADD
        $orm = ORM::factory($this->orm_form);
        //TODO
        if($orm->validate($data ,TRUE ,$errors = ''))
        {
            $this->data = $orm->as_array();
            return TRUE;
        }
        else
        {
            $this->errors = $errors;
            return FALSE;
        }
    }

    /**
     * edit a order_product
     *
     * @param Int $id
     * @param Array $data
     * @return Array
     */
    public function edit($data)
    {
        $id = $this->data['id'];
        //EDIT
        $orm = ORM::factory($this->orm_form,$id);
        if(!$orm->loaded)
        {
            return FALSE;
        }
        //TODO
        if($orm->validate($data ,TRUE ,$errors = ''))
        {
            $this->data = $orm->as_array();
            return TRUE;
        }
        else
        {
            $this->errors = $errors;
            return FALSE;
        }
    }

    /**
     * 是否已经存在
     * @param <array> $args
     * @return <boolean>
     */
    public function exist($data)
    {
        $where = array();
        $where['order_id']    =$data['order_id'];
        $where['SKU']        =$data['SKU'];
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
     * get errors
     */
    public function errors()
    {
        return $this->errors;
    }

    public function delete()
    {
        $id = $this->data['id'];

        $orm = ORM::factory($this->orm_form,$id);
        if(!$orm->loaded)
        {
            return FALSE;
        }
        $orm->delete();
        return TRUE;
    }
}
