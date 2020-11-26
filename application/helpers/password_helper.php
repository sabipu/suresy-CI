<?php 
function generate_password($length = 20){
  $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.'0123456789!@#$%&*+';

  $str = '';
  $max = strlen($chars) - 1;

  for ($i=0; $i < $length; $i++)
    $str .= $chars[random_int(0, $max)];

  return $str;
}

function secured_hash($input)
{
  $output = password_hash($input,PASSWORD_DEFAULT);
  return $output;
}