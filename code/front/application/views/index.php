<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-首页-竞彩-足彩-篮彩-足球-彩票合买</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<meta property="wb:webmaster" content="83c6eb294fea2678" />
<?php
echo html::script(array
(
	'media/js/yclass.js',
	'media/js/loginer',
 	'media/js/jquery',
	'media/js/txt_scroll',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
	'media/css/zc',
	'media/css/mask',
	'media/css/css1',
), FALSE);
?>
<style>
#ic7_cr_con ul.ic_cr_con {
    font: 12px/22px "宋体";
    height: 111px;
    overflow: hidden;
}
</style>
<script type="text/javascript">
function dingzhi(fuid,lotyid,playid){		
		Y.postMsg('msg_login', function (){
			var url = "<?php echo url::base();?>user_auto_order/getuidfuid/";
			Y.ajax(
			{
				url: url,
				type:'GET',
				end:function(data)
				{
					var json = Y.dejson(data.text);			
					if(json.uid!=fuid){
						Y.openUrl("<?php echo url::base();?>user_auto_order/add/"+lotyid+"/"+playid+"/"+fuid,475,330)
					}					
				}
			});
		})
}
</script>
<?php if(!empty($_SESSION['logout']))echo $_SESSION['logout'];?>
</head>
<body>
<!--top小目录-->
<?php 
echo View::factory('header')->render();
?>
<!--menu和列表_end-->
<!--content1-->
<div class="width">
  <div class="fl i_left pt5">
    <h3 class="font14 blue i_ggtit"><a href="/news/news_list/1">网站公告</a></h3>
    <div class="i_gg_list fl">
		<?php 
		if(!empty($news_gg)):	
		foreach($news_gg as $v):
		?>
      <dl>
        <dt class="graybc"><?php echo $v['created']?></dt>
        <dd class="blue" style="height:15px;width:170px;overflow:hidden;"><a href="/news/news_detaile/<?php echo $v['id']?>" title="<?=$v['title']?>"><?php echo $v['title'];//echo tool::cut_str($v['title'],15);?></a></dd>
      </dl>
	  <?php endforeach;
	  endif;
	  ?>
    </div>
  </div>
  <div class="fl i_center pt5">
     <div id=idContainer2 class=container>
    <table id=idSlider2 border=0 cellSpacing=0 cellPadding=0>
      <tbody>
      <tr>
        <td class=td_f>
<?php
echo Site_Service::get_instance()->echo_adflash(); 
?>
</td>
<?php /**?>
        <a href="<?php echo url::base();?>user/register"><img src="<?php echo url::base();?>media/images/ban1.jpg" width="520" height="210" /></a></TD>
        <TD class=td_f><a href="<?php echo url::base();?>user/register"><img src="<?php echo url::base();?>media/images/ban2.jpg" width="520" height="210" /></a></TD>
        <TD class=td_f><a href="<?php echo url::base();?>user/register"><img src="<?php echo url::base();?>media/images/ban3.jpg" width="520" height="210" /></a></TD>
        <TD class=td_f><a href="<?php echo url::base();?>user/register"><img src="<?php echo url::base();?>media/images/ban4.jpg" width="520" height="210" /></a></TD>
<?php **/?>

       </tr></tbody></table>
    <ul id="idNum" class="num"></ul>
    </div>

  </div>
  <div class="fl i_right pt5">
  
