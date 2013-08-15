<%@ page contentType="text/html; charset=utf-8" language="java"%>
<%@ include file="/common/taglibs.jsp"%>
 <%@ taglib uri="http://java.sun.com/jsp/jstl/custom" prefix="f"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
    <meta http-equiv="description" content="Tradeshows Organizer List">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title></title>
	<link type="text/css" rel="stylesheet" href="/user/css/common-style.css">
	<link  type="text/css"rel="stylesheet" href="/user/css/style.css" />
	<script type='text/javascript' src="/user/js/common.js"></script>
	<script type='text/javascript' src="/user/js/pagedData.js"></script>
	<script type="text/javascript" src="/js/jquery-1.4.2.js"></script>
	<script language="JavaScript" >
	
	function del(id){
		if(window.confirm('您确信删除该记录吗?')){
			location.href = '/stomer_user/deleteCUser.do?id=' + id;
    	}else{
    		return;
    	}
	}
	
	</script>
</head>
 
<body>
 
<!-- Nav -->
<div class="Pad03"></div>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" bgcolor="#F0F3F8" class="line2">
			&nbsp;&nbsp;&nbsp;&nbsp;当前位置:customer_user一览
		</td>
	</tr>
	<tr>
		<td  bgcolor="#FFFFFF"><br>
		<div align="left" style="width: 90%;margin:0 auto;">
<form id="iform" action="/stomer_user/listCUser.do" method="post">
<table width="100%" align="center" cellpadding="1" border="0">
	<tr bgcolor="#ffffff">
		<td>字段标题
			<input type="text" name="usernameSear" id="usernameSear" value="${usernameSear}" />&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" value="查询" />&nbsp;&nbsp;
			<input type="button" name="add" onclick="location.href = '/stomer_user/initAddCUser.do';" value="添加"  />
		</td>
		<td>
		</td>
		
	</tr>
</table>
<br />
<span style="color: green;">${message}<br></span>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#5477C0">
	<tr bgcolor="#FFFFFF">
	    <td bgcolor="#F0F3F8">编号</td>
	    	    <td bgcolor="#F0F3F8">字段标题</td>
	    	    <td bgcolor="#F0F3F8">字段标题</td>
	    	    <td bgcolor="#F0F3F8">字段标题</td>
	    	    <td bgcolor="#F0F3F8">字段标题</td>
	    	    <td bgcolor="#F0F3F8">字段标题</td>
	    	    <td bgcolor="#F0F3F8">字段标题</td>
	    	    <td bgcolor="#F0F3F8">鹰币</td>
	    	    <td bgcolor="#F0F3F8">人民币</td>
	    	    <td bgcolor="#F0F3F8">字段标题</td>
	    	    <td bgcolor="#F0F3F8">字段标题</td>
	    	    <td bgcolor="#F0F3F8">字段标题</td>
	    	    <td bgcolor="#F0F3F8">字段标题</td>
	    	    <td bgcolor="#F0F3F8">身份证号码</td>
	    	    <td bgcolor="#F0F3F8">真实姓名</td>
	    	    <td bgcolor="#F0F3F8">地址</td>
	    	    <td bgcolor="#F0F3F8">邮箱</td>
	    	    <td bgcolor="#F0F3F8">开户银行</td>
	    	    <td bgcolor="#F0F3F8">发卡银行</td>
	    	    <td bgcolor="#F0F3F8">银行卡号码</td>
	    	    <td bgcolor="#F0F3F8">银行卡户主</td>
	    	    <td bgcolor="#F0F3F8">代理商编号</td>
	    	    <td bgcolor="#F0F3F8">操作</td>
	</tr>
	
	<c:forEach var="e" items="${page.userObjects}" varStatus="status">
	<tr onmouseover="this.style.backgroundColor='#EDF6FF'" onmouseout="this.style.backgroundColor='#FFFFFF'" bgcolor="#FFFFFF">
	    <td>${status.count+(page.realSize-1)*pageSize}&nbsp;</td>
	    	    <td>${e.id}&nbsp;</td>
	    	    <td>${e.username}&nbsp;</td>
	    	    <td>${e.password}&nbsp;</td>
	    	    <td>${e.qq}&nbsp;</td>
	    	    <td>${e.mobile}&nbsp;</td>
	    	    <td>${e.memberLevelId}&nbsp;</td>
	    	    <td>${e.balance}&nbsp;</td>
	    	    <td>${e.rmb}&nbsp;</td>
	    	    <td>${e.memberPeriod}&nbsp;</td>
	    	    <td>${e.isActive}&nbsp;</td>
	    	    <td>${e.lastLogin}&nbsp;</td>
	    	    <td>${e.dateJoined}&nbsp;</td>
	    	    <td>${e.identityCard}&nbsp;</td>
	    	    <td>${e.realName}&nbsp;</td>
	    	    <td>${e.address}&nbsp;</td>
	    	    <td>${e.mailbox}&nbsp;</td>
	    	    <td>${e.bankAddress}&nbsp;</td>
	    	    <td>${e.bankName}&nbsp;</td>
	    	    <td>${e.bankAccount}&nbsp;</td>
	    	    <td>${e.bankRealName}&nbsp;</td>
	    	    <td>${e.parentId}&nbsp;</td>
	    	    <td>
	    	<a href='<%=request.getContextPath()%>/stomer_user/initUpdateCUser.do?id=${e.id}' >更改</a>&nbsp;
		    <a href="#" onclick="javascript:del('${e.id}')" >删除</a>
	    </td>
	</tr>
	</c:forEach>
</table>

<br>

<div class="MainPage PagePage">
		
		<f:page form="iform" page="${page}"> hello world !</f:page>
		
		每页显示  
		<select id="pageSize" name="pageSize" onchange="javascript:document.getElementById('iform').submit();">
			<option value="10" selected="selected" >10</option>
		</select>条
		<c:if test="${not empty param.pageSize}">
		<script type='text/javascript' language="javascript">
			setSelected('pageSize','${param.pageSize}');
		</script>
		</c:if>	
</div>

</form>
</div>
		</td>
	</tr>
	
</table>
	</div>
<div class="Pad10"></div>
</body>
</html>

