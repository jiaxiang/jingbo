<?php defined('SYSPATH') OR die('No direct access allowed.');

class ProductpicService_Core extends DefaultService_Core {
    //:: 本类定制的业务逻辑 :://
    //TODO 根据业务逻辑需求提供对应的函数调用
    
    const PRODUCTPIC_IS_DEFAULT_TRUE = 1;
    const PRODUCTPIC_IS_DEFAULT_FALSE = 0;
    
    const PRODUCTPIC_STANDARDS_COMMON = '_';
    
    const PRODUCTPIC_STANDARDS_ORIGINAL = 'o';
    const PRODUCTPIC_STANDARDS_TINY = 'ti';
    const PRODUCTPIC_STANDARDS_SQUARE = 'sq';
    const PRODUCTPIC_STANDARDS_THUMBNAIL = 't';
    const PRODUCTPIC_STANDARDS_SMALL = 's';
    const PRODUCTPIC_STANDARDS_MIDDLE = 'm';
    const PRODUCTPIC_STANDARDS_LARGE = 'l';
    
    /* 兼容php5.2环境 Start */
    private static $instance = NULL;
    
    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    /* 兼容php5.2环境 End */
    
    //路由实例管理实例
    private $serv_route_instance = NULL;
    
    /**
     * 获取路由实例管理实例
     */
    private function get_serv_route_instance(){
        if($this->serv_route_instance===NULL){
            $this->serv_route_instance = ServRouteInstance::getInstance(ServRouteConfig::getInstance());
        }
        return $this->serv_route_instance;
    }
    
    public function get($id){
        $servRouteInstance = $this->get_serv_route_instance();
        $cacheInstance = $servRouteInstance->getMemInstance($this->object_name,array('id'=>$id))->getInstance();
        $routeKey = $this->object_name.'_'.$id;
        $cacheObject = $cacheInstance->get($routeKey);
        if(empty($cacheObject)){
            $cacheObject = $this->read(array('id'=>$id));
            if(!empty($cacheObject)){
                $cacheInstance->set($routeKey,$cacheObject);
            }
        }
        return $cacheObject;
    }
    
    public function set($id,$data){
        $request_data = $data;
        $request_data['id'] = $id;
        $this->update($request_data);
        
        $servRouteInstance = $this->get_serv_route_instance();
        $cacheInstance = $servRouteInstance->getMemInstance($this->object_name,array('id'=>$id,))->getInstance();
        $routeKey = $this->object_name.'_'.$id;
        // 清理单体cache
        $cacheInstance->delete($routeKey,0);
    }
    
    public function remove($id){
        $this->delete(array('id'=>$id));
        $servRouteInstance = $this->get_serv_route_instance();
        $cacheInstance = $servRouteInstance->getMemInstance($this->object_name,array('id'=>$id,))->getInstance();
        $routeKey = $this->object_name.'_'.$id;
        // 清理单体cache
        $cacheInstance->delete($routeKey,0);
    }
    
    /**
     * 按商品图片id获取图片数据
     * @param int $productpic_id 商品图片id
     * @param string $stand 输出图片类型 原图/缩略图
     */
    public function get_stand_pic_by_productpic_id($product_id = 0, $productpic_id = 0, $stand = self::PRODUCTPIC_STANDARDS_THUMBNAIL){
        return $this->get_stand_pic(array(
            'type'=>1,
            'id'=>$productpic_id,
            'ref_id'=>$product_id,
        ),$stand);
    }
    
    /**
     * 按商品id获取图片数据
     * @param int $productpic_id 商品图片id
     * @param string $stand 输出图片类型 原图/缩略图
     */
    public function get_default_stand_pic_by_product_id($product_id = 0,$stand = self::PRODUCTPIC_STANDARDS_THUMBNAIL){
        return $this->get_stand_pic(array(
            'type'=>0,
            'id'=>0,
            'ref_id'=>$product_id,
        ),$stand);
    }
    
    /**
     * 根据查询条件获取指定图片数据
     * @param array $requestStruct
     * @param string $stand
     */
    private function get_stand_pic($request_struct,$stand = self::PRODUCTPIC_STANDARDS_THUMBNAIL){
        switch($request_struct['type']){
            case 1:
                    $query_struct = array(
                        'where'=>array(
                            'id'=>$request_struct['id'],
                            'product_id'=>$request_struct['ref_id'],
                        ),
                    );
                    $query_row = $this->query_row($query_struct);
                    if(!empty($query_row)){
                        $route_prefix = Kohana::config('attach.routePrefix');
                        $route_mask_view = Kohana::config('attach.routeMaskViewProduct');
                        $route_postfix = Kohana::config('attach.defaultPostfix');
                        return self::get_attach_url($route_prefix,$query_row['image_id'],$stand,$route_postfix,$route_mask_view);
                    }else{
                        throw new MyRuntimeException('data not found',404);
                    }
                break;
            case 0:
            default:
                break;
        }
    }
    
