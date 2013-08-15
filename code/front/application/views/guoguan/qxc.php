<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-七星彩</title>
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
$_sys.lotid="51";
$_sys.loty = "qxc";
</script>

<script type="text/javascript" src="/media/guoguan/js/index_new.js"></script>
</head><body>
	<!--top小目录-->
	<?php echo View::factory('header')->render();?> 
	<div class="clearboth"></div>
	<div class="guide">您现在的位置：<a title="网上买彩票" href="/">首页</a> &gt; 过关统计 &gt; <a title="七星彩" href="/qxc/">七星彩</a>
	</div>

<!--menu和列表_end-->
	

	
	
	
	
<div class="wrap">
<div class="guoguan_left">
<?php echo View::factory('guoguan/left')->render();?> 
</div>



		<div class="guoguan_right">
		   
			<div class="box01">

				<div class="t_01">
					<span class="p_left">
						<img align="absmiddle" src="/media/guoguan/img/qxc_t.jpg" id="lotimg">过关统计第
						<select id="expect" name="expect">
						</select> 期
						<span id="kjdate"><span style="padding-left:10px;">开奖日期:</span> <span style=" font-weight:bold;color:#F00">2012-02-06</span></span>
						<span id="ckxxdz"></span>
					</span>

				</div>


	<div id="szckj"></div>

				<div class="nx">
					<div class="l">
					<span id="zcdz"></span>

					</div>
					<div class="r">
					<span id="zckj"></span>

                    </div>
					<div class="clear"></div>
				</div>
			</div>
            <div id="ZJInfo" style="z-index:100;position:absolute;top:350px;left:328px;width:350px;background-color:#ffffff;display:none">
                
            </div>  		
			<div class="box02">
			<input type="hidden" id="seltype" value="as"> 
			<input type="hidden" id="lotid" value=""> 

			<input type="hidden" id="as_ps" value=""> 
			<input type="hidden" id="as_tp" value=""> 
			<input type="hidden" id="as_tr" value=""> 

			<input type="hidden" id="af_ps" value=""> 
			<input type="hidden" id="af_tp" value=""> 
			<input type="hidden" id="af_tr" value=""> 
			
			
				<div class="bq01">
					<ul name="mymenu" id="mymenu" class="menuItem01">
					<li id="menu1" class="menu02"><a><span>全部成功</span></a></li>
				<!-- <li id="menu4" class="menu01"><a><span>全部流产</span></a></li> -->	
					</ul>
					<span style="float:right; line-height:27px; padding-right:20px;"><p style="float:left;" class="red">注：</p>带*为代购方案; 带<strong class="addTo">+</strong>为追加方案</span>
				</div>
			</div>
	

		<div id="showlist">
	
		</div>

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