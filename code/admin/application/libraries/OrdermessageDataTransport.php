<?php defined('SYSPATH') OR die('No direct access allowed.');
class OrdermessageDataTransport_Core extends DefaultDataTransport_Service {
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
        $sql    = "SELECT `order_messages`.* FROM (`order_messages`) WHERE `site_id` = $site_id ORDER BY `order_messages`.`id` ASC"; 
        $order_messages = $this->db->query($sql);
        $key_m = 0; 
        foreach($order_messages as $keyc=>$_ordermessage)
        {
            $ordermessage_temp                      = array();
            $ordermessage_temp['id']                = $_ordermessage->id;
            $ordermessage_temp['site_id']           = $_ordermessage->site_id;
            $ordermessage_temp['order_id']          = $_ordermessage->order_id;
            //原表中没有,是不是employee？
            $ordermessage_temp['manager_id']        = 0;
            $ordermessage_temp['type']              = 0;
            $ordermessage_temp['message']           = $_ordermessage->message;
            $ordermessage_temp['ip']                = $_ordermessage->ip_add;
            $ordermessage_temp['active']            = $_ordermessage->private;
            $ordermessage_temp['date_add']          = date('Y-m-d H:i:s',$_ordermessage->date_add);
            $this->data[$key_m]         = $ordermessage_temp;
            $key_m++;
            if(isset($_ordermessage->return_message) && ($_ordermessage->return_message != NULL))
            {
                $ordermessage_temp['type']          = 1;
                $ordermessage_temp['message']       = $_ordermessage->return_message;
                $ordermessage_temp['date_add']      = date('Y-m-d H:i:s',$_ordermessage->date_upd);
                $this->data[$key_m]         = $ordermessage_temp;
                $key_m++;
            }
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
