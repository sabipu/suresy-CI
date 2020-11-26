jQuery(function() {
  initEditForm();
  initFormChange();
  initFormValidation();
});
var hasAddedPasswordRule = false;
function initFormValidation() {

  jQuery.validator.addMethod("phone", function(value, element) {
    return isValidPhone(value);
  }, "Please provide a valid phone number");
  
  jQuery.validator.addMethod("phoneifexists", function(value, element) {
    if(value && value.length > 0)
    {
      return isValidPhone(value);
    }
    return true;
  }, "Please provide a valid phone number");

  jQuery.validator.addMethod("password_valid", function(value, element) {
    return isValidPassword(value);
  }, "Passwords must include at least 8 lowercase and uppercase characters, 1 number, and 1 special character");

  $("#user_details_form").validate({
    rules: {
      'f-name': {
        required: true,
        minlength: 1
      },
      'l-name': {
        required: true,
        minlength: 1
      },
      'birth_date': {
        required: true,
        date: true
      },
      
      email: {
        required: true,
        email: true
      },
      phone: {
        required: true,
        minlength: 3,
        maxlength: 15,
        phone: true,
      },
      alt_phone: {
        minlength: 3,
        maxlength: 15,
        phoneifexists: true,
      },
    },
    messages: {
      'f-name': "Please enter your firstname",
      'l-name': "Please enter your lastname",
      birth_date: {
        required: "Please enter your birthday",
        date: "Your birthday must be a valid date"
      },
      email: {
        required: "Please provide your email address",
        email: "Please provide a valid email address"
      },
      phone: {
        required: "Please provide your phone number",
        phone: "Please provide a valid phone number"
      },
      alt_phone: {
        phoneifexists: "Please provide a valid phone number"
      },
      'new-pass': {
        minlength: 'Your password must be at least 8 characters.',
      },
      're-new-pass': {
        equalTo: 'Password doesn\'t match.',
      }
    }
  });

$('#new-pass').keyup(function (event){
    event.preventDefault();
    var l = $(this).val().length;
    if(hasAddedPasswordRule)
    {
      if(l==0)
      {
        // remove rule
        $( "#new-pass" ).rules("remove");
        hasAddedPasswordRule = false;
      }
    }
    else
    {
      if(l>0)
      {
        $( "#new-pass" ).rules( "add",{
          'password_valid': true,
        });

        hasAddedPasswordRule = true;

      }
    }
  });
}

function initEditForm() {
  jQuery('.btn__edit').click(function(e) {
    e.preventDefault();
    toggleEditModeState();
  });
}

function initFormChange() {
  var formData = getFormData();

  jQuery('.listener').blur(function (e) {
    e.preventDefault();
    var hasChanged = formHasChanged();
  });


  jQuery('.edit__submit').click(function (e) {
    e.preventDefault();
    var hasChanged = formHasChanged();

    if(!hasChanged) {
      showSuccessMessage();
      toggleEditModeState();
    }
    else
    {
      saveForm();
    }
  });

  jQuery('#user_details_form').submit(function (e) {
    e.preventDefault();
    saveForm();
  });

  function saveForm() {
    if(!$('#user_details_form').valid())
    {
      return showErrorMessage('Please fix the errors below and resubmit');
    }

    jQuery('#form_message').html('');
    var newData = getFormData();
    jQuery.ajax('/profile/update', {
      data: newData,
      dataType: 'json',
      type: 'GET',
      complete: function (response, status) {
        if(status == 'success') {
          if(typeof response.responseJSON != 'undefined')
          {
            if(response.responseJSON.valid === false)
            {
              showErrorMessage(response.responseJSON.message);
            }
            else
            {
              formData = newData;
              jQuery('#new-pass').attr('value', ' ');
              toggleEditModeState();
              showSuccessMessage();
            }
          }
        }
        else
        {
          showErrorMessage("Your information wasn't saved. Please contact support.");
        }
      }
    });
  }

  function showSuccessMessage()
  {
    jQuery('#user_details_form').addClass('message__active');
      jQuery('#form_message').html('<div class="success">Your information has been updated, Thank you!</div>');

      setTimeout(function() {
        jQuery('#form_message').fadeOut(750, function ()
        {
          jQuery('#form_message').html('').show();
          jQuery('#user_details_form').removeClass('message__active');
        });
      }, 3000);
  }

  function showErrorMessage(msg='Error')
  {
    jQuery('#user_details_form').addClass('message__active');
    jQuery('#form_message').html('<div class="error">'+msg+'</div>').show();
  }

  function formHasChanged () {
    // if form changed return true
    var currentFormData = getFormData();
    if(Object.keys(currentFormData).length != Object.keys(formData).length) return true;
    for(var key in formData) {
      if(typeof currentFormData[key] == 'undefined') return true;
      if(currentFormData[key] != formData[key]) return true;
    }
    return false;
  }

  function getFormData() {
    var formDataNew = {};
    var formArray = jQuery('#user_details_form').serializeArray();
    for(var key in formArray) {
      var obj = formArray[key];
      formDataNew[obj.name] = obj.value;
    }
    return formDataNew;
  }
}
function isValidPhone(phone)
{
  var re = /\D+/g;
  var cleanphone = phone.replace(re,"");

  // check length
  if (cleanphone.length < 10) return false;
  return true;
}

/**
 * Password validation RegEx for JavaScript
 * 
 * Passwords must be 
 * - At least 8 characters long, max length anything
 * - Include at least 1 lowercase letter
 * - 1 capital letter
 * - 1 number
 * - 1 special character => !@#$%^&*
 *
 * @author Harish Chaudhari <harishchaudhari.com>
 * 
 */
function isValidPassword(str)
{
  return /^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/.test(str);
}

function toggleEditModeState()
{
  var form = jQuery('#user_details_form');
  form.toggleClass('edit__active');
  if(form.hasClass('edit__active')) {
    jQuery('.btn__edit').text('Cancel');
    jQuery('.btn__edit').removeClass('is-link');
    jQuery('.btn__edit').addClass('is-dark');
  }else {
    jQuery('.btn__edit').text('Edit');
    jQuery('.btn__edit').removeClass('is-dark');
    jQuery('.btn__edit').addClass('is-link');
  }
}
