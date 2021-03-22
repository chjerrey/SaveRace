<?php if(!headers_sent() && !isset($_SESSION)) session_start(); ?>
<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
/**
 * Modul User
 *
 * @package   mod\user
 * @link      https://ch-hexen.de
 * @author    Momo Pfirsich <momo@ch-hexen.de>
 * @copyright Copyright (c) 2019 Momo Pfirsich <momo@ch-hexen.de>
 */
/** DB Connection */
  require_once(CH_ROOT."/var/www/vhosts/hosting113386.af996.netcup.net/saverace/ajax/db.php");
/** Mail {@see \mod\mail} */
  require_once(CH_ROOT."/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/mail/functions.php");
/** Ersparnisse {@see \mod\saving} */
  require_once(CH_ROOT."/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/saving/functions.php");
/**
 * standard Variablen
 *
 * @global  mysqli_connect  $link
 * @global  date            $today
 * @global  date            $todaytime
 * @global  date            $todaymd
 * @var     int             $maxLogin
 */
  global $link;
  $today = date("Y-m-d");
  global $today;
  $todaytime = date("Y-m-d H:i:s");
  global $todaytime;
  $todaymd = date("m-d");
  global $todaymd;
  $todayy = date("Y");
  global $todayy;
  $maxLogin = 1800; // 30 Minuten
  global $event;

  if(isset($_POST['fctn']) && isset($_POST['mod']) && $_POST['mod'] == 'user') {
    $return = '{"error": "Es ist ein Fehler aufgetreten!<br />Bitte versuche es zu einem späteren Zeitpunkt erneut."}';
    if($_POST['fctn'] == 'check_username') {
      $return = getCheckUsername($_POST['username'], $_POST['user'], $_POST['action']);
    }
    elseif($_POST['fctn'] == 'check_mail') {
      $return = getCheckMail($_POST['mailaddy'], $_POST['user'], $_POST['action']);
    }
    echo $return;
  }

/**
 * NEW User
 *
 * Registrierung neuer User in Tabelle "users_new"
 *
 * @param   array   $newUser    Array aus $tabelle => $feld => $wert
 * @return  bool                ob neue User erfolgreich angelegt
 */
  function newUser($newUser) {
    global $link;
    global $todaytime;
    $return = false;

    $hash = md5(rand(0,1000));

    $query_user  = 'insert into users_new set '
                  .'hash="'.mysqli_real_escape_string($link, $hash).'", '
                  .'date_hash="'.mysqli_real_escape_string($link, $todaytime).'", '
                  .'`users-username`="'.mysqli_real_escape_string($link, $newUser['username']).'", '
                  .'`users-password`="'.mysqli_real_escape_string($link, getHashPassword($newUser['password'])).'", '
                  .'`users-mail`="'.mysqli_real_escape_string($link, $newUser['email']).'", '
                  .'`users_settings-colors_id`="'.mysqli_real_escape_string($link, $newUser['color']).'"'
                  .';';
    $nameBool = getCheckUsernameBool($newUser['username']);
    $mailBool = getCheckMailBool($newUser['email']);
    if(!$nameBool && $mailBool == 0) {
//print '<pre>'; print_r($query_user); print '</pre>';$insert_user = true;
      $insert_user = mysqli_query($link, $query_user);
      $mail = false;

      if($insert_user) {
        $mail = newMailVerify($newUser['username'], $newUser['email'], $hash);
      }

      if($insert_user && $mail) {
        $chjerrey = newMailRegistered($newUser['username'], $newUser['email'], $hash, $todaytime);
        $return = true;
      }
      elseif($insert_user && !$mail) {
        $query_user = 'delete from users_new '
                     .'where hash="'.mysqli_real_escape_string($link, $hash).'" '
                     .'and `users-username`="'.mysqli_real_escape_string($link, $newUser['username']).'";';
//print '<pre>'; print_r($query_user); print '</pre>';
        $delete_user = mysqli_query($link, $query_user);
      }
    }

    return $return;
  }

