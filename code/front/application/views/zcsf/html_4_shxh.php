<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-足彩胜负-4场进球彩-稍后选号</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/yclass',
 	'media/js/loginer',	
 	'media/js/choose_zc',	
 	'media/js/lastchoose',					
), FALSE);
echo html::stylesheet(array
(
 	'media/css/zc',
 	'media/css/style',
	'media/css/mask',
	'media/css/css1',		
), FALSE);

echo html::script(array
(
 	'media/js/wtid',				
), FALSE);

?>
</head>
<body class="b_bg">
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>zcsf/sfc_14c"><font class="blue">足彩胜负</font></a> &gt; 4场进球彩
	</div>
	<div style="float:right; margin-right:20px;">
		<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
	</div>
	<div style="clear:both;"></div>
</div>
<!--面包屑导航_end-->
<!--header end-->
<div id="bd">
 <div id="ft"> 
    <!--底部公共文件-->
    <div id="main">
      <div class="box_top">
        <div class="box_top_l"></div>
      </div>
      <div class="box_m">
        <div id="xx1" style="display:;">
        <table class="pub_table" id="vsTable" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <th width="35">场次</th>
              <th width="70">赛事</th>
              <th width="85">比赛时间</th>
              <th width="127">对阵</th>
              <th width="72">数据</th>
              <th width="150">平均赔率</th>
              <th width="180"> <table class="th_table" border="0" cellpadding="0" cellspacing="0" width="160">
                  <tbody>
                    <tr>
                      <th colspan="4">选号区</th>
                    </tr>
                    <tr>
                      <td width="40">0</td>
                      <td width="40">1</td>
                      <td width="40">2</td>
                      <td width="40">3+</td>
                    </tr>
                  </tbody>
                </table></th>
              <th width="43">全包</th>
              <th class="last_th"> <table class="th_table" border="0" cellpadding="0" cellspacing="0" width="160">
                  <tbody>
                    <tr>
                      <th colspan="4">投注比率</th>
                    </tr>
                    <tr>
                      <td width="40">0</td>
                      <td width="40">1</td>
                      <td width="40">2</td>
                      <td width="40">3+</td>
                    </tr>
                  </tbody>
                </table></th>
            </td>

  		<?php foreach($expect_list as $key=>$value){ ?>
              <tr data-vs="<?php echo $value['vs1'];?>">
              <td rowspan="2"><?php echo $value['changci'];?></td>
              <td rowspan="2" style="background:			  <?php 
			  if (array_key_exists($value['game_event'],$color_list))
			  { 		  
			  	echo $color_list[$value['game_event']];
			  }else{
				  echo $color_list['default'];
			  } 
			  ?>; color: rgb(255, 255, 255);" class="league"><a href="" target="_blank"><?php echo $value['game_event'];?></a></td>
              <td rowspan="2"><span class="eng"><?php echo substr($value['game_time'],5,11);?></span></td>
              <td>
              <span class="gray">主</span> 
              <?php 
              	if ($value['home_url'] != NULL) {
              		echo '<a href="'.$value['home_url'].'" target="_blank">'.$value['vs1'].'</a>';
              	}
              	else {
              		echo $value['vs1'];
              	}
              ?>
              </td>
              <td rowspan="2">
              <?php 
              	if ($value['xi_url'] != NULL) {
					echo '<a href="'.$value['xi_url'].'" target="_blank">析</a> ';              	
              	} 
              	else {
              		echo '析 ';
              	}
				if ($value['ya_url'] != NULL) {
					echo '<a href="'.$value['ya_url'].'" target="_blank">亚</a> ';              	
              	} 
              	else {
              		echo '亚 ';
              	}
				if ($value['ou_url'] != NULL) {
					echo '<a href="'.$value['ou_url'].'" target="_blank">欧</a> ';              	
              	} 
              	else {
              		echo '欧 ';
              	}
              ?>
              </td>  
			  <?php 
		        if(!empty($value['sp'])){
	        		$sp=json_decode($value['sp']);
					$zcsf_h=$sp->h->v;
					$zcsf_d=$sp->d->v;
					$zcsf_a=$sp->a->v;
        		}else{
        			$zcsf_h=$zcsf_d=$zcsf_a="-";
        		}
              ?>
              <td><span class="sp_w38 eng"><?php echo $zcsf_h?></span><span class="sp_w38 eng"><?php echo $zcsf_d?></span><span class="sp_w38 eng"><?php echo $zcsf_a?></span></td>
              <td><span class="sp_w40"><span class="sp_nxz">0</span></span><span class="sp_w40"><span class="sp_nxz">1</span></span><span class="sp_w40"><span class="sp_nxz">2</span></span><span class="sp_w40"><span class="sp_nxz">3+</span></span></td>
              <td><input type="checkbox"></td>
              <td class="last_td"><span class="sp_w40 eng">2%</span><span class="sp_w40 eng">33%</span><span class="sp_w40 eng">36%</span><span class="sp_w40 eng">29%</span></td>
            </tr>
            <tr data-vs="<?php echo $value['vs2'];?>">
              <td>
              <span class="gray">客</span> 
              <?php 
              	if ($value['away_url'] != NULL) {
              		echo '<a href="'.$value['away_url'].'" target="_blank">'.$value['vs2'].'</a>';
              	}
              	else {
              		echo $value['vs2'];
              	}
              ?>
              </td>
              <td><span class="sp_w40"><span class="sp_nxz">0</span></span><span class="sp_w40"><span class="sp_nxz">1</span></span><span class="sp_w40"><span class="sp_nxz">2</span></span><span class="sp_w40"><span class="sp_nxz">3+</span></span></td>
              <td><input type="checkbox"></td>
              <td class="last_td"><span class="sp_w40 eng">37%</span><span class="sp_w40 eng">35%</span><span class="sp_w40 eng">27%</span><span class="sp_w40 eng">0%</span></td>
            </tr>
		<?php }?>  


            </tbody>
          </table>
               <?php
				   $a=0;
				   $b=0;
				   $c=0;
				   foreach(explode(",",$detail['codes']) as $key=>$value){
				   if(strlen($value)==1) $a++;
				   if(strlen($value)==2) $b++;	   
				   if(strlen($value)==3) $c++;		   
			   }?>
          <div class="pick">当前状态：三选<span class="red eng" id="s3Span">0</span>个，双选<span class="red eng" id="s2Span">0</span>个，单选<span class="red eng" id="s1Span">0</span>个 | 当前金额：<span class="red eng" id="moneySpan">￥0.00</span>元</div>

          <div class="buy_sort"> <span class="title">方案基本信息</span> </div>
          <div id="dd2" style="display:;">
            <table class="buy_table" width="100%" border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td class="td_title p_tb8">预投信息</td>
                  <td class="td_content p_tb8"><span class="red eng" id="three"><?php echo $c; ?></span>个三选 <span class="red eng" id="two"><?php echo $b; ?></span>个双选 <span class="red eng" id="one"><?php echo $a; ?></span>个单选 总金额<span class="red eng">￥<?php echo $detail['price'];?></span>元</td>
                </tr>
                <tr>
                  <td class="td_title p_tb8">方案编号</td>
                  <td class="td_content p_tb8"><?php echo $detail['basic_id']; ?></td>
                </tr>
                <tr>
                  <td class="td_title p_tb8">发起时间</td>
                  <td class="td_content p_tb8"><?php echo $detail['time_stamp']; ?></td>
                </tr>
                <tr>
                  <td class="td_title p_tb8">方案标题</td>
                  <td class="td_content p_tb8"><?php echo $detail['title']; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="buy_sort"> <span class="title">方案认购信息</span> </div>
        <div id="dd2" style="display:;">
          <table class="buy_table" width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
                <td class="td_title p_tb8">方案信息</td>
                <td class="td_content p_tb8">此方案倍投<?php echo $detail['rate'];?>倍，总金额<span class="red eng">￥<?php echo $detail['price'];?></span>元，共2份，每份<span class="red eng">￥<?php echo $detail['price_one'];?></span>元。 </td>
              </tr>
              <tr>
                <td class="td_title p_tb8">保底金额</td>
                <td class="td_content p_tb8">发起人保底 ￥<?php echo $detail['end_price'];?> 元 </td>
              </tr>
              <tr class="last_tr">
                <td class="td_title"></td>
                <td class="td_content"><div class="buy_btn"> <a href="/zcsf/shxh_4c/<?php echo $detail['basic_id'];?>" class="btn_buy_m" title="立即购买" id="buy_hm">立即购买</a> </div></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!------配置信息begin------>
