<?php defined('SYSPATH') OR die('No direct access allowed.');

class Product_templateService_Core extends DefaultService_Core{
	
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
    
    /**
     * 判断站点是否存在模板
     *
     * @param int $site_id 站点ID
     * @return bool
     */
    public function is_template_exist($site_id){
    	$query_struct = array(
    		'where' => array('site_id' => $site_id),
    	);
    	$rows = $this->query_assoc($query_struct);
    	if (empty($rows)) {
    		return 0;
    	}else {
    		return $rows[0]['id'];
    	}
    }
    
    /**
     * 根据站点id获取模板信息
     *
     * @param int $site_id 站点ID
     * @return array 站点的模板
     */
    public function get_template_by_site($site_id){
    	$query_struct = array(
    		'where' => array('site_id' => $site_id),
    	);
    	$rows = $this->query_assoc($query_struct);
    	if (empty($rows)) {
    		return array();
    	}else {
    		return $rows[0];
    	}
    }
}