    /**
     * 按商品id获取图片信息列表
     * @param $product_id
     * @param $stand
     */
    public function get_stand_pic_list_by_product_id($product_id = 0,$stand = self::PRODUCTPIC_STANDARDS_THUMBNAIL){
        $query_struct = array(
            'where'=>array('product_id'=>$product_id,),
        );
        $result_assoc = $this->index($query_struct);
        if($result_assoc){
            $route_prefix = Kohana::config('attach.routePrefix');
            $route_mask_view = Kohana::config('attach.routeMaskViewProduct');
            $route_postfix = Kohana::config('attach.defaultPostfix');
            if($stand==self::PRODUCTPIC_STANDARDS_COMMON){
                foreach($result_assoc as $line=>$row){
                    $result_assoc[$line]['picurl_'.self::PRODUCTPIC_STANDARDS_ORIGINAL]=self::get_attach_url($route_prefix,$row['image_id'],self::PRODUCTPIC_STANDARDS_ORIGINAL,$route_postfix,$route_mask_view);
                    $result_assoc[$line]['picurl_'.self::PRODUCTPIC_STANDARDS_THUMBNAIL]=self::get_attach_url($route_prefix,$row['image_id'],self::PRODUCTPIC_STANDARDS_THUMBNAIL,$route_postfix,$route_mask_view);
                    $result_assoc[$line]['picurl_'.self::PRODUCTPIC_STANDARDS_LARGE]=self::get_attach_url($route_prefix,$row['image_id'],self::PRODUCTPIC_STANDARDS_LARGE,$route_postfix,$route_mask_view);
                }
            }else{
                foreach($result_assoc as $line=>$row){
                    $result_assoc[$line]['picurl_'.$stand]=self::get_attach_url($route_prefix,$row['image_id'],$stand,$route_postfix,$route_mask_view);
                }
            }
        }
        return $result_assoc;
    }
    
    public function get_stand_pic_by_pic_id($pic_id, $stand = self::PRODUCTPIC_STANDARDS_THUMBNAIL){
        $query_struct = array(
            'where'=>array('id'=>$pic_id),
        );
        
        $result_assoc = $this->index($query_struct);
        if(!empty($result_assoc)){
            $route_prefix = Kohana::config('attach.routePrefix');
            $route_mask_view = Kohana::config('attach.routeMaskViewProduct');
            $route_postfix = Kohana::config('attach.defaultPostfix');
            if($stand==self::PRODUCTPIC_STANDARDS_COMMON){
                foreach($result_assoc as $line=>$row){
                    $result_assoc[$line]['picurl_'.self::PRODUCTPIC_STANDARDS_ORIGINAL]=self::get_attach_url($route_prefix,$row['image_id'],self::PRODUCTPIC_STANDARDS_ORIGINAL,$route_postfix,$route_mask_view);
                    $result_assoc[$line]['picurl_'.self::PRODUCTPIC_STANDARDS_THUMBNAIL]=self::get_attach_url($route_prefix,$row['image_id'],self::PRODUCTPIC_STANDARDS_THUMBNAIL,$route_postfix,$route_mask_view);
                    $result_assoc[$line]['picurl_'.self::PRODUCTPIC_STANDARDS_LARGE]=self::get_attach_url($route_prefix,$row['image_id'],self::PRODUCTPIC_STANDARDS_LARGE,$route_postfix,$route_mask_view);
                }
            }else{
                foreach($result_assoc as $line=>$row){
                    $result_assoc[$line]['picurl_'.$stand]=self::get_attach_url($route_prefix,$row['image_id'],$stand,$route_postfix,$route_mask_view);
                }
            }
			$result_assoc = $result_assoc[0];
        }
        return $result_assoc;
    }

    /**
     * 当前商品有默认图片
     * @param $product_id
     */
    public function has_default_pic($product_id){
        $query_struct = array(
            'where'=>array(
                'product_id'=>$product_id,
                'is_default'=>self::PRODUCTPIC_IS_DEFAULT_TRUE,
            ),
        );
        $result_var = $this->query_count($query_struct);
        return $result_var>0;
    }

