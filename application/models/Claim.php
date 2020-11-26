<?php

require_once 'SuresyModel.php';

class Claim extends SuresyModel {

  public $claim_id;
  public $customer_user_id;
  public $policy_id;
  public $created_date;
  public $updated_date;
  public $claim_details;
  public $claim_type = "T";
  public $claim_status = "draft";
  public $claim_total;
  public $claim_date;


  public function __construct()
  {
        parent::__construct();
      $this->tablename = 'claims';
      $this->primarykey = "claim_id";
      $this->datecreatedkey = "created_date";
      $this->dateupdatedkey = "updated_date";
      
  }
  
  
  /**
  *
  * Get a Customer's Claims that are set to claim_status='open'
  *
  * @param    int  $user_id The user's id
  * @return      array of Claim model objects
  *
  */
  public function getOpenClaimsForUser($user_id=NULL)
  {
      $query = is_null($user_id) ? NULL : $this->db->get_where('claims', array('customer_user_id'=>intval($user_id), 'claim_status'=>'open'),0,10);
      return is_null($query) ? array() : $query->result('Claim');
  }

  public function getTypeTitle()
  {
      if($this->claim_type == 'T') {
        return 'Theft Claim';
      } elseif($this->claim_type == 'FT') {
        return 'Fire and Theft Claim';
      } elseif($this->claim_type == 'FTD') {
        return 'Accidental Damage Claim';
      }
      return 'Error Claim';
  }
  
  
}
?>