<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-足彩胜负-订单详细</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<script language="javascript">
var submit_url = '/zcsf/submit_buy_join';
var join_user_forder = 'zcsf/';
</script>
<?php
echo html::script(array
(
    'media/js/yclass.js',
	'media/js/loginer',
	'media/js/fangan',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/zc',
	'media/css/mask',
    'media/css/style',
    'media/css/css1',
), FALSE);
?>
<script language="javascript">
/*Y.extend('jsonp', function (url, data, fn){
    window['echo_json_'+data.c_id] = fn;
    Y.use(url);
});*/
</script>
<script>
function openordowndiv(){
	var fanandiv = Y.one('#fanandiv');
	var openbut = Y.one('#openbutten');
	if(fanandiv.style.display=='none'){
		fanandiv.style.display='block';
		openbut.innerHTML = '点击隐藏方案';
		openbut.className = 'p_hide';
	}else{
		fanandiv.style.display='none';
		openbut.innerHTML = '点击显示方案';
		openbut.className = 'p_show';
	}
}
window.init()
</script>
</head>
<body>
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>zcsf/sfc_14c"><font class="blue">足彩胜负</font></a> &gt; 订单详细
	</div>
	<div style="float:right; margin-right:20px;">
		<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
	</div>
	<div style="clear:both;"></div>
