<?php
// Cronjob monthly 01
  defined('CH_ROOT') || define('CH_ROOT', '');
// write to log
$log  = "Date: ".date("Y-m-d H:i:s").PHP_EOL;

// Ersparnisse
  include_once(CH_ROOT."/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/saving/setSavingPlaceAll.php");

$log .= "-------------------------".PHP_EOL;
$save = file_put_contents(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/cron/log_monthly01.'.date("Y").'.log', $log, FILE_APPEND);

?>
