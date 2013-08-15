<?php defined('SYSPATH') OR die('No direct access allowed.');
/*
 * 竞彩足球输出接口
 */
class Checknum_Controller extends Template_Controller {    
    
    public function __construct()
    {
        parent::__construct();
        $this->source_rqspf = 'http://jiaxianglu.gicp.net/XmlLog/13_1_1.xml';
        $this->source_zjqs = 'http://jk.caipiao.surbiz.com/xml/13_1_1.xml';
        $this->source_bf = 'http://jk.caipiao.surbiz.com/xml/13_1_1.xml';
        $this->source_bqc = 'http://jk.caipiao.surbiz.com/xml/13_1_1.xml';
        $this->cache_time = 30*60;
        $this->cache_mark = 'match_';
    }

    //竞彩足球胜平负
    public function index() {
        
        if (empty($_POST))
            exit('Error submit!');

        $post['data'] = $this->input->post('data');

        //echo "{code:-1,msg:''}";
        echo "{code:-1,msg:'ddddddddddd'}";
        
    }
    
    
    
    
}