/**
 * NEW User Verifikation
 *
 * Neue User verifizieren und aus Tabelle "users_new" in "users" verschieben
 *
 * @param   string  $mail       E-Mail-Adresse
 * @param   string  $hash       Verifizierungshash
 * @return  array               String ob neue User erfolgreich verifiziert und ob Seite neu geladen werden soll
 */
  function newUserVerify($mail = null, $hash = null, $admin = null) {
    global $link;
    global $today;
    $code = 'error';
    $return = 'Deine Verifizierung konnte nicht durchgeführt werden!';
    $refresh = false;
    $newID = 0;

    if(!empty($mail) && !empty($hash)) {
      $query_hash = 'select `users-username`, `users-password`, `users-mail`, '
                   .'`users_settings-colors_id` '
                   .'from users_new '
                   .'where `users-mail`="'.mysqli_real_escape_string($link, $mail).'" '
                   .(($hash == 'admin' && !empty($admin) && boolval($admin['user_new'])) ? 
                      '' : 
                      'and hash="'.mysqli_real_escape_string($link, $hash).'"')
                   .';';
//print '<pre>'; print_r($query_hash); print '</pre>';
      $select_hash = mysqli_query($link, $query_hash);

      if($select_hash && mysqli_num_rows($select_hash) > 0) {
        $newUser = mysqli_fetch_assoc($select_hash);

        $query_mail = 'select id '
                     .'from users '
                     .'where mail="'.mysqli_real_escape_string($link, $mail).'" '
                     .'and username="'.mysqli_real_escape_string($link, $newUser['users-username']).'";';
//print '<pre>'; print_r($query_mail); print '</pre>';
        $select_mail = mysqli_query($link, $query_mail);
        $select_mail = false;

        if(!$select_mail || mysqli_num_rows($select_mail) == 0) {
          foreach($newUser as $tableField=>$newValue) {
            list($newTable, $newField) = explode('-', $tableField);
            $user[$newTable][$newField] = $newValue;
          }
//print '<pre>'; print_r($user); print '</pre>';
          foreach($user as $table=>$fields) {
            $count = 0;
            $query_user = 'insert into '.mysqli_real_escape_string($link, $table).' set ';
            foreach($fields as $field=>$value) {
              if($count > 0) $query_user .= ', ';
              if(empty($value)) $value = 'NULL';
              else $value = '"'.mysqli_real_escape_string($link, $value).'"';
              $query_user .= mysqli_real_escape_string($link, $field).'='.$value;
              $count++;
            }
            if($table == 'users') {
              $query_user .= ', registered="'.mysqli_real_escape_string($link, $today).'"'
                            .', lastseen="'.mysqli_real_escape_string($link, $today).'";';
//print '<pre>'; print_r($query_user); print '</pre>';
              $insert['query-'.$table] = mysqli_query($link, $query_user);
              $newID = mysqli_insert_id($link);
            }
            else {
              $query_user .= ', users_id="'.mysqli_real_escape_string($link, $newID).'";';
//print '<pre>'; print_r($query_user); print '</pre>';
              $insert['query-'.$table] = mysqli_query($link, $query_user);
            }
            unset($query_user);
          }

          $max = count($insert);
          $true = 0;
          $error = '';
          foreach($insert as $action=>$bool) {
            if($bool) $true++;
            else $error .= $action.'<br />';
          }
          if($max == $true) {
            $query_new = 'delete '
                        .'from users_new '
                        .'where `users-mail`="'.mysqli_real_escape_string($link, $mail).'" '
                        .'and hash="'.mysqli_real_escape_string($link, $hash).'";';
//print '<pre>'; print_r($query_hash); print '</pre>';
            $delete_new = mysqli_query($link, $query_new);

            $code = 'success';
            $return = 'Dein Account wurde erfolgreich aktiviert.<br />'
                     .'Viel Spa&szlig; bei SaveRace by ..::ch::..';
            if($hash == 'admin' && !empty($admin) && boolval($admin['user_new'])) {
              $return = 'Die E-Mail-Adresse wurde erfolgreich verifiziert.';
            }

            $refresh = true;
            if($hash != 'admin' && empty($admin)) {
              $login = setUserLogin($mail, 'verify', true);
            }
          }
          else {
            $return = 'Bei der Verifizierung ist ein Fehler aufgetreten.';
            if($hash == 'admin' && !empty($admin) && boolval($admin['user_new'])) {
              $return = 'Verifizierung bei Input fehlgeschlagen!';
            }
//print '<pre>'; print_r($error); print '</pre>';
          }
        }
        else {
          $return = 'Du hast eine fehlerhafte URL eingegeben oder deine E-Mail-Adresse wurde bereits verifiziert.';
          if($hash == 'admin' && !empty($admin) && boolval($admin['user_new'])) {
            $return = 'Verifizierung bereits vorhanden!';
          }
        }
      }
      else {
        $return = 'Du hast eine fehlerhafte URL eingegeben oder deine E-Mail-Adresse wurde bereits verifiziert.';
        if($hash == 'admin' && !empty($admin) && boolval($admin['user_new'])) {
          $return = 'Verifizierung nicht gefunden!';
        }
      }
    }

    return array($code, $return, $refresh, $newID);
  }

/**
 * SET User Login
 *
 * User einloggen und Session setzen
 *
 * @param   string  $mail       E-Mail-Adresse
 * @param   string  $pw         klartext Passwort oder "verify" bei Auto-Login nach Verifizierung
 * @param   bool    $auto       "true" bei Auto-Login nach Verifizierung
 * @return  string              JSON ob Login erfolgreich
 */
  function setUserLogin($mail = null, $pw = null, $auto = false) {
    global $link;
    global $today;
    global $_SESSION;
    $return = false;

    if(!empty($mail) && !empty($pw)) {
      $query_user = 'select id, username, lastseen, status '
                   .'from users '
                   .'where mail="'.mysqli_real_escape_string($link, $mail).'" ';
      if(!($pw == 'verify' && $auto == true)) {
        $password = getHashPassword($pw);
        $query_user .= 'and password="'.mysqli_real_escape_string($link, $password).'" ';
      }
      $query_user .= 'and status <> "deleted";';
//print '<pre>'; print_r($query_user); print '</pre>';
      $select_user = mysqli_query($link, $query_user);

      if($select_user && mysqli_num_rows($select_user) > 0) {
        $row = mysqli_fetch_assoc($select_user);

        if($row['status'] != 'locked') {
          $lastseen = setUserLastseen($row['id']);

          $query_login = 'insert into users_online set '
                        .'users_id="'.mysqli_real_escape_string($link, $row['id']).'", '
                        .'username="'.mysqli_real_escape_string($link, $row['username']).'", '
                        .'time="'.mysqli_real_escape_string($link, time()).'" '
                        .'on duplicate key update time="'.mysqli_real_escape_string($link, time()).'";';
//print '<pre>'; print_r($query_login); print '</pre>';
          $insert_login = mysqli_query($link, $query_login);

          if($lastseen && $insert_login) {
            $_SESSION["login"] = true;
            $_SESSION["username"] = $row['username'];
            $_SESSION["id"] = $row['id'];
            $_SESSION["lastseen"] = $row["lastseen"];
            $_SESSION["status"] = $row["status"];

            $return = true;
          }
        }
      }
    }

    return $return;
  }

