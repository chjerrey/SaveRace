<?php if(!isset($_SESSION)) session_start(); ?>
<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
// User
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/user/functions.php');

  if($layoutLoginBool && 
     !empty($_POST['action']) && $_POST['action'] == 'logout') {
    $login = '<div class="column is-one-third is-centered">
                <article class="message is-info">
                  <div class="message-header">
                    <p>Verarbeitung</p>
                  </div>
                  <div class="message-body">
                    Dein Logout wird gerade verarbeitet.
                  </div>
                </article>
              </div>';

    $userLogout = setUserLogout();
    if($userLogout) {
      $login = '<div class="column is-one-third is-centered">
                <article class="message is-success">
                  <div class="message-header">
                    <p>Erfolg</p>
                  </div>
                  <div class="message-body">
                    Dein Logout wurde erfolgreich verarbeitet.
                  </div>
                </article>
              </div>';
      print '<meta http-equiv="refresh" content="1; url=https://saverace.ch-hexen.de/">';
    }
    else {
      $login = '<div class="column is-one-third is-centered">
                <article class="message is-danger">
                  <div class="message-header">
                    <p>Fehler</p>
                  </div>
                  <div class="message-body">
                    Dein Logout konnte nicht durchgeführt werden!
                  </div>
                </article>
              </div>';
    }
  }
  elseif($layoutLoginBool) {
    $login  = '<div class="column is-one-third is-centered">
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
       $_POST['action'] == 'login') {
//print '<pre>_POST => '; print_r($_POST); print '</pre>';
      $login = '<div class="column is-one-third is-centered">
                  <article class="message is-info">
                    <div class="message-header">
                      <p>Verarbeitung</p>
                    </div>
                    <div class="message-body">
                      Dein Login wird gerade verarbeitet.
                    </div>
                  </article>
                </div>';

      $userLogin = setUserLogin($_POST['login']['email'], $_POST['login']['password']);
      if($userLogin) {
        $login = '<div class="column is-one-third is-centered">
                  <article class="message is-success">
                    <div class="message-header">
                      <p>Erfolg</p>
                    </div>
                    <div class="message-body">
                      Dein Login wurde erfolgreich verarbeitet.
                    </div>
                  </article>
                </div>';
        print '<meta http-equiv="refresh" content="1; url=https://saverace.ch-hexen.de/">';
      }
      else {
        $login = '<div class="column is-one-third is-centered">
                  <article class="message is-danger">
                    <div class="message-header">
                      <p>Fehler</p>
                    </div>
                    <div class="message-body">
                      Dein Login konnte nicht durchgeführt werden!<br />
                      Bitte prüfe die eingegebenen Daten.
                    </div>
                  </article>
                </div>'
                .showLogin('site');
      }
    }
    else {
      $login = showLogin('site');
    }
  }

?>
