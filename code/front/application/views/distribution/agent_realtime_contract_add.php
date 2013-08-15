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
	<span class="blue"><a href="<?php echo url::base();?>distribution/agent_client">下线用户列表</a></span> &gt;&gt; 
	<span class="blue"><a href="<?php echo url::base();?>distribution/agent_realtime_contract/?relationId=<?php echo $relation['id'];?>">实时合约列表</a></span> &gt;&gt; 
	新建实时合约
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

<div class="width">
<!--**content start**-->
		<?php if(isset($error)){ ?>
		<div style="border:1px solid red; width:780px; background-color:#fef2ee; padding-left:10px; font-size:10px;">
			<span class="ui-icon ui-icon-alert">&nbsp;</span>
			出错了: <?php echo $error; ?>
		</div>
		<div style="height:5px;"></div>
		<?php } ?>
<form id="add_form" name="add_form" method="post" onsubmit="return CheckForm()" 
		action="<?php echo url::base().url::current();?>">
		<input type="hidden" name="relationId" value="<?php echo $relation['id'];?>" />
	<div class="member_right fl">
		<div id="member_tit" class="fl">
			<ul>
				<li class="hover">新建二级代理的实时合约</li>
			</ul>
		</div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box" 
			style="border:solid 1px #c5ddf5; ">
			<tr style="height:33px">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">上级代理</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $agent['lastname']; ?>
					<input type="hidden" name="agentId" value="<?php echo $agent['id'];?>" />
				</td>
			</tr>
			<tr style="height:33px">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">下级用户</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $client['lastname']; ?>
					<input type="hidden" name="clientId" value="<?php echo $client['id'];?>" />
				</td>
			</tr>
			<tr style="height:33px">
				<td align="center" valign="middle" bgcolor="#f3f3f3">合约类型</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<input type="hidden" name="contractType" class="text" value="2" />二级代理返利
				</td>
			</tr>
			<tr style="height:33px">
				<td align="center" valign="middle" bgcolor="#f3f3f3">彩种分类</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<select name="type" id="type" onchange="onSelectChange()">
						<option value="0" selected>普通</option>
						<option value="7">北单</option>
					</select>
				</td>
			</tr>
			<tr style="height:33px">
				<td align="center" valign="middle" bgcolor="#f3f3f3">代理返点能力</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<span id="rate_ability" class="required"><?php echo $rate_ability_array['0'];?></span>
					<span class="brief-input-state notice_inline">返点能力代表该代理可以允诺给下级客户的最大返点值</span>
					<input type="hidden" id="rateAbility" name="rateAbility" value="<?php echo $rate_ability_array['0'];?>" />
				</td>
			</tr>
			<tr style="height:33px">
				<td align="center" valign="middle" bgcolor="#f3f3f3">返点率</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<input type="text" name="rate" id="rate" value="" maxlength="5">
					<span>返点率的值范围在0至代理饭店能力之间</span>
				</td>
			</tr>
			<tr style="height:33px">
				<td align="center" valign="middle" bgcolor="#f3f3f3">状态</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					关闭<input type="hidden" name="flag" value="0"/>
					<span class="brief-input-state notice_inline">请在合约创建后，再将其设置成有效状态。</span>
				</td>
			</tr>
			<tr style="height:33px">
				<td align="center" valign="middle" bgcolor="#f3f3f3">备注：</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<textarea maxlength="255" type="textarea" class="text valid" rows="5" cols="56" name="note"></textarea>
					<span class="brief-input-state notice_inline">用户备注，请不要超过250字节。</span>
				</td>
			</tr>
		</table>
	</div>
	<div class="member_right fl">&nbsp;</div>
	<br/>
	
	<div class="member_right fl" style="text-align:center;" >
		<input type="submit" name="submit" class="ui-button" value=" 确认添加 " />
	</div>
</form>
<!--**content end**-->
</div>

	</div>
</div>
<!--content1_end-->

<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->

<script type="text/javascript">
function CheckForm()
{
	for(var index=0; index<10; index++)
	{
		var rateInput = document.getElementById('rate');
		var rateAbilityHidden = document.getElementById('rateAbility');
		if (rateInput.value == null || rateInput.value == '' )
		{
			alert('返点率不能为空, 返点细则'+index);
			return false;
		}
		if (rateInput.value < 0 || rateInput.value > rateAbilityHidden.value) 
		{
			alert('返点率超出范围, 返点细则'+index);
			return false;
		}
	}
	return true;
}
</script>
<script type="text/javascript">
function onSelectChange()
{
	var typeSelector      = document.getElementById('type');
	var rateAbilitySpan   = document.getElementById('rate_ability');
	var rateAbilityHidden = document.getElementById('rateAbility');

	if (typeSelector.value == 0){
		rateAbilitySpan.innerText  = parseFloat('<?php echo $rate_ability_array['0'];?>').toFixed(2);
		rateAbilityHidden.value    = parseFloat('<?php echo $rate_ability_array['0'];?>').toFixed(2);
	}
	else if (typeSelector.value == 7) {
		rateAbilitySpan.innerText  = parseFloat('<?php echo $rate_ability_array['7'];?>').toFixed(2);
		rateAbilityHidden.value    = parseFloat('<?php echo $rate_ability_array['7'];?>').toFixed(2);
	}
}
</script>

</body>
</html>