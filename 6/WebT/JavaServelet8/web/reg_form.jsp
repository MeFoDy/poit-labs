
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Регистрация</title>
    </head>
     <% 
    
        String login = (String)session.getAttribute("name");
        
        
       if ( (login == null) || (login.equals("")) ) {%>
    
       
       <body>
        <h1>Регистрация</h1> </br>
        
        <form method="POST" action="./register.jsp">
            <b>Логин:</b>
            <input type="text" name="login"></br>
            <b>Пароль</b>
            <input type="password" name="pass"></br>
            <input type="submit" value="Регистрация">
        </form></br>
        
        
       </body>
    <% } %>
</html>
