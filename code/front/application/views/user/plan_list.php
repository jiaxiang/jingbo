<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-今日投注</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/jquery',
    'media/js/hdm',
	'media/js/My97DatePicker/WdatePicker',	
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
), FALSE);
?>
<?php echo $ucsynlogin;?>
</head>
<body>
<!--top小目录-->
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>user"><font class="blue">会员中心</font></a>
		<?php 
		if($_nav=="betting"){
		?>
		 &gt; 投注记录
		<?php
		} 
		elseif($_nav=="today_bets") {
		?>
		 &gt; 今日投注
		<?php
		} 
		?>
	</div>
	<div style="float:right; margin-right:20px;">
		<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
	</div>
	<div style="clear:both;"></div>
</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">
<?php echo View::factory('user/left')->render();?>    
<div class="member_right fl">
<?php 
if($_nav == "index") {
	echo View::factory('user/user_header')->render();
?>         
<div id="member_tit" class="fl mt5">
	<span class="fr blue"><a href="/user/betting">更多记录</a>&gt;&gt;</span>
		<ul>
   			<li <?php if ($get_data['type']=="notend") {?> class="hover"<?php }?> id="one1"><a href="/user">未结投注</a></li>
         	<li <?php if ($get_data['type']=="end") {?> class="hover"<?php }?> id="one2""><a href="/user/game_over">已结投注</a></li>
         	<li <?php if ($get_data['type']=="bonus") {?> class="hover"<?php }?> id="one3"><a href="/user/winning">最近中奖</a></li>
        </ul>
</div>
<?php 
}
elseif($_nav == "betting") {
	$data = array('ticket_type'=>$ticket_type, 'hz'=>$hz_data);
	echo View::factory('user/betting', $data)->render();
}
elseif($_nav == "today_bets") {
?>
<div id="member_tit" class="fl">
	<ul>
		<li class="hover">今日投注</li>
	</ul>
</div>
<?php 
}
if($type == "betting") {
?> 
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl mt5" style="border: solid 1px #c5ddf5; border-bottom:0; ">
<?php 
}
else {
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl " style="border-left: solid 1px #c5ddf5; border-right: solid 1px #c5ddf5;">
<?php 
}
?>        
<tr>
	<td width="10%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">彩种</td>
	<!-- <td width="9%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">类型</td> -->
	<td width="10%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">期号</td>
	<td width="13%" align="center" valign="middle" bgcolor="#e8f2ff">发起人</td>
	<td width="10%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">方案金额</td>
	<td width="10%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">我的认购</td>
	<td width="9%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">我的奖金</td>
	<td width="12%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">投注时间</td>
	<td width="8%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">方案进度</td>
	<td width="8%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">方案状态</td>
	<td width="11%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">方案详情</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
<?php
	foreach ($list as $key=>$rs) { 
?>
<tr>
<td width="10%" height="36" align="center" valign="middle">
<?php 
		if (isset($ticket_type['type'][$rs['ticket_type']])) {
			echo $ticket_type['type'][$rs['ticket_type']];
		}
		else {
			echo '';
		}
		echo '<br />';
		if (isset($ticket_type['method'][$rs['ticket_type']][$rs['play_method']])) {
			echo $ticket_type['method'][$rs['ticket_type']][$rs['play_method']];
		}
		else {
			echo '';
		}	
?>
</td>
<!-- 
<td width="9%" height="36" align="center" valign="middle">
<?php 
		if ($rs['plan_type']==0) {
		    echo '代购';	
		}
		elseif ($rs['plan_type']==1) {
		    echo  '发起合买';
		}
		elseif ($rs['plan_type']==2) {
		    echo '参与合买';
		}
?>
</td>
 -->
<td width="10%" height="36" align="center" valign="middle" ><?php if(isset($rs['detail']['expect'])) echo $rs['detail']['expect']; else echo '--'?></td>
<td width="13%" align="center" valign="middle" class="blue" ><?php if(!empty($rs['parent'])) { echo $users[$rs['parent']['user_id']]['lastname'];}  else {echo $users[$rs['user_id']]['lastname'];}?></td>
<td width="10%" height="36" align="center" valign="middle"><?php echo $rs['detail']['total_price']; ?></td>
<td width="10%" height="36" align="center" valign="middle">
<?php 
//if($rs['detail']['ticket_type']==2){echo $rs['detail']['money'];}else{ echo $rs['detail']['price'];}
echo $rs['plan_my_money']; 
?>
</td>
<td width="9%" height="36" align="center" valign="middle">
<?php 
	if ($rs['status'] == 5 || $rs['status'] == 4) { 
		echo "<font color=red>".$rs['bonus']."</font>";
	}
	else {
		if($get_data['type']=="012") {
			echo "未开奖";
		}
		else {
			echo '0';	
		}
	}
?>
</td>
<td width="12%" height="36" align="center" valign="middle"><?php echo date("m-d H:i",strtotime($rs['date_add'])); ?></td>
<td width="8%" height="36" align="center" valign="middle"><?php if(!empty($rs['parent'])) {echo $rs['parent']['progress'];}else{echo $rs['detail']['progress'];} ?>%</td>
<td width="8%" height="36" align="center" valign="middle">
<?php
	switch ($rs['status'])
	{
		case 0:
			echo '未满员';
			break;							
		case 1:
			echo '<font color=red>未出票</font>';
			break;
	    case 2:
			echo '<font color=green>已出票</font>';
			break;
	    case 3:
			echo '<font color=blue>未中奖</font>';
			break;
	    case 4:
			echo '<b><font color=red>已中奖</font></b>';
			break;
	    case 5:
			echo '<b><font color=red><u>已派奖</u></font></b>';
			break;
	    case 6:
			echo '<font color="#aaa"><s>已撤单</s></font>';
			break;
		default:
			break;
	}
?>
</td>
<td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="<?php echo $rs['plan_detail']; ?>" target="_blank">详细</a></span></div></td>
</tr>
<?php 
}
if($_nav=="index") {
	if(!$list) {
?>
                       <tr>
                        <td height="50" colspan="10" align="center" valign="middle">
                    <span class="zhangkai"></span>
                    <div class="manu mt15">暂无数据</div>              
                        </td>
                      </tr>
<?php 
	}
}
else {
?>                        
                  <tr>
                    <td height="50" colspan="10" align="center" valign="middle">
                <span class="zhangkai"></span>
                <div class="manu mt15"><?PHP  echo $this->pagination->render('page_html'); ?></div>              
                    </td>
                  </tr>
<?php 
}
?>
    </table>
  </div>
</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
</html>