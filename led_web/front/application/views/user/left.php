<div class="member_left fl gray3">
    	<h3 class="font14">投注管理</h3>
        <div class="member_menu fl">
        	<p <?php if(!empty($_nav) && $_nav == 'betting') echo 'class="red"';?>><a href="<?php echo url::base();?>user/betting">投注记录</a></p>
            <p <?php if(!empty($_nav) && $_nav == 'today_bets') echo 'class="red"';?>><a href="<?php echo url::base();?>user/today_bets">今日投注</a></p>
			<p <?php if(!empty($_nav) && $_nav == 'auto_order') echo 'class="red"';?>><a href="<?php echo url::base();?>user_auto_order/index">自动跟单</a></p>
        </div>
        <h3 class="font14">资金管理</h3>	
        <div class="member_menu fl">
        	<p <?php if(!empty($_nav) && $_nav == 'recharge') echo 'class="red"';?>><a href="<?php echo url::base();?>user/recharge">网上充值</a></p>
        	
        	<p <?php if(!empty($_nav) && $_nav == 'card_recharge') echo 'class="red"';?>><a href="<?php echo url::base();?>card/recharge">点卡充值</a></p>
        	<!-- 
        	<p <?php if(!empty($_nav) && $_nav == 'recharge_card') echo 'class="red"';?>><a href="<?php echo url::base();?>user_recharge_card/recharge">点卡充值</a></p>
        	<p <?php if(!empty($_nav) && $_nav == 'recharge_card_change') echo 'class="red"';?>><a href="<?php echo url::base();?>user_recharge_card/change">点数兑换</a></p>
        	<p <?php if(!empty($_nav) && $_nav == 'recharge_card_search') echo 'class="red"';?>><a href="<?php echo url::base();?>user_recharge_card/search">点卡查询</a></p>
        	--> 
            <p <?php if(!empty($_nav) && $_nav == 'withdrawals') echo 'class="red"';?>><a href="<?php echo url::base();?>user/withdrawals">帐户提款</a></p>
            <p <?php if(!empty($_nav) && $_nav == 'recharge_records') echo 'class="red"';?>><a href="<?php echo url::base();?>user/recharge_records">充值记录</a></p>
            <p <?php if(!empty($_nav) && $_nav == 'atm_records') echo 'class="red"';?>><a href="<?php echo url::base();?>user/atm_records">取款记录</a></p>
            <p <?php if(!empty($_nav) && $_nav == 'capital_changes') echo 'class="red"';?>><a href="<?php echo url::base();?>user/capital_changes">资金变动明细</a></p>
        </div>
        <h3 class="font14">个人信息管理</h3>
        <div class="member_menu fl">
        <?php
        if (!isset($_user['alipayfastlogin']) || $_user['alipayfastlogin'] == null) { 
        ?>
        	<p <?php if(!empty($_nav) && $_nav == 'password_protection') echo 'class="red"';?>><a href="<?php echo url::base();?>user/password_protection">修改密码保护</a></p>
        <?php
        } 
        ?>
            <p <?php if(!empty($_nav) && $_nav == 'profile') echo 'class="red"';?>><a href="<?php echo url::base();?>user/profile">修改个人资料</a></p>
            <p <?php if(!empty($_nav) && $_nav == 'user_auth') echo 'class="red"';?>><a href="<?php echo url::base();?>user/user_auth">身份实名认证</a></p>
            <p <?php if(!empty($_nav) && $_nav == 'withdrawals_info') echo 'class="red"';?>><a href="<?php echo url::base();?>user/withdrawals_info">修改取款信息</a></p>
        <?php
        if (!isset($_user['alipayfastlogin']) || $_user['alipayfastlogin'] == null) { 
        ?>
            <p <?php if(!empty($_nav) && $_nav == 'password') echo 'class="red"';?>><a href="<?php echo url::base();?>user/password">修改登录密码</a></p>
        <?php 
        }
        ?>
			<p <?php if(!empty($_nav) && $_nav == 'withdrawals_password') echo 'class="red"';?>><a href="<?php echo url::base();?>user/withdrawals_password">修改提现密码</a></p>
        </div>
	<?php if( isset($_user['agent']) && $_user['agent'] != null) { ?>
	<h3 class="font14">代理服务</h3>
	<div class="member_menu fl">
		<p <?php if(!empty($_nav) && $_nav == 'agent_detail') echo 'class="red"';?>>
			<a href="<?php echo url::base();?>distribution/agent">代理信息</a></p>
		<p <?php if(!empty($_nav) && $_nav == 'agent_client') echo 'class="red"';?>>
			<a href="<?php echo url::base();?>distribution/agent_client">下级用户列表</a></p>
		<p <?php if(!empty($_nav) && $_nav == 'realtime_contract') echo 'class="red"';?>>
			<a href="<?php echo url::base();?>distribution/realtime_contract">即时合约</a></p>
		<p <?php if(!empty($_nav) && $_nav == 'month_contract') echo 'class="red"';?>>
			<a href="<?php echo url::base();?>distribution/month_contract">月结合约</a></p>
		<p <?php if(!empty($_nav) && $_nav == 'settle_realtime_rpt') echo 'class="red"';?>>
			<a href="<?php echo url::base();?>distribution/settle_realtime_rpt">即时结算报表</a></p>
		<p <?php if(!empty($_nav) && $_nav == 'settle_month_rpt') echo 'class="red"';?>>
			<a href="<?php echo url::base();?>distribution/settle_month_rpt">月度结算报表</a></p>
	</div>
	<?php } ?>
    </div>