jQuery(function() {
  initFormValidation();
});

function initFormValidation() {
  var validEmail = '^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$';
  var number = '^[0-9]+$';

  var formClass = jQuery('.form-validation'),
      inputClass = jQuery('.input');


  // check if input field need formValidation
  var ifNeedValidation = inputClass.attr('data-required', true);

  if(!ifNeedValidation) {
  }
  // get the fields

  // check type of field

  // cases
  // if select

  // if textarea

  // if checkbox

  // if radio
  // default text

  //Conditions for text///////////////
  // check text if email
  // check if it has required tag or not

  // check text if number 
  // check min and max

  // check if password
  // check if valid and force to put number alphabet uppercase

  //Conditions for select///////////////
  // if required has to select value

  //Conditions for text///////////////
  //check invalid characters
  // check min-max

  //submit handler
  // check success ajax

  /// remove error on focus
  //set form classes
}