<?php defined('SYSPATH') OR die('No direct access allowed.');
/*
 * 竞彩篮球输出接口
 */
class Jclq_Controller extends Template_Controller {    
    private $source_rfsf;        //让分胜负输入接口
    private $source_sf;          //胜负输入接口   
    private $source_sfc;         //胜分差输入接口
    private $source_dxf;         //大小分输入接口
    
    private $cache_time;         //缓存时间
    private $cache_mark;         //缓存标识前缀  
    
    public function __construct()
    {
        parent::__construct();
        $weburl = 'http://jiaxianglu.gicp.net/XmlLog/';
        $weburl = 'http://jk.caipiao.surbiz.com/xml/';
        $this->source_rfsf = $weburl.'13_2_6.xml';
        $this->source_sf = $weburl.'13_2_7.xml';
        $this->source_sfc = $weburl.'13_2_8.xml';
        $this->source_dxf = $weburl.'13_2_9.xml';

        $this->cache_time = 30*60;
        $this->cache_mark = 'match_';
        $this->cache_close = FALSE;
    }

	//竞彩篮球胜负
    public function xml_1_2() {
        $results = array();
        $match_mark = $this->cache_mark.'13_2_7';    
        $ticket_type = 6;
		$play_type = 1;
		
		exit();
		
        $config = kohana::config('cache');
        $mem = @mems::instance($config['sources']['default']['option']);
        $results = $mem->get($match_mark);
        $this->cache_close && $results = array();
        
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );        
        
        if (empty($results))
        {
            //获取新数据
            $results = array();
            try 
            {
                $return_data = array();
                $return_struct['status']  = 1;
                $return_struct['code']    = 200;
                $return_struct['msg']     = '';
                $return_struct['content'] = $return_data;
                
                $doc = new DOMDocument();
                $doc->load($this->source_sf);
                $matchs = $doc->getElementsByTagName("Match");
                
                $result = array();
                $i = 0;                
                    foreach($matchs as $match) {
                        $data = array();
                        $data['match_num'] = intval($match->getAttribute("num"));
                        $data['match_id'] = intval($match->getAttribute("ID"));
                        
                        $pool = $match->getElementsByTagName("Pool");
                        
                        $data['pool_id'] = $pool->item(0)->getAttribute("ID");
                        
                        $comb = $match->getElementsByTagName("Comb");
                        $result['a']['c'] = $comb->item(0)->getAttribute("c");
                        $result['a']['v'] = $comb->item(0)->getAttribute("v");
                        $result['a']['d'] = $comb->item(0)->getAttribute("d");
                        $result['a']['t'] = $comb->item(0)->getAttribute("t");
                        
                        $result['h']['c'] = $comb->item(1)->getAttribute("c");
                        $result['h']['v'] = $comb->item(1)->getAttribute("v");
                        $result['h']['d'] = $comb->item(1)->getAttribute("d");
                        $result['h']['t'] = $comb->item(1)->getAttribute("t");
                        
                        $data['comb'] = json_encode($result);
                        $data['update_time'] = tool::get_date();
                        $data['play_type'] = $play_type;
                        $data['ticket_type'] = $ticket_type;
                        $objmatch = match::get_instance();
                        $objmatch->update($data);
                        
                        $results[] = $data;
                    }
            } 
            catch (MyRuntimeException $ex)
            {
                $this->_ex($ex, $return_struct, $request_data);
            }
            
            $mem->set($match_mark, $results, 1, $this->cache_time);
        }
        
        empty($results) && $results = array();
		header("Content-type:text/xml");
        header("Cache-Control: no-cache");
        $show = '<?xml version="1.0" encoding="utf-8"?>';
        $show .= '<xml>';

    	foreach ($results as $result) {
            $comb = json_decode($result['comb']);
            $show .= '<m id="'.$result['pool_id'].'" win="'.$comb->h->v.'" lost="'.$comb->a->v.'" time="'.$comb->a->d.' '.$comb->a->t.'" />';
        }
        $show .= '</xml>';
        