<input name="ticket_type" id="ticket_type" value="2" type="hidden">
<!--彩种Id-->
<input name="play_method" id="play_method" value="<?php echo $detail['play_method'];?>" type="hidden">
<!--玩法Id--> 
<input name="pid" id="pid" value="<?php echo $detail['basic_id'];?>" type="hidden">
<!--方案Id-->
<input name="expect" id="expect" value="<?php echo $detail['expect'];?>" type="hidden">
<!--期号-->
<input name="lotname" id="lotname" value="0" type="hidden">
<!--彩种Id-->

<input name="tcSelect" id="tcSelect" value="<?php echo $detail['deduct'];?>" type="hidden">
<!--提成-->
<input name="end_time" id="end_time" value="<?php echo $detail['time_end'];?>" type="hidden">
<!--结束时间-->

<input name="playname" id="playname" value="复式合买" type="hidden">
<!--合买方式-->
<input name="ishm" id="ishm" value="1" type="hidden">
<!--是否合买-->
<input name="allmoney" id="allmoney" value="<?php echo $detail['price'];?>" type="hidden">
<!--方案金额-->
<input name="beishu" id="beishu" value="<?php echo $detail['rate'];?>" type="hidden">
<!--倍数-->
<input name="fsInput" id="fsInput" value="<?php echo $detail['copies'];?>" type="hidden">
<!--份数-->
<input name="bdInput" id="bdInput" value="<?php echo $detail['end_price'];?>" type="hidden">
<!--保底金额数-->
<input name="isshow" id="isshow" value="0" type="hidden">
<!--是否开放--> 
<!--需要JS提供-->
<input name="codes" id="codes" value="" type="hidden">
<!--号码--> 
<!------配置信息end------> 
<!--弹窗内容文件--> 
<!--未登录提示层-->
<?php echo View::factory('zcsf/public_div')->render();?>
<!--footer start-->
<?php echo View::factory('footer')->render();?>
  <!--footer end-->

<textarea id="responseJson" style="display: none;">{
	period :      "<?php echo $detail['expect'];?>",   //期号
	serverTime :  "<?php echo date("Y-m-d H:m:s");?>",   //服务器时间
	endTime :     "<?php echo $detail['time_end'];?>",    //截止时间
	singlePrice : 2,   //单注金额
	baseUrl : "<?php echo url::base();?>" , //网站根目录
}</textarea>
<div style="position: absolute; display: none; z-index: 9999;" id="livemargins_control"><img src="zcsf_shxh_files/monitor-background-horizontal.png" style="position: absolute; left: -77px; top: -5px;" width="77" height="5"> <img src="zcsf_shxh_files/monitor-background-vertical.png" style="position: absolute; left: 0pt; top: -5px;"> <img id="monitor-play-button" src="zcsf_shxh_files/monitor-play-button.png" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5" style="position: absolute; left: 1px; top: 0pt; opacity: 0.5; cursor: pointer;"></div>
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
      <div class="tips_info">
        <div class="stateInfo f14 p_t10" id="yclass_confirm_content" style="zoom:1"></div>
      </div>
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