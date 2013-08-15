<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 排列五
 * @author dexin.tang
 *
 */
class Check_code_Controller extends Template_Controller {
	
	public static $pdb = null;
	
	public function __construct()
	{
		parent::__construct();
	}
	public function loaddb(){
		if(!self::$pdb){
		 	self::$pdb = Database::instance();
		}
	}
	public function  index(){
	print_r($_FILES['upfile']);
	print_r($_POST);


		echo '{"ret":0,"zs":8,"err":0,"msg":"消息","time":"2011-12-16 16:02:23","size":"1KB","fid":"\/data\/tmp\/dshm\/5_1216160223563_63_83213.txt","detail":"这是什么","checktime":3.39412689,"uptime":17.3799992,"alltime":41.2018299}';
		
	}
	
	public function  yb(){
		
	}

	public function limitcode()
	{
	
	    echo '{code:0, msg:""}';
	}
	
	public function limitlist ($lotid = 11,$qihao) {
	    
		if($lotid!=11) echo "不存在限号";
		$this->loaddb();

		$limitcode=self::$pdb->select('limitcode')
							  ->from('qihao_exts')
							  ->where(array('lotyid'=>$lotid,'qihao'=>$qihao))
							  ->get()->current()->limitcode;

		if(strlen($limitcode)<3) echo "不存在限号";

		$limitArray=explode(',',$limitcode);

		$str='		<span class="gray">排列三 '.substr($qihao,2).'期统计　　'.date("m月d日 H:i:s",time()).' 更新</span>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="zj_table">
			<colgroup>
				<col width="20%"/>
				<col width="25%"/>
				<col width="30%"/>
				<col width="25%"/>
			</colgroup>

			<thead>
				<tr>
					<th class="tc">号码</th>
					<th class="tc">号码</th>
					<th class="tc">号码</th>
					<th class="tc">号码</th>
				</tr>

			</thead>
		  <tbody>';
		  	$i=0;
			foreach ($limitArray as $key=>$val){
				if($key==0)	$str .='<tr>';

		      	if($i<4){
					$str.='<td class="tc"><b class="org">'.$val.'</b></td>';
				
			  	}else{		
					$str.='</tr><tr><td class="tc"><b class="org">'.$val.'</b></td>';   
					$i=0;
			  	}
			  	$i++;
			  	if($key==(count($limitArray)-1)){
					for ($x=0; $x<4-$i; $x++) {
						$str.='<td class="tc"><b class="org">&nbsp;</b></td>';
					}
				  	$str.='</tr>';
			  	}
		  	}
		 
		$str.='</tbody></table>	';

		echo $str;
	}

	
	
}