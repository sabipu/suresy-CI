<?php 

if ( ! function_exists('is_leap_year'))
{
  function is_leap_year($year=NULL) {
    $year = is_null($year) ? idate('Y') : $year;
  	return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year % 400) == 0)));
  }
}


if ( ! function_exists('yesOrNoToBOOL'))
{
  function yesOrNoToBOOL($val=NULL) {
    if(is_null($val)) return false;
    $val = trim(strtolower($val));
  	return $val == 'yes' || $val == 'y' || $val == 'true';
  }
}

if ( ! function_exists('getAgeFromBirthday'))
{
  function getAgeFromBirthday($bdate=NULL)
  {
    if(is_null($bdate)) return 0;
    return date_diff(date_create($bdate), date_create('now'))->y;  
  }
}

if ( ! function_exists('inputIntVal'))
{
  function inputIntVal ($input=NULL)
  {
    if(is_null($input)) return NULL;
    return intval($input);
  }
}