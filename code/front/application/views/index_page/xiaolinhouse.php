<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_config['site_title'];?>-首页-竞彩-足彩-篮彩-足球-彩票合买</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
	'media/index/js/jquery.min.js',
), FALSE);
echo html::stylesheet(array
(
 	'media/index/css/css',
), FALSE);
?>
<script type="text/javascript">
$(function() {
	var sWidth = $("#focus").width(); //获取焦点图的宽度（显示面积）
	var len = $("#focus ul li").length; //获取焦点图个数
	var index = 0;
	var picTimer;
	
	//以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
	var btn = "<div class='btnBg'></div><div class='btn'>";
	for(var i=0; i < len; i++) {
		btn += "<span></span>";
	}
	btn += "</div><div class='preNext pre'></div><div class='preNext next'></div>";
	$("#focus").append(btn);
	$("#focus .btnBg").css("opacity",0.5);

	//为小按钮添加鼠标滑入事件，以显示相应的内容
	$("#focus .btn span").css("opacity",0.4).mouseenter(function() {
		index = $("#focus .btn span").index(this);
		showPics(index);
	}).eq(0).trigger("mouseenter");

	//上一页、下一页按钮透明度处理
	$("#focus .preNext").css("opacity",0.2).hover(function() {
		$(this).stop(true,false).animate({"opacity":"0.5"},300);
	},function() {
		$(this).stop(true,false).animate({"opacity":"0.2"},300);
	});

	//上一页按钮
	$("#focus .pre").click(function() {
		index -= 1;
		if(index == -1) {index = len - 1;}
		showPics(index);
	});

	//下一页按钮
	$("#focus .next").click(function() {
		index += 1;
		if(index == len) {index = 0;}
		showPics(index);
	});

	//本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
	$("#focus ul").css("width",sWidth * (len));
	
	//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
	$("#focus").hover(function() {
		clearInterval(picTimer);
	},function() {
		picTimer = setInterval(function() {
			showPics(index);
			index++;
			if(index == len) {index = 0;}
		},4000); //此4000代表自动播放的间隔，单位：毫秒
	}).trigger("mouseleave");
	
	//显示图片函数，根据接收的index值显示相应的内容
	function showPics(index) { //普通切换
		var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
		$("#focus ul").stop(true,false).animate({"left":nowLeft},300); //通过animate()调整ul元素滚动到计算出的position
		//$("#focus .btn span").removeClass("on").eq(index).addClass("on"); //为当前的按钮切换到选中的效果
		$("#focus .btn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); //为当前的按钮切换到选中的效果
	}
});

</script>
</head>
<body>
<div id="ad">
  <div id="focus">
    <ul>
      <li><a href="#" target="_blank"><img src="<?php echo url::base();?>media/index/images/ad/01.jpg" alt="QQ商城焦点图效果下载" /></a></li>
      <li><a href="#" target="_blank"><img src="<?php echo url::base();?>media/index/images/ad/02.jpg" alt="QQ商城焦点图效果下载" /></a></li>
      <li><a href="#" target="_blank"><img src="<?php echo url::base();?>media/index/images/ad/03.jpg" alt="QQ商城焦点图效果下载" /></a></li>
      <li><a href="#" target="_blank"><img src="<?php echo url::base();?>media/index/images/ad/04.jpg" alt="QQ商城焦点图效果下载" /></a></li>
      <li><a href="#" target="_blank"><img src="<?php echo url::base();?>media/index/images/ad/05.jpg" alt="QQ商城焦点图效果下载" /></a></li>
    </ul>
  </div>
</div>
<!--ad end-->
<div id="container" class="clearfix">
  <div class="main l">
    <li><a href="<?php echo url::base();?>jczq/rqspf/yc"><img src="<?php echo url::base();?>media/index/images/001.jpg" alt="" /></a></li>
    <li><a href="<?php echo url::base();?>jczq/rqspf/xj"><img src="<?php echo url::base();?>media/index/images/002.jpg" alt="" /></a></li>
    <li><a href="<?php echo url::base();?>jczq/rqspf/yj"><img src="<?php echo url::base();?>media/index/images/003.jpg" alt="" /></a></li>
    <li><a href="<?php echo url::base();?>jczq/rqspf/dj"><img src="<?php echo url::base();?>media/index/images/004.jpg" alt="" /></a></li>
    <li><a href="<?php echo url::base();?>jczq/rqspf/fj"><img src="<?php echo url::base();?>media/index/images/005.jpg" alt="" /></a></li>
    <li><a href="<?php echo url::base();?>jczq/rqspf/og"><img src="<?php echo url::base();?>media/index/images/006.jpg" alt="" /></a></li>
    <li><a href="<?php echo url::base();?>jczq/rqspf/oj"><img src="<?php echo url::base();?>media/index/images/007.jpg" alt="" /></a></li>
    <li><a href="<?php echo url::base();?>jczq/rqspf"><img src="<?php echo url::base();?>media/index/images/008.jpg" alt="" /></a></li>
  </div>
  <div class="nav r">
  <form id="login_index" name="login_index" action="<?php echo url::base();?>user/login" method="post">
    <div class="login">
      <table width="170" border="0" align="center" cellpadding="5" cellspacing="0">
        <tbody>
          <tr>
            <td class="title" style="color:#FFFF00; font-size:16px;">会员登陆</td>
          </tr>
          <tr>
            <td></td>
          </tr>
          <tr>
            <td class="title">用户名：</td>
          </tr>
          <tr>
            <td><input type="text" size="20" class="username" name="username" maxlength="20" /></td>
          </tr>
          <tr>
            <td class="title">密&nbsp;&nbsp;码：</td>
          </tr>
          <tr>
            <td><input type="password" size="20" class="password" name="password" maxlength="20" /></td>
          </tr>
          <tr>
            <td class="title">验证码：</td>
          </tr>
          <tr>
            <td>
            <input type="text" size="5" class="secode" name="secode" id="secode" maxlength="4" />
            </td>
          </tr>
          <tr>
            <td>
            <span class="fl">
			<img alt="点击更换图片" onclick="reload_secoder('login_secoder1');"  style="cursor: pointer;" src="<?php echo url::base();?>site/secoder?id=login_secoder" id='login_secoder1' />
			<script language="javascript">
			var flag = 0;
			function reload_secoder(id,url){
			    flag++;
			    $('#'+id).attr("src","<?php echo url::base();?>site/secoder?id="+id+"&flag="+flag);
			}
			</script>
			</span>
            </td>
          </tr>
          <tr>
            <td class="orange"><a href="<?php echo url::base();?>user/register">会员注册</a></td>
          </tr>
          <tr>
            <td class="orange"><a href="<?php echo url::base();?>user/getpassword" target="_blank">您忘记了密码 ? </a></td>
          </tr>
          <tr>
            <td align="right"><img width="70" height="21" src="<?php echo url::base();?>media/index/images/loginin.gif" onclick="javascript:document.login_index.submit();" /></td>
          </tr>
        </tbody>
      </table>
    </div>
    </form>
    <h2>客服中心</h2>
    <p><?php echo $site_config['kf_phone_num'];?></p>
    <h2>投注清单</h2>
    <!-- <p><span>刘先生 投注曼联1000</span></p>
    <p><span>刘先生 投注曼联1000</span></p>
    <p><span>刘先生 投注曼联1000</span></p>
    <p><span>刘先生 投注曼联1000</span></p>
    <p><span>刘先生 投注曼联1000</span></p>
    <p><span>刘先生 投注曼联1000</span></p>
    <p><span>刘先生 投注曼联1000</span></p>
    <p><span>刘先生 投注曼联1000</span></p>
    <p><span>刘先生 投注曼联1000</span></p>
    <p><span>刘先生 投注曼联1000</span></p>
    <p><span>刘先生 投注曼联1000</span></p> -->
  </div>
</div>
<!--container end-->
</body>
</html>