/**
 * SET User letzter Besuch
 *
 * Datum des letzten Besuchs der User auf "Heute" setzen
 *
 * @param   int     $user       ID der User
 * @return  bool                ob Setzen erfolgreich
 */
  function setUserLastseen($user = 0) {
    global $link;
    global $today;
    $return = false;

    if($user > 0) {
      $query_user = 'update users set '
                   .'lastseen="'.mysqli_real_escape_string($link, $today).'", '
                   .'status="'.mysqli_real_escape_string($link, "active").'" '
                   .'where id="'.mysqli_real_escape_string($link, $user).'";';
//print '<pre>'; print_r($query_user); print '</pre>';
      $return = mysqli_query($link, $query_user);
    }

    return $return;
  }

/**
 * SET User Logout
 *
 * User mit aktueller Session ausloggen und Session löschen
 *
 * @return  string              JSON ob Logout erfolgreich
 */
  function setUserLogout() {
    global $link;
    global $_SESSION;
    $return = false;

    $query_login = 'delete '
                  .'from users_online '
                  .'where users_id="'.mysqli_real_escape_string($link, $_SESSION["id"]).'" '
                  .'and username="'.mysqli_real_escape_string($link, $_SESSION["username"]).'";';
    $delete_login = mysqli_query($link, $query_login);

    if($delete_login) {
      $_SESSION["login"] = false;
      $_SESSION["username"] = null;
      $_SESSION["id"] = null;
      $_SESSION["lastseen"] = null;
      $_SESSION["status"] = null;

      if(ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"],
                  $params["domain"], $params["secure"], $params["httponly"]);
      }
      session_unset();
      session_destroy();
      $return = true;
    }

    return $return;
  }

/**
 * SET aktive User Refresh
 *
 * Onlinezeit der User mit aktueller Session auf "Jetzt" setzen
 *
 * @return  bool                ob Refresh erfolgreich
 */
  function setUserRefresh() {
    global $link;
    global $_SESSION;
    $return = false;

    if(isset($_SESSION["username"]) && isset($_SESSION["id"])) {
      $query_user = 'update users_online set '
                   .'time='.mysqli_real_escape_string($link, time()).' '
                   .'where users_id="'.mysqli_real_escape_string($link, $_SESSION["id"]).'" '
                   .'and username="'.mysqli_real_escape_string($link, $_SESSION["username"]).'";';
//print '<pre>'; print_r($query_user); print '</pre>';
      $update_user = mysqli_query($link, $query_user);
      if($update_user && mysqli_affected_rows($link) > 0) {
        $return = true; 
      }
    }

    return $return;
  }

/**
 * DELETE alle online Usern die länger nichts getan haben
 *
 * Alle Usern ausloggen, die länger als {@see \mod\user::$maxLogin} inaktiv sind
 * Dabei auch User mit aktueller Session ausloggen und Session löschen
 *
 * @return  bool                ob Logout erfolgreich
 */
  function setUserLogoutAll() {
    global $link;
    global $_SESSION;
    global $maxLogin;
    $return = false;

    if(isset($_SESSION["username"]) && isset($_SESSION["id"])) {
      $query_user = 'select users_id '
                   .'from users_online '
                   .'where (time+'.$maxLogin.')<'.mysqli_real_escape_string($link, time()).' '
                   .'and users_id="'.mysqli_real_escape_string($link, $_SESSION["id"]).'" '
                   .'and username="'.mysqli_real_escape_string($link, $_SESSION["username"]).'";';
//print '<pre>'; print_r($query_user); print '</pre>';
      $select_user = mysqli_query($link, $query_user);
      if($select_user && mysqli_num_rows($select_user) > 0) {
        $logout = setUserLogout();
      }
    }

    $query_all = 'delete '
                .'from users_online '
                .'where (time+'.$maxLogin.')<'.mysqli_real_escape_string($link, time()).';';
    $return = mysqli_query($link, $query_all);

    return $return;
  }

/**
 * SET User Infos für Profil
 *
 * Infos zur User einpflegen
 *
 * @param   array   $newUser    Array aus $tabelle => $feld => $wert
 * @return  bool                ob Setzen erfolgreich
 */
  function setUserProfileInfo($userProfile) {
    global $link;
    $return = false;

    if($userProfile['id'] > 0) {
      $userInfo = true;
      $query_infos = 'select id '
                    .'from users '
                    .'where id<>"'.mysqli_real_escape_string($link, $userProfile['id']).'" '
                    .'and (username="'.mysqli_real_escape_string($link, $userProfile['username']).'" '
                    .'or mail="'.mysqli_real_escape_string($link, $userProfile['email']).'")'
                    .';';
//print '<pre>'; print_r($query_infos); print '</pre>';
      $select_infos = mysqli_query($link, $query_infos);
      if($select_infos && mysqli_num_rows($select_infos) > 0) {
        $userInfo = false;
      }
      if($userInfo) {
        $query_user  = 'update users set '
                      .'username="'.mysqli_real_escape_string($link, $userProfile['username']).'", '
                      .'mail="'.mysqli_real_escape_string($link, $userProfile['email']).'" '
                      .'where id="'.mysqli_real_escape_string($link, $userProfile['id']).'"'
                      .';';
//print '<pre>'; print_r($query_user); print '</pre>';
        $update_user = mysqli_query($link, $query_user);

        if($update_user && mysqli_affected_rows($link) > 0) {
          $return = true;
        }
      }
    }

    return $return;
  }