<?php 
if(!empty($_user)) { 
?>
<div id="i_login" class="fl">
<ul>
<li>您好<span  class="cf60"> <?php echo $_user['lastname'];?></span>，欢迎您！</li>
<li>您的当前余额：<span  class="cf60 fbold"><?php echo $_user['user_money'];?></span>元</li>
<li style="padding-top:10px;">
<div class=" fl white"><span><a href="<?php echo url::base();?>user" ><input type="submit"  value="进入会员中心" id="log_index" class="orange_btn  fl white" style="width:100px;" onclick="javascript:window.location='<?php echo url::base();?>user';"/></a></span></div>
<span class="fl blue pl10"><a href="<?php echo url::base();?>user/logout">退出登录</a></span></li>
</ul>
</div>
<?php
}
else { 
?>
<form id="login_index" onsubmit="return false;" action="<?php echo url::base();?>user/login" method="post">
<div id="i_login" class="fl">
<ul>
<li><span class="fl">用户名</span>
<input name="username" type="text" class="i_login_text fl" id="username" maxlength="20" />
</li>
<li><span class="fl ">密　码</span>
<input name="password" type="password" class="i_login_text fl" id="password" maxlength="20" />
</li>
<li><span class="fl ">验证码</span>
<input name="secode" id="secode"  type="text"  class="i_login_yzm fl" maxlength="4" />
<span class="fl">
<img alt="点击更换图片" onclick="reload_secoder('login_secoder1');"  style="cursor: pointer;" src="<?php echo url::base();?>site/secoder?id=login_secoder" id='login_secoder1' />
<script language="javascript">
var flag = 0;
function reload_secoder(id,url){
    flag++;
    $('#'+id).attr("src","<?php echo url::base();?>site/secoder?id="+id+"&flag="+flag);
}
</script>
</span></li>
<li style="padding-left:45px;">
<div class=" fl white"><span><a href="javascript:void(0);"  ><input type="submit"  value="用户登录" id="log_index" class="orange_btn  fl white" style="width:100px;"/></a></span></div>
<span class="fl blue pl10"><a href="<?php echo url::base();?>user/getpassword">忘记密码</a></span></li>
</ul>
</div>
<?php
} 
?>
    </form>
    <p class="pt5 fl"><span class="fl"><a href="<?php echo url::base();?>user/register"><img src="<?php echo url::base();?>media/images/btn.gif" width="123" height="38" /></a></span><span class="fl"><a href="<?php echo url::base();?>/doc/help_detail/51"><img src="<?php echo url::base();?>media/images/btn2.gif" width="126" height="38" /></a></span></p>
  </div>
