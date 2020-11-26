<?php

require_once 'SuresyModel.php';

class Policy extends SuresyModel {

  public $policy_id;
  public $customer_user_id;
  public $quote_id;
  public $start_date;
  public $policy_type;
  public $amount;
  public $renewal_frequency = "annual";
  public $renewed_date;
  public $next_dew_date;
  public $number_of_renewals;
  public $policy_status = "paused";
  public $pdf_url;
  public $coupon_id;
  public $number_of_claims = 0;

	public function __construct()
  {
    parent::__construct();
    $this->tablename = 'policies';
  }
  
  public function startDate($format = 'd/m/Y', $default_val = NULL)
  {
    $time = strtotime($this->start_date);
    return date($format, time());
    
    
  }
  public function policyTypeTitle()
  {
    if($this->policy_type == 'FTD') return "Fire, Theft, Accidental Damage";
    if($this->policy_type == 'FT') return "Fire & Theft";
    return "Theft";

  }
}
?>