/**
 * SET User Passwort
 *
 * Passwort für User setzen
 *
 * @param   int     $user       ID der User
 * @param   string  $old        altes klartext Passwort
 * @param   string  $pass       neues klartext Passwort
 * @return  string              JSON ob Setzen erfolgreich
 */
  function setUserPassword($userPassword) {
    global $link;
    $return = false;

    if(!empty($userPassword) && 
       $userPassword['password_current'] != $userPassword['password'] &&
       $userPassword['password'] == $userPassword['password_repeat']) {
      $vold = getHashPassword($userPassword['password_current']);
      $query_pass = 'select id '
                   .'from users '
                   .'where password="'.mysqli_real_escape_string($link, $vold).'" '
                   .'and id="'.mysqli_real_escape_string($link, $userPassword['id']).'";';
//print '<pre>'; print_r($query_pass); print '</pre>';
      $select_pass = mysqli_query($link, $query_pass);

      if($select_pass && mysqli_num_rows($select_pass) > 0) {
        $value = getHashPassword($userPassword['password']);
        $query_user = 'update users set '
                     .'password="'.mysqli_real_escape_string($link, $value).'" '
                     .'where id="'.mysqli_real_escape_string($link, $user).'";';
//print '<pre>'; print_r($query_user); print '</pre>';
        $update_user = mysqli_query($link, $query_user);

        if($update_user && mysqli_affected_rows($link) > 0) {
          $return = true;
        }
      }
    }

    return $return;
  }

/**
 * NEW User Passwort
 *
 * neues Passwort für User setzen
 *
 * @param   int     $user       ID der User
 * @return  bool                ob Setzen erfolgreich
 */
  function newUserPassword($email = null) {
    global $link;
    $return = false;

    if(!empty($email)) {
      $query_mail = 'select id, username, mail '
                   .'from users '
                   .'where mail="'.mysqli_real_escape_string($link, $email).'"'
                   .';';
//print '<pre>'; print_r($query_mail); print '</pre>';
      $select_mail = mysqli_query($link, $query_mail);

      if($select_mail && mysqli_num_rows($select_mail) > 0) {
        $user = mysqli_fetch_assoc($select_mail);
        $pass = getRandomPassword();
        $value = getHashPassword($pass);
        $query_user = 'update users set '
                     .'password="'.mysqli_real_escape_string($link, $value).'" '
                     .'where id="'.mysqli_real_escape_string($link, $user['id']).'";';
//print '<pre>'; print_r($query_user); print '</pre>'; $update_user = true;
        $update_user = mysqli_query($link, $query_user);

        if($update_user && mysqli_affected_rows($link) > 0) {
          $mail = newMailPassword($user['username'], $user['mail'], $pass);

          if($mail) {
            $return = true;
          }
        }
      }
    }

    return $return;
  }

/**
 * SET User Einstellungen
 *
 * Einstellungen für User setzen
 *
 * @param   int     $user       ID der User
 * @param   string  $settings   JSON mit $feld => $wert
 * @return  string              JSON ob Setzen erfolgreich
 */
  function setUserProfileSetting($userProfile) {
    global $link;
    $return = false;

    if($userProfile['id'] > 0) {
      $query_user  = 'update users_settings set '
                    .'send_reminder="'.mysqli_real_escape_string($link, $userProfile['send_reminder']).'", '
                    .'send_placement="'.mysqli_real_escape_string($link, $userProfile['send_placement']).'", '
                    .'colors_id="'.mysqli_real_escape_string($link, $userProfile['color']).'" '
                    .'where users_id="'.mysqli_real_escape_string($link, $userProfile['id']).'"'
                    .';';
//print '<pre>'; print_r($query_user); print '</pre>';
      $update_user = mysqli_query($link, $query_user);

      if($update_user && mysqli_affected_rows($link) > 0) {
        $return = true;
      }
    }

    return $return;
  }

/**
 * DELETE User
 *
 * User deaktivieren
 *
 * @param   int     $user       ID der User
 * @param   string  $mail       E-Mail-Adresse
 * @param   string  $bday       Geburtstag
 * @param   string  $pass       klartext Passwort
 * @return  string              JSON ob Deaktivierung erfolgreich
 */