</div>
<!--content1_end-->
<span class="zhangkai"></span>
<!--content2-->
<div class="width">
	<div class="fl i_left pt5">
   	  <h3 class="font14 blue zjxx">最新中奖信息</h3>
        <div class="zjxx_box fl">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="19%" height="25" align="center" valign="middle" bgcolor="#fbf3e3" class="blue">排名</td>
              <td width="51%" height="25" align="left" valign="middle" bgcolor="#fbf3e3" class="blue">用户名</td>
              <td width="30%" height="25" align="center" valign="middle" bgcolor="#fbf3e3" class="blue">中奖金额</td>
            </tr>
            <tr>
              <td height="5" colspan="3" ></td>
            </tr>
             
          </table>
            <div id="ic7_cr_con">
            <ul class="ic_cr_con">
            <?php
			$i = 0;
            foreach($plans_win['wins'] as $rowwin)
			{
			$i++;
			?>
			<li>
			<span <?php 
			  if($i <=3)
			  {
				  echo 'class="paim white"'; 
			  }
			  else
			  {
				  echo 'class="paim2 gray6"';
			  }
			  ?>  style="float:left;margin:3px 10px;display:inline;"><?php echo $i;?></span>
			  <?php
			  $link = '#';
			  switch ($rowwin['ticket_type']) {
			  	case 1: $link = '/jczq/viewdetail/'.$rowwin['order_num'];break;
			  	case 2: $link = '/zcsf/viewdetail/'.$rowwin['order_num'];break;
			  	case 6: $link = '/jclq/viewdetail/'.$rowwin['order_num'];break;
			  	case 7: $link = '/bjdc/viewdetail/'.$rowwin['order_num'];break;
			  	default: break;
			  } 
			  ?>
			  <a href="<?php echo $link; ?>" target="_blank" class="fl" style="width:116px;color:#3479D7;text-decoration:none;"><?php echo $plans_win['users'][$rowwin['user_id']]['lastname'];?></a>
			<font color="red"><?php echo round($rowwin['bonus'], 0);?></font>
			</li>
			<?php
			}
			?>
            </ul>
            </div>
            <script type="text/javascript">var _wra = $('ul.ic_cr_con');txt_sroll(_wra,1500,1000);</script>
 
           
        </div>
        <div class="fl pt5">
            <h3 class="font14 blue zjxx">开奖信息</h3>
            <div class="i_kjxx fl zjxx_box">
            <?php if(!empty($kaijiang)):
				foreach($kaijiang as $list):?>
            
            	<p class="i_kjxx_title fl"><span class="fr red"><a href="/news/news_detaile/<?php echo $list['id'];?>">详情</a></span><span class="fl i_kjxx_tit2 blue"><strong><?php echo $list['type'];?></strong></span><span class="fl pl10 black"><?php echo $list['issue'];?></span></p>
                <div class="i_kjxx_text fl" style="padding-top:20px;">
                	<p class="font14 red bold"><?php echo $list['number'];?></p>
                    <?php if(!empty($list['summary'])){?><p class="black"><?php echo $list['summary']?></p><?php }else{?>
					<p class="black"><br /></p>
					<?php }?>
                </div>
                <p class="i_kjxx_time fl" style="padding-bottom:13px;"><?php echo $list['created'];?></p>
            
            <?php endforeach;
				endif;?>
                </div>
        </div>
  </div>
  	<div class="fl i_c2_right pt5">
    	<div class="fl i_center">
        	<div class="i_focus fl">
			<?php 
			if(!empty($index_tj)):	
				foreach($index_tj as $k=>$v):
			?>
         	 <dl <?php if($k==2){echo 'style="border-bottom:0;"';}?>>
			 	<?php
				 if(!empty($v)):		
				 foreach($v as $i=> $vs):
				 	if($i==0){
				 ?>
                	<dt class="red"><a href="/news/news_detaile/<?php echo $vs['id']?>" title="<?=$vs['title']?>"><?php echo tool::cut_str($vs['title'],20);?></a></dt>
					<?php }else{?>
                    <dd class="font14">[<a href="/news/news_detaile/<?php echo $vs['id']?>" title="<?=$vs['title']?>"><?php echo tool::cut_str($vs['title'],16);?></a>]</dd>
				<?php 
					}
				 	endforeach;
				endif;?>
            </dl>
			<?php endforeach;
			endif;?>
            </div>
            <div class="fl lottery_new pt5">
            	<span class="fl"><img src="<?php echo url::base();?>media/images/img2.gif" width="10" height="30" /></span>
                <div class="fl lottery_tit blue">
                	<span class="fl lottery_left_tit font14">彩票新闻</span>
                	<ul id="news_caipiao">
                    	<li class="shou"><a href="/news/news_list/10">传统足球</a></li>
                    	<li class="shou"><a href="/news/news_list/9">竞彩篮球</a></li>
                        <li class="shou"><a href="/news/news_list/8">竞彩足球</a></li>
                        <li class="shou"><a href="/news/news_list/7">北单</a></li>
                    </ul>
                </div>
                <span class="fl"><img src="<?php echo url::base();?>media/images/img3.gif" width="10" height="30" /></span>
            </div>
            <div class="lottery_box fl">
            	<div class="fl lottery_box_l">
            	<?php
            	if ($zxtj[0]['newpic'] == '') {
					$zxtj_img_url = 'media/images/_img4.jpg';
				} 
				else {
					$zxtj_img_url = str_replace("/att","attach",$zxtj[0]['newpic']);
				}
            	?>
            		<p><a target="_blank" href="/news/news_detaile/<?php echo $zxtj[0]['id']?>" title="<?=$zxtj[0]['title']?>"><img src="<?php echo url::base().$zxtj_img_url;?>" width="90" height="73" title="<?=$zxtj[0]['title']?>" /></a></p>
                    <p class="red bold font14" style="height:40px; overflow:hidden;"><a target="_blank" href="/news/news_detaile/<?php echo $zxtj[0]['id']?>" title="<?=$zxtj[0]['title']?>"><?php echo $zxtj[0]['title']?></a></p>
           	   </div>
                <div class="lottery_box_r fl">
				<?php foreach($news_classid as $v):?>
				 <ul style="display:none">
					<?php
					 if(!empty($news_caipiao[$v])):		
					 foreach($news_caipiao[$v] as $i=> $vs):
					 ?>
						<li><span class="fr red"><?php echo date( 'm-d ',strtotime($vs['created']));?></span><a href="/news/news_detaile/<?php echo $vs['id']?>" title="<?=$vs['title']?>"><?php echo tool::cut_str($vs['title'],25);?></a></li>
					<?php 
						endforeach;
					endif;?>
				</ul>
				<?php endforeach;
				?>
                </div>
            </div>
        </div>
