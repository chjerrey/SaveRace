<?php if(!isset($_SESSION)) session_start(); ?>
<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
// Login
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/php/privacypolicy.text.php');

  print  '<h1 class="title is-3">Datenschutzerkl√§rung</h1>';
  print  '<div class="tile is-ancestor">
              <div class="tile is-parent is-shady">
                <article class="tile is-child notification is-white">
                  <div class="content">
                    '.$text.'
                  </div>
                </article>
              </div>
            </div>';

?>
