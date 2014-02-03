<?php
    /**
     * Подключение функций и проверка авторизации
     */
    $error_message = '';
    include("functions/functions.php");
    if (is_authorised()) {
        redirect("index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Авторизация</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="bootstrap/css/login-style.css" rel="stylesheet">

</head>

<body>

<div class="container">
    <form class="form-signin" method="post" action="login.php">
        <?=$error_message?>
        <h2 class="form-signin-heading">Авторизуйтесь:</h2>
        <input type="text" class="input-block-level" placeholder="Логин" name="login">
        <input type="password" class="input-block-level" placeholder="Пароль" name="pass">
        <input type="hidden" name="login-post" value="true">
        <button class="btn btn-large btn-primary" type="submit">Войти</button>
    </form>

</div> <!-- /container -->

</body>
</html>
