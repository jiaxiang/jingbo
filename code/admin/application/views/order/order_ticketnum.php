<script language="javascript">
setInterval("refresh()", 120000);
function refresh(){
  window.location.reload();
}
</script>
<!--**content start**-->
<div class="new_content">
    <div class="newgrid">
        <div class="newgrid_tab fixfloat">
            <ul>
            <li <?php if ($status == 'all') echo 'class="on"';?>><a href="/order/ticketnum">彩票管理</a></li>
            <li <?php if ($status == 'input_bonus') echo 'class="on"';?>><a href="/order/ticketnum/index/input_bonus">待录奖</a></li>
            <li <?php if ($status == 'noticket') echo 'class="on"';?>><a href="/order/ticketnum/index/noticket">未出票彩票</a></li>
            <li <?php if ($status == 'hasticket') echo 'class="on"';?>><a href="/order/ticketnum/index/hasticket">已出票彩票</a></li>
            <li <?php if ($status == 'hasbonus') echo 'class="on"';?>><a href="/order/ticketnum/index/hasbonus">已兑奖彩票</a></li>
            <li <?php if ($status == 'hasprice') echo 'class="on"';?>><a href="/order/ticketnum/index/hasprice">已中奖彩票</a></li>
            <li <?php if ($status == 'invalid') echo 'class="on"';?>><a href="/order/ticketnum/index/invalid">作废彩票</a></li>
            <li <?php if ($status == 'confirm_invalid') echo 'class="on"';?>><a href="/order/ticketnum/index/confirm_invalid">确认作废彩票</a></li>
            <li <?php if ($status == 'ticket_tj') echo 'class="on"';?>><a href="/order/ticketnum/index/ticket_tj">彩票统计</a></li>
            </ul>
        </div>
        <div class="newgrid_top">
            <ul class="pro_oper">
            
