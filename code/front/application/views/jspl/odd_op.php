<!DOCTYPE html PUBLIC "-//W3C//Dtd XHTML 1.0 transitional//EN" "http://www.w3.org/tr/xhtml1/Dtd/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>百家欧赔</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<style type="text/css">
.ggtypelist{
	padding:10px;
	line-height :25px;
}
.ggtypelist label{display:inline-block;width:30%;vertical-align:middle;white-space:nowrap;}
.ggtypelist input{margin-right:4px;vertical-align:middle;}
#button { padding: .5em 1em; text-decoration: none; }
#effect { width: 240px; height: 135px; padding: 0.4em; position: relative; }
#effect h3 { margin: 0; padding: 0.4em; text-align: center; }
</style>
<?php
echo html::script(array
(
	'media/js/jquery-1.6.2.min',
	'media/js/jquery-ui-1.8.16.custom.min',
	'media/js/jquery.cookie',
    //'media/js/jsbf.js?v=201110110',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/zc',
	'media/css/mask',
    'media/css/style',
    'media/css/css1',
	'media/css/jsbf',
	'media/css/jquery-ui-1.8.16.custom',
	'media/css/broad',
	//'media/css/odds',
), FALSE);
?>
</head>
<body>
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<!--<div class="width line36 gray68">您所在的位置：<a href="index.html"><font class="blue">首页</font></a> &gt; 竞彩足球</div>
--><!--面包屑导航_end-->
<span class="zhangkai"></span>
<div class="against">
	<div class="against_a">
		<!-- a href="" target="_blank"><img src="" alt="" class="a_logo"></a-->
		<img src="/media/images/team_logo/default.gif" alt="" class="a_logo" />
  <h2><a href="" target="_blank"><?=$match['home_name_chs']?></a></h2><p>当前排名:<?=$match['home_rank']?></p></div>
	<div class="against_m">
	  <p><a href="" target="_blank"><?=$match['match_name_chs']?></a><br>
		比赛时间：<?=$match['match_time']?><br />
		<?php if ($match['match_site'] != '') {?>比赛地点：<?=$match['match_site']?><br /><?php }?>
	  	<?php if ($match['crown_sp'] != '') {?>皇冠初盘：<?=$match['crown_sp']?><br /><?php }?>
	  	<?php if ($match['match_round'] != '') {?>轮次/分组名：<?=$match['match_round']?><br /><?php }?>
	  	<?php if ($match['match_season'] != '') {?>赛季：<?=$match['match_season']?><br /><?php }?>
	  	<?php if ($match['tv_live_channel'] != '') {?>电视直播频道：<?=$match['tv_live_channel']?><br /><?php }?>
	  </p>
	</div>
	<div class="against_b">
		<!-- a href="" target="_blank"><img src="" alt="" class="b_logo"></a-->
		<img src="/media/images/team_logo/default.gif" alt="" class="a_logo" />
  <h2><a href="" target="_blank"><?=$match['away_name_chs']?></a></h2><p>当前排名:<?=$match['away_rank']?></p></div>
</div><!--对阵板-->
<span class="zhangkai"></span>
<div class="width" style="padding-top:10px;">
<div id="jc_menu" class="font14 bold buy_rmenu">
<ul>
<li class="hover"><span><a href="/jspl/odd_op/<?=$match['match_id']?>">百家欧赔</a></span></li>
<li><span><a href="/jspl/odd_yp/<?=$match['match_id']?>">亚盘对比</a></span></li>
<li><span><a href="/jspl/odd_dx/<?=$match['match_id']?>">大小对比</a></span></li>
</ul>
</div>
</div>
<!--header end-->
<span class="zhangkai"></span>
<div id="bd">
<div class="toggler" id="toggler"></div>
  <div id="main" class="main_dc clearfix">
    <div class="danchang">
      <div class="box_top">
        <div class="box_top_l"></div>
        </div>
      <div class="box_m">
        <span class="zhangkai"></span>
        <div class="dangc_tit">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <!-- tr>
    <td>
<DIV class=ouzhi_radio>
<DIV id=radioleft class=radio_left><SPAN><label for=rg1><INPUT 
id=rg1 value=1 CHECKED type=radio name=RadioGroup1>全部公司</label></SPAN> 
<SPAN><label for=rg2><INPUT id=rg2 value=2 type=radio 
name=RadioGroup1>主流公司</label></SPAN> <SPAN><label for=rg3><INPUT id=rg3 value=3 
type=radio name=RadioGroup1>交易所</label></SPAN> <SPAN><label for=rg4><INPUT 
id=rg4 value=4 type=radio name=RadioGroup1>非交易所</label></SPAN> </DIV>
<DIV class=radio_right>共有[<SPAN 
style="PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px" 
id=nowcnum>200</SPAN>/200]家 <SPAN 
style="PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px" 
id=loadednum>已加载30家</SPAN> <A id=loadedall title=点击加载所有公司 
href="javascript:oddsLoadAll()">全部</A> <SELECT 
style="POSITION: relative; VERTICAL-ALIGN: middle; TOP: -1px" id=table_style 
onchange=(function(a){set_url_search({style:a})})(this.value)> <OPTION 
  selected value=0>赔率上下显示</OPTION> <OPTION value=1>赔率左右显示</OPTION></SELECT> <A 
id=downpl class=btn_Lblue_m title=赔率下载 
href="javascript:void(0);">赔率下载</A></DIV></DIV>

<div class="ouzhi_radio" style="WIDth: auto"><SPAN 
style="PADDING-LEFT: 20px; FLOAT: left"><A id=sx1 class=public_Lblue title=显示筛选公司 
href="javascript:void(0)"><B>保留选中</B></A> <A id=yc1 class=public_Lblue title=隐藏选中公司 
href="javascript:void(0)"><B>隐藏选中</B></A> <A id=qx1 class=public_Lblue title=显示全部公司 
href="javascript:void(0)"><B>显示全部</B></A> 
                             </SPAN>
                             <SPAN class=select_sp1><SELECT 
