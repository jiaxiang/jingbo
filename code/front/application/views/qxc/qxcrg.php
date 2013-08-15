<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-七星彩-订单详情</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<script language="javascript">
var submit_url = '/lotteryapi/orderprocess/buy';
var join_user_forder = 'jczq/';
</script>
<?php
echo html::script(array
(
    'media/js/yclass.js',
	'media/js/loginer',
	'media/lottnum/js/jquery',
    'media/lottnum/js/txt_scroll',
    'media/lottnum/js/utils',
    'media/lottnum/js/rg',
), FALSE);
echo html::stylesheet(array
(
 	//'media/css/public',
	//'media/css/mask',
    //'media/css/style',
    //'media/css/css1',
    'media/lottnum/style/hxpublic',
	'media/lottnum/style/rg-style',
	'media/lottnum/style/style',
), FALSE);
?>
<script language="javascript">
Y.extend('jsonp', function (url, data, fn){
    window['echo_json_'+data.c_id] = fn;
    Y.use(url);
});
</script>
<SCRIPT language=Javascript>
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
</SCRIPT>
</head>
<body>
<iframe style="position: fixed; display: none; opacity: 0;" frameborder="0"></iframe>
<div style="position: absolute; z-index: 1000000000; display: none; top: 50%; left: 50%; overflow: auto;" id="ckepop"></div>
<div style="position: absolute; z-index: 1000000000; display: none; overflow: auto;" id="ckepop"></div>
<!--header start--> 
<!--top小目录--> 
<?php echo View::factory('header')->render();?> 
<div class="clearboth"></div>
		<div class="guide">您现在的位置：<a title="网上买彩票" href="/">首页</a> &gt; <a title="七星彩" href="/qxc">七星彩</a>
	</div>

