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
	<title>用户权限</title>
	<link type="text/css" rel="stylesheet" href="<%=request.getContextPath()%>/user/css/common-style.css">
	<link rel="stylesheet" type="text/css" href="<%=request.getContextPath()%>/user/css/style.css" />
	<script type='text/javascript' src="<%=request.getContextPath()%>/user/js/common.js"></script>
	<script type='text/javascript' src="<%=request.getContextPath()%>/user/js/property.js"></script>
</head>

<body>

<!-- Nav -->
<div class="Pad03"></div>
<fieldset><legend>编辑用户权限</legend>
<form id="iform" method="post" action="<%=request.getContextPath()%>/user/editUser.do" onsubmit="return inputcheck();">
<input name="userId" type="hidden" value="${user.id}"/>
<table  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th width="30%" scope="row">用户名称：</th>
    <td width="70%"><input name="priname" type="text" value="${user.username}" readonly/></td>
  </tr>
  <tr>
    <th scope="row">是否有效：</th>
    <td>
      <c:choose>
    	<c:when test="${user.isAble==1}">
    		<input name="isAble" type="radio" value="1" checked="checked"/>是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    		<input name="isAble" type="radio" value="0"/>否
    	</c:when>
    	<c:otherwise>
    		<input name="isAble" type="radio" value="1"/>是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    		<input name="isAble" type="radio" value="0" checked="checked"/>否
    	</c:otherwise>
      </c:choose>
    </td>
  </tr>
  <tr>
    <th scope="row">所属角色：</th>
    <td>
    	<select name="roleId" style="width:180px;">
    		<c:forEach var="role" items="${roles}">
    			<c:choose>
    				<c:when test="${role.id==user.roleId}"><option value="${role.id}" selected/>${role.rolename}</c:when>
    				<c:otherwise><option value="${role.id}"/>${role.rolename}</c:otherwise>
    			</c:choose>
    		</c:forEach>
    	</select>
	</td>
  </tr>
</table>

<p align="center"><input name="save" type="submit" value="保存"/> <input name="reset" type="reset" value="重置" />
</p>
</form></fieldset>
<div class="Pad10"></div>


</body>
</html>

