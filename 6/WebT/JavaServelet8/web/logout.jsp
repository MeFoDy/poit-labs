
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JSP Page</title>
    </head>
    <body>
        <% session.removeAttribute("pswd");
            session.removeAttribute("login");
        %>
        <h1>Всего доброго!</h1>
    </body>
</html>
