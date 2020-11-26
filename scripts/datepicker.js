function initDatePicker() {
  var dateToday = new Date();

  jQuery('.datepicker').datepicker({
    maxDate: "+30d",
    minDate: dateToday,
    beforeShow: function (input, inst) {
      var instHeight = 0;

      setTimeout(function () {
        instHeight = inst.dpDiv.height();
        if(input.getBoundingClientRect().top < instHeight) {
          inst.dpDiv
            .removeClass('ui-top')
            .addClass('ui-bottom')
            .position({
              my: 'left top+5',
              at: 'left bottom',
              collision: 'none',
              of: input
            })
        } else {
          inst.dpDiv
            .removeClass('ui-bottom')
            .addClass('ui-top')
            .position({
              my: 'left bottom-5',
              at: 'left top',
              collision: 'none',
              of: input
            })
        }
      },0);
    }
  });
}