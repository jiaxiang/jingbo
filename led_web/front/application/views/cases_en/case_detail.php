<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_config['site_title'];?></title>
<?php
echo html::script(array
(
 	'media/js/jquery',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/led/style',
), FALSE);
?>
</head>

<body style="background:url(<?php echo url::base();?>media/images/led/wbg2.jpg) top repeat-x">
<div id="wrapper">
	<div id="body_head">
<?php 
echo View::factory('header_en')->render();
?>
		<div class="banner">
			<div class="pt5"><img src="<?php echo url::base();?>media/images/led/bb3_en.jpg" /></div>
			<div><img src="<?php echo url::base();?>media/images/led/p2.jpg" /></div>
<?php 
echo View::factory('zxdt_en')->render();
?>
		</div>
	</div>
	<!--end head-->
	<div id="innerWrapper">
		<div id="wrapper_left">
			<h3>Cases</h3>
			<div class="l_menu">
				<ul>
					<li <?php if ($news_classify == 30) echo 'class="l_on"';?>><a href="<?php echo url::base();?>en/cases/cases_list/30"><p <?php if ($news_classify == 30) echo 'style="color:#FFFFFF"';?>>LED Lighting</p></a></li>
					<!-- <div class="l_menu_02">
						<ul>
							<li><a href="#"><p>> 道路照明</p></a></li>
							<li><a href="#"><p>> 景观照明</p></a></li>
							<li><a href="#"><p>> 室内照明</p></a></li>
						</ul>
					</div> -->
					<li <?php if ($news_classify == 31) echo 'class="l_on"';?>><a href="<?php echo url::base();?>en/cases/cases_list/31"><p <?php if ($news_classify == 31) echo 'style="color:#FFFFFF"';?>>Solar Street Light</p></a></li>
					<li <?php if ($news_classify == 32) echo 'class="l_on"';?>><a href="<?php echo url::base();?>en/cases/cases_list/32"><p <?php if ($news_classify == 32) echo 'style="color:#FFFFFF"';?>>Solar Power System</p></a></li>
				</ul>
			</div>
		</div>
		<div id="wrapper_right">
			<h3><span>Location：<a href="<?php echo url::base();?>en/index">HOME</a> >> Cases >> <a href="<?php echo url::base();?>products/products_list/<?php echo $news_classify;?>"><?php echo $news_classify_name;?></a></span><font class="font_666">LED Lighting</font></h3>
			<div class="content">
				<div class="products_title"><?php echo $news_infor[0]['title_en']?></div>
				<div class="products_show">
					<div class="products_show_img">
						<div><img src="<?php echo $news_infor[0]['newpic']?>" width="450" class="img_img" height="308"/></div>
						<div class="products_show_img_fl">
							<div class="img_fl_left"></div>
							<div class="img_fl_center">
								<ul>
									<li><img src="<?php echo $news_infor[0]['newpic']?>" width="54" height="54"/></li>
									<li><img src="<?php echo $news_infor[0]['newpic']?>" width="54" height="54"/></li>
									<li><img src="<?php echo $news_infor[0]['newpic']?>" width="54" height="54"/></li>
								</ul>
							</div>
							<div class="img_fl_right"></div>
						</div>
					</div>
					<div class="products_show_con">
						<p>Case Name：<?php echo $news_infor[0]['title_en']?></p>
						<p>Case Model：<?php echo $news_infor[0]['type_en']?></p>
						<p>Case Category：<?php echo $news_infor[0]['issue_en']?></p>
							<?php
					     	if ($news_infor[0]['number'] != '') {
								echo '<p><a href="'.url::base().'media/pdf/'.$news_infor[0]['number'].'">'.$news_infor[0]['number'].'</a></p>';
							} 
					      	?>
						<p>
						<!-- JiaThis Button BEGIN -->
		<div id="ckepop">
			<span class="jiathis_txt">分享到：</span>
			<a class="jiathis_button_fav">收藏夹</a>
			<a class="jiathis_button_print">打印</a>
			<a class="jiathis_button_copy">复制网址</a>
			<a class="jiathis_button_email">邮件</a>
			<script type="text/javascript" charset="utf-8">
			(function(){
			  var _w = 86 , _h = 16;
			  var param = {
			    url:location.href,
			    type:'6',
			    count:'', /**是否显示分享数，1显示(可选)*/
			    appkey:'419500296', /**您申请的应用appkey,显示分享来源(可选)*/
			    title:'<?php echo $site_config['site_title'];?>-产品中心-<?php echo $news_infor[0]['title'];?>', /**分享的文字内容(可选，默认为所在页面的title)*/
			    pic:'', /**分享图片的路径(可选)*/
			    ralateUid:'2439728655', /**关联用户的UID，分享微博会@该用户(可选)*/
				language:'zh_cn', /**设置语言，zh_cn|zh_tw(可选)*/
			    rnd:new Date().valueOf()
			  }
			  var temp = [];
			  for( var p in param ){
			    temp.push(p + '=' + encodeURIComponent( param[p] || '' ) )
			  }
			  document.write('<iframe style="float:left;margin-left:70px;"allowTransparency="true" frameborder="0" scrolling="no" src="http://hits.sinajs.cn/A1/weiboshare.html?' + temp.join('&') + '" width="'+ _w+'" height="'+_h+'"></iframe>')
			})()
			</script>
			<a style="float:left;margin-left:2px;" href="javascript:;" class="tmblog" id="share_btn_1332149169261"><img src="http://v.t.qq.com/share/images/s/b16.png" border="0" alt=""></a>

			<script>
			var _share_tencent_weibo=function(){String.prototype.elength=function(){return this.replace(/[^\u0000-\u00ff]/g,"aa").length};String.prototype.tripurl=function(){return this.replace(new RegExp("((news|telnet|nttp|file|http|ftp|https)://){1}(([-A-Za-z0-9]+(\\.[-A-Za-z0-9]+)*(\\.[-A-Za-z]{2,5}))|([0-9]{1,3}(\\.[0-9]{1,3}){3}))(:[0-9]*)?(/[-A-Za-z0-9_\\$\\.\\+\\!\\*\\(\\),;:@&=\\?/~\\#\\%]*)*","gi"),new Array(12).join("aa"))};if(!!window.find){HTMLElement.prototype.contains=function(B){return this.compareDocumentPosition(B)-19>0}};var _appkey="801113646"||"801000271";var _web={"name":document.title||"","href":location.href.replace(/([^\x00-\xff]+)/g,encodeURIComponent("$1")),"hash":location.hash,"target":"toolbar=0,status=0,resizable=1,width=630,height=530"};var _pic=function(area){var _imgarr=area.getElementsByTagName("img");var _srcarr=[];for(var i=0;i<_imgarr.length;i++){if(_imgarr[i].width<50||_imgarr[i].height<50){continue;}_srcarr.push(encodeURIComponent(_imgarr[i].src))}return _srcarr.join("|")};var _text=function(){var s1=arguments[0]||"",s2=Array().slice.call(arguments,1).join(" ").replace(/[\s\n]+/g," "),k=257-s1.tripurl().elength();var s=s2.slice(0,(k-4)>>1);if(s2.elength()>k){k=k-3;for(var i=k>>1;i<=k;i++){if((s2.slice(0,i)).tripurl().elength()>=k){break}else{s=s2.slice(0,i)}}s+="..."}else{s=s2}return[s1,s]};var _u="http://share.v.t.qq.com/index.php?c=share&a=index&f=q2&url=$url$&appkey="+_appkey+"&assname=&title=$title$&pic=$pic$";var qshare_btn=function(_arr){if(_arr[0]){return _arr[0]}else{var o=document.createElement("a"),_ostyle="width:92px;height:22px;background:url(http://mat1.gtimg.com/app/opent/images/websites/qshare/icon3.gif);position:absolute;display:none;";o.setAttribute("style",_ostyle);o.style.cssText=_ostyle;o.setAttribute("href","javascript:;");document.body.insertBefore(o,document.body.childNodes[0]);return o}}(arguments);var share_area=function(_arr){if(_arr[1]){if((typeof _arr[1]=="object"&&_arr[1].length)||(_arr[1].constructor==Array)){return _arr[1]}else{return[_arr[1]]}}else{return[document.body]}}(arguments);var current_area=share_area[0];var share_btn=function(_arr){if(_arr[2]){_arr[2].onclick=function(){window.open(_u.replace("$title$",encodeURIComponent(_text(_web.name,"").join(" "))).replace("$url$",encodeURIComponent(_web.href)).replace("$pic$",_pic(share_area[0])).substr(0,2048),'null',_web.target)}}else{return null}}(arguments);var _select=function(){return(document.selection?document.selection.createRange().text:document.getSelection()).toString().replace(/[\s\n]+/g," ")};var show=function(e,x,y){with(qshare_btn.style){display="inline-block";left=x+"px";top=y+"px";position="absolute";zIndex="999999"}};var hide=function(e){e.style.display="none"};document.onmouseup=function(e){e=e||window.event;var o=e.target||e.srcElement;for(var i=0;i<share_area.length;i++){if(share_area[i].contains(o)||share_area[i]==o){var _e={"x":e.clientX,"y":e.clientY};var _o={"w":qshare_btn.clientWidth,"h":qshare_btn.clientHeight};var _d=window.pageYOffset||(document.documentElement||document.body).scrollTop||0;var x=(_e.x-_o.w<0)?_e.x+_o.w:_e.x-_o.w,y=(_e.y-_o.h<0)?_e.y+_d-_o.h:_e.y+_d;if(_select()&&_select().length>=10&&o!=qshare_btn){show(qshare_btn,x-5,y);current_area=share_area[i];break}else{hide(qshare_btn)}}else{hide(qshare_btn)}}};document.onmouseover=function(e){var curtarget=(e&&e.target)||(window.event&&window.event.srcElement),sx=parseInt(qshare_btn.style.width),sy=parseInt(qshare_btn.style.height),d=Math.min(sx,sy);if(curtarget.tagName.toLowerCase()=="img"){var erect=curtarget.getBoundingClientRect();if(curtarget.clientWidth>=150&&curtarget.clientHeight>=150){show(share_btn,erect.right-sx-d,erect.bottom+document.body.scrollTop+document.documentElement.scrollTop-sy-d);qshare_btn.setAttribute("shareimg",curtarget.src)}}else if(curtarget!=qshare_btn&&qshare_btn.getAttribute("shareimg")){qshare_btn.removeAttribute("shareimg");hide(qshare_btn);}};document.onmousedown=function(e){var curtarget=(e&&e.target)||(window.event&&window.event.srcElement);if(curtarget!=qshare_btn){if(document.selection){document.selection.empty()}else if(window.getSelection){window.getSelection().removeAllRanges()}}};qshare_btn.onclick=function(){var shareimg=qshare_btn.getAttribute("shareimg");if(shareimg!=null){window.open(_u.replace("$title$",encodeURIComponent(_web.name+" ")).replace("$url$",encodeURIComponent(_web.href)).replace("$pic$",encodeURIComponent(shareimg)).substr(0,2048),'null',_web.target);return}var _str=_select();_resultstr=_text(_web.name,_str).reverse().join(" ");if(_str){var url=_u.replace("$title$",encodeURIComponent(_resultstr+" ")).replace("$pic$",_pic(current_area));url=url.replace("$url$",encodeURIComponent(_web.href.replace(_web.hash,"")+"#"+(current_area["name"]||current_area["id"]||""))).substr(0,2048);window.open(url,'null',_web.target)}hide(this)}};_share_tencent_weibo(null,null,document.getElementById("share_btn_1332149169261"));
			</script>
			<a href="http://www.jiathis.com/share?uid=1591179" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank">更多</a>
		</div>
		<script type="text/javascript">var jiathis_config = {data_track_clickback:true};</script>
		<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js?uid=1591179" charset="utf-8"></script>
		<!-- JiaThis Button END -->
						</p>
					</div>
				</div>
				<div class="product_details_title">Case detailed introduction</div>
				<div class="product_details">
				<?php 
      			echo $news_infor[0]['content_en'];
      			?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
echo View::factory('footer_en')->render();
?>
</body>
</html>