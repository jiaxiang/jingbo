<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-竞彩足球-比分</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
    'media/js/yclass.js?v=201110110',
	'media/js/tabs',
	'media/js/loginer',
	'media/js/detail.js?v=201110110',
	'media/js/jczq.js?v=201110110',
	'media/js/predict',
	//url::base().'xml/jczq/xml_3_2/load.js',
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
<body>
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>jczq/rqspf"><font class="blue">竞彩足球</font></a> &gt; 比分
	</div>
	<div style="float:right; margin-right:20px;">
		<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
	</div>
	<div style="clear:both;"></div>
</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width jingcai_box">
	<div class="fl" id="jingcai_top">
    	<span class="fl" id="jctop_left"><img src="<?php echo url::base();?>media/images/jczq.gif" width="76" height="63" /></span>
        <div class="fl" id="jctop_right">
       	  <p id="jctop_rheight"><span class="fr gray6">销售时间：周一至周五 09:00～23:40  周六至周日 09:00～00:40</span><font class="font16 black heiti">返奖率高达</font><font class="font24 orange heiti">69%，</font><font class="font16 black heiti">过关固定奖金</font></p>
      <div id="jc_menu" class="font14 bold">
            	<ul>
                	<li <?php if(!empty($play_type) && $play_type ==1) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jczq/rqspf"><span>让球胜平负</span></a></li>
                    <li <?php if(!empty($play_type) && $play_type ==2) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jczq/zjqs"><span>总进球数</span></a></li>
                    <li <?php if(!empty($play_type) && $play_type ==3) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jczq/bf"><span>比分</span></a></li>
                    <li <?php if(!empty($play_type) && $play_type ==4) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jczq/bqc"><span>半全场</span></a></li>
                    <li <?php if(!empty($play_type) && $play_type ==5) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jczq/my"><span>我的方案</span></a></li>
                </ul>
          </div>
        </div>
    </div>
     <div id="jingcai_bottom" class="fl"><span class="fr pt5 mr10"><a href="<?php echo url::base();?>buycenter/jczq"><img src="<?php echo url::base();?>media/images/btn3.gif" width="85" height="22" alt="参与合买" /></a></span></div>
    <span class="zhangkai"></span>	
</div>
<!--content1 end-->
<!--header end-->
<div id="bd">

  <div id="main" class="main_dc clearfix">
    <div class="dc_l">
      <div class="box_top">
        <div class="box_top_l"></div>
        <a name="top"></a> </div>
      <div class="box_m">
        <div class="dc_l_t jc_l_t">
          <div class="dc_l_tl"> <span class="mie7">
            <label for="ck1">
            <input checked="checked" id="ck1" type="checkbox">
            让球</label>
            <label for="ck2">
            <input checked="checked" id="ck2" type="checkbox">
            非让球</label>
            <label for="ck3">
            <input id="ck3" type="checkbox">
            已截止(<?php echo $match_end;?>场)</label>
            已隐藏 <span class="red eng" id="hide_count">0</span> 场赛事 <a href="javascript:void%200" id="showAll_btn">恢复</a> 
            
            <?php
            /**
			?>
            <span style="margin-left:80px;">赛事回查</span>&nbsp;
            <select id="seldate" style="font-size:12px;width:85px;">
            
            <?php
            for($i = 0; $i<=6; $i++)
			{
				$time = date("Y-m-d", time()-$i*24*60*60);
				echo '<option value="'.$time.'">'.$time.'</option>'."\n";
			}
			?>

            </select>
            </span>
            <?php
			**/
			?>
            
            </div>
          
          
        <?php
        /**/
		?>  
		<div class="dc_l_tr">
            <div class="dc_ls_w">
              <div class="dc_ls_n" style="display:none;" id="listMenu">
                <ul class="clearfix" id="lgList">
                <?php
                foreach ($matchnames as $rowname) {
				?>
                  <li>
                    <input id="lg<?php echo $rowname;?>" m="<?php echo $rowname;?>" checked="checked" type="checkbox">
                    <label for="lg<?php echo $rowname;?>"><?php echo $rowname;?></label>
                  </li>
                <?php
                }
				?>  
                </ul>
                <div class="ls_n_b"><a href="javascript:void%200" class="btn_Lblue_s" id="selectAllBtn">全选</a><a href="javascript:void%200" class="btn_Lblue_s" id="selectOppBtn">反选</a></div>
              </div>
              <a href="javascript:void%200" class="ls_s_btn" id="listDisplay">联赛选择</a> </div>
          </div>  
		  
          <?php
		  /**/
		  ?>
          
        </div>
        <div class="dc_l_m" id="vsTable">
        
        
          <table class="dc_table" border="0" cellpadding="0" cellspacing="0" width="100%">
            <colgroup>
            <col width="70">
            <col width="80">
            <col width="50">
            <col width="86">
            <col width="86">
            <!--col width="115"-->
            <col width="74">
            <col width="186">
            </colgroup>
            <tbody>
              <tr>
                <th>赛事编号</th>
                <th>赛事类型</th>
                <th><select id="select_time">
                    <option selected="selected" value="0">截止</option>
                    <option value="1">开赛</option>
                  </select></th>
                <th>主队</th>
                <th>客队</th>
                <!--th><select id="select_pv" size="1">
                    <option selected="selected" value="0">平均赔率</option>
                    <option value="1">投注比例</option>
                  </select></th-->
                <th> </th>
                <th class="last_th">选择投注</th>
              </tr>
            </tbody>
          </table>
