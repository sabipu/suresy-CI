<?php

require_once 'SuresyModel.php';

class Quote extends SuresyModel {

  public $quote_id;
  public $name;
  public $email;
  public $startdate;
  public $amount;
  public $type;
  public $created;
  public $data;
  public $coupon_input;
  public $coupon_id;
  public $user_id;
  public $policy_id;
  public $status;
  public $last_step;

	public function __construct()
  {
    parent::__construct();
      $this->tablename = 'quotes';
  }
}
?>