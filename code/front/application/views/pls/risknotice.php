<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-排列三-投注风险须知</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
   'media/js/yclass.js',
	'media/js/loginer'
), FALSE);
echo html::stylesheet(array
(

    'media/lottnum/style/style',
	'media/lottnum/style/hxpublic',

    
), FALSE);
?>

</head>
<body style="background-image:none;">
<div style="width:500px;margin-top:5px; margin-left:5px;">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>排列三投注风险须知</h2>
            <span class="close"><a href="javascript(void 0)" onclick="top.Y.closeUrl()">关闭</a></span>
            </div>
            <div class="tips_text">
              <ul class="tips_info_list" id="msg_content">
                            	<li style="margin-bottom: 10px;">1、彩票发行和销售机构对每期投注号码的可投注数量实行动态控制（又称“限号”），您发起的方案（包括追号方案）中若包含被限号的号码，该方案将因限号无法投注，网站将做撤单返款处理。</li>
				<li style="margin-bottom: 10px;">2、因限号而导致的部分或全部无法投注成功的方案，网站在当期官方截止时间之前进行当期方案的撤单并及时返款操作。</li>
				<li style="margin-bottom: 10px;">3、因限号导致的无法投注成功，网站履行在当期官方截止时间之前撤单并及时返款义务，除此之外，网站对于包括但不限于方案是否中奖等事项不承担任何责任。</li>

              			  </ul>
		    </div>
		    <div class="tips_sbt">
                <input type="button" class="btn_Lora_b" value="关 闭" onclick="top.Y.closeUrl()"/>
            </div>
	    </div>
   </div>
</div>
</body>   
</html>