<div class="left_overflow"> 
<?php
$ii = 0;
foreach ($groups as $groupkey => $groupvalue)
{

?>
          <div class="dc_hs"> <strong><?php echo $groups_date[$groupkey];?> <?php echo tool::get_weekday($groups_date[$groupkey]);?> <?php echo count($groupvalue);?>场比赛可投注</strong> <a href="javascript:void%200">隐藏<s class="c_up"></s></a> </div>
          <table class="dc_table" id="d_<?php echo $groupkey;?>" border="0" cellpadding="0" cellspacing="0" width="720">
            <colgroup>
            <col width="71">
            <col width="81">
            <col width="51">
            <col width="85">
            <col width="85">
            <!--col width="116"-->
            <col width="75">
            <col width="166">	
            </colgroup>
            <tbody>
	<?php 
    $i = 0;
	$tmp = array();
	//d($groupvalue);
    foreach ($groupvalue as $row) 
    {
		$ii++;
        $rowstyle = '';
		
        if ($i % 2==0) 
        {
            $rowstyle = 'even';
        } 
        $i++;
        
        $row['comb'] = json_decode($row['comb']);
		
		$comb_show = array();
		$comb_show[] = $row['comb']->{'1A'}->{'v'};
		$comb_show[] = $row['comb']->{'10'}->{'v'};
		$comb_show[] = $row['comb']->{'20'}->{'v'};
		$comb_show[] = $row['comb']->{'21'}->{'v'};
		$comb_show[] = $row['comb']->{'30'}->{'v'};
		$comb_show[] = $row['comb']->{'31'}->{'v'};
		$comb_show[] = $row['comb']->{'32'}->{'v'};
		$comb_show[] = $row['comb']->{'40'}->{'v'};
		$comb_show[] = $row['comb']->{'41'}->{'v'};
		$comb_show[] = $row['comb']->{'42'}->{'v'};
		$comb_show[] = $row['comb']->{'50'}->{'v'};
		$comb_show[] = $row['comb']->{'51'}->{'v'};
		$comb_show[] = $row['comb']->{'52'}->{'v'};
		$comb_show[] = $row['comb']->{'3A'}->{'v'};
		$comb_show[] = $row['comb']->{'00'}->{'v'};
		$comb_show[] = $row['comb']->{'11'}->{'v'};
		$comb_show[] = $row['comb']->{'22'}->{'v'};
		$comb_show[] = $row['comb']->{'33'}->{'v'};
		$comb_show[] = $row['comb']->{'0A'}->{'v'};
		$comb_show[] = $row['comb']->{'01'}->{'v'};
		$comb_show[] = $row['comb']->{'02'}->{'v'};
		$comb_show[] = $row['comb']->{'12'}->{'v'};
		$comb_show[] = $row['comb']->{'03'}->{'v'};
		$comb_show[] = $row['comb']->{'13'}->{'v'};
		$comb_show[] = $row['comb']->{'23'}->{'v'};
		$comb_show[] = $row['comb']->{'04'}->{'v'};
		$comb_show[] = $row['comb']->{'14'}->{'v'};
		$comb_show[] = $row['comb']->{'24'}->{'v'};
		$comb_show[] = $row['comb']->{'05'}->{'v'};
		$comb_show[] = $row['comb']->{'15'}->{'v'};
		$comb_show[] = $row['comb']->{'25'}->{'v'};
    ?> 
<tr class="<?php echo $rowstyle;?>" zid="<?php echo $row['id'];?>" mid="<?php echo $row['index_id'];?>" pname="<?php echo $row['match_num'];?>" pdate="<?php echo $row['match_num'];?>" lg="<?php echo $row['league'];?>" rq="<?php echo intval($row['goalline']);?>" pendtime="<?php echo date('Y-m-d H:i:s', strtotime($row['time_beg']));?>" odds="<?php echo implode(',', $comb_show);?>" isend="<?php echo $row['match_end']; ?>">
<td style="cursor: pointer;">
<label for="m<?php echo $row['id'];?>"><input name="m<?php echo $row['id'];?>" id="m<?php echo $row['id'];?>" value="<?php echo $row['id'];?>" checked="checked" type="checkbox"><?php echo $row['match_info'];?></label>
</td>
<td style="background: none repeat scroll 0% 0% <?php echo $row['color'];?>; color: rgb(255, 255, 255);" class="league"><a href="<?php echo $row['match_url'];?>" target="_blank"><?php echo $row['league'];?></a></td>
<td><span class="eng end_time" title="开赛时间：<?php echo date('Y-m-d H:i', strtotime($row['time_beg']));?>"><?php echo date('H:i', strtotime($row['time_end']));?></span> 
<span class="eng match_time" title="截止时间：<?php echo date('Y-m-d H:i', strtotime($row['time_end']));?>" style="display:none"><?php echo date('H:i', strtotime($row['time_beg']));?></span> </td>
<td><!--span class="gray">[11]</span-->
<?php if (isset($row['host_rank']) && $row['host_rank'] != null) echo '<font color="gray">['.$row['host_rank'].']</font>';?><a href="<?php echo !empty($row['host_url']) ? $row['host_url'] : '#';?>" title="<?php echo $row['host_name'];?>" target="_blank"><?php echo $row['host_name'];?></a>
</td>
<td>
<a href="<?php echo !empty($row['guest_url']) ? $row['guest_url'] : '#';?>" title="<?php echo $row['guest_name'];?>"  target="_blank"><?php echo $row['guest_name'];?></a><?php if (isset($row['guest_rank']) && $row['guest_rank'] != null) echo '<font color="gray">['.$row['guest_rank'].']</font>';?>
<!--span class="gray">[4]</span-->
</td><!-- 平均赔率/投注比例 -->
<!--td>
<div class="pjpl"><span class="sp_w35 eng">2.79</span><span class="sp_w35 eng">3.18</span><span class="sp_w35 eng">2.31</span></div>
<div class="tzbl" style="display:none"><span class="sp_w35 eng">--</span><span class="sp_w35 eng">--</span><span class="sp_w35 eng">--</span></div></td-->
<td><!-- 比分/析亚欧 -->
  <a href="http://info.sporttery.cn/football/info/fb_match_hhad.php?m=<?php echo $row['match_id'];?>" target="_blank">奖</a> 
  <a href="http://info.sporttery.cn/football/info/fb_match_news.php?m=<?php echo $row['match_id'];?>&s=fb" target="_blank">讯</a> 
  <a href="http://info.sporttery.cn/football/search_odds.php?mid=<?php echo $row['match_id'];?>" target="_blank">同</a> 
</td>
<td><a href="javascript:void%200" class="<?php if($ii > 1){echo 'public_Lblue bf_btn';}else{echo 'public_Dora bf_btn';}?>"><b><span><?php if($ii > 1){echo '展开选项';}else{echo '隐藏选项';}?></span><s class="<?php if($ii>1){echo 'c_down';}else echo 'c_up';?>"></s></b></a> </td>
</tr>
<tr class="hide_b" id="pltr_45000" style="<?php if($ii>1){echo 'display: none;';}?>">
<td colspan="10"><table class="hide_table" border="0" cellpadding="0" cellspacing="0" width="100%">
<colgroup>
<col width="10%">
<col width="7%">
<col width="7%">
<col width="7%">
<col width="7%">
<col width="7%">
<col width="7%">
<col width="7%">
<col width="7%">
<col width="7%">
<col width="7%">
<col width="7%">
<col width="7%">
<col width="">
</colgroup>
<tbody>
  <tr class="sheng">

    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="3A" type="checkbox"><?php }?>
      <span class="eng f_bf">胜其它</span><br>
      <span><?php echo $comb_show[0];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="10" type="checkbox"><?php }?>
      <span class="eng f_bf">1:0</span><br>
      <span><?php echo $comb_show[1];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="20" type="checkbox"><?php }?>
      <span class="eng f_bf">2:0</span><br>
      <span><?php echo $comb_show[2];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="21" type="checkbox"><?php }?>
      <span class="eng f_bf">2:1</span><br>
      <span><?php echo $comb_show[3];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="30" type="checkbox"><?php }?>
      <span class="eng f_bf">3:0</span><br>
      <span><?php echo $comb_show[4];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="31" type="checkbox"><?php }?>
      <span class="eng f_bf">3:1</span><br>
      <span><?php echo $comb_show[5];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="32" type="checkbox"><?php }?>
      <span class="eng f_bf">3:2</span><br>
      <span><?php echo $comb_show[6];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="40" type="checkbox"><?php }?>
      <span class="eng f_bf">4:0</span><br>
      <span><?php echo $comb_show[7];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="41" type="checkbox"><?php }?>
      <span class="eng f_bf">4:1</span><br>
      <span><?php echo $comb_show[8];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="42" type="checkbox"><?php }?>
      <span class="eng f_bf">4:2</span><br>
      <span><?php echo $comb_show[9];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="50" type="checkbox"><?php }?>
      <span class="eng f_bf">5:0</span><br>
      <span><?php echo $comb_show[10];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="51" type="checkbox"><?php }?>
      <span class="eng f_bf">5:1</span><br>
      <span><?php echo $comb_show[11];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="52" type="checkbox"><?php }?>
      <span class="eng f_bf">5:2</span><br>
      <span><?php echo $comb_show[12];?></span></label>
    </td>
  </tr>
  <tr class="ping">
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="1A" type="checkbox"><?php }?>
      <span class="eng f_bf">平其它</span><br>
      <span><?php echo $comb_show[13];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="00" type="checkbox"><?php }?>
      <span class="eng f_bf">0:0</span><br>
      <span><?php echo $comb_show[14];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="11" type="checkbox"><?php }?>
      <span class="eng f_bf">1:1</span><br>
      <span><?php echo $comb_show[15];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="22" type="checkbox"><?php }?>
      <span class="eng f_bf">2:2</span><br>
      <span><?php echo $comb_show[16];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="33" type="checkbox"><?php }?>
      <span class="eng f_bf">3:3</span><br>
      <span><?php echo $comb_show[17];?></span></label>
    </td>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr class="fu">
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
     <?php if($row['match_end']==0) {?><input class="chbox" value="0A" type="checkbox"><?php }?>
      <span class="eng f_bf">负其它</span><br>
      <span><?php echo $comb_show[18];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="01" type="checkbox"><?php }?>
      <span class="eng f_bf">0:1</span><br>
      <span><?php echo $comb_show[19];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="02" type="checkbox"><?php }?>
      <span class="eng f_bf">0:2</span><br>
      <span><?php echo $comb_show[20];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="12" type="checkbox"><?php }?>
      <span class="eng f_bf">1:2</span><br>
      <span><?php echo $comb_show[21];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="03" type="checkbox"><?php }?>
      <span class="eng f_bf">0:3</span><br>
      <span><?php echo $comb_show[22];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="13" type="checkbox"><?php }?>
      <span class="eng f_bf">1:3</span><br>
      <span><?php echo $comb_show[23];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="23" type="checkbox"><?php }?>
      <span class="eng f_bf">2:3</span><br>
      <span><?php echo $comb_show[24];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="04" type="checkbox"><?php }?>
      <span class="eng f_bf">0:4</span><br>
      <span><?php echo $comb_show[25];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="14" type="checkbox"><?php }?>
      <span class="eng f_bf">1:4</span><br>
      <span><?php echo $comb_show[26];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="24" type="checkbox"><?php }?>
      <span class="eng f_bf">2:4</span><br>
      <span><?php echo $comb_show[27];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="05" type="checkbox"><?php }?>
      <span class="eng f_bf">0:5</span><br>
      <span><?php echo $comb_show[28];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="15" type="checkbox"><?php }?>
      <span class="eng f_bf">1:5</span><br>
      <span><?php echo $comb_show[29];?></span></label>
    </td>
    <td style="cursor: pointer;"><label for="sheng1" class="eng">
      <?php if($row['match_end']==0) {?><input class="chbox" value="25" type="checkbox"><?php }?>
      <span class="eng f_bf">2:5</span><br>
      <span><?php echo $comb_show[30];?></span></label>
    </td>
  </tr>
