<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>上海竞搏</title>
<head>
<link href="/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
</head>
<body>
	<div id="append"></div><div class="container">
	<h3><img src="/img/task.gif" width="16" height="16"> 服务器环境</h3>
	<ul class="memlist fixwidth">
		<li><em><span class="tdbg">操作系统</span>:</em><?php echo php_uname();?></li>
		<li><em><span class="tdbg">WEB服务器</span>:</em><?php echo $_SERVER['SERVER_SOFTWARE'];?></li>
		<li><em><span class="tdbg">PHP版本</span>:</em><?php echo phpversion();?></li>
		<li><em><span class="tdbg">接口类型</span>:</em><?php echo php_sapi_name();?></li>
		
		<li><em><span class="tdbg">MySQL客户端版本</span>:</em><?php echo mysql_get_client_info();?></li>
		
		<li><em><span class="tdbg">服务器时间</span>:</em><?php echo date('Y-m-d H:i:s');?></li>
		<li><em><span class="tdbg">服务器IP</span>:</em><?php echo $_SERVER['SERVER_ADDR'];?></li>
		<li><em><span class="tdbg">服务器端口</span>:</em><?php echo $_SERVER['SERVER_PORT'];?></li>
	</ul>
	<!-- h3><img src="/img/task2.gif" width="19" height="16"> 开发者信息</h3>
	<ul class="memlist fixwidth">
		<li>
			<em>版权所有:</em>
			<em class="memcont"><span class="red"><a href="http://www.surlink.com.cn/" target="_blank">上海思锐信息技术有限公司</a></span></em>
		</li>
		
		<li>
			<em>开发者信息:</em><em> 思锐科技技术团队</em></li>
        <li>
			<em>产品服务:</em>
			<em class="memcont">邮箱：info@surlink.com.cn</em></li>
	</ul-->
    </div>
</body>
</html>