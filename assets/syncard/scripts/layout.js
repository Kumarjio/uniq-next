$( document ).ready(function() {
    $(".button-menu").unbind().on('click', function() { side_nav_toggle(); });
    $(".dropdown-button").dropdown();
    $('select').material_select();
    $('.operation-modal').modal();

    $('.date-picker').pickadate({
      format: 'dd-mm-yyyy',
      selectMonths: true, // Creates a dropdown to control month
      selectYears: 15, // Creates a dropdown of 15 years to control year,
      today: 'Today',
      clear: 'Clear',
      close: 'Ok',
      closeOnSelect: false // Close upon selecting a date,
    });

    $('.timepicker').pickatime({
      default: 'now', // Set default time: 'now', '1:30AM', '16:30'
      fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
      twelvehour: false, // Use AM/PM or 24-hour format
      donetext: 'OK', // text for done-button
      cleartext: 'Clear', // text for clear-button
      canceltext: 'Cancel', // Text for cancel-button
      autoclose: false, // automatic close timepicker
      ampmclickable: true, // make AM PM clickable
      aftershow: function(){} //Function for after opening timepicker
    });
});

// SIDE NAV
function side_nav_toggle(){
  if($('#slide-out').hasClass('active')) $('#slide-out').addClass('hide').removeClass('active');
  else $('#slide-out').removeClass('hide').addClass('active');
}
