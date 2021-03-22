<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
/**
 * Standard Funktionen
 *
 * @package   php
 * @link      https://ch-hexen.de
 * @author    Momo Pfirsich <momo@ch-hexen.de>
 * @copyright Copyright (c) 2019 Momo Pfirsich <momo@ch-hexen.de>
 */
/** DB Connection */
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/ajax/db.php');

  if(isset($_POST['fctn']) && isset($_POST['mod']) && $_POST['mod'] == 'none') {
    $return = '{"error": 1}';
    if($_POST['fctn'] == 'submenu') {
      $return = FtnLinkMenu($_POST['ref'], $_POST['page'], $_POST['world']);
    }
    echo $return;
  }

/**
 * GET Datum auf Deutsch
 *
 * Umwandlung des übergebenen Datums auf deutsch: 
 * von yyyy-mm-dd HH:ii:ss 
 * zu dd.mm.yyyy HH:ii:ss
 *
 * @param   date    $datehour   zu formatierendes Datum
 * @param   string  $format     Format für Ergebnis
 * @return  string              deutsches Datum
 */
  function getDateGerman($datehour = false, $format = 'dmy his') {
    $return = '';
    $today = date('Ymd');

    if(!$datehour) $datehour = date('Y-m-d H:i:s');
    $month = ['January'   => 'Januar', 
              'February'  => 'Februar', 
              'March'     => 'März', 
              'April'     => 'April', 
              'May'       => 'Mai', 
              'June'      => 'Juni', 
              'July'      => 'Juli', 
              'August'    => 'August', 
              'September' => 'September', 
              'October'   => 'Oktober', 
              'November'  => 'November', 
              'December'  => 'Dezember'];
    if($format == 'month') {
      $return = $month[$datehour];
    }
    elseif($format == 'monthyear') {
      $date = explode(' ', $datehour);
      $return = $month[$date[0]].' '.$date[1];
    }
    else {
      $date = explode(' ', $datehour);
      list($year, $month, $day) = explode('-', $date[0]);
      if(isset($date[1])) list($hour, $minute, $second) = explode(':', $date[1]);

      if($format == 'day' || 
             $format == 'day hi') {
        $diff = intval($year.$month.$day) - $today ;
        if($diff === -2) $return = 'vorgestern';
        elseif($diff === -1) $return = 'gestern';
        elseif($diff === 0) $return = 'heute';
        elseif($diff === 1) $return = 'morgen';
        elseif($diff === 2) $return = 'übermorgen';
        else $return = $day.'.'.$month.'.';
        if(isset($date[1]) && $format == 'day hi') {
          $return .= ' '.$hour.':'.$minute;
        }
      }
      elseif($format == 'dm' || 
         $format == 'dm hi') {
        $return = $day.'.'.$month.'.';
        if(isset($date[1]) && $format == 'dm hi') {
          $return .= ' '.$hour.':'.$minute;
        }
      }
      elseif($format == 'my') {
        $return = $month.'.'.$year;
      }
      elseif($format == 'dmy') {
        $return = $day.'.'.$month.'.'.$year;
      }
      elseif(isset($date[1]) && $format == 'hi') {
        $return = $hour.':'.$minute;
      }
      elseif(isset($date[1]) && $format == 'his') {
        $return = $hour.':'.$minute.':'.$second;
      }
      else {
        $return = $day.'.'.$month.'.'.$year.((isset($date[1]))?' '.$date[1]:'');
      }
    }

    return $return;
  }

?>
