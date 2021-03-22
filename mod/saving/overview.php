<?php
/**
 * Modul Geld
 *
 * @package   mod\money
 * @link      https://ch-hexen.de
 * @author    Momo Pfirsich <momo@ch-hexen.de>
 * @copyright Copyright (c) 2019 Momo Pfirsich <momo@ch-hexen.de>
 * @ignore
 */
  require_once('functions.php');
  global $today;

  $moneyQuickview = '<div id="money_quick" class="border quick money">'
                     .'<h1>Wechselkurs <span>'.getDateGerman($today, 'dmy').'</span></h1>'
                     .getMoneyParity(1, 'quickview')
                     .'<a href="/parity"><div id="link_history" class="right-aligning font-small">Historie</div></a>'
                   .'</div>';
?>
