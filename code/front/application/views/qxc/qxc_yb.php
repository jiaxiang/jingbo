﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-七星彩-标准格式样本</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
	'media/lottnum/js/jquery',
    'media/js/yclass.js',
	'media/js/loginer',
	'media/js/mask/mask',

), FALSE);
echo html::stylesheet(array
(
    'media/lottnum/style/style',
	'media/lottnum/style/hxpublic',    
), FALSE);
?>
 </head>

<body>
<body style="background-image:none;">
<div style="width:390px;margin-top:5px; margin-left:5px;">
  <div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>七星彩标准格式样本</h2>
            <span class="close"><a href="javascript(void 0)" onclick="parent.Y.closeUrl()">关闭</a></span>
         </div>

         <div class="tips_text">
            2,8,4,6,5,3,4<br>
			2,4,3,6,6,1,9<br>
			2,4,3,3,6,8,4<br>
			2,2,3,6,2,6,9<br>
			2,8,4,6,5,3,4<br>
			2,4,3,6,6,1,9<br>

			2,4,3,3,6,8,4<br>
			2,2,3,6,2,6,9<br>
		 </div>   
         <div class="tips_sbt"><p align="center" style="padding-left:28px">
            <input type="button" class="btn_Lora_b" value="知道了" onclick="parent.Y.closeUrl()"/>
        </p></div>
        </div>

    </div>
  </div>
</div>                
</body>
</html>