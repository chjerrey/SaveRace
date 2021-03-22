<?php
/**
 * Modul Ersparnisse
 *
 * @package   mod\saving
 * @link      https://ch-hexen.de
 * @author    Momo Pfirsich <momo@ch-hexen.de>
 * @copyright Copyright (c) 2019 Momo Pfirsich <momo@ch-hexen.de>
 * @ignore
 */
  if(!isset($log)) $log = '';
  try {
    if(!file_exists(__DIR__.'/functions.php')) {
      throw new Exception(__DIR__.'/functions.php does not exist');
    }
    else {
      require_once(__DIR__.'/functions.php');
      $log .= " * setSavingPlaceAll".PHP_EOL;
      $saving = setSavingPlaceAll();

      // write to log
      $log .= " * * ".$saving.PHP_EOL;
    }
  }
  catch(Exception $error) {
    $log .= " * require saving".PHP_EOL
           ." * * ERROR - ".$error.PHP_EOL;
  }
print $log;
?>