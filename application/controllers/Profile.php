<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'SuresyController.php';



class Profile extends SuresyController {

  public function index() {
    $user_id = $this->requireLogin();
    
    $this->load->model('User');
    
    $vars = array();
    
    $this->vars('user', $this->user());

    // setting up loader
    $loader = $this->load->view('templates/loader', '', true);
    $vars['loader_template'] = $loader;

    // setting up page heading
    $header_vars = array();
    $header_vars['page_title'] = 'My Profile';
    $str = $this->load->view('templates/banner', $header_vars, true);

    $vars['banner_template'] = $str;

    // queuing style files and script files
    $this->stylesheet('/css/profile.css');
    $this->script('/scripts/lib/validation/jquery.validate.min.js');
    $this->script('/scripts/profile.js');
    
    // main render file
    $this->render('profile/profile', $vars);
  }

  public function update() {
    $this->load->model('User');
    $this->load->helper('password');

    // $fname = $this->input->get_post('f-name');
    // $lname = $this->input->get_post('l-name');
    $email = $this->input->get_post('email');
    // $birthday = $this->input->get_post('birth_date');
    $phone = $this->input->get_post('phone');
    $alt_phone = $this->input->get_post('alt_phone');
    $password = $this->input->get_post('new-pass');
    $re_password = $this->input->get_post('re-new-pass');


    $data = array();
    // $data['first_name'] = $fname;
    // $data['last_name'] = $lname;
    $data['email'] = $email;
    // $data['birthdate'] = $birthday;
    $data['phone'] = $phone;
    $data['phone2'] = $alt_phone;
    if($password && $re_password && $re_password === $password)
    {
      $data['password'] = secured_hash($password);

      $config = Array(
        // 'protocol' => 'smtp',
        // 'smtp_host' => 'ssl://smtp.googlemail.com',
        // 'smtp_port' => 465,
        // 'smtp_user' => 'user@gmail.com',
        // 'smtp_pass' => '',
        'mailtype'  => 'html',
        'charset' => 'utf-8',
        'wordwrap' => TRUE
      );
      $this->load->library('email', $config);

      $email = $this->user()->email;
      $user = $this->user();

      if($email) {
        $from = 'no-reply@suresy.com.au';
        $fromName = 'Suresy';
        $to = $email;
        $subject = "Password Reset Link";
        $html_message = $this->load->view('emails/password_changed_html', array(
          'user'=>$user
        ), true);
        $alt_message = $this->load->view('emails/password_changed_text', array(
          'user'=>$user
        ), true);

        $this->email->from($from, $fromName);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($html_message);
        $this->email->set_alt_message($alt_message);

        $this->email->send();
      }
    }
    $message = NULL;
    $isValidData = $this->User->isDataValid($data);
    $result = NULL;
    if($isValidData['valid'] === true)
    {
        $user_id = $this->userId();
        $result = $this->User->save(array("user_id"=>$user_id), $data);
    }
    else
    {
        $str = '';
        foreach($isValidData['invalid'] as $key=>$msg) $str .= $key . " - " . $msg . ", ";
        $message = 'Please fix the following errors: ' . $str;
    }
    echo json_encode(array('result'=>$result!=NULL && $result != false,
        'valid'=>$isValidData['valid'],
        'invalid'=>$isValidData['invalid'],
        'message'=>$message,
    ));

  }

  public function passwordChanged() {
    $this->load->model('User');
    $config = Array(
      // 'protocol' => 'smtp',
      // 'smtp_host' => 'ssl://smtp.googlemail.com',
      // 'smtp_port' => 465,
      // 'smtp_user' => 'user@gmail.com',
      // 'smtp_pass' => '',
      'mailtype'  => 'html', 
      'charset' => 'utf-8',
      'wordwrap' => TRUE
    );
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

  public function edit() {
    $user_id = $this->requireLogin();
    $this->load->model('User');
    $vars = array();


    $this->render('profile/update', $vars);
  }
}
