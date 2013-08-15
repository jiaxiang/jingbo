<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>亚盘对比</title>
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
	'media/css/odds',
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
		<!-- a href="" target="_blank"><img src="/media/images/weather/" alt="" class="a_logo"></a-->
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
<li><span><a href="/jspl/odd_op/<?=$match['match_id']?>">百家欧赔</a></span></li>
<li class="hover"><span><a href="/jspl/odd_yp/<?=$match['match_id']?>">亚盘对比</a></span></li>
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
  <tr>
    <td>
<div id="jc_menu" class="bold_laber">亚盘对比</div>    </td>
  </tr>
</table>
        </div>
        <div class="dc_l_m" id="vsTable">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="15" bgcolor="#f6fbff"><table class="dc_table" border="0" cellpadding="0" cellspacing="0" width="100%" id="datatb">
      <tbody>
        <tr>
          <th class="th_one"><label>序号</label></th>
          <th>公司</th>
          <th width="55">水位</th>
          <th width="120">即时</th>
          <th width="55">水位</th>
          <th>变化时间</th>
          <th width="55">水位</th>
          <th width="90">初盘</th>
          <th width="55">水位</th>
          <th>时间</th>
        </tr>
        <?php
        $pl_count = count($pl);
        for ($i = 0; $i < $pl_count; $i++) {
        ?>
        <tr id="<?=$pl[$i]['company_id']?>">
          <td class="td_one"><?=$i+1?><!-- input name="input" type="checkbox" value="ck5" checked="checked" /--></td>
          <td><?=jspl::getCompanyName($pl[$i]['company_id'])?><!-- img src="images/oz_zhu.gif" alt="1" style="margin-left:5px;" /--></td>
          <td class="red_up"><span id="ying<?=$pl[$i]['company_id']?>"><?=$pl[$i]['home_js_sp']?></span></td>
          <td style="cursor:pointer"><?=jspl::getGoalName($pl[$i]['js_pk'])?></td>
          <td class="green_down"><span id="green<?=$pl[$i]['company_id']?>"><?=$pl[$i]['away_js_sp']?></span></td>
          <td><?=$pl[$i]['time']?></td>
          <td><?=$pl[$i]['home_first_sp']?></td>
          <td ref="<?=$pl[$i]['first_pk']?>"><?=jspl::getGoalName($pl[$i]['first_pk'])?></td>
          <td><?=$pl[$i]['away_first_sp']?></td>
          <td><?=$pl[$i]['time']?></td>
        </tr>
        <?php
        }
        ?>
        <tr class="tr3">
          <td colspan="2" bgcolor="#FFFFCC">最大值</td>
          <td bgcolor="#FFFFCC" id="maxes1"><?=$home_js_sp_max['home_js_sp']?></td>
          <td bgcolor="#FFFFCC" id="maxeh"><?=jspl::getGoalName($js_pk_max['js_pk'])?></td>
          <td bgcolor="#FFFFCC" id="maxes2"><?=$away_js_sp_max['away_js_sp']?></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
          <td bgcolor="#FFFFCC" id="maxfs1"><?=$home_first_sp_max['home_first_sp']?></td>
          <td bgcolor="#FFFFCC" id="maxfh"><?=jspl::getGoalName($first_pk_max['first_pk'])?></td>
          <td bgcolor="#FFFFCC" id="maxfs2"><?=$away_first_sp_max['away_first_sp']?></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
        <tr class="tr3">
          <td colspan="2" bgcolor="#FFFFCC">最小值</td>
          <td bgcolor="#FFFFCC" id="mines1"><?=$home_js_sp_min['home_js_sp']?></td>
          <td bgcolor="#FFFFCC" id="mineh"><?=jspl::getGoalName($js_pk_min['js_pk'])?></td>
          <td bgcolor="#FFFFCC" id="mines2"><?=$away_js_sp_min['away_js_sp']?></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
          <td bgcolor="#FFFFCC" id="minfs1"><?=$home_first_sp_min['home_first_sp']?></td>
          <td bgcolor="#FFFFCC" id="minfh"><?=jspl::getGoalName($first_pk_min['first_pk'])?></td>
          <td bgcolor="#FFFFCC" id="minfs2"><?=$away_first_sp_min['away_first_sp']?></td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
          <td bgcolor="#FFFFCC">&nbsp;</td>
        </tr>
      </tbody>
    </table></td>
  </tr>
  <!-- tr>
    <td bgcolor="#f6fbff"><div class="con_bottom">
      <div class="f12">
        <div align="center" ><a href="javascript:void(0);" title="显示筛选公司" class="public_Lblue" id="xs2"><b>显示筛选公司</b></a> <a href="javascript:void(0);" title="显示全部公司" class="public_Lblue" id="all2"><b>显示全部公司</b></a></div>
      </div>
    </div></td>
    </tr-->
  <tr>
    <td height="15" bgcolor="#f6fbff"><div class="intro_bottom f12">
                <div align="center">共[<?=$pl_count?>]家亚洲指数公司，水位用红、绿颜色代表水位之升、降 </div>
              </div></td>
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