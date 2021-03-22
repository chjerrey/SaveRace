// The following code is based off a toggle menu by @Bradcomp
// source: https://gist.github.com/Bradcomp/a9ef2ef322a8e8017443b626208999c1
// modified for jQuery
$(document).ready(function() {
  var burger = $('.burger');
  var menu = $('#'+burger.attr('data-target'));
  burger.on('click', function() {
    burger.toggleClass('is-active');
    menu.toggleClass('is-active');
    $('.pwm-field-icon').toggleClass('is-inactive');
  });
});