</tbody>
</table></td>
</tr> 
 
    
    <?php
    }
    ?>

	</tbody>
</table>

<?php
}
?>
</div>

            </tbody>
          </table>
        </div>
      </div>
      <a style="left: 987px;" title="回到顶部" class="back_top" href="#top" hidefocus="true">回到顶部</a> </div>
      
      
      
    <div class="dc_r">
      <div class="box_top">
        <div class="box_top_l"></div>
      </div>
      <div class="box_m">
        <div class="dc_r_t">方案截止时间：<span class="eng red" id="end_time"></span></div>
        <div class="dc_r_m">
          <h2>1、确认投注信息</h2>
          <table class="dcr_table" border="0" cellpadding="0" cellspacing="0" width="100%">
            <colgroup>
            <col width="32%">
            <col>
            <col width="12%">
            </colgroup>
            <tbody>
              <tr>
                <th>编号</th>
                <th>比赛</th>
                <th>胆</th>
              </tr>
              <tr class="even" style="display: none;" id="choose_tpl">
                <td><input checked="checked" class="chbox" view="1" type="checkbox">
                  <span class="gray"></span></td>
                <td class="tl">切尔西西<span class="sp_vs">VS</span>切尔西</td>
                <td><span>
                  <input class="chbox" dan="1" type="checkbox">
                  </span></td>
              </tr>
              <tr id="choose_tpl2" style="display: none;">
                <td class="tl" colspan="3"><span data-sg="3A" class="x_sz">胜其它</span><span data-sg="10" class="x_sz">1:0</span><span data-sg="20" class="x_sz">2:0</span><span data-sg="21" class="x_sz">2:1</span><span data-sg="30" class="x_sz">3:0</span><span data-sg="31" class="x_sz">3:1</span><span data-sg="32" class="x_sz">3:2</span><span data-sg="40" class="x_sz">4:0</span><span data-sg="41" class="x_sz">4:1</span><span data-sg="42" class="x_sz">4:2</span><span data-sg="50" class="x_sz">5:0</span><span data-sg="51" class="x_sz">5:1</span><span data-sg="52" class="x_sz">5:2</span><span data-sg="1A" class="x_sz">平其它</span><span data-sg="00" class="x_sz">0:0</span><span data-sg="11" class="x_sz">1:1</span><span data-sg="22" class="x_sz">2:2</span><span data-sg="33" class="x_sz">3:3</span><span data-sg="0A" class="x_sz">负其它</span><span data-sg="01" class="x_sz">0:1</span><span data-sg="02" class="x_sz">0:2</span><span data-sg="12" class="x_sz">1:2</span><span data-sg="03" class="x_sz">0:3</span><span data-sg="13" class="x_sz">1:3</span><span data-sg="23" class="x_sz">2:3</span><span data-sg="04" class="x_sz">0:4</span><span data-sg="14" class="x_sz">1:4</span><span data-sg="24" class="x_sz">2:4</span><span data-sg="05" class="x_sz">0:5</span><span data-sg="15" class="x_sz">1:5</span><span data-sg="25" class="x_sz">2:5</span></td>
              </tr>
            </tbody>
            <tbody id="choose_list">
            </tbody>
          </table>
        </div>
        <div class="dc_r_m">
          <h2>2、选择过关类型</h2>
          <div class="an_title">
            <ul id="ggTabsNav">
              <li id="a1" class="an_cur">自由过关</li>
              <li id="a2">多串过关</li>
            </ul>
          </div>
          <div id="ggListFree" class="ggtypelist clearfix">
            <label style="display:none;" for="r2c1">
            <input name="ggtype_checkbox" id="r2c1" value="2串1" type="checkbox">
            2串1</label>
            <label style="display:none;" for="r3c1">
            <input name="ggtype_checkbox" id="r3c1" value="3串1" type="checkbox">
            3串1</label>
            <label style="display:none;" for="r4c1">
            <input name="ggtype_checkbox" id="r4c1" value="4串1" type="checkbox">
            4串1</label>
            <label style="display:none;" for="r5c1">
            <input name="ggtype_checkbox" id="r5c1" value="5串1" type="checkbox">
            5串1</label>
            <label style="display:none;" for="r6c1">
            <input name="ggtype_checkbox" id="r6c1" value="6串1" type="checkbox">
            6串1</label>
          </div>
        </div>
        <div id="ggList" class="ggtypelist clearfix" style="display:none">
          <label style="display:none;" for="r3c3">
          <input name="ggtype_radio" id="r3c3" value="3串3" type="radio">
          3串3</label>
          <label style="display:none;" for="r3c4">
          <input name="ggtype_radio" id="r3c4" value="3串4" type="radio">
          3串4</label>
          <label style="display:none;" for="r4c4">
          <input name="ggtype_radio" id="r4c4" value="4串4" type="radio">
          4串4</label>
          <label style="display:none;" for="r4c5">
          <input name="ggtype_radio" id="r4c5" value="4串5" type="radio">
          4串5</label>
          <label style="display:none;" for="r4c6">
          <input name="ggtype_radio" id="r4c6" value="4串6" type="radio">
          4串6</label>
          <label style="display:none;" for="r4c11">
          <input name="ggtype_radio" id="r4c11" value="4串11" type="radio">
          4串11</label>
          <label style="display:none;" for="r5c5">
          <input name="ggtype_radio" id="r5c5" value="5串5" type="radio">
          5串5</label>
          <label style="display:none;" for="r5c6">
          <input name="ggtype_radio" id="r5c6" value="5串6" type="radio">
          5串6</label>
          <label style="display:none;" for="r5c10">
          <input name="ggtype_radio" id="r5c10" value="5串10" type="radio">
          5串10</label>
          <label style="display:none;" for="r5c16">
          <input name="ggtype_radio" id="r5c16" value="5串16" type="radio">
          5串16</label>
          <label style="display:none;" for="r5c20">
          <input name="ggtype_radio" id="r5c20" value="5串20" type="radio">
          5串20</label>
          <label style="display:none;" for="r5c26">
          <input name="ggtype_radio" id="r5c26" value="5串26" type="radio">
          5串26</label>
          <label style="display:none;" for="r6c6">
          <input name="ggtype_radio" id="r6c6" value="6串6" type="radio">
          6串6</label>
          <label style="display:none;" for="r6c7">
          <input name="ggtype_radio" id="r6c7" value="6串7" type="radio">
          6串7</label>
          <label style="display:none;" for="r6c15">
          <input name="ggtype_radio" id="r6c15" value="6串15" type="radio">
          6串15</label>
          <label style="display:none;" for="r6c20">
          <input name="ggtype_radio" id="r6c20" value="6串20" type="radio">
          6串20</label>
          <label style="display:none;" for="r6c22">
          <input name="ggtype_radio" id="r6c22" value="6串22" type="radio">
          6串22</label>
          <label style="display:none;" for="r6c35">
          <input name="ggtype_radio" id="r6c35" value="6串35" type="radio">
          6串35</label>
          <label style="display:none;" for="r6c42">
          <input name="ggtype_radio" id="r6c42" value="6串42" type="radio">
          6串42</label>
          <label style="display:none;" for="r6c50">
          <input name="ggtype_radio" id="r6c50" value="6串50" type="radio">
          6串50</label>
          <label style="display:none;" for="r6c57">
          <input name="ggtype_radio" id="r6c57" value="6串57" type="radio">
          6串57</label>
        </div>
        <div class="dc_r_m">
          <h2>3、确认投注结果</h2>
          <p class="dc_qr">投注&nbsp;
            <input name="" class="mul" value="1" style="width: 40px;" id="bs" type="text">
            倍(最高100000倍)<br>
            您选择了 <span class="eng red" id="cs">0</span> 场比赛，共<span class="eng red" id="zs">0</span>注，<br>
            总金额 <strong class="eng red" id="buy_money">￥0.00</strong>元<br>
            <span>理论最高奖金：<span class="eng red" id="maxmoney">￥0.00</span></span> <br>
           
            <a href="javascript:void(0);" id="seemore">查看明细</a> &nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" id="clear_all">清空所选</a></p>
          <p class="dc_r_btn">
          <!-- a href="javascript:void%200" class="btn_Dora_bs m-r" id="gobuy" onclick="return false">确认代购</a>
          <a href="javascript:void%200" class="btn_Dora_bs" id="gohm" onclick="return false">发起合买</a-->
          </p>
          <p class="gray dc_qr p-t0"> 过关投注奖金以方案最终出票时刻的奖金为准。 </p>
        </div>
      </div>
    </div>
    
    <form name="project_form" id="project_form" action="/jczq/tobuy" method="post">
      <input id="guoguantypes" name="guoguantypes" value="{'单关':40,'2串1':1,'2串3':2,'3串1':3,'3串3':56,'3串4':4,'3串6':5,'3串7':6,'4串1':7,'4串4':8,'4串5':9,'4串6':10,'4串10':11,'4串11':12,'4串14':13,'4串15':14,'5串1':15,'5串5':16,'5串6':17,'5串10':18,'5串15':19,'5串16':20,'5串20':21,'5串25':22,'5串26':23,'5串30':24,'5串31':25,'6串1':26,'6串6':27,'6串7':28,'6串15':29,'6串20':30,'6串21':31,'6串22':57,'6串35':32,'6串41':33,'6串42':34,'6串50':35,'6串56':36,'6串57':37,'6串62':38,'6串63':39,'7串1':41,'7串7':42,'7串8':43,'7串21':44,'7串35':45,'7串120':46,'7串127':47,'8串1':48,'8串8':49,'8串9':50,'8串28':51,'8串56':52,'8串70':53,'8串247':54,'8串255':55}" type="hidden">
      <input id="typename" name="sgtypename" value="普通过关" type="hidden">
      <input id="typeids" name="sgtype" value="40" type="hidden">
      <input id="code_data" name="code_data" type="hidden">
      <input id="special_num" name="special_num" type="hidden">
      <input id="allprice" name="allprice" type="hidden">
      <input id="copies" name="copies" type="hidden">
      <input id="rate" name="rate" type="hidden">
      <input id="is_duochuan" name="is_duochuan" value="1" type="hidden">
      <input id="is_hemai" name="is_hemai" value="0" type="hidden">
      <input id="ticket_type" name="ticket_type" value="1" type="hidden">
      <input id="play_method" name="play_method" value="3" type="hidden">
      <input id="ticket_id" name="ticket_id" value="3" type="hidden">
      <input id="playtype" name="playtype" value="bf" type="hidden">
      <input id="isgg" value="2" type="hidden">
      <input id="imaxmoney" name="imaxmoney" value="" type="hidden">
      <input name="price_limit" id="price_limit" value="2,200000,," type="hidden">
    </form>
  </div>
  <div class="width zzdetail" id="zzdetail">
  <table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout:fixed">
    <tbody>
      <tr>
        <th width="65">注号</th>
        <th width="65">过关方式</th>
        <th>注项内容</th>
        <th width="200" class="last_th">奖金</th>
      </tr>
     
    </tbody>
  </table>
  </div>
