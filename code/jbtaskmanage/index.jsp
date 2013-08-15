<%@ page contentType="text/html; charset=utf-8" isELIgnored="false"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/fmt" prefix="fmt"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" prefix="fn"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>后台系统</title>
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="cache-control" content="no-cache"/>
		<meta http-equiv="expires" content="0"/>
		<meta http-equiv="keywords" content="keyword1,keyword2,keyword3"/>
		<meta http-equiv="description" content="This is my page"/>
		<link type="text/css" rel="stylesheet" href="<%=request.getContextPath()%>/css/css.css"/>
		<c:if test="${not empty message}">
			<script>
				alert("${message}");
			</script>
		</c:if>
	</head>
<BODY style="MARGIN-TOP: 107px"  >
<form action="<%=request.getContextPath()%>/login.do" method="post">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD align=middle>
      <TABLE width=587 height="304" border=0 align="center" cellPadding=0 cellSpacing=0>
        <TBODY>
        <TR>
          <TD height="65" align=center>
	 
          </TD>
        </TR>
        <TR vAlign=top>
          <TD height=239 background="<%=request.getContextPath()%>/login_bg.gif" ><table width="310" border="0" align="right" cellpadding="1" cellspacing="0">
            
              <tbody>
                  <tr>
                    <td height="95">&nbsp;</td>
                    <td width="121">&nbsp;</td>
                    <td width="45">&nbsp;</td>
                  </tr>
                  <tr>
                  <td width="138"><input type="text" name="userName"  value="" style="BORDER-RIGHT: medium none; BORDER-TOP: medium none; BORDER-LEFT: medium none; WIDTH: 123px; BORDER-BOTTOM: medium none; HEIGHT: 18px; BACKGROUND-COLOR: transparent" /></td>
                  <td width="121" rowspan="3"><input name="image" type="image"  value="提交" src="<%=request.getContextPath()%>/login.gif" align="absmiddle" /></td>
                  <td width="45" rowspan="3">&nbsp;</td>
                  </tr>
                <tr>
                  <td height="24" valign="bottom"><input type="password" name="password"  value="" style="BORDER-RIGHT: medium none; BORDER-TOP: medium none; BORDER-LEFT: medium none; WIDTH: 123px; BORDER-BOTTOM: medium none; HEIGHT: 18px; BACKGROUND-COLOR: transparent" /></td>
                  </tr>
                <tr>
                  <td height="23" align="left" valign="bottom"><img src="<%=request.getContextPath()%>/pub/validate.do" alt="" width="68" height="20" align="absmiddle" /> =　
                    <input type="text" name="number" value="" style="BORDER-RIGHT: medium none; BORDER-TOP: medium none; BORDER-LEFT: medium none; WIDTH: 40px; BORDER-BOTTOM: medium none; HEIGHT: 18px; BACKGROUND-COLOR: transparent" /></td>
                  </tr>
              </tbody>
            
          </table></TD>
</TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
</form>
</BODY>
</HTML>
