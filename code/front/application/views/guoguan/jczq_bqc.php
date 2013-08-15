<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-竞彩足球-半全场</title>
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
$_sys.lotid="92";
$_sys.loty = "jczq";
</script>

<script type="text/javascript" src="/media/guoguan/js/jc_new.js"></script>
</head><body>
	<!--top小目录-->
	<?php echo View::factory('header')->render();?> 
	<div class="clearboth"></div>
	<div class="guide">您现在的位置：<a title="网上买彩票" href="/">首页</a> &gt; 过关统计 &gt; 竞彩足球  &gt; <a title="半全场" href="/jczq/bqc/">半全场</a>
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
					<span class="p_left"><img id="lotimg" src="/media/guoguan/img/jczq_4.jpg" align="absmiddle" />  选择日期<select name="expect" id="expect" ></select>

					</span>
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