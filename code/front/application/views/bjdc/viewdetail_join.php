<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-单场竞猜-订单详情</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
    'media/js/yclass.js',
	'media/js/loginer',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/szc',
	'media/css/mask',
    'media/css/style',
    'media/css/css1',
), FALSE);
?>
</head>
<body style="background:none;">
	<div style="width:700px;" >
     <div class="tips_b">
      <div class="tips_box" >
        <div class="tips_title">
        <h2>北京单场 <?php echo $user['lastname'];?> 合买方案</h2>
        <span class="close"><a href="javascript(void 0)" onclick="top.Y.closeUrl()">关闭</a></span>
        </div>
	    <div class="tips_info tips_info_np" style="height:450px;overflow-y:auto;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="faTable">
          <tr>
            <th>方案信息</th>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr class="tr1">
                  <td>玩法</td>
                  <td>注数</td>
                  <td>倍数</td>
                  <td>总金额</td>
                  <td>每份</td>
                  <td>保底</td>
                  <td>提成&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                  </tr>
                <tr>
                  <td>胜平负复式</td>
                  <td><?php echo $detail['copies']?>份</td>
                  <td><?php echo $detail['rate']?>倍</td>
                  <td><span class="red">￥<?php echo $detail['total_price']?></span></td>
                  <td>￥<?php echo $detail['price_one']?></td>
                  <td><?php 
								if(empty($detail['baodinum']))
								{
									echo '未保底';
								}
								else
								{
									echo $detail['baodinum'] * $detail['price_one'];
								}
								?></td>
                  <td class="last_td">
									<span class="red"><?php echo $detail['progress']?>%</span>
								</td>
                                  </tr>
              </table></td>
          </tr>
          <tr>
            <th>投注内容 </th>
            <td class="t2">    
            	<div style="word-break:break-all;word-wrap:break-word;">
						<div class="tdbback" id="fanandiv">
							<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tablelay eng">							
							  <tbody>
							  <tr>
								<th>赛事编号</th>
								<th>主队 VS 客队</th>
 								<th>让球数</th>                         
								<th>您的选择</th>
							  </tr>
                                    <?php foreach ($codes as  $key=>$value){?>
                                        <tr class="tr1" mid="<?php echo $matchs[$key]['id'];?>">
                                        <td style="width:12%"><?php echo $matchs[$key]['match_info'];?></td>
                                        <td><?php echo $matchs[$key]['host_name'];?> VS <?php echo $matchs[$key]['guest_name'];?></td>
                                        <td style="width:7%">0</td>
                                        <td style="width:12%"><?php if($matchs[$key]['status']==1)?></td>
                                        </tr>
                                    <?php }?>
                                    <tr class="last_tr">
                                    <td colspan="4">
                                    <table width="100%">
                                    <tr>
                                    <td style="border-right:none;">
                                    <p class="p_tj">
                                        过关方式：<span class="red"><?php echo $detail['typename'];?></span> 总金额：<span class="eng red">￥<?php echo $detail['total_price'];?></span>元&nbsp;&nbsp;<?php /**?><a href="javascript:void(0)" onclick="">查看拆分明细</a><?php **/?>
                                        <br />方案税后奖金：<span class="eng red">￥<?php echo $detail['bonus'];?></span>元								</p></td>
                                    <td colspan="2">&nbsp;</td>
                                    </tr>
                                    </table>
                                    </td>
                                    </tr>
							</table>
						</div>

			</div>
             </td>
      </tr>
      <tr>
        <th>认购信息</th>
        <td class="t2">您本次购买<strong class="eng red"><?php if($buynum){echo $buynum;}?></strong>份，需消费
        <strong class="eng red">￥<?php if($totalbuymoney)echo $totalbuymoney;?>.00</strong>元</td>
      </tr>
    </table>
      </div>
	  <div class="tips_sbt"><p align="center" style="padding-left:24px">
         <input type="button" class="btn_Lora_b" value="关 闭" onclick="top.Y.closeUrl()"/>
         <input type="button" class="btn_Dora_b" value="确 定" onclick="parent.regou();parent.Y.closeUrl();"/>
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>