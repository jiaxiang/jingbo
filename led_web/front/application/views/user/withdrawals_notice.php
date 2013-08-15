<?php
$data['site_config'] = Kohana::config('site_config.site');
$host = $_SERVER['HTTP_HOST'];
$dis_site_config = Kohana::config('distribution_site_config');
if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
	$data['site_config']['description'] = $dis_site_config[$host]['description'];
} 
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box mt5 tblase">
    <TR>
      <TD  align="center" valign="middle" bgcolor="#e8f2ff"  class="blue bold" rowSpan=3>取款方式</TD>
      <TD align="center" valign="middle" bgcolor="#e8f2ff" class="blue bold" width="11%" rowSpan=3>条件</TD>
      <TD height="30" align="center" valign="middle" bgcolor="#e8f2ff" class="blue bold" colSpan=2>一般到账时间(5000元以下)</TD>
      <TD height="28" align="center" valign="middle" bgcolor="#e8f2ff" class="blue bold" colSpan=3>手续费</TD>
    </TR>
    <TR>
      <TD 
                        width="18%" height="25" align="center" valign="middle" bgcolor="#e8f2ff" class="blue bold">提交时间周二至周五</TD>
      <TD align="center" valign="middle" bgcolor="#e8f2ff" class="blue bold"
                        width="21%">提交时间17：30-次日8点</TD>
      <TD align="center" valign="middle" bgcolor="#e8f2ff" class="blue bold" rowSpan=2 
                        width="7%">上海</TD>
      <TD align="center" valign="middle" bgcolor="#e8f2ff" class="blue bold" rowSpan=2 
                        colSpan=2>非上海地区</TD>
    </TR>
    <TR>
      <TD height="25" align="center" valign="middle" bgcolor="#e8f2ff" class="blue bold">
        8：00-17：30</TD>
      <TD align="center" valign="middle" bgcolor="#e8f2ff" class="blue bold">
        /周六/周日/周一</TD>
    </TR>
    <TR>
      <TD  rowSpan=5 align="center">银行转账</TD>
      <TD height="25" align="center" >中国银行</TD>
      <TD  rowSpan=4 align="center">12—24小时</TD>
      <TD  rowSpan=4 align="center">12—48小时</TD>
      <TD  rowSpan=4 align="center">免费</TD>
      <TD 
                        width="20%">RMB＜2000元按照0.1％收取；2000≤RMB＜5万元/每笔2元</TD>
      <TD rowSpan=4 
                    width="13%">5万≤RMB/每笔10元</TD>
    </TR>
    <TR>
      <TD height="25" align="center">建设银行</TD>
      <TD>0＜RMB＜5万元/每笔2元</TD>
    </TR>
    <TR>
      <TD height="25" align="center" >工商银行</TD>
      <TD>RMB＜800元按照0.27%收取；800≤RMB＜5万元/每笔2元</TD>
    </TR>
    <TR>
      <TD height="25" align="center" >交通银行</TD>
      <TD>RMB＜500元按汇款额0.4%收取；500≤RMB＜5万元/每笔2元</TD>
    </TR>
    <TR>
      <TD height="25" align="center" >其他银行</TD>
      <TD align="center" >1-2个工作日 </TD>
      <TD align="center" >2-3个工作日</TD>
      <TD 
                        colSpan=3>一般每笔最低0.9元，其他按取汇款额的0.25%银行收取手续费(依建行标准)</TD>
    </TR>
    <TR>
      <TD align="center" >支付宝</TD>
      <TD height="25" align="center" >支付宝用户</TD>
      <TD align="center" >2—12小时</TD>
      <TD align="center" >4—24小时</TD>
      <TD  colSpan=3 align="center">免手续费</TD>
    </TR>
    <TR>
      <TD colSpan=7><P>若需一次性大额提款请直接致电客服：<?php echo $data['site_config']['kf_phone_num'];?> <?php echo $data['site_config']['kf_phone_num2'];?>
        手续费是银行转帐收取，如遇银行活动手续费会有变化，取款金额以实际到帐为准。如遇特殊原因（银行系统故障/升级等）取款到账时间会受影响。</P></TD>
    </TR>
</TABLE>