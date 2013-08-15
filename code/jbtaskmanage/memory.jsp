<%@ page language="java" import="java.util.*,java.lang.management.*" pageEncoding="UTF-8"%>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>
<html>
  <head>
    <base href="<%=basePath%>">
    <title>Memory</title>
  </head>
  <%! 
  	  String[] formatMemoryUsage(String name,MemoryUsage usage){
		String[] columnValue = {name,
				usage.getInit()/1024+"",
				usage.getUsed()/1024+"",
				usage.getCommitted()/1024+"",
				usage.getMax()/1024+""};
		return columnValue;
	  }
  %>
  <body>
    <% 
	OperatingSystemMXBean os = ManagementFactory.getOperatingSystemMXBean();
		out.println(os.getName() + " " + os.getVersion() +" [ SystemLoadAverage:"+os.getSystemLoadAverage()
				+" AvailableProcessors:"+os.getAvailableProcessors()+" ]</br>");
	ThreadMXBean tb = ManagementFactory.getThreadMXBean();
		out.println(" Thread [ ThreadCount:"+tb.getThreadCount()
				+" PeakThreadCount:"+tb.getPeakThreadCount()
				+" TotalStartedThreadCount:"+tb.getTotalStartedThreadCount()+" ]");
    %>
    <table border="1">
    		<tr>
	    		<td>Name</td>
	    		<td>Init(K)</td>
	    		<td>Used(K)</td>
	    		<td>Committed(K)</td>
	    		<td>Max(K)</td>
    		</tr>
	<%
	String[] hp = formatMemoryUsage("HeapMemory",ManagementFactory.getMemoryMXBean().getHeapMemoryUsage());
		out.println("<tr><td>"+hp[0]+"</td>");
		out.println("<td>"+hp[1]+"</td>");
		out.println("<td>"+hp[2]+"</td>");
		out.println("<td>"+hp[3]+"</td>");
		out.println("<td>"+hp[4]+"</td></tr>");
	String[] mu = formatMemoryUsage("NonHeapMemory",ManagementFactory.getMemoryMXBean().getNonHeapMemoryUsage());
		out.println("<tr><td>"+mu[0]+"</td>");
		out.println("<td>"+mu[1]+"</td>");
		out.println("<td>"+mu[2]+"</td>");
		out.println("<td>"+mu[3]+"</td>");
		out.println("<td>"+mu[4]+"</td></tr>");
	List<MemoryPoolMXBean> mpms = ManagementFactory.getMemoryPoolMXBeans();
	for(MemoryPoolMXBean mpm : mpms){
		String[] mmu = formatMemoryUsage(mpm.getName(),mpm.getUsage());
		out.println("<tr><td>"+mmu[0]+"</td>");
		out.println("<td>"+mmu[1]+"</td>");
		out.println("<td>"+mmu[2]+"</td>");
		out.println("<td>"+mmu[3]+"</td>");
		out.println("<td>"+mmu[4]+"</td></tr>");
	}
    %>
     </table>
     <a href="memory.jsp?action=gc">GC</a>
     <%
     	String action = request.getParameter("action");
     	if("gc".equals(action)){
     		//System.gc();
     	}
     %>
  </body>
</html>
