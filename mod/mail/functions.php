<?php
  defined('CH_ROOT') || ((strpos($_SERVER['DOCUMENT_ROOT'], '/') === 0)? define('CH_ROOT', '') : define('CH_ROOT', 'C:/xampp/'));
/**
 * Modul Mail
 *
 * @package   mod\mail
 * @link      https://saverace.ch-hexen.de
 * @author    Momo Pfirsich <momo@ch-hexen.de>
 * @copyright Copyright (c) 2019 Momo Pfirsich <momo@ch-hexen.de>
 */
//Import the PHPMailer class into the global namespace
  use PHPMailer\PHPMailer\PHPMailer;
  require CH_ROOT.'/var/www/vhosts/hosting113386.af996.netcup.net/saverace/mailer/vendor/autoload.php';

/**
 * NEW Mail an Hexe
 *
 * Versende Mail an Hexe
 *
 * @param   string  $mailTo       E-Mail-Adresse
 * @param   string  $mailSubject  Betreff
 * @param   string  $username     Nutzername
 * @param   string  $text         Text
 * @param   string  $html         Text als HTML
 * @param   bool    $layout     Layoutanwendung
 * @param   array   $sender     Absender
 * @return  bool                ob Senden erfolgreich
 */
  function newMailSend($mailTo, $mailSubject, $username, $text, $html, $layout = true, $sender = null) {
//print '<pre>newMailSend('.$mailTo.', '.$mailSubject.', '.$username.', '.$text.', '.$html.', '.$layout.', '.$sender.')</pre>';
    if($layout) {
      list($mailHtml, $mailTxt) = getMailLayout($mailSubject, $username, $text, $html);
    }
    else {
      list($mailHtml, $mailTxt) = getMailBlank($mailSubject, $text, $html);
    }

    //Create a new PHPMailer instance
    $mail = new PHPMailer;
//    $mail->Encoding = "base64";
    $mail->CharSet = 'UTF-8';
    if(empty($sender) || !is_array($sender)) {
      // SET who the message is to be sent from
      $mail->setFrom('noreply@ch-hexen.de', 'SaveRace by ..::ch::..');
      // SET an alternative reply-to address
      $mail->addReplyTo('momo@ch-hexen.de', 'SaveRace by ..::ch::..');
    }
    else {
      // SET who the message is to be sent from
      $mail->setFrom($sender[0], $sender[1]);
      // SET an alternative reply-to address
      $mail->addReplyTo($sender[0], $sender[1]);
    }
    // SET who the message is to be sent to
    $mail->addAddress($mailTo, $username);
    // SET the subject line
    $mail->Subject = $mailSubject;
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML(html_entity_decode($mailHtml, ENT_QUOTES, 'UTF-8'));
    if(!isset($mail->msgHTML) || empty($mail->msgHTML)) {
      $mail->Body = html_entity_decode($mailHtml, ENT_QUOTES, 'UTF-8');
      $mail->IsHTML(true);
    }
    //Replace the plain text body with one created manually
    $mail->AltBody = $mailTxt;

    //send the message, check for errors
    if(!$mail->send()) {
//      return "Mailer Error: ".$mail->ErrorInfo;
      return false;
    }
    else {
//      print 'Message sent.';
      return true;
    }
  }

/**
 * NEW Mail Registrierung
 *
 * Versende Infomail zu neuer Registrierung
 *
 * @param   string  $witchName  Nutzername
 * @param   string  $witchMail  E-Mail-Adresse
 * @param   string  $witchHash  Verifizierungshash
 * @param   string  $datetime   Datum
 * @return  bool                ob Senden erfolgreich
 */
  function newMailRegistered($witchName, $witchMail, $witchHash, $datetime) {
    $mailSubject = 'Neue Registrierung bei SaveRace by ..::ch::..';
    $text = "es gibt eine neue Registrierung bei SaveRace by ..::ch::.. .\n\n"
           ."Nutzername:\n"
           .$witchName."\n"
           ."E-Mail-Adresse:\n"
           .$witchMail."\n"
           ."Verifizierungslink:\n"
           ."https://saverace.ch-hexen.de/verify/".$witchMail."/".$witchHash."\n\n"
           ."Datum:\n"
           .$datetime;
    $html = 'es gibt eine neue Registrierung bei SaveRace by ..::ch::.. .<br /><br />'
           .'Nutzername:<br />'
           .$witchName.'<br />'
           .'E-Mail-Adresse:<br />'
           .$witchMail.'<br />'
           .'Verifizierungslink:<br />'
           .'<a href="https://saverace.ch-hexen.de/verify/'.$witchMail.'/'.$witchHash.'" style="text-decoration: none; cursor: pointer; color: #3273dc;">https://saverace.ch-hexen.de/verify/'.utf8_decode($witchMail).'/'.utf8_decode($witchHash).'</a><br /><br />'
           .'Datum:<br />'
           .$datetime;
    $mailTo = 'momo@ch-hexen.de';
    $username = 'chjerrey';
    $mail = newMailSend($mailTo, $mailSubject, $username, $text, htmlentities($html, ENT_QUOTES, 'UTF-8'));

    return $mail;
  }

