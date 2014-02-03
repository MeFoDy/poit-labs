<?php
if (!@defined(mailBox)) {
    die("Несанкционированный доступ к файлу");
}
?>
<?php
connect_db();
$message = '';
$hasErrors = false;

// получаем текущее время по базе данных
$query = mysql_query("SELECT CURRENT_TIMESTAMP");
$time = mysql_fetch_assoc($query)['CURRENT_TIMESTAMP'];

/**
 * Если была попытка отправить сообщение
 */
if (isset($_POST['send'])) {
    $query = mysql_query("SELECT COUNT(*) as count FROM `users` WHERE `id`=" . mysql_real_escape_string($_POST['to-whom']));
    $count = mysql_fetch_assoc($query)['count'];
    if ($count == 0) {
        $hasErrors = true;
        $message = "<div class=\"alert alert-error\">"
            . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>"
            . "<h4>Ошибка!</h4>"
            . "Вы не выбрали пользователя, которому собираетесь отправлять сообщение"
            . "</div>";
    } else {
        $fileId = '';
        // если была загрузка файла
        if (isset($_FILES['userfile']['name']) && $_FILES['userfile']['name']) {
            $uploaddir = './files/'; //<----This is all I changed
            $tmpfname = tempnam($uploaddir, "usr");
            $uploadfile = $tmpfname;

            $filename = mysql_real_escape_string(basename($_FILES['userfile']['name']));
            $pathToFile = mysql_real_escape_string(basename($uploadfile));

            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
                $message = "<div class=\"alert alert-success\">"
                    . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>"
                    . "<h4>Файл загружен успешно!</h4>"
                    . "</div>";

                if ($query = mysql_query("INSERT INTO `files` (`filename`, `path`) VALUES ('"
                    . $filename . "', '" . $pathToFile . "')")
                ) {
                    $fileId = mysql_insert_id();
                }
            } else {
                $hasErrors = true;
                $message = "<div class=\"alert alert-error\">"
                    . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>"
                    . "<h4>Ошибка!</h4>";
                switch ($_FILES['userfile']['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $message .= "Превышен максимально допустимый размер файла (100 Мб)";
                        break;
                    default:
                        $message .= "Файл не был загружен";
                }
                $message .= "</div>";
            }
        }
        // делаем запись в базу данных
        $fileId = $fileId ? $fileId : 'NULL';
        $_POST['theme'] = $_POST['theme'] ? $_POST['theme'] : 'Без темы';
        if ($query = mysql_query("INSERT INTO `messages` (`idUserOwner`, `idUserFrom`, `idUserTo`, `theme`, `message`, `time`, `fileId`)"
            . " VALUES ("
            . mysql_real_escape_string($_POST['to-whom']) . ", "
            . $_SESSION['userId'] . ", "
            . mysql_real_escape_string($_POST['to-whom']) . ", '"
            . mysql_real_escape_string($_POST['theme']) . "', '"
            . mysql_real_escape_string($_POST['message']) . "', '"
            . $time . "', " . $fileId
            . ")") &&
            $query = mysql_query("INSERT INTO `messages` (`idUserOwner`, `idUserFrom`, `idUserTo`, `theme`, `message`, `time`, `fileId`)"
                . " VALUES ("
                . $_SESSION['userId'] . ", "
                . $_SESSION['userId'] . ", "
                . mysql_real_escape_string($_POST['to-whom']) . ", '"
                . mysql_real_escape_string($_POST['theme']) . "', '"
                . mysql_real_escape_string($_POST['message']) . "', '"
                . $time . "', " . $fileId
                . ")")
        ) {
            $messageId = mysql_insert_id();
            $message .= "<div class=\"alert alert-success\">"
                . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>"
                . "<h4>Сообщение отправлено!</h4>"
                . "<a href=\"message.php?messageid=" . $messageId . "\">Просмотреть сообщение</a>"
                . "</div>";
        } else {
            $hasErrors = true;
            $message = "<div class=\"alert alert-error\">"
                . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">x</button>"
                . "<h4>Ошибка!</h4>"
                . "Сообщение не было отправлено. Пожалуйста, повторите попытку отправки либо обратитесь к администратору сайта."
                . "</div>";
        }
    }
}

// получаем id пользователя из строки запроса, если он был
if (isset($_GET['userid']) && !empty($_GET['userid'])) {
    $userId = $_GET['userid'];
} else {
    $userId = '';
}
// получаем список возможных адресатов
$userList = array();
$query = mysql_query("SELECT `id`, `login` FROM `users` WHERE `login` != '" . $_SESSION['login'] . "' ORDER BY 'login'");
while ($result = mysql_fetch_assoc($query)) {
    $userList[] = $result;
}

echo $message;
?>
<form class="form-horizontal" action="mail.php?action=new" method="post" enctype="multipart/form-data">
    <span style="float:right"><?=$time?></span>
    <legend>Новое сообщение</legend>
    <div class="control-group">
        <label for="to-whom" class="control-label">Кому</label>

        <div class="controls">
            <select name="to-whom" id="to-whom">
                <option value="-1">- Не выбрано -</option>
                <?php
                foreach ($userList as $user) {
                    $selected = $userId == $user['id'] || ($hasErrors && $userId == $_POST['to-whom'])
                        ? ' selected="selected"'
                        : '';
                    echo "<option value='" . $user['id'] . "'$selected>" . $user['login'] . "</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="control-group">
        <label for="theme" class="control-label">Тема</label>

        <div class="controls">
            <input type="text" id="theme" name="theme" value="<?php echo $hasErrors ? $_POST['theme'] : ''; ?>">
        </div>
    </div>
    <div class="control-group">
        <label for="message" class="control-label">Сообщение</label>

        <div class="controls">
            <textarea name="message" id="message"><?php echo $hasErrors ? $_POST['message'] : ''; ?></textarea>
        </div>
    </div>
    <div class="control-group">
        <label for="userfile" class="control-label">Прикрепить файл</label>

        <div class="controls">
            <input type="hidden" name="MAX_FILE_SIZE" value="<?=100 * 1024 * 1024?>"/>
            <input name="userfile" id="userfile" type="file">
        </div>
    </div>
    <input type="submit" name="send" value="Отправить" class="btn btn-primary">
</form>

<script src="elrte/js/jquery-1.6.1.min.js"></script>
<script src="elrte/js/jquery-ui-1.8.13.custom.min.js"></script>
<script src="elrte/js/elrte.min.js"></script>
<!-- elRTE translation messages -->
<script src="elrte/js/i18n/elrte.ru.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
    $().ready(function () {
        elRTE.prototype.options.panels.web2pyPanel = [
            'bold', 'italic', 'underline', 'forecolor', 'justifyleft', 'justifyright',
            'justifycenter', 'justifyfull', 'formatblock', 'insertorderedlist', 'insertunorderedlist', 'link'
        ];
        elRTE.prototype.options.toolbars.web2pyToolbar = ['web2pyPanel'];
        var opts = {
            toolbar:'web2pyToolbar',
            lang:'ru', // set your language
            styleWithCSS:false,
            height:300
        };
        $('#message').elrte(opts);
    })
</script>