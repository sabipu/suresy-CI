$(function() {
  initForgotForm();
  initRecoverPassword();
  initNewLogin();
  initForgotExpired();
});

function initForgotExpired() {
  var traceMark = $(location).attr('search');

  if(traceMark == '?msg=forgot_expired') {
    $('.loginForm__wrapper').addClass('recover_active');
    $('.forgot__form>h2').html("Request new <mark>reset</mark> link.");
  }
}

function initNewLogin() {
  var traceMark = $(location).attr('search');

  if(traceMark == '?msg=reset') {
    $('.login__form .main-head').html("<mark>Login</mark> with new password.");
  }
}

function initForgotForm() {
  $('.forgot__button').click(function(e) {
    e.preventDefault();
    $('.loginForm__wrapper').toggleClass('recover_active');
  });
}

function initRecoverPassword() {
  $('.forgot__form').submit(function(e) {
    e.preventDefault();

    $('.loginForm__wrapper').addClass('loader_active');
    setTimeout(function() {
      $('.loginForm__wrapper').removeClass('loader_active');
    }, 3000);

    $.ajax({
      type: 'POST',
      url : '/forgot',
      data : {recover_email: $('#recover_email').val()},
      dataType : 'json',
      success : function(data, status, response) {
          if(data.foundUser) {
            $('.loginForm__wrapper').addClass('message__reveal');
            $('.btn-try').hide();
            $('.message-heading').html("<mark>Woohoo!</mark> Reset Link Send");
            $('.message-text').html("We have sent an email with the link to reset your password. Please check your email for instructions on how to reset your password.");
          }else
          {
            $('.loginForm__wrapper').addClass('message__reveal');
            $('.btn-login').hide();
            $('.message-heading').html("<mark>Ooopss!</mark> We Didn't Find You");
            $('.message-text').html("Sorry, we couldn't find an account with that email address. Please recheck your email address or contact support for further information.");
          }

      },
      error : function(data) {
          $('.loginForm__wrapper').addClass('message__reveal');
          $('.btn-login').hide();
          $('.message-heading').html("<mark>Yikees!</mark> Server Error");
          $('.message-text').html("Oops, something went wrong in the cloud. Please try again later and if that doesnot work contact our amazing support team.");
      }
    });
  });
}