<?php

require_once 'SuresyModel.php';

class ClaimMessage extends SuresyModel {

  public $claim_message_id;
  public $claim_id;
  public $message_id;

	public function __construct()
  {
    parent::__construct();
      $this->tablename = 'claim_messages';
  }
}
?>