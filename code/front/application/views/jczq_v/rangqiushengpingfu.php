<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-竞彩足球-让球胜平负</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
    'media/js/yclass.js?v=20110509',
	'media/js/tabs',
	'media/js/loginer',
	'media/js/detail',
	'media/js/jczq',
	'media/js/predict',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/zc.css?v=201112090',
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
		<a href="<?php echo url::base();?>jczq/rqspf"><font class="blue">竞彩足球</font></a> &gt; 让球胜平负
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
       	  <p id="jctop_rheight"><span class="fr gray6">销售时间：周一至周五 09:00～22:40  周六至周日 09:00～00:40</span><font class="font16 black heiti">返奖率高达</font><font class="font24 orange heiti">69%，</font><font class="font16 black heiti">过关固定奖金</font></p>
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
     <div id="jingcai_bottom" class="fl">
     <div class="dc_l">
      <a href="<?php echo url::base();?>jczq/rqspf" title="普通投注"><em>普通投注</em><s></s></a>
       <a href="<?php echo url::base();?>jczq/ds_spf" title="单式投注" <?php if (isset($ds) && $ds == 1) echo 'class="on"';?>><em>单式投注</em><s></s></a> 
       <a href="<?php echo url::base();?>jczq_v/rqspf" title="虚拟投注" class="on"><em>虚拟投注</em><s></s></a>
       </div>
     <span class="fr pt5 mr10"><a href="<?php echo url::base();?>buycenter/jczq"><img src="<?php echo url::base();?>media/images/btn3.gif" width="85" height="22" alt="参与合买" /></a></span></div>
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
            <input checked="checked" id="ck1" type="checkbox" />让球
            </label>
            <label for="ck2">
            <input checked="checked" id="ck2" type="checkbox" />非让球
            </label>
            <label for="ck3">
            <input id="ck3" type="checkbox" />已截止(<?php echo $match_end;?>场)
            </label>已隐藏 <span class="red eng" id="hide_count">0</span> 场赛事 <a href="javascript:void%200" id="showAll_btn">恢复</a> 
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
            </span>
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
                  <li style="height:18px; overflow:hidden;">
                    <input id="lg<?php echo $rowname;?>" m="<?php echo $rowname;?>" checked="checked" type="checkbox" /><label for="lg<?php echo $rowname;?>"><?php echo $rowname;?></label>
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
          <table class="dc_table" border="0" cellpadding="0" cellspacing="0" width="740">
            <colgroup>
            <col width="8%" />
            <col width="8%" />
            <col width="8%" />
            <col width="10%" />
            <col width="4%" />
            <col width="10%" />
            <col width="12%" />
            <col width="8%" />
            <col width="10%" />
            <col width="10%" />
            <col width="10%" />
            <?php
            /**
			?> 
            <col width="4%">
			<?php
            **/
			?> 
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

				<th>
				<!-- <select id="select_pv" size="1">
					<option selected="selected" value="0">平均赔率</option>
					<option value="1">投注比例</option>
				</select> -->
				平均赔率
				</th>
                <th>数据</th>
                <th>胜</th>
                <th>平</th>
                <th>负</th>
            <?php
            /**
			?>                
                <th class="last_th">走势</th>
            <?php
            **/
			?>                
                
              </tr>
            </tbody>
          </table>
