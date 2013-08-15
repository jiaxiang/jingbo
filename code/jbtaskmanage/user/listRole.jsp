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
	<title>角色一览</title>
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
	
	function del(id){
	
		if(window.confirm('您确信删除该记录吗?')){
			location.href = '<%=request.getContextPath()%>/user/deleteRole.do?id=' + id;
    	}else{
    		return;
    	}
    	

	}
	
	//window.parent.Ext.getCmp('menu').root.reload();
	//window.parent.Ext.getCmp('menu').root.expand();
	</script>
</head>

<body>

<!-- Nav -->
<div class="Pad03"></div>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" bgcolor="#F0F3F8" class="line2">
			&nbsp;&nbsp;&nbsp;&nbsp;当前位置:系统管理 &gt; 功能管理
		</td>
	</tr>
	<tr>
		<td  bgcolor="#FFFFFF"><br>


<form id="iform" method="post" action="<%=request.getContextPath()%>/user/deleteRole.do"> 
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#5477C0">
	<tr bgcolor="#FFFFFF">
	    <td align="center" width="20" bgcolor="#F0F3F8">&nbsp;</td>
	    <td bgcolor="#F0F3F8">角色名称</td>
	    <td bgcolor="#F0F3F8">描述</td>
	    <td bgcolor="#F0F3F8">是否可用</td>
	    <td bgcolor="#F0F3F8">&nbsp;</td>
	</tr>
	<c:forEach var="e" items="${listRoles}">
	<tr onmouseover="this.style.backgroundColor='#EDF6FF'" onmouseout="this.style.backgroundColor='#FFFFFF'" bgcolor="#FFFFFF">
	    <td><input type="checkbox" onclick="synchronize('ids',$('boxAll'))" name="ids" value="${e.id}" /></td>
	    <td>${e.rolename}&nbsp;</td>
	    <td>${e.description}&nbsp;</td>
	    <td>
	    	<c:choose>
	    		<c:when test="${e.isAble==1}">可用</c:when>
	    		<c:otherwise>不可用</c:otherwise>
	    	</c:choose>
	    </td>
	    <td>
	    <a href="<%=request.getContextPath()%>/user/preEditRole.do?id=${e.id}" >设置权限</a>&nbsp;
	    <a href="#" onclick="javascript:del('${e.id}')" >删除</a>
	    </td>
	</tr>
	</c:forEach>
</table>
<br/>
<div class="MainPage PagePage">
		<input type="checkbox" id="boxAll" onclick="setSelectAll('ids',this);"  /> &nbsp; 全选&nbsp; 
		<input type="button" name="delete" onclick="doDelete();" value="删除"  />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
		&nbsp;
		<input type="button" name="add" onclick="location.href = '<%=request.getContextPath()%>/user/preEditRole.do';" value="添加"  />
</div>
</form>
		</td>
	</tr>
</table>

	</div>
<div class="Pad10"></div>


</body>
</html>
