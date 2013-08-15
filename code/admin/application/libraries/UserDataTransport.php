<?php defined('SYSPATH') OR die('No direct access allowed.');
class UserDataTransport_Core extends DefaultDataTransport_Service {
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
        $sql    = "SELECT `users`.* FROM (`users`) WHERE `site_id` = $site_id ORDER BY `users`.`id` ASC"; 
        $users = $this->db->query($sql); 
        foreach($users as $keyc=>$_user)
        {
            $user_temp                      = array();
            $user_temp['id']                = $_user->id;
            $user_temp['site_id']           = $_user->site_id;
            $user_temp['email']             = $_user->email;
            $user_temp['title']             = ' ';
            $user_temp['firstname']         = $_user->firstname;
            $user_temp['lastname']          = $_user->lastname;
            $user_temp['password']          = $_user->password;
            $user_temp['birthday']          = '0000-00-00 00:00:00';
            //生日与title的再检查
            $sql    = "SELECT `profiles`.* FROM (`profiles`) WHERE `site_id` = $site_id AND `user_id` = $_user->id ORDER BY `profiles`.`id` ASC LIMIT 0, 1"; 
            $query = $this->db->query($sql);
            if($query->count())
            {
                foreach($query as $_query){
                    $user_temp['title'] = $_query->title;
                    if($_query->birthday != 0)
                    {
                        $user_temp['birthday'] = date('Y-m-d',$_query->birthday);
                    }
                }
            }
            if($_user->date_add)
            {
                $user_temp['date_add']          = date('Y-m-d H:m:s',$_user->date_add);
            }else{
                $user_temp['date_add'] = '0000-00-00 00:00:00';
            }
            $user_temp['ip']                = $_user->ip_add;
            $user_temp['active']            = $_user->active;
            $this->data[$keyc]              = $user_temp;
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