        echo $show;
    }
    

    //竞彩篮球让分胜负
    public function xml_2_2() {
        $results = array();
        $match_mark = $this->cache_mark.'13_2_6';
        $ticket_type = 6;
		$play_type = 2;
		
		exit();
        
        $config = kohana::config('cache');
        $mem = @mems::instance($config['sources']['default']['option']);
        $results = $mem->get($match_mark);
        $this->cache_close && $results = array();
        
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );        
        
        if (empty($results)) 
        {
            //获取新数据
            $results = array();
            try 
            {
                $return_data = array();
                $return_struct['status']  = 1;
                $return_struct['code']    = 200;
                $return_struct['msg']     = '';
                $return_struct['content'] = $return_data;
                
                $doc = new DOMDocument();
                $doc->load($this->source_rfsf);
                $matchs = $doc->getElementsByTagName("Match");
                
                $result = array();
                $i = 0;                
                    foreach($matchs as $match) {
                        $data = array();
                        $data['match_num'] = intval($match->getAttribute("num"));
                        $data['match_id'] = intval($match->getAttribute("ID"));
                        
                        $pool = $match->getElementsByTagName("Pool");
                        
                        $data['pool_id'] = $pool->item(0)->getAttribute("ID");
                        $data['goalline'] = $pool->item(0)->nodeValue;
                        if ($data['goalline'] >= 0) {
                        	$data['goalline'] = substr($data['goalline'], 1);
                        }
                        
                        $comb = $match->getElementsByTagName("Comb");
                        $result['a']['c'] = $comb->item(0)->getAttribute("c");
                        $result['a']['v'] = $comb->item(0)->getAttribute("v");
                        $result['a']['d'] = $comb->item(0)->getAttribute("d");
                        $result['a']['t'] = $comb->item(0)->getAttribute("t");
                        
                        $result['h']['c'] = $comb->item(1)->getAttribute("c");
                        $result['h']['v'] = $comb->item(1)->getAttribute("v");
                        $result['h']['d'] = $comb->item(1)->getAttribute("d");
                        $result['h']['t'] = $comb->item(1)->getAttribute("t");
                        
                        $data['comb'] = json_encode($result);
                        $data['update_time'] = tool::get_date();
                        $data['play_type'] = $play_type;
                        $data['ticket_type'] = $ticket_type;
                        $objmatch = match::get_instance();
                        $objmatch->update($data);
                        
                        $results[] = $data;
                    }
            } 
            catch (MyRuntimeException $ex)
            {
                $this->_ex($ex, $return_struct, $request_data);
            }
            
            $mem->set($match_mark, $results, 1, $this->cache_time);
        }
        
        empty($results) && $results = array();
		header("Content-type:text/xml");
        header("Cache-Control: no-cache");
        $show = '<?xml version="1.0" encoding="utf-8"?>';
        $show .= '<xml>';

    	foreach ($results as $result) {
            $comb = json_decode($result['comb']);
            $show .= '<m id="'.$result['pool_id'].'" win="'.$comb->h->v.'" lost="'.$comb->a->v.'" time="'.$comb->a->d.' '.$comb->a->t.'" />';
        }
        $show .= '</xml>';
        
        echo $show;
    }    
    
    
	//竞彩篮球胜分差
    public function xml_3_2() {
        $results = array();
        $match_mark = $this->cache_mark.'13_2_8';    
        $ticket_type = 6;
		$play_type = 3;
		
		exit();
        
        $config = kohana::config('cache');
        $mem = @mems::instance($config['sources']['default']['option']);
        $results = $mem->get($match_mark);
        $this->cache_close && $results = array();
        
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );        
        
        if (empty($results)) 
        {
            //获取新数据
            $results = array();
            try 
            {
                $return_data = array();
                $return_struct['status']  = 1;
                $return_struct['code']    = 200;
                $return_struct['msg']     = '';
                $return_struct['content'] = $return_data;
                
                $doc = new DOMDocument();
                $doc->load($this->source_sfc);
                $matchs = $doc->getElementsByTagName("Match");
                
                $result = array();
                $i = 0;                
                    foreach($matchs as $match) {
                        $data = array();
                        $data['match_num'] = intval($match->getAttribute("num"));
                        $data['match_id'] = intval($match->getAttribute("ID"));
                        
                        $pool = $match->getElementsByTagName("Pool");
                        
                        $data['pool_id'] = $pool->item(0)->getAttribute("ID");
                        
                        $comb = $match->getElementsByTagName("Comb");
                        $result['hw1t5']['c'] = $comb->item(0)->getAttribute("c");
                        $result['hw1t5']['v'] = $comb->item(0)->getAttribute("v");
                        $result['hw1t5']['d'] = $comb->item(0)->getAttribute("d");
                        $result['hw1t5']['t'] = $comb->item(0)->getAttribute("t");
                        
                        $result['hw6t10']['c'] = $comb->item(1)->getAttribute("c");
                        $result['hw6t10']['v'] = $comb->item(1)->getAttribute("v");
                        $result['hw6t10']['d'] = $comb->item(1)->getAttribute("d");
                        $result['hw6t10']['t'] = $comb->item(1)->getAttribute("t");
                        
                        $result['hw11t15']['c'] = $comb->item(2)->getAttribute("c");
                        $result['hw11t15']['v'] = $comb->item(2)->getAttribute("v");
                        $result['hw11t15']['d'] = $comb->item(2)->getAttribute("d");
                        $result['hw11t15']['t'] = $comb->item(2)->getAttribute("t");
                        
                        $result['hw16t20']['c'] = $comb->item(3)->getAttribute("c");
                        $result['hw16t20']['v'] = $comb->item(3)->getAttribute("v");
                        $result['hw16t20']['d'] = $comb->item(3)->getAttribute("d");
                        $result['hw16t20']['t'] = $comb->item(3)->getAttribute("t");
                        
                        $result['hw21t25']['c'] = $comb->item(4)->getAttribute("c");
                        $result['hw21t25']['v'] = $comb->item(4)->getAttribute("v");
                        $result['hw21t25']['d'] = $comb->item(4)->getAttribute("d");
                        $result['hw21t25']['t'] = $comb->item(4)->getAttribute("t");
                        
                        $result['hw26']['c'] = $comb->item(5)->getAttribute("c");
                        $result['hw26']['v'] = $comb->item(5)->getAttribute("v");
                        $result['hw26']['d'] = $comb->item(5)->getAttribute("d");
                        $result['hw26']['t'] = $comb->item(5)->getAttribute("t");
                        
                        $result['gw1t5']['c'] = $comb->item(6)->getAttribute("c");
                        $result['gw1t5']['v'] = $comb->item(6)->getAttribute("v");
                        $result['gw1t5']['d'] = $comb->item(6)->getAttribute("d");
                        $result['gw1t5']['t'] = $comb->item(6)->getAttribute("t");
                        
                        $result['gw6t10']['c'] = $comb->item(7)->getAttribute("c");
                        $result['gw6t10']['v'] = $comb->item(7)->getAttribute("v");
                        $result['gw6t10']['d'] = $comb->item(7)->getAttribute("d");
                        $result['gw6t10']['t'] = $comb->item(7)->getAttribute("t");
                        
                        $result['gw11t15']['c'] = $comb->item(8)->getAttribute("c");
                        $result['gw11t15']['v'] = $comb->item(8)->getAttribute("v");
                        $result['gw11t15']['d'] = $comb->item(8)->getAttribute("d");
                        $result['gw11t15']['t'] = $comb->item(8)->getAttribute("t");
                        
                        $result['gw16t20']['c'] = $comb->item(9)->getAttribute("c");
                        $result['gw16t20']['v'] = $comb->item(9)->getAttribute("v");
                        $result['gw16t20']['d'] = $comb->item(9)->getAttribute("d");
                        $result['gw16t20']['t'] = $comb->item(9)->getAttribute("t");
                        
                        $result['gw21t25']['c'] = $comb->item(10)->getAttribute("c");
                        $result['gw21t25']['v'] = $comb->item(10)->getAttribute("v");
                        $result['gw21t25']['d'] = $comb->item(10)->getAttribute("d");
                        $result['gw21t25']['t'] = $comb->item(10)->getAttribute("t");
                        
                        $result['gw26']['c'] = $comb->item(11)->getAttribute("c");
                        $result['gw26']['v'] = $comb->item(11)->getAttribute("v");
                        $result['gw26']['d'] = $comb->item(11)->getAttribute("d");
                        $result['gw26']['t'] = $comb->item(11)->getAttribute("t");
                        
                        $data['comb'] = json_encode($result);
                        $data['update_time'] = tool::get_date();
                        $data['play_type'] = $play_type;
                        $data['ticket_type'] = $ticket_type;
                        $objmatch = match::get_instance();
                        $objmatch->update($data);
                        
                        $results[] = $data;
                    }
            } 
            catch (MyRuntimeException $ex)
            {
                $this->_ex($ex, $return_struct, $request_data);
            }
            
            $mem->set($match_mark, $results, 1, $this->cache_time);
        }
        
        empty($results) && $results = array();
		header("Content-type:text/xml");
        header("Cache-Control: no-cache");
        $show = '<?xml version="1.0" encoding="utf-8"?>';
        $show .= '<xml>';

    	foreach ($results as $result) {
            $comb = json_decode($result['comb']);
            $show .= '<m id="'.$result['pool_id'].'" hw1t5="'.$comb->hw1t5->v.'" hw6t10="'.$comb->hw6t10->v.'" hw11t15="'.$comb->hw11t15->v.'" hw16t20="'.$comb->hw16t20->v.'" hw21t25="'.$comb->hw21t25->v.'" hw26="'.$comb->hw26->v.'" gw1t5="'.$comb->gw1t5->v.'" gw6t10="'.$comb->gw6t10->v.'" gw11t15="'.$comb->gw11t15->v.'" gw16t20="'.$comb->gw16t20->v.'" gw21t25="'.$comb->gw21t25->v.'" gw26="'.$comb->gw26->v.'" time="'.$comb->hw1t5->d.' '.$comb->hw1t5->t.'" />';
        }
        $show .= '</xml>';
        
        echo $show;
    }
    
	//竞彩篮球大小分
    public function xml_4_2() {
        $results = array();
        $match_mark = $this->cache_mark.'13_2_9';
        $ticket_type = 6;
		$play_type = 4;
		
		exit();
		
        $config = kohana::config('cache');
        $mem = @mems::instance($config['sources']['default']['option']);
        $results = $mem->get($match_mark);
        $this->cache_close && $results = array();
        
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );        
        
        if (empty($results)) 
        {
            //获取新数据
            $results = array();
            try 
            {
                $return_data = array();
                $return_struct['status']  = 1;
                $return_struct['code']    = 200;
                $return_struct['msg']     = '';
                $return_struct['content'] = $return_data;
                
                $doc = new DOMDocument();
                $doc->load($this->source_dxf);
                $matchs = $doc->getElementsByTagName("Match");
                
                $result = array();
                $i = 0;                
                    foreach($matchs as $match) {
                        $data = array();
                        $data['match_num'] = intval($match->getAttribute("num"));
                        $data['match_id'] = intval($match->getAttribute("ID"));
                        
                        $pool = $match->getElementsByTagName("Pool");
                        
                        $data['pool_id'] = $pool->item(0)->getAttribute("ID");
                        $data['goalline'] = $pool->item(0)->nodeValue;
                    	if ($data['goalline'] >= 0) {
                        	$data['goalline'] = substr($data['goalline'], 1);
                        }
                        
                        $comb = $match->getElementsByTagName("Comb");
                        $result['h']['c'] = $comb->item(0)->getAttribute("c");
                        $result['h']['v'] = $comb->item(0)->getAttribute("v");
                        $result['h']['d'] = $comb->item(0)->getAttribute("d");
                        $result['h']['t'] = $comb->item(0)->getAttribute("t");
                        
                        $result['l']['c'] = $comb->item(1)->getAttribute("c");
                        $result['l']['v'] = $comb->item(1)->getAttribute("v");
                        $result['l']['d'] = $comb->item(1)->getAttribute("d");
                        $result['l']['t'] = $comb->item(1)->getAttribute("t");
                        
                        $data['comb'] = json_encode($result);
                        $data['update_time'] = tool::get_date();
                        $data['play_type'] = $play_type;
                        $data['ticket_type'] = $ticket_type;
                        $objmatch = match::get_instance();
                        $objmatch->update($data);
                        
                        $results[] = $data;
                    }
            } 
            catch (MyRuntimeException $ex)
            {
                $this->_ex($ex, $return_struct, $request_data);
            }
            
            $mem->set($match_mark, $results, 1, $this->cache_time);
        }
        
        empty($results) && $results = array();
		header("Content-type:text/xml");
        header("Cache-Control: no-cache");
        $show = '<?xml version="1.0" encoding="utf-8"?>';
        $show .= '<xml>';

    	foreach ($results as $result) {
            $comb = json_decode($result['comb']);
            $show .= '<m id="'.$result['pool_id'].'" big="'.$comb->h->v.'" small="'.$comb->l->v.'" time="'.$comb->h->d.' '.$comb->h->t.'" />';
        }
        $show .= '</xml>';
        
        echo $show;
    }
    
}
