function formatDate(date, short_month) {
  var monthNames = undefined;
  if(typeof short_month == 'undefined' || !short_month)
  {
    monthNames = [
      "Jan", "Feb", "Mar",
      "Apr", "May", "Jun", "Jul",
      "Aug", "Sept", "Oct",
      "Nov", "Dec"
    ];
    
  }
  else {
    
    monthNames = [
      "January", "February", "March",
      "April", "May", "June", "July",
      "August", "September", "October",
      "November", "December"
    ];
  }

  var day = date.getDate();
  var monthIndex = date.getMonth();
  var year = date.getFullYear();

  return monthNames[monthIndex] + ' ' + day + ', ' + ' ' + year;
}

function parseDateInput(s) {
  var b = s.split(/\D/);
  return new Date(b[0], --b[1], b[2]);
}