<script language="javascript">
$(document).ready(function() {   
    
	 $("#log_index").click(function(){					   
	 	 if ($("#username").val() == '')
		 {
			alert('请输入用户名!');
			$("#username").focus();
			return false;
		 }
	 	 if ($("#password").val() == '')
		 {
			alert('请输入密码!');
			$("#password").focus();
			return false;
		 }
	 	 if ($("#secode").val() == '')
		 {
			alert('请输入验证码!');
			$("#secode").focus();
			return false;
		 }			 
		 
		 $("#login_index").submit();
	 })
	 $(".lottery_box_r ul:last").css({'display':'block'});
	 $("#news_caipiao li").hover(function(){
	 	$("#news_caipiao li").removeClass();
	 	$(this).addClass('hover');
		id=$("#news_caipiao li").index(this);
	 	$('.lottery_box_r ul').css({'display':'none'});
	 	$('.lottery_box_r ul').eq(id).css({'display':'block'});
	 })
});

</script>
        <div class="fl i_right">
        	<h3 class="orange i_tuijian"><a href="/news/zxtj">最新动态</a></h3>
            <div class="i_tuij_box fl blue">
            	<ul>
              <?php 
				if(!empty($zxtj)):	
				foreach($zxtj as $v):
				?>
			 	 <li><a href="/news/news_detaile/<?php echo $v['id']?>" title="<?=$v['title']?>"><?php echo tool::cut_str($v['title'],16);?></a></li>
			  <?php endforeach;
			  endif;
			  ?>
              </ul>
            </div>
            <h3 class="orange i_tuijian mt5"><a href="/recommend">专家推荐</a></h3>
            <div class="i_tuij_box fl blue">
            	<ul>
                	<?php 
				if(!empty($news_zj)):	
				foreach($news_zj as $v):
				?>
			 	 <li><a href="/news/news_detaile/<?php echo $v['id']?>" title="<?=$v['title']?>"><?php echo tool::cut_str($v['title'],16);?></a></li>
				  <?php endforeach;
				  endif;
				  ?>
              </ul>
            </div>
            <h3 class="orange i_tuijian mt5"><a href="/news/news_list/3">玩法推荐</a></h3>
            <div class="i_tuij_box fl blue">
            	<ul>
                <?php 
				if(!empty($news_wj)):	
				foreach($news_wj as $v):
				?>
			 	 <li><a href="/news/news_detaile/<?php echo $v['id']?>" title="<?=$v['title']?>"><?php echo tool::cut_str($v['title'],16);?></a></li>
				  <?php endforeach;
				  endif;
				  ?>
              </ul>
            </div>
        </div>
        <div class="i_c2_right fl pt5"><img src="<?php echo url::base();?>media/images/_img51.jpg" width="774" height="111" /></div>
  </div>
</div>
<!--content2_end-->
<!--content3-->

<span class="zhangkai"></span>
<div class="width">
	<div class="i_left fl pt5">
  <div class="i_buytitle fl font14">
        	<ul class="orange bold">
            	<li class="hover"><a href="<?php echo url::base();?>doc/help">购彩流程</a></li>
                <li><a href="<?php echo url::base();?>doc/help">购彩帮助</a></li>
            </ul>
        </div>
        <div class="i_buy_box fl tc"><a href="<?php echo url::base();?>doc/help"><img src="<?php echo url::base();?>media/images/buy.gif" width="174" height="162" /></a></div>
    </div>
    
