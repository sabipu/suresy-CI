<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'SuresyController.php';


class Playground extends SuresyController {


  public function makePasswordTest()
  {
    $this->load->helper('password');
    
    $password = $this->input->get_post('password');
    
    
    
    echo $password . '<br />' . secured_hash($password);
    
    
    
    
  }
  
  public function debugInfo ()
  {
    print phpinfo();
    
    
  }
  
  
  public function email()
  {
    $this->load->model('User');
    $vars = array();
    $user = new User();
    $user->first_name = '{first_name}';
    $user->last_name = '{last_name}';
    $user->email = 'user@email.com';
    $vars['user'] = $user;
    $vars['recovery_hash'] = md5('sdfsdf');
    $vars['password'] = '{temp_password}';
    $vars['server'] = array();
    $vars['server']['website'] = 'http://suresy.com.au';
    $vars['server']['website'] = 'http://suresy.com.au';
    $vars['server']['mysuresy'] = "http://my.suresy.com.au/";    
    
    $template = $this->uri->segment(3);
    if(!file_exists(APPPATH . 'views/emails/'. $template . '.php'))
    {
      show_404();
      exit();
    }
    $this->load->view('emails/' . $template, $vars);
    
  }
  public function import()
  {
    
    $this->load->model('CalcRate');
    
    $json_filepath = '/Users/travis/Documents/Work/Suresy/suresyApp/data/rates.json';
    $json = file_get_contents($json_filepath);
    $out = array();
    $data = explode(",", $json);

    foreach($data as $v)
    {
      $i = explode(":", trim($v));
      if(!isset($i[0]) || !isset($i[1])) continue;
      $out[trim($i[0])] = trim($i[1]); 
    }
    print '<pre>';
    //print_r($out);
    $objid=1;
    foreach($out as $key=>$rate)
    {
      $obj = new CalcRate();
      
      $key = str_replace("'", '', $key);
      
      //$objid = $obj->addRate('cover_sports', $key, $rate);
      
      print '#' . $objid . ':  ' . $key . '= ' . $rate . '<br />';
      $objid++;
      
    }
    
    
  }
  
  
  public function importPostCodeCSV ()
  {
    $this->load->model('CalcRate');

    $contents = file_get_contents('/Users/travis/Documents/Work/Suresy/suresyApp/data/postcodes.csv');
    $result = explode(",,,,,,,,,,,,", $contents);
    print '<pre>';
    
    $result = array_map('trim', $result);
    
    $x = 0;
    foreach($result as $row)
    {
      $row_array = array_filter(array_map('trim', explode(',', $row)));
      if(!count($row_array) || $row_array[0] == 'Suburb') continue;
      
     // print_r($row_array);
      
      $c = new CalcRate();
      
      $rate = $row_array[1];
      if(strtolower($rate) == 'no quote') $rate = 0.0;
      
      $c->rate = floatval($row_array[1]);
      $c->type = 'postcode';
      $c->key = $row_array[2];
      $c->value = strtolower($row_array[0]);
      $c->modified = date('Y-m-d H:i:s');
      $c->insert();
      $x++;
    }
    
    print $x;
    
  }
  
  
}