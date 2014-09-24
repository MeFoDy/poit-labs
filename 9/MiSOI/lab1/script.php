<?php
ini_set('display_errors', 'on');

require_once("fksistagram.php");

$worker = new Fksistagram('images/lenna.png');
$worker->histogramm();
$worker->out();