<!--menu和列表_end-->
<!--content1-->
	<div class="width">
		<div id="main">
            
            <div class="box_m">
              <div class="det_t_bg">
                	<!-- <div  class="s-logo sfc-logo"></div> -->
					<div id="lot-logo" class="s-logo qxc-logo"></div>
               	<div class="det_h">
                    	<h2>七星彩 第<?php echo $qihao; ?>期   <?php echo $wtype=1?"复式":"单式";?>
						<?php if($buytype == 0) echo "代购"; elseif($buytype == 1) echo "合买";else echo "追号";?></h2>
                        <p><span class="m_r25">此方案发起时间：<?php echo $ctime;?></span><span class="m_r25">认购截止时间：<?php echo $issue['endtime'];?></span><span>方案编号：<?php echo $basic_id;?></span></p>
                  </div>
                  <a id="hmlist" class="m_link" href="/buycenter/lottnumpub/10/">返回合买列表&gt;&gt;</a>
                </div>
 
                
                <div id="xx1">
                	<div class="det_g_t">方案基本信息</div>
                    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="buy_table">
                      <tbody><tr id="fqrinfo">
                        <td class="td_title2">发起人信息</td>
                        <td class="con_content">
                        	<div class="detail_d">
                                <p>
                                <span id="cnickid" class="m_r50 record"><a href="javascript:return 0;"  onclick="Y.openUrl('/zj/view/<?php echo $uid;?>',525,465)" ><?php echo $uname;?></a>&nbsp;&nbsp;&nbsp;</span>
                                </p>
                                
                            </div>
                        </td>
                      </tr>
                      
          <tr>
                        <td class="td_title2">方案信息</td>
                        <td class="con_content">
                            <div style="width:625px;" class="tdbback" id="fanandiv">
                                <table cellspacing="0" cellpadding="0" border="0" width="100%" class="tablelay eng">
                                  <tbody><tr>
                                    <th>总金额</th>
                                    <th>倍数</th>
                                    <th>份数</th>
                                    <th>每份</th>
                                    <th>彩票标识</th>
                                    <th>保底金额</th>
                                    <th>提成比例</th>
                                    <th class="last_th">购买进度</th>
                                  </tr>
                                  <tr class="last_tr">
                                    <td><span id="tmoney" class="red eng"><?php echo "￥".$allmoney;?></span>元</td>                                                            
                                    <td id="mulity"><?php echo $lotmulti."倍";?></td>
                                    <td id="nums"><?php echo $nums."份";?></td>
                                    <td id="smoney"><?php echo "￥".$onemoney."元";?></td>
                                    <td id="icast"><?php if($cpstat==0)echo "未出票";elseif($cpstat==1)echo "出票中";else echo "已出票"; ?></td>
                                    <td id="pnum"><?php if($baodi!=0) echo "￥".$baodimoney."元(".floor($baodimoney/$allmoney*100)."%)";else echo "未保底";?></td>
                                    <td id="wrate"><?php echo $tcratio.'%';?></td>
                                    <td class="last_td"><span id="jindu" class="red eng"><?php echo $renqi."%";?></span></td>
                                  </tr>
                                </tbody></table>
                             </div>
                        </td>
                      </tr>
                      <tr>
                         <td class="td_title2 p_tb8">方案内容</td>
                      <td style="word-break:break-all; display: block;" class="con_content p_tb8">
                           <?php 
                           $uploadflag = false; //是否可提交方案标识
                           $showfalg = true;
                           //$showtype 0 完全公开
                           //$showtype 1 截止后公开
                           //$showtype 2 只对跟单人公开
                           //$showtype 3 截止后对跟单人公开
                            if($substat==1){ //已提交
                            	if($_user['id']!=$uid){ //发起人
	                            	if($showtype==1){ //截止后公开
	                            		if(time()<strtotime($issue['endtime'])){
	                           				$showfalg = false;
	                           			    echo "方案保密，截止后公开";
	                           			}
	                            	}elseif($showtype==2){//只对跟单人公开
	                            		if(!in_array($_user['id'],$uids)){
	                            			$showfalg = false;
	                           			    echo "方案只对跟单人公开";
	                            		}
	                            	}elseif($showtype==3){
	                            		if(time()<strtotime($issue['endtime'])){
	                            			$showfalg = false;
	                            			echo "方案保密，截止后只对跟单人公开";
	                            		}else{
		                            		if(!in_array($_user['id'],$uids)){
		                            			$showfalg = false;
		                           			    echo "方案保密，截止后只对跟单人公开";
		                            		}
	                            		}
	                            	}
                            	}
                            	
                               if($showfalg){
                           			$codes = checknum::shownums($ext['content'],$lotyid);
                           			if(count($codes)>5){
	                           			echo '<div>'.implode('<br>',array_slice($codes, 0,5)).'&nbsp;<a onclick="showMoreDiv(\'\')" href="javascript:void(0)"><br><span id="more_str">更多</span></a></div>
	                                	<div style="display: none;" id="more_code">'.implode('<br>',array_slice($codes, 5)).'</div>';
                           			}else{
                           				echo '<div>'.implode('<br>',$codes).'</div>';
                           			}
                           		}
                            	
                            }else{//未提交
                            	if($_user){
	                           		if($_user['id']==$uid){
	                           			$uploadflag = true;
	                           		}else{
	                           			echo "方案未上传！";
	                           		}
	                           }else{
	                           		echo "方案未上传！";
	                           }
                            }
                           
                           /*if($substat==1){ //已提交
                           		$showfalg = true;
                           		if($_user['id']!=$uid){
	                           		if($showtype!=0){ //截止后公开
	                           			if(time()<strtotime($issue['endtime'])){
	                           				$showfalg = false;
	                           			    echo "方案保密，截止后公开";
	                           			}
	                           		}
                           		}
                           		if($showfalg){
                           			$codes = checknum::shownums($ext['content'],$lotyid);
                           			if(count($codes)>5){
	                           			echo '<div>'.implode('<br>',array_slice($codes, 0,5)).' &nbsp;<a onclick="showMoreDiv(\'\')" href="javascript:void(0)"><span id="more_str">更多</span></a></div>
	                                	<div style="display: none;" id="more_code">'.implode('<br>',array_slice($codes, 5)).'</div>';
                           			}else{
                           				echo '<div>'.implode('<br>',$codes).'</div>';
                           			}
                           		}
                           }else{ //未提交
	                           if($_user){
	                           		if($_user['id']==$uid){
	                           			$uploadflag = true;
	                           		}else{
	                           			echo "方案未上传！";
	                           		}
	                           }else{
	                           		echo "方案未上传！";
	                           }
                           }*/
                           if($uploadflag){
                           		if(time()<strtotime($issue['dendtime'])){
                           ?>
                            <p id="ccodes">您的投注方案尚未上传，<a style="color:#F00;">立即上传</a></p>
                            <iframe name="uploadari" style="display:none;"></iframe> 
                            <p style="margin-top:10px;">
                            	<form style="float:left;" enctype="multipart/form-data" method="post" action="/lotteryapi/orderprocess/uploadorder/<?php echo $lotyid;?>/<?php echo $id; ?>" id="suc_form" target="uploadari" name="project_form">
                            		<input type="file" id="upfile" class="" name="upfile">
								</form>
                              <a class="qr_btn" style=" color:#FFF" title="" href="javascript:uploadorder()">确认上传</a>  
                              <div class="clearfix"></div>
                            </p>   
                            <?php 
                           		}else{
                           			 echo "方案上传已截止，不可上传！";
                           		}
                           }
                            ?>
                            
                                             
                        </td>
                      </tr>
                      <?php 
                       //过关状态
                       if($ggstat==1){
                      ?>
                        <tr>
                            <td class="td_title2 p_tb8">中奖详情</td>
                            <td class="con_content p_tb8">
                             <p>购买详情：<?php 
                             if(0==$restat){
                             	if(2==$isfull) {
                             		echo '已满员 <span class="gray">(时间：'.$fulltime.')</span>';
                             	}else{ //未满员，但已做过关
                             		echo '方案异常';
                             	}
                             }else{
                             	 echo "方案已撤单".($reinfo?"原因：".$reinfo:"");
                             }
                             ?> <br>
                        								开奖号码：<?php 
                        								if($issue['awardnum']){
                        									echo checknum::formatkjnum($issue['awardnum'],$lotyid);
                        								} ?><br>
							
							<?php 
								if($zjinfo){
									echo "中奖情况：".checknum::formatzjinfo($zjinfo,$lotyid);
									if($afterbonus){
										echo "<br>";
										echo "共计<font color=\"red\">￥".$afterbonus."</font>元（税后）";
									}
									if($combonus){
										echo "，发起人提成<font color=\"red\">￥".$combonus."</font>元";//，每份派奖金额<font color="red">￥26.80</font>元/份。<a id="priz_show" javascript:void(0)="" style="margin-left: 30px;">奖金对照表</a>
									}
								}
							?>    </p>
                            </td>
                        </tr>
                        <?php }else{?>
                              <!-- 若方案未截止，则显示认购 -->
                     <form name="project_form" action="" method="POST">                                     
                      <tr id="wyrg_tr">
                        <td class="td_title2">我要认购</td>
                        <td class="con_content"> 
                        	    <?php 
                        	        $stats = array();
                        	        if($restat==1){
                        	        	$stats['code']='102';
                        	    		$stats['info']='，原因：方案已撤单';
                        	        }else{
	                        	    	if(time()>strtotime($issue['endtime'])){
	                        	    		if($isfull==2){
	                        	    			$stats['code']='100';
	                        	    			$stats['info']='，原因：已满员（时间：'.$fulltime.'）';
	                        	    		}else{
	                        	    			$stats['code']='101';
	                        	    			$stats['info']='，原因：方案认购截止（时间：'.$issue['endtime'].'）';
	                        	    		}
	                        	    	}else{
	                        	    		if($isfull==2){
	                        	    			$stats['code']='100';
	                        	    			$stats['info']='，原因：已满员（时间：'.$fulltime.'）';
	                        	    		}else{
	                        	    			$stats['code']='200';
	                        	    			$stats['info']='';
	                        	    		}
	                        	    	}
                        	        }
                        	    	if($stats['code']!=200){
                        	    ?>                       	    
                        	    	<div id="istate" style="display: block;">该方案已停止认购<?php echo $stats['info']; ?></div> 
                        	    <?php }else{ ?>
                        	     
                        	                       	
                        		<div id="shbd" style="display: none;">
                        			<a href="javascript:void 0">点击此处对该方案保底</a>
                        		</div>
                        		<div id="wyrg" style="display: block;">
	                        		<div class="buy_btn">
	                                    <a title="立即购买" class="btn_buy_m" href="javascript:void 0" id="submitCaseBtn3">立即购买</a>
	                                </div>
	                                
	                                <p id="userMoneyInfo">您尚未登录，请先<a onclick="Yobj.postMsg('msg_login')" title="" href="javascript:void 0">登录</a>！</p>
	                                <p>还可以认购 <span id="lnumstr" class="red eng"><?php echo $nums-$rgnum;?></span> 份，我要认购
	                                <input type="text" onkeydown="if(event.keyCode==13){checkForm();return false;}" onkeyup="this.value=Y.getInt(this.value)" value="1" class="mul" id="buynum" name="buynum">
	                                份 总金额<span class="red eng">￥</span><span id="permoney" class="red eng">1.00</span>元</p>
	                                <p class="read"><span class="hide_sp"><input type="checkbox" value="1" id="agreement" checked="checked"></span>我已阅读并同意《<a id="yhhmxy" href="javascript:void 0">用户合买代购协议</a>》</p>
										<input type="hidden" id="agreement2" value="1">
                        		</div>
                        		<?php }?>
                          </td>
                     </tr>  
                     <?php }?>   
                      </tbody></table></form>
                      
                      <input name="isend" id="isend" type='hidden'  value="<?php if($restat==0) echo $pjstat; else echo 0;?>">
				        <input name="isjprizesuc" id="isjprizesuc" type='hidden'  value="0">
				        <input name="pregetmoney" id="pregetmoney" type='hidden'  value="<?php echo sprintf("%.2f",$afterbonus/$nums); ?>">
				        <input name="anumber" id="anumber" type='hidden'  value="<?php echo $nums;?>">
				        <input name="lotid" id="lotid" type="hidden" value="<?php echo $lotyid?>">
				        <!--彩种Id-->
				        <input name="playid" id="playid" type="hidden" value="<?php echo $wtype; ?>">
				        <!--玩法Id-->

				        <input name="expect" id="expect" type="hidden" value="<?php echo $issue['qihao']?>">
				        <!--期号-->
				        <input name="pid" id="pid" type="hidden" value="<?php echo $id;?>">
				        <!--彩种Id-->
				        <input name="senumber" id="senumber" type="hidden" value="<?php echo $nums-$rgnum;?>">
				        <!--保底份数-->
				        <input name="onemoney" id="onemoney" type="hidden" value="<?php echo $onemoney;?>">
				        <!--每份金额-->
				        <input name="ishm" id="ishm" type='hidden'  value="<?php echo $buytype;?>">

				        <!--是否是合买-->
				        <input name="care_uid" id="main_uid" type="hidden" value="<?php echo $_user['id']; ?>" />
				        <input name="buymumber" id="buymumber" type="hidden" value="1"><!--认购份数-->
				        <input name="reload" id="reload" type="hidden" value="1">
				        <input name="orderstr" id="orderstr" type="hidden" value="1">
				        <input name="orderby" id="orderby" type="hidden" value="desc">
                      
                </div>
                
               <div id="xx2">
                    <div class="det_g_t">方案分享信息</div>
                    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="buy_table">
   						<tbody>
   						<?php 
   						if($_user['id']==$uid){
   						?>
					    <tr>
                          <td class="td_title2 p_tb8">发起人撤单</td>
                          <td class="con_content p_tb8">
                                                          <!--  <a class="btn_dot1" onclick="return main_return_confirm()" href="javascript:void(0)">点击此处对该方案进行撤单</a>-->
                                                        <?php if($renqi>79) echo "该方案认购比例加上保底比例已经超过了允许撤单的极值<font color=\"red\">80%</font>";else echo '<a class="btn_dot1" onclick="return main_return_confirm();" href="javascript:void(0)">点击此处对该方案进行撤单</a>'; ?>
                                                        </td>
                        </tr>
					   <?php } ?>
                              
                      <tr id="faxc_tr">
                        <td class="td_title2">方案宣传</td>
                        <td class="con_content">
                            <div class="detail_d clearfix">
                                  
                               <p id="cname" class="gray">方案标题：<?php echo $title;?></p>
                               <p><font style="display:;word-wrap:break-word;" id="allcontent"><span class="gray">方案描述：<?php echo $description;?></span>
                               	</font></p><div id="cdesc"></div><font style="display:;word-wrap:break-word;" id="allcontent">
                               </font>
                                <p></p>
                             </div>   
                                
                        </td>
                      </tr>
                      <tr class="last_tr">
                        <td class="td_title2">合买用户</td>
                        <td class="con_content">
                        	<?php if(empty($customuser)){ ?>
                            <p style="word-wrap:break-word;width:500px;overflow:hidden;">该方案对竞波所有网友开放。</p>
                            <?php }else{?>
                            <p style="word-wrap:break-word;width:500px;overflow:hidden;">该方案开仅对<?php echo $customuser; ?>开放。</p>
                            <?php }?>
                            <div class="yh_tab">
                                <ul class="clearfix">
                                    <li id="joinCount" class="" onclick="javascript:Showan(1,2);">总参与人数<span id="totalCount"></span>人</li>
									<li id="meyBuy" class="an_cur" onclick="javascript:Showan(2,2);">您的认购记录</li>
                                </ul>
                            </div>
                            <div style="display:;" id="show_list_div"><div style="padding-top: 10px;">暂时没有您的认购信息</div></div>
                        </td>
                      </tr>
                    </tbody></table>
                </div>
            </div>
                
            </div>
           </div>
