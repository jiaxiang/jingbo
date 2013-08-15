<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 数字彩操作接口
 * Enter description here ...
 * @author lenayin
 *
 */

class Orderprocess_Controller extends Template_Controller {
	
	public static $pdb = null;
	public static $psize = 2;
	public $lottid = 8;
	public $fg = ';';
	
	public function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin:*");
	}
	
	public function  index(){

		echo $this->lottid;
		
	}
	/**
	 * 撤消认购
	 */
	public function cancelorder(){
		$result = array('stat'=>200,'info'=>'撤消合买成功!');
		if (empty($_REQUEST)){
			$result = array('stat'=>102,'info'=>'未提交数据');
            exit(json_encode($result));
		}
	    //登录判断
		if(!$this->islogin()){
			$result = array('stat'=>103,'info'=>'未登录!');
			exit(json_encode($result));
		}
		$gid = $this->input->get('gid'); //认购编号
		$uid = $this->_user['id'];
		$this->loaddb();
		//check
		$grow = self::$pdb->query("select uid,restat,buytype,pid from sale_prousers where id='".intval($gid)."'")->result_array(FALSE);
		if($grow[0]['uid']!=$uid){
			$result = array('stat'=>101,'info'=>'此认购不属你，不可能撤消！');
			exit(json_encode($result));
		}
		if($grow[0]['restat']!=0){
			$result = array('stat'=>104,'info'=>'认购已撤消，不可重复撤消！');
			exit(json_encode($result));
		}
		if($grow[0]['buytype']==1){
			$result = array('stat'=>105,'info'=>'发起认购不可撤消！');
			exit(json_encode($result));
		}
		//进度校验
		$prow = self::$pdb->query("select renqi from plans_lotty_orders where id='".$grow[0]['pid']."'")
		                  ->result_array(FALSE);
		if($prow[0]['renqi']>=80){
			$result = array('stat'=>107,'info'=>'进度达到可撤单上限，不可撤销！');
			exit(json_encode($result));
		}
		//cancel
		$row = self::$pdb->query("call rev_order(".$gid.", -- 根单编号 
                                    2, -- 撤单类型 1 方案撤单 2 跟单人撤销
				                    2011, -- 交易流水号
                                   @stat)")->result_array(FALSE);
	   //
	   if($row[0]['result']=='succ'){
			exit(json_encode($result));
		}else{
			$result = array('stat'=>106,'info'=>'根单撤消失败!');
			exit(json_encode($result));
		}
	}
	/**
	 * 方案认购
	 */
	public function buy(){
	    $result = array('stat'=>200,'info'=>'succ');
		if (empty($_REQUEST)){
			$result = array('stat'=>102,'info'=>'未提交数据');
            exit(json_encode($result));
		}
	    //登录判断
		if(!$this->islogin()){
			$result = array('stat'=>103,'info'=>'未登录!');
			exit(json_encode($result));
		}
		$pid   = $this->input->get('pid'); //方案编号
		$rnum  = $this->input->get('rnum'); //认购份数
		$uid   = $this->_user['id'];
		$uname = $this->_user['lastname'];
		//check
		if(empty($pid)||empty($rnum)||$pid<=0||$rnum<=0){
			$result = array('stat'=>103,'info'=>'提交数据异常！');
            exit(json_encode($result));
		}
		$this->loaddb();
		$prow = self::$pdb->query("select qihao,lotyid,nums,rgnum,restat,onemoney from plans_lotty_orders where id='".$pid."'")->result_array(FALSE);
		if(isset($prow[0])){
			$qhb = self::$pdb->query("select endtime from qihaos where qihao='".$prow[0]['qihao']."' and lotyid='".$prow[0]['lotyid']."'")->result_array(FALSE);
			if(strtotime($qhb[0]['endtime'])<= time()){
				$result = array('stat'=>120,'info'=>'方案已截止，不可认购！');
				exit(json_encode($result));
			}
			if($prow[0]['restat']!=0 
			||($prow[0]['nums']-$prow[0]['rgnum'])<$rnum){
				$result = array('stat'=>104,'info'=>'方案异常！');
				exit(json_encode($result));
			}
		}else{
			$result = array('stat'=>105,'info'=>'方案不存！');
			exit(json_encode($result));
		}
		
	    //余额检测
		if($this->_user['user_moneys']['all_money']<$rnum*$data['omoney']*$prow[0]['onemoney']){
			$result = array('stat'=>110,'info'=>'你的余额不足!');
		    exit(json_encode($result));
		}
		//sub
		$row = self::$pdb->query("call subgd(".$pid.", -- 方案编号
                                ".$rnum.", -- 认购份数
                                $uid, -- 认购用户
				                '$uname', -- 认购用户名
				                -- in rgtype tinyint, -- 认购类型
				                2011, -- 流水号
				                0, -- 来源
				                @stat
                               )")->result_array(FALSE);
		
	    if($row[0]['stat']=='succ'){
			exit(json_encode($result));
		}else{
			$result = array('stat'=>106,'info'=>'认购失败!');
			exit(json_encode($result));
		}
	}
	
	public function submit_buy_join(){
	    $result = array('state'=>200,'msg'=>'认购成功！');
		if (empty($_REQUEST)){
			$result = array('state'=>102,'msg'=>'未提交数据');
            exit(json_encode($result));
		}
	    //登录判断
		if(!$this->islogin()){
			$result = array('state'=>103,'msg'=>'未登录!');
			exit(json_encode($result));
		}
		$pid   = $this->input->get('pid'); //方案编号
		$rnum  = $this->input->get('buynum'); //认购份数
		$uid   = $this->_user['id'];
		$uname = $this->_user['lastname'];
		//check
		if(empty($pid)||empty($rnum)||$pid<=0||$rnum<=0){
			$result = array('state'=>103,'msg'=>'提交数据异常！');
            exit(json_encode($result));
		}
		$this->loaddb();
		$prow = self::$pdb->query("select qihao,lotyid,nums,rgnum,restat,onemoney from plans_lotty_orders where id='".$pid."'")->result_array(FALSE);
		if(isset($prow[0])){
			$qhb = self::$pdb->query("select endtime from qihaos where qihao='".$prow[0]['qihao']."' and lotyid='".$prow[0]['lotyid']."'")->result_array(FALSE);
			if(strtotime($qhb[0]['endtime'])<= time()){
				$result = array('stat'=>120,'msg'=>'方案已截止，不可认购！');
				exit(json_encode($result));
			}
			if($prow[0]['restat']!=0){
				$result = array('stat'=>104,'msg'=>'方案已撤消，不可认购！');
				exit(json_encode($result));
			}
			if(($prow[0]['nums']-$prow[0]['rgnum'])<$rnum){
				$result = array('stat'=>104,'msg'=>'认购份数大于剩余份数！');
				exit(json_encode($result));
			}
		}else{
			$result = array('state'=>105,'msg'=>'方案不存！');
			exit(json_encode($result));
		}
		
	    //余额检测
		if($this->_user['user_moneys']['all_money']<$rnum*$data['omoney']*$prow[0]['onemoney']){
			$result = array('state'=>110,'msg'=>'你的余额不足!');
		    exit(json_encode($result));
		}
		//sub
		$row = self::$pdb->query("call subgd(".$pid.", -- 方案编号
                                ".$rnum.", -- 认购份数
                                $uid, -- 认购用户
				                '$uname', -- 认购用户名
				                -- in rgtype tinyint, -- 认购类型
				                2011, -- 流水号
				                0, -- 来源
				                @stat
                               )")->result_array(FALSE);
		
	    if($row[0]['stat']=='succ'){
			exit(json_encode($result));
		}else{
			$result = array('state'=>106,'msg'=>'认购失败!');
			exit(json_encode($result));
		}
	}
	/**
	 * 撤消方案
	 */
	public function cancelplan(){
		$result = array('stat'=>200,'info'=>'方案撤销成功');
		if (empty($_REQUEST)){
			$result = array('stat'=>102,'info'=>'未提交数据');
            exit(json_encode($result));
		}
		//登录判断
		if(!$this->islogin()){
			$result = array('stat'=>103,'info'=>'你还没有登录,请先登录!');
			exit(json_encode($result));
		}
		$pid   = $this->input->get('pid'); //方案编号
		$uid   = $this->_user['id'];
		$uname = $this->_user['lastname'];
		//check
		if(intval($pid)<=0){
			$result = array('stat'=>106,'info'=>'提交数据异常！');
            exit(json_encode($result));
		}
		//查询check
	    $this->loaddb();
		$prow = self::$pdb->query("select uid,nums,rgnum,baodi,baodimoney,restat,onemoney from plans_lotty_orders where id='".$pid."'")
		                  ->result_array(FALSE);
		if(isset($prow[0])){
			$jindu = ($prow[0]['rgnum']+$prow[0]['baodimoney']/$prow[0]['onemoney'])/$prow[0]['nums'];
			/*if($prow[0]['restat']!=0
			||$jindu>=0.8
			||$prow[0]['uid']!=$uid){
				$result = array('stat'=>104,'info'=>'方案异常！');
				exit(json_encode($result));
			}*/
			if($prow[0]['restat']!=0){
				$result = array('stat'=>104,'info'=>'方案已撤消，不可重复撤消！');
				exit(json_encode($result));
			}
			if($prow[0]['uid']!=$uid){
				$result = array('stat'=>113,'info'=>'你不是发起人，不可撤消！');
				exit(json_encode($result));
			}
		   if($jindu>=0.8){
				$result = array('stat'=>112,'info'=>'方案进度已超过80%，不可撤消！');
				exit(json_encode($result));
			}
		}else{
			$result = array('stat'=>105,'info'=>'方案不存！');
			exit(json_encode($result));
		}
		
		//cancal order 
		$gcancelflag = true;
		$grows =  self::$pdb->query("select id,restat from sale_prousers where pid='".$pid."'")
		                    ->result_array(FALSE);                 
		/*
		 * 循环调用存储过程出现Commands out of sync; you can't run this command now 
		 * 暂时用mysqli的原生方法来做
		 */
		$config = Kohana::config('database.default');
		extract($config['connection']);
		$mysqli = new mysqli($host, $user, $pass, $database, $port);
		if (mysqli_connect_errno())
		{
		    $result = array('stat'=>106,'info'=>'数据异常!');
		    exit(json_encode($result));
		}
		if(is_array($grows)){
	    	foreach ($grows as $row){
	    		if($row['restat']==0){
					if ($mysqli->multi_query("call rev_order(".$row['id'].", -- 根单编号 
			                                    1, -- 撤单类型 1 方案撤单 2 跟单人撤销
							                    2011, -- 交易流水号
			                                   @stat)"))
					{
					    do {
					        if ($re = $mysqli->store_result()) {
					            while ($row = $re->fetch_row()) {
					            	if($row[0]!='succ') $gcancelflag = false;
					             }
					            $re->close();
					         }
					     } while ($mysqli->next_result());
					}
					else{
						$gcancelflag = false;
					}
					
	    		}
	    	}
		}
	    //操作方案表及清保
	    if($prow[0]['baodi']==1){
	    	if($mysqli->multi_query("call clearbaodi(".$pid.", -- 方案编号
                         0, -- 清保类型 0 只清保 1 清保加认购
                         @stat)")){
	    				do {
					        if ($res = $mysqli->store_result()) {
					            while ($row = $res->fetch_row()) {
					            	 //print_r($row);
					                 if($row[0]==-1) $gcancelflag = false;
					             }
					            $res->close();
					         }
					     } while ($mysqli->next_result());
	    	    //var_dump($gcancelflag);
            }
            else{
            	$gcancelflag = false;
            }	
	    }
	    if($gcancelflag){
	    	$crow = self::$pdb->query("update plans_lotty_orders set restat=1 where id='".$pid."'");
	    }else{
	    	$result = array('stat'=>108,'info'=>'撤单失败!');
	    }
		exit(json_encode($result));
		       

		
	}
	/**
	 * 
	 * 单式方案发起
	 */
	public function order_fqds(){
		if (empty($_REQUEST)){
			$result = array('stat'=>102,'info'=>'未提交数据');
            exit(json_encode($result));
		}
		$data = $this->input->post('data');
		$data = json_decode($data,true);
		$this->lottid = $data['lottid'];
		//登录判断
		if(!$this->islogin()){
			$result['stat'] = 103;
			$result['info'] = "未登录!";
			exit(json_encode($result));
		}
		//彩种编号
		//$data = array();
		$data['upfile']  = $_FILES['upfile'];
		//$data['rgnum']    = $this->input->post('rgnum');
		//$data['rgnum']    = $this->input->post('rgnum');
		
		$this->execsub($data);
		
	}
	/**
	 * 订单提交(方案发起)
	 * 
	 */
	public function ordersub(){
		if (empty($_REQUEST)){
			$result = array('stat'=>102,'info'=>'未提交数据');
            exit(json_encode($result));
		}
	
		//登录判断
		if(!$this->islogin()){
			$result['stat'] = 103;
			$result['info'] = "未登录!";
			exit(json_encode($result));
		}
		
		$data = $this->input->post('data');
		$data = json_decode($data,true);
		//$str = '{"lottid":"8","znum":"100","wtype":"1","codes":"02,25,31,34,30|09,05;19,35,05,25,09|01,11;08,33,19,21,34|07,01;15,31,09,33,02|06,08;23,20,22,18,10|08,05;14,05,04,28,33|01,11;01,06,35,04,26|04,05;25,12,15,33,05|01,10;27,29,28,26,16|10,04;08,24,10,32,13|08,05;17,11,22,13,05|10,08;23,35,20,01,15|10,07;08,12,06,18,14|12,10;01,10,26,34,09|09,03;06,19,32,12,22|09,05;19,31,29,24,06|12,11;18,35,31,13,26|05,08;19,33,14,28,11|05,10;02,26,28,05,20|12,02;02,35,12,05,28|09,08;08,15,28,06,03|04,05;13,20,31,28,32|11,05;20,15,08,16,19|01,11;02,16,26,09,07|12,02;14,29,25,21,22|03,09;14,13,29,27,03|04,01;03,29,19,33,06|10,11;07,01,24,04,08|12,07;20,03,08,27,17|05,11;07,22,05,03,34|10,12;10,16,33,07,22|12,10;35,14,29,13,16|01,02;27,20,04,17,10|10,08;32,24,12,33,21|09,11;22,20,14,18,11|02,11;24,08,33,25,07|01,08;15,03,31,01,21|11,10;10,28,14,01,04|02,04;28,09,25,04,03|11,07;35,32,24,01,26|06,04;26,01,23,28,25|04,05;25,18,26,04,34|07,08;32,18,03,04,34|06,10;24,16,17,09,11|01,12;01,28,32,04,14|09,11;10,35,34,15,13|05,11;01,25,15,02,07|11,06;22,02,23,01,05|11,05;04,20,14,32,23|07,02;15,20,19,05,23|08,07;26,21,32,06,11|02,10;16,32,17,27,19|08,05;02,26,19,14,16|08,07;12,34,07,31,15|06,11;16,14,07,29,34|10,12;27,17,03,11,08|07,02;04,22,28,29,13|11,08;02,31,15,14,17|05,12;17,09,32,10,29|07,09;15,20,21,03,30|10,12;30,07,09,17,22|12,08;09,26,17,24,23|11,01;29,20,23,06,17|09,06;08,10,33,27,31|10,01;32,19,14,07,13|06,09;22,30,31,18,06|10,11;13,05,02,03,20|10,04;12,18,11,16,25|04,03;17,28,12,27,33|04,02;35,10,05,12,33|01,05;04,27,29,32,28|12,06;09,32,08,14,01|01,08;16,27,22,06,26|11,04;02,07,06,27,25|03,01;29,22,08,32,10|01,06;21,13,33,03,04|07,04;09,13,25,03,28|02,11;23,32,03,13,12|02,10;04,31,05,11,02|10,01;20,22,09,23,35|05,03;01,02,26,08,19|07,12;26,20,35,31,13|08,06;29,22,34,30,10|03,11;28,33,10,35,19|12,08;10,25,02,32,20|01,04;13,19,09,16,31|12,04;29,12,31,07,03|01,09;32,25,19,03,27|08,11;19,17,11,15,24|04,12;31,16,22,18,15|05,11;02,27,08,15,30|11,07;25,22,28,27,06|04,01;08,13,34,10,22|03,06;19,29,18,20,17|08,07;18,03,26,23,11|01,12;22,30,29,28,26|02,09;12,20,19,25,09|11,01;16,02,24,34,01|11,08;05,25,13,35,11|07,12;35,20,18,28,24|09,05;","ishm":"1","qihao":"1000","multi":"1","amoney":200,"pmoney":2,"show":"1","tcratio":"5","nums":"200","rgnum":"10","omoney":1,"bflag":1,"bnum":"40"}';
		//$data=json_decode($str,true);
		//print_r($data);
		/*$data = array('lottid'=>8, //彩种编号 1
		              'znum'=>3, //注数 1
		              'wtype'=>1, //玩法 1
		              'codes'=>'01,02,03,04,05|08,12;01,02,03,04,05|08,12;01,02,03,04,05|08,12', //投注串
		              'ishm'=>1,//是否是合买 1
		              'qihao'=>'1003', //期号 1
					  'multi'=>1, //倍数 1
		              'amoney'=>6, //总金额 1
					  'pmoney'=>2,//单注金额 1
		              //'show'=>0, //显示方式 1
		              'tcratio'=>0, //提成比例 1
		              //'nums'=>6, //总份数 1
		              //'rgnum'=>2, //认购份数 1
		              'omoney'=>1,//单份金额 1
		              //'bflag'=>1,//保底标识 
		              //'bnum'=>2 //保底份数
		               );*/

	    $this->execsub($data);

	    
	}
	/**
	 * 
	 * 方案提交
	 * @param $data
	 */
	public function execsub(&$data){
		$result = array('stat'=>200,'info'=>'succ');
	    $fvali = true;
		//数据校验
		$fvali = self::getvali($data);
	    if(!$fvali){
	    	$result = array('stat'=>104,'info'=>'提交数据格式问题！');
            exit(json_encode($result));
	    }
	    $this->loaddb();
	    //查询当期是否可销售或是否已截止
	    $qrow = self::$pdb->query("select fendtime,dendtime,buystat from qihaos where qihao='".$data['qihao']."' and lotyid='".$data['lottid']."'")
	                      ->result_array(false);
	    if($qrow){
	    	$endtime = $qrow[0]['fendtime'];
	    	if($data['wtype']==3) $endtime = $qrow[0]['dendtime'];
	    	if(time()>strtotime($endtime)||$qrow[0]['buystat']!=1){
	    		$result = array('stat'=>109,'info'=>'该期已截止或已设置停售！');
            	exit(json_encode($result));
	    	}
	    }else{
	    	$result = array('stat'=>109,'info'=>'期号不存在！');
            exit(json_encode($result));
	    }
	    $data['title'] = htmlspecialchars(urldecode($data['title']));
	    $data['desc'] = htmlspecialchars(urldecode($data['desc']));
	    
		if(empty($data['title'])){
		    if($data['ishm']==0){
		    	$data['title'] = "代购";
		    	$data['desc']  = $data['desc']?$data['desc']:"代购";
		    }else{
		    	$data['title'] = $this->settitle();
		    	$lotyname  = $this->getlottname($data['lottid']);
		    	$data['desc']  = $data['desc']?$data['desc']:"竞博".$lotyname." 第".$data['qihao']."期 ".($data['wtype']==1?"复式":"单式")."合买 ";
		    }
	    }
	    //测试
	    //$this->_user['id']=128;
	    //$this->_user['lastname'] = "admin1";
	    
	    if(in_array($data['wtype'],array(3,6,10))&&$data['isup']){//单式
	    	$file    = $data['upfile'];
			$upload  = $this->uploadtext($file);
			if($upload['stat']!=200){
				unset($upload['codes']);
				$result = $upload;
				exit(json_encode($result));
			}
			$codes = $upload['codes'];
			$data['codes'] = $codes;
	    }
		
	    $data['codes'] = rtrim($data['codes'],$this->fg);
		if($data['codes']=="稍后上传"){$data['codes']='';}
	    //必要数据校验
	    if($data['amoney']/$data['nums'] != $data['omoney'] || intval($data['omoney']) != $data['omoney']){
	    	$result = array('stat'=>106,'info'=>'金额不符！');
            exit(json_encode($result));
	    }
	    if($data['amoney']!=$data['znum']*$data['multi']*$data['pmoney']){
	    	$result = array('stat'=>109,'info'=>'总金额出错！');
            exit(json_encode($result));
	    }
	    if($data['bnum']+$data['rgnum']>$data['nums']){
	    	$result = array('stat'=>107,'info'=>'保底金额+认购金额大于方案总金额！');
            exit(json_encode($result));
	    }
	    //代购
	    if($data['ishm']==0){
	    	$data['nums']  = 1;
	    	$data['rgnum'] = 1;
	    	$data['omoney'] = $data['amoney'];
	    	$data['bflag']  = 0;
	    	$data['bnum'] = 0;
	    }
	    $data['bnum'] = $data['bflag']?$data['bnum']:0;
	    
	    //代购号码栏不能为空
	    if($data['ishm']==0 && empty($data['codes'])){
	    	 $result['stat'] = 100;
			 $result['info'] = "投注号码不能为空!";
	         exit(json_encode($result));
        }
        //复式合买号码栏不能为空
        if($data['ishm']==1 && $data['wtype']==1 && empty($data['codes'])){
        	 $result['stat'] = 100;
			 $result['info'] = "投注号码不能为空!";
	         exit(json_encode($result));
        }
        //check认购及保底比例限制
        if($data['rgnum']/$data['nums']<0.05){
        	 $result['stat'] = $data['rgnum']/$data['nums'];
			 $result['info'] = "发起认购比例不能小于5%!";
	         exit(json_encode($result));
        }
        if($data['bflag']==1 && $data['bnum']/$data['nums']<0.2){
        	 $result['stat'] = 112;
			 $result['info'] = "方案保底比例不能小于20%!";
	         exit(json_encode($result));
        }
        if(intval($data['bnum'])!=$data['bnum'] || intval($data['nums']!=$data['nums'] || intval($data['rgnum'])!= $data['rgnum'])){
        	 $result['stat'] = 112;
			 $result['info'] = "所分份数、保底份数、认购份数必需是整数!";
	         exit(json_encode($result));
        }
        //单式
        if(in_array($data['wtype'],array(3,6,10)) && $data['isup']==0) //单式先发起后上传不做号码校验
        {
        	//pass
        }
		else
		{
			//格式校验
			$check = checknum::get_instance()->check($data['lottid'],$data['wtype'],$data['codes']);
			if(!$check['stat']){
				$result['stat'] = 100;
				$result['info'] = "格式错误!";
				exit(json_encode($result));
			}

			if($check['nums']!=$data['znum']){
				$result['stat'] = 101;
				$result['nums'] = $check['nums'];
				$result['code'] = $data['codes'];
				$result['info'] = "注数不符!";
				exit(json_encode($result));
			}

			//限号
			if ($data['lottid']==11) {
				//$data['codes'] = "1|2|3$3|9|4$4|7|4$4|8|3$4|8|4$3|9|3$3|9|4$6|5|4";
				
				if(!isset($data['passlimit'])) {
					checknum::get_instance()->plschecklimit($data['wtype'],$data['qihao'],$data['codes']);
				}
			}

        }
		
		//余额检测
		$this->_user['user_moneys'];
		if($this->_user['user_moneys']['all_money']<$data['rgnum']*$data['omoney']){
			$result = array('stat'=>110,'info'=>'你的余额不足!');
		    exit(json_encode($result));
		}
		//pass
		
	    $config = Kohana::config('database.default');
		extract($config['connection']);
		$mysqli = new mysqli($host, $user, $pass, $database, $port);
		if (mysqli_connect_errno())
		{
		    $result = array('stat'=>106,'info'=>'数据异常!');
		    exit(json_encode($result));
		}
		$mysqli->query("SET NAMES 'utf8'");
		$gcancelflag = true;
		$query = "call sub_order(".$data['lottid'].", -- 彩种
                                    ".$data['wtype'].", -- 玩法
                                    2011,  -- 方案编号 
                                    ".intval($data['ishm']).", -- 是否是合买 0 代购 1 合买 2 参与合买
                                    ".$data['qihao'].", -- 彩种期号
                                    ".$this->_user['id'].", -- 用户ID
                                    '".$this->_user['lastname']."', -- 用户名
                                    ".$data['multi'].",  -- 倍数
                                    ".$data['amoney'].", -- 总金额
                                    ".$data['pmoney'].", -- 单注金额
                                    0,  -- 发起来源
                                    ".$data['ishm'].", -- 购买类型 0 代购投注 1 合买投注 2 追号投注
                                    '".$data['title']."', -- 方案标题
                                    '".$data['desc']."', -- 方案描述
                                    '".$data['codes']."',  -- 方案内容
                                    ".$data['show'].", -- 显示类型
                                    0,  -- 提成类型
                                    ".$data['tcratio'].",  -- 提成比例
                                    ".$data['nums'].",  -- 总份数
                                    ".$data['rgnum'].",  -- 发起认识份数
                                    ".$data['omoney'].",  -- 单份价格
                                    ".$data['bflag'].", -- 保底标识
                                    ".$data['bnum']*$data['omoney'].",@prid)";
		//var_dump($query);
	    if($mysqli->multi_query($query)){
	    				do {
					        if ($rest = $mysqli->store_result()) {
					            while ($row = $rest->fetch_row()) {
					            	//var_dump($rest);
					                 if($row[0]!='succ') $gcancelflag = false;
					             }
					            $rest->close();
					         }
					     } while ($mysqli->next_result());
	    	
            }else{
            	$gcancelflag = false;
            }
            
            if($gcancelflag){
            	$res = $mysqli->query("select @prid");
            	$row = $res->fetch_row();
            	$pid = $row[0];
				switch($data['lottid']){
					case '8':
						$result['url']='/dlt/succ/'.$pid;
					break;
					case '9':
						$result['headerurl']='/plw/succ/'.$pid;
					break;
					case '10':
						$result['headerurl']='/qxc/succ/'.$pid;
					break;
					case '11':
						$result['headerurl']='/pls/succ/'.$pid;

					break;
					default:
						$result['url']='/dlt/succ/'.$pid;
					break;
				}
            	
            	exit(json_encode($result));
            }else{
            	$result = array('stat'=>105,'info'=>'方案发起失败！');
				exit(json_encode($result));
            }
		
		/*$row=self::$pdb->query("call sub_order(".$data['lottid'].", -- 彩种
                                    ".$data['wtype'].", -- 玩法
                                    2011,  -- 方案编号 
                                    ".intval($data['ishm']).", -- 是否是合买 0 代购 1 合买 2 参与合买
                                    ".$data['qihao'].", -- 彩种期号
                                    ".$this->_user['id'].", -- 用户ID
                                    '".$this->_user['lastname']."', -- 用户名
                                    ".$data['multi'].",  -- 倍数
                                    ".$data['amoney'].", -- 总金额
                                    ".$data['pmoney'].", -- 单注金额
                                    0,  -- 发起来源
                                    ".$data['ishm'].", -- 购买类型 0 代购投注 1 合买投注 2 追号投注
                                    '".$data['title']."', -- 方案标题
                                    '".$data['desc']."', -- 方案描述
                                    '".$data['codes']."',  -- 方案内容
                                    ".$data['show'].", -- 显示类型
                                    0,  -- 提成类型
                                    ".$data['tcratio'].",  -- 提成比例
                                    ".$data['nums'].",  -- 总份数
                                    ".$data['rgnum'].",  -- 发起认识份数
                                    ".$data['omoney'].",  -- 单份价格
                                    ".$data['bflag'].", -- 保底标识
                                    ".$data['bnum']*$data['omoney'].",@prid)")->result_array(FALSE);*/
		if($row[0]['stat']=='succ'){

			exit(json_encode($result));
		}else{
			$result = array('stat'=>105,'info'=>'方案发起失败！');
			exit(json_encode($result));
		}
	}
	
	/**
	 * 
	 * 方案根单列表
	 */
	public function getrg($sec='my'){
		if (empty($_GET)){
			$result = array('stat'=>102,'info'=>'未提交数据');
            exit(json_encode($result));
		}
		$pid      = $this->input->get('pid'); //方案编号
		$lottid   = $this->input->get('lottid'); //方案编号
		$page     = $this->input->get('p'); //当前页码
		$psize    = $this->input->get('psize');//单页数量
		$uid      = $this->input->get('uid');
		//若登录
		//$uid   = $this->_user['id'];
		if(empty($lottid)) $lottid = 8;
		if(empty($page)) $page = 1;
		if(empty($psize)) $psize = 10;
	    /*{buymumber:1,
	    buymoney:'￥4.00',
	    totalrows:1,
	    totalcount:1,
	    pagecount:1,
	    data:[{username:'红心牛仔',
	           getnum:1,paymoney:'4.00',
	           addtime:'2011-09-12 18:16',
	           getmoney:'0.00',
	           userreturn:'-',
	           wordclass:'',
	           trclass:'class="my"'}]}
        */
		$result = array('stat'=>200,'info'=>'succ');
        if (empty($pid))
        {
            $result = array('stat'=>101,'info'=>'参数错误！');
            exit(json_encode($result));
        }
        $this->loaddb();
        $row = self::$pdb->query("select uid,buytype,restat,nums,afterbonus from plans_lotty_orders where id='".intval($pid)."'")
                         ->result_array(false);
        $fquid = $row[0]['uid'];
        if(empty($fquid)){
        	$result = array('stat'=>103,'info'=>'数据异常！');
            exit(json_encode($result));
        }
        /*if($row[0]){
        	if($row[0]['buytype']==2){//合买
        		
        	}
        }*/
        $extwhere = '';
        if($sec=='my'){
        	$extwhere.= " and uid='".$uid."'";
        }
        $extwhere2 = '';
        if(1==$row[0]['restat']||2==$row[0]['restat']){
        	$extwhere2.= " and restat = 1";
        	$prestat = 1;
        }else{
        	$extwhere2.= " and restat = 0";
        	$prestat = 0;
        }
        //echo "select if(restat=$prestat,sum(1),sum(0)) as total,if(restat=0,sum(rgmoney),sum(0)) as allmoney,if(restat=0,sum(nums),sum(0)) as allnums from sale_prousers where pid='".intval($pid)."'";exit;
        //sum(if(restat=$prestat,1,0))
        if($sec=='my'){ //查询全部 
        	$sumrow = self::$pdb->query("select sum(if(restat=$prestat,1,0))  as total,sum(1) as total,sum(if(restat=0,rgmoney,0)) as allmoney,sum(if(restat=0,nums,0)) as allnums from sale_prousers where pid='".intval($pid)."'$extwhere")
                            ->result_array(false);
            $allrow = self::$pdb->query("select sum(if(restat=$prestat,1,0)) as alltotal from sale_prousers where pid='".intval($pid)."'")
                            ->result_array(false);
            $alltotal = $sumrow[0]['total'];
            $enabletotal = $allrow[0]['alltotal'];
        }else{
        	$sumrow = self::$pdb->query("select sum(1) as total,sum(rgmoney) as allmoney,sum(nums) as allnums from sale_prousers where pid='".intval($pid)."' $extwhere2")
                            ->result_array(false);
            $alltotal = $sumrow[0]['total'];
            $enabletotal = $alltotal;
        }
        
        $allpage = ceil($alltotal/$psize)?ceil($alltotal/$psize):1;
        if($page>$allpage||$page<=0) $page=$allpage;
        $offset = ($page-1)*$psize;
        if($sec=='my'){
        	$rows   = self::$pdb->query("select uname,nums,rgmoney,ctime,bonus,buytype,uid,id,restat from sale_prousers where pid='".intval($pid)."'$extwhere order by ctime desc  limit $offset,$psize")
                         ->result_array(false);
        }else{
        	$rows   = self::$pdb->query("select uname,nums,rgmoney,ctime,bonus,buytype,uid,id,restat from sale_prousers where pid='".intval($pid)."'$extwhere2$extwhere  order by ctime desc  limit $offset,$psize")
                         ->result_array(false);
        }
        $result = array('stat'=>200,
                        'info'=>'succ',
                        'buymumber'=>intval($sumrow[0]['allnums']),
                        'buymoney'=>$sumrow[0]['allmoney'],
                        'totalrows'=>intval($sumrow[0]['total']),
                        'enablerows' => $enabletotal,
                        'pagecount'=>$allpage);
        if($rows){
        	$result['data']=array();
        	foreach ($rows as $k=>$row){
        		$tmp = array();
        		//print_r($row);
        		$tmp['username']   = $row['uname'];
        		$tmp['getnum']     = $row['nums'];
        		$tmp['paymoney']   = $row['rgmoney'];
        		$tmp['addtime']    = $row['ctime'];
        		$tmp['getmoney']   = $row['bonus'];
        		$tmp['wordclass']='';
        		if($row['restat']!=0){
        				$tmp['userreturn'] = '已撤单';
        				$tmp['wordclass'] = 'style="color:#999"';
        		}else{
        			if($row['buytype']==1){
        				$tmp['userreturn'] = '-';
        			}else{
        				$tmp['userreturn'] = '<a href=\'javascript:void(0)\' onclick=\'user_return_confirm('.$row['id'].',this)\'>我要撤单</a>';
        			}
        		}
        	    
        		$tmp['trclass']    = $row['uid'] == $fquid?'class="my'.($k%2?"":" tr2").'"':'class="'.($k%2?"":" tr2").'"';
        		array_push($result['data'],$tmp);
        	}
        }
        exit(json_encode($result));
	}
	/**
	 * 后续上传方案
	 * Enter description here ...
	 */
	public function uploadorder($lottid,$pid){
		$result = array('stat'=>200,'info'=>'succ');
		$pid    = intval($pid);
		$lottid = intval($lottid);
		$this->lottid = $lottid;
		if(empty($pid)||empty($lottid)){
			$result = array('stat'=>101,'info'=>'方案编号彩种编号不能为空');
			exit('<script>
			parent.Y.alert("'.$result['info'].'");
			</script>');
		}
	    //登录判断
		if(!$this->islogin()){
			$result = array('stat'=>103,'info'=>'未登录!');
			exit('<script>
			parent.Y.alert("'.$result['info'].'");
			</script>');
		}
		$file    = $_FILES['upfile'];
		$upload  = $this->uploadtext($file);
		if($upload['stat']!=200){
			unset($upload['codes']);
			$result = $upload;
			exit('<script>
			parent.Y.alert("'.$result['info'].'");
			</script>');
		}
		$codes = rtrim($upload['codes'],$this->fg);;
		$this->loaddb();
		$prow = self::$pdb->query('select allmoney,pmoney,wtype,uid from plans_lotty_orders where id="'.intval($pid).'"')
						  ->result_array(false);
        $znum = $prow[0]['allmoney']/$prow[0]['pmoney'];
        if($znum==0||$prow[0]['uid']!=$this->_user['id']){
        	$result = array('stat'=>102,'info'=>'方案异常');
        	exit('<script>
			parent.Y.alert("'.$result['info'].'");
			</script>');
        }

	    //格式校验
		$check = checknum::get_instance()->check($lottid,$prow[0]['wtype'],$codes);
		if(!$check['stat']){
			$result['stat'] = 103;
			$result['info'] = "格式错误!";
			exit('<script>
			parent.Y.alert("'.$result['info'].'");
			</script>');
		}
		if($check['nums']!=$znum){
			$result['stat'] = 104;
			$result['info'] = "注数不符!";
			exit('<script>
			parent.Y.alert("'.$result['info'].'");
			</script>');
		}
		//修改投注内容
		$crow = self::$pdb->query('select content,id from lotty_number_projects where pid="'.intval($pid).'"')
						  ->result_array(false);
	    if($crow[0]){
	    	self::$pdb->query('update lotty_number_projects set content="'.$codes.'",ctime="'.date("Y-m-d H:i:s").'" where id='.$crow[0]['id']);
	    }else{
	    	self::$pdb->query('insert into lotty_number_projects (`pid`,`content`,`ctime`) values ("'.$pid.'","'.$codes.'","'.date("Y-m-d H:i:s").'")');	    	
	    }
	    self::$pdb->query('update plans_lotty_orders set `subtime`="'.date("Y-m-d H:i:s").'",`substat`=1 where id='.$pid);
	    exit('<script>
			parent.Y.alert("'.$result['info'].'");
			parent.location.reload();
			</script>');
	}
	
	//if()
	
	/**
	 *  获取上传文件内容
	 */
	public function uploadtext(&$file){
		$result   = array('stat'=>200,'info'=>'succ','codes'=>'');
	    if(upload::valid($file)){
				if(upload::size($file,array("4M"))){
					if(upload::type($file,array('txt'))){
						$tmp             = file($file["tmp_name"]);
						$codes = '';
						foreach ($tmp as $val){
							if($val){
								//$codes.=str_replace(PHP_EOL, '',$val).";";

								switch($this->lottid){
									case '9':
										$this->fg=';';
										$val=implode(",", str_split(trim($val)));
									break;
									case '10':
										$this->fg=';';
										$val=implode(",", explode(',',trim($val)));
									break;
									case '11':
										$this->fg=';';
										$val=implode(",", str_split(trim($val)));
									break;
	
								}


								$codes.=str_replace(array("\r\n", "\n", "\r"),"",$val).$this->fg;
							}
						}
						//$codes           = implode(';',$tmp);
						$result['codes'] = $codes; 
					}else{
						$result = array('stat'=>801,'info'=>'文件类型不支持','codes'=>'');
					}
				}else{
					$result = array('stat'=>802,'info'=>'文件大于4m','codes'=>'');
				}
		}else{
			$result = array('stat'=>803,'info'=>'没上传文件','codes'=>'');
		}
		return $result;
	}
	
	public function loaddb(){
		if(!self::$pdb){
		 	self::$pdb = Database::instance();
		}
	}
	/**
	 * 格式校验
	 * @param unknown_type $data
	 */
	public static function getvali(&$data){
		switch($data['lottid']){
			case '9':
			case '10':
			case '11':
					if('0'==$data['ishm']){
						$data['show']= '3';
						$data['nums']= '1';
						$data['rgnum']= '1';
						$data['bflag']= '0';
						$data['bnum']= '0';
						$data['omoney']= $data['amoney'];
					}
			break;
		}
		
		$rules = array('lottid'=>array('numeric','required'),
					'znum'=>array('numeric','required'),
					'wtype'=>array('numeric','required'),
				     'ishm'=>array('numeric','required'),
					'show'=>array('numeric','required'),
					'tcratio'=>array('numeric','required'),
					'nums'=>array('numeric','required'),
					'rgnum'=>array('numeric','required'),
					'omoney'=>array('numeric','required'),
		    	    'bflag'=>array('numeric',''),
					'bnum'=>array('numeric',''),
					'pmoney' => array('numeric','required'),
					'qihao'=>array('string','required'),
		            'multi'=>array('numeric','required'),
					'amoney'=>array('numeric','required'),
					'title'=>array('string',''),
					'desc'=>array('string',''),
					'codes'=>array('string','')
		            );
		


	  $fvali = true;            
	  foreach ($rules as $key=>$val){
			if(!isset($data[$key])) {
				if($val[1]=='required'){
						$fvali = false;
						break;
				}else{
						$data[$key] = $val[0]=='numeric'?0:"";
						continue;
				}
			}
		    if($val[0]=='numeric'){
				if(!is_numeric($data[$key])) $fvali = false;
			}elseif($val[0]=='string'){
				if(!is_string($data[$key])) $fvali = false;	
			}
		}
		return $fvali;
	}
	/**
	 * 
	 * Enter description here ...
	 */
	public function settitle(){
		$titles = Kohana::config('titles.title');
		$key = array_rand($titles);
		return $titles[$key];
	}
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $lottid
	 */
	public function getlottname($lottid=8){
		$lotynames = Kohana::config('ticket_type.type');
		$lotyname  = $lotynames[$lottid];
		return $lotyname;
	}
	
}