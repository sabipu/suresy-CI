<?php

require_once 'SuresyModel.php';

class BillingHistoy extends SuresyModel {

  public $billinghistory_id;
  public $transaction_type = "invoice";
  public $amount;
  public $date;
  public $user_id;
  public $claim_id;
  public $policy_id;
  public $user_billing_id;
  public $status = "unpaid";
  public $decline_attempts = 0;
  public $response_data;

	public function __construct()
  {
    parent::__construct();
      $this->tablename = 'billinghistory';
  }
}
?>