/*  function setUserDelete($user = 0, $mail = '', $bday = '', $pass = '') {
    global $link;
    global $today;
    $return = '{"error": "Es ist ein Fehler aufgetreten!"}';

    if($user > 0 && !empty($mail) && !empty($bday) && !empty($pass)) {
      $value = getHashPassword($pass);
      $query_pass = 'select id '
                   .'from users '
                   .'where password="'.mysqli_real_escape_string($link, $value).'" '
                   .'and birthday="'.mysqli_real_escape_string($link, $bday).'" '
                   .'and mail="'.mysqli_real_escape_string($link, $mail).'" '
                   .'and id="'.mysqli_real_escape_string($link, $user).'";';
//print '<pre>'; print_r($query_pass); print '</pre>';
      $select_pass = mysqli_query($link, $query_pass);
      if($select_pass && mysqli_num_rows($select_pass) > 0) {
        $query_user = 'update users set '
                     .'lastseen="'.mysqli_real_escape_string($link, $today).'", '
                     .'status="deleted" '
                     .'where id="'.mysqli_real_escape_string($link, $user).'";';
//print '<pre>'; print_r($query_user); print '</pre>';
        $update_user = mysqli_query($link, $query_user);
        $update = mysqli_affected_rows($link);
        if($update) {
          $logout = setUserLogout();
          $return = '{"success": "Profil erfolgreich gelöscht."}';
        }
      }
      else {
        $return = '{"error": "Angaben fehlerhaft!"}';
      }
    }

    return $return;
  }

/**
 * GET Login Status
 *
 * Prüfung ob Session aktive User hat
 *
 * @return  bool                ob Login vorhanden
 */
  function getLoginStatus() {
    $login = false;

    if(isset($_SESSION["login"]) && 
       $_SESSION["login"] && 
       isset($_SESSION["username"]) && 
       isset($_SESSION["id"])) {
      $login = true;
    }

    return $login;
  }

/***** Check * Start **************************************************/
/**
 * GET Boolean Usernname vorhanden
 *
 * Prüfung ob Usernname bereits vergeben ist<br />
 * Rückgabe Boolean<br />
 * 0 - kein Fund<br />
 * 1 - allgemeiner Fehler<br />
 * 2 - Name passend zu ID der User<br />
 * 3 - Name vergeben
 *
 * @param   string  $username   Usernname
 * @param   int     $user       ID des Users
 * @return  bool                ob Usernname vergeben
 */
  function getCheckUsernameBool($username = null, $user = 0) {
    global $link;
    $return = 1;

    if(!empty($username)) {
      $query_user = 'select id from users '
                   .'where username="'.mysqli_real_escape_string($link, $username).'" '
                   .'UNION '
                   .'select id from users_new '
                   .'where `users-username`="'.mysqli_real_escape_string($link, $username).'" '
                   .';';
//print '<pre>'; print_r($query_user); print '</pre>';
      $select_user = mysqli_query($link, $query_user);
      if($select_user) {
        $row = mysqli_fetch_assoc($select_user);
        if(empty($row)) {
          $return = 0;
        }
        else {
          $return = 3;
          if($user > 0 && intval($row['id']) === intval($user)) {
            $return = 2;
          }
        }
      }
      else {
        $return = 0;
      }

      /*if($select_user && mysqli_num_rows($select_user) > 0) {
        $return = true;
      }
      else {
        $return = false;
      }*/
    }

    return $return;
  }

/**
 * GET Usernname vorhanden
 *
 * Prüfung ob Usernname bereits vergeben ist
 *
 * @param   string  $username   Usernname
 * @return  string              JSON ob Usernname verfügbar
 */
  function getCheckUsername($username = null, $user = 0, $action = 'register') {
    global $link;
    $return = '{"error": "Fehler bei Prüfung der Usernnamens!"}';

    if(!empty($username)) {
      $nameBool = getCheckUsernameBool($username, $user);

      if($nameBool == 0) {
        if($action == 'delete') {
          $return = '{"error": "Unter diesem Usernnamen bist du nicht registriert."}';
        }
        else {
          $return = '{"success": "Dieser Usernname ist noch nicht registriert."}';
        }
      }
      elseif($nameBool == 2) {
        if($action == 'register') {
          $return = '{"error": "Dieser Usernnameist bereits registriert!"}';
        }
        elseif($action == 'profile') {
          $return = '{"success": "Unter diesem Usernnamen bist du registriert.", '
                    .'"class": ""}';
        }
        else {
          $return = '{"success": "Unter diesem Usernnamen bist du registriert."}';
        }
      }
      elseif($nameBool == 3) {
        if($action == 'delete') {
          $return = '{"error": "Unter diesem Usernnamen bist du nicht registriert."}';
        }
        else {
          $return = '{"error": "Dieser Usernname ist bereits registriert!"}';
        }
      }

      /*if($nameBool) {
        $return = '{"error": "Dieser Usernname ist nicht mehr verf&uuml;gbar!"}';
      }
      else{
        $return = '{"success": "Dieser Usernname ist noch verf&uuml;gbar."}';
      }*/
    }

    return $return;
  }

