$(function() {
  initPasswordCheck();
});

function initPasswordCheck() {
  $('#password, #re-password').on('keyup', function () {
    if ($('#password').val() == $('#re-password').val()) {
      $('#message').html('Matching').css('color', 'green');
      $(':input[type="submit"]').prop('disabled', false);
      return;
    } else 
      $('#message').html('Not Matching').css('color', 'red');
      $(':input[type="submit"]').prop('disabled', true);
  });
}