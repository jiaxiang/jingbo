<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>竞波网</title>
<meta name="Keywords" content="彩票,足彩,体彩,福彩,caipiao" />
<meta name="Description" content="竞波网是一家服务于中国彩民的互联网彩票合买代购交易平台，是当前中国彩票互联网交易行业的领导者。竞波网以服务中国彩民为己任，为彩民提供全国各大联销型彩票的在线合买、代购和彩票软件开发、彩票增值短信业务、彩票WAP移动业务等服务。覆盖了足球彩票，体育彩票，福利彩票等各类中国彩票." />
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
	<span class="blue"><a href="<?php echo url::base();?>distribution/agent">代理服务</a></span> &gt;&gt; 
	<span class="blue"><a href="<?php echo url::base();?>distribution/agent_client">下线用户列表</a></span> &gt;&gt; 实时合约
</div>
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
		
		<!--**error start**-->
		<?php 
			$remindData = (array)remind::get();
			if (isset($remindData['error'])) 
			{
				$errorData = $remindData['error'];
		?>
	    <div style="height:25px; line-height:25px; border:1px solid #cc0a0c; background-color:#FEF6f3; padding-left:15px; color:red;">
	    	<span><?php echo $errorData[0]; ?></span>
	    </div>
	    <?php } ?>
		<!--**error end**-->
		
<!-- Content Core Start -->
		<div class="member_right fl">
			<div id="member_tit" class="fl">
				<ul>
					<li class="hover">下线用户&nbsp;<?php echo $client['lastname'];?>&nbsp;实时合约列表</li>
				</ul>
			</div>
			<!-- 
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" 
				style="border-left: solid 1px #c5ddf5; border-right: solid 1px #c5ddf5;">
				<tr>
					<td height="33" align="right" valign="middle" bgcolor="#e8f2ff">
						<input type="button" name="add" value="添加新合约" onclick="onAddButtonClick()" />&nbsp;
					</td>
					<td></td>
				</tr>
		    </table>
			 -->
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" 
				style="border: solid 1px #c5ddf5; border-bottom:0;">
				<tr height="33">
					<!-- 
					<td width="15%" align="center" valign="middle" bgcolor="#f3f3f3">操作</td>
					 -->
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">合约类型</td>
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">彩种分类</td>
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">返点率</td>
					<td width="15%" align="center" valign="middle" bgcolor="#f3f3f3">合约创建日期</td>
					<td width="15%" align="center" valign="middle" bgcolor="#f3f3f3">最后一次结算日期</td>
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">状态</td>
				</tr>
		    </table>
			<?php if (is_array($contractList) && count($contractList)) {?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
				<?php foreach ($contractList as $contract) { ?>
				<tr height="33">
					<!-- 
					<td width="15%"  align="center" valign="middle">
						<?php //if($contract['flag']==0) {?>
						<a href="<?php //echo url::base().'distribution/agent_realtime_contract/open/'.$contract['id'];?>">生效</a>&nbsp;
						<?php //} else {?>
						<a href="<?php //echo url::base().'distribution/agent_realtime_contract/close/'.$contract['id'];?>">关闭</a>&nbsp;
						<?php //} ?>
						<a href="<?php //echo url::base().'distribution/agent_realtime_contract/delete/'.$contract['id'];?>" 
								onclick="javascript:return confirm('确定删除？')">删除</a>&nbsp;
					</td>
					 -->
					<td width="10%" align="center" valign="middle">
						<?php if ($contract['contract_type'] == 0) {
							echo '普通返利';
						}else if($contract['contract_type'] == 1) {
							echo '下线返利';
						}else if($contract['contract_type'] == 2) {
							echo '超级代理返利';
						}?>&nbsp;
					</td>
					<td width="10%" align="center" valign="middle"><?php echo ($contract['type'] == 7) ? '北单' : '普通';?>&nbsp;</td>
					<td width="10%" align="center" valign="middle"><?php echo $contract['rate'];?>&nbsp;</td>
					<td width="15%" align="center" valign="middle"><?php echo $contract['createtime'];?>&nbsp;</td>
					<td width="15%" align="center" valign="middle"><?php echo $contract['lastsettletime'];?>&nbsp;</td>
					<td width="10%" align="center" valign="middle">
						<?php echo ($contract['flag'] == 2) ? '生效' : '关闭';?>
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

<script>
function onAddButtonClick()
{
	document.location.href='/distribution/agent_realtime_contract/add/<?php echo $relation['id'];?>';
}
</script>
</html>