<?php

require_once 'SuresyModel.php';

class PolicyData extends SuresyModel {

  public $policy_data_id;
  public $quote_status = 'input';
  public $is_policy = 'false';
  public $user_id = NULL;
  public $num_quotes = 0;
  public $quote_date;
  public $quoted_annual_premium  = 0;
  public $annual_gst = 0;
  public $annual_stamp_duty = 0;
  public $annual_net_premium = 0;
  public $quoted_montly_premium = 0;
  public $monthly_gst = 0;
  public $monthly_stamp_duty = 0;
  public $monthly_net_premium = 0;
  public $policy_start_date = NULL;
  public $first_name = NULL;
  public $last_name = NULL;
  public $email;
  public $address = NULL;
  public $address_street = NULL;
  public $suburb = NULL;
  public $postcode = NULL;
  public $state = 'WA';
  public $city = NULL;
  public $country = 'AU';
  public $birthday = NULL;
  public $burglar_alarm = 'false';
  public $dog = 'no';
  public $housemates = 'no';
  public $cover_type = 'TO';
  public $cover_household = 0;
  public $cover_electronics = 0;
  public $cover_jewellery = 0;
  public $cover_sports = 0;
  public $cover_total = 0;
  public $policyholder_age = NULL;
  public $excess = 0;
  public $promo_code = NULL;
  public $gross_written_premium = 0;
  public $earned_premium = 0;
  public $average_written_premium = 0;
  public $average_earned_premium = 0;
  public $total_claims = 0;
  public $accidental_damage_claims = 0;
  public $fire_claims = 0;
  public $theft_claims = 0;
  public $total_cost_of_claims = 0;
  public $date_created;
  public $date_updated;
  public $last_completed_step;
  public $payment_method = 'cc';
  public $payment_progress = 'uncharged';
  public $payment_response;
  public $email_sent = 'no';
  public $email_debug = NULL;
  public $kfs_link = NULL;
  public $pds_link = NULL;
  public $billing_start_date;
  

  public function __construct() {
    parent::__construct();
    $this->tablename = 'policies_data';
    $this->primarykey = "policy_data_id";
    $this->datecreatedkey = "date_created";
    $this->dateupdatedkey = "date_updated";
  }

  public function getByPolicyDataId($policy_data_id = NULL) {
    if(is_null($policy_data_id) || !is_numeric($policy_data_id)) return false;
    return $this->db->get_where($this->tablename, array('policy_data_id'=>$policy_data_id), 0, 1)->row(0, 'PolicyData');
  }

  public function getPolicyDataByEmail($email)
  {
    
    return $this->db->get_where($this->tablename, array('email'=>$email), 0, 1)->row(0, 'PolicyData');
    
  }
  public function record() {
    
  }

  public function quote() {

  }

  public function getExpiryDate()
  {
    $starttime = strtotime($this->policy_start_date);

    $plusyear = $starttime + (365*24*60*60);

    $expireDate = date('Y-m-d H:i:s', $plusyear);

    return $expireDate;


  }

  public function makePolicy() {

  }

  public function getPolicyDataForUser($user_id=NULL) {
    if(is_null($user_id) || !is_numeric($user_id)) return false;
    return $this->db->get_where($this->tablename, array('user_id'=>$user_id),1, 0)->row(0,'PolicyData'); 

  }
}
?>