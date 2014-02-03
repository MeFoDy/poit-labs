<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Авторизация</title>
    </head>

    <%

        String login = session.getAttribute("login") != null ? session.getAttribute("login").toString() : null;
        if ((login == null) || (login.equals(""))) {%>


    <body>
        <h1>Вход</h1> </br>

        <form method="POST" action="./login.jsp">
            <b>Логин:</b>
            <input type="text" name="login"></br>
            <b>Пароль</b>
            <input type="password" name="pass"></br>
            <input type="submit" value="Вход">  
        </form></br>
        <a href="./reg_form.jsp">Регистрация</a>

    </body>
    <%} else {

        //    ServletFileUpload upload = new ServletFileUpload(factory);
        String pass = null;
        try {
            pass = session.getAttribute("pswd").toString();
        } catch (Exception ex) {
            out.write(ex.getMessage());
        }

        if (newpackage.auth.IsLogin(login, pass)) { //if authorized correct

    %>

    <form action="FileParser" method="POST" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit">
    </form>

    </br>

    <a href="./logout.jsp">Выход</a>

    <% }
            }%> 


</html>
