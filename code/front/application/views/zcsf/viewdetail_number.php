<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>彩票编号</title>
<head>
<?php
echo html::script(array
(
    'media/js/yclass.js',
	'media/js/loginer',
	'media/js/predict',
	'media/js/fangan',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/zc',
	'media/css/mask',
    'media/css/style',
    'media/css/css1',
), FALSE);
?>
</head>
<body style="background-image:none;">
<div style="width:500px;margin-top:5px; margin-left:5px;">
    <div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
                <h2>彩票标识</h2>
                <span class="close"><a href="javascript(void 0)" onclick="top.Y.closeUrl()">关闭</a></span>
            </div>
            <div class="tips_text">
			<?php 
                    switch($detail['play_method']) {
                    case 1:  //14场胜负彩
                        $expect_text="胜负彩";	
                        break;		
                    case 2:	//9场任选
                        $expect_text="9场任选";	
                        break;
                    case 3://6场半
                        $expect_text="6场半全场";
                        break;
                    case 4://4场半
                        $expect_text="4场进球彩";
                        break;			
                    default:
                        $expect_text="胜负彩";
                        break;
                    }		
            ?>         

                <h3 class="tc"><?php echo $expect_text;?>第<em class="red"><?php echo $detail['expect'];?></em>期彩票标识</h3>
                <p class="tc gray">方案编号<?php echo $detail['basic_id'];?></p>
                                <ul class="tips_text_list">
                                    <li align="center"><span class="red">
                    <?php d($lottery_numbers,false);?></span></li>
                                </ul>
                <div class="page" style="display:none">
                 <a href='javascript:void(0);' class='h_l'>首页</a><a href='javascript:void(0);' class='pre'	title='上一页'></a><a class='curpage' href='?lotid=1&pid=13179661&page=1'>1</a> <a href='javascript:void(0);'	class='h_l'>尾页</a><span class='sele_page'><input id='go_page' type='text'	class='num' onkeyup="this.value=this.value.replace(/[^\d]/g,'');if(this.value>1)this.value=1;if(this.value<=0)this.value=1" onkeydown="if(event.keyCode==13){location.href=location.href+'&page='+Y.one('#go_page').value;return false;}"/><input style='cursor:pointer;' type='button' class='btn' value='GO' onclick="location.href=location.href+'&page='+Y.one('#go_page').value"/></span><span	class='gray'>共1页，1条记录</span><input type='hidden' id='total_page' value='1' />                </div>
                            </div>
            <div class="tips_sbt">
                <input type="button" value="关闭窗口" class="btn_gray_b m-r" onclick="top.Y.closeUrl()"/>
            </div>
        </div>
    </div>
</div>
</body>
</html>