<?php
if(isset($_GET['type'])){
  $fehlercode = $_GET['type'];
}
else{
  $fehlercode = '404';
}

if ($fehlercode == '401') {
  $fehler = 'Zugriff nicht erlaubt!';
  $ursache = 'Ursachen daf&uuml;r k&ouml;nnten sein:<ul class="content" id="cause"><li>Du bist nicht authorisiert diese Seite zu betreten</li></ul>';
}
elseif ($fehlercode == '403') {
  $fehler = 'Zugriff nicht erlaubt!';
  $ursache = 'Dieser Bereich ist geschützt.<br />';
}
elseif ($fehlercode == '410') {
  $fehler = 'Seite oder Datei nicht mehr verf&uuml;gbar';
  $ursache = 'Ursachen daf&uuml;r k&ouml;nnten sein:<ul class="content" id="cause"><li>Die gew&uuml;nschte Seite oder Datei wurde umbenannt oder existiert nicht mehr</li><li>Du hast ein veraltetes Lesezeichen aufgerufen</li><li>Du hast die URL falsch eingegeben</li></ul>';
}
elseif ($fehlercode == '500') {
  $fehler = 'Interner Serverfehler';
  $ursache = 'Es gab einen Fehler im System.<br />';
}
else {
  $fehler = 'Seite oder Datei nicht gefunden';
  $ursache = 'Ursachen daf&uuml;r k&ouml;nnten sein:<ul class="content" id="cause"><li>Die gew&uuml;nschte Seite oder Datei ist vor&uuml;bergehend nicht erreichbar</li><li>Die gew&uuml;nschte Seite oder Datei wurde umbenannt oder existiert nicht mehr</li><li>Du hast ein veraltetes Lesezeichen aufgerufen</li><li>Du hast die URL falsch eingegeben</li></ul>';
}

print '<div class="column is-one-third is-centered">
        <article class="message is-danger">
          <div class="message-header">
            <p>'.$fehler.'</p>
          </div>
          <div class="message-body">
            '.$ursache.'<br />
            Du hast folgende M&ouml;glichkeit:
            <ul class="content" id="possibilities">
              <li>
                Navigiere zur <a href="/">Startseite</a>
              </li>
            </ul>
          </div>
        </article>
      </div>';

?>
