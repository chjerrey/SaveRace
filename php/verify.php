<?php if(!isset($_SESSION)) session_start(); ?>
<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
// User
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/user/functions.php');

  print '<h1 class="title is-3">Verifizierung</h1>';
  print  '<div class="tile is-ancestor">
              <div class="tile is-parent is-shady">
                <article class="tile is-child notification is-white">
                  <div class="content">';

  if(isset($_GET['mail']) && !empty($_GET['mail']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    list($vcode, $verify, $refresh, $users_id) = newUserVerify($_GET['mail'], $_GET['hash']);
    print  '<div class="column is-one-third is-centered">
              <article class="message is-'.(($vcode == 'success')? 'success' : (($vcode == 'error')? 'danger' : 'info')).'">
                <div class="message-header">
                  <p>'.(($vcode == 'success')? 'Erfolg' : (($vcode == 'error')? 'Fehler' : 'Verarbeitung')).'</p>
                </div>
                <div class="message-body">
                  '.$verify.'
                </div>
              </article>
            </div>';
    if($refresh) print '<meta http-equiv="refresh" content="1; url=https://saverace.ch-hexen.de/">';
  }
  else {
    print  '<div class="column is-one-third is-centered">
              <article class="message is-danger">
                <div class="message-header">
                  <p>Fehler</p>
                </div>
                <div class="message-body">
                  Deine Verifizierung konnte nicht durchgeführt werden!
                </div>
              </article>
            </div>';
  }

          print  '</div>
                </article>
              </div>
            </div>';
?>
