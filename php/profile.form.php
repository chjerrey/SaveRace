<?php if(!isset($_SESSION)) session_start(); ?>
<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
// User
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/user/functions.php');

  if($layoutLoginBool) {
    $user = getUserProfileInfo($_SESSION['id']);
//print '<pre>user => '; print_r($user); print '</pre>';

    // Daten
    $profile = '<div id="profile_form" class="content has-text-centered">'
                .'<form target="_self" method="post" action="/profile">'
                  .'<input type="hidden" name="action" class="field_action" value="profile" />'
                  .'<input type="hidden" name="profile[id]" class="field_user" value="'.$user['id'].'" />'
                  .'<div class="columns">
                      <div class="column is-half">
                        <div class="column is-two-thirds field is-centered">
                          <label class="label">E-Mail-Adresse</label>
                          <p class="control has-icons-left has-icons-right">
                            <input type="email" name="profile[email]" id="profile_email" class="field_email input is-rounded" value="'.((isset($_POST['profile']['email']))? $_POST['profile']['email'] : $user['mail']).'" required>
                            <span class="icon is-small is-left">
                              <i class="fas fa-envelope"></i>
                            </span>
                            <span class="icon is-small is-right">
                              <i class="fas fa-check" style="display: none;"></i>
                              <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                            </span>
                          </p>
                        </div>
                        <div class="column is-two-thirds field is-centered">
                          <label class="label">Nutzername</label>
                          <p class="control has-icons-right">
                            <input type="text" name="profile[username]" id="profile_username" class="field_username input is-rounded" value="'.((isset($_POST['profile']['username']))? $_POST['profile']['username'] : $user['username']).'" required>
                            <span class="icon is-small is-right">
                              <i class="fas fa-check" style="display: none;"></i>
                              <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                            </span>
                          </p>
                        </div>
                      </div>
                      <div class="column is-half">
                        <div class="column is-two-thirds field is-centered">
                          <label class="label">Registriert am</label>
                          <p class="control has-icons-right">
                            <input type="text" name="profile[registered]" id="profile_registered" class="field_registered input is-rounded" value="'.$user['registered'].'" disabled="disabled">
                            <span class="icon is-small is-right">
                              <i class="fas fa-check" style="display: none;"></i>
                              <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                            </span>
                          </p>
                        </div>
                        <div class="column is-two-thirds field is-centered">
                          <label class="label">Zuletzt gesehen</label>
                          <p class="control has-icons-right">
                            <input type="text" name="profile[lastseen]" id="profile_lastseen" class="field_lastseen input is-rounded" value="'.$user['lastseen'].'" disabled="disabled">
                            <span class="icon is-small is-right">
                              <i class="fas fa-check" style="display: none;"></i>
                              <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                            </span>
                          </p>
                        </div>
                        <div class="column is-two-thirds field is-centered">
                          <label class="label">Status</label>
                          <p class="control has-icons-right">
                            <input type="text" name="profile[status]" id="profile_status" class="field_status input is-rounded" value="'.$user['status'].'" disabled="disabled">
                            <span class="icon is-small is-right">
                              <i class="fas fa-check" style="display: none;"></i>
                              <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                            </span>
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="column is-one-third field is-centered">
                      <p class="control">
                        <button class="button">
                          Daten ändern
                        </button>
                      </p>
                    </div>'
                .'</form>'
              .'</div>';

    // Color
    require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/color/functions.php');
    $colorsAvailable = getColorsAvailable();
//print '<pre>colorsAvailable => '; print_r($colorsAvailable); print '</pre>';

    // Einstellungen
    $settings  = '<div id="profile_form" class="content has-text-centered">'
                  .'<form target="_self" method="post" action="/profile">'
                    .'<input type="hidden" name="action" class="field_action" value="settings" />'
                    .'<input type="hidden" name="settings[id]" class="field_user" value="'.$user['id'].'" />'
                    .'<input type="hidden" name="settings[send_reminder]" class="field_send_reminder" value="0" />'
                    .'<input type="hidden" name="settings[send_placement]" class="field_send_placement" value="0" />'
                    .'<div class="columns">
                        <div class="column is-half">
                          <div class="column is-two-thirds field is-centered">
                            <label class="label">Erinnerungsmail</label>
                            <p class="control">
                              <input type="checkbox" name="settings[send_reminder]" id="settings_send_reminder" class="field_send_reminder switch is-rounded is-outlined"'.((isset($_POST['settings']['send_reminder']))? (($_POST['settings']['send_reminder'])? ' checked="checked"' : '') : (($user['send_reminder'])? ' checked="checked"' : '')).' value="1">
                              <label for="settings_send_reminder"></label>
                            </p>
                          </div>
                          <div class="column is-two-thirds field is-centered">
                            <label class="label">Platzierungsmail</label>
                            <p class="control">
                              <input type="checkbox" name="settings[send_placement]" id="settings_send_placement" class="field_send_placement switch is-rounded is-outlined"'.((isset($_POST['settings']['send_placement']))? (($_POST['settings']['send_placement'])? ' checked="checked"' : '') : (($user['send_placement'])? ' checked="checked"' : '')).' value="1">
                              <label for="settings_send_placement"></label>
                            </p>
                          </div>
                        </div>
                        <div class="column is-half">
                          <div class="column is-two-thirds field is-centered">
                            <label class="label">Farbe</label>';
              $cmax = count($colorsAvailable);
              $settings .= '<div class="control switch-radio is-rounded r'.$cmax.' colors">';
              $ccount = 0;
              foreach($colorsAvailable as $color) {
                if($color['id'] == $user['colors_id']) $color['inactive'] = 0;

                $ccount++;
                $settings .= '<input type="radio" name="settings[color]" id="settings_color_'.$color['id'].'" value="'.$color['id'].'" class="field_color r'.$ccount.'"'
                            .((isset($_POST['settings']['color']))? (($color['id'] == $_POST['settings']['color'])? ' checked="checked"' : '') : (($color['id'] == $user['colors_id'])? ' checked="checked"' : ''))
                            .(($color['inactive'])?' disabled':'').'>'
                            .'<label for="settings_color_'.$color['id'].'" class="r'.$ccount.(($ccount == $cmax)?' rlast':'').'"'.(($color['inactive'])?' disabled':'').'>
                                <img src="/img/piggy__'.$color['short'].'.png" />
                              </label>';
              }
                $settings .= '<span class="handle"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="column is-one-third field is-centered">
                        <p class="control">
                          <button class="button">
                            Einstellungen speichern
                          </button>
                        </p>
                      </div>'
                  .'</form>'
                .'</div>';

    // Passwort
    $password  = '<div id="profile_form" class="content has-text-centered">'
                  .'<form target="_self" method="post" action="/profile">'
                    .'<input type="hidden" name="action" class="field_action" value="password" />'
                  .'<input type="hidden" name="password[id]" class="field_user" value="'.$user['id'].'" />'
                    .'<div class="columns">
                        <div class="column is-half">
                          <div class="column is-two-thirds field is-centered">
                            <label class="label">aktuelles Passwort</label>
                            <p class="control has-icons-left has-icons-right">
                              <input type="password" name="password[password_current]" id="password_password_current" class="field_password_current input is-rounded" placeholder="Passwort wiederholen" required>
                              <span class="icon is-small is-left">
                                <i class="fas fa-lock"></i>
                              </span>
                              <span class="icon is-small is-right">
                                <i class="fas fa-check" style="display: none;"></i>
                                <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                              </span>
                            </p>
                          </div>
                        </div>
                        <div class="column is-half">
                          <div class="column is-two-thirds field is-centered">
                            <label class="label">neues Passwort</label>
                            <p class="control has-icons-left has-icons-right">
                              <input type="password" name="password[password]" id="password_password" class="field_password input is-rounded" placeholder="Passwort" required>
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
                          <div class="column is-two-thirds field is-centered">
                            <label class="label">Passwort wiederholen</label>
                            <p class="control has-icons-left has-icons-right">
                              <input type="password" name="password[password_repeat]" id="password_password_repeat" class="field_password_repeat input is-rounded" placeholder="Passwort wiederholen" required>
                              <span class="icon is-small is-left">
                                <i class="fas fa-lock"></i>
                              </span>
                              <span class="icon is-small is-right">
                                <i class="fas fa-check" style="display: none;"></i>
                                <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                              </span>
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="column is-one-third field is-centered">
                        <p class="control">
                          <button class="button">
                            Passwort ändern
                          </button>
                        </p>
                      </div>'
                  .'</form>'
                .'</div>';

    if(!empty($_POST['action']) && 
       ($_POST['action'] == 'profile' || 
        $_POST['action'] == 'settings' || 
        $_POST['action'] == 'password')) {
print '<pre>_POST => '; print_r($_POST); print '</pre>';

      if($_POST['action'] == 'profile') {
        if($_POST['profile']['email'] != $user['mail'] ||
           $_POST['profile']['username'] != $user['username']) {
          $updated = setUserProfileInfo($_POST['profile']);
          if($updated) {
            $profile.= '<div class="column is-two-thirds is-centered">
                          <article class="message is-success">
                            <div class="message-body">
                              Deine Daten wurden angepasst.
                            </div>
                          </article>
                        </div>';
          }
          else {
            $profile.= '<div class="column is-two-thirds is-centered">
                          <article class="message is-danger">
                            <div class="message-body">
                              Deine Daten konnten nicht angepasst werden!
                            </div>
                          </article>
                        </div>';
          }
        }
        else {
          $profile.= '<div class="column is-two-thirds is-centered">
                        <article class="message is-warning">
                          <div class="message-body">
                            Keine Änderung erkannt.
                          </div>
                        </article>
                      </div>';
        }
      }
      elseif($_POST['action'] == 'settings') {
        if($_POST['settings']['send_reminder'] != $user['send_reminder'] ||
           $_POST['settings']['send_placement'] != $user['send_placement'] ||
           $_POST['settings']['color'] != $user['colors_id']) {
          $updated = setUserProfileSetting($_POST['settings']);
          if($updated) {
            $settings.= '<div class="column is-two-thirds is-centered">
                          <article class="message is-success">
                            <div class="message-body">
                              Deine Einstellungen wurden angepasst.
                            </div>
                          </article>
                        </div>';
          }
          else {
            $settings.= '<div class="column is-two-thirds is-centered">
                          <article class="message is-danger">
                            <div class="message-body">
                              Deine Einstellungen konnten nicht angepasst werden!
                            </div>
                          </article>
                        </div>';
          }
        }
        else {
          $settings.= '<div class="column is-two-thirds is-centered">
                        <article class="message is-warning">
                          <div class="message-body">
                            Keine Änderung erkannt.
                          </div>
                        </article>
                      </div>';
        }
      }
      elseif($_POST['action'] == 'password') {
        if($_POST['password']['password_current'] != $_POST['password']['password'] &&
           $_POST['password']['password'] == $_POST['password']['password_repeat']) {
          $updated = setUserPassword($_POST['password']);
          if($updated) {
            $password.= '<div class="column is-two-thirds is-centered">
                          <article class="message is-success">
                            <div class="message-body">
                              Dein Passwort wurde erfolgreich geändert.
                            </div>
                          </article>
                        </div>';
          }
          else {
            $password.= '<div class="column is-two-thirds is-centered">
                          <article class="message is-danger">
                            <div class="message-body">
                              Dein Passwort konnte nicht geändert werden!
                            </div>
                          </article>
                        </div>';
          }
        }
        elseif($_POST['password']['password_current'] == $_POST['password']['password']) {
          $password.= '<div class="column is-two-thirds is-centered">
                        <article class="message is-warning">
                          <div class="message-body">
                            Keine Änderung erkannt.
                          </div>
                        </article>
                      </div>';
        }
        elseif($_POST['password']['password'] != $_POST['password']['password_repeat']) {
          $password.= '<div class="column is-two-thirds is-centered">
                        <article class="message is-danger">
                          <div class="message-body">
                            Die Passwörter stimmen nicht überein!
                          </div>
                        </article>
                      </div>';
        }
        else {
          $password.= '<div class="column is-two-thirds is-centered">
                        <article class="message is-danger">
                          <div class="message-body">
                            Dein Passwort konnte nicht geändert werden!
                          </div>
                        </article>
                      </div>';
        }
      }
    }
  }
  else {
    $profile = $settings = $password = '<article class="message is-small is-danger">
                                          <div class="message-header">
                                            <p>Fehler</p>
                                          </div>
                                          <div class="message-body">
                                            Du musst eingeloggt sein!
                                          </div>
                                        </article>';
  }

?>
