<?php

require_once 'SuresyModel.php';

class ClaimContact extends SuresyModel {

  public $claim_contact_id;
  public $claim_id;
  public $contact_type;
  public $contact_name;
  public $contact_phone;

  public $contact_user_id;
  public $police_incident_report_number;
  public $police_report_date;

  public function __construct()
  {
    parent::__construct();
    $this->tablename = 'claim_contacts';
    $this->primarykey = 'claim_contact_id';
  }
}
?>