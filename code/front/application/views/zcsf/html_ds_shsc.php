<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-足彩胜负-单式上传</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
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
<body style="background-image:none;" bgColor="transparent">
<div style="width:600px;margin-top:5px; margin-left:5px;border:1px;bordercolor:red" >
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
                <h2>胜负彩单式方案上传</h2>
                <span class="close"><a href="javascript:;" onclick="top.Y.closeUrl()">关闭</a></span>
            </div>
            <form name="project_form" onsubmit="return checkform()" id="project_form" action="/zcsf/submit_upload" method="post" ENCTYPE="multipart/form-data">
            <div class="tips_text">
                <ul class="tips_info_list">
					<li>您发起方案为：<em class="red"><?php echo $detail['zhushu']?></em>注，<em class="red"><?php echo $detail['rate']?></em>倍，共<em class="red">￥<?php echo $detail['price']?>.00</em>元。</li>
					<li><input name="upfile" id="upfile" type="file" class="m-r" /><a href="javascript:void 0" onclick="Y.openUrl('/sfc/inc/project_ds_3.php',420,380,1)">查看标准格式样本</a></li>
					<li class="red">1、选择倍投注时只需上传单倍方案；上传的方案注数必须跟填写的一致，否则可能无法出票。</li>
					<li>2、请严格参照"标准格式样本"格式上传方案，否则网站不保证为您做过关统计以及历史战绩统计。</li>
					<li>3、文件格式必须是文本文件。</li>
					<li>4、由于上传的文件较大，会导致上传时间及在本页停留时间较长，请耐心等待。</li>
                </ul>
            </div>
			<input name="pid" id="pid" type="hidden" value="<?php echo $detail['basic_id']?>"><!--彩种Id-->
            <div class="tips_sbt">
             <input type="button" class="btn_Lora_b" value=" 返回 " onclick="top.Y.closeUrl()"/><input type="submit" class="btn_Dora_b" value="确认上传" />
            </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript"> 
    checkform=function(){
    	if(Y.one('#upfile').value==''){
    		Y.getTip().show('#upfile','<h5>请先选择要上传的文件！</h5>').setIco(7)
    		return false;
    	}
    	if(!Y.one('#upfile').value.match(/\.te?xt$/i)){
    		Y.getTip().show('#upfile','<h5>您好，上传文件只支持txt格式，请重新上传！</h5>').setIco(7)
    		return false;
    	}
    	Y.getTip().hide()	
    	return true;
    }
    Y.get('#all_button label').click(function(){
    	Y.get('label', this.parentNode).removeClass('b');
    	Y.get(this).addClass('b');
    });
</script>    