<script> 
function setTab(name,cursel,n){
	for(i=1;i<=n;i++){
	  var menu=document.getElementById(name+i);
	  var con=document.getElementById("con_"+name+"_"+i);
	  con.style.display=i==cursel?"block":"none";
	  menu.className=i==cursel?"hover":"";
	}
}
</script>
    
    <div class="fl i_c2_right pt5">
    	<div class="i_c2_right fl">
        	<span class="fl"><img src="<?php echo url::base();?>media/images/img2.gif" width="10" height="30" /></span>
                <div class="fl lottery_tit blue" style="width:725px;">
                	<span class="fl lottery_left_tit font14">推荐合买</span>
                	<ul>
                    	<li id="one1" onMouseOver="setTab('one',1,3)"><a target="_blank" href="/buycenter/sfc_14c">传统足球</a></li>
                    	<li id="one3" onMouseOver="setTab('one',3,3)"><a target="_blank" href="/buycenter/jclq">竞彩篮球</a></li>
                        <li id="one2" onMouseOver="setTab('one',2,3)" class="hover" ><a target="_blank" href="/buycenter/jczq">竞彩足球</a></li>
                    </ul>
                </div>
                <span class="fl"><img src="<?php echo url::base();?>media/images/img3.gif" width="10" height="30" /></span>
        </div>
        <div class="i_tuijian_box fl">

<div id="con_one_1" style="display:none;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0"  class="blue">
            <tr>
              <td width="20%" height="29" align="center" valign="middle" bgcolor="#e4edf8">发起人</td>
              <td width="12%" height="29" align="center" valign="middle" bgcolor="#e4edf8">期次</td>
              <td width="18%" height="29" align="center" valign="middle" bgcolor="#e4edf8">方案金额</td>
              <td width="20%" height="29" align="center" valign="middle" bgcolor="#e4edf8">每份金额</td>
              <td width="18%" height="29" align="center" valign="middle" bgcolor="#e4edf8">进度</td>
              <td width="12%" height="29" align="center" valign="middle" bgcolor="#e4edf8">详情</td>
            </tr>
            <tr>
              <td height="1" colspan="7" bgcolor="#ffffff"></td>
            </tr>
            <tr>
              <td height="1" colspan="7" bgcolor="#e4e4e4"></td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="i_tuij_table">
                   
		   <?php foreach($Plans_sfc_data_list as $key=>$value){ 
               $user = user::get($value['user_id']); 
			   
				if($value['progress']==100){
					$baodi_text=$value['progress']."%";   
				}else{
				   if ($value['is_baodi']=="1"){
					   $baodi_text=$value['progress']."%+".intval(number_format($value['end_price']/$value['copies']*100,2))."%(<span class='red'>保</span>)";
				   }else{
						$baodi_text=$value['progress']."%";   
				   }
				}
			   if ($value['buyed']==0){
				   $baodi_text="<span class='red'>满员</span>";
			   }			   
			   $zdgd = "<span style='float:left;margin-left:20px;width:70px;overflow:hidden;'><a href='javascript:;' onclick='Y.openUrl(\"/zj/view/".$value['user_id']."\",525,466)'>".$user['lastname']."</a></span><a style='float:right;*float:right;margin-right:10px;color:#db8a19' href='javascript:return 0;' onclick='dingzhi(".$value['user_id'].",2,".$value['play_method'].");'>定制跟单</a>";
           ?>
            <tr>
              <td width="20%" height="30" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $zdgd;?></td>
              <td width="12%" height="30" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $value['expect'];?></td>
              <td width="18%" height="30" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $value['price'];?></td>
              <td width="20%" height="30" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $value['price_one'];?>元</td>
              <td width="18%" height="30" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $baodi_text;?></td>
            <?php /*  <td width="14%" height="30" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo '<input type="text" name="rgfs" class="i_tuij_text fl" vid="'.$value['basic_id'].'" vlotid="2" vplayid="'.$value['play_method'].'" vonemoney="2" vsnumber="'.$value['buyed'].'" value="1" vexpect="'.$value['expect'].'" onkeyup="if(this.value<=0)this.value=1;if(this.value>'.$value['buyed'].')this.value='.$value['buyed'].'"/>';?><div class="orange_btn fl white"><span><a href="#">参与</a></span></div></td>  */?>
              <td width="12%" height="30" align="center" valign="middle" bgcolor="#f2f2f2" class="blue"><a href="/zcsf/viewdetail/<?php echo $value['basic_id'];?>" target="_blank">方案详情</a></td>
            </tr>	 
	 <?php }?>         

          </table>