/**
 * GET Boolean Mail vorhanden
 *
 * Prüfung ob E-Mail-Adresse bereits registriert ist<br />
 * Rückgabe Boolean<br />
 * 0 - kein Fund<br />
 * 1 - allgemeiner Fehler<br />
 * 2 - Mail passend zu ID der User<br />
 * 3 - Mail vergeben
 *
 * @param   string  $mail       E-Mail-Adresse
 * @param   int     $user       ID des Users
 * @return  int                 ob E-Mail-Adresse vergeben
 */
  function getCheckMailBool($mail = null, $user = 0) {
    global $link;
    $return = 1;

    if(!empty($mail)) {
      $query_user = 'SELECT id FROM users '
                   .'where mail="'.mysqli_real_escape_string($link, $mail).'" '
                   .'UNION ALL '
                   .'SELECT id FROM users_new '
                   .'where `users-mail`="'.mysqli_real_escape_string($link, $mail).'" '
                   .';';
//print '<pre>'; print_r($query_user); print '</pre>';
      $select_user = mysqli_query($link, $query_user);
      if($select_user) {
        $row = mysqli_fetch_assoc($select_user);
        if(empty($row)) {
          $return = 0;
        }
        else {
          $return = 3;
          if($user > 0 && intval($row['id']) === intval($user)) {
            $return = 2;
          }
        }
      }
      else {
        $return = 0;
      }
    }

    return $return;
  }

/**
 * GET Mail vorhanden
 *
 * Prüfung ob E-Mail-Adresse bereits registriert ist
 *
 * @param   string  $mail       E-Mail-Adresse
 * @param   int     $user       ID der User
 * @param   string  $action     Aktion, die diese Funktion aufruft
 * @return  string              JSON ob E-Mail-Adresse verfügbar
 */
  function getCheckMail($mail = null, $user = 0, $action = 'register') {
    global $link;
    $return = '{"error": "Fehler bei Prüfung der E-Mail-Adresse!"}';

    if(!empty($mail)) {
      $mailBool = getCheckMailBool($mail, $user);

      if($mailBool == 0) {
        if($action == 'delete') {
          $return = '{"error": "Unter diese E-Mail-Adresse bist du nicht registriert."}';
        }
        else {
          $return = '{"success": "Diese E-Mail-Adresse ist noch nicht registriert."}';
        }
      }
      elseif($mailBool == 2) {
        if($action == 'register') {
          $return = '{"error": "Diese E-Mail-Adresse ist bereits registriert!"}';
        }
        elseif($action == 'profile') {
          $return = '{"success": "Unter dieser E-Mail-Adresse bist du registriert.", '
                    .'"class": ""}';
        }
        else {
          $return = '{"success": "Unter dieser E-Mail-Adresse bist du registriert."}';
        }
      }
      elseif($mailBool == 3) {
        if($action == 'delete') {
          $return = '{"error": "Unter diese E-Mail-Adresse bist du nicht registriert."}';
        }
        else {
          $return = '{"error": "Diese E-Mail-Adresse ist bereits registriert!"}';
        }
      }
    }

    return $return;
  }
/***** Check * Ende ***************************************************/

/***** Infos * Start **************************************************/
/**
 * GET User Info variabel
 *
 * Holen variabler Infos aus Tabelle "users"
 *
 * @param   int     $user       ID der User
 * @param   string  $parameter  Infos, die abgefragt werden sollen
 * @return  array|bool          Ergebnis aus Datenbank
 */
  function getUserInfoAll($parameter = 'u.username') {
    global $link;
    $user = null;

    $query_user = 'select u.id, '.mysqli_real_escape_string($link, $parameter).' '
                 .'from users as u '
                 .'left join users_settings as us on us.users_id=u.id '
                 .'left join colors as c on c.id=us.colors_id '
                 .';';
//print '<pre>'; print_r($query_user); print '</pre>';
    $select_user = mysqli_query($link, $query_user);
    if($select_user && mysqli_num_rows($select_user) > 0) {
      while($users = mysqli_fetch_assoc($select_user)) {
        $user[$users['id']] = $users;
      }
    }

    return $user;
  }

/**
 * GET User Info variabel
 *
 * Holen variabler Infos aus Tabelle "users"
 *
 * @param   int     $user       ID der User
 * @param   string  $parameter  Infos, die abgefragt werden sollen
 * @return  array|bool          Ergebnis aus Datenbank
 */
  function getUserInfo($user = 0, $parameter = 'u.id') {
    global $link;
    $return = null;

    if($user > 0) {
      $query_user  = 'select '.mysqli_real_escape_string($link, $parameter).' '
                    .'from users as u '
                    .'left join users_settings as us on us.users_id=u.id '
                    .'left join colors as c on c.id=us.colors_id '
                    .'where u.id="'.mysqli_real_escape_string($link, $user).'"'
                    .';';
//print '<pre>'; print_r($query_user); print '</pre>';
      $select_user = mysqli_query($link, $query_user);
      if($select_user && mysqli_num_rows($select_user) > 0) {
        $return = mysqli_fetch_assoc($select_user);
      }
    }

    return $return;
  }

/**
 * GET User Infos für Profil
 *
 * Holen aller für das Profil der User relevanten Daten aus den Tabellen:
 * users, users_infos, users_settings, users_levels
 *
 * @param   int     $user       ID der User
 * @return  string|bool         Ergebnis aus Datenbank
 */
  function getUserProfileInfo($id = 0) {
    global $link;
    $user = null;

    if($id > 0) {
      $status  = ['inactive'  => 'inaktiv', 
                  'active'    => 'aktiv', 
                  'deleted'   => 'gelöscht', 
                  'paused'    => 'pausiert', 
                  'locked'    => 'gesperrt'];

      $query_user  = 'select u.id, u.username, u.mail, u.registered, u.lastseen, u.status, '
                    .'us.send_reminder, us.send_placement, us.colors_id, '
                    .'c.name, c.short '
                    .'from users as u '
                    .'inner join users_settings as us on u.id=us.users_id '
                    .'inner join colors as c on c.id=us.colors_id '
                    .'where u.id="'.mysqli_real_escape_string($link, $id).'"'
                    .';';
//print '<pre>'; print_r($query_user); print '</pre>';
      $select_user = mysqli_query($link, $query_user);

      if($select_user && mysqli_num_rows($select_user) > 0) {
        $user = mysqli_fetch_assoc($select_user);
        $user['status'] = $status[$user['status']];
      }
    }

    return $user;
  }

