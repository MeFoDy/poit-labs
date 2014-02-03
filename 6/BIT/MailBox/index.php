<?php
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
$title = "Mail Box";
$isMainActive = $isDocumentsActive = $isAbonentsActive = $isIncomeActive = $isOutcomeActive = $isNewDocumentActive = '';
$isMainActive = ' class="active"';

/**
 * Подключение заголовочного файла
 */
include_once("header.php");
/**
 * Вывод контента текущей страницы
 */
?>

            <img src="images/mailbox.jpg" width="300px" style="float:right">
            <h2>Главная</h2>
            <p>
                Выберите подходящее действие в меню слева.
            </p>

            <dt>Новый</dt>
            <dd>Создание нового сообщения.</dd>

            <dt>Входящие</dt>
            <dd>Просмотр присланных Вам сообщений.</dd>

            <dt>Исходящие</dt>
            <dd>Просмотр отправленных Вами сообщений.</dd>

            <dt>Просмотр</dt>
            <dd>Вывод полного списка абонентов.</dd>

            <dt>Выход</dt>
            <dd>Закрытие сессии авторизации.</dd>
<?php
/**
 * Вывод подвала сайта
 */
include_once("footer.php");