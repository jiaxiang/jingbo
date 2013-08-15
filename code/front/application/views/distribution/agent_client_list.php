<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-代理服务-下级用户列表</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/jquery',
    'media/js/hdm',
	'media/js/tk',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
	'media/css/szc',
	'media/css/mask',
), FALSE);	
?>
<script language="javascript">
</script>
</head>
<body>
<!--top小目录-->
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36">
	您所在的位置：
	<span class="blue"><a href="<?php echo url::base();?>">首页</a></span> &gt;&gt; 
	<span class="blue"><a href="<?php echo url::base();?>user">会员中心</a></span> &gt;&gt; 
	<span class="blue"><a href="#">代理服务</a></span> &gt;&gt; 下级用户列表</div>
<!--面包屑导航_end-->

<!--content1-->
<div class="width">
	<?php echo View::factory('user/left')->render();?>  

	<div class="member_right fl" style="position:relative">
		<?php //弹出窗口?>
		<div class="paly_pop_ok" style="top:40px; left:120px;">
		<div class="tips_b">
			<div class="tips_box">
				<div class="tips_title">
				<h2>温馨提示</h2>
				<span class="close"><a href="/user/login">关闭</a></span>
				</div>
				<div class="tips_text" style="overflow-y:auto; line-height:30px;">
			   	 	
				</div>
				<div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
					<a class="xg_gg_bf fhxgai" href="/user/login">重新登陆</a>
				</div>
			</div>
		</div>
		</div> 

<!-- Content Core Start -->
		<div class="member_right fl">
			<div id="member_tit" class="fl">
				<ul>
					<li class="hover">下级用户列表</li>
				</ul>
			</div>
			<form action="?" method="get" name="search_form" id="search_form">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" 
				style="border-left: solid 1px #c5ddf5; border-right: solid 1px #c5ddf5;">
				<tr>
					<td height="33" align="right" valign="middle" bgcolor="#e8f2ff">
						&nbsp;搜索:&nbsp; 
						<select name="search_key" class="text">
							<option value="lastname"  <?php if ($searchBox['search_key'] == 'lastname') echo "SELECTED";?>>用户名</option>
						</select>&nbsp;
						<input type="text" name="search_value" class="text" value="<?php echo $searchBox['search_value'];?>" />&nbsp;
						<input type="submit" name="Submit2" value="搜索" class="ui-button-small" />&nbsp;
					</td>
					<td></td>
				</tr>
		    </table>
			</form>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border: solid 1px #c5ddf5; border-bottom:0;">
				<tr height="33">
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">操作</td>
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">用户名</td>
					<td width="20%" align="center" valign="middle" bgcolor="#f3f3f3">注册时间</td>
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">是否返利</td>
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">普通返点率</td>
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">北单返点率</td>
					<!-- 
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">实时返点</td>
					 -->
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">月结返点</td>
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">状态</td>
				</tr>
		    </table>
			<?php if (is_array($dataList) && count($dataList)) {?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
				<?php foreach ($dataList as $relation) { ?>
				<tr height="33">
					<td width="10%" align="center" valign="middle">
					<?php if($relation['client_type'] == 0 || $relation['client_type'] == 1 || $relation['client_type'] == 2) { ?>
						<a href="agent_client/edit/<?php echo $relation['relationId']; ?>">修改</a>
					<?php }?>
					</td>
					<td width="10%" align="center" valign="middle"><?php echo $relation['lastnameMark'].'('.$relation['relationId'].')' ;?>&nbsp;</td>
					<td width="20%" align="center" valign="middle"><?php echo $relation['date_add'];?>&nbsp;</td>
					<td width="10%" align="center" valign="middle">
					<?php 	 if ($relation['client_type'] == 0) {echo '普通下线';}
						else if ($relation['client_type'] == 1) {echo '返利下线';}
						else if ($relation['client_type'] == 2) {echo '特殊二级代理';}
						else if ($relation['client_type'] == 11) {echo '一级代理';}
						else if ($relation['client_type'] == 12) {echo '二级代理';}
					?>
					</td>
					<td width="10%" align="center" valign="middle"><?php echo $relation['client_rate'];?>&nbsp;</td>
					<td width="10%" align="center" valign="middle"><?php echo $relation['client_rate_beidan'];?>&nbsp;</td>
					<td width="10%" align="center" valign="middle">
					<?php if ($relation['client_type'] == 1) { ?>
						<a href="<?php echo url::base().'distribution/client_month_contract/?relationId='.$relation['relationId']; ?>">查看</a>&nbsp;
					<?php }?>
					</td>
					<td width="10%" align="center" valign="middle">
						<?php echo ($relation['active'] == 1) ? '正常' : '关闭';?>
					</td>
				</tr>
				<?php };?>
			</table>
			<?php }else {?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
				<tr><td height="33" align="left" valign="middle" style="padding-left:20xp;">&nbsp;没有相应的记录&nbsp;</td></tr>
			</table>
            <?php }?>
            
            <div class="recharge_box fl" style="padding-top:5px;">
	        <div class="manu mt15">
			<?PHP  echo $this->pagination->render('page_html');?>
	        </div>
	        </div>
		</div>
<!-- Content Core End -->
	</div>
</div>
<!--content1_end-->

<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
</html>
