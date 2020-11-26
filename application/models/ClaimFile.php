<?php

require_once 'SuresyModel.php';

class ClaimFile extends SuresyModel {

  public $claim_file_id;
  public $claim_id;
  public $file_id;

	public function __construct()
  {
    parent::__construct();
      $this->tablename = 'claim_files';
  }
}
?>