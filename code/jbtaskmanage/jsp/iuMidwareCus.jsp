<%@ page contentType="text/html; charset=utf-8" language="java"%>
<%@ include file="/common/taglibs.jsp"%>
<%@ page import="org.apache.struts.taglib.html.Constants" %> 
<%@ page import="org.apache.struts.Globals" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title></title>

	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	<script type='text/javascript' src="/js/calendar.js"></script>
	<script type="text/javascript" src="/user/js/common.js"></script>
	<script type="text/javascript" src="/js/jquery-1.4.2.js"></script>
	<link type="text/css" rel="stylesheet" href="/user/css/common-style.css">
	<link  type="text/css"rel="stylesheet" href="/user/css/style.css" />
</head>	
<script type="text/javascript">

	function checkForm(){
		var cusKey = $('#cusKey').val();
		if(cusKey == ''){
			alert('接口调用key不能为空');
			$('#cusKey').focus();
			return false;
		}
		var cusPwd = $('#cusPwd').val();
		if(cusPwd == ''){
			alert('接口调用密码不能为空');
			$('#cusPwd').focus();
			return false;
		}
		if(!_isYSAll(cusPwd)){
			alert('接口调用密码只能为英数字');
			$('#cusPwd').focus();
			return false;
		}
		return true;
	}
	
	$(function(){
		$('#saveBtn').bind('click',function(){
			//修改保存
			if(checkForm()){
				$('#excForm').submit();
			}
		});
	})
</script>

<body>
	<form id="excForm" action="/midwarecus/iuMidwareCus.do" method="post">
		<input type="hidden" name="<%=Constants.TOKEN_KEY%>" value="<%=session.getAttribute(Globals.TRANSACTION_TOKEN_KEY)%>"/>
		<input type="hidden" name="id" value="${midwarecus.id}">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td height="30" bgcolor="#F0F3F8" class="line2">
					&nbsp;&gt; 
					<c:if test="${saveFlg == 0}">添加mid_midwarecus</c:if>
					<c:if test="${saveFlg == 1}">修改mid_midwarecus</c:if>
				</td>
			</tr>
			<tr>
				<td height="100">
					<br />
					<table width="85%" border="0" align="center" cellpadding="5"
						cellspacing="1">
						<tr><td><span style="color: red;">${message}</span></td></tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								接口调用key:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
								<c:if test="${saveFlg == 0}">
									<input id="cusKey" name="cusKey" type="text" value="${midwarecus.cusKey }" />
								</c:if>
								<c:if test="${saveFlg == 1}">
									<input id="cusKey" name="cusKey" type="hidden" value="${midwarecus.cusKey }" />
									${midwarecus.cusKey }
								</c:if>
								</label>
							</td>
						</tr>
						<c:if test="${saveFlg == 1}">
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								接口调用密码:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="cusPwd" name="cusPwd" type="text" maxlength="8" value="${midwarecus.cusPwd }" />
								</label>
							</td>
						</tr>
						</c:if>
												
						<!--<input type="hidden" name="roleId" value="" />-->
						<tr>
							<td height="24" bgcolor="#EEEEEE">
								
							</td>
							<td height="20" bgcolor="#EEEEEE">
								<input type="hidden" name="saveFlg" id="saveFlg" value="${saveFlg}">
								<input type="button" id="saveBtn" name="saveBtn" value="保存">
								<input type="button" onclick="location.href = '/midwarecus/listMidwareCus.do';" value="返回"  />
							</td>
						</tr>
						<tr>
							<td height="20" colspan="2">
								&nbsp;
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>