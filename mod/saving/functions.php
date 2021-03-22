<?php if(!headers_sent() && !isset($_SESSION)) session_start(); ?>
<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
/**
 * Modul Ersparnis
 *
 * @package   mod\saving
 * @link      https://ch-Usern.de
 * @author    Momo Pfirsich <momo@ch-Usern.de>
 * @copyright Copyright (c) 2019 Momo Pfirsich <momo@ch-Usern.de>
 */
/** DB Connection */
  require_once(CH_ROOT."/var/www/vhosts/hosting113386.af996.netcup.net/saverace/ajax/db.php");
/** Nutzer {@see \mod\user} */
  require_once(CH_ROOT."/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/user/functions.php");
/** Mail {@see \mod\mail} */
  require_once(CH_ROOT."/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/mail/functions.php");
/**
 * standard Variablen
 *
 * @global  mysqli_connect  $link
 * @global  int             $dayslast
 * @global  date            $today
 * @global  date            $todaytime
 */
  global $link;

/**
 * NEW Ersparnis Eintrag
 *
 * Setze neuen Ersparniseintrag für User
 *
 * @param   int     $user       ID des Users
 * @param   string  $currency   Währung
 * @param   int     $amount     Betrag
 * @param   string  $comment    Nachricht
 * @return  bool                ob Setzen erfolgreich
 */
  function newSaving($newSaving) {
    global $link;
    $saving = false;

    if(!empty($newSaving['depot']) && $newSaving['depot'] == 'on') $newSaving['depot'] = 1;
    else $newSaving['depot'] = 0;

    if($newSaving['user'] > 0 && !empty($newSaving['date']) && $newSaving['amount'] != 0 && !empty($newSaving['comment'])) {
      $query_saving  = 'insert into users_savings set '
                      .'users_id="'.mysqli_real_escape_string($link, $newSaving['user']).'", '
                      .'date="'.mysqli_real_escape_string($link, $newSaving['date']).'", '
                      .'amount="'.mysqli_real_escape_string($link, ($newSaving['amount'] * 100)).'", '
                      .'comment="'.mysqli_real_escape_string($link, $newSaving['comment']).'", '
                      .'depot="'.mysqli_real_escape_string($link, $newSaving['depot']).'"'
                      .';';
//print '<pre>'; print_r($query_saving); print '</pre>'; $saving = true;
      $saving = mysqli_query($link, $query_saving);
    }

    return $saving;
  }

/**
 * GET aktuelle Ersparnis Historie
 *
 * Hole Ersparnis Historie für User
 *
 * @param   int     $user       ID der User
 * @return  string              HTML Layout
 */
  function getSavingHistory($user = 0) {
    global $link;
    $saving  = '';

    if($user > 0) {
      $query_savings = 'select c.`id`, c.`date` as `datum`, c.`amount` as `summe`, '
                      .'c.`comment`, c.`depot`, "current" as `class`, '
                      .'"0" as `place` '
                      .'from users_savings as c '
                      .'where c.`users_id`="'.mysqli_real_escape_string($link, $user).'" '
                      .'and c.`date`>="'.mysqli_real_escape_string($link, date('Y-m-').'01').'" '
                      .'UNION '
                      .'select h.`id`, DATE_FORMAT(h.`date`, "%Y-%m") as `datum`, sum(h.`amount`) as `summe`, '
                      .'CONCAT("Gesamtersparnis ", DATE_FORMAT(h.`date`, "%m %Y")) as `comment`, "0" as `depot`, "history" as `class`, '
                      .'hp.`place` '
                      .'from users_savings as h '
                      .'left join users_places as hp on hp.`users_id`=h.`users_id` and hp.`date` like CONCAT(DATE_FORMAT(h.`date`, "%Y-%m"), "%") '
                      .'where h.`users_id`="'.mysqli_real_escape_string($link, $user).'" '
                      .'and h.`depot`="0" '
                      .'and h.`date`<"'.mysqli_real_escape_string($link, date('Y-m-').'01').'" '
                      .'group by `datum` '
                      .'UNION '
                      .'select d.`id`, DATE_FORMAT(d.`date`, "%Y-%m") as `datum`, sum(d.`amount`) as `summe`, '
                      .'CONCAT("Gesamtdepot ", DATE_FORMAT(d.`date`, "%m %Y")) as `comment`, "1" as `depot`, "history" as `class`, '
                      .'"0" as `place` '
                      .'from users_savings as d '
                      .'where d.`users_id`="'.mysqli_real_escape_string($link, $user).'" '
                      .'and d.`depot`="1" '
                      .'and d.`date`<"'.mysqli_real_escape_string($link, date('Y-m-').'01').'" '
                      .'group by `datum` '
                      .'order by datum desc, id desc;';
//print '<pre>'; print_r($query_savings); print '</pre>';
      $select_savings = mysqli_query($link, $query_savings);

      if($select_savings && mysqli_num_rows($select_savings) > 0) {
        while($savings = mysqli_fetch_assoc($select_savings)) {
          $saving .= '<tr class="is-'.$savings['class'].' '.((0 > $savings['summe'])? 'is-negative' : '').' '.(($savings['depot'])? 'is-depot' : '').'">'
                      .'<td class="has-icon">'
                        .(($savings['depot'])? 
                           '<i class="fas fa-chart-line" title="Depot"></i>' : 
                           (($savings['class'] == 'history' && $savings['place'] > 0)? 
                             '<img src="/img/crown'.$savings['place'].'.png" alt="o" title="Platz '.$savings['place'].'" />' : 
                             ''))
                      .'</td>'
                      .'<td>'.$savings['datum'].'</td>'
                      .'<td>€&nbsp;<span class="is-monospace">' 
                        .((($savings['summe'] >= 0 && 100000 > $savings['summe']) || 
                           (0 > $savings['summe'] && $savings['summe'] > -100000))? '&nbsp;' : '')
                        .((($savings['summe'] >= 0 && 10000 > $savings['summe']) || 
                           (0 > $savings['summe'] && $savings['summe'] > -10000))? '&nbsp;' : '')
                        .((($savings['summe'] >= 0 && 1000 > $savings['summe']) || 
                           (0 > $savings['summe'] && $savings['summe'] > -1000))? '&nbsp;' : '')
                        .(($savings['summe'] >= 0)? '&nbsp;' : '')
                        .number_format(($savings['summe'] / 100), 2, ',', '.')
                      .'</span></td>'
                      .'<td>'.$savings['comment'].'</td>'
                      .'<td class="has-icon">'
                        .'<i class="fas fa-trash" title="bearbeiten"></i> '
                        .'<i class="fas fa-pen" title="bearbeiten"></i>'
                      .'</td>'
                    .'</tr>';
        }
      }
      else {
        $saving  = '<tr>
                      <td colspan="4">
                        <article class="message is-warning">
                          <div class="message-body">
                            Noch keine Ersparnisse gespeichert.
                          </div>
                        </article>
                      </td>
                    </tr>';
      }
    }

    return $saving;
  }

