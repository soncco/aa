$(document).ready(function() {

  // User dropdown.
  $('#user_dropdown').click(function() {
    ud = $(this)
    if(ud.find('.active').length == 0) {
      ud.find('.label').addClass('active');
      ud.find('.body').removeAttr('style');
    } else {
      ud.find('.label').removeClass('active');
      ud.find('.body').css('display','none');
    }
  });

  // DropKick.
  $('select').dropkick();

  // Message Box.
  if ($('#success_dialog').length > 0) {
    $('#messages').slideToggle('slow');
  }
  
  $('#messages .close_button').click(function (){
    $('#messages').slideToggle('fast');
  });

});