<div class="left_overflow"> 
<?php
foreach ($groups as $groupkey => $groupvalue)
{
?>
          <div class="dc_hs"> <strong><?php echo $groups_date[$groupkey];?> <?php echo tool::get_weekday($groups_date[$groupkey]);?> <?php echo count($groupvalue);?>场比赛可投注</strong> <a href="javascript:void%200">隐藏<s class="c_up"></s></a> </div>
          <table class="dc_table" id="d_<?php echo $groupkey;?>" border="0" cellpadding="0" cellspacing="0" width="720">
            <colgroup>
            <col width="8%" />
            <col width="8%" />
            <col width="7%" />
            <col width="10%" />
            <col width="4%" />
            <col width="10%" />
            <col width="14%" />
            <col width="7%" />
            <col width="10%" />
            <col width="10%" />
            <col width="10%" />
            <?php
            /**
			?>             
            <col width="4%">
            <?php
            **/
			?> 			
            </colgroup>
            <tbody>
	<?php 
    $i = 0;
    foreach ($groupvalue as $row) 
    {
        $rowstyle = '';
        if ($i % 2==0) 
        {
            $rowstyle = 'even';
        } 
        $i++;
        $row['comb'] = json_decode($row['comb']);
        $row['last_comb'] = json_decode($row['last_comb']);
        $row['avg_sp'] = json_decode($row['avg_sp']);
    	$goalclass = intval($row['goalline']);
		if (intval($row['goalline']) > 0) {
			$goalclass = '<strong class="eng red">+'.intval($row['goalline']).'</strong>';
		}
		if (intval($row['goalline']) < 0) {
			$goalclass = '<strong class="eng green">'.intval($row['goalline']).'</strong>';
		}
    ?> 
    <tr class="<?php echo $rowstyle;?>" zid="<?php echo $row['id'];?>" mid="<?php echo $row['index_id'];?>" pname="<?php echo $row['match_num'];?>" pdate="<?php echo $row['match_num'];?>" lg="<?php echo $row['league'];?>" rq="<?php echo intval($row['goalline']);?>" pendtime="<?php echo date('Y-m-d H:i:s', strtotime($row['time_end']));?>" win="<?php echo $row['comb']->h->v;?>" draw="<?php echo $row['comb']->d->v;?>" lost="<?php echo $row['comb']->a->v;?>" isend="<?php echo $row['match_end']; ?>">
    <td style="cursor: pointer;">
    <label for="m<?php echo $row['id'];?>"><input name="m<?php echo $row['id'];?>" id="m<?php echo $row['id'];?>" value="<?php echo $row['id'];?>" checked="checked" type="checkbox"><?php echo $row['match_info'];?></label>
    </td>
    <td style="background: none repeat scroll 0% 0% <?php echo $row['color'];?>; color: rgb(255, 255, 255);" class="league">
    <a href="<?php echo $row['match_url'];?>" target="_blank"><?php echo $row['league'];?></a>
    </td>
    <td>
    <span class="eng end_time" title="开赛时间：<?php echo date('Y-m-d H:i', strtotime($row['time_beg']));?>"><?php echo date('H:i', strtotime($row['time_end']));?></span> 
    <span class="eng match_time" title="截止时间：<?php echo date('Y-m-d H:i', strtotime($row['time_end']));?>" style="display:none"><?php echo date('H:i', strtotime($row['time_beg']));?></span> 
    </td>
    <td><!--span class="gray">[11]</span-->
    <?php if (isset($row['host_rank']) && $row['host_rank'] != null) echo '<font color="gray">['.$row['host_rank'].']</font>';?><a href="<?php echo !empty($row['host_url']) ? $row['host_url'] : '#';?>" title="<?php echo $row['host_name'];?>" target="_blank"><?php echo $row['host_name'];?></a>
    </td>
    <td><?php echo $goalclass;?></td>
    <td>
    <a href="<?php echo !empty($row['guest_url']) ? $row['guest_url'] : '#';?>" title="<?php echo $row['guest_name'];?>"  target="_blank"><?php echo $row['guest_name'];?></a><?php if (isset($row['guest_rank']) && $row['guest_rank'] != null) echo '<font color="gray">['.$row['guest_rank'].']</font>';?>
    <!--span class="gray">[4]</span-->
    </td>

		<td><!-- 平均赔率/投注比例 -->
      <div class="pjpl">
      <span class="sp_w35 eng"><?php if (isset($row['avg_sp']->h) && $row['avg_sp']->h > 0) echo $row['avg_sp']->h; else echo '-';?></span>
      <span class="sp_w35 eng"><?php if (isset($row['avg_sp']->d) && $row['avg_sp']->d > 0) echo $row['avg_sp']->d; else echo '-';?></span>
      <span class="sp_w35 eng"><?php if (isset($row['avg_sp']->a) && $row['avg_sp']->a > 0) echo $row['avg_sp']->a; else echo '-';?></span>
      </div>
<!--       <div class="tzbl" style="display:none"> -->
<!--       <span class="sp_w35 eng"></span> -->
<!--       <span class="sp_w35 eng"></span> -->
<!--       <span class="sp_w35 eng"></span> -->
<!--       </div> -->
      </td>

    <td class="h_br"><!-- 比分/析亚欧 -->
    <?php
    if (isset($row['xi_url']) && $row['xi_url'] != null) {
    	$xi_url = $row['xi_url'];
    }
    else {
    	$xi_url = 'http://info.sporttery.cn/football/info/fb_match_hhad.php?m='.$row['match_id'];
    }
    if (isset($row['ya_url']) && $row['ya_url'] != null) {
    	$ya_url = $row['ya_url'];
    }
    else {
    	$ya_url = 'http://info.sporttery.cn/football/info/fb_match_news.php?m='.$row['match_id'].'&s=fb';
    }
    if (isset($row['ou_url']) && $row['ou_url'] != null) {
    	$ou_url = $row['ou_url'];
    }
    else {
    	$ou_url = 'http://info.sporttery.cn/football/search_odds.php?mid='.$row['match_id'];
    }
    ?>
      <a href="<?php echo $xi_url;?>" target="_blank">析</a> 
      <a href="<?php echo $ya_url;?>" target="_blank">亚</a> 
      <a href="<?php echo $ou_url;?>" target="_blank">欧</a> 
    </td>
    <?php
    $h_c = $d_c = $a_c = '';
    $h_sp = $row['comb']->h->v;
    $d_sp = $row['comb']->d->v;
    $a_sp = $row['comb']->a->v;
    
    $h_last_sp = $row['last_comb']->h->v;
    $d_last_sp = $row['last_comb']->d->v;
    $a_last_sp = $row['last_comb']->a->v;
    if ($row['last_comb'] != null && $h_sp > $h_last_sp) {
    	$h_c = '<span class="red">↑</span>';
    }
    if ($row['last_comb'] != null && $h_sp < $h_last_sp) {
    	$h_c = '<span class="green">↓</span>';
    }
    
    if ($row['last_comb'] != null && $d_sp > $d_last_sp) {
    	$d_c = '<span class="red">↑</span>';
    }
    if ($row['last_comb'] != null && $d_sp < $d_last_sp) {
    	$d_c = '<span class="green">↓</span>';
    }
    
    if ($row['last_comb'] != null && $a_sp > $a_last_sp) {
    	$a_c = '<span class="red">↑</span>';
    }
    if ($row['last_comb'] != null && $a_sp < $a_last_sp) {
    	$a_c = '<span class="green">↓</span>';
    }
    ?>
    <td class="h_br" style="cursor: pointer; text-align: left; padding-left: 3px;"><?php if($row['match_end']==0) {?><input class="chbox" value="3" type="checkbox" /> <?php }?>
      <span class="eng b"><?php echo $h_sp.$h_c;?></span></td>
    <td class="h_br" style="cursor: pointer; text-align: left; padding-left: 3px;"><?php if($row['match_end']==0) {?><input class="chbox" value="1" type="checkbox" /> <?php }?>
      <span class="eng b"><?php echo $d_sp.$d_c;?></span></td>
    <td class="h_br" style="cursor: pointer; text-align: left; padding-left: 3px;"><?php if($row['match_end']==0) {?><input class="chbox" value="0" type="checkbox" /> <?php }?>
      <span class="eng b"><?php echo $a_sp.$a_c;?></span></td>
                <?php
                /**
                ?>  
    <td><a class="icon_jjzs" target="_blank" href="#"></a></td>
                <?php
                **/
                ?> 
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
        </div>
      </div>
      <a style="left: 987px;" title="回到顶部" class="back_top" href="#top" hidefocus="true">回到顶部</a> </div>
    <div class="dc_r">
      <div class="box_m2">
        <div class="dc_r_t">方案截止时间：<span class="eng red" id="end_time"></span></div>
        <div class="dc_r_m">
          <h2>1、确认投注信息</h2>
          <table class="dcr_table" border="0" cellpadding="0" cellspacing="0" width="100%">
            <colgroup>
            <col width="31%">
            <col width="27%">
            <col width="34%">
            <col width="8%">
            </colgroup>
            <tbody>
              <tr>
                <th>编号</th>
                <th>主队</th>
                <th>投注</th>
                <th>胆</th>
              </tr>
              <tr style="display: none;" id="choose_tpl">
                <td><input checked="checked" class="chbox" view="1" type="checkbox">
                  <span class="gray"></span></td>
                <td class="tl">切尔西西</td>
                <td class="tl"><span class="x_s" data-sg="3">胜</span><span class="x_s" data-sg="1">平</span><span class="x_s" data-sg="0">负</span></td>
                <td><span>
                  <input class="chbox" dan="1" type="checkbox">
                  </span></td>
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
			<label style="display:none;" for="r7c1">
            <input name="ggtype_checkbox" id="r7c1" value="7串1" type="checkbox">
            7串1</label>
			<label style="display:none;" for="r8c1">
            <input name="ggtype_checkbox" id="r8c1" value="8串1" type="checkbox">
            8串1</label>
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
		  <label style="display:none;" for="r7c7">
          <input name="ggtype_radio" id="r7c7" value="7串7" type="radio">
          7串7</label>
		  <label style="display:none;" for="r7c8">
          <input name="ggtype_radio" id="r7c8" value="7串8" type="radio">
          7串8</label>
		  <label style="display:none;" for="r7c21">
          <input name="ggtype_radio" id="r7c21" value="7串21" type="radio">
          7串21</label>
		  <label style="display:none;" for="r7c35">
          <input name="ggtype_radio" id="r7c35" value="7串35" type="radio">
          7串35</label>
		  <label style="display:none;" for="r7c120">
          <input name="ggtype_radio" id="r7c120" value="7串120" type="radio">
          7串120</label>
		  <label style="display:none;" for="r8c8">
          <input name="ggtype_radio" id="r8c8" value="8串8" type="radio">
          8串8</label>
		  <label style="display:none;" for="r8c9">
          <input name="ggtype_radio" id="r8c9" value="8串9" type="radio">
          8串9</label>
		  <label style="display:none;" for="r8c28">
          <input name="ggtype_radio" id="r8c28" value="8串28" type="radio">
          8串28</label>
		  <label style="display:none;" for="r8c56">
          <input name="ggtype_radio" id="r8c56" value="8串56" type="radio">
          8串56</label>
		  <label style="display:none;" for="r8c70">
          <input name="ggtype_radio" id="r8c70" value="8串70" type="radio">
          8串70</label>
		  <label style="display:none;" for="r8c247">
          <input name="ggtype_radio" id="r8c247" value="8串247" type="radio">
          8串247</label>
        </div>
        <div class="dc_r_m">
          <h2>3、确认投注结果</h2>
          <p class="dc_qr">投注&nbsp;
            <input name="" class="mul" value="1" style="width: 40px;" id="bs" type="text">
            倍(最高100000倍)<br>
            您选择了 <span class="eng red" id="cs">0</span> 场比赛，共<span class="eng red" id="zs">0</span>注，<br>
            总金额 <strong class="eng red" id="buy_money">￥0.00</strong>元<br>
            <span>理论最高奖金：<span class="eng red" id="maxmoney">￥0.00</span></span> <br>
            <span><a href="javascript:void(0);" id="seemore">查看明细</a>&nbsp;&nbsp;<a href="javascript:void(0)" id="clear_all">清空所选</a></span>
            <?php 
			/**
			?>
            <a href="javascript:void(0);" id="seemore">查看明细</a>
            <?php
			**/
			?>
            </p>
          <p class="dc_r_btn">
          <a href="javascript:void%200" class="btn_Dora_bs m-r" id="gobuy" onclick="return false">确认代购</a>
          </p>
          <p class="gray dc_qr p-t0">过关投注奖金以方案最终出票时刻的奖金为准。 </p>
        </div>
      </div>
    </div>
    <form name="project_form" id="project_form" action="/jczq_v/tobuy" method="post">
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
      <input id="play_method" name="play_method" value="1" type="hidden">
      <input id="ticket_id" name="ticket_id" value="1" type="hidden">
      <input id="playtype" name="playtype" value="spf" type="hidden">
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
        <th width="100">过关方式</th>
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