/**
 * GET aktuelle Ersparnis
 *
 * Hole aktuellen Ersparnisbetrag von allen Usern
 *
 * @return  array               Betrag
 */
  function getSavingCurrent($month = 'this') {
    global $link;
    $saving = null;

    if($month == 'this') {
      $month_first = date('Y-m-d', strtotime("first day of this month"));
      $month_last = date('Y-m-d', strtotime("last day of this month"));
    }
    elseif($month == 'last') {
      $month_first = date('Y-m-d', strtotime("first day of previous month"));
      $month_last = date('Y-m-d', strtotime("last day of previous month"));
    }

    $query_savings = 'select cu.`id`, cu.`username`, '
                    .'cc.`short`, cc.`lighter`, cc.`light_bg`, cc.`light`, cc.`middle`, cc.`dark`, cc.`darker`, '
                    .'sum(c.`amount`) as `summe`, "0" as `depot`, '
                    .'CONCAT("Gesamtersparnis ", DATE_FORMAT(c.`date`, "%m %Y")) as `comment` '
                    .'from users_savings as c '
                    .'inner join users as cu on cu.`id`=c.`users_id` '
                    .'inner join users_settings as cus on cus.`users_id`=c.`users_id` '
                    .'inner join colors as cc on cc.`id`=cus.`colors_id` '
                    .'where c.`depot`="0" '
                    .'and c.`date`>="'.mysqli_real_escape_string($link, $month_first).'" '
                    .'and c.`date`<="'.mysqli_real_escape_string($link, $month_last).'" '
                    .'group by cu.`id` '
                    .'UNION '
                    .'select du.`id`, du.`username`, '
                    .'dc.`short`, dc.`lighter`, dc.`light_bg`, dc.`light`, dc.`middle`, dc.`dark`, dc.`darker`, '
                    .'sum(d.`amount`) as `summe`, "1" as `depot`, '
                    .'CONCAT("Gesamtdepot ", DATE_FORMAT(d.`date`, "%m %Y")) as `comment` '
                    .'from users_savings as d '
                    .'inner join users as du on du.`id`=d.`users_id` '
                    .'inner join users_settings as dus on dus.`users_id`=d.`users_id` '
                    .'inner join colors as dc on dc.`id`=dus.`colors_id` '
                    .'where d.`depot`="1" '
                    .'and d.`date`>="'.mysqli_real_escape_string($link, $month_first).'" '
                    .'and d.`date`<="'.mysqli_real_escape_string($link, $month_last).'" '
                    .'group by du.`id` '
                    .'order by id asc;';
//print '<pre>'; print_r($query_savings); print '</pre>';
    $select_savings = mysqli_query($link, $query_savings);

    if($select_savings && mysqli_num_rows($select_savings) > 0) {
      while($savings = mysqli_fetch_assoc($select_savings)) {
        if(!isset($saving[$savings['id']])) {
          $saving[$savings['id']]['username'] = $savings['username'];
          $saving[$savings['id']]['color']['short'] = $savings['short'];
          $saving[$savings['id']]['color']['lighter'] = $savings['lighter'];
          $saving[$savings['id']]['color']['light_bg'] = $savings['light_bg'];
          $saving[$savings['id']]['color']['light'] = $savings['light'];
          $saving[$savings['id']]['color']['middle'] = $savings['middle'];
          $saving[$savings['id']]['color']['dark'] = $savings['dark'];
          $saving[$savings['id']]['color']['darker'] = $savings['darker'];
          $saving[$savings['id']]['current'] = 0;
          $saving[$savings['id']]['depot'] = 0;
        }
        if($savings['depot'] == "0") {
          $saving[$savings['id']]['current'] = ($savings['summe'] / 100);
        }
        elseif($savings['depot'] == "1") {
          $saving[$savings['id']]['depot'] = ($savings['summe'] / 100);
        }
      }
    }

    return $saving;
  }

