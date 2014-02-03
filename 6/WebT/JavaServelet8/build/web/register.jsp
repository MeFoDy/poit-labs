
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
       
    <% 
        String login = request.getParameter("login");
        String pass = request.getParameter("pass");

        if (!newpackage.auth.Register(login, pass)){
    %>    
    <h1> Ошибка создания пользователя </h1>    
    
    <% } else { %>
    
    <h2> Пользователь успешно зарегистрирован </h2>
   
    <% 
        session.setAttribute("login", login);
        session.setAttribute("pswd", pass.hashCode());
    } %>
</html>
