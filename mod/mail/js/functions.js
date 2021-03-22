function contact_submit() {
  var from_name = $('#contact_name').val();
  var from_mail = $('#contact_mail').val();
  var category = $('#contact_category').val();
  var subject = $('#contact_subject').val();
  var message = $('#contact_text').val();
  var frombool = true;
  var from_mailbool = true;
  var textbool = true;

/*$('#contact_submit_check').html('ftn: "contact",<br />Name: '+from_name+',<br />Mail: '+from_mail+',<br />Kategorie: '+category+',<br />Betreff: '+subject+',<br />Text: '+message);
$('#contact_submit_check').removeClass('invalid');
$('#contact_submit_check').addClass('valid');
$('#contact_submit_check').show();
$('#contact_submit_check').css({'display':'inline-block','line-height':'normal'});
*/
  if(from_name == '' || from_name === undefined) {
    $('#contact_name_check').html('Bitte gib einen Namen ein!');
    $('#contact_name_check').removeClass('valid');
    $('#contact_name_check').addClass('invalid');
    $('#contact_name_check').show();
    $('#contact_name_check').css({'display':'inline-block','line-height':'normal'});
    frombool = false;
  }
  else { $('#contact_name_check').html(''); $('#contact_name_check').removeClass('invalid'); $('#contact_name_check').addClass('valid'); $('#contact_name_check').hide(); frombool = true; }
  if(from_mail == '' || from_mail === undefined || !emailReg.test(from_mail)) {
    $('#contact_mail_check').html('Die E-Mail-Adresse ist ung&uuml;ltig!');
    $('#contact_mail_check').removeClass('valid');
    $('#contact_mail_check').addClass('invalid');
    $('#contact_mail_check').show();
    $('#contact_mail_check').css({'display':'inline-block','line-height':'normal'});
    from_mailbool = false;
  }
  else { $('#contact_mail_check').html(''); $('#contact_mail_check').removeClass('invalid'); $('#contact_mail_check').addClass('valid'); $('#contact_mail_check').hide(); from_mailbool = true; }
  if(message == '' || message === undefined) {
    $('#contact_submit_check').html('Bitte gib eine Nachricht ein!');
    $('#contact_submit_check').removeClass('valid');
    $('#contact_submit_check').addClass('invalid');
    $('#contact_submit_check').show();
    $('#contact_submit_check').css({'display':'inline-block','line-height':'normal'});
    textbool = false;
  }
  else { $('#contact_submit_check').html(''); $('#contact_submit_check').removeClass('invalid'); $('#contact_submit_check').addClass('valid'); $('#contact_submit_check').hide(); textbool = true; }

  if(frombool == true && from_mailbool == true && textbool == true) {
    $.ajax({
      type: 'POST',
      data: {
        fctn: 'contact',
        mod: 'mail',
        from_name: from_name,
        from_mail: from_mail,
        category: category,
        subject: subject,
        message: message},
      url: '/mod/mail/functions.php',
      success: function(data) {
//console.log(data);
        var data_json = JSON.parse(data);
        if(data_json['error'] == null) {
          $('#contact_submit_check').html(data_json['success']);
          $('#contact_submit_check').removeClass('invalid');
          $('#contact_submit_check').addClass('valid');
          $('#contact_form').html('<p class="valid"> Vielen Dank.<br />Deine Anfrage wurde erfolgreich versandt.</p>');
        }
        else {
          $('#contact_submit_check').html(data_json['error']);
          $('#contact_submit_check').removeClass('valid');
          $('#contact_submit_check').addClass('invalid');
        }
        $('#contact_submit_check').show();
        $('#contact_submit_check').css({'display':'inline-block','line-height':'normal','vertical-align':'top'});
      },
      error: function() {
        $('#contact_submit_check').html('Fehler bei der Verarbeitung!');
        $('#contact_submit_check').removeClass('valid');
        $('#contact_submit_check').addClass('invalid');
        $('#contact_submit_check').show();
        $('#contact_submit_check').css({'display':'inline-block','line-height':'normal'});
      }
    });
  }
}
