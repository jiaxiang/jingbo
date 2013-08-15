<?php defined('SYSPATH') OR die('No direct access allowed.');
class OrderDataTransport_Core extends DefaultDataTransport_Service {
    /**
     * 当前操作的记录ID
     */
    protected $current_id = -1;

    /**
     * 记录结束ID
     */
    protected $end = 0;

    /**
     * 记录集数据
     */
    protected $data     = array();

    /**
     * 实例化对像 
     */
    private static $instances = NULL;

    // 获取单态实例
    public static function & instance($site_id){
        if(self::$instances[$site_id] === null){
            $classname = __CLASS__;
            self::$instances[$site_id] = new $classname($site_id);
        }
        return self::$instances[$site_id];
    }


    /**
     * Construct load data
     *
     * @param Int $id
     */
    public function __construct($site_id)
    {
        $this->db = Database::instance('old');
        $sql    = "SELECT `orders`.* FROM (`orders`) WHERE `site_id` = $site_id ORDER BY `orders`.`id` ASC"; 
        $orders = $this->db->query($sql); 
        foreach($orders as $keyc=>$_order)
        {
            $order_temp                      = array();
            $order_temp['id']                = $_order->id;
            $order_temp['site_id']           = $_order->site_id;
            $order_temp['order_num']         = $_order->order_num;
            $order_temp['user_id']           = $_order->user_id;
            $order_temp['email']             = $_order->email;
            $order_temp['total']             = $_order->total;
            $order_temp['currency']          = $_order->currency_id;
            $sql    = "SELECT `currencies`.* FROM (`currencies`) WHERE `site_id` = $site_id AND `currency_id` = $_order->currency_id ORDER BY `currencies`.`id` ASC LIMIT 0, 1";
            $query = $this->db->query($sql);
            foreach($query as $_query)
            {
                $order_temp['currency']          = $_query->name;
                $order_temp['conversion_rate']   = $_query->conversion_rate;
            } 
            $order_temp['total_products']    = $_order->total_products;
            $order_temp['total_shipping']    = $_order->total_shipping;
            $order_temp['total_discount']    = $_order->total_products + $_order->total_shipping - $_order->total;
            //订单状态
            $order_status_id    = $_order->order_status_id;
            $order_status       = 1;
            $pay_status         = 1;
            $ship_status        = 1;
            switch($order_status_id)
            {
            case 2:
                $pay_status = 2;
                break;
            case 3:
                $order_status = 4;
                break;
            case 4:
                $order_status = 2;
                $pay_status = 3;
                break;
            case 5:
                $order_status = 2;
                $pay_status = 3;
                break;
            case 6:
                $order_status = 2;
                $pay_status = 3;
                $ship_status = 2;
                break;
            case 7:
                $order_status = 2;
                $pay_status = 3;
                $ship_status = 4;
                break;
            case 8:
                $order_status = 2;
                $pay_status = 4;
                break;
            case 9:
                $order_status = 2;
                $pay_status = 5;
                $ship_status = 4;
                break;
            case 10:
                $order_status = 2;
                $pay_status = 6;
                break;
            case 11:
                $order_status = 2;
                $pay_status = 6;
                $ship_status = 4;
                break;
            case 12:
                $order_status = 4;
                $pay_status = 7;
                break;
            case 13:
                $order_status = 4;
                break;
            }
            $order_temp['order_status']      = $order_status;
            $order_temp['pay_status']        = $pay_status;
            $order_temp['ship_status']       = $ship_status; 
            $order_temp['user_status']       = 'null';
            $order_temp['order_source']      = 'site';  
            $order_temp['total_real']        = $_order->total_real;
            $order_temp['total_paid']        = $_order->total_paid;
            $order_temp['shipping_firstname']= $_order->shipping_firstname;
            $order_temp['shipping_lastname'] = $_order->shipping_lastname;
            $order_temp['shipping_country']  = $_order->shipping_country;
            $order_temp['shipping_state']    = $_order->shipping_state;
            $order_temp['shipping_city']     = $_order->shipping_city;
            $order_temp['shipping_address']  = $_order->shipping_address;
            $order_temp['shipping_zip']      = $_order->shipping_zip;
            $order_temp['shipping_phone']    = $_order->shipping_phone;
            $order_temp['shipping_mobile']   = $_order->shipping_mobile;
            $order_temp['billing_firstname'] = $_order->billing_firstname;
            $order_temp['billing_lastname']  = $_order->billing_lastname;
            $order_temp['billing_country']   = $_order->billing_country;
            $order_temp['billing_state']     = $_order->billing_state;
            $order_temp['billing_city']      = $_order->billing_city;
            $order_temp['billing_address']   = $_order->billing_address;
            $order_temp['billing_zip']       = $_order->billing_zip;
            $order_temp['billing_phone']     = $_order->billing_phone;
            $order_temp['billing_mobile']    = $_order->billing_mobile;
            //支付方式，待添加
            $order_temp['payment_id']        = 1;
            $order_temp['trans_id']          = $_order->trans_id;
            $order_temp['ems_num']           = $_order->ems_num;
            $order_temp['carrier']           = $_order->carrier;
            $order_temp['supplier']          = $_order->supplier;
            $order_temp['date_add']          = date('Y-m-d H:i:s',$_order->date_add);
            $order_temp['date_upd']          = date('Y-m-d H:i:s',$_order->date_upd);
            $order_temp['date_pay']          = '0000-00-00 00:00:00';
            if(($_order->date_pay != NULL) && ($_order->date_pay != 0))
            {
                $order_temp['date_pay'] = date('Y-m-d H:i:s',$_order->date_pay);
            }
            $order_temp['date_verify']       = '0000-00-00 00:00:00';
            if(($_order->date_verify != NULL) && ($_order->date_verify != 0))
            {
                $order_temp['date_verify'] = date('Y-m-d H:i:s',$_order->date_verify);
            }
            $order_temp['ip']               = $_order->ip_add;
            $order_temp['active']           = $_order->active;
            $this->data[$keyc]     = $order_temp;
        }
        $this->end    = count($this->data);
    }


    /**
     * 获取下一条记录的ID
     * 
     * @return int,bool  当不具备下一条记录时，返回 false;
     */
    public function next_id()
    {
        $this->current_id ++;
        if($this->current_id<$this->end)
        {
            return $this->current_id; 
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * 通过ID获取数组
     * 
     * @param int $id
     * @return array
     */
    public function get($id)
    {
        if(isset($this->data[$id]))
        {
            return $this->data[$id];
        }
        else
        {
            return array();
        }
    }
}
