<?php defined('SYSPATH') OR die('No direct access allowed.');
class OrderhistoryDataTransport_Core extends DefaultDataTransport_Service {
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
        $sql    = "SELECT `order_histories`.* FROM (`order_histories`) WHERE `site_id` = $site_id ORDER BY `order_histories`.`id` ASC"; 
        $order_histories = $this->db->query($sql); 
        foreach($order_histories as $keyc=>$_orderhistory)
        {
            $orderhistory_temp                      = array();
            $orderhistory_temp['id']                = $_orderhistory->id;
            $orderhistory_temp['site_id']           = $_orderhistory->site_id;
            $orderhistory_temp['order_id']          = $_orderhistory->order_id;
            //原表中没有,employee?
            $orderhistory_temp['manager_id']        = 0;
            $orderhistory_temp['manager_name']      = ' ';
            $orderhistory_temp['order_status_id']   = $_orderhistory->order_status_id;
            //订单状态
            $order_status_id    = $_orderhistory->order_status_id;
            $order_status       = 1;
            $pay_status         = 1;
            $ship_status        = 1;
            $status_flag        = 'pay_status';
            switch($order_status_id)
            {
            case 2:
                $pay_status = 2;
                break;
            case 3:
                $order_status = 4;
                $status_flag = 'order_status';
                break;
            case 4:
                $order_status = 2;
                $pay_status = 3;
                break;
            case 5:
                $order_status = 2;
                $pay_status = 3;
                $status_flag = 'order_status';
                break;
            case 6:
                $order_status = 2;
                $pay_status = 3;
                $ship_status = 2;
                $status_flag = 'ship_status';
                break;
            case 7:
                $order_status = 2;
                $pay_status = 3;
                $ship_status = 4;
                $status_flag = 'ship_status';
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
                $status_flag = 'order_status';
                break;
            }
            $orderhistory_temp['order_status']      = $order_status;
            $orderhistory_temp['pay_status']        = $pay_status;
            $orderhistory_temp['ship_status']       = $ship_status; 
            $orderhistory_temp['status_flag']       = $status_flag;  
            $orderhistory_temp['is_send_mail']      = $_orderhistory->is_send_mail;
            $orderhistory_temp['content_user']      = $_orderhistory->content_user;
            $orderhistory_temp['content_admin']     = $_orderhistory->content_admin;
            $orderhistory_temp['time_use']          = $_orderhistory->time_use;
            $orderhistory_temp['date_add']          = date('Y-m-d H:i:s',$_orderhistory->date_add);
            $orderhistory_temp['ip']                = $_orderhistory->ip_add;
            $orderhistory_temp['result']            = 'success';
            $this->data[$keyc]     = $orderhistory_temp;
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