</div>


<div id="con_one_2">          
          <table width="100%" border="0" cellspacing="0" cellpadding="0"  class="blue">
            <tr>
              <td width="20%" height="29" align="center" valign="middle" bgcolor="#e4edf8">发起人</td>
              <td width="22%" height="29" align="center" valign="middle" bgcolor="#e4edf8">过关方式</td>
              <td width="18%" height="29" align="center" valign="middle" bgcolor="#e4edf8">方案总金额</td>
              <td width="10%" height="29" align="center" valign="middle" bgcolor="#e4edf8">每份金额</td>
              <td width="18%" height="29" align="center" valign="middle" bgcolor="#e4edf8">进度</td>
              <td width="12%" height="29" align="center" valign="middle" bgcolor="#e4edf8">详情</td>
            </tr>
            <tr>
              <td height="1" colspan="7" bgcolor="#ffffff"></td>
            </tr>
            <tr>
              <td height="1" colspan="7" bgcolor="#e4e4e4"></td>
            </tr>
          </table>          
           <table width="100%" border="0" cellspacing="0" cellpadding="0" class="i_tuij_table">
                   
		   <?php foreach($Plans_jczq_data_list as $key=>$value){ 
               $user = user::get($value['user_id']); 
			   
				if($value['progress']==100){
					$baodi_text=$value['progress']."%";   
				}else{
				   if ($value['baodinum']>"0"){
					   $baodi_text=$value['progress']."%+".intval(number_format($value['baodinum']/$value['zhushu']*100,2))."%(<span class='red'>保</span>)";
				   }else{
						$baodi_text=$value['progress']."%";   
				   }
				}
			   if ($value['buyed']==0){
				   $baodi_text="<span class='red'>满员</span>";
			   }		
				$zdgd = "<span style='float:left;margin-left:20px;width:70px;overflow:hidden;'><a href='javascript:;' onclick='Y.openUrl(\"/zj/view/".$value['user_id']."\",525,466)'>".$user['lastname']."</a></span><a style='float:right;*float:right;margin-right:10px;color:#db8a19' href='javascript:return 0;' onclick='dingzhi(".$value['user_id'].",1,".$value['play_method'].");'>定制跟单</a>";
			   //$zdgd = "<span style='float:left;margin-left:20px;width:70px;overflow:hidden;'>".$user['lastname']."</span><a style='float:right;*float:right;margin-right:10px;color:#db8a19' href='javascript:return 0;' onclick='dingzhi(".$value['user_id'].",1,".$value['play_method'].");'>定制跟单</a>";
			   //$zdgd = $user['lastname'];
           ?>
            <tr>
              <td width="20%" height="30" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $zdgd;?></td>
              <td width="22%" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $value['typename'];?></td>
              <td width="18%" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $value['total_price'];?></td>
              <td width="10%" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $value['price_one'];?>元</td>
              <td width="18%" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $baodi_text;?></td>
            <?php /*  <td width="14%" height="30" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo '<input type="text" name="rgfs" class="i_tuij_text fl" vid="'.$value['basic_id'].'" vlotid="2" vplayid="'.$value['play_method'].'" vonemoney="2" vsnumber="'.$value['buyed'].'" value="1" vexpect="'.$value['expect'].'" onkeyup="if(this.value<=0)this.value=1;if(this.value>'.$value['buyed'].')this.value='.$value['buyed'].'"/>';?><div class="orange_btn fl white"><span><a href="#">参与</a></span></div></td>  */?>
              <td width="12%" align="center" valign="middle" bgcolor="#f2f2f2" class="blue"><a href="/jczq/viewdetail/<?php echo $value['basic_id'];?>" target="_blank">方案详情</a></td>
            </tr>
	 <?php }?>         

          </table>         
