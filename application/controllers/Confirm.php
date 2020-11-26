<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'SuresyController.php';

class Confirm extends SuresyController {

  public function __construct() {
    parent::__construct();
    $this->stylesheet('/css/login.css');
  }

  public function success() {
    
    
    $should_debug = $this->input->get_post('debug');
    
    $vars = array();

    $this->load->model('User');
    $this->load->model('PolicyData');
    $this->load->helper('password');
    $this->load->helper('calculator');
		$this->config->load('server');
		$server_links = $this->config->item('server');

    //$this->vars('user', $this->user());

    // setting up page heading
    $header_vars = array();
    $header_vars['page_title'] = '';
    $str = $this->load->view('templates/banner', $header_vars, true);

    $vars['banner_template'] = $str;

    // lookup policy data

    $policy_data_id = $this->input->get('p');
    // echo $policy_data_id;
    $input_msg = $this->input->get('msg');
    if($input_msg)
    {
      $this->header = '_base/login_header';
      $this->footer = '_base/login_footer';
  
      // main render file
      $this->render('confirm/success', $vars);

    }
    else
    {

      $the_record = $this->PolicyData->getByPolicyDataId($policy_data_id);
  
      if($the_record && $the_record->policy_data_id !== NULL && $policy_data_id === $the_record->policy_data_id) {
  
        $policy_status = $the_record->is_policy;
        // echo $policy_status;
        
        
        
        
        
        
        if($policy_status === 'false') {
          //changes to policy data table
          $record = array();
          $record['is_policy'] = true;
          $record['quote_status'] = 'policy';
//           $record['policy_start_date'] = date('Y-m-d H:i:s');
          $record['payment_progress'] = 'success';
          $record['kfs_link'] = isset($server_links['kfs']) ? $server_links['kfs'] : 'https://www.suresy.com.au/key-facts-sheet/';
          $record['pds_link'] = isset($server_links['pds']) ? $server_links['pds'] : 'https://www.suresy.com.au/pds/';
  
          // create user record
          $newUserData = array();
          $newUserData['first_name'] = $the_record->first_name;
          $newUserData['last_name'] = $the_record->last_name;
          $newUserData['name'] = $the_record->first_name . ' ' . $the_record->last_name;
          $newUserData['email'] = $the_record->email;
          $password = generate_password(20);
          $newUserData['password'] = secured_hash($password);
          $newUserData['address'] = $the_record->address;
          $newUserData['address_street'] = $the_record->address_street;
          $newUserData['city'] = $the_record->city;
          $newUserData['suburb'] = $the_record->suburb;
          $newUserData['postcode'] = $the_record->postcode;
          $newUserData['state'] = $the_record->state;
          $newUserData['country'] = $the_record->country;
  
          $newUserData['created'] = $the_record->policy_start_date;
          $newUserData['modified'] = $the_record->policy_start_date;
  
          $birthday = $the_record->birthday;
          $newUserData['birthday'] = $birthday;
          $newUserData['age'] = $the_record->policyholder_age;
  
          $newUserData['status'] = 'active';
          $newUserData['status_change_date'] = $the_record->policy_start_date;
  
          // save
          $newUserId = $this->User->insert($newUserData);
          $record['user_id'] = $newUserId;
  
          // save record on policy data table
          $this->PolicyData->save(array("policy_data_id"=>$policy_data_id), $record);
  
  
          // send an email
          $email = $the_record->email;
          if($should_debug) echo 'to: ' . $email . '<br />';
          $user = $this->User->getUserById($newUserId);
          $this->vars('user', $user);
          

          $this->config->load('email');
          $config = $this->config->item('email');
          $this->load->library('email', $config);
          if($user) {
            if($should_debug) echo 'found user: <br />';
            $from = 'info@suresy.com.au';
            $fromName = 'Suresy';
            $to = $email;
            
            if($should_debug) var_dump('sending to email: ' . $email);
            
            
            $subject = "TEST - Congratulations on Signing Up";
            $html_message = $this->load->view('emails/signup_complete_html', array(
              'user'=>$user,
              'password'=>$password,
              'server'=>$this->vars['server']
            ), true);
            $alt_message = $this->load->view('emails/signup_complete_text', array(
              'user'=>$user,
              'password'=>$password,
              'server'=>$this->vars['server']
              
            ), true);
  
            $this->email->from($from, $fromName);
            $this->email->to($email);
            $this->email->bcc('travis@dilate.com.au');
  
            $this->email->subject($subject);
            $this->email->message($html_message);
            $this->email->set_alt_message($alt_message);
            
            $pds_path = FCPATH . "docs" . DIRECTORY_SEPARATOR . "suresy_pds.pdf";
            $kfs_path = FCPATH . "docs" . DIRECTORY_SEPARATOR . "suresy_kfs.pdf";
            
/*
            $this->email->attach($pds_path, 'attachment');
            $this->email->attach($kfs_path, 'attachment');
*/
            
            
            $wassent = $this->email->send(false);
            
            $email_response = $this->email->print_debugger(array('headers', 'subject', 'body'));
            
            
            if($should_debug) 
            {
  //             $email_response = $this->email->print_debugger(array('headers', 'subject', 'body'));
              echo 'was sent: ' . $wassent ? 'true' : 'false';
              echo '<br />----------------------<br /><br />Debug Info: <br /><br /><br /><br />';
              echo $email_response;
              
              exit();
            }
            
            $newdata = array();
            $newdata['email_sent'] = $wassent ? 'yes' : 'no';
            $newdata['email_debug'] = $email_response;
            
            if(isset($_POST['email_debug']))
            
            
            $this->PolicyData->save(array("policy_data_id"=>$policy_data_id), $newdata);
  
  
            
          }
        }
      }
      else
      {
        show_404();
        return;
      }
  
  
      header('Location: https://my.suresy.dilatedigital.com.au/quote/calculator/success?msg=thankyou');
      exit();
    }     
          
/*
    $this->header = '_base/login_header';
    $this->footer = '_base/login_footer';

    // // queuing style files and script files
    // $this->stylesheet('/css/dashboard.css');
    // $this->script('/scripts/main.js');

    // main render file
    $this->render('confirm/success', $vars);
*/
  }
}