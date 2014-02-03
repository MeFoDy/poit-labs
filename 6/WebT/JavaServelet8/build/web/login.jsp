
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
      
    <% 
        String login = request.getParameter("login");
        String pass = request.getParameter("pass");

        if (!newpackage.auth.IsLogin(login, Integer.toString(pass.hashCode()))){
    %>    
    <h1> Авторизация не выполнена </h1>    
    
    
    <% } else { %>
    
    <h2> Авторизация выполнена </h2>
   
    <% 
        int hhhs = pass.hashCode();
        
        session.setAttribute("login", login);
        session.setAttribute("pswd", Integer.toString(hhhs));
    } %>
</html>
