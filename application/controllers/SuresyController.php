<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'BaseController.php';

class SuresyController extends BaseController {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('User');
  }

  /**
  *
  * Requires user to be logged in, if they aren't it redirects them to login page
  *
  * @param    string  $url URL to be redirected to 
  * @return      int  Logged in user's id
  *
  */
  
  public function requireLogin($url=NULL)
  {
    if(!$this->session->has_userdata('user_logged'))
    {
      $this->logout(is_null($url) ? $this->uri->uri_string() : $url, NULL);     
    }
    return $this->userId();
    
  }
  
  
  public function userId()
  {
    return $this->session->userdata('user_logged'); 
  }
  
  public function user()
  {
    return $this->User->getUserById($this->userId());
  }


  
  
  public function logoutWithMsg()
  {
    $this->logout(NULL, 'logout');
  }
  
  public function logout ($url=NULL, $msg=NULL)
  { 
    $this->session->sess_destroy();
    $ref = $this->input->get('r') ? $this->input->get('r') : $url;
    $ref_param = $ref ? "?r=" . $ref : '';  
    if(!is_null($msg))
    {
      $ref_param .= ($ref_param != '' ? '&' : '?') . 'msg=' . $msg;
    }  
    header("location: /login" . $ref_param);
    exit();
  } 
}
