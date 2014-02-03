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
$title = "Список абонентов | Mail Box";
$isMainActive = $isDocumentsActive = $isAbonentsActive = $isIncomeActive = $isOutcomeActive = $isNewDocumentActive = '';
$isAbonentsActive = ' class="active"';

/**
 * Подключение заголовочного файла
 */
include_once("header.php");
/**
 * Вывод контента текущей страницы
 */
?>

<h2>Список абонентов</h2>
<?php
connect_db();
?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>№</th>
        <th>Идентификатор</th>
        <th>Отправить</th>
    </tr>
    </thead>
    <tbody>
<?php
$query = mysql_query("SELECT `id`, `login` FROM `users` WHERE `login` != '".$_SESSION['login']."'");
while ($result = mysql_fetch_assoc($query)) {
    echo "<tr><td>".$result['id']."</td><td>".$result['login']."</td>"
    ."<td><a href=\"mail.php?action=new&userid=".$result['id']."\"><big><i class=\"icon-envelope\"></i></big></a></td></tr>";
}
?></tbody>
</table>
<?php
/**
 * Вывод подвала сайта
 */
include_once("footer.php");