/**
 * NEW Mail Verifikation
 *
 * Versende Verifikationsmail
 *
 * @param   string  $username   Nutzername
 * @param   string  $mailTo     E-Mail-Adresse
 * @param   string  $hash       Verifizierungshash
 * @return  bool                ob Senden erfolgreich
 */
  function newMailVerify($username, $mailTo, $hash) {
    $mailSubject = 'Deine Registrierung bei SaveRace by ..::ch::..';
    $text = "vielen Dank für Deine Registrierung bei SaveRace by ..::ch::.. .\n\n"
           ."Um Deinen neuen Account zu aktivieren, klicke bitte auf folgenden Link:\n"
           ."https://saverace.ch-hexen.de/verify/".$mailTo."/".$hash."\n\n"
           ."Sollte der Link nicht funktionieren, kopiere diesen bitte in die Adresszeile deines Browsers.";
    $html = 'vielen Dank für Deine Registrierung bei SaveRace by ..::ch::.. .<br /><br />'
           .'Um Deinen neuen Account zu aktivieren, klicke bitte auf folgenden Link:<br />'
           .'<a href="https://saverace.ch-hexen.de/verify/'.$mailTo.'/'.$hash.'" style="text-decoration: none; cursor: pointer; color: #3273dc;">https://saverace.ch-hexen.de/verify/'.utf8_decode($mailTo).'/'.utf8_decode($hash).'</a><br /><br />'
           .'Sollte der Link nicht funktionieren, kopiere diesen bitte in die Adresszeile deines Browsers.';
    $mail = newMailSend($mailTo, $mailSubject, $username, $text, htmlentities($html, ENT_QUOTES, 'UTF-8'));

    return $mail;
  }

/**
 * NEW Mail Passwort
 *
 * Versende neues Passwort als Mail
 *
 * @param   string  $username     Nutzername
 * @param   string  $mailTo       E-Mail-Adresse
 * @param   string  $password     Passwort
 * @return  bool                  ob Senden erfolgreich
 */
  function newMailPassword($username, $mailTo, $password) {
    $mailSubject = 'Dein neues Passwort bei SaveRace by ..::ch::..';
    $text = "hiermit erhälst Du Dein neues Passwort für SaveRace by ..::ch::.. .\n\n"
           ."Logge Dich bitte mit folgendem Passwort ein: ".$password."\n"
           ."Bitte ändere Dein Passwort bei Deinem nächsten Login.";
    $html = 'hiermit erhälst Du Dein neues Passwort für SaveRace by ..::ch::.. .<br /><br />'
           .'Logge Dich bitte mit folgendem Passwort ein: '.$password.'<br />'
           .'Bitte ändere Dein Passwort bei Deinem nächsten Login.';
    $mail = newMailSend($mailTo, $mailSubject, $username, $text, htmlentities($html, ENT_QUOTES, 'UTF-8'));

    return $mail;
  }

/**
 * SET Platzierung
 *
 * Platzierung der Ersparnisse
 *
 * @return  array               Betrag
 */
  function newMailReminder($username, $mailTo, $month) {
//print '<pre>newMailReminder('.$username.', '.$mailTo.', '.$month.')</pre>';
    $mailSubject = 'Deine Ersparnisse für '.$month.' bei SaveRace by ..::ch::..';
    $text = "schön, dass du bei SaveRace by ..::ch::.. mitmachst.\n\n"
           ."Hast du deine Ersparnisse für ".$month." schon eingetragen? Falls nicht, hole die Eingaben doch bitte nach.\n\n"
           ."Herzlichen Dank fürs Mitmachen!";
    $html = 'schön, dass du bei SaveRace by ..::ch::.. mitmachst.<br /><br />'
           .'Hast du deine Ersparnisse für '.$month.' schon eingetragen? Falls nicht, hole die Eingaben doch bitte nach.<br /><br />'
           .'Herzlichen Dank fürs Mitmachen!';
    $mail = newMailSend($mailTo, $mailSubject, $username, $text, htmlentities($html, ENT_QUOTES, 'UTF-8'));

    return $mail;
  }

