$(document).ready(function() {
  $('.modal').on('.modal-button', 'click', function() {
    $('.pwm-field-icon').addClass('is-inactive');
  });
  $('.modal').on('.modal-close', 'click', function() {
    $('.pwm-field-icon').removeClass('is-inactive');
  });
  $('.modal').on('.modal-button-close', 'click', function() {
    $('.pwm-field-icon').removeClass('is-inactive');
  });
  $('.modal').on('.modal-background', 'click', function() {
    $('.pwm-field-icon').removeClass('is-inactive');
  });
});

/* Cookie Disclaimer ******************************************************************************/
  $(document).ready(function() {
    var disclaimer = $('#popup_cookie');
  //  console.log(disclaimer);
  //  console.log(disclaimer.hasClass('is-active'));
    if(disclaimer.hasClass('is-active')) {
  //    console.log($('.pwm-field-icon'));
      $('.pwm-field-icon').addClass('is-inactive');
    };
    $('.cookie_button').on('click', function(event) {
      var cook = $(this).attr('cookie');
      var expiryDate = new Date();
      expiryDate.setMonth(expiryDate.getMonth() + 1)
      document.cookie = 'saverace_cookies='+cook+'; expires=' + expiryDate.toGMTString() + '; SameSite=None; Secure';
      $('#popup_cookie').removeClass('is-active');
      $('.pwm-field-icon').removeClass('is-inactive');
    });
  });



// Modals
  var rootEl = document.documentElement;
  var $modals = getAll('.modal');
  var $modalButtons = getAll('.modal-button');
  var $modalCloses = getAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button');
  if ($modalButtons.length > 0) {
    $modalButtons.forEach(function ($el) {
      $el.addEventListener('click', function () {
        var target = $el.dataset.target;
        openModal(target);
      });
    });
  }
  if ($modalCloses.length > 0) {
    $modalCloses.forEach(function ($el) {
      $el.addEventListener('click', function () {
        closeModals();
      });
    });
  }
  function openModal(target) {
    var $target = document.getElementById(target);
    rootEl.classList.add('is-clipped');
    $target.classList.add('is-active');
  }
  function closeModals() {
    rootEl.classList.remove('is-clipped');
    $modals.forEach(function ($el) {
      $el.classList.remove('is-active');
    });
  }
  document.addEventListener('keydown', function (event) {
    var e = event || window.event;
    if (e.keyCode === 27) {
      closeModals();
      closeDropdowns();
    }
  });
  
  // Functions
  function getAll(selector) {
    var parent = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : document;

    return Array.prototype.slice.call(parent.querySelectorAll(selector), 0);
  }