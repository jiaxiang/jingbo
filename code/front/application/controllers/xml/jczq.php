<?php defined('SYSPATH') OR die('No direct access allowed.');
/*
 * 竞彩足球输出接口
 */
class Jczq_Controller extends Template_Controller {    
    private $source_rqspf;    //让球胜平负输入接口
    private $source_zjqs;     //总进球数输入接口   
    private $source_bf;       //比分输入接口
    private $source_bqc;      //半全场输入接口
    private $cache_time;      //缓存时间
    private $cache_mark;      //缓存标识前缀
    private $cache_close;     //关闭缓存
    
    public function __construct()
    {
        return;
        parent::__construct();
        $weburl = 'http://jiaxianglu.gicp.net/XmlLog/';
        //$weburl = 'http://jk.caipiao.surbiz.com/xml/';
        $this->source_rqspf = $weburl.'13_1_1.xml';
        $this->source_zjqs = $weburl.'13_1_4.xml';
        $this->source_bf = $weburl.'13_1_3.xml';
        $this->source_bqc = $weburl.'13_1_2.xml';
        
        $this->cache_time = 30*60;
        $this->cache_mark = 'match_';
        $this->cache_close = FALSE;
    }

    //竞彩足球胜平负
    public function xml_1_2($type = NULL) {
        $results = array();
        $match_mark = $this->cache_mark.'13_1_1';
        $ticket_type = 1;
        $play_type = 1;
                        
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

        $config = kohana::config('cache');
        $mem = @mems::instance($config['sources']['default']['option']);
        $results = $mem->get($match_mark);
        
        $this->cache_close && $results = array();
        
        if (empty($results)) 
        {
            match::get_instance()->refresh_match();//更新数据
            
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
                $doc->load($this->source_rqspf);
                $matchs = $doc->getElementsByTagName("Match");
                
                $result = array();
                $i = 0;
                $objmatch = match::get_instance();                
                foreach($matchs as $match) {
                    $data = array();
                    $data['match_num'] = intval($match->getAttribute("num"));
                    $data['match_id'] = intval($match->getAttribute("ID"));
                    
                    $pool = $match->getElementsByTagName("Pool");
                    
                    $data['pool_id'] = $pool->item(0)->getAttribute("ID");
                    $data['goalline'] = intval($pool->item(0)->nodeValue);
                    
                    $comb = $match->getElementsByTagName("Comb");
                    $result['a']['c'] = $comb->item(0)->getAttribute("c");
                    $result['a']['v'] = $comb->item(0)->getAttribute("v");
                    $result['a']['d'] = $comb->item(0)->getAttribute("d");
                    $result['a']['t'] = $comb->item(0)->getAttribute("t");
                    
                    $result['d']['c'] = $comb->item(1)->getAttribute("c");
                    $result['d']['v'] = $comb->item(1)->getAttribute("v");
                    $result['d']['d'] = $comb->item(1)->getAttribute("d");
                    $result['d']['t'] = $comb->item(1)->getAttribute("t");  
                    
                    $result['h']['c'] = $comb->item(2)->getAttribute("c");
                    $result['h']['v'] = $comb->item(2)->getAttribute("v");
                    $result['h']['d'] = $comb->item(2)->getAttribute("d");
                    $result['h']['t'] = $comb->item(2)->getAttribute("t");
                    
                    $data['comb'] = json_encode($result);
                    $data['update_time'] = tool::get_date();
                    $data['play_type'] = $play_type;
                    $data['ticket_type'] = $ticket_type;
                    
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
        
        if (empty($type)) {
            empty($results) && $results = array();
            
            header("Content-type:text/xml");
            header("Cache-Control: no-cache");
            
            $show = '<?xml version="1.0" encoding="utf-8"?>';
            $show .= '<xml>';
            
            foreach ($results as $result) {
                $comb = json_decode($result['comb']);
                $time = $comb->a->d.' '.$comb->a->t;
                $show .= '<m id="'.$result['pool_id'].'" win="'.$comb->h->v.'" draw="'.$comb->d->v.'" lost="'.$comb->a->v.'" time="'.$time.'" />';
            }
            $show .= '</xml>';
            
            echo $show;
        }
    }
    
    
    //竞彩足球总进球数
    public function xml_2_2($type = NULL) {
        $results = array();
        $match_mark = $this->cache_mark.'13_1_4';
        $ticket_type = 1;
        $play_type = 2;
        
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

        $config = kohana::config('cache');
        $mem = @mems::instance($config['sources']['default']['option']);
        $results = $mem->get($match_mark);
        $this->cache_close && $results = array();
        
        
        if (empty($results))
        {
            match::get_instance()->refresh_match();//更新数据
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
                $doc->load($this->source_zjqs);
                $matchs = $doc->getElementsByTagName("Match");
                                
                $result = array();
                $i = 0;
                $objmatch = match::get_instance();
                foreach($matchs as $match) {
                    $data = array();
                    $data['match_num'] = intval($match->getAttribute("num"));
                    $data['match_id'] = intval($match->getAttribute("ID"));
                    
                    $pool = $match->getElementsByTagName("Pool");
                    
                    $data['pool_id'] = $pool->item(0)->getAttribute("ID");
                    
                    //print $data['pool_id'];
                    
                    $comb = $match->getElementsByTagName("Comb");
                    
                    for ($i = 0; $i<=7 ; $i++)
                    {
                        $result[$i]['s'] = $comb->item($i)->getAttribute("s");
                        $result[$i]['v'] = $comb->item($i)->getAttribute("v");
                        $result[$i]['d'] = $comb->item($i)->getAttribute("d");
                        $result[$i]['t'] = $comb->item($i)->getAttribute("t");
                    }
                    
                    $data['comb'] = json_encode($result);
                    $data['update_time'] = tool::get_date();
                    $data['play_type'] = $play_type;
                    $data['ticket_type'] = $ticket_type;
                                        
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
        
        if (empty($type)) {
            empty($results) && $results = array();
            
            header("Content-type:text/xml");
            header("Cache-Control: no-cache");
            
            $show = '<?xml version="1.0" encoding="utf-8"?>';
            $show .= '<xml>';
            
            
            foreach ($results as $result) {
                $comb = json_decode($result['comb']);                
                $time = $comb[0]->d.' '.$comb[0]->t;
                
                $add = '';
                foreach($comb as $key => $row)
                {
                    $add .= " s".$key."=\"".$row->v."\"";
                }
                $show .= '<m id="'.$result['pool_id'].'" '.$add.' time="'.$time.'" />';
            }
            $show .= '</xml>';
            
            echo $show;
        }
    } 

    
    //竞彩足球比分
    public function xml_3_2($type = NULL) {
        $results = array();
        $match_mark = $this->cache_mark.'13_1_3';
        $ticket_type = 1;
        $play_type = 3;
                
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

        $config = kohana::config('cache');
        $mem = @mems::instance($config['sources']['default']['option']);
        $results = $mem->get($match_mark);
        $this->cache_close && $results = array();
                 
        if (empty($results))
        {
            match::get_instance()->refresh_match();//更新数据
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
                $doc->load($this->source_bf);
                $matchs = $doc->getElementsByTagName("Match");
                                
                $result = array();
                $i = 0;
                $objmatch = match::get_instance();
                foreach($matchs as $match) {
                    $data = array();
                    $data['match_num'] = intval($match->getAttribute("num"));
                    $data['match_id'] = intval($match->getAttribute("ID"));
                    
                    $pool = $match->getElementsByTagName("Pool");
                    $data['pool_id'] = $pool->item(0)->getAttribute("ID");
                    
                    $comb = $match->getElementsByTagName("Comb");
                    
                    foreach ($comb as $rowcomb)
                    {
                        $mark = '';
                        if ($rowcomb->getAttribute("c") == '-1:-A')
                        {
                            $mark = '0A';
                        }
                        elseif($rowcomb->getAttribute("c") == '-1:-D')
                        {
                            $mark = '3A';
                        }
                        elseif($rowcomb->getAttribute("c")== '-1:-H')
                        {
                            $mark = '1A';
                        }
                        else 
                        {
                             $tmp = explode(':', $rowcomb->getAttribute("c"));
                             $mark = intval($tmp[0]).intval($tmp[1]);
                        }
                        
                        $result[$mark]['c'] = $rowcomb->getAttribute("c");
                        $result[$mark]['s'] = $rowcomb->getAttribute("s");
                        $result[$mark]['v'] = $rowcomb->getAttribute("v");
                        $result[$mark]['d'] = $rowcomb->getAttribute("d");
                        $result[$mark]['t'] = $rowcomb->getAttribute("t");                        
                    }
                    
                    $data['comb'] = json_encode($result);
                    $data['update_time'] = tool::get_date();
                    $data['play_type'] = $play_type;
                    $data['ticket_type'] = $ticket_type;
                                        
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
        
        
        if (empty($type)) {
            empty($results) && $results = array();
                        
            header("Content-type:text/xml");
            header("Cache-Control: no-cache");
            
            $show = '<?xml version="1.0" encoding="utf-8"?>';
            $show .= '<xml>';
            
            foreach ($results as $result) {
                $comb = json_decode($result['comb']);                  
                $add = '';
                $i = 0;
                foreach ($comb as $key => $row)
                {
                    $i++;
                    if ($i == 1)
                    {
                        $time = $row->d.' '.$row->t;
                    }
                    
                    if ($key == '0A')
                    {
                        $add .= " bother=\"".$row->v."\"";
                        continue;
                    }
                    elseif ($key == '1A')
                    {
                        $add .= " cother=\"".$row->v."\"";
                        continue;
                    }
                    elseif ($key == '3A')
                    {
                        $add .= " aother=\"".$row->v."\"";
                        continue;
                    }
                    else 
                    {
                        //开始对数据加工
                        $num1 = intval(substr($key, 0, 1));
                        $num2 = intval(substr($key, -1));
                        
                        if ($num1 == $num2)
                        {
                            $add .= " c".$num1.$num2."=\"".$row->v."\"";
                            continue;
                        }
                        elseif ($num1 > $num2)
                        {
                            $add .= " a".$num1.$num2."=\"".$row->v."\"";
                            continue;
                        }
                        elseif ($num1 < $num2)
                        {
                            $add .= " b".$num2.$num1."=\"".$row->v."\"";
                            continue;
                        }
                    }
                }
                
                $show .= '<m id="'.$result['pool_id'].'" '.$add.' time="'.$time.'" />';

            }
            $show .= '</xml>';
            
            echo $show;
        }
    }     

    
    //竞彩足球半全场
    public function xml_4_2($type = NULL) {
        $results = array();
        $match_mark = $this->cache_mark.'13_1_2';
        $ticket_type = 1;
        $play_type = 4;
                    
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

        $config = kohana::config('cache');
        $mem = @mems::instance($config['sources']['default']['option']);
        $results = $mem->get($match_mark);
        $this->cache_close && $results = array();

        if (empty($results))
        {
            match::get_instance()->refresh_match();//更新数据
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
                $doc->load($this->source_bqc);
                $matchs = $doc->getElementsByTagName("Match");
                                
                $result = array();
                $i = 0;
                $objmatch = match::get_instance();
                foreach($matchs as $match) {
                    $data = array();
                    $data['match_num'] = intval($match->getAttribute("num"));
                    $data['match_id'] = intval($match->getAttribute("ID"));
                    
                    $pool = $match->getElementsByTagName("Pool");
                    
                    $data['pool_id'] = $pool->item(0)->getAttribute("ID");
                    
                    //print $data['pool_id'];
                    
                    $comb = $match->getElementsByTagName("Comb");
                    
                    $i = 0;
                    foreach($comb as $rowcomb)
                    {
                        $mark = '';
                        switch ($comb->item($i)->getAttribute("c"))
                        {
                            case 'A:A':
                                $mark = 'cc'; 
                            break;
                            case 'A:D':
                                $mark = 'cb'; 
                            break;
                            case 'A:H':
                                $mark = 'ca'; 
                            break;
                            case 'D:A':
                                $mark = 'bc'; 
                            break;                            
                             case 'D:D':
                                $mark = 'bb'; 
                            break;                           
                            case 'D:H':
                                $mark = 'ba'; 
                            break;                            
                            case 'H:A':
                                $mark = 'ac'; 
                            break;                            
                            case 'H:D':
                                $mark = 'ab'; 
                            break;                            
                            case 'H:H':
                                $mark = 'aa'; 
                            break;   
                        }
                        
                        $result[$mark]['c'] = $comb->item($i)->getAttribute("c");
                        $result[$mark]['v'] = $comb->item($i)->getAttribute("v");
                        $result[$mark]['s'] = $comb->item($i)->getAttribute("s");
                        $result[$mark]['d'] = $comb->item($i)->getAttribute("d");
                        $result[$mark]['t'] = $comb->item($i)->getAttribute("t");
                        $i++;
                    }
                    
                    $data['comb'] = json_encode($result);
                    $data['update_time'] = tool::get_date();
                    $data['play_type'] = $play_type;
                    $data['ticket_type'] = $ticket_type;

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
        
        if (empty($type)) {
            empty($results) && $results = array();
            
            header("Content-type:text/xml");
            header("Cache-Control: no-cache");
            
            $show = '<?xml version="1.0" encoding="utf-8"?>';
            $show .= '<xml>';
            
            foreach ($results as $result) {
                $comb = json_decode($result['comb']);
                $time = $comb->cc->d.' '.$comb->cc->t;
                $add = '';
                $add .= 'aa="'.$comb->aa->v.'" ';
                $add .= 'ac="'.$comb->ac->v.'" ';
                $add .= 'ab="'.$comb->ab->v.'" ';
                $add .= 'ca="'.$comb->ca->v.'" ';
                $add .= 'cc="'.$comb->cc->v.'" ';
                $add .= 'cb="'.$comb->cb->v.'" ';
                $add .= 'ba="'.$comb->ba->v.'" ';
                $add .= 'bc="'.$comb->bc->v.'" ';
                $add .= 'bb="'.$comb->bb->v.'" ';
                
                $show .= '<m id="'.$result['pool_id'].'" '.$add.' time="'.$time.'" />';
            }
            $show .= '</xml>';
            
            echo $show;
        }
    }

    
      
    
    
}
