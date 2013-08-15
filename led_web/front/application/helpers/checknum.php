<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 数字彩号码检验
 * 
 */
class checknum_Core {
    private static $instance = NULL;
	public static $pdb = null;
    private static $lott = array(
		8=>array('name'=>'dlt','fg'=>';'),
		9=>array('name'=>'plw','fg'=>';'),	
		10=>array('name'=>'qxc','fg'=>';'),
		11=>array('name'=>'pls','fg'=>';'),
	);
	public function loaddb(){
		if(!self::$pdb){
		 	self::$pdb = Database::instance();
		}
	}
    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    
    public function check($lotyid=8,$type=1,$codes=""){
    	 isset(self::$lott[$lotyid]) && !empty($lotyid) && $lottconf = self::$lott[$lotyid];
    	 if(is_array($lottconf)){
    	 	$func = $lottconf['name'];
    	 	if(is_callable(array('checknum', $func))){
    	 		 return $this->$func($type,$codes);
    	 	}
    	 }
    	 return false;
    }

	function getOrderLimitCode ($ca) {		
		foreach ($ca as $val){			
			$teamb = str_split($val);
			asort($teamb);
			$tempa[] = implode("",$teamb);
		}
		return $tempa;
	}

	public function plschecklimit($type=1,$qihao,$codes=""){

    			$this->loaddb();
				$limitstr=self::$pdb->select('limitcode')
				->from('qihao_exts')
				->where(array('lotyid'=>11,'qihao'=>$qihao))
				->get()->current()->limitcode;
				$limitCode=explode(',',$limitstr);
				$beforCode = explode(';',$codes);
				$limitCode2 = $limitCode;
				

				switch ($type) {
					case '1':
					case '3':
					case '6':
					case '10':
						$tmparr  = explode(';', $codes);
    					$codearr = array_filter($tmparr,array("checknum","clearempty"));
						$oldarray = $this->getZhxList($codes);
					break;
					case '4':						
						$oldarray =$this->getZhXHeList($codes);					
					break;
					case '5':
						$limitCode2 = $this->getOrderLimitCode($limitCode);
						$oldarray =$this->getZ6List($codes);
						//$oldarray =$this->getOrderLimitCode($oldarray);
					break;
					case '9':
						$limitCode2 = $this->getOrderLimitCode($limitCode);
						$oldarray =$this->getZ3List($codes);
					break;

				}
				//$result['oldarray'] = $oldarray; 
				foreach ($oldarray as $key=>$val){
					if(in_array($val,$limitCode2)){
						$result['stat'] = 500;
						$result['info'] = '您好,'.$oldarray[$key].'号码已限投!';
						exit(json_encode($result));
					}

				}

				//exit(json_encode($result));
				
    }

	


	
   /**
     * 排列五号码校验
     * @param $codes 号码串
     * @param $type 玩法类型 1 普通 2 生肖乐 3 胆拖
     * @param $codes 投注内容 1,2,3,4,5;5,4,3,2,1
     * 
     */

	public function plw($type=1,$codes=""){
    	$nums = 0; //注数
    	$flag = true;
    	if($type==1||$type==3){
    		$tmparr  = explode(';', $codes);
    		$codearr = array_filter($tmparr,array("checknum","clearempty"));
    		if(count($codearr)){
				foreach ($codearr as $val){    			
    				$q = $this->plwnumcheck($val);
					$nums+=$q;
    			}
    		}
    		 return array('stat'=>$flag,'nums'=>$nums);
    	}
    }
 
	/**
     * 
     * 排列五号码范围校验
     * @param  $item 号码串
     */
	function plwnumcheck($item){
		$flag = true;
		$cmin = 5;
		$min = 0;
		$max = 9;    
		$items = explode(',',$item);
		if(count($items) != $cmin) return 0;
		$zsnum=1;
		foreach($items as $val){
			if(1<strlen($val))
			{
				$snum = str_split($val);				
				if(array_unique($snum)!=$snum){
					return 0;
				}
				$n = strlen($val);
			}
			else{
			    $n=1;
			}
			$val = intval($val);
			if(999999999<$val) return 0;
			$zsnum *= $n;
		}
		return $zsnum;
	}
    

