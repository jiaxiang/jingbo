<?php defined('SYSPATH') or die('No direct access allowed.');?>
<script type="text/javascript" src="<?php echo url::base();?>js/message.js"></script>
<script type="text/javascript">
    $(function() {
        //导出单据事件
        $("#do_export").click(function(){
            var i = false;
            $('.sel').each(function(){
                if(i == false){
                    if($(this).attr("checked")==true){
                        i = true;
                    }
                }
            });
            if(i == false){
                showMessage('操作失败', '<font color="#990000">请选择所要导出的收款单！</font>');
                return false;
            }
            $('#list_form').attr('action','<?php echo url::base();?>order/order_doc/payment_export');
            $('#list_form').submit();
            return false;
        });
        /**
         * 收款单批量删除
         */
        $('#delete_all').click(function(){
            var list_form   = $('#list_form');
            var ids_checked = $('input[class="sel"]:checked').length;
            if (ids_checked > 0) {
                confirm("确定删除所有被选中的项吗?",function(){
               	    ajax_block.open();
               	    list_form.attr('action','<?php echo url::base();?>order/order_doc/payment_delete');
                    list_form.submit();
                });
            } else {  
                showMessage('操作失败', '<font color="#990000">请选择所要删除的单据！</font>');
            }
            return false;
        });
    });

</script>
<!-- header_content -->
<div class="new_content">
    <div class="newgrid">
        <div class="newgrid_tab fixfloat">
           <?php $mac = 'payment';include('order_doc_menu.php');?>
        </div>
        <div class="newgrid_top">
            <ul class="pro_oper">
                <li>
                    <a href="javascript:void(0);" id="do_export"><span class="batch_pro">导出单据</span></a>
                </li>
                <li>
                    <a href="javascript:void(0);" id="delete_all"><span class="del_pro">批量删除</span></a>
                </li>
            </ul>
            <form action="<?php echo url::base() . url::current();?>" method="GET" name="search_form" class="new_search" id="search_form">
                <input type="hidden" value="0" id="adv_bar_nor" name="adv_bar">
                <div>搜索:
                    <select name="search_type" class="text">
                        <option value="payment_num" <?php if(isset($where['search_type']) && $where['search_type'] == 'payment_num')echo "SELECTED";?>>收款单号</option>
                        <option value="email" <?php if(isset($where['search_type']) && $where['search_type'] == 'email')echo "SELECTED";?>>Email</option>
                    </select>
                    <input type="text" name="search_value" class="text" value="<?php isset($where['search_value']) && !empty($where['search_value']) && print($where['search_value']);?>">
                    <input type="submit" value="搜索" class="ui-button-small ui-widget ui-state-default ui-corner-all" role="button" aria-disabled="false">
                </div>
            </form>
        </div>
        <?php if (is_array($payment_list) && count($payment_list)) {?>        
        <form id="list_form" name="list_form" method="post" action="<?php echo url::base() . url::current();?>">
            <table cellspacing="0" class="table_overflow">
                <thead>
                    <tr class="headings">
                        <th width="30"><input type="checkbox" id="check_all"></th>
                        <th width="80">查看详情</th>
                        <th width="100">收款单状态</th>
                        <th width="150">收款单号</th>
                        <th width="150">订单号</th>
                        <th width="150">email</th>
                        <th width="80">支付方式</th>
                        <th width="50">币种</th>
                        <th width="80">支付金额</th>
                        <th width="100">添加时间</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($payment_list as $key1=>$payment):?>
                    <tr>
                        <td>
                            <input class="sel" name="payment_ids[]" value="<?php echo $payment['id'];?>" type="checkbox" temp="<?php echo $key1;?>">
                        </td>
                        <td>
                            <a href="<?php url::base()?>/order/order_doc/payment_detail/<?php echo $payment['id']?>" class="payment_doc_btn" name="payment" target="_blank">查看</a>
                        </td>
                        <td title='<?php echo $payment['payment_status']?>'><?php echo $payment['payment_status']?></td>
                        <td><?php echo $payment['payment_num']?></td>
                        <td><?php echo $payment['order_num']?></td>
                        <td><?php echo $payment['email']?></td>
                        <td><?php echo $payment['payment_method']?></td>
                        <td><?php echo $payment['currency']?></td>
                        <td><?php echo $payment['amount']?></td>
                        <td><?php echo $payment['date_add']?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </form>
        <?php }else {?>
        <?php echo remind::no_rows();?>
        <?php }?>         
    </div>
</div>
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