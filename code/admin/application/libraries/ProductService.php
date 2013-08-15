<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 商品管理 Service
 * 
 */
class ProductService_Core extends DefaultService_Core {
	const PRODUCT_STATUS_DELETE  = 2;  // 删除
	const PRODUCT_STATUS_DRAFT   = 1;  // 草稿
	const PRODUCT_STATUS_PUBLISH = 0;  // 正常
    
    const PRODUCT_TYPE_ASSEMBLY = 2;         // 组合商品
    const PRODUCT_TYPE_CONFIGURABLE = 1;     // 可配置商品
    const PRODUCT_TYPE_GOODS = 0;            // 简单商品
    const PRODUCT_TYPE_GIFT_CARD = 3;        // 礼品卡
	
	const PRODUCT_RETAIL_ONLY = 0;           // 仅零售
	const PRODUCT_RETAIL_AND_WHOLESALE = 1;  // 即零售又批发
	const PRODUCT_WHOLESALE_ONLY = 2;        // 仅批发
	
	/* 兼容php5.2环境 Start */
    private static $instance = NULL;
    
    //路由实例管理实例
    private $serv_route_instance = NULL;
    
    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    /* 兼容php5.2环境 End */
	
	/**
     * 获取路由实例管理实例
     */
    private function get_serv_route_instance(){
        if($this->serv_route_instance===NULL){
            $this->serv_route_instance = ServRouteInstance::getInstance(ServRouteConfig::getInstance());
        }
        return $this->serv_route_instance;
    }


	/**
	 * 加减货品的库存
	 * @param $good_id
	 * @param $quantity
	 */
	public function update_store($good_id, $quantity)
	{
	    $good = $this->get($good_id);
	    if(empty($good))
	    {
	    	return false;
	    }
	    if($good['store'] >= 0)
	    {
	    	$store = $good['store']+$quantity;
	    	$store < 0 && $store=0;
	    }else{
	    	return true;
	    }
	    $data['store'] = $store;
	    $this->set($good_id, $data);
	    return true;
	}
    
    /**
     * 产品的抢购数据获得
     */
    protected function get_product_rush(& $product){
        $mk = 'admin_product_rush'.$product['product_id'];
        $datas =  Cache::get($mk);    
        if(empty($datas)){
            $where = " WHERE status='0' AND product_id='".$product['product_id']."' ";
            $sql = "SELECT * FROM product_rushes  
                    {$where}
                ";
            $rs = Database::instance()->query($sql)->result_array(false);
            if(empty($rs[0]) || $rs[0]['id']==0)return;
            $datas = $rs[0];
            Cache::set($mk, $datas);
        }
        
        if(!empty($datas['id']) && $datas['product_id']==$product['product_id']){
            $product['store'] = $datas['store'];
            $product['price'] = $datas['price_rush'];
            $product['title'] = $datas['title'];
            $product['max_buy'] = $datas['max_buy'];
            $product['is_rush'] = 1;
        }
    }
    
	/**
	 * 根据订单号减库存
	 * @param $order_id 订单的id
	 */
	public function updata_good_store_by_order_id($order_id){
        try{
	        $goods = Myorder_product::instance()->order_products(array('order_id'=>$order_id));
	        foreach($goods as $good_order){
                $this->get_product_rush($good_order);
                //抢购商品在前台订单生成时已经减过，后台不能重复减少
                if(isset($good_order['is_rush']) && $good_order['is_rush']==1){
                    continue;
                }
	        	$this->update_store($good_order['good_id'], -$good_order['quantity']);
	        }
        }catch (MyRuntimeException $ex){
        //TODO  订单支付成功但是货品不存在
        }
	}
        
	public function set($id,$data){
        $request_data = $data;
        $request_data['id'] = $id;
        $this->update($request_data);
        /*
        $servRouteInstance = $this->get_serv_route_instance();
        $cacheInstance = $servRouteInstance->getMemInstance($this->object_name,array('id'=>$id,))->getInstance();
        $routeKey = $this->object_name.'_'.$id;
        // 清理单体cache
        $cacheInstance->delete($routeKey,0);
        */
    }
	
    public function sku_exists($product_id, $sku)
    {
    	$query_struct = array('where'=>array(
    		'id !='   => $product_id,
    		'sku'     => $sku,
    	));
    	return $this->query_count($query_struct) > 0 ? TRUE : FALSE;
    }
    
