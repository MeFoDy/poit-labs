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
$isMainActive = $isDocumentsActive = $isAbonentsActive = $isIncomeActive = $isOutcomeActive = $isNewDocumentActive = '';
$title = "Оптимизация базы загруженных файлов | MailBox";

/**
 * Подключение заголовочного файла
 */
include_once("header.php");
/**
 * Вывод контента текущей страницы
 */
?>
<legend>Оптимизация базы загруженных файлов</legend>
<pre><?php
    /**
     * удаление отсутсвующих в базе файлов
     */
    echo "====== УДАЛЕНИЕ УСТАРЕВШИХ ФАЙЛОВ, УДАЛЕННЫХ ПОЛЬЗОВАТЕЛЯМИ ======\n";
    $query = mysql_query("SELECT DISTINCT `fileId` FROM `messages`");
    $filesFromMessages = array();
    while ($result = mysql_fetch_assoc($query)) {
        if ($result['fileId']) {
            $filesFromMessages[] = $result['fileId'];
        }
    }

    $query = mysql_query("SELECT `id`, `path` FROM `files`");
    $filesFromFiles = array();
    while ($result = mysql_fetch_assoc($query)) {
        if ($result['id']) {
            $filesFromFiles[$result['id']] = $result['path'];
        }
    }
    foreach ($filesFromFiles as $key => $fileFromFiles) {
        if (array_search($key, $filesFromMessages) === false) {
            echo $fileFromFiles . " - сообщений с файлом не найдено. ";
            if (mysql_query("DELETE FROM `files` WHERE `id`=" . $key)) {
                echo "Упоминание в базе удалено.";
            }
            echo "\n";
        }
    }

    echo "Удаление завершено.\n";

    echo "====== УДАЛЕНИЕ ОТСУТСТВУЮЩИХ В БАЗЕ ФАЙЛОВ ======\n";
    $query = mysql_query("SELECT `path` FROM `files`");
    $filesFromDb = array();
    while ($result = mysql_fetch_assoc($query)) {
        $filesFromDb[] = $result['path'];
    }
    $filesFromFileSystem = array();
    if ($handle = opendir('./files')) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                $filesFromFileSystem[] = $file;
            }
        }
        closedir($handle);
    }
    foreach ($filesFromFileSystem as $fileFromFs) {
        if (array_search($fileFromFs, $filesFromDb) === false) {
            echo $fileFromFs . " - не найден в базе данных. ";
            if (unlink("./files/" . $fileFromFs)) {
                echo "Удален.";
            }
            echo "\n";
        }
    }
    echo "Удаление завершено.\n";

    ?>
</pre>
<?php
/**
 * Вывод подвала сайта
 */
include_once("footer.php");