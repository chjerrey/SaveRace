<?php if(!isset($_SESSION)) session_start(); ?>
<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
// User
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/user/functions.php');

  if($layoutLoginBool) {
    $form  = '<div class="column is-one-third is-centered">
                <article class="message is-danger">
                  <div class="message-header">
                    <p>Fehler</p>
                  </div>
                  <div class="message-body">
                    Du bist bereits registriert!
                  </div>
                </article>
              </div>';
  }
  else {
    if(!empty($_POST['action']) && 
       $_POST['action'] == 'register') {
//print '<pre>_POST => '; print_r($_POST); print '</pre>';
      $form  = '<div class="column is-one-third is-centered">
                  <article class="message is-info">
                    <div class="message-header">
                      <p>Verarbeitung</p>
                    </div>
                    <div class="message-body">
                      Deine Registrierung wird gerade verarbeitet.
                    </div>
                  </article>
                </div>';

      if($_POST['register']['anb'] == 'on' &&
         $_POST['register']['password'] == $_POST['register']['password_repeat']) {
        $registered = newUser($_POST['register']);
        if($registered) {
          $form  = '<div class="column is-one-third is-centered">
                    <article class="message is-success">
                      <div class="message-header">
                        <p>Erfolg</p>
                      </div>
                      <div class="message-body">
                        Deine Registrierung wurde erfolgreich verarbeitet.<br/>
                        Bitte verifiziere dich über die dir soeben zugesandte E-Mail.
                      </div>
                    </article>
                  </div>';
        }
        else {
          $form  = '<div class="column is-one-third is-centered">
                    <article class="message is-danger">
                      <div class="message-header">
                        <p>Fehler</p>
                      </div>
                      <div class="message-body">
                        Deine Registrierung konnte nicht durchgeführt werden!
                      </div>
                    </article>
                  </div>';
        }
      }
      else {
        $form  = '<div class="column is-one-third is-centered">
                  <article class="message is-danger">
                    <div class="message-header">
                      <p>Fehler</p>
                    </div>
                    <div class="message-body">
                      Deine Registrierung konnte nicht durchgeführt werden!';
      if($_POST['register']['anb'] != 'on') 
            $form .= '<br />Du hast den Allgemeinen Nutzungsbedingungen und der Datenschutzerklärung nicht zugestimmt.';
      if($_POST['register']['password'] != $_POST['register']['password_repeat']) 
            $form .= '<br />Die Passwörter stimmen nicht überein.';
          $form .= '</div>
                  </article>
                </div>';
      }
    }
    else {
      $userLimit = getUserLimit();
      if($userLimit > 0) {
        // Color
        require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/color/functions.php');
        // ANB
        require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/php/anb.text.php');
        $anb = $text;
        // Datenschutz
        require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/php/privacypolicy.text.php');
        $privacypolicy = $text;

        // Registrierung
        $colorsAvailable = getColorsAvailable();
//print '<pre>colorsAvailable => '; print_r($colorsAvailable); print '</pre>';
        $form  = '<div id="register_form" class="content has-text-centered">'
                  .'<form target="_self" method="post" action="/register">'
                    .'<input type="hidden" name="action" class="field_action" value="register" />'
                    .'<div class="column is-one-third field is-centered">
                        <p class="control has-icons-left has-icons-right">
                          <input type="email" name="register[email]" id="register_email" class="field_email input is-rounded" placeholder="E-Mail-Adresse" required>
                          <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                          </span>
                          <span class="icon is-small is-right">
                            <i class="fas fa-check" style="display: none;"></i>
                            <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                          </span>
                        </p>
                      </div>
                      <div class="column is-one-third field is-centered">
                        <p class="control has-icons-left has-icons-right">
                          <input type="password" name="register[password]" id="register_password" class="field_password input is-rounded" placeholder="Passwort" required>
                          <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                          </span>
                          <span class="icon is-small is-right">
                            <i class="fas fa-check" style="display: none;"></i>
                            <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                          </span>
                        </p>
                        <ul class="help has-text-left">
                          <li>mindestens 7 Zeichen</li>
                          <li>Groß- und Kleinbuchstaben, Ziffern, Sonderzeichen</li>
                        </ul>
                      </div>
                      <div class="column is-one-third field is-centered">
                        <p class="control has-icons-left has-icons-right">
                          <input type="password" name="register[password_repeat]" id="register_password_repeat" class="field_password_repeat input is-rounded" placeholder="Passwort wiederholen" required>
                          <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                          </span>
                          <span class="icon is-small is-right">
                            <i class="fas fa-check" style="display: none;"></i>
                            <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                          </span>
                        </p>
                      </div>
                      <div class="column is-one-third field is-centered">
                        <p class="control has-icons-right">
                          <input type="text" name="register[username]" id="register_username" class="field_username input is-rounded" placeholder="Nutzername" required>
                          <span class="icon is-small is-right">
                            <i class="fas fa-check" style="display: none;"></i>
                            <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                          </span>
                        </p>
                      </div>
                      <div class="column is-one-third field is-centered">';
          $cmax = count($colorsAvailable);
              $form .= '<div class="control switch-radio is-rounded r'.$cmax.' colors">';
          $ccount = 0;
          foreach($colorsAvailable as $color) {
            $ccount++;
                  $form .= '<input type="radio" name="register[color]" id="register_color_'.$color['id'].'" value="'.$color['id'].'" class="field_color r'.$ccount.'"'
                          .(($color['inactive'])?' disabled':'').' required>'
                          .'<label for="register_color_'.$color['id'].'" class="r'.$ccount.(($ccount == $cmax)?' rlast':'').'"'.(($color['inactive'])?' disabled':'').'>
                              <img src="/img/piggy__'.$color['short'].'.png" />
                            </label>';
          }
                $form .= '<span class="handle"></span>
                        </div>
                      </div>
                      <div class="column is-one-third field is-centered">
                        <p class="control">
                          <input type="checkbox" name="register[anb]" id="register_anb" class="field_anb switch is-rounded is-outlined">
                          <label for="register_anb"></label>'
                        .'<span>'
                           .'Ich habe die <span class="button is-small is-info modal-button" data-target="popup_anb" aria-haspopup="true">Allgemeinen Nutzungsbedingungen</span> '
                           .'und die <span class="button is-small is-info modal-button" data-target="popup_privacypolicy" aria-haspopup="true">Datenschutzerklärung</span> '
                           .'gelesen, verstanden und akzeptiere sie.'
                         .'</span>
                        </p>
                      </div>
                      <div class="column is-one-third field is-centered">
                        <p class="control">
                          <button class="button">
                            Registrieren
                          </button>
                        </p>
                      </div>'
                  .'</form>'
                .'</div>';
        $form .= '<div id="popup_anb" class="modal">'
                  .'<div class="modal-background"></div>'
                  .'<div class="modal-card">'
                    .'<header class="modal-card-head">'
                      .'<p class="modal-card-title">Allgemeine Nutzungsbedingungen</p>'
                      .'<button class="delete" aria-label="close"></button>'
                    .'</header>'
                    .'<section class="modal-card-body">'
                      .'<div class="poptext">'
                        .$anb
                      .'</div>'
                    .'</section>'
                  .'</div>'
                .'</div>';
        $form .= '<div id="popup_privacypolicy" class="modal">'
                  .'<div class="modal-background"></div>'
                  .'<div class="modal-card">'
                    .'<header class="modal-card-head">'
                      .'<p class="modal-card-title">Datenschutzerklärung</p>'
                      .'<button class="delete" aria-label="close"></button>'
                    .'</header>'
                    .'<section class="modal-card-body">'
                      .'<div class="poptext">'
                        .$privacypolicy
                      .'</div>'
                    .'</section>'
                  .'</div>'
                .'</div>';
      }
      else {
        // Limit erreicht
        $form  = '<article class="message is-danger">
                    <div class="message-header">
                      <p>Limit erreicht</p>
                    </div>
                    <div class="message-body">
                      Die maximale Anzahl von möglichen Nutzern ist bereits erreicht!
                    </div>
                  </article>';
      }
    }
  }

?>
