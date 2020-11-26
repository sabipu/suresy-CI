<?php

require_once 'SuresyModel.php';

class UserBilling extends SuresyModel {

  public $user_billing_id;
  public $user_id;
  public $policy_id;
  public $cc_num;
  public $cc_exp_mon;
  public $cc_exp_yr;
  public $cc_cvv;
  public $cc_name;
  public $cc_type;
  public $cc_address;
  public $cc_address2;
  public $cc_suburb;
  public $cc_state;
  public $cc_postcode;
  public $cc_country;
  public $payment_type = "card";
  public $paypal_id;

	public function __construct()
  {
    parent::__construct();
      $this->tablename = 'user_billing';
  }
}
?>