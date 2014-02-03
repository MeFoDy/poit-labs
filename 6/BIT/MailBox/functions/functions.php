<?php

session_start();

include_once("config.php");

/**
 * подключение к базе данных
 */
function connect_db()
{
    global $dbHost, $dbLogin, $dbPassword, $dbBase;
    if (!mysql_connect($dbHost, $dbLogin, $dbPassword)) {
        die("Can't connect to MySQL.");
    }
    if (!mysql_select_db($dbBase)) {
        die("Can't select DataBase.");
    }
}

/**
 * @return bool
 * Функция выполняет проверку авторизации текущего пользователя
 */
function is_authorised()
{
    connect_db();
    // проверка сессии на вмешательство извне
    if (isset($_SESSION['hash'])) {
        $_SESSION['hash'] = mysql_real_escape_string($_SESSION['hash']);
    }
    if (isset($_SESSION['login'])) {
        $_SESSION['login'] = trim(mysql_real_escape_string($_SESSION['login']));
    }
    global $error_message;
    $error_message = '';
    // нажата кнопка выхода
    if (isset($_GET['exit'])) {
        $error_message = '<p class="text-error">Выход из приложения</p>';
        $_SESSION = array();
        return false;
    }
    // попытка авторизации
    if (isset($_POST['login-post']) && $_POST['login-post']) {
        $query = mysql_query("SELECT * FROM `users` WHERE `login` = '"
            . mysql_real_escape_string(strtolower(trim($_POST['login'])))
            . "' LIMIT 1");
        if ($query && $result = mysql_fetch_assoc($query)) {
            $_SESSION = array();
            // при неправильном вводе пароля
            if ($_POST['pass'] !== $result['pass']) {
                $error_message = '<p class="text-error">Неправильный пароль</p>';
                return false;
            }
            $_SESSION['login'] = $result['login'];
            $_SESSION['userId'] = $result['id'];
            $_SESSION['hash'] = md5(time() . $_SESSION['login']);
            if (!mysql_query("UPDATE `users` SET `isActive` = TRUE, `lastTime` = CURRENT_TIMESTAMP, `hash` = '"
                . $_SESSION['hash'] . "' WHERE `login` = '" . $_SESSION['login'] . "'")
            ) {
                $error_message = '<p class="text-error">Сбой базы данных</p>';
                return false;
            }
            // успешная авторизация
            $error_message = '<p class="text-success">Авторизация прошла успешно</p>';
            return true;
        } else {
            $error_message = '<p class="text-error">Неправильный логин/пароль</p>';
            return false;
        }
    } else {
        // был авторизован ранее
        if (isset($_SESSION['login']) && isset($_SESSION['hash'])) {
            $query = mysql_query("SELECT * FROM `users` WHERE `login` = '"
                . $_SESSION['login']
                . "' AND (CURRENT_TIMESTAMP - `lastTime` < 10440) AND (`hash` = '" . $_SESSION['hash'] . "')"
                . " AND `isActive` LIMIT 1");
            if ($query && $result = mysql_fetch_assoc($query)) {
                if (!mysql_query("UPDATE `users` SET `isActive` = TRUE, `lastTime` = CURRENT_TIMESTAMP WHERE `login` = '"
                    . $_SESSION['login'] . "'")
                ) {
                    $error_message = '<p class="text-error">Сбой базы данных</p>';
                    return false;
                }
                $error_message = '<p class="text-success">Авторизация прошла успешно</p>';
                return true;
            } else {
                $error_message = '<p class="text-error">Истекло максимальное время неактивности пользователя</p>';
                return false;
            }
        }
        return false;
    }
}

function get_new_messages_count()
{
    connect_db();
    $query = mysql_query("SELECT COUNT( * ) AS count "
        . "FROM `messages` LEFT JOIN `users` ON `users`.`id` = `messages`.`idUserTo` "
        . "WHERE `messages`.`idUserOwner` = " . $_SESSION['userId']
        . " AND `messages`.`isRead` = FALSE"
        . " AND `messages`.`idUserTo` = " . $_SESSION['userId']);
    $result = mysql_fetch_assoc($query);
    if ($result) {
        return $result['count'];
    }
    return 0;
}

/**
 * @param $url
 * Функция делает переадресацию на другую страницу
 * url - адрес страницы
 */
function redirect($url)
{
    if (!headers_sent()) {
        //Если заголовки еще не отправлены...
        //пробуем редирект на php
        header("Location: " . $url);
        exit;
    } else {
        //Если заголовки отправлены...
        //делаем редирект на javascript ...
        //если javascript отключен, делаем редирект на html.
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
        echo '</noscript>';
        exit;
    }
}

/**
 * @param $obj
 * вывод отладочной информации
 */
function print_otlad($obj)
{
    echo "<pre>";
    print_r($obj);
    echo "</pre>";
}

/**
 * Функция отдачи файла $file пользователю
 */
function file_force_download($file, $name)
{
    if (file_exists($file)) {
        // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
        // если этого не сделать файл будет читаться в память полностью!
        if (ob_get_level()) {
            ob_end_clean();
        }
        // заставляем браузер показать окно сохранения файла
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        // читаем файл и отправляем его пользователю
        if ($fd = fopen($file, 'rb')) {
            while (!feof($fd)) {
                print fread($fd, 1024);
            }
            fclose($fd);
        }
        exit;
    } else {
        echo "Error: File not found";
    }
}