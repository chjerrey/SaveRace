<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
/**
 * Farben Funktionen
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
 * GET Layout gewählte Farbe
 *
 * Lade Layoutfarben aus Datenbank entsprechend Hexeneinstellungen
 *
 * @param   bool    $loginBool  eingeloggter Zustand
 * @param   int     $id         ID der Hexe
 * @return  array               Farbcodes
 */
  function getColor($loginBool = false, $id = 0) {
    global $link;
    global $event;

    if($loginBool) {
      $query_witch_design_color = 'select design_colors_id, design_event, '
                                 .'design_sidebar '
                                 .'from users_settings '
                                 .'where users_id="'.mysqli_real_escape_string($link, $id).'" '
                                 .'limit 1;';
//print '<pre>'; print_r($query_witch_design_color); print '</pre>';
      $select_witch_design_color = mysqli_query($link, $query_witch_design_color);
      $witch_design = mysqli_fetch_assoc($select_witch_design_color);
      if($event['name'] !== 'normal' && $witch_design["design_event"] > 0) {
        $query_css_design_color = 'select "'.mysqli_real_escape_string($link, $witch_design["design_sidebar"]).'" as sidebar, '
                                 .'short, lighter, light_bg, light, middle, dark, darker '
                                 .'from events_colors '
                                 .'where event="'.mysqli_real_escape_string($link, $event['name']).'" '
                                 .'limit 1;';
      }
      else {
        $query_css_design_color = 'select "'.mysqli_real_escape_string($link, $witch_design["design_sidebar"]).'" as sidebar, '
                                 .'short, lighter, light_bg, light, middle, dark, darker '
                                 .'from design_colors '
                                 .'where id="'.mysqli_real_escape_string($link, $witch_design["design_colors_id"]).'" '
                                 .'limit 1;';
      }
    }
    else {
      $witch_design["design_sidebar"] = 'none';
      $witch_design["design_colors_id"] = '1';
      if($event['name'] !== 'normal') {
        $query_css_design_color = 'select "'.mysqli_real_escape_string($link, $witch_design["design_sidebar"]).'" as sidebar, '
                                 .'short, lighter, light_bg, light, middle, dark, darker '
                                 .'from events_colors '
                                 .'where event="'.mysqli_real_escape_string($link, $event['name']).'" '
                                 .'limit 1;';
      }
      else {
        $query_css_design_color = 'select "'.mysqli_real_escape_string($link, $witch_design["design_sidebar"]).'" as sidebar, '
                                 .'short, lighter, light_bg, light, middle, dark, darker '
                                 .'from design_colors '
                                 .'where id="'.mysqli_real_escape_string($link, $witch_design["design_colors_id"]).'" '
                                 .'limit 1;';
      }
    }
//print '<pre>'; print_r($query_css_design_color); print '</pre>';
    $select_css_design_color = mysqli_query($link, $query_css_design_color);
    if($select_css_design_color && mysqli_num_rows($select_css_design_color) > 0) {
      $css_design_color = mysqli_fetch_assoc($select_css_design_color);
    }
    else {
      $query_css_design_color = 'select "'.mysqli_real_escape_string($link, $witch_design["design_sidebar"]).'" as sidebar, '
                               .'short, lighter, light_bg, light, middle, dark, darker '
                               .'from design_colors '
                               .'where id="'.mysqli_real_escape_string($link, $witch_design["design_colors_id"]).'" '
                               .'limit 1;';
      $select_css_design_color = mysqli_query($link, $query_css_design_color);
      $css_design_color = mysqli_fetch_assoc($select_css_design_color);
    }

    return $css_design_color;
  }

/**
 * GET Layout alle Farben
 *
 * Hole alle verfügbaren Farben aus der Datenbank
 *
 * @return  array               ID, Farbcodes
 */
  function getColorsAvailable() {
    global $link;
    $color = null;

    $query_colors  = 'select c.id, c.name as title, c.short, '
                    .'c.lighter, c.light_bg, c.light, c.middle, c.dark, c.darker, '
                    .'if(u.users_id is not null, 1, 0) as inactive '
                    .'from colors as c '
                    .'left join users_settings as u on u.colors_id=c.id'
                    .';';
//print '<pre>'; print_r($query_colors); print '</pre>';
    $select_colors = mysqli_query($link, $query_colors);

    if($select_colors && mysqli_num_rows($select_colors) > 0) {
      while($colors = mysqli_fetch_assoc($select_colors)) {
        $color[$colors['id']] = $colors;
      }
    }

    return $color;
  }

?>