<?php
switch ($status)
{              
	case 'noticket':
		echo '<li><a href="javascript:void(0);"><span class="rec_pro" id="batch_yes">设为已出票</span></a></li>';
		echo '<li><a href="javascript:void(0);"><span class="del_pro" id="batch_invalid">设为已作废</span></a></li>';
		break;
	case 'hasticket':
		echo '<li><a href="javascript:void(0);"><span class="rec_pro" id="batch_no">设为未出票</span></a></li>';
		echo '<li><a href="javascript:void(0);"><span class="rec_pro" id="batch_duijiang">设为已兑奖</span></a></li>';
		break;
	case 'hasbonus':
		break;		
	case 'invalid':
		echo '<li><a href="javascript:void(0);"><span class="del_pro" id="batch_confirm_invalid">确认作废</span></a></li>';
		break;		
	case 'confirm_invalid':
		break;  		
	default:
}            
?>
<?php if ($status == 'ticket_tj') {?><li><span>共<?=$count?>张，共计<?=$total_money?>元</span></li><?php }?>

                <?php /** echo role::view_check('<li><a href="javascript:void(0);" id="do_export"><span class="batch_pro">导出订单</span></a></li>', 'order_export');?>
                <li class="down" id="export_product"><span class="batch_pro left">批量操作</span><span class="down_arrow left"></span>
                    <ul class="level_2">
                        <!--li><a id="shipping_processing" href="javascript:void(0)">批量配货</a></li-->
                        <li><a href="javascript:void(0);" id="order_cancel">设为已打票</a></li>
                        <?php 可显示废除按钮的状态  ?>
                        <?php if(in_array($status,$show_cancel_btn_quick_search)):?>
                            <?php echo role::view_check('<li><a href="javascript:void(0);" id="order_cancel">批量废除</a></li>', 'order_edit');?>
                        <?php endif;?>
                    </ul>
                </li>
                <?php
                **/
				?>
            </ul>
            
            <form id="search_form" name="search_form" class="new_search" method="GET" action="<?php echo url::base() . url::current();?>">
                <div style="padding-right:100px;">搜索：
                    <select name="search_type" class="text">
                    <?php
                    if ($status == 'ticket_tj') { 
                    ?>
                    <option value="port" <?php if ($where['search_type'] == 'port')echo "SELECTED";?>>端口号</option>
                    <?php
                    }
                    else { 
                    ?>
                    <option value="id" <?php if ($where['search_type'] == 'id')echo "SELECTED";?>>ID</option>
                    <option value="codes" <?php if ($where['search_type'] == 'codes')echo "SELECTED";?>>彩票代码</option>
                    <option value="order_num" <?php if ($where['search_type'] == 'order_num')echo "SELECTED";?>>订单号码</option>
                    <?php
                    } 
                    ?>
                    </select>
                    <input type="text" name="search_value" class="text" value="<?php echo $where['search_value'];?>">
                      时间：<input type="text" id="start_time" name="start_time" value="<?php if (isset($where['start_time'])) echo $where['start_time'];?>" class="text" size="10" />
        			<script type="text/javascript">$(function() { $("#start_time").datepicker({ currentText: 'Now',dateFormat: "yy-mm-dd" }); });</script>
        			到<input type="text" id="end_time" name="end_time" value="<?php if (isset($where['end_time'])) echo $where['end_time'];?>" class="text" size="10" />
        			<script type="text/javascript">$(function() { $("#end_time").datepicker({ currentText: 'Now',dateFormat: "yy-mm-dd" }); });</script>
                    <input type="submit" name="Submit2" value="搜索" class="ui-button-small">
                </div>
            </form>            

        </div>
        <?php if (is_array($list) && count($list)) {?>
        <table cellspacing="0" class="table_overflow">
            <form id="list_form" name="list_form" method="post" action="<?php echo url::base() . url::current();?>">
                <thead>
                    <tr class="headings">
                        <th width="20"><input type="checkbox" id="check_all"></th>
                        <th width="40">彩票ID<br />订单ID</th>
                        <th width="60">彩种玩法</th>
                        <th width="140">订单号</th>
                        <th width="70">用户</th>
                        <th >彩票代码</th>
                        <th width="25">倍数</th>
                        <th width="30">金额</th>
                        <th width="40">状态</th>
                        <th width="120">下单/出票/兑奖</th>
                        <th width="40">操作人</th>
                        <th width="40">端口</th>
                        <th width="50">操作</th>
                    </tr>
                </thead>
                <tbody>
                        <?php foreach ($list as $key=>$rs) { ?>
                    	<tr>
                        <td><input class="sel" name="order_ids[]" value="<?php echo $rs['id'];?>" type="checkbox"></td>
                        <td>
                        <?php echo $rs['id'];?><br />
                        <?php 
						if (!empty($plans_basic[$rs['order_num']]))
						{
							echo $plans_basic[$rs['order_num']]['id'];	
						}?>
						</td>
                        
                        <td>
                        <?php if(!empty($account_type['type'][$rs['ticket_type']])) echo $account_type['type'][$rs['ticket_type']];?>
                        <br />
                        <?php if(!empty($account_type['method'][$rs['ticket_type']][$rs['play_method']])) echo $account_type['method'][$rs['ticket_type']][$rs['play_method']];?>
                        </td>
                        
                        
                        <td><a href="/order/order?search_type=order_num&search_value=<?php echo $rs['order_num'];?>" target="_blank"><?php echo $rs['order_num'];?></a></td>
                        <td><?php if(!empty($users[$plans[$rs['ticket_type']][$rs['plan_id']]['user_id']]['lastname'])) echo '<a href="/user/user/account/'.$users[$plans[$rs['ticket_type']][$rs['plan_id']]['user_id']]['id'].'" target="_blank">'.$users[$plans[$rs['ticket_type']][$rs['plan_id']]['user_id']]['lastname'].'</a>';?></td>
                        <td style="white-space:inherit;word-wrap:break-word;word-break:normal;"><?php echo $rs['codes'];?> <?php if($rs['ticket_type']==2) echo '<a href="http://'.$site_config['name'].'/zcsf/viewdetail_codes/'.$rs['order_num'].'" target="_blank">(详细)</a>'?>
                        <?php
                        if(!empty($rs['bonus']))
						{
							echo '<br />';
							echo '彩票号码:'.$rs['num'].' ,密码:'.$rs['num'];
						}
						?>
                        </td>
                        <td><?php echo $rs['rate'];?></td>
                        <td><?php echo $rs['money'];?></td>
                        <td><?php
						switch ($rs['status'])
						{
							case 0:
								echo '<font color=red>未出票</font>';
								break;
						    case 1:
								echo '<font color=green>已出票</font>';
								break;
						    case 2:
								if ($rs['bonus']!=-9999)
								{
									echo '<font color=blue>已兑奖</font>';
								}
								else
								{
									echo '<font color=blue>待录奖</font>';	
								}
								if (!empty($rs['bonus']))
									echo '<br><font color=blue><b>已中奖</b></font><br>'.$rs['bonus'];
								break;
						    case -1:
								echo '<font color="#aaa"><s>已作废</s></font>';
								break;
						    case -2:
								echo '<font color="#aaa"><u><s>确认作废</s></u></font>';
								break;
							default:
								break;
						}
						?></td>
                        
                        <td><?php if(empty($rs['time_add'])){echo '...';}else{echo $rs['time_add'];}?><br />
                        <?php if(empty($rs['time_print'])){echo '...';}else{echo $rs['time_print'];}?><br />
                        <?php 
                        if(empty($rs['time_duijiang'])) {
                        	echo '...';
                        }
                        else {
                        	if (isset($rs['time_add'])) {
                        		$time_add_date = date('Y-m-d', strtotime($rs['time_add']));
                        		$time_add_date_s = strtotime($time_add_date);
                        		//echo $time_add_date_s;
                        		$time_duijiang_date = date('Y-m-d', strtotime($rs['time_duijiang']));
                        		$time_duijiang_date_s = strtotime($time_duijiang_date);
                        		//echo $time_duijiang_date_s-$time_add_date_s;
                        		if ($time_duijiang_date_s - $time_add_date_s > 86400) {
                        			echo '<span style="color:red;">'.$rs['time_duijiang'].'</span>';
                        		}
                        		else {
                        			echo $rs['time_duijiang'];
                        		}
                        	}
                        	else {
                        		echo $rs['time_duijiang'];
                        	}
                        }
                        ?><br />
						</td>
                       <td><?php if(!empty($rs['manager_id'])) echo $managers[$rs['manager_id']];?></td>
                       <td><?php if(!empty($rs['port'])) echo $rs['port']; else echo '未分配';?></td>
                       <td>
						<?php
					    if ($status == 'invalid') 
						{
                        }
						else
						{
							if ($rs['status']==1 || ($rs['status']==2 && $rs['bonus']==-9999))
							{
								echo '<a href="/order/ticketnum/set_bonus/'.$rs['id'].'/'.$_GET['page'].'">录入奖金</a>';	
							}							
						}
						?>
                        </td>                 
                    </tr>
				<?php }?>
                </tbody>
                <input type="hidden" value="" id="content_user_batch" name="content_user_batch">
                <input type="hidden" value="" id="content_admin_batch" name="content_admin_batch">
            </form>
        </table>
            <?php }else {?>
            <?php echo remind::no_rows();?>
            <?php }?>
    </div>
