<?php
if (!@defined(mailBox)) {
    die("Несанкционированный доступ к файлу");
}
?>

<h2>Исходящие</h2>
<?php
connect_db();
echo $message;
?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Когда</th>
        <th>Кому</th>
        <th width="50%">Тема</th>
        <th>Удалить</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $query = mysql_query("SELECT `messages`.`id`, `idUserTo`, `users_from`.`login`, `theme`, `time`, `isRead` "
        ."FROM `messages` "
        ."LEFT JOIN `users` as `users_from` ON `users_from`.`id` = `messages`.`idUserTo` "
        ."LEFT JOIN `users` as `current_user` ON `current_user`.`id` = `messages`.`idUserFrom` "
        ."WHERE `current_user`.`login` = '".$_SESSION['login']."' AND `current_user`.`id` = `messages`.`idUserOwner` "
        ."ORDER BY `time` DESC");
    while ($result = mysql_fetch_assoc($query)) {
        $tr_style = "";
        // подсветка непрочитанных сообщений полужирным шрифтом
        if ($result['isRead'] == false) {
            $tr_style = " style='font-weight:bold;'";
        }
        echo "<tr".$tr_style."><td>".$result['time']."</td>"
            ."<td><a href=\"mail.php?action=new&userid=".$result['idUserTo']."\">".$result['login']."</a></td>"
            ."<td><a style=\"display:block;\" href=\"message.php?messageid=".$result['id']."\">".$result['theme']."</a></td>"
            ."<td><a class=\"remove-button\" href=\"mail.php?action=outcome&remove=t&messageid=".$result['id']."\"><big><i class=\"icon-remove\"></i></big></a></td></tr>";
    }
    ?></tbody>
</table>
<script>
    bootbox.setLocale("ru");
    $(document).on("click", "a.remove-button", function(e) {
        e.preventDefault();
        var location = $(this).attr('href');
        bootbox.confirm("Вы уверены, что хотите удалить письмо?", function(result) {
            if(result) {
                window.location.replace(location);
            }
        });
    });
</script>