<?php
include_once("functions/functions.php");

if (isset($_GET['fileid'])) {
    connect_db();
    $query = mysql_query("SELECT COUNT(*) as count FROM `messages` WHERE `fileId` = "
        . mysql_real_escape_string($_GET['fileid'])
        . " AND `idUserOwner` = " . $_SESSION['userId']);
    $result = mysql_fetch_assoc($query)['count'];
    if ($result <= 0) {
        die("This is not your file!");
    }

    $query = mysql_query("SELECT * FROM `files` WHERE `id` = "
        . mysql_real_escape_string($_GET['fileid']));
    $fileInfo = mysql_fetch_assoc($query);

    file_force_download("./files/".$fileInfo['path'], $fileInfo['filename']);
}