</div>
<!--**content end**-->
<!--FOOTER-->
<div class="new_bottom fixfloat">
    <div class="b_r_view new_bot_l">
        <?php echo view_tool::per_page(); ?>
    </div>

    <div class="Turnpage_rightper">
        <div class="b_r_pager">
            <?PHP echo $this->pagination->render('opococ'); ?>
        </div>
    </div>
</div>
<!--END FOOTER-->

<!-- 批量废除订单 -->
<div id="order_cancel_content" title="设为已打票" style="display:none;">
    <div class="dialog_box">
        <div class="out_box">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td colspan="2">
                            <h3 class="title1_h3">确定要打印选中的彩票?</h3>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="list_save">
        <input name="order_cancel_btn" onclick="order_cancel();" type="button" value=" 确认 " class="ui-button"/>
        <input name="cancel" id="cancel_btn" type="button" value=" 取消 " class="ui-button" onclick='$("#order_cancel_content").dialog("close");'/>
    </div>
</div>

<!-- 批量配货 -->
<div id="shipping_processing_dialog" title="批量配货" style="display:none;">
    <div class="dialog_box">
        <div class="out_box">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td colspan="2">
                            <h3 class="title1_h3">确认选择的订单是要处理为配货中！</h3>
                        </td>
                    </tr>
                    <tr>
                        <th>备注(管理员)：</th>
                        <td>
                            <textarea type="textarea" class="text" rows="3" cols="60" name="content_admin" id="content_admin"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>备注(会员)：</th>
                        <td>
                            <textarea type="textarea" class="text" rows="3" cols="60" name="content_user" id="content_user"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="list_save">
        <input name="order_cancel_btn" onclick="shipping_processing();" type="button" value=" 确认 " class="ui-button"/>
        <input name="cancel" id="cancel_btn" type="button" value=" 取消 " class="ui-button" onclick='$("#shipping_processing_dialog").dialog("close");'/>
    </div>
