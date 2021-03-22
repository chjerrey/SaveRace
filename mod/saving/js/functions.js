$(function() {
  var date = new Date(), y = date.getFullYear(), m = date.getMonth();

  var options = {
    type: 'date',
    color: 'info',
    lang: 'de',
    dateFormat: 'YYYY-MM-DD',
    displayMode: 'dialog',
    showFooter: false,
    showButtons: false,
    enableMonthSwitch: false,
    enableYearSwitch: false,
    weekStart: 1,
    minDate: new Date(y, m, 1),
    maxDate: new Date(y, m + 1, 0)
  };
  // Initialize all input of type date
  var calendars = bulmaCalendar.attach('[type="date"]', options);

  if($('#saving_message').length > 0) {
    setTimeout(function() {
      $('#saving_message').fadeOut();
    }, 2000);
  }

});
