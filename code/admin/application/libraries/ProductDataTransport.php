<?php defined('SYSPATH') OR die('No direct access allowed.');
class ProductDataTransport_Core extends DefaultDataTransport_Service {
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
        if(!isset(self::$instances[$site_id])){
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
        /*
        $products = ORM::factory('product')
            ->where('site_id',$site_id)
            ->find_all();
         */
        $sql = "SELECT `products`.* FROM (`products`) WHERE `site_id` = $site_id ORDER BY `products`.`id` ASC";
        $products = $this->db->query($sql); 
        foreach($products as $keyc=>$_product)
        {
            
            $product_temp                   = array();
            $product_temp['id']             = $_product->product_id;
            $product_temp['site_id']        = $_product->site_id;
            $product_temp['status']         = 1;
            $product_temp['on_sale']        = $_product->on_sale;
            $product_temp['SKU']            = $_product->SKU;
            $product_temp['title']          = $_product->name;
            $product_temp['uri_name']       = $_product->name_url;
            $product_temp['category_id']    = $_product->category_default_id;

            //补充三个不全的数据
            /*if($_product->category_default_id == 119)
            {
                $product_temp['category_id'] = 135;
            }
            if($_product->category_default_id == 753)
            {
                $product_temp['category_id'] = 144;
            }
            if($_product->category_default_id == 324)
            {
                $product_temp['category_id'] = 144;
            }
             */

            $product_temp['product_tag_ids']= '';
            $product_temp['meta_title']     = substr(strip_tags($_product->meta_title), 0, 100);
            $product_temp['meta_keywords']      = strip_tags($_product->meta_keywords);
            $product_temp['meta_description']   = strip_tags($_product->meta_description);
            $brief = $_product->description_short;
            if(empty($brief) || ($brief == NULL))
            {
                $brief = $_product->description;
            }
            $product_temp['brief']              = substr(strip_tags($brief), 0, 255);
            //描述
            $description    =  $_product->description;
            /*$description    .= '<div class="img_details">';
            for($i=1;$i<=10;$i++)
            {
                $description .= '<img src="http://www.bagsok.com/detail_images/'.$_product->SKU.'-M/'.$i.'.jpg" />';
            }
            for($i=1;$i<=20;$i++)
            {
                $description .= '<img src="http://www.bagsok.com/detail_images/'.$_product->SKU.'/'.$i.'.jpg" />';
            }
            $description .= '</div>';
             */
            $product_temp['description']        = $description;
            
            $product_temp['name_manage']        = $_product->name_cn;
            $product_temp['store']              = 100;
            $product_temp['sold_count']         = 0;
            $product_temp['comments_count']     = 0;
            $product_temp['star_average']       = 0;
            $product_temp['create_timestamp']   = time();
            $product_temp['update_timestamp']   = time();

            //商品图片
            $product_temp['images']             = array();
            /*
            $product_images = ORM::factory('product_image')
                ->where('site_id',$site_id)
                ->where('product_id',$_product->id)
                ->find_all();
             */
            $sql    = "SELECT `product_images`.* FROM (`product_images`) WHERE `site_id` = $site_id AND `product_id` = $_product->product_id ORDER BY `product_images`.`id` ASC";
            $product_images = $this->db->query($sql); 
            foreach($product_images as $_image)
            {
                $product_temp['images'][$_image->id]   = $site_id.'/'.$_image->image_SKU.'.jpg';     
            }

            //商品品牌
            //这里用feature_group_id = 4,2
            $product_temp['brand_id']       = 0;
            $sql = "SELECT `product_features`.* FROM (`product_features`) WHERE `site_id` = $site_id AND `product_id` = $_product->product_id ORDER BY `product_features`.`id` ASC";
            $product_features = $this->db->query($sql);
            $features_id_list = array();
            foreach($product_features as $keyf=>$_feature)
            {
                $features_id_list[$_feature->feature_id] = $_feature->feature_id;
            }
            if(!count($features_id_list))
            {
                $features_id_list[] = 0;
            }
            $sql = "SELECT `features`.* FROM (`features`) WHERE `feature_group_id` in (4,2) AND `feature_id` IN (";
            $sql .= join($features_id_list,',').") ORDER BY `features`.`id` ASC LIMIT 0, 1";
            $brands = $this->db->query($sql);
            foreach($brands as $_value)
            {
                $product_temp['brand_id']   = $_value->feature_id;
            }
            /*
            if($brands->count())
            {
                $product_temp['brand_id']   = $brands->current()->feature_id;
            }
             */
            //商品属性
            $product_temp['features'] = array();
            $sql = "SELECT `product_features`.* FROM (`product_features`) WHERE `site_id` = $site_id AND `product_id` = $_product->product_id ORDER BY `product_features`.`id` ASC";
            $product_features = $this->db->query($sql); 
            foreach($product_features as $keyf=>$_feature)
            { 
                //$feature = ORM::factory('feature',$_feature->feature_id)->as_array();
                if($_feature->feature_id <= 0 )
                {
                    continue;
                }

                $sql    = "SELECT `features`.* FROM (`features`) WHERE `features`.`feature_id` = $_feature->feature_id AND `feature_group_id` NOT IN (4,2) ORDER BY `features`.`feature_id` ASC LIMIT 0, 1";
                //值存在性验证
                if(!$this->db->query($sql)->count())
                {
                    continue;
                } 
                $feature = $this->db->query($sql)->current(); 
                $sql    = "SELECT * FROM (`feature_groups`) WHERE `feature_group_id` = $feature->feature_group_id ORDER BY `id` ASC LIMIT 0, 1";
                if(!$this->db->query($sql)->count())
                {
                    continue;
                } 

                $product_temp['features'][$keyf]['featureoption_id']     = $feature->feature_id;     
                $product_temp['features'][$keyf]['feature_id']           = $feature->feature_group_id;     
            }

            //商品规格
            $product_temp['goods']             = array();
            /*
            $product_attributes = ORM::factory('product_attribute')
                ->where('site_id',$site_id)
                ->where('product_id',$_product->id)
                ->orderby('default_on','ASC')
                ->find_all();
             */
            $sql    = "SELECT `product_attributes`.* FROM (`product_attributes`) WHERE `site_id` = $site_id AND `product_id` = $_product->product_id ORDER BY `default_on` ASC";
            $product_attributes = $this->db->query($sql); 
            foreach($product_attributes as $keya=>$_product_attribute)
            {
                $sql = "SELECT `product_attribute_combinations`.* FROM (`product_attribute_combinations`) WHERE `site_id` = $site_id AND `attribute_id` != 1 AND `product_attribute_id` = $_product_attribute->id ORDER BY `product_attribute_combinations`.`id` ASC";
                $product_attribute_combinations = $this->db->query($sql);
                if(!count($product_attribute_combinations))
                {
                    continue;
                } 
                $is_default=$keya?0:1;
                //$product_temp['goods'][$keya]['id']             = $_product_attribute->id;     
                $product_temp['goods'][$keya]['site_id']        = $site_id;     
                $product_temp['goods'][$keya]['on_sale']        = $_product_attribute->on_sale&&$product_temp['on_sale']?1:0;     
                $product_temp['goods'][$keya]['product_id']     = $_product_attribute->product_id;     
                $product_temp['goods'][$keya]['is_default']     = $is_default;     
                $product_temp['goods'][$keya]['sku']            = $product_temp['SKU'].'_'.($keya+1);   
                $product_temp['goods'][$keya]['price']          = $_product_attribute->price+$_product->price;     
                $product_temp['goods'][$keya]['market_price']   = $_product_attribute->price+$_product->market_price;     
                $product_temp['goods'][$keya]['cost']           = 0;
                $product_temp['goods'][$keya]['weight']         = $_product_attribute->weight+$_product->weight;
                $product_temp['goods'][$keya]['store']          = 50;     
                $product_temp['goods'][$keya]['sold_count']     = 0;     
                $product_temp['goods'][$keya]['title']          = $_product->name;     
                $product_temp['goods'][$keya]['create_timestamp']   = time();
                $product_temp['goods'][$keya]['update_timestamp']   = time();

                //货品规格
                $product_temp['goods'][$keya]['attributes']       = array(); 
                /*
                $product_attribute_combinations = ORM::factory('product_attribute_combination')
                    ->where('site_id',$site_id)
                    ->where('product_attribute_id',$_product_attribute->id)
                    ->find_all();
                 */
                foreach($product_attribute_combinations as $keypac=>$_combination)
                {
                    //$attribute = ORM::factory('attribute',$_combination->attribute_id)->as_array();
                    $sql = "SELECT `attributes`.* FROM (`attributes`) WHERE `attributes`.`attribute_id` = $_combination->attribute_id ORDER BY `attributes`.`id` ASC LIMIT 0, 1";
                    //值存在性验证
                    if(!$this->db->query($sql)->count())
                    {
                        continue;
                    } 
                    $attribute = $this->db->query($sql)->current(); 
                    $sql    = "SELECT * FROM (`attribute_groups`) WHERE `attribute_group_id` = $attribute->attribute_group_id ORDER BY `id` ASC LIMIT 0, 1";
                    //组存在性验证
                    if(!$this->db->query($sql)->count())
                    {
                        continue;
                    } 
                    $product_temp['goods'][$keya]['attributes'][$keypac]['attributeoption_id']     = $attribute->attribute_id;     
                    $product_temp['goods'][$keya]['attributes'][$keypac]['attribute_id']           = $attribute->attribute_group_id;     
                }

                //货品图片
                $product_temp['goods'][$keya]['images']       = array(); 
                /*
                $product_attribute_images = ORM::factory('product_attribute_image')
                    ->where('site_id',$site_id)
                    ->where('product_attribute_id',$_product_attribute->id)
                    ->find_all();
                 */
                $sql = "SELECT `product_attribute_images`.* FROM (`product_attribute_images`) WHERE `site_id` = $site_id AND `product_attribute_id` = $_product_attribute->id ORDER BY `product_attribute_images`.`id` ASC";
                $product_attribute_images = $this->db->query($sql); 
                foreach($product_attribute_images as $keyi=>$_image)
                {
                    //图片值存在性验证
                    $sql    = "SELECT * FROM (`product_images`) WHERE `product_image_id` = $_image->product_image_id ORDER BY `id` ASC LIMIT 0, 1";
                    if(!$this->db->query($sql)->count())
                    {
                        continue;
                    } 

                    $product_temp['goods'][$keya]['images'][$_image->product_image_id]     = $_image->product_image_id;     
                }
            }
            // 商品规格不存在
            if(!count($product_temp['goods']))
            {
                //$product_temp['goods'][0]['id']             = $_product_attribute->id;     
                $product_temp['goods'][0]['site_id']        = $site_id;     
                $product_temp['goods'][0]['on_sale']        = $product_temp['on_sale']?1:0;     
                $product_temp['goods'][0]['product_id']     = $_product_attribute->product_id;     
                $product_temp['goods'][0]['is_default']     = 1;     
                $product_temp['goods'][0]['sku']            = $product_temp['SKU'];     
                $product_temp['goods'][0]['price']          = $_product->price;     
                $product_temp['goods'][0]['market_price']   = $_product->market_price;     
                $product_temp['goods'][0]['cost']           = 0;     
                $product_temp['goods'][0]['weight']         = $_product->weight;     
                $product_temp['goods'][0]['store']          = 100;     
                $product_temp['goods'][0]['sold_count']     = 0;     
                $product_temp['goods'][0]['title']          = $_product->name;     
                $product_temp['goods'][0]['create_timestamp']   = time();
                $product_temp['goods'][0]['update_timestamp']   = time();

                $product_temp['goods'][0]['attributes']       = array(); 
                //货品图片
                $product_temp['goods'][0]['images']       = array(); 
                /*
                $product_images = ORM::factory('product_image')
                    ->where('site_id',$site_id)
                    ->where('product_id',$_product->id)
                    ->find_all();
                 */
                $sql    = "SELECT `product_images`.* FROM (`product_images`) WHERE `site_id` = $site_id AND `product_id` = $_product->product_id ORDER BY `product_images`.`id` ASC";
                $product_images = $this->db->query($sql); 
                foreach($product_images as $keyi=>$_image)
                {
                    $product_temp['goods'][0]['images'][$_image->product_image_id]     = $_image->product_image_id;     
                }
            }
            //相关商品
            $product_temp['relatives']             = array();
            /*
            $sql = "SELECT `product_relatives`.* FROM (`product_relatives`) WHERE `site_id` = $site_id AND `product_id` = $_product->id ORDER BY `product_relatives`.`id` ASC";
            $product_relatives = $this->db->query($sql); 
            foreach($product_relatives as $keyf=>$_relative)
            {
                $sql    = "SELECT * FROM (`products`) WHERE `site_id` = $site_id AND  `id` = $_relative->product_id ORDER BY `id` ASC LIMIT 0, 1";
                $product_vaild = $this->db->query($sql)->current(); 
                //商品值存在性验证
                if(!$product_vaild->id)
                {
                    continue; 
                }

                $product_temp['relatives'][$keyf]     = $_relative->relative_id;     
            }
             */
            $this->data[$keyc]     = $product_temp;
        }
        $this->end    = count($this->data);
    }

    public function reset()
    {
        $this->current_id = -1;
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
