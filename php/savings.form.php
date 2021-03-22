<?php if(!isset($_SESSION)) session_start(); ?>
<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
// Ersparnis
  require_once(CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mod/saving/functions.php');

/**
 * SHOW Ersparnisse Formular
 *
 * Zeige Ersparnisse Formular je nach Format
 *
 * @return  string              HTML
 */
  function showSavingsForm() {
    global $layoutLoginBool;
    global $page;

    if($layoutLoginBool) {
      $form  = '<div id="saving_form">'
                .'<form target="_self" method="post" action="/'.$page.'">'
                  .'<input type="hidden" name="action" class="field_action" value="saving" />'
                  .'<input type="hidden" name="saving[user]" class="field_user" value="'.$_SESSION['id'].'" />'
                  .'<div class="columns is-variable is-1">'
                    .'<div class="column is-one-quarter">
                        <p class="control">
                          <input type="date" name="saving[date]" id="saving_date" class="field_date input is-small is-rounded" placeholder="Datum" required>
                        </p>
                      </div>
                      <div class="column is-one-quarter">
                        <p class="control">
                          <input type="number" name="saving[amount]" id="saving_amount" class="field_amount input is-small is-rounded" placeholder="0,00" min="-1000000.00" max="1000000.00" step="0.01" required>
                        </p>
                      </div>
                      <div class="column is-one-quarter">
                        <p class="control">
                          <input type="text" name="saving[comment]" id="saving_comment" class="field_comment input is-small is-rounded" placeholder="Kommentar" required>
                        </p>
                      </div>
                      <div class="column is-one-quarter">
                        <div style="width: 49%; display: inline-block;">
                          <p class="control">
                            <input type="checkbox" name="saving[depot]" id="saving_depot" class="field_depot input switch is-small is-rounded is-outlined">
                            <label for="saving_depot">Depot</label>
                          </p>
                        </div>
                        <div style="width: 49%; display: inline-block;">
                          <p class="control">
                            <button class="button is-small is-rounded">
                              sparen
                            </button>
                          </p>
                        </div>
                      </div>'
                  .'</div>'
                .'</form>'
              .'</div>';

      if(!empty($_POST['action'])) {
        if($_POST['action'] == 'saving') {
//print '<pre>_POST => '; print_r($_POST); print '</pre>';
          if(!empty($_POST['saving']['date']) &&
             !empty($_POST['saving']['amount']) &&
             !empty($_POST['saving']['comment'])) {
            $saving = newSaving($_POST['saving']);
            if($saving) {
              $form .= '<article id="saving_message" class="message is-small is-success">
                          <div class="message-body">
                            Dein Ersparnis wurde erfolgreich gespeichert.
                          </div>
                        </article>';
            }
            else {
              $form .= '<article id="saving_message" class="message is-small is-danger">
                          <div class="message-body">
                            Dein Ersparnis konnte nicht gespeichert werden!
                          </div>
                        </article>';
            }
          }
          else {
            $form .= '<article id="saving_message" class="message is-small is-danger">
                        <div class="message-body">
                          Dein Ersparnis konnte nicht gespeichert werden!';
          if(empty($_POST['saving']['date'])) 
                $form .= '<br />Du hast kein Datum angegeben.';
          if(empty($_POST['saving']['amount'])) 
                $form .= '<br />Du hast keinen Betrag angegeben.';
          if(empty($_POST['saving']['comment'])) 
                $form .= '<br />Du hast keinen Kommentar angegeben.';
              $form .= '</div>
                      </article>';
          }
        }
      }
    }
    else {
      $form  = '<article id="saving_message" class="message is-small is-danger">
                  <div class="message-body">
                    Du musst eingeloggt sein!
                  </div>
                </article>';
    }

    return $form;
  }

?>
