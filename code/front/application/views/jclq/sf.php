<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-竞彩篮球-胜负</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
    'media/js/yclass.js?v=20110509',
	'media/js/tabs',
	'media/js/loginer',
	'media/js/detail',
	'media/js/jclq',
	'media/js/predict',
	//url::base().'xml/jczq/xml_1_2/load.js',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/lc',
	'media/css/mask',
    'media/css/style',
    'media/css/css1',
), FALSE);
?>
<style type="text/css">
span.tzbl, span.match_time { display:none; }
.ggtypelist{ padding:10px; line-height :25px; }
.ggtypelist label{ width:30%; vertical-align:middle; white-space:nowrap; }
.ggtypelist input{ vertical-align:middle; padding-right:10px; }
.ggtypelist{
	padding:10px;
	line-height :25px;
}
.ggtypelist label{display:inline-block;width:30%;vertical-align:middle;white-space:nowrap;}
.ggtypelist input{margin-right:4px;vertical-align:middle;}
</style>
</head>
<body>
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>jclq/rfsf"><font class="blue">竞彩篮球</font></a> &gt; 胜负
	</div>
	<div style="float:right; margin-right:20px;">
		<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
	</div>
	<div style="clear:both;"></div>
</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width jingcai_box ">
  <div class="fl" id="jingcai_top"> <span class="fl" id="jctop_left"><img src="<?php echo url::base();?>media/images/jclq-logo.png" /></span>
    <div class="fl" id="jctop_right">
      <p id="jctop_rheight"><span class="fr gray6">销售时间：周一至周五 09:00～22:40  周六至周日 09:00～00:40</span><font class="font16 black heiti">返奖率高达</font><font class="font24 orange heiti">69%，</font><font class="font16 black heiti">过关固定奖金</font></p>
      <div id="jc_menu" class="font14 bold">
        <ul>
         <li <?php if(!empty($play_type) && $play_type == 1) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jclq/sf"><span>胜负</span></a></li>
         <li <?php if(!empty($play_type) && $play_type == 2) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jclq/rfsf"><span>让分胜负</span></a></li>
		 <li <?php if(!empty($play_type) && $play_type == 3) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jclq/sfc"><span>胜分差</span></a></li>
         <li <?php if(!empty($play_type) && $play_type == 4) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jclq/dxf"><span>大小分</span></a></li>
		 <li <?php if(!empty($play_type) && $play_type == 5) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jclq/my"><span>我的方案</span></a></li>
        </ul>
      </div>
    </div>
  </div>
  <div id="jingcai_bottom" class="fl">
    <div class="dc_l">
    <?php
    /**
	?>
    <a href="zqdc_spf.html" title="普通投注" class="on"><em>普通投注</em><s></s></a> <a href="zqdc_spf_ds.html" title="单式投注"  ><em>单式投注</em><s></s></a> 
    <?php
	**/
	?>
    </div>
    <span class="fr pt5 mr10"><a href="<?php echo url::base();?>buycenter/jclq"><img src="<?php echo url::base();?>media/images/btn3.gif" width="85" height="22" alt="参与合买" /></a></span></div>
  <span class="zhangkai"></span> </div>
<!--content1 end-->
<!--header end-->

<!-- bd begin -->
<div id="bd">
  <div id="main" class="main_dc clearfix">
    <div class="dc_l">
	<div class="box_top">
        <div class="box_top_l"></div>
        <a name="top"></a> </div>
      <div class="box_m">
        <div class="dc_l_t jc_l_t">
          <div class="dc_l_tl"> <span class="mie7">
            <input id="ck3" type="checkbox" />
          			<span class="mie7">
						已截止(0场)&nbsp;&nbsp;已隐藏 
						<span class="red eng" id="hide_count">0</span> 场赛事 
						<a href="javascript:void(0)" id="showAll_btn">恢复</a>
					</span> 
				</div>
          <div class="dc_l_tr">
            <div class="dc_ls_w">
              <div id="listMenu" style="display: none;" class="dc_ls_n">
                <ul id="lgList" class="clearfix">