/**
 * GET User Einstellungen
 *
 * Holen aller Einstellungen der User aus der Tabelle:
 * users_settings
 *
 * @param   int     $user       ID der User
 * @return  string|bool         Ergebnis aus Datenbank
 */
/*  function getUserProfileSetting($user = 0) {
    global $link;
    $return = false;

    if($user > 0) {
      $query_user = 'select design_colors_id, design_event, '
                   .'design_sidebar, design_games, '
                   .'times_id, weather_id, difficulties_id, '
                   .'show_status, show_mail, '
                   .'show_name, show_birthday, format_birthday, show_country, '
                   .'show_homepage, '
                   .'send_message_pn, send_message_friend, send_message_gift, '
                   .'send_message_request, send_message_exam, send_message_quest, '
                   .'send_message_game, send_message_bank, '
                   .'send_pn_friend, send_pn_gift, '
                   .'send_pn_request, send_pn_exam, send_pn_quest, '
                   .'send_pn_game, send_pn_bank, '
                   .'send_atmail_pn, send_atmail_friend, send_atmail_gift, '
                   .'send_atmail_game, send_atmail_bank '
                   .'from users_settings '
                   .'where users_id="'.mysqli_real_escape_string($link, $user).'";';
//print '<pre>'; print_r($query_user); print '</pre>';
      $select_user = mysqli_query($link, $query_user);
      if($select_user && mysqli_num_rows($select_user) > 0) {
        $return = mysqli_fetch_assoc($select_user);
      }
      else {
        $return = false;
      }
    }

    return $return;
  }

/**
 * GET User Settings "Senden"
 *
 * Hole Einstellungen der User für Benachrichtigungen
 *
 * @param   int     $user       ID der User
 * @return  array               Booleans für Kurznachricht, PrivatNachricht, Mail
 */
/*  function getUserSettingSend($user = 0) {
    global $link;
    $setting = null;

    if($user > 0) {
      $query_settings = 'select u.mail, '
                       .'us.send_message_pn, us.send_message_friend, us.send_message_gift, '
                       .'us.send_message_request, us.send_message_exam, us.send_message_quest, '
                       .'us.send_message_game, us.send_message_bank, '
                       .'us.send_pn_friend, us.send_pn_gift, '
                       .'us.send_pn_request, us.send_pn_exam, us.send_pn_quest, '
                       .'us.send_pn_game, us.send_pn_bank, '
                       .'us.send_atmail_pn, us.send_atmail_friend, us.send_atmail_gift, '
                       .'us.send_atmail_game, us.send_atmail_bank '
                       .'from users as u '
                       .'join users_settings as us on u.id=us.users_id '
                       .'where u.id="'.mysqli_real_escape_string($link, $user).'";';
//print '<pre>'; print_r($query_settings); print '</pre>';
      $select_settings = mysqli_query($link, $query_settings);
      $setting = mysqli_fetch_assoc($select_settings);
    }

    return $setting;
  }
/***** Infos * Ende **************************************************/

/**
 * GET verfügbare Plätze
 *
 * Hole noch verfügbare User Plätze
 *
 * @return  int                 Anzahl
 */
  function getUserLimit() {
    global $link;
    $user = null;

    $query_users = 'select ('
                  .'(select count(c.id) from colors as c) - '
                  .'(select count(u.id) from users as u '
                    .'where u.status <> "deleted" '
                    .'and u.status <> "locked")'
                  .') as `limit`'
                  .';';
    $select_users = mysqli_query($link, $query_users);
    while($users = mysqli_fetch_assoc($select_users)) {
      $user = $users['limit'];
    }

    return $user;
  }

/**
 * GET verfügbare Plätze
 *
 * Hole noch verfügbare User Plätze
 *
 * @return  int                 Anzahl
 */
  function getUserAll() {
    global $link;
    $user = null;

    $query_users = 'select u.id, u.username '
                  .'from users as u '
                  .';';
    $select_users = mysqli_query($link, $query_users);
    if($select_users && mysqli_num_rows()) {
      while($users = mysqli_fetch_assoc($select_users)) {
        $user[$users['id']] = $users['username'];
      }
    }

    return $user;
  }

