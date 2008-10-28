<%@ Page Language="VB" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<script runat="server">

</script>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>.NET 2.0 Test</title>
</head>
<script runat="server">
    Dim testString As String = "hello world"
</script>

<body>
    <form id="form1" runat="server">
    <h1><%Response.Write(testString)%></h1>
    </form>
</body>
</html>
