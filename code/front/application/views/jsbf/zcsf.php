<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-即时比分-足彩胜负</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
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
    'media/js/jsbf',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/zc',
	'media/css/mask',
    'media/css/style',
    'media/css/css1',
	'media/css/jsbf',
	'media/css/jquery-ui-1.8.16.custom',
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
<div class="width" style="padding-top:10px;">
<div id="jc_menu" class="font14 bold buy_rmenu">
<ul>
<li><span><a href="/jsbf/all">所有比分</a></span></li>
<li><span><a href="/jsbf/bjdc">单场比分</a></span></li>
<li class="hover"><span><a href="/jsbf/zcsf">足彩比分</a></span></li>
<li><span><a href="/jsbf/jczq">竞彩比分</a></span></li>
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
        <a name="top"></a> </div>
      <div class="box_m">
        <span class="zhangkai"></span>
        <div class="dangc_tit jc_l_t">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="60%"><table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%" height="30" align=center valign="middle" class="font14 bold">设置</td>
        <td width="40%" height="30" align="left" valign="middle">
<input type="checkbox" id="sound_op" onclick="set_sound()" />进球声音&nbsp;&nbsp;&nbsp;
<input type="checkbox" id="open_op" onclick="set_open()"/>进球提示
        </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="99%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        
      </tr>
    </table></td>
  </tr>
</table></td>
    <td width="40%"><div style="width:490px; text-align:right; " class="blue font14 bold">
    </div></td>
  </tr>
</table>
        </div>
        <div class="dc_l_m" id="vsTable">
          <table class="dc_table" border="0" cellpadding="0" cellspacing="0" width="100%">
            <colgroup>
            <col width="8%">
            <col width="8%">
            <col width="12%">
            <col width="5%">
            <col width="20%">
            <col width="10%">
            <col width="20%">
            <col width="8%">
            <col width="9%">
            </colgroup>
            <tbody>
              <tr>
                <th>序号</th>
                <th>名称</th>
                <th>开场时间</th>
                <th>状态</th>
                <th>主队</th>
                <th>比分</th>
                <th>客队</th>
                <th>半场</th>
                <th class="last_th">数据</th>
              </tr>
            </tbody>
          </table>
          <table class="dc_table" id="d_2011-06-25" border="0" cellpadding="0" cellspacing="0" width="100%">
            <colgroup>
            <col width="8%">
            <col width="8%">
            <col width="12%">
            <col width="5%">
            <col width="20%">
            <col width="10%">
            <col width="20%">
            <col width="8%">
            <col width="9%">
            </colgroup>
            <tbody>
<?php
for ($i = 0; $i < count($data); $i++) { 
?>
<tr>
<td style="cursor: pointer;"><label><?php echo $data[$i]['week'].' '.($i+1);?></label></td>
<td style="background: none repeat scroll 0% 0% <?=$data[$i]['color']?>; color: rgb(255, 255, 255);" class="league"><a href="javascript:;"><?=$data[$i]['match_name_chs']?></a></td>
<td class="h_br"><span class="eng end_time" title="开场时间：<?=$data[$i]['match_open_time']?>" id="match_open_time_<?=$data[$i]['id']?>"><?=substr($data[$i]['match_open_time'], 5, 11)?></span></td>
<td class="h_br"><span style="color:<?=jsbf::$status_color[$data[$i]['match_status']]?>" id="match_status_<?=$data[$i]['id']?>"><?=jsbf::$status_name[$data[$i]['match_status']]?> <?=jsbf::getTimeStatus($data[$i]['match_open_time'], $data[$i]['match_status'])?><?php if ($data[$i]['match_ing_gif'] != '') echo $data[$i]['match_ing_gif']; ?></span></td>
<td class="h_br"><span class="gray">[<?=$data[$i]['home_rank']?>]</span><span id="home_red_card_<?=$data[$i]['id']?>"><?php if ( $data[$i]['home_red_card'] > 0) echo '<span class="redcard">'.$data[$i]['home_red_card'].'</span>';?></span><span id="home_yellow_card_<?=$data[$i]['id']?>"><?php if ( $data[$i]['home_yellow_card'] > 0) echo '<span class="yellowcard">'.$data[$i]['home_yellow_card'].'</span>';?></span><?=$data[$i]['home_name_chs']?></td>
<td class="h_br"><a href="javascript:;" <?php if ($data[$i]['match_status'] == '1' || $data[$i]['match_status'] == '2' || $data[$i]['match_status'] == '3' || $data[$i]['match_status'] == '-1') echo 'title="比赛事件" onclick="showEvent('.$data[$i]['match_id'].')"';?>><span <?php if ($data[$i]['match_status'] == '1' || $data[$i]['match_status'] == '2' || $data[$i]['match_status'] == '3' || $data[$i]['match_status'] == '-1') echo 'style="color:#FF0000;font-size:14px;font-weight:bold"';?> id="home_score_<?=$data[$i]['id']?>"><?=$data[$i]['home_score']?></span> : <span <?php if ($data[$i]['match_status'] == '1' || $data[$i]['match_status'] == '2' || $data[$i]['match_status'] == '3' || $data[$i]['match_status'] == '-1') echo 'style="color:#FF0000;font-size:14px;font-weight:bold"';?> id="away_score_<?=$data[$i]['id']?>"><?=$data[$i]['away_score']?></span></a></td>
<td class="h_br"><?=$data[$i]['away_name_chs']?><span id="away_red_card_<?=$data[$i]['id']?>"><?php if ( $data[$i]['away_red_card'] > 0) echo '<span class="redcard">'.$data[$i]['away_red_card'].'</span>';?></span><span id="away_yellow_card_<?=$data[$i]['id']?>"><?php if ( $data[$i]['away_yellow_card'] > 0) echo '<span class="yellowcard">'.$data[$i]['away_yellow_card'].'</span>';?></span><span class="gray">[<?=$data[$i]['away_rank']?>]</span></td>
<td class="h_br"><span id="home_first_half_score_<?=$data[$i]['id']?>"><?=$data[$i]['home_first_half_score']?></span> : <span id="away_first_half_score_<?=$data[$i]['id']?>"><?=$data[$i]['away_first_half_score']?></span></td>
<td class="h_br" >--</td>
</tr>
<?php
} 
?>
            </tbody>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="15" colspan="3" bgcolor="#f6fbff"></td>
    </tr>
  <tr>
    <td width="2%" bgcolor="#f6fbff">&nbsp;</td>
    <td width="96%" bgcolor="#f6fbff"></td>
    <td width="2%" bgcolor="#f6fbff">&nbsp;</td>
  </tr>
  <tr>
    <td height="15" colspan="3" bgcolor="#f6fbff"></td>
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