    /**
     * 设置商品的默认图片
     * @param int $productpic_id
     * @param int $product_id
     */
    public function set_default_pic_by_productpic_id($productpic_id, $product_id=0){
        $return_object = array();
        $productpic_object = $this->get($productpic_id);
        if($product_id>0 && $productpic_object['product_id']!=$product_id){
            throw new MyRuntimeException('商品 ID 不符',400);
        }
        if($productpic_object['is_default']==self::PRODUCTPIC_IS_DEFAULT_FALSE){
            $query_struct = array(
                'where'=>array(
                    'is_default'=>self::PRODUCTPIC_IS_DEFAULT_TRUE,
                    'id !='=>$productpic_id,
                ),
            );
            $product_id>0 && $query_struct['where']['product_id'] = $product_id;
            $last_productpic_object = $this->query_row($query_struct);
            if(!empty($last_productpic_object)){
                $last_productpic_object['is_default'] = self::PRODUCTPIC_IS_DEFAULT_FALSE;
                $request_data = array(
                    'is_default'=>self::PRODUCTPIC_IS_DEFAULT_FALSE,
                );
                $this->set($last_productpic_object['id'],$request_data);
                $return_object = $last_productpic_object;
            }
            
            $request_data = array(
                'is_default'=>self::PRODUCTPIC_IS_DEFAULT_TRUE,
            );
            $this->set($productpic_id,$request_data);
            
            if($productpic_object['product_id']>0)
            {
                ProductService::get_instance()->set($productpic_object['product_id'], array(
                	'default_image_id'    => $productpic_object['image_id'],
                    'update_time'         => time(),
                ));
            }
        }
    }
    
    /**
     * 删除商品图片
     * @param int $productpic_id
     * @param int $product_id
     */
    public function delete_productpic($productpic_id, $product_id){
        $return_object = array();
        $productpic_object = $this->get($productpic_id);
        $this->delete_productpic_attachment($productpic_object);
        $this->delete(array('id'=>$productpic_id));
        //$this->remove($productpic_id);
        if($productpic_object['is_default']==self::PRODUCTPIC_IS_DEFAULT_TRUE){
            // 设置下一个商品图片为默认图
            $query_struct = array(
                'where'=>array(
                    'product_id'=>$product_id,
                    'is_default'=>self::PRODUCTPIC_IS_DEFAULT_FALSE,
                    'id !='=>$productpic_id,
                ),
            );
            $next_productpic_object = $this->query_row($query_struct);
            if($next_productpic_object){
                $next_productpic_object['is_default'] = self::PRODUCTPIC_IS_DEFAULT_TRUE;
                $this->set_default_pic_by_productpic_id($next_productpic_object['id'],$product_id);
                $return_object = $next_productpic_object;
            } else {
            	ProductService::get_instance()->set($product_id, array(
            		'default_image_id'    => '',
            		'update_timestamp' => time(),
            	));
            }
        }
        return $return_object;
    }
    
    /**
     * 删除商品对应的附件数据和存储文件
     * @param unknown_type $productpic_object
     */
    public function delete_productpic_attachment($productpic_object){
        !empty($productpic_object['image_id']) && AttService::get_instance("product")->delete_img($productpic_object['image_id']);
        //$attachIds = array();
        //!empty($productpic_object['image_id']) && !in_array($productpic_object['image_id'],$attachIds) && $attachIds[]=$productpic_object['image_id'];
        //$attachIds = array_unique($attachIds);
        /* 调用附件服务
        require_once(Kohana::find_file('vendor', 'phprpc/phprpc_client',TRUE));
        !isset($attachmentService) && $attachmentService = new PHPRPC_Client(Kohana::config('phprpc.remote.Attachment.host'));
        !isset($phprpcApiKey) && $phprpcApiKey = Kohana::config('phprpc.remote.Attachment.apiKey');
        foreach($attachIds as $id){
            //$attachmentService->remove_attachment_data_by_attachment_id($id);
            $args = array($id);
            $sign = md5(json_encode($args).$phprpcApiKey);
            $attachmentService->phprpc_removeAttachmentDataByAttachmentId($id,$sign);
        }*/
    }
    
    /**
     * 获取附件url
     * @param $prefix
     * @param $attachment_id
     * @param $stand
     * @param $postfix
     */
    public static function get_attach_url($prefix = NULL, $attachment_id = 0, $stand = self::PRODUCTPIC_STANDARDS_THUMBNAIL, $postfix = NULL, $mask = NULL){
        $current_prefix = $prefix==NULL?Kohana::config('attach.routePrefix'):$prefix;
        $presets = Kohana::config('attach.sizePresets');
        $current_preset_string = !empty($presets[$stand])?'_'.$presets[$stand]:'';
        $current_postfix = $postfix==NULL?Kohana::config('attach.defaultPostfix'):$postfix;
        $current_postfix_string = !empty($current_postfix)?'.'.$current_postfix:'';
        $current_mask_string = $mask==NULL?Kohana::config('attach.routeMaskViewProduct'):$mask;
        return $current_prefix.str_replace(array('#id#','#preset#','#postfix#'),array($attachment_id,$current_preset_string,$current_postfix_string),$current_mask_string);
    }
}