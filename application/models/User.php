<?php

require_once 'SuresyModel.php';
require_once 'Policy.php';

class User extends SuresyModel {

  public $user_id;
  public $role = "customer";
  public $name;
  public $first_name;
  public $last_name;
  public $email;
  public $password;
  public $address;
  public $address_street;
  public $address_street2;
  public $city;
  public $suburb;
  public $postcode;
  public $state;
  public $country = "AU";
  public $phone;
  public $phone2;
  public $last_logged;
  public $created;
  public $modified;
  public $birthday;
  public $age;
  public $status;
  public $status_change_date;
  public $last_activity_date;
  public $fist_time_login = "yes";
  public $recovery_hash;
  public $recovery_date;
  public $approved_newsletter;

	public function __construct()
  {
    parent::__construct();
    $this->tablename = 'users';
  }
  
  public function getValidUser($email = NULL, $password = NULL)
  {
	  $CI =& get_instance();
	  $CI->load->helper('password');
	  
	  $this->db->from($this->tablename);
	  $this->db->where(array('email'=>$email));
	  $query = $this->db->get();	  
	  
    foreach ($query->result('User') as $user)
    {
	    $isPasswordCorrect = password_verify($password, $user->password);
	    if($isPasswordCorrect)
	    {
  	    return $user;
	    }
	  }
	  return NULL;
  }
  

  
  
  public function getUserById($user_id)
  {
    
    return $this->db->get_where($this->tablename, array('user_id'=>$user_id), 0, 1)->row(0, 'User');
    
  }
  
  public function getPolicy()
  {
    $policy = new Policy();
    return $this->db->get_where($policy->tablename, array('customer_user_id'=>$this->user_id), 0, 1)->row(0,'Policy');
  }
  
  public function login()
  {
	  
  }

  public function isDataValid($data=NULL)
  {
    $invalids = array();
    // check name
    // if(!$this->isValidMinLength($data['first_name'], 2)) $invalids['first_name'] = "Must be at least 2 characters";
    // if(!$this->isValidMinLength($data['last_name'], 2)) $invalids['last_name'] = "Must be at least 2 characters";
    // if(!$this->isValidRequired($data['birthdate'])) $invalids['birthdate'] = "This is required";
    // if(!$this->isValidDate($data['birthdate'])) $invalids['birthdate'] = "Must be a valid date";
    if(!$this->isValidRequired($data['email'])) $invalids['email'] = "This is required";
    if(!$this->isValidEmail($data['email'])) $invalids['email'] = "Must be a valid email";
    
    if(!$this->isValidRequired($data['phone'])) $invalids['phone'] = "This is required";
    if(!$this->isValidPhone($data['phone'])) $invalids['phone'] = "Must be a valid phone number";
    if(strlen($data['phone2']) > 0 && !$this->isValidPhone($data['phone2'])) $invalids['phone2'] = "Must be a valid phone number";

    
    // check password

    return array('valid'=>count($invalids) == 0 ? true : false, 'invalid'=>$invalids);
  }
  public function hasState()
  {
    $userdoesnthavestate = false;
                              if(!isset($this->state) || is_null($this->state) || (
                                $this->state != 'act' &&
                                $this->state != 'nsw' &&
                                $this->state != 'nt' &&
                                $this->state != 'qld' &&
                                $this->state != 'sa' &&
                                $this->state != 'tas' &&
                                $this->state != 'vic' &&
                                $this->state != 'wa'
                                ))
                              {
                                $userdoesnthavestate = true;
                              }

                              return !$userdoesnthavestate;



  }

  public function getName()
  {
	  return $this->name;
	  
  }

  public function findUserWithEmail($email = NULL) {
    return $this->db->get_where($this->tablename, array('email'=>$email, 'status'=>'active'), 0, 1)->row(0, 'User');
  }
  
  public function findUserWithHash($recovery_hash = NULL) {
    $user =  $this->db->get_where($this->tablename, array('recovery_hash'=>$recovery_hash), 0, 1)->row(0, 'User');
    if($user && time() < strtotime($user->recovery_date) + (24 * 60 * 60))
    {
      // if found user and not expired
      return $user;
    }
    else if($user)
    {
      // if found user but expired
      return false;
    }
    // if couldnt find user
    return NULL;
  }
  
}
?>