<?php
	foreach ($matchnames as $rowname) {
?>
<li>
<input id="lg<?php echo $rowname;?>" m="<?php echo $rowname;?>" checked="checked" type="checkbox" class="chbox" />
<label for="lg<?php echo $rowname;?>"><?php echo $rowname;?></label>
</li>
<?php
	}
?>  
                </ul>
                <div class="ls_n_b"> <a id="selectAllBtn" class="btn_Lblue_s" href="javascript:void(0)">全选</a> <a id="selectOppBtn" class="btn_Lblue_s" href="javascript:void(0)">反选</a> </div>
              </div>
              <a id="listDisplay" class="ls_s_btn" href="javascript:void(0)">联赛选择</a> </div>
          </div>
        </div>
        
<!-- detail of match begin -->
        <div class="dc_l_m" id="vsTable">
          <table class="dc_table" border="0" cellpadding="0" cellspacing="0" width="100%">
            <colgroup>
            <col width="10%" />
            <col width="10%" />
			<col width="10%" />
            <col width="30%" />
            <col width="10%" />
            <col width="10%" />
            <col width="10%" />
            </colgroup>
            <tbody>
              <tr class="">
                <th>赛事编号</th>
                <th>赛事类型</th>
                <th>
					<select id="select_time" style="font-size: 12px;">
						<option value="0">截止</option>
						<option value="1">开赛</option>
					</select>
				</th>
				<th> 客队 VS 主队</th>
                <th>&nbsp;</th>
                <th>主负</th>
                <th>主胜</th>
              </tr>
            </tbody>
          </table>
          
