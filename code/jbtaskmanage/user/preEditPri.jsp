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
	<title>添加/编辑功能菜单</title>
	<link type="text/css" rel="stylesheet" href="<%=request.getContextPath()%>/user/css/common-style.css">
	<link rel="stylesheet" type="text/css" href="<%=request.getContextPath()%>/user/css/style.css" />
	<script type='text/javascript' src="<%=request.getContextPath()%>/user/js/pagedData.js"></script>
	<script type='text/javascript' src="<%=request.getContextPath()%>/user/js/common.js"></script>
	<script type='text/javascript' src="<%=request.getContextPath()%>/user/js/property.js"></script>
</head>

<body>

<!-- Nav -->
<div class="Pad03"></div>
<fieldset><legend>添加/编辑功能菜单</legend>

<form id="iform" method="post" action="<%=request.getContextPath()%>/user/createOrUpdatePri.do" onsubmit="return inputcheck();">
<c:if test="${not empty pri.id}"><input name="id" type="hidden" value="${pri.id}"/></c:if>
<table  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th width="30%" scope="row">功能名称：</th>
    <td width="70%"><input name="priname" type="text" value="${pri.priname}"  size="100"/></td>
  </tr>
  <tr>
    <th scope="row">链接地址：</th>
    <td>
      <input name="priurl" type="text" size="100" value="${pri.priurl}" /></td>
  </tr>
  <tr>
    <th scope="row">上级菜单：</th>
    <td>
    	<select name="pid" id="pid" style="width:180px;"> 
			<option value="">- 顶级菜单 -</option>
			<c:forEach var="e" items="${pris}">
			<c:if test="${pri.id != e.id}"> <!-- 不显示自己 -->
				<option value="${e.id}" >${e.priname}</option>
			</c:if>
			</c:forEach>
		</select>
	</td>
  </tr>
  <tr>
    <th scope="row">设置无效：</th>
    <td>
    <c:if test="${not empty pri.id}"> 
	    <c:if test="${pri.isAble == 1}"><input name="isAble" type="checkbox" value="0" /></c:if>
	    <c:if test="${pri.isAble != 1}"><input name="isAble" type="checkbox" checked="checked" value="0"  /></c:if>
    </c:if>
    <c:if test="${empty pri.id}"> 
    	<input name="isAble" type="checkbox" value="0" />
    </c:if>
    </td>
  </tr>
  <tr>
    <th scope="row">隐藏：</th>
    <td>
    <c:if test="${not empty pri.id}"> 
	    <c:if test="${pri.priDisplay == 0}"><input name="priDisplay" type="checkbox" value="1" /></c:if>
	    <c:if test="${pri.priDisplay != 0}"><input name="priDisplay" type="checkbox" checked="checked" value="1"  /></c:if>
    </c:if>
    <c:if test="${empty pri.id}"> 
    	<input name="priDisplay" type="checkbox" value="1" />
    </c:if>
    </td>
  </tr>
</table>
<c:if test="${not empty pri.pri.id}">
<script>
	setSelected('pid',${pri.pri.id});
	//$('pid').disabled=true;
</script>
</c:if>
<p align="center"><input name="save" type="submit" value="保存"/> <input name="reset" type="reset" value="重置" />
</p>
</form></fieldset>
<div class="Pad10"></div>


</body>
</html>

