<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_attributeService_Core extends DefaultService_Core {
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
     * 验证补充user_profile
     * @param $user_profiles
     */
    public function add_default_attributes(&$user_attributes)
	{
		$default = kohana::config('user_attribute_type.system_default');
        //查看系统默认的是否齐全
        $default_data = array();
        foreach($user_attributes as $key=>$user_attribute)
        {
            if($user_attribute['attribute_default'])
            {
                $default_data[$user_attribute['attribute_name']] = $user_attribute;
                $default_data[$user_attribute['attribute_name']]['key'] = $key;
            }
        }
        $dafault_keys = array_keys($default);
        $dafault_data_keys = array_keys($default_data);
        $diff = array_diff($dafault_keys, $dafault_data_keys);
        if(!empty($diff))
        {
            //把系统默认的补充到数据库中
            foreach($diff as $key)
            {
                $name_default = array('attribute_name'=>$key,'attribute_default'=>1,'site_id'=>site::id());
                $tmp_arr = array_merge($name_default,$default[$key]);
                $tmp_arr['id'] = $this->add($tmp_arr);
                $user_attributes[] = $tmp_arr;
            }
        }
        //检查数据库中是否有多余的系统默认项
        $diff = array_diff($dafault_data_keys, $dafault_keys);
        foreach($diff as $key)
        {
            $this->set($default_data[$key]['id'], array('attribute_default'=>0));
            $user_attributes[$default_data[$key]['key']]['attribute_default'] = 0;
        }
    }
    
}