   /**
     * 排列五号码校验
     * @param $codes 号码串
     * @param $type 玩法类型 1 普通 2 生肖乐 3 胆拖
     * @param $codes 投注内容 1,2,3,4,5;5,4,3,2,1
     * 
     */

	public function pls($type=1,$codes=""){
    	$nums = 0; //注数
    	$flag = true;

		$tmparr  = explode(';', $codes);
		$codearr = array_filter($tmparr,array("checknum","clearempty"));
		if(count($codearr)){
			foreach ($codearr as $val){    			
				$q = $this->plsnumcheck($val,$type);
				$nums+=$q;			
			}
		}
		return array('stat'=>$flag,'nums'=>$nums,'wtype'=>$type);
    }
 
	/**
     * 
     * 排列五号码范围校验
     * @param  $item 号码串
     */
	function plsnumcheck($item,$type=1){
		$flag = true;
		$min = 0;
		$max = 9;
		switch ($type) {
		case '1':
		case '3':
		case '6':
		case '10':
			$items = explode(',',$item);
			$ncmin = count($items);
			$cmin='3';
			if($ncmin!=3) return 0;
				$zsnum=1;
				foreach($items as $val){
					if(1<strlen($val))
					{
						$snum = str_split($val);				
						if(array_unique($snum)!=$snum){
							return 0;
						}
						$n = strlen($val);
					}
					else{
						$n=1;
					}
					$val = intval($val);
					if(999999999<$val) return 0;
					$zsnum *= $n;
				}
		break;
		case '4':
			$items = explode(',',$item);
			$ncmin = count($items);
			if($ncmin>28) return 0;
				$zsnum=$n=0;
				foreach($items as $val){
					if(28>intval($val))
					{
						$n = count($this->getZhXHeList($val));
					}
					$zsnum += $n;
				}
			
		break;
		case '5':
			$items = explode(',',$item);
			$ncmin = count($items);
		    $cmin='10';
			if($ncmin>10 || $ncmin<3) return 0;
			foreach($items as $val){
				if($val>9) return 0;					
			}
			$zsnum = $this->combin($ncmin,3);
		break;
		case '9':
		    $items = explode(',',$item);
			$ncmin = count($items);
		    $cmin='10';
			if($ncmin>10 || $ncmin<2) return 0;
			foreach($items as $val){
				if($val>9) return 0;					
			}
			$zsnum = $ncmin*($ncmin-1);
		break;

		}
		return $zsnum;
	}


	 /**
     * 七星彩号码校验
     * @param $codes 号码串
     * @param $type 玩法类型 1 普通 2 生肖乐 3 胆拖
     * @param $codes 投注内容 1,2,3,4,5,6,7;7,6,5,4,3,2,1
     * 
     */
	public function qxc($type=1,$codes=""){
		$nums = 0; //注数
    	$flag = true;
    	if($type==1||$type==3){
    		$tmparr  = explode(';', $codes);
    		$codearr = array_filter($tmparr,array("checknum","clearempty"));
    		if(count($codearr)){
				foreach ($codearr as $val){    			
    				$q = $this->qxcnumcheck($val);
					$nums+=$q;
    			}
    		}
    		 return array('stat'=>$flag,'nums'=>$nums);
    	}
	}

	/**
     * 
     * 七星彩号码范围校验
     * @param  $item 号码串
     */
	function qxcnumcheck($item){
		$flag = true;
		$cmin = 7;
		$min = 0;
		$max = 9;    
		$items = explode(',',$item);
		if(count($items) != $cmin) return 0;
		$zsnum=1;
		foreach($items as $val){
			if(1<strlen($val))
			{
				$snum = str_split($val);				
				if(array_unique($snum)!=$snum){
					return 0;
				}
				$n = strlen($val);
			}
			else{
			    $n=1;
			}
			$val = intval($val);
			if(999999999<$val) return 0;
			$zsnum *= $n;
		}
		return $zsnum;
	}


