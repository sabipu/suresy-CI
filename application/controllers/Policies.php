<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'SuresyController.php';



class Policies extends SuresyController {
  public function view() {
    $user_id = $this->requireLogin();

    $this->load->model('User');
    $this->load->model('PolicyData');

    $vars = array();
    
    $this->vars('user', $this->user());
    $this->vars('policy', $this->PolicyData->getPolicyDataForUser($this->userId()));

    // setting up page heading
    $header_vars = array();
    $header_vars['page_title'] = 'Schedule';
    $str = $this->load->view('templates/banner', $header_vars, true);

    $vars['banner_template'] = $str;

    // queuing style files and script files
    $this->stylesheet('/css/policy.css');
    $this->script('/scripts/main.js');

    // main render file
    $this->render('policy/policy', $vars);
  }
  
  public function update() {
	$logged_user_id = $this->requireLogin();

    // models
    $this->load->model('User');
    $this->load->model('PolicyData');

    // policy update page with policy id
    $policy_data_id = $this->uri->segment(3);
    $foundPolicy = false;
    $policy_data_obj = NULL;
    $user = NULL;
    
    if($policy_data_id && is_numeric($policy_data_id )) {
      $policy_data_obj = $this->PolicyData->getByPolicyDataId($policy_data_id);
      
      $user = $this->User->getUserById($policy_data_obj->user_id);
      
/*
      echo "Logged in: $logged_user_id ";
      echo "<br>";
      var_dump($user);
      echo "<hr>";
      var_dump($policy_data_obj);
*/
      
/*
      if($logged_user_id != $policy_data_obj) {
	      show_404();
	      return;
      }
*/
      
      
      
      
      if($policy_data_obj)
      {
        $foundPolicy = true;
      }
    }

    if(!$foundPolicy) {
      show_404();
      exit();
    }
    
    $user = $user ? $user : $this->user();
    
    
    $vars = array();
    
    $this->vars('user', $user);
    $this->vars('policy', $policy_data_obj);
    
    // setting up page heading
    $header_vars = array();
    $header_vars['page_title'] = 'update/change policy';
    $str = $this->load->view('templates/banner', $header_vars, true);

    $vars['banner_template'] = $str;

    // queuing style files and script files
    $this->stylesheet('/css/policyupdate.css');
    $this->script('/scripts/lib/mustache.min.js');
    $this->script('/scripts/policyupdate.js');
    
    // main render file
    $this->render('policy/update', $vars);
  }
  
  public function allpolicies() {
	$user_id = $this->requireLogin();

    $this->load->model('User');
    $this->load->model('PolicyData');

    $vars = array();
    
    $this->vars('user', $this->user());
    $this->vars('policy', $this->PolicyData->getPolicyDataForUser($this->userId()));

    // setting up page heading
    $header_vars = array();
    $header_vars['page_title'] = 'All Policies';
    $str = $this->load->view('templates/banner', $header_vars, true);

    $vars['banner_template'] = $str;

    // queuing style files and script files
    $this->stylesheet('/css/all-policies.css');
    $this->script('/scripts/lib/list.min.js');
    $this->script('/scripts/all-policies.js');

    // main render file
    $this->render('policy/all-policies', $vars);
  }

  public function cancel() {
    
  }
  
  public function pause() {
    
  }
  
  public function download() {
    
  }
}