<!--content1_end-->


<span class="zhangkai"></span>
<!--content2-->

<!--content2_end-->
<!--content3-->

<span class="zhangkai"></span>

<!--content3_end-->
<!--link-->
<!--footer start--> 
<?php echo View::factory('footer')->render();?> 
<!--footer end-->
<textarea id="responseJson" style="display: none;">{
	serverTime :  "<?php echo date("Y-m-d H:i:s");?>",   //服务器时间
	endTime :     "<?php echo $issue['endtime'];?>",   //截止时间
	singlePrice : 2,   									 //单注金额
	baseUrl : "<?php echo url::base();?>"  				 //网站根目录
}</textarea>


<div id="ft">
      <!--底部包含文件-->

      <!--未登录提示层-->
      <?php echo View::factory('login')->render();?>
      <!--默认提示层-->
      <div class="tips_m" style="display:none;" id="defLay">
        <div class="tips_b">
          <div class="tips_box">
            <div class="tips_title">
              <h2>温馨提示</h2>
              <span class="close" id="defTopClose"><a href="javascript:void(0);">关闭</a></span> </div>
            <div class="tips_text" id="defConent" style="padding:18px;text-align:center;"></div>
            <div class="tips_sbt" style="padding:8px;text-align:center;height:auto;">
              <input class="btn_Lblue_m" value="关闭" id="defCloseBtn" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--号码示例层-->
      <div class="tips_m" style="display:none;" id="codeTpl">
        <div class="tips_b">
          <div class="tips_box">
            <div class="tips_title">
              <h2>温馨提示</h2>
              <span class="close" id="codeTplClose"><a href="javascript:void(0);">关闭</a></span> </div>
            <div class="tips_text" id="codeTplConent" style="padding:18px;"></div>
            <div class="tips_sbt" style="padding:8px;text-align:center;height:auto;">
              <input class="btn_Lora_b" value="知道了" id="codeTplYes" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--余额不足内容-->
      <div class="tips_m" style="top: 300px; display: none; position: absolute;" id="addMoneyLay">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2>可用余额不足</h2>
              <span class="close" id="addMoneyClose"><a href="javascript:void%200">关闭</a></span> </div>
            <div class="tips_text">
              <p class="pd_l tc f14" id="addMoneyContent">您的可投注余额不足，请充值<br>
                (点充值跳到"充值"页面，点"返回"可进行修改)</p>
            </div>
            <div class="tips_sbt">
              <input value="返 回" class="btn_Lora_b" id="addMoneyNo" type="button">
              <input value="充 值" class="btn_Dora_b" id="addMoneyYes" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--代购确认-->
      <div class="tips_m" style="display: none; position: absolute;" id="b2_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2 id="b2_dlg_title">确认投注内容</h2>
              <span class="close" id="b2_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="tips_info" id="b2_dlg_content"></div>
            <div class="tips_sbt">
              <input value="取 消" class="btn_Lora_b" id="b2_dlg_no" type="button">
              <input value="确 定" class="btn_Dora_b" id="b2_dlg_yes" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--机选号码列表-->
      <div class="tips_m" style="top:300px;width:300px;display:none;position:absolute" id="jx_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div class="tips_title">
              <h2>机选号码列表</h2>
              <span class="close" id="jx_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="tips_text">
              <ul class="tips_text_list" id="jx_dlg_list">
              </ul>
            </div>
            <div class="tips_sbt">
              <input value="重新机选" class="btn_gray_b m-r" id="jx_dlg_re" type="button">
              <input value="选好了" class="s-ok s-ok-sp" id="jx_dlg_ok" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--查看胆拖明细列表-->
      <div class="tips_m" style="top: 300px; width: 300px; display: none; position: absolute;" id="split_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2>查看投注明细</h2>
              <span class="close" id="split_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="tips_text">
              <ul class="tips_text_list" id="split_dlg_list" style="height:284px;overflow:auto;">
              </ul>
            </div>
            <div class="tips_sbt">
              <input value="关 闭" class="s-ok" id="split_dlg_ok" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--温馨提示-->
      <div style="top: 700px; display: none; width: 500px; position: absolute;" class="tips_m" id="info_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2>温馨提示</h2>
              <span class="close" id="info_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="alert_c">
              <div class="state error">
                <div class="stateInfo f14 p_t10" id="info_dlg_content"></div>
              </div>
            </div>
            <div class="tips_sbt">
              <input class="btn_Dora_b" value="确 定" id="info_dlg_ok" type="button">
            </div>
          </div>
        </div>
      </div>
      <!-- 确认投注内容 -->
      <div class="tips_m" style="width: 700px; display: none; position: absolute;" id="ishm_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2 id="ishm_dlg_title">方案合买</h2>
              <span class="close"><a href="javascript:void%200" id="ishm_dlg_close">关闭</a></span> </div>
            <div class="tips_info tips_info_np" id="ishm_dlg_content"></div>
            <div class="tips_sbt">
              <input value="确认投注" class="btn_Dora_b" id="ishm_dlg_yes" type="button">
              <a href="javascript:void(0);" class="btn_modifyFont" title="返回修改" id="ishm_dlg_no">返回修改&gt;&gt;</a> </div>
          </div>
        </div>
      </div>
      <!--提示确认-->
      <div class="tips_m" style="display: none; position: absolute;" id="confirm_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2 id="confirm_dlg_title">温馨提示</h2>
              <span class="close" id="confirm_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="tips_info" id="confirm_dlg_content"></div>
            <div class="tips_sbt">
              <input value="取 消" class="btn_Lora_b" id="confirm_dlg_no" type="button">
              <input value="确 定" class="btn_Dora_b" id="confirm_dlg_yes" type="button">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--弹窗内容文件-->
  </div>
