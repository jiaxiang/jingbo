<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-竞彩足球-奖金明细</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::stylesheet(array
(
 	'media/css/zc',
    'media/css/style',
), FALSE);
?>
</head>
<body style="background:none;">
<div style="width:692px;" class="tips_m">
	<div class="tips_b">
		<div class="tips_box">
			<div class="tips_title">
				<h2>奖金明细</h2>
				<span class="close"><a href="javascript:void(0)" onclick="top.Y.closeUrl()">关闭</a></span>
			</div>
			<div class="tips_info" style="height:350px; overflow-y:auto; overflow-x:hidden; _width:632px">
				<div class="mx_tips">
					<h3 class="red">奖金明细</h3>
					<p class="tac">过关方式：<em class="red"><?php echo $results['typename'];?></em>，方案总奖金<em class="red"><?php echo sprintf("%01.2f", $results['bonus']);?></em>元</p>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					  <tbody>
					  <tr>
						<th>序号</th>
						<th class="tl" style="padding-left: 20px;">方案拆分</th>
						<th>过关方式</th>
						<th>倍数</th>
						<th class="last_th">奖金</th>
					  </tr>
					
                    

<?php
//d($data);

$i = 0;
foreach ($data as $rowdata)
{
	if(empty($rowdata['detail']))
		continue;
	
	foreach ($rowdata['detail'] as $rowdetail)
	{
		$i++;
		$arrselect = explode('/', $rowdetail[0]);
?>                    
                     <tr>
						<td><?php echo $i;?></td>
						<td class="tl">
    <p style="width:260px;word-wrap:break-word;word-break:break-all">
	<?php
    foreach ($arrselect as $rowselec)
    {	
        $arrrowselec = explode('|', $rowselec);
        $arrselect2 = explode('[', $arrrowselec[1]);
        $select = substr($arrselect2[1], 0, strlen($arrselect2[1]) -1);	
        $weeknum = substr($arrrowselec[1], 0, 1);
        $selectchar = '';
        if (!empty($config))
        {
            $selectchar = $config[$select];
        }
        echo  tool::get_cn_week_by_num($weeknum).substr($arrrowselec[1], 1, 3).'：'.$selectchar.'[<span class="red">'.$rowdata['odds'][$rowselec].'</span>]<br>';
    }
    ?>
		</p>
          </td>
						<td><?php echo count($arrselect);?>串1</td>
						<td><?php echo $rowdata['result']['rate'];?></td>
						<td class="last_td">￥<?php echo sprintf("%01.2f", $rowdetail[1]);?></td>
					  </tr>
                      
<?php
	}

}
?>                      
                      
                      
					  					  <tr class="last_tr">
						<td>合计:</td>
						<td colspan="3">&nbsp;</td>
						<td class="last_td"><em class="red">￥<?php echo sprintf("%01.2f", $results['bonus']);?></em>元</td>
					  </tr>
					  </tbody>
					</table>
					<p class="p_tb5">
						<strong class="red">提示：</strong><br>
						1、“奖金明细”只显示该方案中将的部分；<br>
						2、“奖金详情”中，投注选项后括号中的数字表示奖金。
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
</body></html>