</div>
<script type="text/javascript">        
	//设为未出票
		$("#batch_no").click(function(){
		var i = false;
		$('.sel').each(function(){
			if(i == false){
				if($(this).attr("checked")==true){
					i = true;
				}
			}
		});
		if(i == false){
			alert('请选择要设为未出票的彩票！');
			return false;
		}
		if(!confirm('设为未出票的彩票只是针对"已出票"状态做的返回操作,不会对其他状态的彩票做出改变，确认要进行此操作吗？')){
			return false;
		}
		$('#list_form').attr('action','/order/ticketnum/set_no');
		$('#list_form').submit();
		return false;
		});
	
		//设为已出票
		$("#batch_yes").click(function(){
		var i = false;
		$('.sel').each(function(){
			if(i == false){
				if($(this).attr("checked")==true){
					i = true;
				}
			}
		});
		if(i == false){
			alert('请选择要设为已出票的彩票！');
			return false;
		}
		if(!confirm('设为已出票的彩票只针对"未出票"状态进行操作,不会对其他状态的彩票做出改变，确认要进行此操作吗？')){
			return false;
		}
		$('#list_form').attr('action','/order/ticketnum/set_yes');
		$('#list_form').submit();
		return false;
		});	
		
		
		//设为已作废
		$("#batch_invalid").click(function(){
		var i = false;
		$('.sel').each(function(){
			if(i == false){
				if($(this).attr("checked")==true){
					i = true;
				}
			}
		});
		if(i == false){
			alert('请选择要设为已作废的彩票！');
			return false;
		}
		if(!confirm('设为已作废的彩票提交之后需要待审核人员确认作废之后才会生效，确认要进行此操作吗？')){
			return false;
		}
		$('#list_form').attr('action','/order/ticketnum/set_invalid');
		$('#list_form').submit();
		return false;
		});	
		
		
		//设为已兑奖
		$("#batch_duijiang").click(function(){
		var i = false;
		$('.sel').each(function(){
			if(i == false){
				if($(this).attr("checked")==true){
					i = true;
				}
			}
		});
		if(i == false){
			alert('请选择要设为已兑奖的彩票！');
			return false;
		}
		if(!confirm('设为已兑奖的彩票只针对"已出票"的彩票进行操作,不会对其他状态的彩票做出改变，确认要进行此操作吗？')){
			return false;
		}
		$('#list_form').attr('action','/order/ticketnum/set_duijiang');
		$('#list_form').submit();
		return false;
		});
		
            <?php 
			if ($status == 'invalid') 
			{
			?>		
		
		//设为确认已作废
		$("#batch_confirm_invalid").click(function(){
		var i = false;
		var j = 0;
		$('.sel').each(function(){
			if(i == false){
				if($(this).attr("checked")==true){
					i = true;
				}
			}
		});
		if(i == false){
			alert('请选择要设为确认已作废的彩票！');
			return false;
		}
		$('.sel').each(function(){
			if($(this).attr("checked")==true){
				j++;
			}
		});
		//if(j > 1){
		//	alert('每次只能选择1张彩票！');
		//	return false;
		//}
		if(!confirm('设为确认已作废的彩票将会返还用户相应的金额，确认要进行此操作吗？')){
			return false;
		}
		$('#list_form').attr('action','/order/ticketnum/set_confirm_invalid');
		$('#list_form').submit();
		return false;
		});	
		
		<?php
			}
		?>
		
		
		
</script>


