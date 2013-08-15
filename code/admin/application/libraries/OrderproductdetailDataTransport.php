<?php defined('SYSPATH') OR die('No direct access allowed.');
class OrderproductdetailDataTransport_Core extends DefaultDataTransport_Service {
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
        $sql    = "SELECT `order_products`.* FROM (`order_products`) WHERE `site_id` = $site_id ORDER BY `order_products`.`id` ASC"; 
        $order_product_details = $this->db->query($sql); 
        foreach($order_product_details as $keyc=>$_orderproductdetail)
        {
            $orderproductdetail_temp                      = array();
            $orderproductdetail_temp['id']                = $_orderproductdetail->id;
            $orderproductdetail_temp['site_id']           = $_orderproductdetail->site_id;
            $orderproductdetail_temp['order_id']          = $_orderproductdetail->order_id;
            $orderproductdetail_temp['product_type']      = 0;
            if($_orderproductdetail->pack_id == 0)
            {
                $orderproductdetail_temp['product_type'] = 1;
            }
            elseif($_orderproductdetail->pack_id == -1)
            {
                $orderproductdetail_temp['product_type'] = 2;
            }
            $orderproductdetail_temp['related_ids']       = 0;
            $orderproductdetail_temp['product_id']        = $_orderproductdetail->product_id;
            $orderproductdetail_temp['attribute']         = array();
            $sql = "SELECT `product_attribute_combinations`.* FROM (`product_attribute_combinations`) WHERE `site_id` = $site_id AND `attribute_id` != 1 AND `product_attribute_id` = $_orderproductdetail->product_attribute_id ORDER BY `product_attribute_combinations`.`id` ASC";
            $product_attributes = $this->db->query($sql);
            foreach($product_attributes as $key_p_a=>$_product_attribute)
            {
                $orderproductdetail_temp['attribute'][$key_p_a] = $_product_attribute->attribute_id;
            }
            //用attribute在c里实现
            //$orderproductdetail_temp['good_id']      = $_orderproductdetail->content_user;
            $orderproductdetail_temp['quantity']            = $_orderproductdetail->quantity;
            $orderproductdetail_temp['sendnum']             = 0;
            $orderproductdetail_temp['dly_status']          = 'storage';
            $orderproductdetail_temp['price']               = $_orderproductdetail->price;
            $orderproductdetail_temp['discount_price']      = $_orderproductdetail->price_discount; 
            $orderproductdetail_temp['name']                = $_orderproductdetail->name;
            $orderproductdetail_temp['SKU']                 = $_orderproductdetail->SKU;
            $orderproductdetail_temp['attribute_style']     = $_orderproductdetail->attribute_style;
            $sql = "SELECT `products`.* FROM (`products`) WHERE `site_id` = $site_id AND `product_id` = $_orderproductdetail->product_id ORDER BY `products`.`id` ASC LIMIT 0, 1";
            $query = $this->db->query($sql);
            $brief = ' ';
            $link  = ' ';
            foreach($query as $_query)
            {
                $brief = strip_tags($_query->description_short);
                $link  = 'http://www.bagsok.com/product/'.$_query->name_url.'.html';
            }
            $orderproductdetail_temp['brief']               = $brief;
            $orderproductdetail_temp['link']                = $link; 
            $orderproductdetail_temp['date_add']            = date('Y-m-d H:i:s',$_orderproductdetail->date_add);
            $orderproductdetail_temp['weight']              = $_orderproductdetail->weight;
            $this->data[$keyc]     = $orderproductdetail_temp;
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
