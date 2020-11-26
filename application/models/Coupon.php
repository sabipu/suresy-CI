<?php

require_once 'SuresyModel.php';

class Coupon extends SuresyModel {

  public $coupon_id;
  public $type = "fixed";
  public $coupon_frequency = "onetime";
  public $coupon_discount = 0;
  public $expiration_date;
  public $created;
  public $title;
  public $description;
  public $coupon_code;

	public function __construct()
  {
    parent::__construct();
      $this->tablename = 'coupons';
  }
}
?>