<?php

require_once 'SuresyModel.php';

class ClaimItem extends SuresyModel {

  public $claim_item_id;
  public $claim_id;
  public $item_name;
  public $item_price = 0;
  public $item_when;

	public function __construct()
  {
    parent::__construct();
    $this->tablename = 'claim_items';
    $this->primarykey = "claim_item_id";
  }
}
?>