/**
 * GET Mail Layout mit Anrede, Grußformel
 *
 * Hole Mailtetxt im Layout mit Header, Anrede, Grußformel, Footer
 *
 * @param   string  $subject    Betreff
 * @param   string  $username   Nutzername
 * @param   string  $text       Text
 * @param   string  $html       Text als HTML
 * @return  array               HTML Mail, Text Mail
 */
  function getMailLayout($subject = null, $username = null, $text = null, $html = null) {
    $mailHtml = "";
    $mailTxt = "";

    $mailTxt .= "SaveRace by ..::ch::..\n\n"
               .$subject."\n\n\n"
               ."Hallo ".$username.",\n\n"
               .$text."\n\n\n"
               ."Solltest Du Fragen haben, wende Dich bitte an \n"
               ."momo@ch-hexen.de\n\n\n"
               ."Dein ..::ch::..-Team\n\n\n"
               ."Besuche unsere Website: https://saverace.ch-hexen.de/\n";

    $mailHtml .= '<!doctype html><html><body>'
                  .'<table style="border-spacing: 0; border-collapse: collapse; color: #4a4a4a; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Oxygen-Sans, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, sans-serif; font-size: 16px; font-weight: 400; line-height: 1.5; text-align: left; clear: both; position: relative; z-index: 0; margin: 0 auto; max-width: 1344px; width: 100%; padding: 0;">'
                    .'<thead>'
                      .'<tr>'
                        .'<th style="background-color: #3298dc;color: #fff;height: 75px;padding: 8px 12px;">'
                          .'<a id="header_home_link" href="https://saverace.ch-hexen.de/" style="text-decoration: none;cursor: pointer;color: #ffffff;">'
                            .'SaveRace by ..::ch::..'
                          .'</a>'
                        .'</th>'
                      .'</tr>'
                    .'</thead>'
                    .'<tbody>'
                      .'<tr>'
                        .'<td style="background: #EFF3F4;padding: 8px;">'
                          .'<h1 style="font-size: 32px;font-weight: 600;line-height: 36px;margin: 24px 0;">'
                            .$subject
                          .'</h1>'
                          .'Hallo '.$username.',<br />'
                          .'<br />'
                          .html_entity_decode($html).'<br />'
                          .'<br />'
                          .'<br />'
                          .'Solltest Du Fragen haben, wende Dich bitte an <br />'
                          .'<a href="mailto:momo@ch-hexen.de" style="text-decoration: none; cursor: pointer; color: #3273dc;">momo@ch-hexen.de</a><br />'
                          .'<br />'
                          .'<br />'
                          .'Dein ..::ch::..-Team<br />'
                        .'</td>'
                      .'</tr>'
                    .'</tbody>'
                    .'<tfoot>'
                      .'<tr>'
                        .'<td style="background-color: #fafafa;padding: 8px;font-size: 10.4px;">'
                          .'<a href="https://saverace.ch-hexen.de/" style="text-decoration: none; cursor: pointer; color: #3273dc;">Webseite</a> &emsp;'
                          .'<span>&copy; 2020 - '.date('Y').' SaveRace by ..::ch::..</span>'
                        .'</td>'
                      .'</tr>'
                    .'</tfoot>'
                  .'</table>'
                .'</body></html>';

    return array(htmlentities($mailHtml, ENT_QUOTES, 'UTF-8'), $mailTxt);
  }

/**
 * GET Mail Layout ohne Anrede, Grußformel
 *
 * Hole Mailtext im Layout mit Header, Footer
 *
 * @param   string  $subject    Betreff
 * @param   string  $text       Text
 * @param   string  $html       Text als HTML
 * @return  array               HTML Mail, Text Mail
 */
  function getMailBlank($subject = null, $text = null, $html = null) {
    $mailHtml = "";
    $mailTxt = "";

    $mailTxt .= "SaveRace by ..::ch::..\n\n"
               .$subject."\n\n\n"
               .$text."\n\n\n"
               ."Besuche unsere Website: https://saverace.ch-hexen.de/\n";

    $mailHtml .= '<!doctype html><html><body>'
                  .'<table style="border-spacing: 0; border-collapse: collapse; color: #4a4a4a; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Oxygen-Sans, Ubuntu, Cantarell, &quot;Helvetica Neue&quot;, sans-serif; font-size: 16px; font-weight: 400; line-height: 1.5; text-align: left; clear: both; position: relative; z-index: 0; margin: 0 auto; max-width: 1344px; width: 100%; padding: 0;">'
                    .'<thead>'
                      .'<tr>'
                        .'<th style="background-color: #3298dc;color: #fff;height: 75px;padding: 8px 12px;">'
                          .'<a id="header_home_link" href="https://saverace.ch-hexen.de/" style="text-decoration: none;cursor: pointer;color: #ffffff;">'
                            .'SaveRace by ..::ch::..'
                          .'</a>'
                        .'</th>'
                      .'</tr>'
                    .'</thead>'
                    .'<tbody>'
                      .'<tr>'
                        .'<td style="background: #EFF3F4;padding: 8px;">'
                          .'<h1 style="font-size: 32px;font-weight: 600;line-height: 36px;margin: 24px 0;">'
                            .$subject
                          .'</h1>'
                          .html_entity_decode($html).'<br />'
                        .'</td>'
                      .'</tr>'
                    .'</tbody>'
                    .'<tfoot>'
                      .'<tr>'
                        .'<td style="background-color: #fafafa;padding: 8px;font-size: 10.4px;">'
                          .'<a href="https://saverace.ch-hexen.de/" style="text-decoration: none; cursor: pointer; color: #3273dc;">Webseite</a> &emsp;'
                          .'<span>&copy; 2020 - '.date('Y').' SaveRace by ..::ch::..</span>'
                        .'</td>'
                      .'</tr>'
                    .'</tfoot>'
                  .'</table>'
                .'</body></html>';

    return array(htmlentities($mailHtml, ENT_QUOTES, 'UTF-8'), $mailTxt);
  }

?>