</div>
<!--提示层-->
<div class="tips_m" style="width: 692px; top: 1000px; display: none; position: absolute;" id="blk1">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2>竞彩足球奖金明细</h2>
        <span class="close"><a href="javascript:void(0)" id="close1">关闭</a></span> </div>
      <div style="height: 470px; overflow-y: auto; overflow-x: hidden;" class="tips_info">
        <div class="mx_tips">
          <p><strong class="red" id="prix_range">奖金范围：0-0元</strong></p>
          <h3>奖金分布</h3>
          <div id="hot_case"></div>
          <div id="hit_split"></div>
          <h3>投注分布</h3>
          <div id="tz_fenbu"></div>
          <p class="p_tb5 red" style="text-align:center">注：预测奖金为投注时的即时奖金，最终奖金以出票时刻的奖金为准。</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!--footer start-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>

<div id="ft">
  <textarea id="responseJson" style="display: none;">{
	period :      "",   //期号
	serverTime :  "<?php echo date("Y-m-d H:i:s");?>",   //服务器时间
	endTime :     "",    //截止时间
	singlePrice : 0,    //单注金额
	baseUrl : "<?php echo url::base();?>"  //网站根目录
}</textarea>
 

  
<!--未登录提示层-->
<?php echo View::factory('login')->render();?>
<!--默认提示层-->
  
  <div class="tips_m" style="display:none;" id="defLay">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>温馨提示</h2>
          <span class="close" id="defTopClose"><a href="javascript:void(0);">关闭</a></span> </div>
        <div class="tips_text" id="defConent" style="padding:18px;text-align:center;"></div>
        <div class="tips_sbt" style="padding:8px;text-align:center;height:auto;">
          <input class="btn_Lblue_m" value="关闭" id="defCloseBtn" type="button">
        </div>
      </div>
    </div>
  </div>
  <!--号码示例层-->
  <div class="tips_m" style="display:none;" id="codeTpl">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>温馨提示</h2>
          <span class="close" id="codeTplClose"><a href="javascript:void(0);">关闭</a></span> </div>
        <div class="tips_text" id="codeTplConent" style="padding:18px;"></div>
        <div class="tips_sbt" style="padding:8px;text-align:center;height:auto;">
          <input class="btn_Lora_b" value="知道了" id="codeTplYes" type="button">
        </div>
      </div>
    </div>
  </div>
  <!--余额不足内容-->
  <div class="tips_m" style="top:300px;display:none;" id="addMoneyLay">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>可用余额不足</h2>
          <span class="close" id="addMoneyClose"><a href="javascript:void%200">关闭</a></span> </div>
        <div class="tips_text">
          <p class="pd_l tc f14" id="addMoneyContent">您的可投注余额不足，请充值<br>
            (点充值跳到“充值”页面，点“返回”可进行修改)</p>
        </div>
        <div class="tips_sbt">
          <input value="返 回" class="btn_Lora_b" id="addMoneyNo" type="button">
          <input value="充 值" class="btn_Dora_b" id="addMoneyYes" type="button">
        </div>
      </div>
    </div>
  </div>
  <!--代购确认-->
  <div class="tips_m" style="display:none" id="b2_dlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2 id="b2_dlg_title">确认投注内容</h2>
          <span class="close" id="b2_dlg_close"><a href="#">关闭</a></span> </div>
        <div class="tips_info" id="b2_dlg_content"></div>
        <div class="tips_sbt">
          <input value="取 消" class="btn_Lora_b" id="b2_dlg_no" type="button">
          <input value="确 定" class="btn_Dora_b" id="b2_dlg_yes" type="button">
        </div>
      </div>
    </div>
  </div>
  <!--机选号码列表-->
  <div class="tips_m" style="top:300px;width:300px;display:none;position:absolute" id="jx_dlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>机选号码列表</h2>
          <span class="close" id="jx_dlg_close"><a href="#">关闭</a></span> </div>
        <div class="tips_text">
          <ul class="tips_text_list" id="jx_dlg_list">
          </ul>
        </div>
        <div class="tips_sbt">
          <input value="重新机选" class="btn_gray_b m-r" id="jx_dlg_re" type="button">
          <input value="选好了" class="s-ok s-ok-sp" id="jx_dlg_ok" type="button">
        </div>
      </div>
    </div>
  </div>
  <!--查看胆拖明细列表-->
  <div class="tips_m" style="top:300px;width:300px;display:none;position:absolute" id="split_dlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>查看投注明细</h2>
          <span class="close" id="split_dlg_close"><a href="#">关闭</a></span> </div>
        <div class="tips_text">
          <ul class="tips_text_list" id="split_dlg_list" style="height:284px;overflow:auto;">
          </ul>
        </div>
        <div class="tips_sbt">
          <input value="关 闭" class="s-ok" id="split_dlg_ok" type="button">
        </div>
      </div>
    </div>
  </div>
  <!--温馨提示-->
  <div class="tips_m" style="top:700px;display:none;position:absolute" id="info_dlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>温馨提示</h2>
          <span class="close" id="info_dlg_close"><a href="#">关闭</a></span> </div>
        <div class="tips_text">
          <div class="tips_ts" id="info_dlg_content" style="zoom:1"></div>
        </div>
        <div class="tips_sbt">
          <input value="确 定" class="btn_Dora_b" id="info_dlg_ok" type="button">
        </div>
      </div>
    </div>
  </div>
  <!-- 确认投注内容 -->
  <div class="tips_m" style="width:700px;display:none;" id="ishm_dlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2 id="ishm_dlg_title">方案合买</h2>
          <span class="close"><a href="javascript:void%200" id="ishm_dlg_close">关闭</a></span> </div>
        <div class="tips_info tips_info_np" id="ishm_dlg_content"></div>
        <div class="tips_sbt">
          <input value="确认投注" class="btn_Dora_b" id="ishm_dlg_yes" type="button">
          <a href="javascript:void(0);" class="btn_modifyFont" title="返回修改" id="ishm_dlg_no">返回修改&gt;&gt;</a> </div>
      </div>
    </div>
  </div>
  <!--提示确认-->
  <div class="tips_m" style="display:none" id="confirm_dlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2 id="confirm_dlg_title">温馨提示</h2>
          <span class="close" id="confirm_dlg_close"><a href="#">关闭</a></span> </div>
        <div class="tips_info" id="confirm_dlg_content"></div>
        <div class="tips_sbt">
          <input value="取 消" class="btn_Lora_b" id="confirm_dlg_no" type="button">
          <input value="确 定" class="btn_Dora_b" id="confirm_dlg_yes" type="button">
        </div>
      </div>
    </div>
  </div>
