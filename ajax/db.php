<?php
$GLOBALS['$db_host'] = '10.35.249.151';
$GLOBALS['$db_user'] = 'k29892_saverace';
$GLOBALS['$db_pass'] = 'LiTTlE89&SaveRace';
$GLOBALS['$db_database'] = 'k29892_saverace';

date_default_timezone_set('Europe/Berlin');

global $link;
$link = mysqli_connect($GLOBALS['$db_host'], $GLOBALS['$db_user'], $GLOBALS['$db_pass'], $GLOBALS['$db_database']);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
mysqli_set_charset($link , 'utf8mb4');
?>