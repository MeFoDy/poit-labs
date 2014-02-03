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
$title = "Просмотр сообщения | Mail Box";
$isMainActive = $isDocumentsActive = $isAbonentsActive = $isIncomeActive = $isOutcomeActive = $isNewDocumentActive = '';
$isDocumentsActive = ' class="active"';

/**
 * Подключение заголовочного файла
 */
include_once("header.php");
/**
 * Вывод контента текущей страницы
 */
?>

<h2>Просмотр сообщения</h2>
<?php
connect_db();
if (isset($_GET['messageid'])) {
    if ($query = mysql_query("SELECT * FROM `messages` WHERE `id` = "
        . mysql_real_escape_string($_GET['messageid']) . " AND `idUserOwner` = " . $_SESSION['userId'])
    ) {
        $message = mysql_fetch_assoc($query);
        if ($message['idUserTo'] === $message['idUserOwner']) {
            $messageType = "От кого";
            $userTo = $message['idUserFrom'];
        } else {
            $messageType = "Кому";
            $userTo = $message['idUserTo'];
        }

        $query = mysql_query("UPDATE `messages` SET `isRead` = TRUE WHERE `id` = "
            . mysql_real_escape_string($_GET['messageid']) . " AND `idUserOwner` = " . $_SESSION['userId']);

        $query = mysql_query("SELECT `id`, `login` FROM `users` WHERE `id` = '" . $userTo . "'");
        $user = mysql_fetch_assoc($query);


        ?>
    <h6 class="muted"><?=$messageType?></h6>
    <p><?=$user['login']?></p>
    <h6 class="muted">Тема сообщения
        <small>(<?=$message['time']?>)</small>
        :
    </h6>
    <p><?=$message['theme']?></p>
    <h6 class="muted">Сообщение:</h6>
    <div class="well"><?=$message['message']?></div>
    <?php
        if ($message['fileId']) {
            echo "<h6 class='muted'>Прикрепленный файл:</h6>";
            if ($query = mysql_query("SELECT `filename` FROM `files` WHERE `id` = " . $message['fileId'])) {
                echo "<a class='btn btn-primary' href='download.php?fileid=" . $message['fileId'] . "'>"
                    . "<i class='icon-download-alt'></i> "
                    . mysql_fetch_assoc($query)['filename']
                    . "</a>";
            }
        }
        ?>
    <a class="remove-button btn btn-info" href="mail.php?action=income&remove=t&messageid=<?=$message['id']?>">
        <i class="icon-remove"></i> Удалить сообщение
    </a>
    <script>
        bootbox.setLocale("ru");
        $(document).on("click", "a.remove-button", function (e) {
            e.preventDefault();
            var location = $(this).attr('href');
            bootbox.confirm("Вы уверены, что хотите удалить письмо?", function (result) {
                if (result) {
                    window.location.replace(location);
                }
            });
        });
    </script>
    <?php
    }
}
/**
 * Вывод подвала сайта
 */
include_once("footer.php");