<?php
	foreach ($groups as $groupkey => $groupvalue) {
?>
	<div class="dc_hs">
		<strong><?php echo $groups_date[$groupkey];?><?php echo tool::get_weekday($groups_date[$groupkey]);?>&nbsp;<?php echo count($groupvalue);?>场比赛可投注</strong>&nbsp;
		<a href="javascript:void(0)">隐藏<s class="c_up"></s></a>
	</div>
          <table class="dc_table" id="d_<?php echo $groupkey;?>" border="0" cellpadding="0" cellspacing="0" width="100%">
            <colgroup>
            <col width="10%" />
            <col width="10%" />
			<col width="10%" />
            <col width="14%" />
            <col width="2%" />
            <col width="14%" />
            <col width="10%" />
            <col width="10%" />
            <col width="10%" />
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
    ?> 
			<tr class="<?php echo $rowstyle;?>" 
					  zid="<?php echo $row['id'];?>" 
					  mid="<?php echo $row['index_id'];?>" 
					  pname="<?php echo $row['match_num'];?>" 
					  pdate="<?php echo $row['match_num'];?>" 
					  lg="<?php echo $row['league'];?>" 
					  lost="<?php echo $row['comb']->h->v;?>" 
					  win="<?php echo $row['comb']->a->v;?>" 
					  guestteam="<?php echo $row['guest_name'];?>" 
					  hometeam="<?php echo $row['host_name'];?>" 
					  pendtime="<?php echo date('Y-m-d H:i:s', strtotime($row['time_end'])) ;?>" 
				isend="<?php echo $row['match_end']; ?>"
				style="" >
			  
                <td><label for="m<?php echo $row['id'];?>">
                  <input type="checkbox" checked="checked" class="i-cr"
                  	value="<?php echo $row['id'];?>"
					id="m<?php echo $row['id'];?>" 
                  	name="<?php echo $row['id'];?>" 
                  	 /><?php echo $row['match_info'];?></label></td>
				
                <td style="background: none repeat scroll 0% 0% <?php echo $row['color'];?>; color: rgb(255, 255, 255);" class="league">
                	<a href="<?php echo $row['match_url'];?>" target="_blank"><?php echo $row['league'];?></a>
                </td>
				
                <td class="h_br">
				 <span class="eng end_time" title="截止时间：<?php echo date('Y-m-d H:i', strtotime($row['time_end']));?>">
				 <?php echo date('H:i', strtotime($row['time_end']));?></span> 
					<span class="eng match_time" title="开赛时间：<?php echo date('Y-m-d H:i', strtotime($row['time_beg']));?>" style="display:none">
						<?php echo date('H:i', strtotime($row['time_beg']));?></span> 
				</td>
				
				<td class="tr"><?php echo $row['guest_name'];?></td>
				<td><span class="gray">VS</span></td>
				<td class="tl"><?php echo $row['host_name'];?></td>
				
				<td class="h_br">&nbsp;
				    <a href="http://info.sporttery.cn/basketball/info/bk_match_info.php?m=<?php echo $row['match_id'];?>&s=bk" target="_blank">讯</a> 
				    <a href="http://info.sporttery.cn/basketball/mnl_odds.php?mid=<?php echo $row['match_id'];?>" target="_blank">同</a>
				</td>
				
				<td class="h_br" style="cursor: pointer; text-align: left; padding-left: 3px;">&nbsp;
					<?php if($row['match_end']==0) {?><input class="i-cr" value="2" type="checkbox" /><?php }?>
					<span class="eng b"><?php echo $row['comb']->h->v;?></span>
				</td>
                
                <td class="h_br" style="cursor: pointer; text-align: left; padding-left: 3px;">&nbsp;
					<?php if($row['match_end']==0) {?><input class="i-cr" value="1" type="checkbox" /><?php }?>
					<span class="eng b"><?php echo $row['comb']->a->v;?></span>
				</td>
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
<!-- detail of match end -->
      </div>
    </div>
	 <a style="left: 987px;" title="回到顶部" class="back_top" href="#top" hidefocus="true">回到顶部</a> 
    <div class="dc_r">
      <div class="box_top">
        <div class="box_top_l"></div>
      </div>
      <div class="box_m">
        <div class="dc_r_t"> 方案截止时间：<span class="eng red" id="end_time"></span> </div>
        <div class="dc_r_m">
          <h2>1、确认投注信息</h2>
          <table class="dcr_table" border="0" cellpadding="0" cellspacing="0" width="100%">
            <colgroup>
            <col width="33%" />
            <col width="33%" />
            <col width="22%" />
            <col width="12%" />
            </colgroup>
            <tbody>
              <tr>
                <th>编号</th>
                <th>主队</th>
                <th>投注</th>
                <th>胆</th>
              </tr>
              <tr id="choose_tpl" style="display: none;">
                <td><input class="chbox" checked="checked" view="1" type="checkbox" /><span>周三001</span></td>
                <td class="tl">凯尔特人</td>
                <td class="tl"><span class="x_s" data-sg="2">负</span><span class="x_s" data-sg="1">胜</span></td>
                <td><span>
                  <input class="chbox" dan="1" type="checkbox" />
                  </span>
                 </td>
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
            <input name="ggtype_checkbox" id="r2c1" value="2串1" type="checkbox" />
            2串1</label>
            <label style="display:none;" for="r3c1">
            <input name="ggtype_checkbox" id="r3c1" value="3串1" type="checkbox" />
            3串1</label>
            <label style="display:none;" for="r4c1">
            <input name="ggtype_checkbox" id="r4c1" value="4串1" type="checkbox" />
            4串1</label>
            <label style="display:none;" for="r5c1">
            <input name="ggtype_checkbox" id="r5c1" value="5串1" type="checkbox" />
            5串1</label>
            <label style="display:none;" for="r6c1">
            <input name="ggtype_checkbox" id="r6c1" value="6串1" type="checkbox" />
            6串1</label>
            <label style="display:none;" for="r7c1">
            <input name="ggtype_checkbox" value="7串1" id="r7c1" type="checkbox" />
            7串1</label>
            <label for="r8c1" style="display:none;">
            <input name="ggtype_checkbox" value="8串1" id="r8c1" type="checkbox" />
            8串1</label>
          </div>
        </div>
        <div id="ggList" class="ggtypelist clearfix" style="display:none">
          <label for="r3c3" style="display: none;">
          <input name="ggtype_radio" value="3串3" id="r3c3" type="radio" />
          3串3</label>
          <label for="r3c4" style="display: none;">
          <input name="ggtype_radio" value="3串4" id="r3c4" type="radio" />
          3串4</label>
          <label for="r4c4" style="display: none;">
          <input name="ggtype_radio" value="4串4" id="r4c4" type="radio" />
          4串4</label>
          <label for="r4c5" style="display: none;">
          <input name="ggtype_radio" value="4串5" id="r4c5" type="radio" />
          4串5</label>
          <label for="r4c6" style="display: none;">
          <input name="ggtype_radio" value="4串6" id="r4c6" type="radio" />
          4串6</label>
          <label for="r4c11" style="display: none;">
          <input name="ggtype_radio" value="4串11" id="r4c11" type="radio" />
          4串11</label>
          <label for="r5c5" style="display: none;">
          <input name="ggtype_radio" value="5串5" id="r5c5" type="radio" />
          5串5</label>
          <label for="r5c6" style="display: none;">
          <input name="ggtype_radio" value="5串6" id="r5c6" type="radio" />
          5串6</label>
          <label for="r5c10" style="display: none;">
          <input name="ggtype_radio" value="5串10" id="r5c10" type="radio" />
          5串10</label>
          <label for="r5c16" style="display: none;">
          <input name="ggtype_radio" value="5串16" id="r5c16" type="radio" />
          5串16</label>
          <label for="r5c20" style="display: none;">
          <input name="ggtype_radio" value="5串20" id="r5c20" type="radio" />
          5串20</label>
          <label for="r5c26" style="display: none;">
          <input name="ggtype_radio" value="5串26" id="r5c26" type="radio" />
          5串26</label>
          <label for="r6c6" style="display: none;">
          <input name="ggtype_radio" value="6串6" id="r6c6" type="radio" />
          6串6</label>
          <label for="r6c7" style="display: none;">
          <input name="ggtype_radio" value="6串7" id="r6c7" type="radio" />
          6串7</label>
          <label for="r6c15" style="display: none;">
          <input name="ggtype_radio" value="6串15" id="r6c15" type="radio" />
          6串15</label>
          <label for="r6c20" style="display: none;">
          <input name="ggtype_radio" value="6串20" id="r6c20" type="radio" />
          6串20</label>
          <label for="r6c22" style="display: none;">
          <input name="ggtype_radio" value="6串22" id="r6c22" type="radio" />
          6串22</label>
          <label for="r6c35" style="display: none;">
          <input name="ggtype_radio" value="6串35" id="r6c35" type="radio" />
          6串35</label>
          <label for="r6c42" style="display: none;">
          <input name="ggtype_radio" value="6串42" id="r6c42" type="radio" />
          6串42</label>
          <label for="r6c50" style="display: none;">
          <input name="ggtype_radio" value="6串50" id="r6c50" type="radio" />
          6串50</label>
          <label for="r6c57" style="display: none;">
          <input name="ggtype_radio" value="6串57" id="r6c57" type="radio" />
          6串57</label>
          <label for="r7c7" style="display: none;">
          <input name="ggtype_radio" value="7串7" id="r7c7" type="radio" />
          7串7</label>
          <label for="r7c8" style="display: none;">
          <input name="ggtype_radio" value="7串8" id="r7c8" type="radio" />
          7串8</label>
          <label for="r7c21" style="display: none;">
          <input name="ggtype_radio" value="7串21" id="r7c21" type="radio" />
          7串21</label>
          <label for="r7c35" style="display: none;">
          <input name="ggtype_radio" value="7串35" id="r7c35" type="radio" />
          7串35</label>
          <label for="r7c120" style="display: none;">
          <input name="ggtype_radio" value="7串120" id="r7c120" type="radio" />
          7串120</label>
          <label for="r8c8" style="display: none;">
          <input name="ggtype_radio" value="8串8" id="r8c8" type="radio" />
          8串8</label>
          <label for="r8c9" style="display: none;">
          <input name="ggtype_radio" value="8串9" id="r8c9" type="radio" />
          8串9</label>
          <label for="r8c28" style="display: none;">
          <input name="ggtype_radio" value="8串28" id="r8c28" type="radio" />
          8串28</label>
          <label for="r8c56" style="display: none;">
          <input name="ggtype_radio" value="8串56" id="r8c56" type="radio" />
          8串56</label>
          <label for="r8c70" style="display: none;">
          <input name="ggtype_radio" value="8串70" id="r8c70" type="radio" />
          8串70</label>
          <label for="r8c247" style="display: none;">
          <input name="ggtype_radio" value="8串247" id="r8c247" type="radio" />
          8串247</label>
        </div>
        <div class="dc_r_m">
          <h2>3、确认投注结果</h2>
          <p class="dc_qr"> 投注&nbsp;
            <input style="width: 40px;" value="1" class="mul" id="bs" type="text" />
            倍(最高100000倍)<br />
            您选择了 <span class="eng red" id="cs">0</span> 场比赛，共 <span class="eng red" id="zs">0</span> 注，<br />
            总金额 <strong class="eng red" id="buy_money">￥0.00</strong>元<br />
            理论最高奖金：<span class="eng red" id="maxmoney">￥0.00</span><br />
            <a href="javascript:void(0)" id="seemore">查看明细</a> </p>
          <p class="dc_r_btn"> </p>
          <p class="dc_r_btn">
          <!-- a href="javascript:void 0" class="btn_Dora_bs m-r" id="gobuy" onclick="return false">确认代购</a>
          <a href="javascript:void%200" class="btn_Dora_bs" id="gohm" onclick="return false">发起合买</a-->
          </p>
          <p></p>
          <p class="gray dc_qr p-t0">过关投注奖金以方案最终出票时刻的奖金为准。</p>
        </div>
      </div>
    </div>
  </div>
  
</div>
<!-- end of bd -->

<div id="blk1" style="width: 692px; top: 1000px; display: none; position: absolute;" class="tips_m">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2>竞彩篮球奖金明细</h2>
        <span class="close"><a id="close1" href="javascript:void(0)">关闭</a></span> </div>
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
<form name="project_form" id="project_form" action="/jclq/tobuy" method="post">
	<input id="typename" name="sgtypename" value="普通过关" type="hidden" />
	<input id="typeids" name="sgtype" value="40" type="hidden" />
	<input id="code_data" name="code_data" type="hidden" />
	<input id="special_num" name="special_num" type="hidden" />
	<input id="allprice" name="allprice" type="hidden" />
	<input id="copies" name="copies" type="hidden" />
	<input id="rate" name="rate" type="hidden" />
	<input id="is_duochuan" name="is_duochuan" value="1" type="hidden" />
	<input id="is_hemai" name="is_hemai" value="0" type="hidden" />
	<input id="ticket_type" name="ticket_type" value="6" type="hidden" />
	<input id="play_method" name="play_method" value="1" type="hidden" />
	<input id="ticket_id" name="ticket_id" value="1" type="hidden" />
	<input id="playtype" name="playtype" value="sf" type="hidden" />
	<input id="isgg" value="2" type="hidden" />
	<input id="imaxmoney" name="imaxmoney" value="" type="hidden" />
	<input name="price_limit" id="price_limit" value="2,200000,," type="hidden" />
	<!--金额限制 格式:最小金额,最大金额,加注最小金额,加注最大多金额(加注的只有大乐透有-->
	<input id="jsonggtype" value="{'单关':40,'2串1':1,'2串3':2,'3串1':3,'3串3':56,'3串4':4,'3串6':5,'3串7':6,'4串1':7,'4串4':8,'4串5':9,'4串6':10,'4串10':11,'4串11':12,'4串14':13,'4串15':14,'5串1':15,'5串5':16,'5串6':17,'5串10':18,'5串15':19,'5串16':20,'5串20':21,'5串25':22,'5串26':23,'5串30':24,'5串31':25,'6串1':26,'6串6':27,'6串7':28,'6串15':29,'6串20':30,'6串21':31,'6串22':57,'6串35':32,'6串41':33,'6串42':34,'6串50':35,'6串56':36,'6串57':37,'6串62':38,'6串63':39,'7串1':41,'7串7':42,'7串8':43,'7串21':44,'7串35':45,'7串120':46,'7串127':47,'8串1':48,'8串8':49,'8串9':50,'8串28':51,'8串56':52,'8串70':53,'8串247':54,'8串255':55}" type="hidden" />
	<input id="playtype" value="sf" type="hidden" />
	<input id="isgg" value="2" type="hidden" />
</form>

<div class="width zzdetail" id="zzdetail">
  <table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout:fixed">
    
    
      <tr>
        <th width="100">注号</th>
        <th width="120">过关方式</th>
        <th>注项内容</th>
        <th width="200" class="last_th">奖金</th>
      </tr>
      <tr style="display: none;" id="zzchoose_tpl">
        <td>1</td>
        <td>3串1</td>
        <td class="tl">周四003(胜)x周四004(胜)</td>
        <td class="last_td">53.23元</td>
      </tr>
  </table>

  </div>
<!--footer start-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<div id="ft">
  
  <textarea id="responseJson" style="display: none;">{
	period :      "",   //期号
	serverTime :  "2011-07-20 17:56:57",   //服务器时间
	endTime :     "",    //截止时间
	singlePrice : 0,   //单注金额
	baseUrl : "http://trade..com"  //网站根目录
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
  <div style="top:700px;display:none;position:absolute;width: 500px;" class="tips_m" id="info_dlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>温馨提示</h2>
          <span class="close" id="info_dlg_close"><a href="#">关闭</a></span> </div>
        <div class="alert_c">
          <div class="state error">
            <div class="stateInfo f14 p_t10" id="info_dlg_content"></div>
          </div>
        </div>
        <div class="tips_sbt">
          <input class="btn_Dora_b" value="确 定" id="info_dlg_ok" type="button">
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
<script type="text/javascript" src="js/yclass.js"></script>
<script type="text/javascript" src="js/loginer.js"></script>
<script type="text/javascript" src="js/tabs.js"></script>
<script type="text/javascript" src="js/detail_lq.js"></script>
<script type="text/javascript" src="js/jclq.js"></script>
<script type="text/javascript" src="js/predict.js"></script>
<div style="display: none;" id="#title_folat">
  <table class="dc_table" border="0" cellpadding="0" cellspacing="0" width="100%">
    <colgroup>
    <col width="10%" />
    <col width="8%" />
    <col width="12%" />
    <col width="30%" />
    <col width="8%" />
    <col width="11%" />
    <col width="8%" />
    <col width="8%" />
    <col width="" />
    </colgroup>
    <tbody>
      <tr class="">
        <th>赛事编号</th>
        <th>赛事类型</th>
        <th> <select id="select_time" style="font-size: 12px; width: 72px;">
            <option selected="selected" value="0">截止时间</option>
            <option value="1">开赛时间</option>
          </select>
        </th>
        <th>客队 VS 主队</th>
        <th>数据</th>
        <th> <select id="select_pv" style="font-size: 12px; width: 72px;">
            <option selected="selected" value="0">平均欧赔</option>
            <option value="1">投注比例</option>
          </select>
        </th>
        <th>主负</th>
        <th>主胜</th>
        <th class="last_th">走势</th>
      </tr>
    </tbody>
  </table>
</div>
<div style="position: absolute; display: none; z-index: 9999;" id="livemargins_control"><img src="jclq_spf_files/monitor-background-horizontal.png" style="position: absolute; left: -77px; top: -5px;" height="5" width="77"> <img src="jclq_spf_files/monitor-background-vertical.png" style="position: absolute; left: 0pt; top: -5px;"> <img id="monitor-play-button" src="jclq_spf_files/monitor-play-button.png" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5" style="position: absolute; left: 1px; top: 0pt; opacity: 0.5; cursor: pointer;"></div>
<div class="tips_m" style="top: 700px; width: 500px; display: none; position: absolute;" id="yclass_alert">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2 id="yclass_alert_title">温馨提示</h2>
        <span class="close" id="yclass_alert_close"><a href="#">关闭</a></span> </div>
      <div class="alert_c">
        <div class="state error">
          <div class="stateInfo f14 p_t10" id="yclass_alert_content"></div>
        </div>
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
