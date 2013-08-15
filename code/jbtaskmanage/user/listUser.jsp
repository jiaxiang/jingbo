<%@ page contentType="text/html; charset=utf-8" isELIgnored="false"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/fmt" prefix="fmt" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" prefix="fn" %>
<%@ taglib uri="/WEB-INF/struts-html.tld" prefix="html"%>
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
	<title>用户管理</title>
	<link type="text/css" rel="stylesheet" href="<%=request.getContextPath()%>/user/css/common-style.css">
	<link rel="stylesheet" type="text/css" href="<%=request.getContextPath()%>/user/css/style.css" />
	<script type='text/javascript' src="<%=request.getContextPath()%>/user/js/common.js"></script>
	<script type='text/javascript' src="<%=request.getContextPath()%>/user/js/pagedData.js"></script>
	<script language="JavaScript" >
	function doDelete()
	{
		var frm = document.getElementById('iform');
    	for(i=0;i<frm.elements.length;i++) 
    	{
        	var e=frm.elements[i];
       		if ((e.type=="checkbox")&&(e.name=="ids")&& (e.checked))
       		{
       			if(window.confirm('您确信删除选中的记录吗?')){
       				frm.action = '<%=request.getContextPath()%>/user/deleteUser.do';
			    	frm.submit();
			    	return true;
    			}else{
    				return;
    			}
				
            }
        }
        alert("请选中你想删除的那些记录前面的方框!");
        return false;
	}
	</script>
</head>

<body>

<script>
<c:if test="${not empty msg}">
	alert('${msg}');
</c:if>
</script>

<!-- Nav -->
<div class="Pad03"></div>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" bgcolor="#F0F3F8" class="line2">
			&nbsp;&nbsp;&nbsp;&nbsp;当前位置:系统管理 &gt; 用户管理
		</td>
	</tr>
	<tr>
		<td  bgcolor="#FFFFFF"><br>
		
<form id="iform" method="post" action="<%=request.getContextPath()%>/user/listUser.do"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td> 
		用户姓名：<input type="text" name="username" value="${username}"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" value="查询"/></td>
		<td align="right">您可以通过选择右边的条件来过滤结果

<select id="userable" name="userable" onchange="$('iform').submit();">
    <c:choose>
    	<c:when test="${userable==1}">
    		<option value="" >-是否有效-</option>
    		<option value="1" selected>有效用户</option>
    		<option value="0" >无效用户</option>
    	</c:when>
    	<c:when test="${userable==0}">
    		<option value="" >-是否有效-</option>
    		<option value="1" >有效用户</option>
    		<option value="0" selected>无效用户</option>
    	</c:when>
    	<c:otherwise>
    		<option value="">-是否有效-</option>
    		<option value="1">有效用户</option>
    		<option value="0">无效用户</option>
    	</c:otherwise>
    </c:choose>
</select>

<select id="role" name="role" onchange="$('iform').submit();">
    <option value="" >-所有角色-</option>
    <c:forEach var="e" items="${roles}">
    	<c:choose>
    		<c:when test="${e.id==role}"><option value="${e.id}" selected>${e.rolename}</option></c:when>
    		<c:otherwise><option value="${e.id}" >${e.rolename}</option></c:otherwise>
    	</c:choose>
    </c:forEach>
</select></td>
	</tr>
</table>
<br/>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#5477C0">
	<tr bgcolor="#FFFFFF">
		<td width="20" align="center" bgcolor="#F0F3F8">&nbsp;</td>
	    <td width="100" bgcolor="#F0F3F8">用户名</td>
	    <td width="200" bgcolor="#F0F3F8">Email</td>
	    <td width="100" bgcolor="#F0F3F8">类型</td>
	    <td bgcolor="#F0F3F8">状态</td>
	    <td bgcolor="#F0F3F8">创建时间</td>
	    <td bgcolor="#F0F3F8">管理</td>
	</tr>
	<c:forEach var="e" items="${page.userObjects}">
		<tr onmouseover="this.style.backgroundColor='#EDF6FF'" onmouseout="this.style.backgroundColor='#FFFFFF'" bgcolor="#FFFFFF">
		    <td width="20" align="center">
		    	<input type="checkbox" onclick="synchronize('ids',$('boxAll'))" name="ids" value="${e.id}" />
		    </td>
		    <td>${e.username}</td>
		    <td>${e.email}</td>
		    	<c:if test="${not empty e.roleId}">
		   			<td>${e.rolename}</td>
		    	</c:if>
		    	<c:if test="${empty e.roleId}">
		    		<td>未分配角色</td>
		    	</c:if>
		    <td><c:if test="${e.isAble == 1}">有效用户</c:if><c:if test="${e.isAble != 1}"><font color="red">无效用户</font></c:if></td>
		    <td><fmt:formatDate value="${e.createDate}" pattern="yyyy-MM-dd HH:mm:ss" /></td>
			<td>
				<a href="<%=request.getContextPath()%>/user/preEditUser.do?userId=${e.id}">管理</a>
			</td>
		</tr>
	</c:forEach>
</table>
<br/>
<div class="MainPage PagePage">
		<input type="checkbox" id="boxAll" onclick="setSelectAll('ids',this);"  /> &nbsp; 全选&nbsp; 
		<input type="button" name="delete" onclick="doDelete();" value="删除"  />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 

		<input type="button" name="add" onclick="location.href = '<%=request.getContextPath()%>/user/preCreateUsers.do';" value="注册用户"  />
		
		<f:page form="iform" page="${page}"> hello world !</f:page>
		
		每页显示  
		<select id="pageSize" name="pageSize" onchange="javascript:document.getElementById('iform').submit();">
			<option value="5" >5</option>
			<option value="10" selected="selected" >10</option>
			<option value="20" >20</option>
		</select>条
		<c:if test="${not empty param.pageSize}">
		<script type='text/javascript' language="javascript">
			setSelected('pageSize','${param.pageSize}');
		</script>
		</c:if>	
</div>
</form>
		</td>
	</tr>
</table>

	</div>
<div class="Pad10"></div>


</body>
</html>
