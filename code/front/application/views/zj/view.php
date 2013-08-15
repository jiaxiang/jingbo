<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-战绩</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<style>
*{ margin:0;  padding:0;}
input{ margin:0;  padding:0;}
img{ border:none;}
ul li{ list-style:none;}
body{ font-size:12px; font-family:Verdana, Geneva, sans-serif;}

.clear{ clear:both; font-size:0px; line-height:0px;}
a{ text-decoration:none; color:#666;}
a:hover{ color: #06C;}
.red{ color:#F00;}

.jp_tank{ background:#dce6f4; padding:4px; width:705px; margin: 0 auto;}
.jp_box_title { background:url(/media/zj/img/jp/tips_ico.png) repeat-x;border-bottom: 1px solid #87B0DE; height: 28px; overflow: hidden; padding-left: 10px; padding-right: 6px;line-height:28px;}
.jp_box_title h1 { font-size:14px; float:left;}
.jp_close a{background-position: 0 -30px;
    float: right;
    height: 22px;
    margin-top: 3px;
    overflow: hidden;
    text-indent: -99999em;
    width: 23px;
 }
	
.jp_a_close{background: url('/media/zj/img/jp/tips_ico.png') no-repeat scroll 0 0 transparent;}
.jp_m{ background:#fff;}
.jp_t_title{ line-height:25px;}
.jp_t_title .rd{ color:#F00;}
.jp_t_title .span_l{padding-left:8px;}
.jp_t_title .span_r{}
.tb_{ border-bottom:2px solid #3591de; margin-top:5px; height:22px;}
.tb_ ul { padding-left:10px;overflow:hidden;}
.tb_  li{ float:left; margin-left:10px; line-height:22px; cursor:pointer;}

#showdatalist table .d_tabletitle td { line-height:22px; background:#dcedff;}
#showdatalist table tr td{text-align:center;line-height:20px;  border-bottom: 1px dotted #CCCCCC;border-right: 1px dotted #CCCCCC;}
.dis table tr td{ line-height:25px; text-align:center;}
.dis table tr td{ border-bottom:1px solid #CCC; border-right:1px solid #CCC;}
.dis table tr td input { display:inline; margin-left:5px;}
.hovertab{ background:url('/media/zj/img/jp/sprite_btn13.png') no-repeat; width:80px; height:22px; text-align:center; color:#FFF; font-size:14px; font-weight:bold;}
.normaltab{background:url('/media/zj/img/jp/sprite_btn12.png') no-repeat; width:80px; height:22px; text-align:center; font-size:14px;}
.dis{display:block;}
.undis{ height:280px; display: none;}
.jp_btn{ text-align:center; line-height:35px; color:#FFF;}
.jp_btn input{ margin:8px 0;}
.jp_btn .dz{ line-height:24px; margin-right:10px; background:url(/media/zj/img/jp/kjsprite_btn.png) no-repeat scroll 0px 0px; height:22px; width:70px; color:#FFF; font-weight:bold; border:none;}
.jp_btn .cl{line-height:24px; margin-right:10px; background:url(/media/zj/img/jp/kjsprite_btn.png) no-repeat scroll -110px 0px; height:22px; width:70px; color: #F60; font-weight:bold; border:none;}

</style>
<script type="text/javascript">
<!--
	var uid=<?php echo $uid;?>;
	var uname = '<?php echo $uname?>';
//-->
</script>
<?php
echo html::script(array
(
	'media/zj/js/jquery-1.5.2.js',
	'media/js/yclass.js',
	'media/zj/js/base.js',
	'media/js/loginer',
	'media/zj/js/viewjp'
), FALSE);
echo html::stylesheet(array
(

    'media/lottnum/style/style',
	'media/lottnum/style/hxpublic'

    
), FALSE);
?>
</head>

<body style="background-image:none;">
<div style="width:525px;" >
     <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
        <h2>
<?php echo $site_config['site_title'];?>用户战绩
        </h2>
        <span class="close"><a href="javascript(void 0)" onclick="top.Y.closeUrl()">关闭</a></span>
        </div>
	    <div class="tips_info tips_info_np">
	    
	   

        	<div class="jp_m">
        	<div class="jp_t_title"><span class="span_l">用户 <span id="suid" class="rd"> </span>&nbsp;的总战绩
        	<!-- <span id="jpnum"></span>&nbsp;&nbsp;&nbsp;| 
        	<a href="/help/help_2_8.html" target=_blank>奖牌战绩规则</a>&nbsp;&nbsp;&nbsp;--> </span> <span class="span_r">
        	<input name="ss" id="ss1" type="radio" value="all" onclick='jpAwardClick("all")'/><label for="ss1">所有记录</label><input name="ss" id="ss2" type="radio" value="zj" onclick='jpAwardClick("zj")'/><label for="ss2">中奖记录</label></span>
			</div>
            <div class="jp_t_title" id="divgd" style="display:none;"><span class="span_l">自动跟单人数：<span id="gdnum" class="rd">0</span>人&nbsp;&nbsp;&nbsp;| 
        	<a href="javascript:void 0" class="btn_dot1" id="dzgd" target=_blank>我要定制</a></span></div>
            <div class="clear"></div>
            <div id="tb_" class="tb_">
               <ul style="">
                    <li id="tb_1"  class="hovertab" onclick="HoverLi(1);">足彩胜负</li>
                    <li id="tb_2"  class="normaltab" onclick="HoverLi(2);">体彩数字</li>
                    <li id="tb_3"  class="normaltab" onclick="HoverLi(3);">竞彩足球</li>
                    <li id="tb_4"  class="normaltab" onclick="HoverLi(4);">竞彩篮球</li>
					<li id="tb_5"  class="normaltab" onclick="HoverLi(5);">单场竞猜</li>
               </ul>
                 <div class="clear"></div>
            </div>
          
<div class="ctt">
<div class="dis" id="tbc_01">
<table width="100%" border="0" bgcolor="#FFFFFF" class="Myaccounttble1" cellpadding="0"  cellspacing="0">
   <tr>
    <td colspan="7"  style="padding-bottom:3px; text-align:left; padding-left:10px;">
    <input name="as" id="as1" type="radio" value="9" onclick="gameClick('9');"/><label for="as1">胜负彩</label>
    <input name="as" id="as2" type="radio" value="10" onclick="gameClick('10');"/><label for="as2">进球数</label>
    <input name="as" id="as3" type="radio" value="11" onclick="gameClick('11');"/><label for="as3">任选九</label>
    <input name="as" id="as4" type="radio" value="12" onclick="gameClick('12');"/><label for="as4">半全场</label>
    </td>
    </tr>
</table>
</div>
<div class="undis" id="tbc_02">
<table width="100%" border="0" bgcolor="#FFFFFF" class="Myaccounttble1" cellpadding="0"  cellspacing="0">
	<tr>
      <td colspan="7"  style="padding-bottom:3px; text-align:left; padding-left:10px;">
     
      <input name="as" id="as6" type="radio" value="18" onclick="gameClick('18');"/><label for="as6">大乐透</label>
      <input name="as" id="as9" type="radio" value="19" onclick="gameClick('19');"/><label for="as9">排列3</label>
      <input name="as" id="as10" type="radio" value="21" onclick="gameClick('21');"/><label for="as10">排列5</label>
      <input name="as" id="as11" type="radio" value="20" onclick="gameClick('20');"/><label for="as11">七星彩</label>
      </td>
    </tr>
</table>
</div>
<div class="dis" id="tbc_03">
<table width="100%" border="0" bgcolor="#FFFFFF" class="Myaccounttble1" cellpadding="0"  cellspacing="0">
	<tr>
      <td colspan="7"  style="padding-bottom:3px; text-align:left; padding-left:10px;">
      <input name="as" id="as12" type="radio" value="1" onclick="gameClick('1');"/><label for="as12">胜平负</label>
      <input name="as" id="as13" type="radio" value="2" onclick="gameClick('2');"/><label for="as13">进球数</label>
      <input name="as" id="as15" type="radio" value="3" onclick="gameClick('3');"/><label for="as15">比分</label>
      <input name="as" id="as16" type="radio" value="4" onclick="gameClick('4');"/><label for="as16">半全场</label>
      </td>
    </tr>
</table>
</div>
<div class="dis" id="tbc_04">
<table width="100%" border="0" bgcolor="#FFFFFF" class="Myaccounttble1" cellpadding="0"  cellspacing="0">
	<tr>
      <td colspan="7"  style="padding-bottom:3px; text-align:left; padding-left:10px;">
      <input name="as" id="as17" type="radio" value="5" onclick="gameClick('5');"/><label for="as17">胜负</label>
      <input name="as" id="as18" type="radio" value="6" onclick="gameClick('6');"/><label for="as18">让分胜负</label>
      <input name="as" id="as19" type="radio" value="7" onclick="gameClick('7');"/><label for="as19">胜分差</label>
      <input name="as" id="as20" type="radio" value="8" onclick="gameClick('8');"/><label for="as20">大小分</label>
      </td>
    </tr>
</table>
</div>

<div class="dis" id="tbc_05">
<table width="100%" border="0" bgcolor="#FFFFFF" class="Myaccounttble1" cellpadding="0"  cellspacing="0">
	<tr>
      <td colspan="7"  style="padding-bottom:3px; text-align:left; padding-left:10px;">
      <input name="as" id="as17" type="radio" value="13" onclick="gameClick('13');"/><label for="as17">让球胜平负</label>
      <input name="as" id="as18" type="radio" value="14" onclick="gameClick('14');"/><label for="as18">总进球数</label>
      <input name="as" id="as19" type="radio" value="15" onclick="gameClick('15');"/><label for="as19">上下单双</label>
      <input name="as" id="as20" type="radio" value="16" onclick="gameClick('16');"/><label for="as20">比分</label>
	  <input name="as" id="as20" type="radio" value="17" onclick="gameClick('17');"/><label for="as20">半全场</label>

      </td>
    </tr>
</table>
</div>
</div>
 

<div id="showdatalist">
<table width="100%" border="0" bgcolor="#FFFFFF"  cellpadding="0"  cellspacing="0">
  <tr align="center" class="d_tabletitle">
    <td width="60">期号</td>
    <td width="80">奖牌</td>
    <td width="80">方案编号</td>
    <td width="80">方案总金额</td>
    <td width="80">中奖金额</td>
    <td width="80">盈利金额</td>
    <td width="60">回报率</td>
  </tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td><td></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td></td></tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td><td></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td></td></tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td><td></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td></td></tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td><td></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td></td></tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td><td></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td></td></tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td><td></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td></td></tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td><td></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td></td></tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td><td></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td></td></tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td><td></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td></td></tr>
  <tr><td>&nbsp;</td><td>&nbsp;</td><td></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td style=" color:#F00"></td><td></td></tr>
    <tr align="left">
    <td colspan="7">总数<span class="red">1</span>页&nbsp;&nbsp;分页[<a>&lt;&lt;</a>]&nbsp;&nbsp;[<a>&lt;</a>]&nbsp;&nbsp;&nbsp;[&gt;]&nbsp;&nbsp;[&gt;&gt;]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="su_page"> 跳转至<select style="height:20px; border:1px solid #09C;"><option selected="" value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option></select></span>页</td>
    </tr>
</table>
</div>
</div>
</div>
	      <div class="tips_sbt"><p align="center" style="padding-left:24px">
         <input type="button" class="btn_Lora_b" value="关 闭" onclick="top.Y.closeUrl()"/>
      </div>
    </div>
  </div>
</div>
</body>
</html>



	

