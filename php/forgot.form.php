<?php if(!isset($_SESSION)) session_start(); ?>
<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
// User
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/user/functions.php');

  if($layoutLoginBool) {
    $forgot  = '<div class="column is-one-third is-centered">
                  <article class="message is-danger">
                    <div class="message-header">
                      <p>Fehler</p>
                    </div>
                    <div class="message-body">
                      Du bist bereits eingeloggt!
                    </div>
                  </article>
                </div>';
  }
  else {
    if(!empty($_POST['action']) && 
       $_POST['action'] == 'forgot') {
//print '<pre>_POST => '; print_r($_POST); print '</pre>';
      $forgot  = '<div class="column is-one-third is-centered">
                    <article class="message is-info">
                      <div class="message-header">
                        <p>Verarbeitung</p>
                      </div>
                      <div class="message-body">
                        Deine Anfrage wird gerade verarbeitet.
                      </div>
                    </article>
                  </div>';

      $userLogin = newUserPassword($_POST['forgot']['email']);
      if($userLogin) {
        $forgot  = '<div class="column is-one-third is-centered">
                      <article class="message is-success">
                        <div class="message-header">
                          <p>Erfolg</p>
                        </div>
                        <div class="message-body">
                          Dir wurde ein neues Passwort zugesandt.
                        </div>
                      </article>
                    </div>';
      }
      else {
        $forgot  = '<div class="column is-one-third is-centered">
                      <article class="message is-danger">
                        <div class="message-header">
                          <p>Fehler</p>
                        </div>
                        <div class="message-body">
                          Deine Anfrage konnte nicht verarbeitet werden!<br />
                          Bitte prüfe die eingegebenen Daten.
                        </div>
                      </article>
                    </div>'
                    .showForgot('site');
      }
    }
    else {
      $forgot = showForgot('site');
    }
  }

?>
