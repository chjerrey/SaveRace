<?php if(!isset($_SESSION)) session_start(); ?>
<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
// Ersparnisse
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/saving/functions.php');

  print '<h1 class="title is-3">Ersparnisse</h1>';
  print  '<div class="tile is-ancestor">
              <div class="tile is-parent is-shady">
                <article class="tile is-child notification is-white">
                  <div class="content">';

  if($layoutLoginBool) {
    print  '<table id="saving_history_table" class="table is-fullwidth tablesorter">
              <thead>
                <tr>
                  <th class="has-icon"></th>
                  <th>Datum</th>
                  <th>Umsatz</th>
                  <th>Kommentar</th>
                  <th class="has-icon"></th>
                </tr>
              </thead>
              <tbody class="saving_history_content">
                '.getSavingHistory($_SESSION['id']).'
              </tbody>
            </table>';
  }
  else {
    print  '<article class="message is-small is-danger">
              <div class="message-header">
                <p>Fehler</p>
              </div>
              <div class="message-body">
                Du musst eingeloggt sein!
              </div>
            </article>';
  }
  
          print  '</div>
                </article>
              </div>
            </div>';

?>