    /**
     * 大乐透号码校验
     * @param $codes 号码串
     * @param $type 玩法类型 1 普通 2 生肖乐 3 胆拖
     * @param $codes 投注内容 01,04,10,25,30|02,12;01,04,10,25,30|02,12
     * 
     */
    public function dlt($type=1,$codes=""){
    	$nums = 0; //注数
    	$flag = true;
    	if($type==1||$type==3){
    		$tmparr  = explode(';', $codes);
    		$codearr = array_filter($tmparr,array("checknum","clearempty"));
    		if(count($codearr)){
    			foreach ($codearr as $val){
    				$item = explode('|',$val);
    				if(count($item)!=2) {
    					$flag = false;
    					break;
    				}
    				$qflag = $this->dltnumcheck($item[0],1);
    				$qhou  = $this->dltnumcheck($item[1],2);
    				if($qflag==false || $qhou == false) {
    					$flag = false;
    					break;
    				}else{ //注数计算
    					$nums+=$this->dltcheknum($item);
    				}
    			}
    		}

    	}
		else if ($type==13) {
			$tmparr  = explode(';', $codes);
    		$codearr = array_filter($tmparr,array("checknum","clearempty"));
			if(count($codearr)){

				foreach ($codearr as $val){
    				$item = explode('|',$val);
					
					if(count($item)==2){
						$red = explode('$',$item[0]);
						$blue = explode('$',$item[1]);
						if(count($blue)){
						}
						$ra = count(explode(',',$red[0]));
						$rb = count(explode(',',$red[1]));
						$ba = count(explode(',',$blue[0]));
						$bb = count(explode(',',$blue[1]));
						$nums += $this->getDltDtnum($ra,$rb,$ba,$bb);

					}
					else{
					    $flag = false;
					}
    			
    			}
			}
		}
   		 return array('stat'=>$flag,'nums'=>$nums);
    }
    public function getDltDtnum($ra,$rb,$ba,$bb) {
		$rnum = $ra+$rb;
		$bnum = $ba+$bb;
        $rnum = $this->combin($rb,5-$ra);
		$bnum = $this->combin($bb,2-$ba);
		return $rnum*$bnum;
    }

    public function clearempty($item){
    	if($item) return true;
    }
    /**
     * 
     * 大乐透号码范围校验
     * @param  $item 号码串 
     * @param  $ptype 1 前区 2 后区
     */
    public function dltnumcheck($item,$ptype=1){
    	$flag = true;
    	$cmin = 5;
    	$min = 1;
    	$max = 35;
    	if($ptype==2){
    		$max = 12;
    		$cmin = 2;
    	}
    	$items = explode(',',$item);
    	if(count($items)<$cmin) return false;
    	if(array_unique($items)!=$items){
    		return false;
    	}
    	foreach($items as $val){
    		$val = intval($val);
    		if($val>$max || $val<$min){
    			$flag = false;
    		}
    	}
    	return $flag;
    }
    /**
     * 
     * 号码计算
     * @param array $code
     */
    public function dltcheknum($code){
    	$q = explode(',',$code[0]);
    	$h = explode(',',$code[1]);
    	$qnum = $this->combin(count($q),5);
    	$hnum = $this->combin(count($h),2);
    	return $qnum*$hnum;
    	
    }
    /**
     * 
     * Enter description here ...
     * @param $arr
     * @param $size
     * eg:$r = Combination(array(1,2,3,4,5,6,7),5); 
     */
	function Combination($arr, $size = 1) { 
	     $len = count($arr); 
	     $max = pow(2,$len) - pow(2,$len-$size); 
	     $min = pow(2,$size)-1; 
	  
	     $r_arr = array(); 
	     for ($i=$min; $i<=$max; $i++){ 
	         $count = 0; 
	         $t_arr = array(); 
	         for ($j=0; $j<$len; $j++){ 
	             $a = pow(2, $j); 
	             $t = $i&$a; 
	             if($t == $a){ 
	                 $t_arr[] = $arr[$j]; 
	                 $count++; 
	             } 
	         }      
	         if($count == $size){ 
	             $r_arr[] = $t_arr;         
	         } 
	     } 
	     return $r_arr; 
	 }
	/*
	* Function: 拆分直选和值
	* Param   : 3或2,3,4
	* Return  : 号码组
	*/
	public	function getZhXHeList($n,$fg=',') {	
				$result = array();
				$nlist=explode($fg,$n);
				if(count($nlist)==1){
					for ($x=0; $x<=9; $x++) {	
						for ($y=0; $y<=9; $y++) {
							if($n<($x+$y)) break;
							for ($z=0; $z<=9; $z++) {
								if($n==($x+$y+$z)){
								$result[]=$x.$y.$z;
								continue 2;
								}
							}
						}
					}
				}
				else{
					foreach ($nlist as $val){
						$result = array_merge( $result,$this->getZhXHeList($val)); 
					}
				}

				return $result;
			}

