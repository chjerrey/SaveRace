<?php if(!isset($_SESSION)) session_start(); ?>
<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
// Ersparnisse
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/saving/functions.php');

  if($layoutLoginBool) {
    print  '<h1 class="title is-3">Rennen</h1>';
    $savingCurrent = getSavingCurrent();
//print '<pre>savingCurrent => '; print_r($savingCurrent); print '</pre>';

    if(empty($savingCurrent)) {
      $saving  = '<article class="message is-small is-warning">
                    <div class="message-header">
                      <p>Achtung</p>
                    </div>
                    <div class="message-body">
                      Für diesen Monat sind noch keine Ersparnisse hinterlegt.
                    </div>
                  </article>';
    }
    else {
      $firstId = 1;
      $saving  = '<canvas id="chart-container" style="height: 300px; width: 100%;"></canvas>';
        $ucnt = 0;
        foreach($savingCurrent as $uid => $usaving) {
          if($ucnt == 0) $firstId = $uid;
          $saving .= '<img id="img_'.$uid.'" src="/img/stripes__'.$usaving['color']['short'].'.png" style="display: none;" />';
          $savingPlace[$uid] = $usaving['current'];
          $ucnt++;
        }
      $savingPlace = getSavingPlace($savingPlace);
//print '<pre>savingPlace => '; print_r($savingPlace); print '</pre>';

      $saving .= '<script type="text/javascript">
                    var chart = $("#chart-container");
                    var canvas = document.getElementById("chart-container");
                    var ctx = canvas.getContext("2d");';

        foreach($savingCurrent as $uid => $usaving) {
          $saving .= 'var img_'.$uid.' = document.getElementById("img_'.$uid.'");';
        }
        $saving .= 'img_'.$firstId.'.onload = function() {';
        foreach($savingCurrent as $uid => $usaving) {
          $saving .= 'var pattern_'.$uid.' = ctx.createPattern(img_'.$uid.', "repeat");';
        }
        $saving .= '
                      var myChart = new Chart(chart, {
                        type: "bar",
                        data: {
                          labels: [';
              $ucnt = 0;
              foreach($savingCurrent as $uid => $usaving) {
                if($ucnt > 0) $saving .= ',';
                $saving .= '"'.$usaving['username'].'"';
                $ucnt++;
              }
              $saving .= '],
                          datasets: [{
                            barPercentage: 1,
                            barThickness: 29,
                            label: "Ersparnis",
                            data: [';
                $ucnt = 0;
                foreach($savingCurrent as $uid => $usaving) {
                  if($ucnt > 0) $saving .= ',';
                  $saving .= '"'.$usaving['current'].'"';
                  $ucnt++;
                }
                $saving .= '],
                            backgroundColor: [';
                $ucnt = 0;
                foreach($savingCurrent as $uid => $usaving) {
                  if($ucnt > 0) $saving .= ',';
                  $saving .= '"#'.$usaving['color']['middle'].'"';
                  $ucnt++;
                }
                $saving .= '],
                            borderColor: [';
                $ucnt = 0;
                foreach($savingCurrent as $uid => $usaving) {
                  if($ucnt > 0) $saving .= ',';
                  $saving .= '"#'.$usaving['color']['dark'].'"';
                  $ucnt++;
                }
                $saving .= '],
                            borderWidth: 1
                          }, {
                            barPercentage: 1,
                            barThickness: 14.5,
                            label: "Depot",
                            data: [';
                $ucnt = 0;
                foreach($savingCurrent as $uid => $usaving) {
                  if($ucnt > 0) $saving .= ',';
                  $saving .= '"'.$usaving['depot'].'"';
                  $ucnt++;
                }
                $saving .= '],
                            backgroundColor: [';
                $ucnt = 0;
                foreach($savingCurrent as $uid => $usaving) {
                  if($ucnt > 0) $saving .= ',';
                  $saving .= 'pattern_'.$uid.'';
                  $ucnt++;
                }
                $saving .= '],
                            borderColor: [';
                $ucnt = 0;
                foreach($savingCurrent as $uid => $usaving) {
                  if($ucnt > 0) $saving .= ',';
                  $saving .= '"#'.$usaving['color']['middle'].'"';
                  $ucnt++;
                }
                $saving .= '],
                            borderWidth: 1
                          }]
                        },
                        options: {
                          layout: {
                            padding: {
                              left: 0,
                              right: 0,
                              top: 30,
                              bottom: 0
                            }
                          },
                          legend: {
                            display: false
                          },
                          scales: {
                            yAxes: [{
                              ticks: {
                                beginAtZero: true,
                                callback: function(value, index, values) {
                                  return value + " €";
                                }
                              }
                            }]
                          },
                          tooltips: {
                            enabled: true,
                            mode: "single",
                            callbacks: {
                              label: function (tooltipItems, data) {
                                return data.datasets[tooltipItems.datasetIndex].label + ": " + tooltipItems.yLabel + " €";
                              }
                            }
                          },
                          plugins: {
                            labels: [{
                              render: "image",
                              textMargin: 0,
                              images: [';
                  $ucnt = 0;
                  foreach($savingCurrent as $uid => $usaving) {
                    if($ucnt > 0) $saving .= ',';
                    $saving .= '{ src: "/img/piggy__'.$usaving['color']['short'].$savingPlace[$uid]['place'].'.png", width: 29, height: 29 }';
                    $ucnt++;
                  }
                  $saving .= ']
                            }]
                          }
                        }
                      });
                    };
                  </script>';
    }

    print  '<div class="tile is-ancestor">
              <div class="tile is-parent is-shady">
                <article class="tile is-child notification is-white">
                  <div class="content">
                    '.$saving.'
                  </div>
                </article>
              </div>
            </div>';
  }
  else {
    print  '<h1 class="title is-3">Willkommen ...</h1>';
    print  '<div class="tile is-ancestor">
              <div class="tile is-parent is-shady">
                <article class="tile is-child notification is-white">
                  <h2 class="subtitle">... bei SaveRace!</h2>
                  <div class="content">
                    <p>
                      Dieses Spiel dient dazu seine User zum Sparen zu animieren.<br />
                      Die User notieren ihre Ersparnisse und können so im monatlichen Rennen um den ersten Platz kämpfen.<br />
                      <img src="/img/piggy.png" alt="" />
                    </p>
                  </div>
                </article>
              </div>
            </div>';
  }

?>
