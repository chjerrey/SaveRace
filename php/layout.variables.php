<?php if(!isset($_SESSION)) session_start(); ?>
<?php
  $layoutLoginBool = getLoginStatus();
  $today = date('Y-m-d');

  if($layoutLoginBool) {
    $user_id = $_SESSION['id'];

  // User Info
    $user = getUserInfo($_SESSION['id'], 'u.id, u.username, c.short');
  }

// Login
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/php/login.form.php');

// Footer
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/php/footer.php');

?>
