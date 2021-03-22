<?php
  ini_set('session.cookie_samesite', 'None'); 
  ini_set('session.cookie_secure', true);
?>
<?php if(!isset($_SESSION)) session_start(); ?>
<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/php/layout.php');

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  $page = 'saverace';
  if(isset($_GET['page'])) {
    if($_GET['page'] == 'error' || 
       $_GET['page'] == 'anb' || 
       $_GET['page'] == 'privacypolicy' || 
       $_GET['page'] == 'imprint' || 
       $_GET['page'] == 'register' || 
       $_GET['page'] == 'verify' || 
       $_GET['page'] == 'forgot' || 
       $_GET['page'] == 'login' || 
       $_GET['page'] == 'profile' || 
       $_GET['page'] == 'savings' || 
       $_GET['page'] == 'saverace') {
      $page = $_GET['page'];
    }
  }
?>
<!doctype html>
<html class="" lang="de">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SaveRace by ..::ch::..</title>
    <link rel="shortcut icon" href="/img/piggy.ico" type="image/x-icon" />

    <meta name="robots" content="no-index, no-follow" />
    <meta name="keywords" content="save, money, browsergame, Geld, sparen, Spiel" />
    <meta name="description" content="Wer kann mehr Geld im Monat ansparen?" />
    <meta name="geo.region" content="DE-BE" />
    <meta name="geo.placename" content="Berlin" />

    <!-- Fonts -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <script type="text/javascript" src="/js/fontawesome.js"></script>
    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">-->
    <link rel="stylesheet" href="/css/font.css">

    <!-- Bulma -->
    <link rel="stylesheet" href="/bulma/css/bulma.min.css">
    <link rel="stylesheet" href="/bulma-helpers/css/bulma-helpers.min.css">
    <link rel="stylesheet" href="/bulma-modal-fx/css/modal-fx.min.css" />
    <link rel="stylesheet" href="/bulma-extensions/dist/css/bulma-extensions.min.css" />
    <link rel="stylesheet" href="/bulma-extensions/bulma-switch/dist/css/bulma-switch.min.css" />
    <link rel="stylesheet" href="/bulma-extensions/bulma-switch/dist/css/bulma-switch-radio.css" />
    <link rel="stylesheet" href="/bulma-extensions/bulma-calendar/dist/css/bulma-calendar.css" />

<!--    <link rel="stylesheet" href="/css/jquery-ui-1.10.3.css" type="text/css" />-->
    <link rel="stylesheet" href="/css/style.css" type="text/css" />

    <script type="text/javascript" src="/js/jquery-latest.js"></script>
    <script type="text/javascript" src="/js/jquery-1.10.2.js"></script>
    <script type="text/javascript">
      var $ = jQuery.noConflict();
    </script>
    <script type="text/javascript" src="/js/jquery-ui-1.10.3.min.js"></script>
    <script type="text/javascript" src="/js/jquery.tipsy.js"></script>
    
    <script type="text/javascript" src="/bulma/js/bulma.js"></script>
    <script type="text/javascript" src="/bulma-modal-fx/js/modal-fx.min.js"></script>
    <script type="text/javascript" src="/bulma-extensions/dist/js/bulma-extensions.min.js"></script>
    <script type="text/javascript" src="/bulma-extensions/bulma-calendar/dist/js/bulma-calendar.min.js"></script>
		<script type="text/javascript" src="/js/chartjs/dist/Chart.js"></script>
		<script type="text/javascript" src="/js/chartjs/plugin/chartjs-plugin-labels.js"></script>
    <script type="text/javascript" src="/mod/user/js/functions.js"></script>
    <script type="text/javascript" src="/mod/saving/js/functions.js"></script>
  </head>

  <body>
    <?php
      //print '<pre>_SESSION => '; print_r($_SESSION); print '</pre>';
    ?>
    <?php
      print $layoutTop;
      include('php/'.$page.'.php');
      print $layoutBottom;
    ?>
    <?php
      print $layoutCookies;
    ?>

    <script type="text/javascript" src="/js/functions.js"></script>
  </body>
</html>