id=pltype> <OPTION selected value=1>所有欧赔</OPTION> <OPTION 
value=2>显示初盘</OPTION></SELECT> </SPAN><SPAN class=select_sp2><SELECT 
id=td_offset> <OPTION selected value=0>主胜赔率</OPTION> <OPTION 
  value=1>平局赔率</OPTION> <OPTION value=2>主负赔率</OPTION></SELECT>从最小<INPUT type=text 
class=fw id=plmin size="10">
                             --<INPUT type=text class=fw id=plmax size="10">
                             最大<INPUT id=search class="btn_Lblue" value=确定 type=button> 
 </SPAN>
 <a>
<DIV style="PADDING-LEFT: 10px; PADDING-right: 20px; FLOAT: right" class="fl">
<a id="customize_down" class="public_Lblue" title="赔率定制/显示分类" href="javascript:void(0)">
<b>赔率定制/显示分类</b>
</a>
<DIV id=customize_tip class=dz-tips>
<UL class=dz-t-list>
  <LI><A style="FONT-WEIGHT: bold" id=customize_new class=red 
  href="javascript:void(0)">新增修改定制&gt;&gt;</A></LI></UL>
<P style="TEXT-ALIGN: center; PADDING-BOTTOM: 15px"><A id=customize_up 
class=c_btn_b title=关闭 href="javascript:void(0)"><B>关闭</B></A></P></DIV></DIV></a>
</DIV>
</td>
    </tr-->
</table>
        </div>
      <div class="dc_l_m" id="vsTable">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="2%" height="15" colspan="2" bgcolor="#f6fbff" ><table width="100%" border="0.5" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="dc_table" id="datatb">
      <tbody>
          <TR class="cc_table th">
    <TH class="no-bl b-r" rowSpan=2>序号</TH>
    <TH class="cc_table t" rowSpan=2 width=240>欧赔公司</TH>
    <TH style="BORDER-BOTTOM-COLOR: #ffffff" colSpan=6>欧赔</TH>
    </TR>
  <TR  class="cc_table t ">
    <TH width=100><A>初盘主胜</A></TH>
    <TH width=100><A>初盘和局</A></TH>
    <TH width=100><A>初盘客胜</A></TH>
    <TH width=100><A>即时主胜</A></TH>
    <TH width=100><A>即时和局</A></TH>
    <TH width=100><A>即时客胜</A></TH>
    </TR>

<?php
$pl_count = count($pl);
for ($i = 0; $i < $pl_count; $i++) { 
?>
<TR id=tr_<?=$pl[$i]['company_id']?> ttl="sx1">
    <TD class="no-bl h_br" ><LABEL class=lab_c for=ck293><?=$i+1?>&nbsp;&nbsp;</LABEL></TD>
    <TD class=h_br ><A href=""><?=jspl::getCompanyName($pl[$i]['company_id'])?></A></TD>
    <TD class=h_br><?=$pl[$i]['first_home3_sp']?></TD>
    <TD class=h_br><?=$pl[$i]['first_home1_sp']?></TD>
    <TD class=h_br><?=$pl[$i]['first_home0_sp']?></TD>
    <TD class=h_br><?=$pl[$i]['js_home3_sp']?></TD>
    <TD class=h_br><?=$pl[$i]['js_home1_sp']?></TD>
    <TD class=h_br><?=$pl[$i]['js_home0_sp']?></TD>
    </TR>
<?php
} 
?>    
      </tbody>
    </table></td>
  </tr>
  
  <tr>
    <td height="15" colspan="2" bgcolor="#f6fbff"><div class="con_bottom">
<!-- div>
<a id="sx2" class="public_Lblue" href="javascript:void(0)" title="显示筛选公司">
<b>保留选中</b></a>
<a id="yc2" class="public_Lblue" href="javascript:void(0)" title="隐藏选中公司">
<b>隐藏选中</b></a>
<a id="qx2" class="public_Lblue" href="javascript:void(0)" title="显示全部公司">
<b>显示全部</b></a>
<a id="fx2" class="public_Lblue" href="javascript:void(0)" title="反选">
<b>反选</b></a></div-->
</div>
<div class="intro_bottom">共[<?=$pl_count?>]家欧赔公司，其中水位用红、绿颜色代表水位之升、降</div></td>
    </tr>
</table>
        </div>
      </div>
      <a style="left: 987px;" title="回到顶部" class="back_top" href="#top" hidefocus="true">回到顶部</a> </div>
  </div>
 
</div>
<!--提示层-->
  <!--footer start-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
 <!--footer end-->
<div id="ft">
<!--未登录提示层-->
 <?php echo View::factory('login')->render();?>
  <!--默认提示层-->
</div>
<div style="opacity: 0.2;" tabindex="-1" class="yclass_mask_panel"></div>
<div style="position: absolute; z-index: 500000; left: -99999px;">
  <div style="min-width: 120px; text-align: center; font: 12px/1.5 verdana; color: rgb(51, 51, 51);"></div>
  <div style="position: absolute; left: 0pt; top: 0pt; display: none; z-index: 9; width: 88%; height: 30px; background: none repeat scroll 0% 0% rgb(238, 238, 238); opacity: 0.1; cursor: move;"></div>
</div>
<div class="notifyicon tip-2">
  <div class="notifyicon_content"></div>
  <div class="notifyicon_arrow"><s></s><em></em></div>
  <div class="notifyicon_space"></div>
</div>
</body>
</html>