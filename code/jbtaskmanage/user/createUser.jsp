<%@ page contentType="text/html; charset=utf-8" isELIgnored="false"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/fmt" prefix="fmt"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" prefix="fn"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>注册${role.rolename}</title>

		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="expires" content="0">
		<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
		<meta http-equiv="description" content="This is my page">
		<link type="text/css" rel="stylesheet" href="<%=request.getContextPath()%>/user/css/common-style.css">
		<link rel="stylesheet" type="text/css" href="<%=request.getContextPath()%>/user/css/style.css" />
		<style type="text/css">
			body{
				overflow-x:hidden;
				margin-left: 0px;
				margin-top: 0px;
				margin-right: 0px;
				margin-bottom: 0px;
			}
		</style>
	</head>
<script>
	function checkSubmit(){
		var msgs = "";
		var counter = 1;
		var username = document.all("username").value;
		var pwd = document.all("pwd").value;
		var repwd = document.all("repwd").value;
		var email = document.all("email").value;
		var stra = /^\w+\@\w+(\.\w+)+$/i;
		
		if(username==''){
			msgs += (counter++)+".  用户名不能为空\r\n";
		}
		if(pwd=='' || repwd==''){
			msgs += (counter++)+".  密码不能为空\r\n";
		}
		if(pwd.replace(/[ ]/g,"").length<6 || pwd.replace(/[ ]/g,"").length >15){
			msgs += (counter++)+".  密码不能小于6位大于15位\r\n";
		}
		if(pwd!=repwd){
			msgs += (counter++)+".  两次输入的密码不一致\r\n";
		}
		if(email == ''){
			msgs += (counter++)+".  邮箱不能为空\r\n";
		}
		if(!stra.test(email)){
			msgs += (counter++)+".  邮箱格式不正确\r\n";
		}
		
		if(msgs!=null && msgs.length>0){
			alert(msgs);
		}else{
			register.submit();
		}
	}
</script>
<link rel="stylesheet" type="text/css" href="<%=request.getContextPath()%>/css/style.css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
body,td,th {
	font-size: 12px;
}
.font_14 {
	font-size: 14px;
	color: #FFFFFF;
}
.STYLE1 {
	font-size: 14px;
	font-weight: bold;
	color: #000000;
	padding-left:20px;
}
.STYLE2 {color: #000000}
.STYLE3 {color: #000000; font-weight: bold; }
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #333333;
}
a:hover {
	text-decoration: none;
	color: #333333;
}
a:active {
	text-decoration: none;
}
-->
</style>

<c:choose>
	<c:when test="${SysUser != null}">
		<body>
			<form action="<%=request.getContextPath()%>/user/createUsers.do" method="post" name="register">
				<table width="100%" border="0"  cellpadding="0" cellspacing="0">
					<tr>
					  <td height="30" align="left" background="<%=request.getContextPath()%>/css/bg_new.gif" class="STYLE1">&nbsp;&gt; 
					  	注册${role.rolename} 
					  </td>
					</tr>
					<tr>
						<td height="40" valign="bottom"><hr width="95%" size="3" color="#5694CF">
					  </td>
					</tr>
					<tr>
						<td height="100">
							<br />
							<table width="85%" border="0" align="center" cellpadding="5" cellspacing="1">
								<tr>
									<td width="17%" height="25" bgcolor="#EEEEEE">
										&nbsp;&nbsp;用户名
									</td>
									<td width="83%" height="20" bgcolor="#EEEEEE">
										<label>
											<input name="username" type="text" size="20" value="${username}"/>
										</label>
									</td>
								</tr>
								<tr>
									<td height="25" bgcolor="#EEEEEE">
										&nbsp;&nbsp;用户密码
									</td>
									<td height="20" bgcolor="#EEEEEE">
										<input type="password" name="pwd" />
										（6-15任意字符）
									</td>
								</tr>
								
<script>
<c:if test="${not empty msg}">
	alert('${msg}');
</c:if>
</script>
								<tr>
									<td height="25" bgcolor="#EEEEEE">
										&nbsp;&nbsp;重复密码
									</td>
									<td height="20" bgcolor="#EEEEEE">
										<input type="password" name="repwd" />
										（重复输入密码）
									</td>
								</tr>
								<tr>
									<td height="25" bgcolor="#EEEEEE">
										&nbsp;&nbsp;用户邮箱
									</td>
									<td height="20" bgcolor="#EEEEEE">
										<input name="email" type="text" size="50" value="${email}"/>
									</td>
								</tr>
								<tr>
									<td height="25" bgcolor="#EEEEEE">
										&nbsp;&nbsp;所属角色
									</td>
									<td height="20" bgcolor="#EEEEEE">
										<select name="roleId" style="width:180px;">
											<c:forEach var="role" items="${roles}">
												<c:choose>
													<c:when test="${role.id==user.role.id}"><option value="${role.id}" selected/>${role.rolename}</c:when>
													<c:otherwise><option value="${role.id}"/>${role.rolename}</c:otherwise>
												</c:choose>
											</c:forEach>
										</select>
									</td>
								</tr>
								<!--<input type="hidden" name="roleId" value="${param.roleId}" />-->
								<tr>
									<td height="24" bgcolor="#EEEEEE">
										<input type="button" value="提交" onClick="checkSubmit()">
									</td>
									<td height="20" bgcolor="#EEEEEE">&nbsp;
										
									</td>
								</tr>
								<tr>
									<td height="20" colspan="2">&nbsp;
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</body>
	</c:when>
	<c:otherwise>
	非法操作
</c:otherwise>
</c:choose>