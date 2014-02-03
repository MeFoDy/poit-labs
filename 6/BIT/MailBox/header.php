<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?=$title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Le styles -->
    <link rel="stylesheet" href="elrte/css/elrte.min.css" />

    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="bootstrap/css/whhg.css" rel="stylesheet">
    <link href="bootstrap/css/style.css" rel="stylesheet">
    <!-- Le scripts -->
    <script src="bootstrap/js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/bootbox.min.js"></script>

    <!-- jQuery and jQuery UI -->
    <link rel="stylesheet" href="elrte/css/smoothness/jquery-ui-1.8.13.custom.css" media="screen">
    <link rel="stylesheet" href="elrte/css/elrte.min.css" media="screen">
</head>

<body>

<div class="navbar navbar-inverse">
    <div class="navbar-inner">
        <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="/">Mail Box</a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li<?=$isMainActive?>><a href="/">Главная</a></li>
                    <li<?=$isDocumentsActive?>><a href="mail.php">Документы</a></li>
                    <li<?=$isAbonentsActive?>><a href="abonents.php">Список абонентов</a></li>
                    <li><a href="?exit=true">Выход</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class="container">

    <!-- Example row of columns -->
    <div class="row">
        <div class="span3">
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                    <li class="nav-header">Документы</li>
                    <li<?=$isNewDocumentActive?>>
                        <a href="mail.php?action=new"><i class="icon-envelope"></i> Новый</a>
                    </li>
                    <li<?=$isIncomeActive?>>
                        <a href="mail.php?action=income"><i class="icon-inboxalt"></i> Входящие (<?=get_new_messages_count()?>)</a>
                    </li>
                    <li<?=$isOutcomeActive?>>
                        <a href="mail.php?action=outcome"><i class="icon-outbox"></i> Исходящие</a>
                    </li>

                    <li class="nav-header">Список абонентов</li>
                    <li<?=$isAbonentsActive?>>
                        <a href="abonents.php"><i class="icon-phonebookalt"></i> Просмотр</a>
                    </li>

                    <li class="nav-header">Вы вошли как <strong><?=$_SESSION['login']?></strong></li>
                    <li>
                        <a href="?exit=true"><i class="icon-exit"></i> Выход</a>
                    </li>
                </ul>
            </div>
            <!--/.well -->
        </div>
        <div class="span9">