</div>
<div style="position: absolute; display: none; z-index: 9999;" id="livemargins_control"><img src="images/monitor-background-horizontal.png" style="position: absolute; left: -77px; top: -5px;" height="5" width="77"> <img src="images/monitor-background-vertical.png" style="position: absolute; left: 0pt; top: -5px;"> <img id="monitor-play-button" src="images/monitor-play-button.png" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5" style="position: absolute; left: 1px; top: 0pt; opacity: 0.5; cursor: pointer;"></div>
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
      <div class="tips_info" id="yclass_confirm_content" style="zoom:1"></div>
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

<div id="bgdiv"></div>

<!-- 用户协议 -->
		<div
			style="width: 500px; position: absolute; display: none; z-index: 8000000"
			id="xydiv">
			<div class="tips_b">
				<div class="tips_box">
					<div class="tips_title move">
						<h2>
							大乐透用户协议
						</h2>
						<span class="close"><a onclick="return false" id="closeXy1"
							href="javascript(void 0)">关闭</a>
						</span>
					</div>

					<div style="height: 300px; overflow-y: auto" class="tips_text">
						<ul id="msg_content" class="tips_info_list">
							<span lang="EN-US"><span lang="EN-US"
								style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
									style="mso-list: Ignore"><font face="Calibri"><span
											lang="EN-US"
											style="FONT-SIZE: 10pt; FONT-FAMILY: 宋体; mso-bidi-font-family: 宋体; mso-font-kerning: 0pt">
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">1、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">本网站立足于服务彩民，所有用户发起、认购彩票方案，网站均不收取任何手续费。</span>
													<span lang="EN-US"> </span>
												</p>
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">2、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">网站用户须同意本网站代理购买、保管彩票、领取奖金和派发奖金的有关事宜。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">3、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">发起人可自行设置税后奖金盈利部分</span><span
														lang="EN-US"><font face="Calibri">0%-8%</font>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">做为方案提成，网站保留提成比例调整的权利。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>

												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">4、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">用户有权自由发起方案，合买代购方案不限制。</span>
												</p>
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">5、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">为保证方案发起的严肃性，方案最低发起金额为</span><span
														lang="EN-US"><font face="Calibri">2</font>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">元，合买方案发起人须先购买至少</span><span
														lang="EN-US"><font face="Calibri">5%</font>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">6、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">为确保方案正常出票，</span><span
														lang="EN-US"><font face="Calibri">19:00</font>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">以后单式方案单倍金额上限为</span><span
														lang="EN-US"><font face="Calibri">20,000</font>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">元。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>

												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">7、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">方案进度（含保底）超过</span><span
														lang="EN-US"><font face="Calibri">80%</font>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">的发起人、认购人均不能撤单。当期彩票截止后，未合买成功方案系统将进行撤单返款处理。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">8、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">奖金分配：代购方案所中取的奖金，均属于此方案发起人所有。合买方案中奖后，发起人按照事先约定的方式、比例进行提成，其余奖金按照此方案各用户认购比例进行分配，除不尽的部分归方案发起人所有。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">9、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">&nbsp;
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">彩票开奖后，网站将代为办理兑奖、派奖事宜，并在一个工作日内把税后奖金添入中奖用户之预付款帐户。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>
												<p
													style="MARGIN: 0cm 0cm 0pt 21pt; TEXT-INDENT: -21pt; tab-stops: list 18.0pt; mso-list: l0 level1 lfo1; mso-char-indent-count: 0"
													class="MsoListParagraph">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; mso-bidi-font-family: Calibri; mso-bidi-font-size: 11.0pt; mso-fareast-font-family: Calibri; mso-fareast-theme-font: minor-latin; mso-bidi-theme-font: minor-latin"><span
														style="mso-list: Ignore"><font face="Calibri">10、</font><span
															style="FONT: 7pt Times New Roman"><font size="2">
															</font>
														</span>
													</span>
													</span><span
														style="FONT-FAMILY: 宋体; mso-fareast-font-family: 宋体; mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-fareast-theme-font: minor-fareast; mso-ascii-theme-font: minor-latin; mso-hansi-theme-font: minor-latin">如因彩票中心网络异常、赛事提前截止、停电、网站网络中断、出票服务器维护等特殊原因，网站有随时调整截止时间的权利。如因上述意外因素导致本站未能够出票完毕，本站将在开奖前对未出票方案做撤单返款处理，并发公告通知网友。除此之外，本站不再承担其他责任。</span><span
														lang="EN-US"><o:p></o:p>
													</span>
												</p>

												<p align="left"
													style="MARGIN-LEFT: 21pt; TEXT-INDENT: -21pt; TEXT-ALIGN: left"
													class="MsoNormal">
													<span><span><span lang="EN-US"
															style="FONT-FAMILY: 宋体"><font size="2"><span>13、本网站保留变更本协议条款的权利。<br>
																			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																</span><span>&nbsp;&nbsp;&nbsp;</span>
															</font><span><font size="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
															</span>
														</span>
													</span>
													</span>
												</p>
												<p align="right"
													style="MARGIN: 13pt 0cm; mso-margin-top-alt: auto; mso-margin-bottom-alt: auto; mso-pagination: widow-orphan"
													class="MsoNormal">
													<span lang="EN-US"
														style="FONT-SIZE: 10pt; FONT-FAMILY: 宋体; mso-bidi-font-family: 宋体; mso-font-kerning: 0pt"><a
														target="_blank" href="http://www.jingbo365.com/"><span
															style="COLOR: blue; mso-bidi-font-size: 11.0pt">www.jingbo365.com</span>
													</a>
													<br>
													</span><span
														style="FONT-SIZE: 10pt; FONT-FAMILY: 宋体; mso-bidi-font-family: 宋体; mso-font-kerning: 0pt">客服热线：<span
														lang="EN-US">400-820-2324<br>
													</span>
													</span><span lang="EN-US"
														style="FONT-SIZE: 12pt; FONT-FAMILY: 宋体; mso-bidi-font-family: 宋体; mso-font-kerning: 0pt">
													</span>
												</p>
										</span>
									</font>
								</span>
							</span>
							</span>
							<font face="Calibri"> </font>
						</ul>
						<font face="Calibri"> </font>
					</div>
					<font face="Calibri">
						<div class="tips_sbt">
							<input type="button" onclick="return false" id="closeXy2"
								value="关 闭" class="btn_Lora_b">
						</div> </font>
				</div>
				<font face="Calibri"> </font>
			</div>
		</div>
		<!-- 用户协议结束 -->

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
