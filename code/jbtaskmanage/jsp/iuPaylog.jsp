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
	<form id="excForm" action="/stomer_paylog/iuPaylog.do" method="post">
		<input type="hidden" name="<%=Constants.TOKEN_KEY%>" value="<%=session.getAttribute(Globals.TRANSACTION_TOKEN_KEY)%>"/>
		<input type="hidden" name="id" value="${stomer_paylog.id}">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td height="30" bgcolor="#F0F3F8" class="line2">
					&nbsp;&gt; 
					<c:if test="${saveFlg == 0}">添加customer_paylog</c:if>
					<c:if test="${saveFlg == 1}">修改customer_paylog</c:if>
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
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="id" name="id" type="text" value="${stomer_paylog.id }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="usernameId" name="usernameId" type="text" value="${stomer_paylog.usernameId }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="balance" name="balance" type="text" value="${stomer_paylog.balance }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="revenue" name="revenue" type="text" value="${stomer_paylog.revenue }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="expenses" name="expenses" type="text" value="${stomer_paylog.expenses }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="buyType" name="buyType" type="text" value="${stomer_paylog.buyType }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								消费日期:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="costDate" name="costDate" type="text" value="${stomer_paylog.costDate }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="remark" name="remark" type="text" value="${stomer_paylog.remark }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								投注类别:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="betType" name="betType" type="text" value="${stomer_paylog.betType }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								方案编号:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="betId" name="betId" type="text" value="${stomer_paylog.betId }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								账户类别:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="accountType" name="accountType" type="text" value="${stomer_paylog.accountType }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								充值密码:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="key" name="key" type="text" value="${stomer_paylog.key }" />
								</label>
							</td>
						</tr>
												
						<!--<input type="hidden" name="roleId" value="" />-->
						<tr>
							<td height="24" bgcolor="#EEEEEE">
								
							</td>
							<td height="20" bgcolor="#EEEEEE">
								<input type="hidden" name="saveFlg" id="saveFlg" value="${saveFlg}">
								<input type="button" id="saveBtn" name="saveBtn" value="保存">
								<input type="button" onclick="location.href = '/stomer_paylog/listPaylog.do';" value="返回"  />
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