/**
 * GET Platzierung
 *
 * Platzierung der Ersparnisse
 *
 * @return  array               Betrag
 */
  function getSavingPlace($savingCurrent) {
    global $link;
    $saving = null;

    if(!empty($savingCurrent)) {
      arsort($savingCurrent);
      $i = 1;
      foreach($savingCurrent as $uid => $current) {
        $saving[$uid]['amount'] = $current;
        if($i > 3) $saving[$uid]['place'] = 0;
        else {
          $saving[$uid]['place'] = $i;
          $i++;
        }
      }
    }

    return $saving;
  }

/**
 * SET alle Platzierungen
 *
 * Platzierungen der Ersparnisse
 *
 * @return  array               Betrag
 */
  function setSavingPlaceAll() {
    global $link;
    $saving = 'ERROR';

    $savingCurrent = getSavingCurrent('last');
    if(!empty($savingCurrent)) {

      foreach($savingCurrent as $uid => $usaving) {
        $savingPlace[$uid] = $usaving['current'];
      }
      $savingPlace = getSavingPlace($savingPlace);

      $saving = ((setSavingPlace($savingPlace))? 'SUCCESS' : 'ERROR');
    }

    return $saving;
  }

/**
 * SET Platzierung
 *
 * Platzierung der Ersparnisse
 *
 * @return  array               Betrag
 */
  function setSavingPlace($savingPlace = null) {
    global $link;
    $saving = false;

    if(!empty($savingPlace)) {
      $month_last = date('Y-m-d', strtotime("last day of previous month"));
      $month = date('m Y', strtotime("first day of previous month"));

      $query_saving  = 'insert into users_places '
                      .'(`users_id`, `date`, `place`, `amount`) values ';
      $i = 1;
      foreach($savingPlace as $uid => $uplace) {
        $userInfo = getUserInfo($uid, 'u.username, u.mail, us.send_placement');
        if($userInfo['send_placement']) {
          $mailSubject = 'Deine Platzierung für '.$month.' bei SaveRace by ..::ch::..';
          $text = "hier kommt deine Platzierung des letzten Monats bei SaveRace by ..::ch::.. .\n\n";
          $html = 'hier kommt deine Platzierung des letzten Monats bei SaveRace by ..::ch::.. .<br /><br />';
          if($uplace['place'] > 0) {
            $text.= "Herzlichen Glückwunsch!\n"
                   ."Du konntest dir Platz ".$uplace['place']." für ".$month." ersparen.\n\n";
            $html.= 'Herzlichen Glückwunsch!<br />'
                   .'Du konntest dir Platz '.$uplace['place'].' für '.$month.' ersparen.<br /><br />';
          }
          else {
            $text.= "Schade.\n"
                   ."Für ".$month." konntest du leider keinen der vorderem Plätze ersparen.\n"
                   ."Sei nicht traurig. Jeder spart nur so viel er kann. Und der neue Monat bietet eine weitere Chance eine Platzierung zu ergattern.\n\n";
            $html.= 'Schade.<br />'
                   .'Für '.$month.' konntest du leider keinen der vorderem Plätze ersparen.<br />'
                   .'Mach dir nichts draus. Jeder spart nur so viel er kann. Und der neue Monat bietet eine weitere Chance eine Platzierung zu ergattern.<br /><br />';
          }
          $text.= "Wir hoffen, du sparst weiter kräftig.";
          $html.= 'Wir hoffen, du sparst weiter kräftig.';
          $mail = newMailSend($userInfo['mail'], $mailSubject, $userInfo['username'], $text, htmlentities($html, ENT_QUOTES, 'UTF-8'));
        }

        if($i > 1) $query_saving .= ', ';
        $query_saving .= '("'.mysqli_real_escape_string($link, $uid).'", '
                         .'"'.mysqli_real_escape_string($link, $month_last).'", '
                         .'"'.mysqli_real_escape_string($link, $uplace['place']).'", '
                         .'"'.mysqli_real_escape_string($link, ($uplace['amount'] * 100)).'")';
        $i++;
      }
      $query_saving .= ';';
//print '<pre>'; print_r($query_saving); print '</pre>'; $saving = true;
      $saving = mysqli_query($link, $query_saving);

      
    }

    return $saving;
  }

?>