	/**
	 * 通过商品ID获取该商品所属分类
	 * 
	 * @param  int $product_id
	 * @return array
	 * @throws MyRuntimeException
	 */
	public function get_category_by_product_id($product_id)
	{
		try {
			$product = $this->get($product_id);
			$product = coding::decode_product($product);
			
			$category_id = $product['category_id'];
			
			return CategoryService::get_instance()->get($category_id);
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
	
	/**
	 * 通过商品ID获取该商品所属品牌
	 * 
	 * @param  int $product_id
	 * @return array
	 * @throws MyRuntimeException
	 */
	public function get_brand_by_product_id($product_id)
	{
		try {
			$product = $this->get($product_id);
			$product = coding::decode_product($product);
			
			$brand_id = $product['brand_id'];
			
			throw BrandService::get_instance()->get($brand_id);
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
	
	/**
	 * 通过 product.id 获取该 product 所派生的 good
	 * 
	 * @param  int $product_id  商品ID
	 * @return array
	 * @throws MyRuntimeException
	 */
	public function get_goods_by_product_id($product_id)
	{
		// 初始化默认查询条件
        $request_struct = array(
            'where'		=> array(
                'product_id' => (int)$product_id,
			),
        );
        
        try {
        	return $this->query_assoc($request_struct);
        } catch (MyRuntimeException $ex) {
        	throw $ex;
        }
	}
	
	/**
	 * 通过 product.id 获取该 product 的默认 good
	 * 
	 * @param  int $product_id  商品ID
	 * @return array
	 * @throws MyRuntimeException
	 */
	public function get_default_good_by_product_id($product_id)
	{
		// 初始化默认查询条件
        $request_struct = array(
            'where'		=> array(
                'product_id' => (int)$product_id,
        		'is_default' => 1,
			),
        );
        
        try {
        	$goods = $this->query_assoc($request_struct);
        	if (empty($goods)) {
        		throw new MyRuntimeException('Object not found.');
        	}
        	return $goods[0];
        } catch (MyRuntimeException $ex) {
        	throw $ex;
        }
	}
	
	/**
	 * 通过 product.id 获取该 product 所派生的 good 数量
	 * 
	 * @param  int $product_id  商品ID
	 * @return int
	 * @throws MyRuntimeException
	 */
	public function get_goods_count_by_product_id($product_id)
	{
		$request_struct = array(
			'where' => array(
				'product_id' => (int)$product_id,
			)
		);
		
		try {
			return $this->query_count($request_struct);
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
	
	/**
	 * 通过 site.id 获取该站点下商品数量，可同时获取多个站
	 * 
	 * @param  int $site_ids  站点ID列表
	 * @return int
	 * @throws MyRuntimeException
	 */
	public function get_products_count_by_site_ids($site_ids)
	{
		$request_struct = array(
			'where' => array(
				'site_id' => (array)$site_ids,
			)
		);
		
		try {
			return $this->query_count($request_struct);
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
	
	/**
	 * 通过product.id 获取该 product 关联的规格 ID
	 * 
	 * @param  int $product_id
	 * @return array
	 * @throws MyRuntimeException
	 */
	public function get_relation_attribute_ids_by_product_id($product_id)
	{
		$return_array = array();
		try {
			$product = $this->get($product_id);
			$product = coding::decode_product($product);
			if (!empty($product['product_attribute_relation_struct']) AND !isset($product['product_attribute_relation_struct']['items'])) {
				$return_array = $product['product_attribute_relation_struct']['items'];
			}
			return $return_array;
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
	
	/**
	 * 通过product.id 获取该 product 关联的特性 ID
	 * 
	 * @param  int $product_id  商品ID
	 * @return array
	 * @throws MyRuntimeException
	 */
	public function get_relation_feature_ids_by_product_id($product_id)
	{
		$return_array = array();
		try {
			$product = $this->get($product_id);
			$product = coding::decode_product($product);
			if (!empty($product['product_feature_relation_struct']) AND !isset($product['product_feature_relation_struct']['items'])) {
				$return_array = $product['product_feature_relation_struct']['items'];
			}
			return $return_array;
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
	
	/**
	 * 通过 product.id 获取该 product 所关联的规格
	 * 
	 * @param  int $product_id  商品ID
	 * @return array
	 * @throws MyRuntimeException
	 */
	public function get_relation_attributes_by_product_id($product_id)
	{
		try {
			$attribute_ids = $this->get_relation_attribute_ids_by_product_id($product_id);
			if (!empty($attribute_ids)) {
				$request_struct = array(
					'where' => array(
						'id' => $attribute_ids,
					),
				);
				return AttributeService::get_instance()->query_assoc($request_struct);
			} else {
				return array();
			}
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
	
	/**
	 * 通过 product.id 获取该 product 所关联的特性
	 * 
	 * @param  int $product_id  商品ID
	 * @return array
	 * @throws MyRuntimeException
	 */
	public function get_relation_features_by_product_id($product_id)
	{
		try {
			$feature_ids = $this->get_relation_feature_ids_by_product_id($product_id);
			if (!empty($feature_ids)) {
				$request_struct = array(
					'where' => array(
						'id' => $feature_ids,
					),
				);
				return FeatureService::get_instance()->query_assoc($request_struct);
			} else {
				return array();
			}
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
	
	/**
	 * 通过商品ID获取完整的货品数据，包括货品关联、图片等
	 * 
	 * @param  int $product_id  货品ID
	 * @return array
				(
				    [product] => Array
				        (
				            [id] => 1
				            [site_id] => 1
				            [on_sale] => 1
				            [category_id] => 1
				            [brand_id] => 1
				            [sku] => 台
				            [title] => 阿迪王球鞋
				            [uri_name] => 球鞋
				            [category_ids] => Array
				                (
				                )
				
				            [product_tag_ids] => Array
				                (
				                )
				
				            [goods_price] => 100
				            [goods_attributeoption_relation_struct_default] => Array
				                (
				                    [items] => Array
				                        (
				                            [1] => Array
				                                (
				                                    [0] => 2
				                                )
				
				                            [2] => Array
				                                (
				                                    [0] => 4
				                                )
				
				                        )
				
				                )
				
				            [product_featureoption_relation_struct] => Array
				                (
				                    [items] => Array
				                        (
				                            [1] => 3
				                            [2] => 5
				                        )
				
				                )
				
				            [product_attribute_relation_struct] => Array
				                (
				                    [items] => Array
				                        (
				                            [0] => 1
				                            [1] => 2
				                        )
				
				                )
				
				            [product_feature_relation_struct] => Array
				                (
				                    [items] => Array
				                        (
				                            [0] => 1
				                            [1] => 2
				                        )
				
				                )
				
				            [goods_market_price] => 200
				            [goods_cost] => 50
				            [pic_url] => http://v2.kohana.cn/docs/lib/tpl/kohana/images/kohana.png
				            [product_tag_entities] => Array
				                (
				                )
				
				            [meta_title] => 阿迪王球鞋
				            [meta_keywords] => 阿迪王,球鞋,鞋
				            [meta_description] => 阿迪王,球鞋,鞋
				            [brief] => 这是一双破鞋
				            [name_manage] => 阿迪王球鞋
				            [store] => 100
				            [sold_count] => 34
				            [comments_count] => 0
				            [star_average] => 4.1
				            [create_timestamp] => 1273797691
				            [update_timestamp] => 1273797691
				        )
				
				    [goods] => Array
				        (
				            [1] => Array
				                (
				                    [id] => 1
				                    [on_sale] => 1
				                    [site_id] => 1
				                    [product_id] => 1
				                    [is_default] => 1
				                    [sku] => 靠
				                    [goods_attributeoption_relation_struct] => Array
				                        (
				                            [items] => Array
				                                (
				                                    [1] => 2
				                                    [2] => 4
				                                )
				
				                        )
				
				                    [price] => 200
				                    [market_price] => 0
				                    [cost] => 0
				                    [weight] => 0
				                    [store] => 10
				                    [sold_count] => 0
				                    [title] => 阿斯顿发生地方
				                    [create_timestamp] => 0
				                    [update_timestamp] => 0
				                )
				
				        )
				
				    [attributes] => Array
				        (
				            [1] => Array
				                (
				                    [id] => 1
				                    [site_id] => 1
				                    [name] => color
				                    [name_manage] => 颜色
				                    [meta_struct] => Array
				                        (
				                        )
				
				                    [options] => Array
				                        (
				                            [2] => Array
				                                (
				                                    [id] => 2
				                                    [site_id] => 1
				                                    [attribute_id] => 1
				                                    [name] => green
				                                    [name_manage] => 绿色
				                                    [order] => 0
				                                    [meta_struct] => Array
				                                        (
				                                            [itemval] => #ff0
				                                        )
				
				                                )
				
				                        )
				
				                )
				
				            [2] => Array
				                (
				                    [id] => 2
				                    [site_id] => 1
				                    [name] => grain
				                    [name_manage] => 质地
				                    [meta_struct] => Array
				                        (
				                        )
				
				                    [options] => Array
				                        (
				                            [4] => Array
				                                (
				                                    [id] => 4
				                                    [site_id] => 1
				                                    [attribute_id] => 2
				                                    [name] => cotton
				                                    [name_manage] => 全棉
				                                    [order] => 0
				                                    [meta_struct] => Array
				                                        (
				                                        )
				
				                                )
				
				                        )
				
				                )
				
				        )
				
				    [features] => Array
				        (
				            [1] => Array
				                (
				                    [id] => 1
				                    [site_id] => 1
				                    [name] => 材质
				                    [meta_struct] => Array
				                        (
				                        )
				
				                    [option] => Array
				                        (
				                            [id] => 3
				                            [site_id] => 1
				                            [feature_id] => 1
				                            [name] => 陶瓷
				                            [meta_struct] => Array
				                                (
				                                )
				
				                        )
				
				                )
				
				            [2] => Array
				                (
				                    [id] => 2
				                    [site_id] => 1
				                    [name] => 性别
				                    [meta_struct] => Array
				                        (
				                        )
				
				                    [option] => Array
				                        (
				                            [id] => 5
				                            [site_id] => 1
				                            [feature_id] => 2
				                            [name] => 女
				                            [meta_struct] => Array
				                                (
				                                )
				
				                        )
				
				                )
				
				        )
				
				    [pictures] => Array
				        (
				        )
				
				    [comment_count] => 0
				)
	 * @throws MyRuntimeException
	 */
	public function get_full_data_by_product_id($product_id)
	{
		$return_array = array(
			'product'       => NULL,
			'goods'         => array(),
			'attributes'    => array(),
			'features'      => array(),
			'pictures'      => array(),
			'comment_count' => 0,
		);
		
		try {
			// 获取 product
			$product = $this->get($product_id);
			$product = coding::decode_product($product);
			$return_array['product'] = $product;
			
			// 获取 product 的评论数量
			$request_struct = array('where' => array(
				'product_id' => $product['id'],
			));
			$comment_count = ProductcommentService::get_instance()->query_count($request_struct);
			$return_array['comment_count'] = $comment_count;
			
			// 获取 product 所派生的货品
			$goods    = $this->query_assoc($request_struct);
			$good_ids = array();
			$attributeoption_ids = array();
			foreach ($goods as $good) {
				$good = coding::decode_good($good);
				$return_array['goods'][$good['id']] = $good;
				$good_ids[] = $good['id'];
				if (!empty($good['goods_attributeoption_relation_struct']['items'])) {
					foreach ($good['goods_attributeoption_relation_struct']['items'] as $attribute_id => $attributeoption_id) {
						if (isset($attributeoption_ids[$attributeoption_id]) AND $attributeoption_ids[$attributeoption_id] != $attribute_id) {
							throw new MyRuntimeException('Internal error.', 500);
						} else {
							$attributeoption_ids[$attributeoption_id] = $attribute_id;
						}
					}
				}
			}
			
			if (!empty($product['product_attribute_relation_struct']['items'])) {
				$request_struct = array('where' => array(
					'id' => $product['product_attribute_relation_struct']['items'],
				));
				$attributes = AttributeService::get_instance()->query_assoc($request_struct);
				if (count($attributes) != count($product['product_attribute_relation_struct']['items'])) {
					throw new MyRuntimeException('Internal error.', 500);
				}
				foreach ($attributes as $attribute) {
					$attribute = coding::decode_attribute($attribute);
					if ($attribute['site_id'] == $product['site_id']) {
						$return_array['attributes'][$attribute['id']] = $attribute;
					} else {
						throw new MyRuntimeException('Internal error.', 500);
					}
				}
			} elseif (!empty($attributeoption_ids)) {
				throw new MyRuntimeException('Internal error.', 500);
			}
			
			if (!empty($attributeoption_ids)) {
				$request_struct = array('where' => array(
					'id' => array_keys($attributeoption_ids),
				));
				$attributeoptions = AttributeoptionService::get_instance()->query_assoc($request_struct);
				if (count($attributeoptions) != count($attributeoption_ids)) {
					throw new MyRuntimeException('Internal error.', 500);
				}
				foreach ($attributeoptions as $attributeoption) {
					$attributeoption = coding::decode_attributeoption($attributeoption);
					if (isset($return_array['attributes'][$attributeoption['attribute_id']]) AND $attributeoption_ids[$attributeoption['id']] == $attributeoption['attribute_id']) {
						if (!isset($return_array['attributes'][$attributeoption['attribute_id']]['options'])) {
							$return_array['attributes'][$attributeoption['attribute_id']]['options'] = array();
						}
						$return_array['attributes'][$attributeoption['attribute_id']]['options'][$attributeoption['id']] = $attributeoption;
					} else {
						throw new MyRuntimeException('Internal error.', 500);
					}
				}
			} elseif (!empty($product['product_attribute_relation_struct']['items'])) {
				throw new MyRuntimeException('Internal error.', 500);
			}
			
			if (!empty($product['product_attribute_relation_struct']['items'])) {
				foreach ($return_array['attributes'] as $attribute_id => $attribute) {
					if (!isset($attribute['options']) OR empty($attribute['options'])) {
						throw new MyRuntimeException('Internal error.', 500);
					}
				}
			}
			
			if (!empty($product['product_feature_relation_struct']['items'])) {
				$request_struct = array('where' => array(
					'id' => $product['product_feature_relation_struct']['items'],
				));
				$features = FeatureService::get_instance()->query_assoc($request_struct);
				if (count($product['product_feature_relation_struct']['items']) != count($features)) {
					throw new MyRuntimeException('Internal error.', 500);
				}
				foreach ($features as $feature) {
					$feature = coding::decode_feature($feature);
					if ($feature['site_id'] == $product['site_id']) {
						$return_array['features'][$feature['id']] = $feature;
					} else {
						throw new MyRuntimeException('Internal error.', 500);
					}
				}
			} elseif (!empty($product['product_featureoption_relation_struct']['items'])) {
				throw new MyRuntimeException('Internal error.', 500);
			}
			
			if (!empty($product['product_featureoption_relation_struct']['items'])) {
				$request_struct = array('where' => array(
					'id' => array_values($product['product_featureoption_relation_struct']['items']),
				));
				$featureoptions = FeatureoptionService::get_instance()->query_assoc($request_struct);
				if (count($featureoptions) != count($product['product_featureoption_relation_struct']['items'])) {
					throw new MyRuntimeException('Internal error.', 500);
				}
				foreach ($featureoptions as $featureoption) {
					$featureoption = coding::decode_featureoption($featureoption);
					if (isset($return_array['features'][$featureoption['feature_id']]) AND !isset($return_array['features'][$featureoption['feature_id']]['option']) AND isset($product['product_featureoption_relation_struct']['items'][$featureoption['feature_id']]) AND $product['product_featureoption_relation_struct']['items'][$featureoption['feature_id']] == $featureoption['id']) {
						$return_array['features'][$featureoption['feature_id']]['option'] = $featureoption;
					} else {
						throw new MyRuntimeException('Internal error.', 500);
					}
				}
			} elseif (!empty($product['product_feature_relation_struct']['items'])) {
				throw new MyRuntimeException('Internal error.', 500);
			}
			
			if (!empty($product['product_feature_relation_struct']['items'])) {
				foreach ($return_array['features'] as $feature_id => $feature) {
					if (!isset($feature['option'])) {
						throw new MyRuntimeException('Internal error.', 500);
					}
				}
			}
			
			return $return_array;
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
	
	/**
	 * 通过商品ID获取该商品所关联的规格及规格项
	 * 
	 * @param  int $product_id  商品ID
	 * @return array
				(
				    [1] => Array
				        (
				            [id] => 1
				            [site_id] => 1
				            [name] => color
				            [name_manage] => 颜色
				            [meta_struct] => Array
				                (
				                )
				
				            [options] => Array
				                (
				                    [2] => Array
				                        (
				                            [id] => 2
				                            [site_id] => 1
				                            [attribute_id] => 1
				                            [name] => green
				                            [name_manage] => 绿色
				                            [order] => 0
				                            [meta_struct] => Array
				                                (
				                                    [itemval] => #ff0
				                                )
				
				                        )
				
				                )
				
				        )
				
				    [2] => Array
				        (
				            [id] => 2
				            [site_id] => 1
				            [name] => grain
				            [name_manage] => 质地
				            [meta_struct] => Array
				                (
				                )
				
				            [options] => Array
				                (
				                    [4] => Array
				                        (
				                            [id] => 4
				                            [site_id] => 1
				                            [attribute_id] => 2
				                            [name] => cotton
				                            [name_manage] => 全棉
				                            [order] => 0
				                            [meta_struct] => Array
				                                (
				                                )
				
				                        )
				
				                )
				
				        )
				
				)
	 * @throws MyRuntimeException
	 */
	public function get_relation_attribute_options_by_product_id($product_id)
	{
		$return_array = array();
		
		try {
			$product = $this->get($product_id);
			$product = coding::decode_product($product);
			
			// 查询该商品派生的所有 货品
			$request_struct = array(
				'where' => array(
					'product_id' => $product['id'],
				),
			);
			$goods = $this->query_assoc($request_struct);
			
			if (!empty($goods)) {
				$attribute_options = array();
				foreach ($goods as $good) {
					$good = coding::decode_good($good);
					if (empty($good['goods_attributeoption_relation_struct']['items'])) {
						continue;
					}
 					$attributeoption_relation = & $good['goods_attributeoption_relation_struct']['items'];
 					foreach ($attributeoption_relation as $attribute_id => $attributeoption_id) {
 						if (!isset($attribute_options[$attribute_id])) {
 							$attribute_options[$attribute_id] = array();
 						}
 						$attribute_options[$attribute_id][] = $attributeoption_id;
 					}
				}
				//$attribute_options     = $good['goods_attributeoption_relation_struct']['items'];
				$attribute_ids         = array();
				$attributeoption_ids   = array();
				// attributeoption.id 数量计数器
				$attributeoption_count = 0;
				
				foreach ($attribute_options as $attribute_id => $elements) {
					$attribute_ids[$attribute_id] = TRUE;
					foreach ($elements as $attributeoption_id) {
						$attributeoption_ids[$attributeoption_id] = TRUE;
						$attributeoption_count ++;
					}
				}
				
				// 各个 attribute.id 之下的 attributeoption.id 不可出现重复
				if (count($attributeoption_ids) != $attributeoption_count) {
					throw new MyRuntimeException('Relation data error.', 500);
				}
				
				// 获取 attribute.id 和 attributeoption.id 列表
				$attribute_ids       = array_keys($attribute_ids);
				$attributeoption_ids = array_keys($attributeoption_ids);
				
				// 查询 attribute
				$request_struct = array(
					'where' => array(
						'id'      => $attribute_ids,
					),
				);
				$attributes = AttributeService::get_instance()->query_assoc($request_struct);
				// 确保每一个 attribute.id 都是有效的
				if (count($attributes) != count($attribute_ids)) {
					throw new MyRuntimeException('Relation data error.', 500);
				}
				
				// 查询 attributeoption
				$request_struct = array(
					'where' => array(
						'id' => $attributeoption_ids,
					)
				);
				$attributeoptions = AttributeoptionService::get_instance()->query_assoc($request_struct);
				// 确保每一个 attributeoption.id 都是有效的
				if (count($attributeoptions) != count($attributeoption_ids)) {
					throw new MyRuntimeException('Relation data error.', 500);
				}
				
				foreach ($attributes as $attribute) {
					$attribute = coding::decode_attribute($attribute);
					// attribute 必须与 good 处于同一站点当中
					if ($attribute['site_id'] == $product['site_id']) {
						$return_array[$attribute['id']] = $attribute;
					} else {
						throw new MyRuntimeException('Relation data error.', 500);
					}
				}
				
				foreach ($attributeoptions as $attributeoption) {
					$attributeoption = coding::decode_attributeoption($attributeoption);
					// 检查 attributeoption 与 attribute 的从属关系
					if (isset($return_array[$attributeoption['attribute_id']]) AND isset($attribute_options[$attributeoption['attribute_id']]) AND in_array($attributeoption['id'], $attribute_options[$attributeoption['attribute_id']])) {
						if (!isset($return_array[$attributeoption['attribute_id']]['options'])) {
							$return_array[$attributeoption['attribute_id']]['options'] = array();
						}
						$return_array[$attributeoption['attribute_id']]['options'][$attributeoption['id']] = $attributeoption;
					} else {
						throw new MyRuntimeException('Relation data error.', 500);
					}
				}
			}
			
			return $return_array;
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
	
	/**
	 * 通过商品ID获取该商品所关联的特性及特性项
	 * 
	 * @param  int $product_id  商品ID
	 * @return array
				(
				    [1] => Array
				        (
				            [id] => 1
				            [site_id] => 1
				            [name] => 材质
				            [meta_struct] => Array
				                (
				                )
				
				            [option] => Array
				                (
				                    [id] => 3
				                    [site_id] => 1
				                    [feature_id] => 1
				                    [name] => 陶瓷
				                    [meta_struct] => Array
				                        (
				                        )
				
				                )
				
				        )
				
				    [2] => Array
				        (
				            [id] => 2
				            [site_id] => 1
				            [name] => 性别
				            [meta_struct] => Array
				                (
				                )
				
				            [option] => Array
				                (
				                    [id] => 5
				                    [site_id] => 1
				                    [feature_id] => 2
				                    [name] => 女
				                    [meta_struct] => Array
				                        (
				                        )
				
				                )
				
				        )
				
				)
	 * @throws MyRuntimeException
	 */
	public function get_relation_feature_options_by_product_id($product_id)
	{
		$return_array = array();
		
		try {
			$product = $this->get($product_id);
			$product = coding::decode_product($product);
			
			if (!empty($product['product_featureoption_relation_struct']['items'])) {
				$feature_options   = & $product['product_featureoption_relation_struct']['items'];
				
				// 分别获取 feature.id 和 featureoption.id
				$feature_ids       = array_keys($feature_options);
				$featureoption_ids = array_values($feature_options);
				
				// 查询 feature
				$request_struct = array('where' => array(
					'id' => $feature_ids,
				));
				$features = FeatureService::get_instance()->query_assoc($request_struct);
				// 确保每一个ID都是有效的
				$feature_count = count($features);
				if ($feature_count != count($feature_options)) {
					throw new MyRuntimeException('Relation data error.', 500);
				}
				
				// 组装返回数组当中的 features
				foreach ($features as $feature) {
					$feature = coding::decode_feature($feature);
					// 验证 feature.site_id 必须与 product.site_id 相同
					if ($feature['site_id'] == $product['site_id']) {
						$return_array[$feature['id']] = $feature;
					} else {
						throw new MyRuntimeException('Relation data error.', 500);
					}
				}
				
				// 查询 featureoption
				$request_struct = array('where' => array(
					'id' => $featureoption_ids,
				));
				$featureoptions = FeatureoptionService::get_instance()->query_assoc($request_struct);
				// feature 和 featureoption 必须成对出现
				if ($feature_count != count($featureoptions)) {
					throw new MyRuntimeException('Relation data error.', 500);
				}
				
				// 组装返回数组当中的 options
				foreach ($featureoptions as $featureoption) {
					$featureoption = coding::decode_featureoption($featureoption);
					// 检查 featureoption 与 feature 的从属关系，当 featureoption 不属于 feature 时，输出错误
					if (isset($return_array[$featureoption['feature_id']]) AND !isset($return_array[$featureoption['feature_id']]['option']) AND $featureoption['id'] == $feature_options[$featureoption['feature_id']]) {
						$return_array[$featureoption['feature_id']]['option'] = $featureoption;
					} else {
						throw new MyRuntimeException('Relation data error.', 500);
					}
				}
			}
			
			return $return_array;
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
	
	public function get_relation_products_by_product_id($product_id)
	{
		$relation_ids = array();
		$query_struct = array('where'=>array(
			'product_id' => $product_id,
		));
		foreach (Product_relationService::get_instance()->query_assoc($query_struct) as $relation) {
			$relation_ids[] = $relation['relation_product_id'];
		}
		
		$relations = array();
		if (!empty($relation_ids)) {
			$relations = $this->query_assoc(array('where'=>array(
				'id' => $relation_ids,
			)));
			
			$category_ids = array();
			$brand_ids    = array();
			foreach ($relations as $relation) {
				$category_ids[$relation['category_id']] = TRUE;
				if ($relation['brand_id'] > 0) {
					$brand_ids[$relation['brand_id']] = TRUE;
				}
			}
			
			$categroys = array();
			if (!empty($category_ids)) {
				$query_struct = array('where'=>array(
					'id' => array_keys($category_ids),
				));
				foreach (CategoryService::get_instance()->query_assoc($query_struct) as $category) {
					$categroys[$category['id']] = $category;
				}
			}
			
			$brands = array();
			if (!empty($brand_ids)) {
				$query_struct = array('where'=>array(
					'id' => array_keys($brand_ids),
				));
				foreach (BrandService::get_instance()->query_assoc($query_struct) as $brand) {
					$brands[$brand['id']] = $brand;
				}
			}
			
			foreach($relations as $key => $relation) {
				$relation['category'] = array();
				if (isset($categroys[$relation['category_id']])) {
					$relation['category'] = $categroys[$relation['category_id']];
				}
				if (isset($brands[$relation['brand_id']])) {
					$relation['brand'] = $brands[$relation['brand_id']];
				}
				$relations[$key] = $relation;
			}
		}
		
		return $relations;
	}
	
	/**
	 * 设置 product 的 feature 以及 featureoption
	 * 
	 * @param  int   $product_id  商品ID
	 * @param  array $features    特性设置键值对：array('1' => '3', '2' => '7')，键为 特性ID，值为该特性之下的某个特性项
	 * @return array
	 * @throws MyRuntimeException
	 */
	public function set_features($product_id, $features)
	{
		$return_array = array();
		
		if (empty($features)) {
			return $return_array;
		}
		
		try {
			$product = $this->get($product_id);
			$product = coding::decode_product($product);
			
			$features = $this->clear_features_by_site_id($product['site_id'], $features);
			
			if (empty($features)) {
				return $return_array;
			}
			
			$relation_struct = $product['product_featureoption_relation_struct'];
			if (empty($relation_struct['items'])) {
				$relation_struct['items'] = array();
			}
			
			$product_featureoption_relation_service = Product_featureoption_relationService::get_instance();
			$product_featureoption_relation_orm     = ORM::factory('product_featureoption_relation');
			
			foreach ($relation_struct['items'] as $feature_id => $featureoption_id) {
				if (!isset($features[$feature_id]) OR $features[$feature_id] != $featureoption_id) {
					$product_featureoption_relation_orm->where('featureoption_id', $featureoption_id);
					$product_featureoption_relation_orm->where('feature_id', $feature_id);
					$product_featureoption_relation_orm->where('site_id', $product['site_id']);
					if ($product_featureoption_relation_orm->delete_all()) {
						unset($relation_struct['items'][$feature_id]);
					}
				}
			}
			
			foreach ($features as $feature_id => $featureoption_id) {
				if (!isset($relation_struct['items'][$feature_id])) {
					$relation = array(
						'site_id'          => $product['site_id'],
						'product_id'       => $product['id'],
						'feature_id'       => $feature_id,
						'featureoption_id' => $featureoption_id,
					);
					if ($product_featureoption_relation_service->create($relation)) {
						$relation_struct['items'][$feature_id] = $featureoption_id;
					}
				}
			}
			
			$update_struct = array(
				'id' => $product['id'],
				'product_featureoption_relation_struct' => $relation_struct,
				'product_feature_relation_struct'       => array('items' => array_keys($relation_struct['items'])),
			);
			$update_struct = coding::encode_product($update_struct);
			$this->update($update_struct);
			
			$return_array = $relation_struct['items'];
			
			return $return_array;
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
	
	/**
	 * 根据 site.id 清除 attribute.id 与 attributeoption.id 键值对当中不合法的部分
	 * 
	 * @param  int   $site_id     站点ID
	 * @param  array $attributes  规格键值对：array('1' => array('3','5'), '2' => '7')，键为 规格ID，值为该规格之下的一个或多个规格项
	 * @return array
	 */
	public function clear_attribute_options_by_site_id($site_id, $attributes)
	{
		$return_array = array();
		try {
			// 获取所有的 attribute.id和attributeoption.id，并清理掉其中重复的部分
			$attribute_ids       = array();
			$attributeoption_ids = array();
			foreach ($attributes as $attribute_id => $elements) {
				$attribute_id = (int)$attribute_id;
				$attribute_ids[$attribute_id] = TRUE;
				if (is_array($attributes[$attribute_id])) {
					$attributes[$attribute_id] = array();
					foreach ($elements as $attributeoption_id) {
						$attributeoption_id = (int)$attributeoption_id;
						$attributeoption_ids[$attributeoption_id] = TRUE;
						$attributes[$attribute_id][$attributeoption_id] = TRUE;
					}
				} else {
					$attributeoption_id = (int)$elements;
					$attributeoption_ids[$attributeoption_id] = TRUE;
				}
			}
			$attribute_ids       = array_keys($attribute_ids);
			$attributeoption_ids = array_keys($attributeoption_ids);
			// 构建查询条件，通过此次查询过滤掉不属于该站点下的 attribute
			$attribute_request_struct = array(
				'where' => array(
					'id'      => $attribute_ids,
					'site_id' => $site_id,
				),
			);
			
			// 构建查询结构体，用于查找各个 attribute 之下的 attributeoption
			$attributeoption_request_struct = array(
				'where' => array(
					'id'      => $attributeoption_ids,
					'site_id' => $site_id,
				),
			);
			
			$attribute_service = AttributeService::get_instance();
			$attribute_records = $attribute_service->query_assoc($attribute_request_struct);
			
			if (!empty($attribute_records)) {
				foreach ($attribute_records as $attribute) {
					$return_array[$attribute['id']] = array();
				}
				
				$attributeoption_service = AttributeoptionService::get_instance();
				$attributeoption_records = $attributeoption_service->query_assoc($attributeoption_request_struct);
				
				foreach ($attributeoption_records as $attributeoption) {
					$attribute_id       = $attributeoption['attribute_id'];
					$attributeoption_id = $attributeoption['id'];
					if (isset($return_array[$attribute_id])) {
						if (is_array($attributes[$attribute_id])) {
							if (isset($attributes[$attribute_id][$attributeoption_id])) {
								$return_array[$attribute_id][] = $attributeoption_id;
							}
						} else {
							if ($attributes[$attribute_id] == $attributeoption_id) {
								$return_array[$attribute_id] = $attributeoption_id;
							}
						}
					}
				}
				
				// 过滤掉未匹配到 attributeoption 的项
				foreach ($return_array as $attribute_id => $attributeoption_ids) {
					if (empty($attributeoption_ids)) {
						unset($return_array[$attribute_id]);
					}
				}
			}
			
			return $return_array;
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
	
	/**
	 * 通过商品 ID 删除商品
	 * 
	 * @param  int $product_id
	 * @return void
	 * @throws MyRuntimeException
	 */
	public function delete_by_product_id($product_id)
	{
		try {
			$product = $this->get($product_id);
			$product = coding::decode_product($product);
			
			$this->remove_prev_product_cache($product['id'], $product['category_id']);
			$this->remove_next_product_cache($product['id'], $product['category_id']);
			
			// 删除货品
			ORM::factory('good')->where('product_id', $product['id'])->delete_all();
			ORM::factory('goods_attributeoption_relation')->where('product_id', $product['id'])->delete_all();
			ORM::factory('goods_productpic_relation')->where('product_id', $product['id'])->delete_all();
			
			// 删除商品与虚拟集合的关联
			$result = ORM::factory('collection_product_relation')->where('product_id', $product['id'])->find_all()->as_array();
			$collection_relations = array_map(create_function('$item', 'return $item->as_array();'), $result);
			foreach($collection_relations as $collection_relation){
			    CollectionService::get_instance()->clear($collection_relation['collection_id']);
			}
			ORM::factory('collection_product_relation')->where('product_id', $product['id'])->delete_all();
			
			// 删除商品描述
			ORM::factory('productdescsection')->where('product_id', $product['id'])->delete_all();
			// 删除商品评论
			ORM::factory('productcomment')->where('product_id', $product['id'])->delete_all();
			// 删除商品与规格项关联
			ORM::factory('product_attributeoption_relation')->where('product_id', $product['id'])->delete_all();
			// 删除商品与特性项关联
			ORM::factory('product_featureoption_relation')->where('product_id', $product['id'])->delete_all();
			// 删除商品与规格项以及商品图片的关联
			ORM::factory('product_attributeoption_productpic_relation')->where('product_id', $product['id'])->delete_all();
			
			ORM::factory('product_relation')->where('product_id', $product['id'])->delete_all();
			ORM::factory('product_relation')->where('relation_product_id', $product['id'])->delete_all();
			
			// 删除产品批发数据
			ORM::factory('product_wholesale')->where('product_id', $product['id'])->delete_all();
			
			//删除商品咨询
			ORM::factory('productinquiry')->where('product_id', $product['id'])->delete_all();
			
			// 删除产品图片
			$productpic_service = ProductpicService::get_instance();
			foreach ($productpic_service->query_assoc(array('where'=>array('product_id'=>$product['id']))) as $picture)
			{
				$productpic_service->delete_productpic($picture['id'], $product['id'], $product['site_id']);
			}
			// 商品及货品图片删除
			//ORM::factory('productpic')->where('product_id', $product['id'])->delete_all();
			
			$this->remove($product['id']);
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
	
	public function remove_prev_product_cache($product_id, $category_id)
	{
		$prev_id = $this->get_prev_id_by_product_id($product_id, $category_id);
		$serv_route_instance = ServRouteInstance::getInstance(ServRouteConfig::getInstance());
		if ($prev_id > 0)
		{
			$cache_instance = $serv_route_instance->getMemInstance($this->object_name, array('id' => $prev_id))->getInstance();
        	$cache_instance->delete($this->object_name . '_' . $prev_id);
		}
	}
	
	public function remove_next_product_cache($product_id, $category_id)
	{
		$serv_route_instance = ServRouteInstance::getInstance(ServRouteConfig::getInstance());
		$next_id = $this->get_next_id_by_product_id($product_id, $category_id);
		if ($next_id > 0)
		{
			$cache_instance = $serv_route_instance->getMemInstance($this->object_name, array('id' => $next_id))->getInstance();
        	$cache_instance->delete($this->object_name . '_' . $next_id);
		}
	}
	
	public function get_prev_id_by_product_id($product_id, $category_id)
	{
		$query_struct = array(
        	'where' => array(
        		'id <'        => $product_id,
				'status'      => self::PRODUCT_STATUS_PUBLISH,
				'category_id' => $category_id,
        	),
        	'orderby' => array(
        		'id' => 'DESC',
        	),
        	'limit' => array(
        		'page'     => 1,
        		'per_page' => 1,
        	),
        );
        $prev_product = $this->query_assoc($query_struct);
        if (!empty($prev_product)) {
        	return $prev_product[0]['id'];
        } else {
        	return 0;
        }
	}
	
	public function get_next_id_by_product_id($product_id, $category_id)
	{
		$query_struct = array(
        	'where' => array(
        		'id >'        => $product_id,
				'status'      => self::PRODUCT_STATUS_PUBLISH,
				'category_id' => $category_id,
        	),
        	'orderby' => array(
        		'id' => 'ASC',
        	),
        	'limit' => array(
        		'page'     => 1,
        		'per_page' => 1,
        	),
        );
        $next_product = $this->query_assoc($query_struct);
        if (!empty($next_product)) {
        	return $next_product[0]['id'];
        } else {
        	return 0;
        }
	}
	
    /**
     * 根据name_manage[管理名称]检查是否重复
     * @param $site_id  int
     * @param $name_manage  string
     * @return bool
     */
    public function check_exist_name_manage($name_manage)
    {
        $query_struct = array (
            'where' => array (
                'name_manage' => $name_manage 
            ) 
        );
        if($this->count($query_struct))
        return true;
    }
}
