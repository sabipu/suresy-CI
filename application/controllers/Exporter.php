<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'SuresyController.php';


class Exporter extends SuresyController {

  public function __construct()
  {
    error_reporting(0);

    parent::__construct();
    $this->load->model('CalcRate');
    $this->load->model('CalcPromocode');
        
  }
  
  
  public function exportCSV ()
  {
    $download = true;
    $this->load->dbutil();

    $query = $this->db->query("SELECT 
    policy_data_id, 
    quote_status, 
    is_policy, 
    user_id, 
    num_quotes, 
    CONVERT_TZ(quote_date,'+00:00','+8:00') as 'quote_date', 
    quoted_annual_premium, 
    annual_gst, 
    annual_stamp_duty, 
    annual_net_premium, 
    quoted_monthly_premium, 
    monthly_gst, 
    monthly_stamp_duty, 
    monthly_net_premium,
    CONVERT_TZ(policy_start_date,'+00:00','+8:00') as 'policy_start_date', 
    first_name, 
    last_name, 
    email, 
    address, 
    address_street, 
    suburb, 
    postcode, 
    state, 
    city, 
    country, 
    birthday, 
    burglar_alarm, 
    dog, housemates, 
    cover_type, 
    cover_household, 
    cover_electronics, 
    cover_jewellery, 
    cover_sports, 
    cover_total, 
    policyholder_age, 
    excess, 
    promo_code, 
    gross_written_premium, 
    earned_premium, 
    average_written_premium, 
    average_earned_premium, 
    total_claims, 
    accidental_damage_claims, 
    fire_claims, 
    theft_claims, 
    total_cost_of_claims, 
    CONVERT_TZ(date_created,'+00:00','+8:00') as 'date_created',
    CONVERT_TZ(date_updated,'+00:00','+8:00') as 'date_updated', 
    last_completed_step, 
    payment_method, 
    email_sent, 
    kfs_link, 
    pds_link,
    CONVERT_TZ(billing_start_date,'+00:00','+8:00') as 'billing_start_date' 
     
    FROM policies_data ORDER BY policy_data_id ASC");

    if($download)
    {
      header("Content-type: text/csv");
      header("Cache-Control: no-store, no-cache");
      header('Content-Disposition: attachment; filename="policies_'.date("d_m_Y_H_i_s").'.csv"');
    }



    echo $this->dbutil->csv_from_result($query);
    
    
    
    if($download) $file = fopen('php://output','w');
    
  }
}
  

