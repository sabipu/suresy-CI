<?php 
if ( ! function_exists('split_name'))
{

  // uses regex that accepts any word character or hyphen in last name
  function split_name_old($name) {
      $name = trim($name);
      $first_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
      $last_name = trim( preg_replace('#'.$first_name.'#', '', $name ) );
      return array($first_name, $last_name);
  }
  

 function split_name($name) {
    $names = explode(" ", trim($name));
    $first_name = $names[0];
    $last_name = implode(" ", array_slice($names, 1));
    return array($first_name, $last_name);
  }

}