	/*
	* Function: 拆分直选
	* Param   : 1,2,3;4,567,8
	* Return  : 号码组
	*/
		public function getZhxList ($code) {
			$farray = explode(';',$code);
			$result = array();                                                                
			foreach ($farray as $val1){
				$sarray = explode(',',$val1);
				$tempa = str_split(trim($sarray[0]));
				$tempb = str_split(trim($sarray[1]));
				$tempc = str_split(trim($sarray[2]));
				foreach ($tempa as $xx){
					$x = $xx;
					foreach ($tempb as $yy){
						$y = $yy;
						foreach ($tempc as $zz){
							$z=$zz;
							$result[]=$x.$y.$z;
						}
					}
					
				}
				
				
			}
			return $result;

		}
		/*
		* Function: 得到组六的具体号码组
		* Param   : 2,3,4,5,6,7
		* Return  : 号码组
		*/
		function getZ6List ($codes) {			
			$tempx = $tempy = $tempz = $teampa = explode(',',$codes);
			$result = $tmp=array();
			foreach ($tempx as $xkey=>$xx){
			    $x=$xx;
				foreach ($tempy as $ykey=>$yy){
					if($xkey==$ykey) continue;
					$y=$yy;
					foreach ($tempz as $zkey=>$zz){
						if($ykey==$zkey||$xkey==$zkey) continue;
						$z=$zz;
						$tp = array($x,$y,$z);
						asort($tp);
						$result[] = implode("",$tp);
					}
				}
			}
			foreach ($result as $val){
				if(!in_array($val,$tmp))
			    $tmp[]=$val;
			}
			$result =$tmp;
		    return $result;
		}
		/*
		* Function: 得到组三的具体号码组
		* Param   : 2,3,4,5,6,7
		* Return  : 号码组
		*/
		function getZ3List ($codes) {			
			$tempx = $tempy = $tempz = explode(',',$codes);
			$result = array();
			foreach ($tempx as $xkey=>$xx){
			    $x=$xx;
				foreach ($tempy as $ykey=>$yy){
					if($xkey!=$ykey) continue;
					$y=$yy;
					foreach ($tempz as $zkey=>$zz){
						if($ykey==$zkey) continue;
						$z=$zz;
						$tp = array($x,$y,$z);
						asort($tp);
						$result[] = implode("",$tp);
					}
				}
			}
		    return $result;
		}
   /**
	 * 排列数运算
	 * @param $n
	 * @param $c
	 */
    public function P($n,$c){
	    if($n>=$c)
		{
		   return $this->combin($n)/$this->combin($n-$c);  
		}
		else
		{
		   return false;
		}
    }
	/**
	 * 组合数运算
	 * @param $n
	 * @param $c
	 */
    public function combin($n,$c){
	    if($n>=$c)
		{
		   return $this->factorial($n)/($this->factorial($c)*$this->factorial($n-$c));  
		}
		else
		{
		   return false;
		}
    }
    /**
     * 
     * 阶乘运算
     * @param $s
     */
	public function factorial($s)
	{
		if ($s <0)
		{
		   return false;
		} elseif($s==0 OR $s==1){
		   return 1;
		}else{
		   return $this->factorial($s-1)*$s;   
		}
	}
	/**
	 * 
	 * 格式化开奖号码
	 * @param $kjnum 开奖号码串
	 * @param $type 彩种ID
	 */
	public static function formatkjnum($kjnum='',$lotyid=8){
		$result = '';
		switch($lotyid){
			case '8':
			    $arr = explode('|',$kjnum);
					if(count($arr)!=2){
					return false;
				}
				$qq = explode(',',$arr[0]);
				$hq = explode(',',$arr[1]);
				$result.= '<b class="ba-red">'.implode('</b><b class="ba-red">',$qq).'</b>';
				$result.= '<b class="ba-blue">'.implode('</b><b class="ba-blue">',$hq).'</b>';
			break;
			case '9':
				$qq = explode(',',$kjnum);
			    $result.= '<b class="ba-red">'.implode('</b><b class="ba-red">',$qq).'</b>';
			break;
			case '10':
			    $qq = explode(',',$kjnum);
			    $result.= '<b class="ba-red">'.implode('</b><b class="ba-red">',$qq).'</b>';
			break;
			case '11':
			    $qq = explode(',',$kjnum);
			    $result.= '<b class="ba-red">'.implode('</b><b class="ba-red">',$qq).'</b>';
			break;
			
		}
		return $result;
	} 
	
