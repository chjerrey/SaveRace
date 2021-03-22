<?php if(!isset($_SESSION)) session_start(); ?>
<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
// User
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/user/functions.php');
// Layout Variablen
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/php/layout.variables.php');
// Ersparnisse
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/php/savings.form.php');

  $layoutTop = '';
  $layoutBottom = '';

// Header
  $layoutTop.= '<section class="hero is-info is-medium is-bold">
                  <div class="hero-head">
                    <nav class="navbar">
                      <div class="container">
                        <div class="navbar-brand">
                          <a class="navbar-item" href="/">
                            <img src="/img/piggy.png" alt="">
                            SaveRace
                          </a>';
  if($layoutLoginBool) {
            $layoutTop.= '<span class="navbar-item navbar-burger burger" data-target="navbarMenuBurger">
                            <button class="button is-rounded">
                              <img src="/img/piggy__'.$user['short'].'.png" />
                            </button>
                          </span>
                        </div>
                        <div id="navbarMenuBurger" class="navbar-menu burger-menu">
                          <div class="navbar-end">
                            <div class="tabs is-right">
                              <ul>
                                <li><a href="/profile">Profil</a></li>
                                <li><a href="/savings">Ersparnisse</a></li>
                                <li id="logout_form">'
                                .'<form target="_self" method="post" action="/login">'
                                  .'<input type="hidden" name="action" id="field_action" value="logout" />'
                                  .'<button class="button is-rounded">
                                      Logout
                                    </button>'
                                .'</form>'
                              .'</li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div id="navbarMenu" class="navbar-menu">
                          <div class="navbar-end">
                            <div class="tabs is-right">
                              <div class="navbar-item">
                                <a class="button is-rounded" href="/profile" title="Profil">
                                  <img src="/img/piggy__'.$user['short'].'.png" />
                                </a>
                              </div>
                              <div class="navbar-item">
                                <a href="/savings" title="Ersparnisse">
                                  Ersparnisse
                                </a>
                              </div>
                              <div class="navbar-item">
                                <div id="logout_form">'
                                .'<form target="_self" method="post" action="/login">'
                                  .'<input type="hidden" name="action" id="field_action" value="logout" />'
                                  .'<button class="button is-rounded">
                                      Logout
                                    </button>'
                                .'</form>'
                              .'</div>
                              </div>
                            </div>
                          </div>
                        </div>';
  }
  else {
            $layoutTop.= '<span class="navbar-burger burger" data-target="navbarMenuBurger">
                            <span></span>
                            <span></span>
                            <span></span>
                          </span>
                        </div>
                        <div id="navbarMenuBurger" class="navbar-menu burger-menu">
                          <div class="navbar-end">
                            <div class="tabs is-right">
                              <ul>
                                <li><a href="/login">Login</a></li>
                                <li><a href="/forgot">Login vergessen</a></li>
                                <li><a href="/register">Registrieren</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div id="navbarMenu" class="navbar-menu">
                          <div class="navbar-end">
                            <div class="tabs is-right">
                              <div class="navbar-item">
                                '.showLogin('menu').'
                              </div>
                            </div>
                          </div>
                        </div>';
  }
        $layoutTop.= '</div>
                    </nav>
                  </div>
                </section>';

  if($layoutLoginBool) {
    $layoutTop.= '<div id="user" data-user="'.$user_id.'">'
                   .'<div class="box cta">
                      '.showSavingsForm().'
                    </div>'
                 .'</div>';
  }

// Content
  $layoutTop .= '<div id="content" class="container">';
  $layoutBottom .= '</div>';

// Footer
  $layoutBottom .= '<div id="footer" class="justify">'
                    .$footer
                  .'</div>';

// Cookie Dosclaimer
  $layoutCookies = '<div id="popup_cookie" class="modal'
                    .((isset($_COOKIE["saverace_cookies"]) || 
                       $page == 'anb' || 
                       $page == 'privacypolicy' || 
                       $page == 'imprint')? 
                      '' : 
                      ' is-active')
                  .'">'
                    .'<div class="modal-background"></div>'
                    .'<div class="modal-card">'
                      .'<header class="modal-card-head">'
                        .'<p class="modal-card-title">Cookies</p>'
                        .'<button class="delete" aria-label="close"></button>'
                      .'</header>'
                      .'<section class="modal-card-body">'
                        .'<div class="poptext">'
                          .'Für den vollen Spielspaß musst du <b>Cookies akzeptieren</b>.<br />'
                          .'Mehr erfährst du in den <a href="/anb">ANB</a> und der <a href="/privacypolicy">Datenschutzerklärung</a>.'
                        .'</div>'
                      .'</section>'
                      .'<footer class="modal-card-foot">'
                        .'<button class="button cookie_button" name="cookie_accept" id="cookie_accept" cookie="all">akzeptieren</button>'
                      .'</footer>'
                    .'</div>'
                  .'</div>';

?>
