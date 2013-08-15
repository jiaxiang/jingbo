<!--**content start**-->
<div class="new_content">
    <div class="newgrid">
        <div class="newgrid_tab fixfloat">
            <ul>
            <li <?php if(empty($status)) echo 'class="on"';?>><a href="/order/order">订单列表</a></li>
            <li <?php if($status == 'hasbuy') echo 'class="on"';?>><a href="/order/order/index/hasbuy">未满员</a></li>
            <li <?php if($status == 'noprint') echo 'class="on"';?>><a href="/order/order/index/noprint">未出票</a></li>
            <!--li <?php if($status == 'beexpired') echo 'class="on"';?>><a href="/order/order/index/beexpired">将要过期</a></li-->
            <li <?php if($status == 'hasexpired') echo 'class="on"';?>><a href="/order/order/index/hasexpired">已过期</a></li>
            <li <?php if($status == 'hasprint') echo 'class="on"';?>><a href="/order/order/index/hasprint">已出票</a></li>
            <li <?php if($status == 'nobonus') echo 'class="on"';?>><a href="/order/order/index/nobonus">未中奖</a></li>
            <!-- li <?php if($status == 'hasbonus') echo 'class="on"';?>><a href="/order/order/index/hasbonus">已中奖</a></li-->
            <li <?php if($status == 'r98') echo 'class="on"';?>><a href="/order/order/zc_r98">中八场</a></li>
            <li <?php if($status == 'givehonus') echo 'class="on"';?>><a href="/order/order/index/givehonus">已派奖</a></li>
            <li <?php if($status == 'cancel') echo 'class="on"';?>><a href="/order/order/index/cancel">已撤单</a></li>
            </ul>
        </div>
        <div class="newgrid_top">
            <ul class="pro_oper">
            <?php
			if ($status == 'hasbonus') 
			{
			?>
             <li><a href="javascript:void(0);"><span class="rec_pro" id="batch_givehonus">订单派奖</span></a></li>
            <?php
			}
			?> 
            <?php 
			if ($status == 'hasbuy' || $status == 'hasexpired') 
			{
			?>
             <li><a href="javascript:void(0);"><span class="del_pro" id="batch_invalid">订单取消</span></a></li>
            <?php
			}
			?> 
          </ul>
            <form id="search_form" name="search_form" class="new_search" method="GET" action="<?php echo url::base() . url::current();?>">
                <div style="padding-right:10px;">搜索：
                    <select name="search_type" class="text">
                        <option value="id" <?php if ($where['search_type'] == 'id')echo "SELECTED";?>>ID</option>
                        <option value="order_num" <?php if ($where['search_type'] == 'order_num')echo "SELECTED";?>>订单号码</option>
                        <option value="lastname" <?php if ($where['search_type'] == 'lastname')echo "SELECTED";?>>用户名</option>
                        <option value="plan_type" <?php if ($where['search_type'] == 'plan_type')echo "SELECTED";?>>购买方式</option>
                        <option value="ticket_type" <?php if ($where['search_type'] == 'ticket_type')echo "SELECTED";?>>彩种</option>
                    </select>
                    <input type="text" name="search_value" class="text" value="<?php echo $where['search_value'];?>">
                    时间：<input type="text" id="start_time" name="start_time" value="<?php if (isset($where['start_time'])) echo $where['start_time'];?>" class="text" size="10" />
        			<script type="text/javascript">$(function() { $("#start_time").datepicker({ currentText: 'Now',dateFormat: "yy-mm-dd" }); });</script>
        			到<input type="text" id="end_time" name="end_time" value="<?php if (isset($where['end_time'])) echo $where['end_time'];?>" class="text" size="10" />
        			<script type="text/javascript">$(function() { $("#end_time").datepicker({ currentText: 'Now',dateFormat: "yy-mm-dd" }); });</script>
                    <input type="submit" name="Submit2" value="搜索" class="ui-button-small">(购买方式:0代购1合买，彩种:1竞彩足球2足彩6竞彩篮球7北单8大乐透9排五10七星11排三)
                </div>
            </form>
        </div>
        <?php if (is_array($list) && count($list)) {?>
        <table cellspacing="0" class="table_overflow">
            <form id="list_form" name="list_form" method="post" action="<?php echo url::base() . url::current();?>">
                <thead>
                    <tr class="headings">
                        <th width="10"><input type="checkbox" id="check_all"></th>
                        <th width="30">订单ID</th>
                        <th width="20">类型</th>
                        <th width="40">彩种</th>
                        <th width="50">玩法</th>
                        <th width="110">订单号</th>
                        <th width="70">发起人</th>
                        <th width="40">金额</th>
                        <th width="40">进度</th>
                        <th width="40">奖金</th>
                        <th width="40">彩金</th>
                        <th width="40">状态</th>
                        <th width="120">下单时间/截止时间</th>
                        <th width="50">操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php //d($list);?>
                        <?php foreach ($list as $key=>$rs) { ?>
                    	<tr>
                        <td><input class="sel" name="order_ids[]" value="<?php echo $rs['id'];?>" type="checkbox"></td>
                        <td><?php echo $rs['id'];?></td>
                        <td><?php if($rs['plan_type']==0){echo '代购';}else{echo '合买';}?></td>
                        <td><?php if(!empty($ticket_type['type'][$rs['ticket_type']])) echo $ticket_type['type'][$rs['ticket_type']];?></td>
                        <td><?php if(!empty($ticket_type['method'][$rs['ticket_type']][$rs['play_method']])) echo $ticket_type['method'][$rs['ticket_type']][$rs['play_method']];?></td>
                        <td><a href="<?php echo $rs['plan_detail'];?>" target="_blank"><?php echo $rs['order_num'];?></a></td>
                        <td><?php if(!empty($rs['user']['lastname'])) echo '<a href="/user/user/account/'.$rs['user']['id'].'" target="_blank">'.$rs['user']['lastname'].'</a>';?></td>
                        <td><?php echo $rs['detail']['total_price'];?></td>
                        <td><?php echo $rs['detail']['progress'];?>%</td>
                        <td><?php if (isset($rs['plan_bonus']) && $rs['plan_bonus'] > 0) echo $rs['plan_bonus']; else echo 0;?></td>
                        <td>
                        <?php
                        if (!isset($rs['detail']['bonus'])) {
                        	$rs['detail']['bonus'] = 0;
                        }
                        $add_money = 0;
                        $add_money_obj = add_money::get_instance();
                        //if ($rs['status'] == 4 || $rs['status'] == 5) {
                        $r98_flag = false;
                        switch ($rs['ticket_type']) {
                        	case 2:
                        		if ($rs['status'] == 3) {
	                        		$add_money_total_r98 = $add_money_obj->get_bonus_add_money_zcr9_2($rs['detail']['total_price']);
	                        		if ($add_money_total_r98 > 0 && $rs['play_method'] == 2 && $rs['detail']['r98_jj'] == 1) {
	                        			$add_money = $add_money_total_r98;
	                        			$r98_flag = true;
	                        		}
                        		}
                        		if ($rs['status'] == 4 || $rs['status'] == 5) {
                        			$add_money_total_r9 = $add_money_obj->get_bonus_add_money_zcr9_1($rs['detail']['total_price']);
                        			if ($add_money_total_r9 > 0 && $rs['play_method'] == 2 && $rs['detail']['r98_jj'] == 0) {
                        				$add_money = $add_money_total_r9;
                        			}
                        		}
                        		break;
                        	case 1:
                        		if ($rs['status'] == 4 || $rs['status'] == 5) {
	                        		$add_money_total = $add_money_obj->get_bonus_add_money($rs['detail']['bonus']);
	                        		if ($add_money_total > 0) {
	                        			$add_money = $add_money_total;
	                        		}
                        		}
                        		break;
                        	case 6:
                        		if ($rs['status'] == 4 || $rs['status'] == 5) {
	                        		$add_money_total_jclq = $add_money_obj->get_bonus_add_money_jclq($rs['detail']['bonus']);
	                        		if ($add_money_total_jclq > 0 && $rs['ticket_type'] == 6) {
	                        			$add_money = $add_money_total_jclq;
	                        		}
                        		}
                        		break;
                        	default:break;
                        }
                        //}
                        echo $add_money;
                        ?>
                        </td>
                        <td><?php
                        /* if (!isset($rs['detail']['bonus'])) $rs['detail']['bonus'] = 0;
                        $add_money_obj = add_money::get_instance();
        				$add_money_total = $add_money_obj->get_bonus_add_money($rs['detail']['bonus']);
        				$add_money_total_jclq = $add_money_obj->get_bonus_add_money_jclq($rs['detail']['bonus']);
        				$add_money_total_r9 = $add_money_obj->get_bonus_add_money_zcr9_1($rs['detail']['total_price']);
        				$add_money_total_r98 = $add_money_obj->get_bonus_add_money_zcr9_2($rs['detail']['total_price']); */
						switch ($rs['status'])
						{
							case 0:
								echo '未满员';
								break;							
							case 1:
								echo '<font color=red>未出票</font>';
								
								if (strtotime($rs['date_end']) < time())
								{
									echo '<br><u><b><font color=red>已过期</font></u></b>';	
								}
								if (strtotime($rs['date_end']) < time()-$time_expired && strtotime($rs['date_end']) > time())
								{
									echo '<br><b><font color=red>将要过期</font></b>';	
								}								
								
								break;
						    case 2:
								echo '<font color=green>已出票</font>';
								break;
						    case 3:
								echo '<font color=blue>未中奖</font>';
								if (isset($r98_flag) && $r98_flag === true) {
									echo '<br /><font color="green">中八场</font>';
								}
								break;
						    case 4:
								echo '<b><font color=green>已中奖</font></b>';
								//echo '<br />'.$rs['detail']['bonus'];
								//echo '<br />'.$rs['plan_bonus'];
								/* if ($add_money_total > 0 && $rs['ticket_type'] == 1) {
									echo '<br /><font color="red">彩金'.$add_money_total.'</font>';
								}
								if ($add_money_total_jclq > 0 && $rs['ticket_type'] == 6) {
									echo '<br /><font color="red">彩金'.$add_money_total_jclq.'</font>';
								}
								if ($add_money_total_r9 > 0 && $rs['ticket_type'] == 2 && $rs['play_method'] == 2) {
									echo '<br /><font color="red">彩金'.$add_money_total_r9.'</font>';
								} */
								break;
						    case 5:
								echo '<b><font color=green><u>已派奖</u></font></b>';
								//echo '<br />'.$rs['detail']['bonus'];
								//echo '<br />'.$rs['plan_bonus'];
								/* if ($add_money_total > 0 && $rs['ticket_type'] == 1) {
									echo '<br /><font color="red">彩金'.$add_money_total.'</font>';
								}
								if ($add_money_total_jclq > 0 && $rs['ticket_type'] == 6) {
									echo '<br /><font color="red">彩金'.$add_money_total_jclq.'</font>';
								}
								if ($add_money_total_r9 > 0 && $rs['ticket_type'] == 2 && $rs['play_method'] == 2) {
									echo '<br /><font color="red">彩金'.$add_money_total_r9.'</font>';
								} */
								break;
						    case 6:
								echo '<font color="#aaa"><s>已撤单</s></font>';
								break;
							default:
								break;
						}
						if($rs['ticket_type'] == 1 && ($rs['status']==4 || $rs['status']==5))
						{
							echo '<br /><a href="http://'.$site_config['name'].'/jczq/bonus_info/'.$rs['order_num'].'" target="_blank">奖金明细</a>';	
						}
						if($rs['ticket_type'] == 6 && ($rs['status']==4 || $rs['status']==5))
						{
							echo '<br /><a href="http://'.$site_config['name'].'/jclq/bonus_info/'.$rs['order_num'].'" target="_blank">奖金明细</a>';
						}
						if($rs['ticket_type'] == 7 && ($rs['status']==4 || $rs['status']==5))
						{
							echo '<br /><a href="http://'.$site_config['name'].'/bjdc/bonus_info/'.$rs['order_num'].'" target="_blank">奖金明细</a>';
						}
						?>
						</td>
                        <td><?php echo $rs['date_add'];?><br/><?php echo $rs['date_end'];?>
						</td>
                        <td>
                        <?php
						if ($rs['status'] > 0)
						{
							echo '<a href="/order/ticketnum?search_type=order_num&search_value='.$rs['order_num'].'" target="_blank">彩票详细</a>';	
						}
						?>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
                <input name="backurl" type="hidden" value="<?php echo $status;?>" />
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
		//取消订单
		$("#batch_invalid").click(function(){
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
			alert('请选择要取消的订单！');
			return false;
		}
		$('.sel').each(function(){
			if($(this).attr("checked")==true){
				j++;
			}
		});
		if(j > 1){
			alert('每次只能选择1张订单！');
			return false;
		}
		if(!confirm('设为取消订单将会返还用户相应的金额，确认要进行此操作吗？')){
			return false;
		}
		$('#list_form').attr('action','/order/order/set_invalid');
		$('#list_form').submit();
		return false;
		});	
		
		//订单派奖
		$("#batch_givehonus").click(function(){
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
			alert('请选择确定要派奖的订单！');
			return false;
		}
		$('.sel').each(function(){
			if($(this).attr("checked")==true){
				j++;
			}
		});
		if(j > 1){
			alert('每次只能选择1张订单！');
			return false;
		}
		if(!confirm('派奖将会分发奖金到会员帐户，确认要进行此操作吗？')){
			return false;
		}
		$('#list_form').attr('action','/order/order/set_givebonus');
		$('#list_form').submit();
		return false;
		});		
</script>