	/**
	 * 格式化中奖信息串
	 */
	public static function formatzjinfo($zjinfo='',$lotyid=8){
		$result = '';
		$nums = array("零","一","二","三","四","五","六","七","八","九","十"); 
		switch($lotyid){
			case '8':
				$arr = explode(',',$zjinfo);
				foreach ($arr as $val){
					$tmp = explode('=',$val);
					$result.= $nums[$tmp[0]]."等奖<font color=\"red\">".$tmp[1]."</font>注,";
				}
				$result = substr($result,0,-1);
			break;
			case '9':
				$bonusconfig = Kohana::config("lottnum.bonusinfo");
			    $arr = explode(',',$zjinfo);				
				foreach ($arr as $val){
					$tmp = explode('=',$val);
					$result.= $bonusconfig['plw'][$tmp[0]]['name']."<font color=\"red\">".$tmp[1]."</font>注,";
				}
				$result = substr($result,0,-1);
			break;
			case '10':
				$bonusconfig = Kohana::config("lottnum.bonusinfo");
			    $arr = explode(',',$zjinfo);				
				foreach ($arr as $val){
					$tmp = explode('=',$val);
					$result.= $bonusconfig['qxc'][$tmp[0]]['name']."<font color=\"red\">".$tmp[1]."</font>注,";
				}
				$result = substr($result,0,-1);
			break;
			case '11':

				$bonusconfig = Kohana::config("lottnum.bonusinfo");
			    $arr = explode(',',$zjinfo);				
				foreach ($arr as $val){
					$tmp = explode('=',$val);
					$result.= $bonusconfig['pls'][$tmp[0]]['name']."<font color=\"red\">".$tmp[1]."</font>注,";
				}
				$result = substr($result,0,-1);
			break;
		}
		return $result;
	}
	
	public static function shownums($codes,$lotyid=8){
		$result = array();
		$result = explode(self::$lott[$lotyid]['fg'],$codes);
		//$result = implode('<br>',$arr);
		return $result;
	}

	/*
	* Function: 得到对应的注数
	* Param   : $val 为和
	* Return  : 返回 $val的对应注数
	*/
	public static function getZHX ($val) {
	    
		$zhxArray = array('0'=>'1',
						'1'=>'3',
						'2'=>'6',
						'3'=>'10',
						'4'=>'15',
						'5'=>'21',
						'6'=>'28',
						'7'=>'36',
						'8'=>'45',
						'9'=>'55',
						'10'=>'63',
						'11'=>'69',
						'12'=>'73',
						'13'=>'75',
						'14'=>'75',
						'15'=>'73',
						'16'=>'69',
						'17'=>'63',
						'18'=>'55',
						'19'=>'45',
						'20'=>'36',
						'21'=>'28',
						'22'=>'21',
						'23'=>'15',
						'24'=>'10',
						'25'=>'6',
						'26'=>'3',
						'27'=>'1'
		);
		return $zhxArray[$val];
	}
    
	public static function getZXHZ ($val) {
		$zxhzArray = array('1'=>'1',
							'2'=>'2',
							'3'=>'2',
							'4'=>'4',
							'5'=>'5',
							'6'=>'6',
							'7'=>'8',
							'8'=>'10',
							'9'=>'11',
							'10'=>'13',
							'11'=>'14',
							'12'=>'14',
							'13'=>'15',
							'14'=>'15',
							'15'=>'14',
							'16'=>'14',
							'17'=>'13',
							'18'=>'11',
							'19'=>'10',
							'20'=>'8',
							'21'=>'6',
							'22'=>'5',
							'23'=>'4',
							'24'=>'2',
							'25'=>'2',
							'26'=>'1');
	    return $zxhzArray[$val];
	}
	
}