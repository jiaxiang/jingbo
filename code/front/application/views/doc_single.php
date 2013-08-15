<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<title><?php echo $title;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
echo html::script(array
(
    'media/js/yclass.js',
	'media/js/loginer',
), FALSE);
echo html::stylesheet(array
(
    'media/css/szc',
), FALSE);
?>
</head>
<body style="background-image:none;">
<div style="width:500px;margin-top:5px; margin-left:5px;">
	<div class="tips_b">

        <div class="tips_box">
            <div class="tips_title">
            <h2><?php echo $title;?></h2>
            <span class="close"><a href="javascript(void 0)" onclick="top.Y.closeUrl()">ر</a></span>
            </div>
            <div class="tips_text" style="height:300px;overflow-y:auto">
              <ul class="tips_info_list" id="msg_content">

<?php echo $content;?>

			  </ul>
		    </div>
		    <div class="tips_sbt">
                <input type="button" class="btn_Lora_b" value="确定" onclick="top.Y.closeUrl()"/>

            </div>
	    </div>
   </div>
</div>
</body>
</html>

   


