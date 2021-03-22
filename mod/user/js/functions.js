var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,})?$/;

$(function() {
// CHANGE Mail
  $('body').on('focus', '.field_email', function() {
    $(this).removeClass('is-success').removeClass('is-danger')
      .siblings('.icon.is-right').children().hide();
  });
  $('body').on('change blur', '.field_email', function() {
    var value = getTrim($(this).val());
    $(this).val(value);
    var action = $(this).parents('form').find('.field_action').val();
    var user = $('#user').attr('data-user');
    getCheckMail(value, action, user);
  });
// CHANGE Username
  $('body').on('focus', '.field_username', function() {
    $(this).removeClass('is-success').removeClass('is-danger')
      .siblings('.icon.is-right').children().hide();
  });
  $('body').on('change blur', '.field_username', function() {
    var value = getTrim($(this).val());
    $(this).val(value);
    var action = $(this).parents('form').find('.field_action').attr('value');
    var user = $('#user').attr('data-user');
    getCheckUsername(value, action, user);
  });
// CHANGE Passwort
  $('body').on('focus', '.field_password', function() {
    $(this).removeClass('is-success').removeClass('is-warning').removeClass('is-danger')
      .siblings('.icon.is-right').children().hide();
  });
  $('body').on('change blur', '.field_password', function() {
    var action = $(this).parents('form').find('.field_action').attr('value');
    if(action == 'register') {
      passwordStrength($(this).val(), action);
      if($(this).parents('form').find('.field_password_repeat').val() != '') {
        getCheckPassword($(this).parents('form').find('.field_password_repeat').val(), 
                         $(this).val(), action);
      }
    }
  });
  $('body').on('focus', '.field_password_repeat', function() {
    $(this).removeClass('is-success').removeClass('is-danger')
      .siblings('.icon.is-right').children().hide();
  });
  $('body').on('change blur', '.field_password_repeat', function() {
    var action = $(this).parents('form').find('.field_action').attr('value');
    if(action == 'register') {
      getCheckPassword($(this).val(), 
                       $(this).parents('form').find('.field_password').val(), action);
    }
  });
// CHANGE Farbe
  $('body').on('change blur', '.field_color', function() {
    if($(this).prop('checked')) {
      $(this).parent('.switch-radio').addClass('is-success');
    }
    else {
      $(this).parent('.switch-radio').removeClass('is-success');
    }
  });
// CHANGE ANB
  $('body').on('change blur', '.field_anb', function() {
    if($(this).prop('checked')) {
      $(this).addClass('is-success');
    }
    else {
      $(this).removeClass('is-success');
    }
  });
});



