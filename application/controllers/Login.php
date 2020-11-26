<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'SuresyController.php';

class Login extends SuresyController {

  public function __construct() {
    parent::__construct();
    $this->stylesheet('/css/login.css');
  }
  


  public function index() {
    $this->load->model('User');
    $vars = array();
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $ref = $this->input->get_post('r');

    if(!$ref) $ref = "/dashboard";
    $vars['ref'] = $ref;
  

    if(!$email && !$password)
    {
       $this->session->sess_destroy();
    }
        
    if($this->session->has_userdata('user_logged')) {
      header("location: " . $ref);
      return;
    }
    
    
    if($email && $password) {
      $user = $this->User->getValidUser($email, $password);
      
/*
      echo $this->db->last_query();
      exit();
*/
      if($user) {
        $this->session->set_userdata('user_logged', $user->user_id);
        header("location: " . $ref);
      }
      else {
        $vars['invalid'] = true;
        $vars['error_message'] = "Invalid email/password";
      }
    }

    $this->header = '_base/login_header';
    $this->footer = '_base/login_footer';
    
    $this->script('/scripts/login.js');
    
    $this->render('login/login', $vars);
  }






  public function recover() {
    $this->load->model('User');
    $this->load->helper('password');
    
    $recovery_hash = $this->uri->segment(2);
    $user = $this->User->findUserWithHash($recovery_hash);
    $this->vars('recovery_hash', $recovery_hash);
    if($user === NULL)
    {
      show_error('Your password recovery link has expired. If you still want to reset your password, please goto the <a href="https://suresy.com.au/login/">forgot password link</a>.', 500, 'Recovery Link Expired');
      return;
    }
    else if($user===false)
    {
      header('Location: /login?msg=forgot_expired');
      return;
    }

    $password = $this->input->get_post('password');
    if($password)
    {
      $user->save(array("user_id"=>$user->user_id), array(
        'password'=>secured_hash($password), 
        'modified'=>date('Y-m-d H:i:s'), 
        'last_activity_date'=>date('Y-m-d H:i:s'),
        'recovery_hash'=>NULL,
        'recovery_date'=>NULL,
      ));
      header('Location: /login?msg=reset');
      exit();
    }

    $this->header = '_base/login_header';
    $this->footer = '_base/login_footer';

    $this->script('/scripts/recover.js');
    $this->render('login/recover');
  }

  public function forgot() {
    $this->load->model('User');



    $this->config->load('email');
    $config = $this->config->item('email');
    $this->load->library('email', $config);
          
          
    $vars = array();
    $queries = array();
    $email = $this->input->get_post('recover_email');

    // write code to find the user
    $user = $this->User->findUserWithEmail($email);
    if($user) {
      $recovery_hash = md5(time() . $user->email);

      $from = 'info@suresy.com.au';
      $fromName = 'Suresy';
      $to = $email;
      $subject = "Password Reset Link";
      $html_message = $this->load->view('emails/password_forgot_html', array(
        'user'=>$user,
        'recovery_hash'=>$recovery_hash,
      ), true);
      $alt_message = $this->load->view('emails/password_forgot_text', array(
        'user'=>$user,
        'recovery_hash'=>$recovery_hash,
      ), true);

      // send an email to $email
      $user->save(array("user_id"=>$user->user_id), array('recovery_hash'=>$recovery_hash, 'recovery_date'=>date('Y-m-d H:i:s')));



      $this->email->from($from, $fromName);
      $this->email->to($email);

      $this->email->subject($subject);
      $this->email->message($html_message);
      $this->email->set_alt_message($alt_message);

      $emailsent = $this->email->send();
      
      echo json_encode(array(
        'foundUser'=>true,
        'email'=>$email,
        'email_sent'=>$emailsent,
      ));
    }
    else
    {
        echo json_encode(array(
        'foundUser'=>false,
        'email'=>$email,
        'email_sent'=>false,
      ));
    }
  }
}
