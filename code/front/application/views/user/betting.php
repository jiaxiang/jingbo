  <div id="touzhu" class="fl"><span class="font14 bold blue">投注记录</span>(您可以查询近3个月的记录，默认查询最近一周的记录) </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl mt5" id="betting_box">
<script>  
function checkSearchForm(){
}  
</script>  
   <form id="searchForm" name="searchForm" method="get" action="/user/betting" onSubmit="return checkSearchForm()">
  <tr>
    <td height="10" colspan="3"></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td height="30" valign="middle" class="black">【查询彩种】</td>
    <td height="30" align="left" valign="middle">
    <select name="ticket_type" id="ticket_type">
      <option value="0"<?php if (empty($get_data['ticket_type'])){echo " selected=\"selected\"";}?>>所有彩种</option>
      <?php
      foreach ($ticket_type['type'] as $key => $val) {
      ?>
      <option value="<?php echo $key;?>" <?php if ($get_data['ticket_type'] == $key){echo "selected=\"selected\"";}?>><?php echo $val;?></option>
      <?php 
      } 
      ?>
    </select>
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td height="30" valign="middle" class="black">【查询状态】</td>
    <td height="30" align="left" valign="middle">
    <select name="plan_status" id="plan_status">
      <option value="-1" <?php if (!isset($get_data['plan_status'])){echo "selected=\"selected\"";}?>>所有状态</option>
      <option value="0" <?php if ($get_data['plan_status'] === 0){echo "selected=\"selected\"";}?>>未满员</option>
      <option value="99" <?php if ($get_data['plan_status'] == 99){echo "selected=\"selected\"";}?>>已中奖</option>
      <option value="6" <?php if ($get_data['plan_status'] == 6){echo "selected=\"selected\"";}?>>已撤单</option>
    </select>
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td height="30" valign="middle" class="black">【查询时间】</td>
    <td height="30" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="14%" align="left" valign="middle">
          <input onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'2030-10-01\'}'})" name="start_time" type="text" id="start_time" value="<?php 
		  if (!empty($get_data['start_time']))
		  {
		   	   echo  $get_data['start_time'];
		  }
		  else
		  {
			  echo date("Y-m-d",strtotime("-7 day"));
		  }	  
		  ?>"  style="width:100px;" />
        </td>
        <td width="4%" align="center" valign="middle">至</td>
        <td width="82%" align="left" valign="middle">
        <input onFocus="WdatePicker({minDate:'#F{$dp.$D(\'start_time\')}',maxDate:'2030-10-01'})" name="end_time" type="text" id="end_time" value="<?php 
		  if (!empty($get_data['end_time']))
		  {
		   	   echo  $get_data['end_time'];
		  }
		  else
		  {
			   echo date("Y-m-d",time());
		  }?>" style="width:100px;"  /></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td width="2%">&nbsp;</td>
    <td width="10%" height="30" valign="middle" class="black">【查询类别】</td>
    <td width="88%" height="30" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="3%" align="left" valign="middle"><input type="radio" name="type" id="type" value="0"<?php if (empty($get_data['type'])){echo " checked";}?> checked onclick="javascript:document.searchForm.submit();" /></td>
        <td width="5%" align="left" valign="middle">全部</td>
        <!-- 
        <td width="3%" align="left" valign="middle"><input type="radio" name="type" id="type" value="win"<?php if ($get_data['type']=="win"){echo " checked";}?> onclick="javascript:document.searchForm.submit();" /></td>
        <td width="5%" align="left" valign="middle">中奖</td>
        -->
        <td width="3%" align="left" valign="middle"><input type="radio" name="type" id="type" value="start"<?php if ($get_data['type']=="start"){echo " checked";}?> onclick="javascript:document.searchForm.submit();" /></td>
        <td width="7%" align="left" valign="middle">我的发起</td>
        <td width="3%" align="left" valign="middle"><input type="radio" name="type" id="type" value="join"<?php if ($get_data['type']=="join"){echo " checked";}?> onclick="javascript:document.searchForm.submit();" /></td>
        <td width="73%" align="left" valign="middle">我的跟单</td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td height="5" colspan="3"></td>
  </tr>
  <!-- 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>
    <div class="orange_btn fl white"><span><a href="javascript:document.searchForm.submit();">查询</a></span></div>
    </td>
  </tr>
   -->
   
   <tr>
    <td width="2%">&nbsp;</td>
    <td width="10%" height="30" valign="middle" class="black">【当前汇总】</td>
    <td width="88%" height="30" valign="middle">方案：<span style="font-weight:bold; color:#FF0000;"><?php echo $hz['c'];?></span>个&nbsp;我的认购：<span style="font-weight:bold; color:#FF0000;"><?php echo $hz['use_money'];?></span>元&nbsp;我的奖金：<span style="font-weight:bold; color:#FF0000;"><?php echo $hz['my_bonus'];?></span>元
    </td>
  </tr>
   
  <tr>
    <td height="10" colspan="3"></td>
    </tr>
   </form> 
  </table>