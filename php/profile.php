<?php if(!isset($_SESSION)) session_start(); ?>
<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
// Profil
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/php/profile.form.php');

  print  '<h1 class="title is-3">Profil</h1>';

  if($layoutLoginBool) {
    $breadcrumbs = '<nav class="breadcrumb is-small has-bullet-separator" aria-label="breadcrumbs">
                      <ul>
                        <li><a href="#data">Daten</a></li>
                        <li><a href="#settings">Einstellungen</a></li>
                        <li><a href="#password">Passwort ändern</a></li>
                      </ul>
                    </nav>';
    print  $breadcrumbs;
    print  '<div class="tile is-ancestor">
              <div class="tile is-parent is-shady">
                <article class="tile is-child notification is-white">
                  <div class="content">
                    <p class="title is-4" id="data">Daten</p>
                  '.$profile.'
                  </div>
                </article>
              </div>
            </div>';
    print  $breadcrumbs;
    print  '<div class="tile is-ancestor">
              <div class="tile is-parent is-shady">
                <article class="tile is-child notification is-white">
                  <div class="content">
                    <p class="title is-4" id="settings">Einstellungen</p>
                  '.$settings.'
                  </div>
                </article>
              </div>
            </div>';
    print  $breadcrumbs;
    print  '<div class="tile is-ancestor">
              <div class="tile is-parent is-shady">
                <article class="tile is-child notification is-white">
                  <div class="content">
                    <p class="title is-4" id="password">Passwort ändern</p>
                  '.$password.'
                  </div>
                </article>
              </div>
            </div>';
  }
  else {
    print  '<div class="tile is-ancestor">
              <div class="tile is-parent is-shady">
                <article class="tile is-child notification is-white">
                  <div class="content">
                    <article class="message is-small is-danger">
                      <div class="message-header">
                        <p>Fehler</p>
                      </div>
                      <div class="message-body">
                        Du musst eingeloggt sein!
                      </div>
                    </article>
                  </div>
                </article>
              </div>
            </div>';
  }

?>
