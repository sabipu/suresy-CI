<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'SuresyController.php';

class Dashboard extends SuresyController {
  public function index() {
    $user_id = $this->requireLogin();
    $this->load->model('Claim');
    $this->load->model('PolicyData');
    
    $vars = array();
    
    $this->vars('user', $this->user());
    $this->vars('claims', $this->Claim->getOpenClaimsForUser($user_id));
    $this->vars('policy', $this->PolicyData->getPolicyDataForUser($this->userId()));

    // setting up page heading
    $header_vars = array();
    $header_vars['page_title'] = 'dashboard';
    $str = $this->load->view('templates/banner', $header_vars, true);

    $vars['banner_template'] = $str;

    // queuing style files and script files
    $this->stylesheet('/css/dashboard.css');
    $this->script('/scripts/main.js');

    // main render file
    $this->render('dashboard/dashboard', $vars);
  }
}