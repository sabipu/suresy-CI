jQuery(function() {
  initStepsControl();
})

function initStepsControl() {
  jQuery('.policy__update').stepControl({
    
    // startStep: 1,
    // currentStepIndex: 1,
    // totalSteps: 6,
    // prevButton: '.prev',
    // nextButton: '.next',
    // activeClass: 'step__active',
    // opener: '.opener1',
    // steps: '.js__step'
    // animSpeed: 400,
    // effect: 'slide'
  });
}

;(function($) {
  $.fn.stepControl = function( options ) {
      var settings = $.extend({
          // color: "#556b2f",
          backgroundColor: "white"
      }, options );

      return this.css({
          color: settings.color,
          backgroundColor: settings.backgroundColor
      });
  };
}(jQuery));



var startStep = 1;
var currentStepIndex = 1;
var totalSteps = 6;

function setupClaimFormSteps()
{
  $('#claim_next_step').click(function (e){
    e.preventDefault();
    nextClaimStep();
  });
  
  $('#claim_prev_step').click(function (e){
    e.preventDefault();
    previousClaimStep();
  });
}

function nextClaimStep()
{
  var nextStepIndex = currentStepIndex + 1;
  if(nextStepIndex > totalSteps)
  {
    return;
  }
  
  showClaimStep(nextStepIndex);
  
}

function previousClaimStep()
{
  var nextStepIndex = currentStepIndex - 1;
  if(nextStepIndex < startStep) { return; }
  
  showClaimStep(nextStepIndex);
  
}

function showClaimStep(index)
{
  if(index > startStep)
  {
    $('#claim_prev_step').show();
  }
  else
  {
    $('#claim_prev_step').hide();
  }
  if(index < totalSteps)
  {
    $('#claim_submit').hide();
    $('#claim_next_step').show();
  }
  else
  {
     $('#claim_next_step').hide();
     $('#claim_submit').show();
  }
  var target = '#claim_step' + index;
  
  $('.claim__step.active__step').removeClass('active__step').hide();
  $(target).addClass('active__step').show();
  currentStepIndex = index;
  
  switch (currentStepIndex) {
      case 1:
          claimStep1();
          break;
      case 2:
          claimStep2();
          break;
      case 3:
          claimStep3();
          break;
      case 4:
          claimStep4();
          break;
      case 5:
          claimStep5();
          break;
      case 6:
          claimStep6();
          break;
  }
  
}