</div>
<!--面包屑导航_end-->
<!--header end-->
<div class="mt30" id="bd">
  <div id="main">
    <div class="box_top" style="display:block;">
      <div class="box_top_l"></div>
    </div>
    <div class="box_m">
      <div class="det_t_bg">
        <div class="s-logo sfc-logo"></div>
        <div class="det_h">
          <?php
				switch($detail_parent['play_method']) {
                    case 1:  //14场胜负彩
                        $expect_text="14场胜负";
						$expect_type="14";
                        break;
                    case 2:	//9场任选
                        $expect_text="任选9场";
						$expect_type="9";
                        break;
                    case 3://6场半
                        $expect_text="6场半全";
						$expect_type="6";
                        break;
                    case 4://4场半
                        $expect_text="4场进球";
						$expect_type="4";
                        break;
                    default:
                        $expect_text="14场胜负";
						$expect_type="14";
                        break;
				}

					if($detail_parent['is_buy']==1){
						$text1="合买";
					}else{
						$text1="代购";
					}
				   if ($detail_parent['codes']=="稍后上传"){
					   $text2="单式";
				   }elseif ($detail_parent['codes']=="文本文件上传"){
					   $text2="单式";
				   }else{
					   $text2="复式";
				   }
				   
					$cai_result=1;	
					foreach($expect_list as $value){
						if($value['cai_result']===""){
							$cai_result=0;	
						}
					}
				   //d($cai_result);
				   //彩果_数组
            	   if($cai_result==1){
						 foreach($expect_list as $key=>$value){	
							   if ($detail_parent['play_method']==1 or $detail_parent['play_method']==2 or $detail_parent['play_method']==3){ 						
									$tmp_cai_result[]=$value['cai_result'];
								}elseif($detail_parent['play_method']==4){
									$tmp_data=explode(",",str_replace("+","",$value['cai_result']));		
									$tmp_cai_result[]=$tmp_data[0];
									$tmp_cai_result[]=$tmp_data[1];
								}
						 }
				   }else{
						$tmp_cai_result="";   
				   }
				   //$tmp_cai_result=array(3,1,1,1,1,1,1,1,1,1,3,1,0,0);//测试的彩果数据
				   ?> 
                   
                                      
				   <?php if($detail_parent['friends']=="all"){ //判断是否是有参与合买权限
                            $is_hmr=1;
                        }elseif(in_array($user['lastname'],explode(",",$detail_parent['friends']))){
                            $is_hmr=1;
                        }else{
                            $is_hmr=0;
                        }
                   ?>
                     
          <h2><?php echo $expect_text;?>第<?php echo $detail_parent['expect'];?>期 <?php echo $text2.$text1;?></h2>
          <p><span class="m_r25">此方案发起时间：<?php echo $detail_parent['time_stamp'];?></span><span class="m_r25">认购截止时间：<?php echo $detail_parent['time_end'];?></span><span>方案编号：<?php echo $detail_parent['basic_id'];?></span></p>
        </div>
        <a href="/buycenter" class="m_link">返回合买列表&gt;&gt;</a> </div>
      <div id="xx1">
        <div class="det_g_t">方案基本信息</div>
        <table class="buy_table" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td class="td_title2">发起人信息</td>
              <td class="con_content"><div class="detail_d">
                  <p> <span class="m_r50 record"> <?php echo $user['lastname']; ?> </span></p>
                  			<?php
							if($_user['id'] != $detail_parent['user_id']){
							?>
							<div id="auto_order">
							<span id="zdgd" class="gray">自动跟单：</span>
							<a class="btn_dot1" id="auto_order" href="javascript:void 0">我要定制</a>
							</div>
							<?php } ?>
                </div></td>
            </tr>
            <tr>
              <td class="td_title2">方案信息</td>
              <td class="con_content">
              
                  <div class="tdbback mb_10">
                      <table cellspacing="0" cellpadding="0" border="0" width="100%" class="tablelay eng">
                        <tr>
                          <th width="18%">总金额</th>
                          <th width="8%">倍数</th>
                          <th width="10%">份数</th>
                          <th width="10%">每份</th>
                          <th width="12%">发起人提成</th>
                          <th width="10%">彩票标识</th>
                          <th width="18%">保底金额</th>
                          <th width="10%" class="last_th">购买进度</th>
                        </tr>
                        <tr class="last_tr">
                          <td><span class="red eng">￥<?php echo $detail_parent['price'];?></span>元</td>
                          <td><?php echo $detail_parent['rate'];?>倍</td>
                          <td><?php echo $detail_parent['copies'];?>份</td>
                          <td nowrap="nowrap">￥<?php echo number_format($detail_parent['price_one'],2);?>元</td>
                          <td nowrap="nowrap"><span class="red eng"><?php echo $detail_parent['deduct'];?>%</span></td>
                          <td><?php if($detail_parent['status'] == 2 || $detail_parent['status'] == 3 || $detail_parent['status'] == 4 || $detail_parent['status'] == 5){
                            echo "已出票"; 
                            /*<a href="javascript:;" onclick="Y.openUrl('/zcsf/viewdetail_number/<?php echo $detail_parent['basic_id'];?>',530,500);return false;" target="_blank">已出票</a>	*/				  
						   }else{
                          echo "未出票";
                             } ?></td>
                          <td><?php if($detail_parent['is_baodi']==0){ echo "未保底"; }else{ echo "￥".$detail_parent['end_price']*$detail_parent['price_one']."元(<span class='red'>".intval(number_format($detail_parent['end_price']/$detail_parent['copies']*100,2))."%</span>)";}?></td>
                          <td class="last_td"><span class="red eng"> <?php echo $detail_parent['progress'];?>%</span></td>
                        </tr>
                      </table>
                    </div>

                <?php if ($detail_parent['codes']=="稍后上传" and $detail_parent['is_upload']==0) {
							if($detail_parent['parent_id']==0 and $_user['id']==$detail_parent['user_id'] and !$tmp_cai_result and strtotime($expect_data['start_time'])<time() and $expect_data['buy_status']==1){
								echo "<a href=\"javascript:;\" onclick=\"Y.openUrl('/zcsf/sfc_shsc/".$detail_parent['basic_id']."',630);\">上传方案</a>";
							}else{
							  echo "<p> 方案未传 </p>";
							} ?>
                <?php }elseif($detail_parent['is_upload']==1){
					        $upload_html="<p> 方案已传，请点击<font class='red'><a href='/".$detail_parent['upload_filepath']."' target='_blank'>下载</a></font> </p>";
					        if ($is_public === true) {
					        	echo $upload_html;
					        }
					        else {
					        	echo '<p> '.$is_public.'</p>';
					        }
							/* if($detail_parent['is_open']==2){
									if($join_data){
									  echo $upload_html;
									}else{
									  echo "<p> 对参与本方案合买者公开 </p>";
									} 
							}elseif($detail_parent['is_open']==1){
									if(time()<strtotime($detail_parent['time_end'])){
									  echo $upload_html;
									}else{
									  echo "<p> 截止后公开 </p>";
									} 								
							}else{
							  echo $upload_html;
							}  */
							?>                   
                <?php } else { ?>
						   <?php if ($detail_parent['is_select_code']==0 and !$tmp_cai_result) {
                                      if($detail_parent['parent_id']==0 and $_user['id']==$detail_parent['user_id'] and !$tmp_cai_result and strtotime($expect_data['start_time'])<time() and $expect_data['buy_status']==1){
                                        echo "<p> <a style=\"color:blue;\" href=\"/zcsf/shxh_".$expect_type."c/".$detail_parent['basic_id']."\" >立即选号</a> </p>";
                                      }else{
                                        echo "<p> 未选号 </p>";
                                      }
                                 }else{?>                
                                          <div class="detail_d clearfix">
                                                    <?php
                                                     $a=0;
                                                     $b=0;
                                                     $c=0;
                                                     $d=0;													 
                                                     foreach(explode(",",$detail_parent['codes']) as $key=>$value){
                                                     if(strlen($value)==1) $a++;
                                                     if(strlen($value)==2) $b++;
                                                     if(strlen($value)==3) $c++;
                                                     if(strlen($value)>3) $d++;													 
                                                     }
													 ?>
                                            <p class="p_xh">投注选号：<strong class="red eng f14"><?php if($detail_parent['play_method']==2){echo ($a-5);}else{echo $a;} ?></strong>个单选、<strong class="red eng f14"><?php echo $b; ?></strong>个双选、<strong class="red eng f14"><?php echo $c; ?></strong>个三选<?php if($detail_parent['play_method']==4){?>、<strong class="red eng f14"><?php echo $d; ?></strong>个四选<?php }?></p>
                                            <a href="#" id="openbutten" class="p_hide" onclick="openordowndiv()" style="display:block;;">点击隐藏方案</a> </div>
										<?php
										if ($is_public === true) { 
										?>
                                         <div id="fanandiv" class="tdbback" style="display:block;">
                                            <!--点击展开查看方案begin-->
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablelay">
                                              <tr>
                                                <th class="trbg trline3">场次</th>
												<?php foreach($expect_list as $key=>$value){?>
                                                <?php  if ($detail_parent['play_method']==1 or $detail_parent['play_method']==2 or $detail_parent['play_method']==3){ ?>
                                                <th class="trbg trline5"><?php echo $value['changci']; ?></th>
                                                <?php }elseif($detail_parent['play_method']==4){?>
                                                <th class="trbg trline5" colspan="2"><?php echo $value['changci']; ?></th>
                                                <?php }} ?>
                                                <th class="trbg trline5">倍数</th>
                                                <th class="trbg trline4 trline5">金额</th>
                                              </tr>
                                              <tr class="tr1">
                                                <td class="trline trline3">对阵</td>
                                                <?php foreach($expect_list as $key=>$value){?>
                                                <?php  if ($detail_parent['play_method']==1 or $detail_parent['play_method']==2){ ?>
                                                <td class="trline trline5"><div class="texts"><?php echo $value['vs1']; ?> <span class="gray">
                                                    <?php if ($value['game_result']){ echo $value['game_result'];} else {echo " VS ";} ?>
                                                    </span> <?php echo $value['vs2']; ?> </div></td>
                                                <?php }elseif($detail_parent['play_method']==4){?>
                                                <td class="trline trline5"><div class="texts"><?php echo $value['vs1']; ?></div></td>
                                                <td class="trline trline5"><div class="texts"><?php echo $value['vs2']; ?></div></td>
                                                <?php }elseif($detail_parent['play_method']==3){?>
                                                <?php if($key==0 or $key==2 or $key==4 or $key==6 or $key==8 or $key==10){?>
                                                <td class="trline trline5"><div class="texts"><?php echo $value['vs1']; ?> <span class="gray"> VS </span> <?php echo $value['vs2']; ?> <span class="red">半</span> </div></td>
                                                <?php }else{?>
                                                <td class="trline trline5"><div class="texts"><?php echo $value['vs1']; ?> <span class="gray"> VS </span> <?php echo $value['vs2']; ?> <span class="red">全</span> </div></td>
                                                <?php }}} ?>
                                                <td class="trline trline5">&nbsp;</td>
                                                <td class="gray trline trline4 trline5">单位（元）</td>
                                              </tr>
                                              <tr class="tr2">
                                                <td class="gray trline trline3">选号</td>
                                                
                                               <?php if($tmp_cai_result){?>
                                                        <?php foreach(explode(",",$detail_parent['codes']) as $key=>$value){?>
                                                        <td class="trline trline5 ">
                                                            <?php 
                                                                foreach(str_split($value) as $val){
                                                                    if($val==$tmp_cai_result[$key]){
                                                                        echo "<span class=\"red\">".$val."</span>"; 
                                                                    }else{
                                                                        echo $val; 												
                                                                    }
                                                                }
                                                             ?>                          
                                                        </td>
                                                        <?php }?>                               
                                               <?php }else{?> 
                                                        <?php foreach(explode(",",$detail_parent['codes']) as $key=>$value){ ?>
                                                        <td class="trline trline5"><?php echo $value; ?></td>
                                                        <?php }?>                                                                 
                                                <?php }?>                      
                                                  
                                                  <td class="trline trline5"><?php echo $detail_parent['rate'];?></td>
                                                  <td class="red trline trline4 trline5">￥<?php echo $detail_parent['price'];?></td>
                                                </tr>
                                              </table>
                                          <!--点击展开查看方案end-->
                                       </div>
                                       <?php
										}
										else {
											echo '<p> '.$is_public.'</p>';
										} 
                                       ?>
                					<?php }?>
                <?php }?>
                <?php 
			     $plan_basic_obj = Plans_basicService::get_instance();
			     $userid = $_user['id'];
			     //d($user);
			     if ($plan_basic_obj->is_cancel_plan($detail['basic_id'], $userid) == true) {
			     	echo '<a href="/zcsf/cancel_plan/'.$detail['basic_id'].'">我要撤单</a>';
			     }
			     ?>
                </td>
            </tr>
            
            <?php if($tmp_cai_result and ($detail_parent['status']==3 or $detail_parent['status']==4 or $detail_parent['status']==5)){?>
            <!--开奖后显示开奖号码-->
            <tr>
              <td class="td_title2">中奖详情</td>
              <td class="con_content">
			  <?php if($detail_parent['status']==0){
                	 	echo "<p>该方案已作废，原因：未满员。</p>";		
                	}else{
               		 	echo "<p>购买详情：已满员。</p>";
              		}
			  ?>
              <p>开奖号码：
			  <?php foreach(explode(",",$detail_parent['codes']) as $key=>$value){
                          $arr_code[] = str_split($value);
                      }
                      $ok_num=0;
                      foreach($tmp_cai_result as $k=>$val){
                              echo "<b class=\"ba-red\">".$val."</b>";
                              if($detail_parent['type']==1){
                                  if(in_array($val,$arr_code[$k])){
                                      $ok_num++;   
                                  } 
                              }
                      }
              ?>
              </p>
              <p><span class='fl'>中奖情况：猜中<font color=red><?php echo $ok_num; ?></font>场
			  <?php 
              
                    switch($detail_parent['status']) {
                    case 1:
                        $status = "未出票";
                        break;
                    case 2:
                        $status = "已出票";
                        break;
                    case 3:
                        $status = "未中奖";
                        break;
                    case 4:
                        $status = "已中奖";
                        break;	
                    case 5:
                        $status = "已派奖";
                        break;
                    case 6:
                        $status = "方案取消";
                        break;
            }
			if($detail_parent['status']==4 or $detail_parent['status']==5){
				//$deduct_bonus=($detail_parent['bonus']-$detail_parent['price'])*($detail_parent['deduct']/100);//提成金额
				$deduct_bonus=($detail_parent['bonus'])*($detail_parent['deduct']/100);//提成金额
			?>
            <p>税后奖金：<font color=red>￥<?php echo $detail_parent['bonus'];?></font>，发起人提成<font color=red>￥<?php echo $deduct_bonus;?></font>，每份派奖：<font color=red>￥<?php echo ($detail_parent['bonus']-$deduct_bonus)/$detail_parent['copies'];?></font>&nbsp;&nbsp;&nbsp;&nbsp;<?php /**?><span style="cursor:pointer" onClick="Y.openUrl('#',700,414)"><font color="#FF6600"><u>查看奖金明细</u></font></span><?php **/?></p>
			<?php //echo $status;
			}
			?>
              </p> 
              </td>
            </tr>
            <?php }elseif( !$tmp_cai_result && $detail_parent['is_buy']==1 && $detail_parent['status']==0){?>
            <!--开奖前可购买-->
            <tr>
              <td class="td_title2">我要认购</td>
              <td class="con_content">
			  <?php if($detail_parent['progress']==100){?>
                        该方案已停止认购，原因：已满员
                <?php }elseif(strtotime($buy_end_time)<time()){ ?>
                        该方案已停止认购，原因：已过期                                       
                <?php }elseif($is_hmr==1){ ?>
                        <div class="buy_btn"> <a id="submitCaseBtn3" href="javascript:void 0" class="btn_buy_m" title="立即购买">立即购买</a> </div>
                        <p id="userMoneyInfo">您尚未登录，请先<a href="javascript:void%200" title="" onclick="Yobj.postMsg('msg_login')">登录</a></p>
                        还可以认购 <span class="red eng"><?php echo $detail_parent['buyed']?></span> 份，我要认购
                        <input name="buynum" id="buynum" type="text" class="mul" maxlength="6" value="1" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onkeydown="if(event.keyCode==13){checkForm();return false;}"/>
                        份 总金额<span class="red eng">￥</span><span class="red eng" id="permoney">1.00</span>元
                        </p>
                        <p class="read"><span class="hide_sp">
                        
                        <a href="document.getElementById('buyform').submit();">购买</a>
                        
                          <input type="checkbox" checked="checked" id="agreement" value="1"/>
                          </span>我已阅读并同意《<a href="javascript:;" onclick="Y.openUrl('/doc/webdoc/gmxy',505,426)">用户合买代购协议</a>》</p>
                        <input type="hidden" value="1" id="agreement2"/>
                <?php }else{?>
                		该方案只对部份网友开放
                <?php }?>
                </td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
      
      <div id="xx2">
        <div class="det_g_t">方案分享信息</div>
        <table class="buy_table" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td class="td_title2">方案宣传</td>
              <td class="con_content"><div class="detail_d clearfix">
                  <!--<div class="copy_link"><a href="javascript:void(0);" onclick="copyurl('<?php echo url::base();?>zcsf/viewdetail/<?php echo $detail_parent['basic_id'];?>')" class="public_Lblue" id="copystr"><b>点击复制方案地址</b></a></div>-->
                  <p class="gray">方案标题：<?php echo $detail_parent['title'];?></p>
                  <p class="gray">方案描述：<?php echo $detail_parent['description'];?></p>
                </div></td>
            </tr>
            
 
				  <tr class="last_tr">
					<td class="td_title2">合买用户</td>
					<td class="con_content">
						<div class="yh_tab">
							<ul class="clearfix">
								<li id="joinCount" class="" onclick="javascript:Showan(1,2);">总参与人数<span id="totalCount"></span>人</li>
								<li id="meyBuy" class="an_cur" onclick="javascript:Showan(2,2);">您的认购记录</li>
							</ul>
						</div>
						<div id="show_list_div"></div>
					</td>
				  </tr> 
            
            
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<input name="isend" id="isend" type='hidden'  value="0">
<input name="isjprizesuc" id="isjprizesuc" type='hidden'  value="1">
<input name="pregetmoney" id="pregetmoney" type='hidden'  value="0">
<input name="anumber" id="anumber" type='hidden'  value="<?php echo $detail_parent['copies']?>">
<input name="lotid" id="lotid" type="hidden" value="<?php echo $detail_parent['ticket_type']?>">
<input name="user_id" id="user_id" type="hidden" value="<?php echo $_user['id']?>">
<input name="fuser_id" id="fuser_id" type="hidden" value="<?php echo $detail_parent['user_id']?>">
<input name="lottyid" id="lottyid" type="hidden" value="2">
<!--彩种Id-->
<input name="playid" id="playid" type="hidden" value="<?php echo $detail_parent['play_method']?>">
<!--玩法Id-->
<input name="expect" id="expect" type="hidden" value="<?php echo $detail_parent['expect']?>">
<!--期号-->
<input name="pid" id="pid" type="hidden" value="<?php echo $detail_parent['basic_id']?>">
<input name="basic_id" id="basic_id" type="hidden" value="<?php echo $detail_parent['basic_id']?>">
<!--彩种Id-->
<input name="senumber" id="senumber" type="hidden" value="<?php echo $detail_parent['buyed']?>">
<!--保底份数-->
<input name="onemoney" id="onemoney" type="hidden" value="<?php echo $detail_parent['price_one']?>">
<!--每份金额-->
<input name="ishm" id="ishm" type='hidden'  value="1">
<!--是否是合买-->
<input name="care_username" id="main_username" type="hidden" value="%D0%A1%C9%FA%B2%BB%B2%C5" />
<input name="buymumber" id="buymumber" type="hidden" value="9472">
<!--认购份数-->
<input name="reload" id="reload" type="hidden" value="1">
<input name="orderstr" id="orderstr" type="hidden" value="1">
<input name="orderby" id="orderby" type="hidden" value="desc">
<!--footer start-->
<?php echo View::factory('footer')->render();?>
<!--footer end-->

<textarea id="responseJson" style="display: none;">{
	period :      "<?php echo $detail_parent['expect'];?>",   //期号
	serverTime :  "<?php echo date("Y-m-d H:m:s");?>",   //服务器时间
	endTime :     "<?php echo $detail_parent['time_end'];?>",    //截止时间
	singlePrice : 2,   //单注金额
	baseUrl : "<?php echo url::base();?>"  //网站根目录
}</textarea>

 <?php echo View::factory('zcsf/public_div')->render();?>


<script type="text/javascript">
var fanandiv = document.getElementById('fanandiv');
function toggle_fanandiv(that) {
	if (fanandiv.style.display == 'none') {
		fanandiv.style.display = '';
		that.getElementsByTagName('b')[0].className = 'c_up';
	} else {
		fanandiv.style.display = 'none';
		that.getElementsByTagName('b')[0].className = 'c_down';
	}
}
Class( {
	ready : true,
	index : function() {
		var max_prize = 0,
			min_prize = 0,
			zygg,  //是否自由过关
			_gg_name,
			issuc     = this.getInt(this.get('#issuc').val()),
			gg_name   = this.get('#gg_name').val(),
			beishu    = this.get('#beishu').val(),
			max_pl    = this.get('#max_pl').val(),
			min_pl    = this.get('#min_pl').val(),
			max_danpl = this.get('#max_danpl').val(),
			min_danpl = this.get('#min_danpl').val();
		if (issuc>0) {
			max_prize = this.get('#max_pl').val();
			min_prize = this.get('#min_pl').val();
			beishu=1;
		} else {
            var dt = this.getDT(this.get('#max_pl').val(), this.get('#min_pl').val());
            var max_t_pl = [], max_d_pl = [],
                 min_t_pl = [], min_d_pl = [],
                 d=dt.d, t=dt.t;
            for(var k in d){
                var pl = d[k];
                pl.sort(Array.up);
                min_d_pl.push(pl[0]);
                max_d_pl.push(pl[pl.length-1]);
            }
            for(k in t){
                var pl = t[k];
                pl.sort(Array.up);
                min_t_pl.push(pl[0]);
                max_t_pl.push(pl[pl.length-1]);
            }
            min_t_pl.sort(Array.up);
            min_d_pl.sort(Array.up);
            var gg = gg_name.split(',').map(function (x){
                return parseInt(x)
            }).sort(Array.up)[0];
            if (gg>min_d_pl.length) {//如果最小命中大于胆SP组的长度, 则取相应长度的拖
                min_t_pl = min_t_pl.slice(0, gg - min_d_pl.length)
            }else{
                min_d_pl = min_d_pl.slice(0, gg);
                min_t_pl = [];
            }
			max_prize = this.postMsg('msg_predict_max_prize', max_t_pl, gg_name, max_d_pl , true).data;//t, type, d, round
			min_prize = this.postMsg('msg_predict_min_prize', min_t_pl, gg_name, min_d_pl, true).data;
		}
		if (min_prize && max_prize) {//显示区间
			this.get('#prize_predict').html('￥' + (min_prize * beishu).toFixed(2) + '-' + (max_prize * beishu).toFixed(2));
		} else {//隐藏
			this.get('#prize_predict').parent('span').hide();
			this.get('a.tog_fa').setStyle('marginTop', 0);
		}
	},
    getDT: function (d, t){//取得胆拖数据
        var d1 = this.string2obj(d);
            all = this.string2obj(t), t2={}, d2={};
            for(var k in all){
                if (k in d1) {
                    d2[k] = all[k]
                }else{
                    t2[k] = all[k]
                }
            }
        return {
            d: d2,
            t: t2
        }
    },
    string2obj: function (str){
        var g, o={};
		if (str.trim()!='') {
			g = str.toString().split('/');
			g.each(function (a, i){
				var x=a.replace(']','').split('[');
				o[x[0]] = x[1].replace(/[^#,]+#/g,'').split(',');
			});
		}
        return o;
    }
} );
window.init();
</script>
<div style="position: absolute; display: none; z-index: 9999;" id="livemargins_control"><img src="faxq_files/monitor-background-horizontal.png" style="position: absolute; left: -77px; top: -5px;" height="5" width="77"> <img src="faxq_files/monitor-background-vertical.png" style="position: absolute; left: 0pt; top: -5px;"> <img id="monitor-play-button" src="faxq_files/monitor-play-button.png" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5" style="position: absolute; left: 1px; top: 0pt; opacity: 0.5; cursor: pointer;"></div>
<div class="tips_m" style="top: 700px; width: 500px; display: none; position: absolute;" id="yclass_alert">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2 id="yclass_alert_title">温馨提示</h2>
        <span class="close" id="yclass_alert_close"><a href="#">关闭</a></span> </div>
      <div class="alert_c">
        <div class="state error">
          <div class="stateInfo f14 p_t10" id="yclass_alert_content"></div>
        </div>
      </div>
      <div class="tips_sbt">
        <input value="确 定" class="btn_Dora_b" id="yclass_alert_ok" type="button">
      </div>
    </div>
  </div>
</div>
<div class="tips_m" style="display: none; position: absolute;" id="yclass_confirm">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2 id="yclass_confirm_title">温馨提示</h2>
        <span class="close" id="yclass_confirm_close"><a href="#">关闭</a></span> </div>
      <div class="tips_info">
        <div class="stateInfo f14 p_t10" id="yclass_confirm_content" style="zoom:1"></div>
      </div>
      <div class="tips_sbt">
        <input value="取 消" class="btn_Lora_b" id="yclass_confirm_no" type="button">
        <input value="确 定" class="btn_Dora_b" id="yclass_confirm_ok" type="button">
      </div>
    </div>
  </div>
</div>
<div style="display:none;" id="open_iframe">
  <div id="open_iframe_content"></div>
</div>
<div style="opacity: 0.2;" tabindex="-1" class="yclass_mask_panel"></div>
<div style="position: absolute; z-index: 500000; left: -99999px;">
  <div style="min-width: 120px; text-align: center; font: 12px/1.5 verdana; color: rgb(51, 51, 51);"></div>
  <div style="position: absolute; left: 0pt; top: 0pt; display: none; z-index: 9; width: 88%; height: 30px; background: none repeat scroll 0% 0% rgb(238, 238, 238); opacity: 0.1; cursor: move;"></div>
</div>
<div class="notifyicon tip-2">
  <div class="notifyicon_content"></div>
  <div class="notifyicon_arrow"><s></s><em></em></div>
  <div class="notifyicon_space"></div>
</div>
</body>
</html>
