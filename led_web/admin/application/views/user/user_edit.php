<?php defined('SYSPATH') OR die('No direct access allowed.');?>
<!-- header_content -->
<div class="new_sub_menu">
    <div class="new_sub_menu_con">
        <div class="newgrid_tab fixfloat">
            <ul>
                <li class="on">编辑会员</li>
            </ul>
        </div>
    </div>
</div>
<!-- header_content(end) -->
<!--**content start**-->
<div id="content_frame">
    <div class="grid_c2">
        <div class="newgrid">
            <!--** edit start**-->
            <div class="out_box">
                <form id="add_form" name="add_form" method="post" action="<?php echo url::base() . url::current();?>">
                    <div class="out_box">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tbody>
                           	 <tr>
                                    <th>用户名：</th>
                                    <td>
                                    <label><?php echo $data['lastname'];?></label>
                                    </td>
                              </tr>
                                <tr>
                                    <th>邮箱：</th>
                                    <td>
                                    	<input type="text" size="60" name="email" class="text email required" value="<?php echo $data['email'];?>"><span class="required"> *</span>
                                    	<span class="brief-input-state notice_inline">请不要超过255字节。</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>姓名：</th>
                                    <td>
                                    	<input type="text" size="60" name="real_name" class="text required" value="<?php echo $data['real_name'];?>"><span class="required"> *</span>
                                    	<span class="brief-input-state notice_inline">请不要超过50字节。</span>	
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th>证件号码：</th>
                                    <td>
                                    	<input type="text" size="60" name="identity_card" class="text" value="<?php echo $data['identity_card'];?>"><span class="required"> </span>
                                    	<span class="brief-input-state notice_inline">请不要超过50字节。</span>	
                                    </td>
                                </tr>
                                 <tr>
                                    <th>通信地址：</th>
                                    <td>
                                    	<input type="text" size="60" name="address" class="text" value="<?php echo $data['address'];?>"><span class="required"> </span>
                                    	<span class="brief-input-state notice_inline">请不要超过50字节。</span>	
                                    </td>
                                </tr>
                                 <tr>
                                    <th>邮编：</th>
                                    <td>
                                    	<input type="text" size="60" name="zip_code" class="text" value="<?php echo $data['zip_code'];?>"><span class="required"> </span>
                                    	<span class="brief-input-state notice_inline">请不要超过50字节。</span>	
                                    </td>
                                </tr>
                                 <tr>
                                    <th>固定电话：</th>
                                    <td>
                                    	<input type="text" size="60" name="tel" class="text" value="<?php echo $data['tel'];?>"><span class="required"> </span>
                                    	<span class="brief-input-state notice_inline">请不要超过50字节。</span>	
                                    </td>
                                </tr>
                                 <tr>
                                    <th>手机号码：</th>
                                    <td>
                                    	<input type="text" size="60" name="mobile" class="text" value="<?php echo $data['mobile'];?>"><span class="required"> </span>
                                    	<span class="brief-input-state notice_inline">请不要超过50字节。</span>	
                                    </td>
                                </tr>                               
                                <tr>
                                  <th>生日：</th>
                                  <td><input type="text"  name="birthday" id="birthday"  value="<?php echo $data['birthday'];?>" size="10" class="text" style="background-color:#f1f1f1" readonly="true"/></td>
                                </tr>
                                <?php
                                /**
								?>
                                <tr>
                                    <th>等级：</th>
                                    <td>
                                    <?php if(!empty($user_levels)):?>
                                    	<select name="level_id" id="level_id" class="text">
                                    		<?php foreach($user_levels as $key=>$user_level1):?>
                                    		<?php if(!$key):?>
                                    		<optgroup label="普通等级">
                                    		<?php else:?>
                                    		<optgroup label="特殊等级">
                                    		<?php endif;?>
                                    		<?php foreach($user_level1 as $user_level):?>
	                                    		<option value="<?php echo $user_level['id'];?>" <?php if($user_level['id']==$data['level_id']) echo 'selected';?>>
	                                    		<?php echo $user_level['name_manage'];?> 
	                                    		</option>
	                                    	<?php endforeach;?>
                                    		</optgroup>
                                    		<?php endforeach;?>
                                    	</select>
                                    <?php endif;?>
                                    </td>
                                </tr>
								<?php
								**/
								?>
                                <tr>
                                    <th width="15%">注册时间：</th>
                                    <td><?php echo $data['date_add'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>注册IP：</th>
                                    <td><?php echo $data['ip'];?></td>
                                </tr>
                                <tr>
                                	<th>用户备注：</th>
                                	<td>
                                		<textarea maxlength="1024" type="textarea" class="text valid" rows="5" cols="56" name="remark"><?php echo $data['remark'];?></textarea>
                                		<span class="brief-input-state notice_inline">用户备注，请不要超过1024字节。</span>
                                	</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="list_save">
                        <input name="submit" type="submit" class="ui-button" value=" 确认修改 ">
                    </div>
                    <div class="clear">&nbsp;</div>
                </form>
                <form id="edit_password_form" name="edit_password_form" method="post" action="<?php echo url::base() . 'user/user/do_edit_password/' . $data['id'];?>">
                    <div class="out_box">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tbody>
                                <tr>
                                    <th width="15%">新密码：</th>
                                    <td><input type="password" size="60" name="password" class="text"><span class="required"> *</span></td>
                                </tr>
                                <tr>
                                    <th>是否发邮件：</th>
                                    <td><input type="radio" name="send_mail" value="1" checked>
									发送邮件
                                        <input type="radio" name="send_mail" value="0">
									不发送邮件&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="mail_template" id="<?php echo $forget_mail['id'];?>">重置密码邮件模板</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="list_save">
                        <input name="submit" type="submit" class="ui-button" value=" 确认修改 ">
                    </div>
                    <div class="clear">&nbsp;</div>
                </form>
                <form id="edit_draw_password_form" name="edit_draw_password_form" method="post" action="<?php echo url::base() . 'user/user/do_edit_draw_password/' . $data['id'];?>">
                    <div class="out_box">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tbody>
                                <tr>
                                    <th width="15%">新取款密码：</th>
                                    <td><input type="password" size="60" name="draw_password" class="text"><span class="required"> *</span></td>
                                </tr>
                                <tr>
                                    <th>是否发邮件：</th>
                                    <td><input type="radio" name="send_mail" value="1" checked>
									发送邮件
                                        <input type="radio" name="send_mail" value="0">
									不发送邮件&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="mail_template" id="<?php echo $reset_draw_mail['id'];?>">重置取款密码邮件模板</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="list_save">
                        <input name="submit" type="submit" class="ui-button" value=" 确认修改 ">
                    </div>
                    <div class="clear">&nbsp;</div>
                </form>
               
            </div>
            <!--** edit end**-->
        </div>
    </div>
</div>
<!--**content end**-->
<div id='example' style="display:none;"></div>
<div id='address' style="display:none;"></div>
<script type="text/javascript" src="<?php echo url::base();?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
	    $('#birthday').datepicker({dateFormat:"yy-mm-dd"});

        $("#add_form").validate({
			rules:{
        		email: {
					maxlength: 255
				},
				firstname: {
					maxlength: 50
				},
				lastname: {
					maxlength: 50
				}
			},
    		messages:{
				email: {
					required: '邮箱不可为空',
					maxlength: '邮箱长度不可超过 255 个字符'
				},
				firstname: {
					required: '名不可为空',
					maxlength: '名长度不可超过 50 个字符'
				},
				lastname: {
					required: '姓不可为空',
					maxlength: '姓长度不可超过 50 个字符'
				}
			}
        });
        $("#edit_password_form").validate({
			errorClass:"error",
			rules:{
        	password:{
				required:true,
				rangelength:[5,200]
        		}
			}
            });
        //查看邮件模板
        var dialogOpts = {
            title: "邮件模板内容",
            modal: true,
            autoOpen: false,
            height: 500,
            width: 600
        };
        $("#example").dialog(dialogOpts);

        $(".mail_template").click(function(){
            var id = $(this).attr('id');
            $("#example").html("loading...");
            $.ajax({
        		url: '<?php echo url::base();?>site/mail/ajax_content' + '?id=' + id,
                type: 'GET',
                dataType: 'json',
                error: function() {
                    window.location.href = '<?php echo url::base();?>login?request_url=<?php echo url::current()?>';
                },
                success: function(retdat, status) {
    				ajax_block.close();
    				if (retdat['code'] == 200 && retdat['status'] == 1) {
    					$("#example").html(retdat['content']);
    				} else {
    					showMessage('操作失败', '<font color="#990000">' + retdat['msg'] + '</font>');
    				}
    			}
        	});
            $("#example").dialog("open");
        });

        var addressOpts = {
            title: "编辑地址",
            modal: true,
            autoOpen: false,
            width: 800
        };
        $("#address").dialog(addressOpts);
        $(".address_edit").click(function(){
            var id = $(this).attr('id');
            $("#address").html("loading...");
            $.ajax({
        		url: '<?php echo url::base();?>user/address/ajax_edit' + '?id=' + id,
                type: 'GET',
                dataType: 'json',
                error: function() {
                    window.location.href = '<?php echo url::base();?>login?request_url=<?php echo url::current()?>';
                },
                success: function(retdat, status) {
    				ajax_block.close();
    				if (retdat['code'] == 200 && retdat['status'] == 1) {
    					$("#address").html(retdat['content']);
    				} else {
    					showMessage('操作失败', '<font color="#990000">' + retdat['msg'] + '</font>');
    				}
    			}
        	});
            $("#address").dialog("open");
        });
        $(".address_add").click(function(){
            var user_id = "<?php echo $data['id'];?>";
            $("#address").html("loading...");
            $.ajax({
        		url: '<?php echo url::base();?>user/address/ajax_add' + '?user_id=' + user_id,
                type: 'GET',
                dataType: 'json',
                error: function() {
                    window.location.href = '<?php echo url::base();?>login?request_url=<?php echo url::current()?>';
                },
                success: function(retdat, status) {
    				ajax_block.close();
    				if (retdat['code'] == 200 && retdat['status'] == 1) {
    					$("#address").html(retdat['content']);
    				} else {
    					showMessage('操作失败', '<font color="#990000">' + retdat['msg'] + '</font>');
    				}
    			}
        	});
            $("#address").dialog("open");
        });
    });
</script>