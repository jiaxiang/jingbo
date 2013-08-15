<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-足球单场-总进球数统计</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
	'media/guoguan/js/jquery-1.5.2',
    'media/js/yclass',
	'media/guoguan/js/base',
	'media/js/loginer',	
), FALSE);
echo html::stylesheet(array
(
    'media/lottnum/style/style',
	'media/lottnum/style/hxpublic',
	'media/guoguan/css/public',
	'media/guoguan/css/guoguan',

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
$_sys.lotid="89";
$_sys.loty = "bjdc";
</script>

<script type="text/javascript" src="/media/guoguan/js/dc_new.js"></script>
</head><body>
	<!--top小目录-->
	<?php echo View::factory('header')->render();?> 
	<div class="clearboth"></div>
	<div class="guide">您现在的位置：<a title="网上买彩票" href="/">首页</a> &gt; 过关统计 &gt; 足球单场  &gt; <a title="总进球数" href="/bjdc/zjqs/">总进球数</a>
	</div>

<!--menu和列表_end-->
	

	
	
	
	
<div class="wrap">
<div class="guoguan_left">
<?php echo View::factory('guoguan/left')->render();?> 
</div>


		<div class="guoguan_right">
		    <!-- 最新过关列表 begin -->
<!-- 		    <div class="quk_link"><strong class="red">最新过关：</strong><a href="jq4.php" title="4场进球">4场进球</a><a href="qlc.php" title="七乐彩">七乐彩</a><a href="dlt.php" title="超级大乐透">超级大乐透</a><a href="ticai.php?lot=eexw" title="22选5">22选5</a><a href="pls.php" title="排列3">排列3</a><a href="sd.php" title="福彩3D">福彩3D</a></div>		    最新过关列表 end -->
			<div class="box01">

				<div class="t_01">
					<span class="p_left"><img id="lotimg" src="/media/guoguan/img/sfc_t6.jpg" align="absmiddle" />过关统计第<select name="expect" id="expect" ></select> 期
					<span id="kjdate"></span>

					<span id="ckxxdz"></span>
<!-- 						<span style="padding-left:10px;">开奖日期:</span> <span style=" font-weight:bold;color:#F00">2011-06-04</span> -->
<!-- 						<span style="padding-left:10px;"><input type="checkbox" onclick="javascript:shiftvs(this)" /> 查看详细对阵</span> -->
					</span>
<!-- 					 <div class="bot"> -->
<!--                       <a href="/pages/info/bonus/sfc.php" target="_blank"><img src="/img/info/guoguan/d01.gif" border="0" /></a> -->
<!--                   </div> -->
				</div>

				<div class="nx">
					<div class="l">
					<span id="zcdz"></span>

<!-- 						<table class="table_list01 table_list02" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#D1E5FE"> -->
<!-- 							<tr><td height="25" width="35" class="td_t01">场次</td><td class="td_t02" width="33">1</td><td class="td_t02" width="33">2</td><td class="td_t02" width="33">3</td><td class="td_t02" width="33">4</td><td class="td_t02" width="33">5</td><td class="td_t02" width="33">6</td><td class="td_t02" width="33">7</td><td class="td_t02" width="33">8</td><td class="td_t02" width="33">9</td><td class="td_t02" width="33">10</td><td class="td_t02" width="33">11</td><td class="td_t02" width="33">12</td><td class="td_t02" width="33">13</td><td class="td_t02" width="33">14</td></tr> -->
<!-- 							<tr id="tr_vs1"><td height="58" class="td_t01">主队</td> -->
<!-- 							<td class="bg_01 td_shu"><div class="tt">乌克兰</div></td><td class="bg_01 td_shu"><div class="tt">尼日利</div></td><td class="bg_01 td_shu"><div class="tt">加拿大</div></td><td class="bg_01 td_shu"><div class="tt">墨西哥</div></td><td class="bg_01 td_shu"><div class="tt">韩<br />&nbsp;&nbsp;<br />国</div></td><td class="bg_01 td_shu"><div class="tt">法<br />&nbsp;&nbsp;<br />罗</div></td><td class="bg_01 td_shu"><div class="tt">罗马尼</div></td><td class="bg_01 td_shu"><div class="tt">克罗地</div></td><td class="bg_01 td_shu"><div class="tt">摩尔多</div></td><td class="bg_01 td_shu"><div class="tt">圣马力</div></td><td class="bg_01 td_shu"><div class="tt">奥地利</div></td><td class="bg_01 td_shu"><div class="tt">比利时</div></td><td class="bg_01 td_shu"><div class="tt">白<br />&nbsp;&nbsp;<br />俄</div></td><td class="bg_01 td_shu"><div class="tt">意大利</div></td>							</tr> -->
<!-- 							<tr id="tr_vs2" style="display:none"><td height="120" class="td_t01">对阵</td> -->
<!-- 							<td class="bg_01 td_shu"><div class="tt">乌克兰</div><div class="vs">2:0</div><div class="tt">乌兹别</div></td><td class="bg_01 td_shu"><div class="tt">尼日利</div><div class="vs">4:1</div><div class="tt">阿根廷</div></td><td class="bg_01 td_shu"><div class="tt">加拿大</div><div class="vs">2:2</div><div class="tt">厄瓜多</div></td><td class="bg_01 td_shu"><div class="tt">墨西哥</div><div class="vs">VS</div><div class="tt">新西兰</div></td><td class="bg_01 td_shu"><div class="tt">韩<br />&nbsp;&nbsp;<br />国</div><div class="vs">VS</div><div class="tt">塞尔维</div></td><td class="bg_01 td_shu"><div class="tt">法<br />&nbsp;&nbsp;<br />罗</div><div class="vs">VS</div><div class="tt">斯洛文</div></td><td class="bg_01 td_shu"><div class="tt">罗马尼</div><div class="vs">VS</div><div class="tt">波<br />&nbsp;&nbsp;<br />黑</div></td><td class="bg_01 td_shu"><div class="tt">克罗地</div><div class="vs">VS</div><div class="tt">格鲁吉</div></td><td class="bg_01 td_shu"><div class="tt">摩尔多</div><div class="vs">VS</div><div class="tt">瑞<br />&nbsp;&nbsp;<br />典</div></td><td class="bg_01 td_shu"><div class="tt">圣马力</div><div class="vs">VS</div><div class="tt">芬<br />&nbsp;&nbsp;<br />兰</div></td><td class="bg_01 td_shu"><div class="tt">奥地利</div><div class="vs">VS</div><div class="tt">德<br />&nbsp;&nbsp;<br />国</div></td><td class="bg_01 td_shu"><div class="tt">比利时</div><div class="vs">VS</div><div class="tt">土耳其</div></td><td class="bg_01 td_shu"><div class="tt">白<br />&nbsp;&nbsp;<br />俄</div><div class="vs">VS</div><div class="tt">法<br />&nbsp;&nbsp;<br />国</div></td><td class="bg_01 td_shu"><div class="tt">意大利</div><div class="vs">VS</div><div class="tt">爱沙尼</div></td>							</tr> -->
<!-- 							<tr><td height="25" class="td_t01">彩果</td> -->
<!-- 							<td class="red_b">3</td><td class="red_b">3</td><td class="red_b">1</td><td class="red_b">*</td><td class="red_b">*</td><td class="red_b">*</td><td class="red_b">*</td><td class="red_b">*</td><td class="red_b">*</td><td class="red_b">*</td><td class="red_b">*</td><td class="red_b">*</td><td class="red_b">*</td><td class="red_b">*</td>							</tr> -->
<!-- 						</table> -->
					</div>
					<div class="r">
					<span id="zckj"></span>
<!-- 						<ul id="ul_kj" class="mini"> -->
<!-- 							<li>一等奖：<span class="red_b">--</span> 注，每注奖金 <span class="red_b">--</span> 元</li> -->

<!-- 							<li>二等奖：<span class="red_b">--</span> 注，每注奖金 <span class="red_b">--</span> 元</li> -->
<!-- 							<li>全国销量：<span class="red_b">24,273,104</span> 元</li> -->
<!-- 							<li>奖池滚存：<span class="red_b">--</span> 元</li> -->
<!-- 							<li class="fr"><a href="./dist/sfc.php?expect=11056" target="_blank" rel="nofollow">>>查看开奖结果分布</a></li> -->
<!-- 							<li><a href="javascript:void(0)" onclick="ajax_complete('sfc','11056')">>>本站中奖统计</a><img style="position:absolute;margin:-5px 0 0 0" src="/img/info/public/xin.gif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="./dist/sfc.php?expect=11056" target="_blank" rel="nofollow">>>查看开奖结果分布</a></li> -->
<!-- 						</ul> -->
                    </div>

					<div class="clear"></div>
				</div>
			</div>
            <div style="z-index:100;position:absolute;top:350px;left:328px;width:350px;background-color:#ffffff;display:none" id="ZJInfo">
                
            </div>  		
			<div class="box02">
			<input id="seltype" type="hidden" /> 
			<input id="lotid" type="hidden" /> 

			<input id="fs_ps" type="hidden" /> 
			<input id="fs_tp" type="hidden" /> 
			<input id="fs_tr" type="hidden" /> 
			
			<input id="us_ps" type="hidden" /> 
			<input id="us_tp" type="hidden" /> 
			<input id="us_tr" type="hidden" />

			<input id="ff_ps" type="hidden" /> 
			<input id="ff_tp" type="hidden" /> 
			<input id="ff_tr" type="hidden" />
			
			<input id="uf_ps" type="hidden" /> 
			<input id="uf_tp" type="hidden" /> 
			<input id="uf_tr" type="hidden" /> 
			
			
				<div class="bq01">
					<ul class="menuItem01" id="mymenu" name="mymenu">
				
					<li class="menu02" id="menu1"><a ><span>已结束的成功方案</span></a></li>

					</ul>
					<span style="float:right; line-height:27px; padding-right:20px;"><p class="red" style="float:left;">注：</p>带*为代购方案</span>
				</div>

			</div>
<!-- 		<div> -->
<!-- 		<input name="expect" value="" type="hidden" /> -->
		
<!-- 		<table style="margin-top: 0pt;" class="table_list01" border="0" cellpadding="0" cellspacing="0" width="100%" /> -->
<!-- 		<tbody> -->
<!-- 		<tr class="td_t01"> -->
<!-- 		<td height="22" width="14%"> -->
<!-- 		<img src="/img/info/guoguan/searchrow.gif" align="absmiddle" height="17" width="13" /> 搜索方案： -->
<!-- 		</td> -->
<!-- 		<td width="23%"> -->
<!-- 		<input name="keyword" style="color: #999; margin-right:10px;" value="" size="22" id="keyword" onclick="oclick(this)" onblur="oblur(this)" type="text" /> -->
<!-- 		</td> -->
<!-- 		<td width="18%"> -->
<!-- 		<span class="ss"><a href="#" onclick="document.spro.submit()"></a></span> -->
<!-- 		<span class="sx"><a href="#" onclick="location.href=location.href"></a></span> -->

<!-- 		</td> -->
<!-- 		<td><span class="red">注：</span>带*为代购方案</td> -->
<!-- 		</tr> -->
<!-- 		</tbody> -->
<!-- 		</table> -->
		

		<div id="showlist" ></div>


<!-- 		</div> -->
  </div>	
</div>
	
	
	
	
	
	
	
	
	
	
	

	
<!--link-->
<?php echo View::factory('footer')->render();?> 
<!--未登录提示层-->
<?php echo View::factory('login')->render();?>

<!--提示确认-->
<div class="tips_m" style="display:none" id="confirm_dlg">
	<div class="tips_b">

        <div class="tips_box">
            <div class="tips_title">
                <h2 id="confirm_dlg_title">温馨提示</h2>
                <span class="close" id="confirm_dlg_close"><a href="#">关闭</a></span>
            </div>
            <div class="tips_info"  id="confirm_dlg_content"></div>
            <div class="tips_sbt">
                <input type="button" value="取 消" class="btn_Lora_b"  id="confirm_dlg_no" /><input type="button" value="确 定" class="btn_Dora_b"  id="confirm_dlg_yes" />

            </div>
        </div>
    </div>
</div>



</html>	