<?php
define("mailBox", "mailBox");
/**
 * Подключение функций и проверка авторизации
 */
include("functions/functions.php");
if (!is_authorised()) {
    redirect("login.php");
    exit;
}

/**
 * Секция объявления переменных для данной страницы
 * title - заголовок страницы
 */
$isMainActive = $isDocumentsActive = $isAbonentsActive = $isIncomeActive = $isOutcomeActive = $isNewDocumentActive = '';

/**
 * Определение нужного контроллера
 */
$message = "";
if (isset($_GET['remove']) && $_GET['remove'] === 't' && isset($_GET['messageid'])) {
    // если был запрос на удаление файла
    $messageId = mysql_real_escape_string($_GET['messageid']);
    if ($query = mysql_query("DELETE FROM `messages` WHERE `id` = " . $messageId . " AND `idUserOwner` = " . $_SESSION['userId'])) {
        $message = "<div class=\"alert alert-info\">"
            . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>"
            . "Сообщение удалено"
            . "</div>";
    }
    else {
        $message = "<div class=\"alert alert-error\">"
            . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>"
            . "<h4>Не удалось удалить сообщение</h4>"
            . "Возможно, у Вас недостаточно прав для совершения данной операции"
            . "</div>";
    }
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == "new") {
        $title = "Новое сообщение | Mail Box";
        $included_file = "mail-new.php";
        $isDocumentsActive = $isNewDocumentActive = ' class="active"';
    } elseif ($_GET['action'] == "outcome") {
        $title = "Исходящие | Mail Box";
        $included_file = "mail-outcome.php";
        $isDocumentsActive = $isOutcomeActive = ' class="active"';
    } elseif ($_GET['action'] == "income") {
        $title = "Входящие | Mail Box";
        $included_file = "mail-income.php";
        $isDocumentsActive = $isIncomeActive = ' class="active"';
    }
} else {
    $title = "Входящие | Mail Box";
    $included_file = "mail-income.php";
    $isDocumentsActive = $isIncomeActive = ' class="active"';
}

/**
 * Подключение заголовочного файла
 */
include_once("header.php");
/**
 * Вывод контента текущей страницы
 */
include_once($included_file);
/**
 * Вывод подвала сайта
 */
include_once("footer.php");