<?php defined('SYSPATH') OR die('No direct access allowed.');

class Myorder_Core extends My{
	//表名
	protected $object_name = 'order';
	//数据成员记录单体数据
	protected $data = array();
	//记录Service中的错误信息
	protected $error = array();

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
	 * get order data
	 *
	 * @param Array $where
	 * @param Array $orderby
	 * @param Int $limit
	 * @param Int $offset
	 * @param Int $in
	 * @return Array
	 */
	private function _data($where,$in,$orderby,$limit,$offset)
	{
		$list = array();

		$orm = ORM::factory('order');
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

		foreach($orm_list as $key=>$rs)
		{
            $list[$key] = $rs->as_array();
            $list[$key]['order_status'] = Myorder_status::instance($rs->order_status)->get();
            //$list[$key]['site']			= Mysite::instance($rs->site_id)->get();
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
	function count($where=NULL,$in=NULL)
	{
		$orm = ORM::factory('order');

		if(!empty($where))
		{
			$orm->where($where);
		}

		if(!empty($in))
		{
			//$orm->in('site_id',$in);
		}

		$count = $orm->count_all();
		return $count;
	}

	/**
	 * 订单总额
	 *
	 * @param Array $where
	 * @param Array $in
	 */
	function sum($where=NULL,$in=NULL,$field = 'total')
	{
		$orm = ORM::factory('order');

		$orm->select('sum('.$field.') as sum');
		if(!empty($where))
		{
			$orm->where($where);
		}

		if(!empty($in))
		{
			//$orm->in('site_id',$in);
		}

		$sum = $orm->find()->sum;
		return $sum;
	}

	/**
	 * 下单用户量
	 * @param Array $where
	 * @param Array $in
	 */
	function count_order_user($field = 'user_id')
	{
		$sql = "SELECT count(distinct($field)) as count
					FROM orders";
		$res=Database::instance()->query($sql)->result_array(FALSE);
		return $res[0]['count'];
	}

	/**
	 * list site
	 *
	 * @param Array $where
	 * @param Array $orderby
	 * @param Int $limit
	 * @param Int $offset
	 * @param Int $in
	 * @return Array
	 */
	public function orders($where=NULL,$in=NULL,$orderby=NULL,$limit=100,$offset=0)
	{
		$list = $this->_data($where,$in,$orderby,$limit,$offset);
		return $list;
	}

	/**
	 * edit a order
	 *
	 * @param Array $data
	 * @param Int $id
	 * @return Array
	 */
	public function edit($data)
	{
		$id = $this->data['id'];
		//EDIT
		$order = ORM::factory('order',$id);
		if(!$order->loaded)
		{
			return FALSE;
		}
		//TODO
		if($order->validate($data ,TRUE ,$errors = ''))
		{
			$this->data = $order->as_array();
			return $this->data;
		}
		else
		{
			return FALSE;
		}
	}

	private function _search_sql($where,$or_like,$in,$orderby,$limit,$offset)
	{
		$db = Database::instance()->from('orders');
		if(!empty($where))
		{
			$db->where($where);
		}

		if(!empty($or_like))
		{
			$db->orlike($or_like);
		}

		if(!empty($in))
		{
			//$db->in('site_id',$in);
		}

		if(!empty($orderby))
		{
			$db->orderby($orderby);
		}

		if(!empty($limit))
		{
			$db->limit($limit);
		}

		if(!empty($offset))
		{
			$db->offset($offset);
		}

		$sql = $db->compile();
		return $sql;
	}

	/**
	 * list search
	 *
	 * @param Array $where
	 * @param Array $orderby
	 * @param Int $limit
	 * @param Int $offset
	 * @param Int $in
	 * @return Array
	 */
	public function search($where=NULL,$or_like=NULL,$in=NULL,$orderby=NULL,$limit=100,$offset=0)
	{
		$sql = $this->_search_sql($where,$or_like,$in,$orderby,$limit,$offset);
		$sql = Mytool::bracket_or_where($sql,$or_like);
		$list= Database::instance()->query($sql)->result_array(FALSE);
		foreach($list as $key=>$rs)
		{
            $list[$key]['order_status'] = Myorder_status::instance($rs['order_status'])->get();
            //$list[$key]['site']			= Mysite::instance($rs['site_id'])->get();
		}
		return $list;

	}
	
   	/**
	 * 统计不同时段的订单数量
	 */
	public function stat_by_date(){
		
            $now		=date( 'Y-m-d H:i:s');//当前时间
            $today		=date( 'Y-m-d H:i:s', mktime(0,0,0,date('m') ,date('d'),date('Y')));//今天
            $yesterday	=date( 'Y-m-d H:i:s', mktime(0,0,0,date('m') ,date('d')-1,date('Y')));//昨天
            $last2day	=date( 'Y-m-d H:i:s', mktime(0,0,0,date('m') ,date('d')-2,date('Y')));//前天
            $lastweek	=date( 'Y-m-d H:i:s', mktime(0,0,0,date('m') ,date('d')-date('w')+1-7,date('Y')));//上周
            $thisweek	=date( 'Y-m-d H:i:s', mktime(0,0,0,date('m') ,date('d')-date('w')+1,date('Y')));//这周
			$lastmonth	=date( 'Y-m-d H:i:s', mktime(0,0,0,date('m')-1,1,date('Y')));//上月
			$thismonth	=date( 'Y-m-d H:i:s', mktime(0,0,0,date('m'),1,date('Y')));//本月

			/*$where['today']	="date_add>='$today'		and date_add<'$now'" ;
			$where['lastday']	="date_add>='$yesterday'	and date_add<'$today'" ;
			$where['last2day']	="date_add>='$last2day'		and date_add<'$yesterday'" ;
			$where['lastweek']	="date_add>='$lastweek'		and date_add<'$thisweek'" ;
			$where['lastmonth']	="date_add>='$lastmonth'	and date_add<'$thismonth'" ;*/
            
			$where['today']		= array($today, $now);           
			$where['lastday']	= array($yesterday, $today);      
			$where['last2day']	= array($last2day, $yesterday);   
			$where['lastweek']	= array($lastweek, $thisweek);    
			$where['lastmonth']	= array($lastmonth, $thismonth); 

			$res_arr = array();
			foreach($where as $key=>$val){
                $query_struct = array();
                //$res_arr[$key] = 0;
				//$sql = "SELECT count(id) as $key FROM orders WHERE $val ";
				//$tem = Database::instance()->query($sql)->result_array(FALSE);
				//$tem && $res_arr[$key] = $tem[0][$key];
                $query_struct['where']['date_add >='] = $val[0];
                $query_struct['where']['date_add <'] = $val[1];
                $res_arr[$key] = $this->query_count($query_struct);
		    }
            
			return $res_arr;
	}
	
   	/**
	 * 分组统计
	 */
	public static function group_count($in = NULL,$groupby = NULL){
		$db = Database::instance()->from('orders');
		$db->select('count(id) as count',$groupby);
		if(!empty($where))
		{
			$db->where($where);
		}

		if(!empty($in))
		{
			//$db->in('site_id',$in);
		}

		if(!empty($groupby))
		{
			$db->groupby($groupby);
		}
		$count = $db->get()->result_array(FALSE);
		return $count;
	}

    /**
     * 根据订单号得到订单详情
     *
     *  @param      String  $order_number
     *  @return     Boolean
     */
    public function get_by_order_num($order_num)
    {
        //todo
		$order = ORM::factory('order')->where('order_num',$order_num)->find()->as_array();
		return $order;
    }
    /**
     * 根据trasn_id得到订单详情
     *
     *  @param      String  $trans_id
     *  @return     Boolean
     */
    public function get_by_trans_id($trans_id)
    {
        //todo
		$order = ORM::factory('order')->where('trans_id',$trans_id)->find()->as_array();
		return $order;
    }
	/**
     * 添加退款记录
	 *
	 * @param <array> $data
     * @return <boolean>
     */
	public function add_order_refund_log($data)
	{
		//ADD
		$order_refund_log = ORM::factory('order_refund_log');
		//TODO
		if($order_refund_log->validate($data ,TRUE ,$errors = ''))
		{
			$this->data = $order_refund_log->as_array();
			return TRUE;
		}
		else
		{
			$this->errors = $errors;
			return FALSE;
		}
	}
	
	/**
	 * 根据订单ID更新订单状态
	 * 
	 * @param int $order_id 订单ID
	 * @param int $order_status 订单状态
	 * @return boolean
	 */
	public function update_order_status_by_order_id($order_id=0,$status=0)
	{
		if($order_id<=0 || $status<=0)
		{
			return false;
		}
		$order = ORM::factory('order',$order_id);
		if($order->loaded==TRUE)
		{	
			$order->order_status = $status;
			$order->date_upd = date('Y-m-d H:i:s',time());
			$order->save();
			return $order->saved;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 根据订单ID更新订单支付状态
	 * 
	 * @param int $order_id 订单ID
	 * @param int $order_status 订单状态
	 * @return boolean
	 */
	public function update_pay_status_by_order_id($order_id=0,$status=0)
	{
		if($order_id<=0 || $status<=0)
		{
			return false;
		}
		$order = ORM::factory('order',$order_id);
		if($order->loaded==TRUE)
		{	
			$order->pay_status = $status;
			$order->date_upd = date('Y-m-d H:i:s',time());
			$order->save();
			return $order->saved;
		}
		else
		{
			return false;
		}
	}

	/**
	 * 根据订单ID更新订单发货状态
	 * 
	 * @param int $order_id 订单ID
	 * @param int $order_status 订单状态
	 * @return boolean
	 */
	public function update_ship_status_by_order_id($order_id=0,$status=0)
	{
		if($order_id<=0 || $status<=0)
		{
			return false;
		}
		$order = ORM::factory('order',$order_id);
		if($order->loaded==TRUE)
		{	
			$order->ship_status = $status;
			$order->date_upd = date('Y-m-d H:i:s',time());
			$order->save();
			return $order->saved;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 订单退款
	 * @param int $order_id 订单ID
	 * @param int $refund_amount 退款金额
	 */
	public function refund_by_order_id($order_id=0,$refund_amount=0)
	{
		if($order_id<=0 || $refund_amount<=0)
		{
			return false;
		}
		$order = ORM::factory('order',$order_id);
		if($order->loaded == TRUE)
		{
			$order_total_paid = $order->total_paid;
			if($refund_amount>$order_total_paid)
			{
				return false;
			}
			else
			{
				$order->total_paid = $order->total_paid-$refund_amount;
				$order->date_upd = date('Y-m-d H:i:s',time());
				$order->save();
				return $order->saved;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * 更新订单支付金额
	 * @param int $order_id 订单ID
	 * @param int $amount 退款金额
	 */
	public function update_total_paid_by_order_id($order_id=0,$amount=0)
	{
		if($order_id<=0 || $amount<=0)
		{
			return false;
		}
		$order = ORM::factory('order',$order_id);
		if($order->loaded == TRUE)
		{
			$order->total_paid = $amount;
			$order->date_pay = date("Y-m-d H:i:s",time());
			$order->date_upd = date('Y-m-d H:i:s',time());
			$order->save();
			return $order->saved;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 判断订单号是否存在
	 * @param array $data
	 * @return boolean
	 */
    public function exist($data)
    {
		$where = array();
		$where['order_num']	=$data['order_num'];
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
	 * delete a item
	 *
	 * @param Int $id
	 * @return Boolean
	 */
	public function delete_by_user_id($user_id)
	{
		$where = array();
		$where['user_id'] = $user_id;

		$orm_list = ORM::factory('order')->where($where)->find_all();

		foreach($orm_list as $key=>$rs){
			$rs->date_upd = date('Y-m-d H:i:s',time());
			$rs->active = 0;
			$rs->save();
		}
		return true;
	}
	
	/**
	 * 根据产品id得到其对应的uri_name，考虑id不在表里面的情况
	 * 
	 * @param int $good_id
	 * @return string
	 */
	public function get_product_uri_by_id($good_id)
	{
        $good = ProductService::get_instance()->get($good_id);
		if(isset($good) && !empty($good['id']))
		{
			$uri_name = isset($good['uri_name'])?$good['uri_name']:$good['id'];
		}
		else
		{
			$uri_name = '';
		}
		return $uri_name;
	}
	
	/**
	 * 根据产品id得到其对应的category_id，考虑id不在表里面的情况
	 * 
	 * @param int $good_id
	 * @return string
	 */
	public function get_category_id_by_id($product_id)
	{
		//$good = ORM::factory('good')->where('id',$good_id)->find()->as_array();
		//if(isset($good) && !empty($good['id']))
		//{
			$product = $this->get_product_by_id($product_id);
			if(isset($product['category_id']))
			{
				return $product['category_id'];
			}
			else
			{
				return 0;	
			}			
		//}
		//else
		//{
			//$category_id = 0;
		//}
		//return $category_id;
	}
	
	/**
	 * 根据产品id得到其对应的信息，考虑id不在表里面的情况
	 * 
	 * @param int $good_id
	 * @return string
	 */
	public function get_good_by_id($good_id)
	{
		//$good = ORM::factory('good')->where('id',$good_id)->find()->as_array();
        return ProductService::get_instance()->get($good_id);
		//$good = isset($good) && !empty($good['id']) ? $good : '';
		//return $good;
	}
	
	/**
	 * 根据产品id得到其对应的product信息，考虑id不在表里面的情况
	 * 
	 * @param int $product_id
	 * @return string
	 */
	public function get_product_by_id($product_id)
	{
		//$product = ORM::factory('product')->where('id',$product_id)->find()->as_array();
        return ProductService::get_instance()->get($product_id);
		//$product = isset($product) && !empty($product['id']) ? $product : '';
		//return $product;
	}
	
    /**
     * 根据delivery_id得到物流url
     *
     *  @param      String  $delivery_id
     *  @return     $string
     */
    public function get_delivery_url_by_delivery_id($delivery_id)
    {
        //todo
		$delivery = ORM::factory('delivery')->where('id',$delivery_id)->find()->as_array();
		$url = isset($delivery) && !empty($delivery['id']) ? $delivery['url'] : '';
		return $url;
    }

    /**
     * 重新查询数据库，计算商品价格
     * zhu
     *  @param      array  $order
     *  @return     bool
     */
    public function update_total($order_id = 0)
    {
	    //重新查询数据库，计算价格
        $order_id>0 && $this->_load($order_id);
        $total_products = 0;
        $order = $this->data;
	    $goods_order = Myorder_product::instance()->order_product_details(array('order_id'=>$order['id']));
        if($goods_order && is_array($goods_order)){
    	    foreach($goods_order as $val)
    	    {
    	    	$total_products += $val['quantity'] * $val['discount_price'];
    	    }
        }
	    $total = $total_products + $order['total_shipping'];
	    $total_real = round($total * 100 / $order['conversion_rate']) / 100;
	    $final_data = array('total'=>$total, 'total_products'=>$total_products,'total_real'=>$total_real);
	    return $this->edit($final_data);
    }
    
}
