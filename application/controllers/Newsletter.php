<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'SuresyController.php';

class Newsletter extends SuresyController {

  public function __construct() {
    parent::__construct();
  }
  
  
  public function subscribe()
  {
    $email = $this->input->get_post('email');
    
    $data['email'] = $email;
    
    $this->db->insert('newsletter', $data);
    
    echo $this->json($data);
    
  }
  
  
}