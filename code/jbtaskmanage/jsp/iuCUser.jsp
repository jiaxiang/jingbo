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
	<form id="excForm" action="/stomer_user/iuCUser.do" method="post">
		<input type="hidden" name="<%=Constants.TOKEN_KEY%>" value="<%=session.getAttribute(Globals.TRANSACTION_TOKEN_KEY)%>"/>
		<input type="hidden" name="id" value="${stomer_user.id}">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td height="30" bgcolor="#F0F3F8" class="line2">
					&nbsp;&gt; 
					<c:if test="${saveFlg == 0}">添加customer_user</c:if>
					<c:if test="${saveFlg == 1}">修改customer_user</c:if>
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
									<input id="id" name="id" type="text" value="${stomer_user.id }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="username" name="username" type="text" value="${stomer_user.username }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="password" name="password" type="text" value="${stomer_user.password }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="qq" name="qq" type="text" value="${stomer_user.qq }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="mobile" name="mobile" type="text" value="${stomer_user.mobile }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="memberLevelId" name="memberLevelId" type="text" value="${stomer_user.memberLevelId }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								鹰币:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="balance" name="balance" type="text" value="${stomer_user.balance }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								人民币:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="rmb" name="rmb" type="text" value="${stomer_user.rmb }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="memberPeriod" name="memberPeriod" type="text" value="${stomer_user.memberPeriod }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="isActive" name="isActive" type="text" value="${stomer_user.isActive }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="lastLogin" name="lastLogin" type="text" value="${stomer_user.lastLogin }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								字段标题:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="dateJoined" name="dateJoined" type="text" value="${stomer_user.dateJoined }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								身份证号码:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="identityCard" name="identityCard" type="text" value="${stomer_user.identityCard }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								真实姓名:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="realName" name="realName" type="text" value="${stomer_user.realName }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								地址:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="address" name="address" type="text" value="${stomer_user.address }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								邮箱:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="mailbox" name="mailbox" type="text" value="${stomer_user.mailbox }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								开户银行:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="bankAddress" name="bankAddress" type="text" value="${stomer_user.bankAddress }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								发卡银行:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="bankName" name="bankName" type="text" value="${stomer_user.bankName }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								银行卡号码:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="bankAccount" name="bankAccount" type="text" value="${stomer_user.bankAccount }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								银行卡户主:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="bankRealName" name="bankRealName" type="text" value="${stomer_user.bankRealName }" />
								</label>
							</td>
						</tr>
												<tr>
							<td width="17%" height="25" align="right" bgcolor="#EEEEEE">
								代理商编号:&nbsp;&nbsp;
							</td>
							<td width="83%" height="20" bgcolor="#EEEEEE">
								<label>
									<input id="parentId" name="parentId" type="text" value="${stomer_user.parentId }" />
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
								<input type="button" onclick="location.href = '/stomer_user/listCUser.do';" value="返回"  />
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