/**
 * SHOW Login Formular
 *
 * Zeige Login Formular je nach Format
 *
 * @return  string              HTML
 */
  function showLogin($format = 'menu') {
    if($format == 'site') {
      $form  = '<div id="login_form">'
                .'<form target="_self" method="post" action="/login">'
                  .'<input type="hidden" name="action" class="field_action" value="login" />'
                  .'<div class="column is-one-third field is-centered">
                      <p class="control has-icons-left has-icons-right">
                        <input type="email" name="login[email]" id="login_email" class="field_email input is-rounded" placeholder="E-Mail-Adresse">
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
                        <input type="password" name="login[password]" id="login_password" class="field_password input is-rounded" placeholder="Password">
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
                      <p class="control">
                        <button class="button is-rounded">
                          Login
                        </button>
                      </p>
                    </div>'
                .'</form>'
              .'</div>';
    }
    elseif($format == 'burger') {
      $form  = '<span id="user" data-user="0" style="display: none;"></span>'
              .'<div id="login_form">'
                .'<form target="_self" method="post" action="/login">'
                  .'<input type="hidden" name="action" class="field_action" value="login" />'
                  .'<div class="columns is-variable is-1">'
                    .'<div class="column is-two-fifths">
                        <p class="control has-icons-left has-icons-right">
                          <input type="email" name="login[email]" id="login_email" class="field_email input is-small is-rounded" placeholder="E-Mail-Adresse">
                          <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                          </span>
                          <span class="icon is-small is-right">
                            <i class="fas fa-check" style="display: none;"></i>
                            <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                          </span>
                        </p>
                      </div>
                      <div class="column is-two-fifths">
                        <p class="control has-icons-left has-icons-right">
                          <input type="password" name="login[password]" id="login_password" class="field_password input is-small is-rounded" placeholder="Passwort">
                          <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                          </span>
                          <span class="icon is-small is-right">
                            <i class="fas fa-check" style="display: none;"></i>
                            <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                          </span>
                        </p>
                      </div>
                      <div class="column is-one-fifths">
                        <p class="control">
                          <button class="button is-small is-rounded">
                            Login
                          </button>
                        </p>
                      </div>'
                  .'</div>'
                .'</form>'
              .'</div>';
    }
    else {
      $form  = '<span id="user" data-user="0" style="display: none;"></span>'
              .'<div id="login_form">'
                .'<form target="_self" method="post" action="/login">'
                  .'<input type="hidden" name="action" class="field_action" value="login" />'
                  .'<div class="columns is-variable is-1">'
                    .'<div class="column is-two-fifths">
                        <p class="control has-icons-left has-icons-right">
                          <input type="email" name="login[email]" id="login_email" class="field_email input is-small is-rounded" placeholder="E-Mail-Adresse">
                          <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                          </span>
                          <span class="icon is-small is-right">
                            <i class="fas fa-check" style="display: none;"></i>
                            <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                          </span>
                        </p>
                        <p class="content is-small">
                          <a href="/forgot">
                            <span>Login vergessen</span>
                          </a>
                        </p>
                      </div>
                      <div class="column is-two-fifths">
                        <p class="control has-icons-left has-icons-right">
                          <input type="password" name="login[password]" id="login_password" class="field_password input is-small is-rounded" placeholder="Passwort">
                          <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                          </span>
                          <span class="icon is-small is-right">
                            <i class="fas fa-check" style="display: none;"></i>
                            <i class="fas fa-exclamation-triangle" style="display: none;"></i>
                          </span>
                        </p>
                        <p class="content is-small">
                          <a href="/register">
                            <span>Registrieren</span>
                          </a>
                        </p>
                      </div>
                      <div class="column is-one-fifths">
                        <p class="control">
                          <button class="button is-small is-rounded">
                            Login
                          </button>
                        </p>
                      </div>'
                  .'</div>'
                .'</form>'
              .'</div>';
    }

    return $form;
  }

/**
 * SHOW Passwort vergessen Formular
 *
 * Zeige Passwort vergessen Formular je nach Format
 *
 * @return  string              HTML
 */
  function showForgot($format = 'site') {
    if($format == 'other') {
      $form  = '';
    }
    else {
      $form  = '<div id="forgot_form">'
                .'<form target="_self" method="post" action="/forgot">'
                  .'<input type="hidden" name="action" class="field_action" value="forgot" />'
                  .'<div class="column is-one-third field is-centered">
                      <p class="control has-icons-left has-icons-right">
                        <input type="email" name="forgot[email]" id="forgot_email" class="field_email input is-rounded" placeholder="E-Mail-Adresse">
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
                      <p class="control">
                        <button class="button is-rounded">
                          Passwort anfordern
                        </button>
                      </p>
                    </div>'
                .'</form>'
              .'</div>';
    }

    return $form;
  }

/* Passwort ***************************************************************************************/
/**
 * GET Passwort gehashed
 *
 * Salze und hashe das Passwort
 *
 * @param   string  $pw         klartext Passwort
 * @return  string              Passworthash
 */
  function getHashPassword($pw) {
    $salt = "srbych";
    $salt_pw = $salt.$pw.$salt;
    return hash('sha256', $salt_pw);
  }

/**
 * GET zufälliges Passwort
 *
 * Generiere ein zufälliges Passwort
 *
 * @return  string              zufälliges klartext Passwort
 */
  function getRandomPassword() {
    $password = '';
    $zeichen = 'qwertzupasdfghkyxcvbnm';
    $zeichen .= '123456789';
    $zeichen .= 'WERTZUPLKJHGFDSAYXCVBNM';

    srand((double)microtime()*1000000);
    //Startwert für den Zufallsgenerator festlegen

    for($i = 0; $i < 15; $i++) {
      $password .= substr($zeichen,(rand()%(strlen ($zeichen))), 1);
    }
    return $password;
  }

// DELETE alle online Usern die länger als 20 Minuten nichts getan haben
  $online_logout = setUserLogoutAll();
// REFRESH aktiven Usern
  $online_refresh = setUserRefresh();

?>
