<?php
class doc_Core {
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
     * 首页调用文案分类下
     *
     * @param int $index 文案分类顺序
     * @return array 文案数据数组
     */
    public static function index_one($index)
    {
        $result = Mydoc::instance()->index_one($index);
        return $result;
    }
    
    /*
     * 获取单条信息
     */
    public  function get_byid($id)
    {
        $id = intval($id);
        $obj = ORM::factory('doc');
        $obj->where('id', $id);
        $result = $obj->find();
        
        if ($obj->loaded)
        {
            return $result->as_array();
        }
        else 
        {
            return array();
        }
        
    }
    
}