</div>   

<div id="con_one_3" style="display:none;">          
          <table width="100%" border="0" cellspacing="0" cellpadding="0"  class="blue">
            <tr>
              <td width="20%" height="29" align="center" valign="middle" bgcolor="#e4edf8">发起人</td>
              <td width="22%" height="29" align="center" valign="middle" bgcolor="#e4edf8">过关方式</td>
              <td width="18%" height="29" align="center" valign="middle" bgcolor="#e4edf8">方案总金额</td>
              <td width="10%" height="29" align="center" valign="middle" bgcolor="#e4edf8">每份金额</td>
              <td width="18%" height="29" align="center" valign="middle" bgcolor="#e4edf8">进度</td>
              <td width="12%" height="29" align="center" valign="middle" bgcolor="#e4edf8">详情</td>
            </tr>
            <tr>
              <td height="1" colspan="7" bgcolor="#ffffff"></td>
            </tr>
            <tr>
              <td height="1" colspan="7" bgcolor="#e4e4e4"></td>
            </tr>
          </table>          
           <table width="100%" border="0" cellspacing="0" cellpadding="0" class="i_tuij_table">
                   
		   <?php foreach($Plans_jclq_data_list as $key=>$value){ 
               $user = user::get($value['user_id']); 
			   
				if($value['progress']==100){
					$baodi_text=$value['progress']."%";   
				}else{
				   if ($value['baodinum']>"0"){
					   $baodi_text=$value['progress']."%+".intval(number_format($value['baodinum']/$value['zhushu']*100,2))."%(<span class='red'>保</span>)";
				   }else{
						$baodi_text=$value['progress']."%";   
				   }
				}
			   if ($value['buyed']==0){
				   $baodi_text="<span class='red'>满员</span>";
			   }			
			   $zdgd = "<span style='float:left;margin-left:20px;width:70px;overflow:hidden;'><a href='javascript:;' onclick='Y.openUrl(\"/zj/view/".$value['user_id']."\",525,466)'>".$user['lastname']."</a></span><a style='float:right;*float:right;margin-right:10px;color:#db8a19' href='javascript:return 0;' onclick='dingzhi(".$value['user_id'].",6,".$value['play_method'].");'>定制跟单</a>";
           ?>
            <tr>
              <td width="20%" height="30" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $zdgd;?></td>
              <td width="22%" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $value['typename'];?></td>
              <td width="18%" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $value['total_price'];?></td>
              <td width="10%" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $value['price_one'];?>元</td>
              <td width="18%" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo $baodi_text;?></td>
            <?php /*  <td width="14%" height="30" align="center" valign="middle" bgcolor="#f2f2f2"><?php echo '<input type="text" name="rgfs" class="i_tuij_text fl" vid="'.$value['basic_id'].'" vlotid="2" vplayid="'.$value['play_method'].'" vonemoney="2" vsnumber="'.$value['buyed'].'" value="1" vexpect="'.$value['expect'].'" onkeyup="if(this.value<=0)this.value=1;if(this.value>'.$value['buyed'].')this.value='.$value['buyed'].'"/>';?><div class="orange_btn fl white"><span><a href="#">参与</a></span></div></td>  */?>
              <td width="12%" align="center" valign="middle" bgcolor="#f2f2f2" class="blue"><a href="/jclq/viewdetail/<?php echo $value['basic_id'];?>" target="_blank">方案详情</a></td>
            </tr>
	 <?php }?>         

          </table>         
</div>       
        </div>
    </div>
</div>
<!--content3_end-->
<?php
echo Site_Service::get_instance()->echo_friend_links($site_link); 
?>
<!--copyright-->
<span class="zhangkai"></span>
<div id="ft">
<?php 
//echo View::factory('login')->render();
?>
      <!--底部包含文件-->
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
<?php  
echo View::factory('footer')->render();
?>
</body>
</html>