// GET Mail valide
function getValidMail(container, mail) {
//  console.log('getValidMail('+container+', '+mail+')');
  var valid = false;
  if(mail == '' || !emailReg.test(mail)) {
    $(container+'.field_email').addClass('is-danger')
      .siblings('.icon.is-right').children('.fa-exclamation-triangle').show();
    valid = false;
  }
  else {
    $(container+'.field_email').addClass('is-success')
      .siblings('.icon.is-right').children('.fa-check').show();
    valid = true;
  }
//  console.log("\t"+valid);
  return valid;
}
// GET Mail vorhanden
function getCheckMail(mail, label, user) {
//  console.log('getCheckMail('+mail+', '+label+', '+user+')');
  var valid = getValidMail('#'+label+'_form ', mail);
  if(valid && 
     (label == 'register' || 
      label == 'profile')) {
    $('#'+label+'_form .field_email').removeClass('is-success').removeClass('is-danger')
      .siblings('.icon.is-right').children().hide();
    $.ajax({
      type: 'POST',
      data: {
        fctn: 'check_mail',
        mod: 'user',
        mailaddy: mail,
        user: user,
        action: label},
      url: '/mod/user/functions.php',
      success: function(data) {
        var data_json = JSON.parse(data);
//        console.log(data_json);
        if(data_json['error'] == null) {
          if(data_json['class'] == null) {
            $('#'+label+'_form .field_email').addClass('is-success')
              .siblings('.icon.is-right').children('.fa-check').show();
          }
          else {
            $('#'+label+'_form .field_email').addClass(data_json['class']);
          }
        }
        else {
          $('#'+label+'_form .field_email').addClass('is-danger')
            .siblings('.icon.is-right').children('.fa-exclamation-triangle').show();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          $('#'+label+'_form .field_email').addClass('is-danger')
            .siblings('.icon.is-right').children('.fa-exclamation-triangle').show();
      }
    });
  }
}

// GET Username vorhanden
function getCheckUsername(username, label, user) {
//  console.log('getCheckUsername('+username+', '+label+', '+user+')');
  if(username.length < 3) {
    $('#'+label+'_form .field_username').addClass('is-danger')
      .siblings('.icon.is-right').children('.fa-exclamation-triangle').show();
  }
  else {
    $.ajax({
      type: 'POST',
      data: {
        fctn: 'check_username',
        mod: 'user',
        username: username,
        user: user,
        action: label},
      url: '/mod/user/functions.php',
      success: function(data) {
        var data_json = JSON.parse(data);
        if(data_json['error'] == null) {
          if(data_json['class'] == null) {
            $('#'+label+'_form .field_username').addClass('is-success')
              .siblings('.icon.is-right').children('.fa-check').show();
          }
          else {
            $('#'+label+'_form .field_username').addClass(data_json['class']);
          }
        }
        else {
          $('#'+label+'_form .field_username').addClass('is-danger')
            .siblings('.icon.is-right').children('.fa-exclamation-triangle').show();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          $('#'+label+'_form .field_username').addClass('is-danger')
            .siblings('.icon.is-right').children('.fa-exclamation-triangle').show();
      }
    });
  }
}

// GET Passwörter identisch
function getCheckPassword(pw_copy, pw, label) {
//  console.log('getCheckPassword('+pw_copy+', '+pw+', '+label+')');
  if(pw == '' || pw_copy == '' || 
     !(pw_copy == pw)) {
    $('#'+label+'_form .field_password_repeat').addClass('is-danger')
      .siblings('.icon.is-right').children('.fa-exclamation-triangle').show();
  }
  else {
    $('#'+label+'_form .field_password_repeat').addClass('is-success')
      .siblings('.icon.is-right').children('.fa-check').show();
  }
}
/*function getCheckPasswordOld(pw, old, label) {
//console.log('getCheckPasswordOld('+pw+', '+old+', '+label+')');
  if(old == pw) {
    show_error(label, 'password_duplicate');
  }
  else {
    $('#'+label+'_password_duplicate_check').html('');
    $('#'+label+'_password_duplicate_check').removeClass('invalid');
    $('#'+label+'_password_duplicate_check').addClass('valid');
    $('#'+label+'_password_duplicate_check').hide();
  }
}
*/
// GET String ohne Leerzeichen
function getTrim(string) {
  string = string.replace(/\s+/g, '');

  return string;
}

// SET Login
/*function setLogin() {
  if(!$('#login_username').val() || !$('#login_password').val()) {
    removeRunner();
    $('#login_error').html('Bitte Hexennamen und Passwort angeben!');
    $('#login_error').removeClass('valid');
    $('#login_error').addClass('invalid');
    $('#login_error').show();
    $('#login_error').css({'display':'inline-block','line-height':'normal'});
  }
  else {
    var username = getTrim($('#login_username').val());
    var hash = $('#login_password').val();
    $('#login_error').html('');
    $('#login_error').hide();
    $.ajax({
      type: 'POST',
      data: {
        fctn: 'login',
        mod: 'user',
        user: username,
        pw: hash},
      url: '/mod/user/functions.php',
      success: function(data) {
        removeRunner();
//console.log(data);
        var data_json = JSON.parse(data);
        if(data_json['error'] == null) {
          $('#login_error').html(data_json['success']);
          $('#login_error').removeClass('invalid');
          $('#login_error').addClass('valid');
          $('#login_submit_saver').click();
          location.reload();
        }
        else {
          $('#login_error').html(data_json['error']);
          $('#login_error').removeClass('valid');
          $('#login_error').addClass('invalid');
        }
        $('#login_error').show();
        $('#login_error').css({'display':'inline-block','line-height':'normal'});
      },
      error: function() {
        removeRunner();
        $('#login_error').html('Fehler beim Login!');
        $('#login_error').removeClass('valid');
        $('#login_error').addClass('invalid');
        $('#login_error').show();
        $('#login_error').css({'display':'inline-block','line-height':'normal'});
      }
    });
  }
}
*/
// SET Logout
/*function setLogout() {
  $.ajax({
    type: 'POST',
    data: {
      fctn: 'logout',
      mod: 'user'},
    url: '/mod/user/functions.php',
    success: function(data) {
      removeRunner();
//console.log(data);
      var data_json = JSON.parse(data);
      if(data_json['error'] == null) {
        $('#loggedin_error').html(data_json['success']);
        $('#loggedin_error').removeClass('invalid');
        $('#loggedin_error').addClass('valid');
        window.location.href = window.location.pathname;
      }
      else {
        $('#loggedin_error').html(data_json['error']);
        $('#loggedin_error').removeClass('valid');
        $('#loggedin_error').addClass('invalid');
      }
      $('#loggedin_error').show();
      $('#loggedin_error').css({'display':'inline-block','line-height':'normal'});
    },
    error: function() {
      removeRunner();
      $('#loggedin_error').html('Fehler beim Logout!');
      $('#loggedin_error').removeClass('valid');
      $('#loggedin_error').addClass('invalid');
      $('#loggedin_error').show();
      $('#loggedin_error').css({'display':'inline-block','line-height':'normal'});
    }
  });
}
*/
// SET Profil Infos
/*function setUserProfileInfo(infos, label) {
  $.ajax({
    type: 'POST',
    data: {
      fctn: 'infos',
      mod: 'user',
      infos: infos},
    url: '/mod/user/functions.php',
    success: function(data) {
      removeRunner();
//console.log(data);
      var data_json = JSON.parse(data);
      if(data_json['error'] == null) {
        $('#edit'+label+'_check').html(data_json['success']);
        $('#edit'+label+'_check').removeClass('invalid');
        $('#edit'+label+'_check').addClass('valid');
        location.reload();
      }
      else {
        $('#edit'+label+'_check').html(data_json['error']);
        $('#edit'+label+'_check').removeClass('valid');
        $('#edit'+label+'_check').addClass('invalid');
      }
      $('#edit'+label+'_check').show();
      $('#edit'+label+'_check').css({'display':'block','line-height':'normal'});
    },
    error: function() {
      removeRunner();
      $('#edit'+label+'_check').html('Fehler beim Login!');
      $('#edit'+label+'_check').removeClass('valid');
      $('#edit'+label+'_check').addClass('invalid');
      $('#edit'+label+'_check').show();
      $('#edit'+label+'_check').css({'display':'block','line-height':'normal'});
    }
  });
}
*/
// SET Passwort
/*function setUserPassword(old, pass, label) {
  $.ajax({
    type: 'POST',
    data: {
      fctn: 'password',
      mod: 'user',
      old: old,
      pass: pass},
    url: '/mod/user/functions.php',
    success: function(data) {
      removeRunner();
//console.log(data);
      var data_json = JSON.parse(data);
      if(data_json['error'] == null) {
        $('#edit'+label+'_check').html(data_json['success']);
        $('#edit'+label+'_check').removeClass('invalid');
        $('#edit'+label+'_check').addClass('valid');
        location.reload();
      }
      else {
        $('#edit'+label+'_check').html(data_json['error']);
        $('#edit'+label+'_check').removeClass('valid');
        $('#edit'+label+'_check').addClass('invalid');
      }
      $('#edit'+label+'_check').show();
      $('#edit'+label+'_check').css({'display':'block','line-height':'normal'});
    },
    error: function() {
      removeRunner();
      $('#edit'+label+'_check').html('Fehler beim Login!');
      $('#edit'+label+'_check').removeClass('valid');
      $('#edit'+label+'_check').addClass('invalid');
      $('#edit'+label+'_check').show();
      $('#edit'+label+'_check').css({'display':'block','line-height':'normal'});
    }
  });
}
*/
// SET Einstellungen
/*function setUserProfileSetting(settings, label) {
  $.ajax({
    type: 'POST',
    data: {
      fctn: 'settings',
      mod: 'user',
      settings: settings},
    url: '/mod/user/functions.php',
    success: function(data) {
      removeRunner();
//console.log(data);
      var data_json = JSON.parse(data);
      if(data_json['error'] == null) {
        $('#settings'+label+'_check').html(data_json['success']);
        $('#settings'+label+'_check').removeClass('invalid');
        $('#settings'+label+'_check').addClass('valid');
        location.reload();
      }
      else {
        $('#settings'+label+'_check').html(data_json['error']);
        $('#settings'+label+'_check').removeClass('valid');
        $('#settings'+label+'_check').addClass('invalid');
      }
      $('#settings'+label+'_check').show();
      $('#settings'+label+'_check').css({'display':'block','line-height':'normal'});
    },
    error: function() {
      removeRunner();
      $('#settings'+label+'_check').html('Fehler beim Login!');
      $('#settings'+label+'_check').removeClass('valid');
      $('#settings'+label+'_check').addClass('invalid');
      $('#settings'+label+'_check').show();
      $('#settings'+label+'_check').css({'display':'block','line-height':'normal'});
    }
  });
}
*/
//DELETE User
/*function setUserDelete(mail, bday, pass, label) {
//console.log('setUserDelete('+mail+', '+bday+', '+pass+', '+label+')');
  $.ajax({
    type: 'POST',
    data: {
      fctn: 'delete',
      mod: 'user',
      mail: mail,
      bday: bday,
      pass: pass},
    url: '/mod/user/functions.php',
    success: function(data) {
      removeRunner();
//console.log(data);
      var data_json = JSON.parse(data);
      if(data_json['error'] == null) {
        $('#delete'+label+'_check').html(data_json['success']);
        $('#delete'+label+'_check').removeClass('invalid');
        $('#delete'+label+'_check').addClass('valid');
        location.reload();
      }
      else {
        $('#delete'+label+'_check').html(data_json['error']);
        $('#delete'+label+'_check').removeClass('valid');
        $('#delete'+label+'_check').addClass('invalid');
      }
      $('#delete'+label+'_check').show();
      $('#delete'+label+'_check').css({'display':'block','line-height':'normal'});
    },
    error: function() {
      removeRunner();
      $('#delete'+label+'_check').html('Fehler beim Login!');
      $('#delete'+label+'_check').removeClass('valid');
      $('#delete'+label+'_check').addClass('invalid');
      $('#delete'+label+'_check').show();
      $('#delete'+label+'_check').css({'display':'block','line-height':'normal'});
    }
  });
}
*/
// NEW User
/*function newUser() {
  var necessary = getNecessaryFull('register');
  if(necessary) {
    show_no_error('register', 'submit');

    var gender = $('.register_gender:checked').val();
    var users = '{"username":"'+getTrim($('#register_username').val())+'",';
    if($('#register_advertised').is(':checked')) {
        users += '"advertiser":"'+$('#register_advertiser option:selected').val()+'",';
    }
        users += '"password":"'+$('#register_password').val()+'",'
                +'"mail":"'+getTrim($('#register_mail').val())+'",'
                +'"birthday":"'+$('#register_birthday').val()+'",'
                +'"gender":"'+gender+'",'
                +'"country":"'+$('#register_country').val()+'"}';
//console.log(users);
    var users_infos = '';
    if($('#register_name').val() != '') {
      users_infos = '{"name":"'+$('#register_name').val()+'"}';
    }
//console.log(users_infos);
    var users_quests = '';
    if($('#register_introduction').val() == 1) {
      users_quests = '{"value":"'+$('#register_introduction_value').val()+'"}';
    }
//console.log(users_quests);
    var users_settings = '{"times_id":"'+$('.register_time:checked').val()+'",'
                   +'"weather_id":"'+$('.register_weather:checked').val()+'",'
                   +'"difficulties_id":"'+$('.register_difficulty:checked').val()+'"}';
//console.log(users_settings);
    var skin = $('#register_avatar_set .avatar .skin').attr('class').split(' ');
    var eyes = $('#register_avatar_set .avatar .eyes').attr('class').split(' ');
    var hair = $('#register_avatar_set .avatar .hair').attr('class').split(' ');
    var dress = $('#register_avatar_set .avatar .dress').attr('class').split(' ');
    var avatars = '{"skin":"'+skin[2].split(gender)[1]+'",'
                  +'"eyes":"'+eyes[2].split(gender)[1]+'",'
                  +'"hair":"'+hair[2].split(gender)[1]+'",'
                  +'"dress":"'+dress[2].split(gender)[1]+'",'
                  +'"color_skin":"'+skin[3].split('c')[1]+'",'
                  +'"color_eyes":"'+eyes[3].split('c')[1]+'",'
                  +'"color_hair":"'+hair[3].split('c')[1]+'",'
                  +'"color_dress":"'+dress[3].split('c')[1]+'"}';
//console.log(avatars);

    $.ajax({
      type: 'POST',
      data: {
        fctn: 'register',
        mod: 'user',
        users: users,
        users_infos: users_infos,
        users_quests: users_quests,
        users_settings: users_settings,
        avatars: avatars},
      url: '/mod/user/functions.php',
      success: function(data) {
//console.log(data);
        var data_json = JSON.parse(data);
        if(data_json['error'] == null) {
          $('#register_submit_check').html(data_json['success']);
          $('#register_submit_check').removeClass('invalid');
          $('#register_submit_check').addClass('valid');
          setSubmitDisable('register');
          $('#login_submit_saver').click();
        }
        else {
          $('#register_submit_check').html(data_json['error']);
          $('#register_submit_check').removeClass('valid');
          $('#register_submit_check').addClass('invalid');
        }
        $('#register_submit_check').show();
        $('#register_submit_check').css({'display':'block','line-height':'normal'});
      },
      error: function() {
        $('#register_submit_check').html('Fehler bei der Registrierung!');
        $('#register_submit_check').removeClass('valid');
        $('#register_submit_check').addClass('invalid');
        $('#register_submit_check').show();
        $('#register_submit_check').css({'display':'block','line-height':'normal'});
      }
    });
  }
  else {
    show_error('register', 'submit');
  }
}
*/

// Password strength meter
// This jQuery plugin is written by firas kassem [2007.04.05]
// Firas Kassem  phiras.wordpress.com || phiras at gmail {dot} com
// for more information : http://phiras.wordpress.com/2007/04/08/password-strength-meter-a-jquery-plugin/
function passwordStrength(pass, label) {
//  console.log('passwordStrength('+pass+', '+label+')');
  score = 0 
  
  //password < 7
  if (pass.length < 7 ) {
    $('#'+label+'_form .field_password').addClass('is-danger')
      .siblings('.icon.is-right').children('.fa-exclamation-triangle').show();
  }
  else {
    //password length
    score += pass.length * 7
    score += ( checkRepetition(1,pass).length - pass.length ) * 1
    score += ( checkRepetition(2,pass).length - pass.length ) * 1
    score += ( checkRepetition(3,pass).length - pass.length ) * 1
    score += ( checkRepetition(4,pass).length - pass.length ) * 1
    score += ( checkRepetition(5,pass).length - pass.length ) * 1
    score += ( checkRepetition(6,pass).length - pass.length ) * 1
    score += ( checkRepetition(7,pass).length - pass.length ) * 1

    //password has 3 numbers
    if (pass.match(/(.*[0-9].*[0-9].*[0-9])/))  score += 5 
    
    //password has 2 sybols
    if (pass.match(/(.*[!,@,#,$,%,^,&,*,?,_,~].*[!,@,#,$,%,^,&,*,?,_,~])/)) score += 5 
    
    //password has Upper and Lower chars
    if (pass.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  score += 10 
    
    //password has number and chars
    if (pass.match(/([a-zA-Z])/) && pass.match(/([0-9])/))  score += 15 
    //
    //password has number and symbol
    if (pass.match(/([!,@,#,$,%,^,&,*,?,_,~])/) && pass.match(/([0-9])/))  score += 15 
    
    //password has char and symbol
    if (pass.match(/([!,@,#,$,%,^,&,*,?,_,~])/) && pass.match(/([a-zA-Z])/))  score += 15 
    
    //password is just a nubers or chars
    if (pass.match(/^\w+$/) || pass.match(/^\d+$/) )  score -= 10 
    
    //verifing 0 < score < 100
    if ( score < 0 )  score = 0 
    if ( score > 100 )  score = 100 
    
    if (score < 34 ) {
      $('#'+label+'_form .field_password').addClass('is-danger')
      .siblings('.icon.is-right').children('.fa-exclamation-triangle').show();
    }
    else if (score < 68 ) {
      $('#'+label+'_form .field_password').addClass('is-warning')
            .siblings('.icon.is-right').children('.fa-check').show();
    }
    else {
      $('#'+label+'_form .field_password').addClass('is-success')
            .siblings('.icon.is-right').children('.fa-check').show();
    }
  }
}

function checkRepetition(pLen,str) {
  res = '';
  for ( i=0; i<str.length ; i++ ) {
      repeated=true
      for (j=0;j < pLen && (j+i+pLen) < str.length;j++)
          repeated=repeated && (str.charAt(j+i)==str.charAt(j+i+pLen))
      if (j<pLen) repeated=false
      if (repeated) {
          i+=pLen-1
          repeated=false
      }
      else {
          res+=str.charAt(i)
      }
  }
  return res
}

