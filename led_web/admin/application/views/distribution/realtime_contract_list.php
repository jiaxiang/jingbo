<div class="new_content">
	<div class="newgrid">
		<div class="newgrid_tab fixfloat">
			<ul>
				<li class="on"><a href='<?php echo url::base().'distribution/realtime_contract/index/'.$user['id'];?>'><?php echo $user['lastname'];?>&nbsp;实时合约列表</a></li>
			</ul>
		</div>																																													
		<div class="newgrid_top">
			<ul class="pro_oper">
				<li>
					<a href="/distribution/realtime_contract/add/<?php echo $user['id']; ?>"><span class="add_pro">添加实时合约</span></a>
				</li>
				<li>
					<a href="/distribution/realtime_contract/template_reference/<?php echo $user['id']; ?>"><span class="add_pro">参考实时合约模板</span></a>
				</li>
			</ul>
        </div>
		
		<?php if (is_array($data) && count($data)) {?>
		<form id="list_form" name="list_form" method="post" action="<?php echo url::base() . url::current();?>">
		<table  cellspacing="0">
			<thead>
				<tr class="headings">
				<th width="50px">操作</th>
				<th width="30px">上级代理</th>
				<th width="30px">下级用户</th>
				<th width="50px">合约类型(合约号)</th>
				<th width="50px">彩种分类</th>
				<th width="70px">实时返点率</th>
				<th width="70px">合约创建日期</th>				
				<th width="70px">合约生效日期</th>				
				<th width="70px">最后一次结算日期</th>
				<th width="70px">备注</th>				
				<th width="20px" class="txc">状态</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $item) { ?>
				<tr>
					<td>
						<?php if ($item['flag']==0) {?>
						<a href="<?php echo url::base().'distribution/realtime_contract/open/'.$item['id']; ?>">生效</a>&nbsp;
						<?php } else {?>
						<a href="<?php echo url::base().'distribution/realtime_contract/close/'.$item['id']; ?>">关闭</a>&nbsp;
						<?php } ?>
						<a href="<?php echo url::base().'distribution/realtime_contract/delete/'.$item['id']; ?>" 
							 onclick="javascript:return confirm('确定删除？')">删除</a>&nbsp;
					</td>
					<td>竞波网</td>
					<td><?php echo $user['lastname'].'('.$item['user_id'].')' ;?></td>
					<td>
					<?php 
						if($item['contract_type'] == 0) {
							echo '普通代理返点'; 
						} else if ($item['contract_type'] == 1) {
							echo '下线返点'; 
						} else if ($item['contract_type'] == 2) {
							echo '超级代理返点'; 
						}
						echo '('.$item['id'].')';
					?>
					</td>
					<td><?php echo ($item['type'] == 7) ? '北单' : '普通';?></td>
					<td><?php echo $item['rate'];?></td>
					<td><?php echo $item['createtime'];?></td>
					<td><?php echo $item['starttime'];?></td>
					<td><?php echo $item['lastsettletime'];?></td>
					<td><?php echo $item['note'];?></td>
					<td class="txc"><?php echo ($item['flag'] == 2)? '生效':'关闭';?></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		</form>
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