</div>

<div style="display: none;" id="#title_folat">
  <table class="dc_table" border="0" cellpadding="0" cellspacing="0" width="100%">
    <colgroup>
    <col width="9%">
    <col width="8%">
    <col width="8%">
    <col width="10%">
    <col width="4%">
    <col width="10%">
    <col width="15%">
    <col width="8%">
    <col width="8%">
    <col width="8%">
    <col width="8%">
    <col width="4%">
    </colgroup>
    <tbody>
      <tr>
        <th>赛事编号</th>
        <th>赛事类型</th>
        <th><select id="select_time">
            <option selected="selected" value="0">截止</option>
            <option value="1">开赛</option>
          </select></th>
        <th>主队</th>
        <th>让</th>
        <th>客队</th>
        <th><select id="select_pv" size="1">
            <option selected="selected" value="0">平均赔率</option>
            <option value="1">投注比例</option>
          </select></th>
        <th>数据</th>
        <th>胜</th>
        <th>平</th>
        <th>负</th>
        <th class="last_th">走势</th>
      </tr>
    </tbody>
  </table>
</div>
<div style="position: absolute; display: none; z-index: 9999;" id="livemargins_control"><img src="<?php echo url::base();?>media/images/monitor-background-horizontal.png" style="position: absolute; left: -77px; top: -5px;" height="5" width="77"> <img src="<?php echo url::base();?>media/images/monitor-background-vertical.png" style="position: absolute; left: 0pt; top: -5px;"> <img id="monitor-play-button" src="<?php echo url::base();?>media/images/monitor-play-button.png" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5" style="position: absolute; left: 1px; top: 0pt; opacity: 0.5; cursor: pointer;"></div>
<div class="tips_m" style="top: 700px; display: none; position: absolute;" id="yclass_alert">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2 id="yclass_alert_title">温馨提示</h2>
        <span class="close" id="yclass_alert_close"><a href="#">关闭</a></span> </div>
      <div class="tips_text">
        <div class="tips_ts" id="yclass_alert_content" style="zoom:1"></div>
      </div>
      <div class="tips_sbt">
        <input value="确 定" class="btn_Dora_b" id="yclass_alert_ok" type="button">
      </div>
    </div>
  </div>
</div>
<div class="tips_m" style="display: none; position: absolute;" id="yclass_confirm">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2 id="yclass_confirm_title">温馨提示</h2>
        <span class="close" id="yclass_confirm_close"><a href="#">关闭</a></span> </div>
      <div class="tips_info" id="yclass_confirm_content" style="zoom:1"></div>
      <div class="tips_sbt">
        <input value="取 消" class="btn_Lora_b" id="yclass_confirm_no" type="button">
        <input value="确 定" class="btn_Dora_b" id="yclass_confirm_ok" type="button">
      </div>
    </div>
  </div>
</div>
<div style="display:none;" id="open_iframe">
  <div id="open_iframe_content"></div>
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
