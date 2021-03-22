<?php
/**
 * Modul Mail
 *
 * @package   mod\mail
 * @link      https://ch-hexen.de
 * @author    Momo Pfirsich <momo@ch-hexen.de>
 * @copyright Copyright (c) 2019 Momo Pfirsich <momo@ch-hexen.de>
 * @ignore
 */
  if(!isset($log)) $log = '';
  try {
    if(!file_exists(__DIR__.'/../user/functions.php')) {
        throw new Exception(__DIR__.'/../user/functions.php does not exist');
    }
    elseif(!file_exists(__DIR__.'/functions.php')) {
      throw new Exception(__DIR__.'/functions.php does not exist');
    }
    else {
      require_once(__DIR__.'/../user/functions.php');
      $userInfoAll = getUserInfoAll('u.username, u.mail, us.send_reminder');

      // write to log
      $log .= " * getUserInfoAll".PHP_EOL
             ." * * ".((!empty($userInfoAll))?count($userInfoAll):'0').PHP_EOL;

      if(!empty($userInfoAll)) {
        $month = date('m Y', strtotime("first day of this month"));

        require_once(__DIR__.'/functions.php');
        $log .= " * newMailReminder".PHP_EOL;
        foreach($userInfoAll as $user) {
          if($user['send_reminder']) {
            $mail = ((newMailReminder($user['username'], $user['mail'], $month))? 'SUCCESS' : 'ERROR');
          }
          else {
            $mail = 'disabled';
          }

          // write to log
          $log .= " * * ".$user['id'].' - '.$mail.PHP_EOL;
        }
      }
    }
  }
  catch(Exception $error) {
    $log .= " * require mail".PHP_EOL
           ." * * ERROR - ".$error.PHP_EOL;
  }
print $log;
?>