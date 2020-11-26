<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'SuresyController.php';


class Calculator extends SuresyController {

  public function __construct()
  {
    error_reporting(0);

    parent::__construct();
    $this->load->model('CalcRate');
    $this->load->model('CalcPromocode');
        
  }

  public function emailAvailable(){
    
    $policy = NULL;
    $user = NULL;
    $this->load->model('User');
    $this->load->model('PolicyData');
    $response = new stdClass();
    
    $email = $this->input->get_post('email');
    
    if($email)
    {
      $user = $this->User->findUserWithEmail($email);
      $policy = $this->PolicyData->getPolicyDataByEmail($email);
    }
    
    $response->exists = $user || $policy;
    $response->email = $email;
    
    
    echo $this->json($response);
    
    
  }
  public function postcodeAvailable() {
    
    $postcode = $this->input->get_post('postcode');
    $suburb = $this->input->get_post('suburb');
    $calc = false;
    $response = new stdClass();
    $response->postcode = $postcode;
    $response->suburb = $suburb;
    $response->available = false;
    if($postcode || $suburb)
    {
      $calc = $this->CalcRate->getRateForSuburbPostcode($postcode, $suburb);
    }
    $response->rate = $calc;
    
    if($calc && floatval($calc) > 0)
    {
      $response->available = true;
    }
    
    $this->output->set_header('Access-Control-Allow-Origin: *');

    echo $this->json($response);
    
  }
  public function quote($return=false, $raw_input=NULL) 
  {
 
    $this->load->helper('calculator');

    $response = new stdClass();
    $calculation = new stdClass();
    $calculation_steps = array();
    
    $calculation->adft = array();
    $calculation->ft = array();
    $calculation->to = array();
    $response->input = new stdClass();
    $response->quote = new stdClass();
    //     $response->query = new stdClass();
    
    if(!is_null($raw_input))
    {
      $response->input = $raw_input;
    }
    else
    {
      $response->input->cover_household_items =     $this->input->get_post('cover_household');
      
      $response->input->cover_household_items =     $response->input->cover_household_items ? $response->input->cover_household_items : $this->input->get_post('cover_household_items');

      $response->input->cover_electronics =         $this->input->get_post('cover_electronics');
      
      
      $response->input->cover_jewellery =           $this->input->get_post('cover_jewellery');
      $response->input->cover_jewellery =           $response->input->cover_jewellery ? $response->input->cover_jewellery : $this->input->get_post('cover_jewelry');


      $response->input->cover_sports =              $this->input->get_post('cover_sports');
      $response->input->security_dog =              yesOrNoToBOOL($this->input->get_post('security_dog'));
      $response->input->security_alarm =            yesOrNoToBOOL($this->input->get_post('security_alarm'));
      $response->input->security_housemates =       yesOrNoToBOOL($this->input->get_post('security_housemates'));
      $response->input->postcode =                  $this->input->get_post('postcode');
      $response->input->suburb =                    $this->input->get_post('suburb');
      $response->input->excess =                    $this->input->get_post('excess');
      $response->input->promocode =                 $this->input->get_post('promocode');
      $response->input->is_leap_year =              is_leap_year();
      $response->input->age =                       inputIntVal($this->input->get_post('age'));
      $response->input->birthday =                  $this->input->get_post('birthday');
    }

    if(!is_null($response->input->birthday))      $response->input->birthday_age = getAgeFromBirthday($response->input->birthday);
    if(!isset($response->input->birthday_age) || is_null($response->input->birthday_age))   $response->input->birthday_age = $response->input->age;    

    
    $rates = new stdClass();
    $rates->cover_household_items =               $this->CalcRate->getRateForCoverHousehold($response->input->cover_household_items);
    $rates->cover_electronics =                   $this->CalcRate->getRateForCoverElectronics($response->input->cover_electronics);
    $rates->cover_jewellery =                     $this->CalcRate->getRateForCoverJewellery($response->input->cover_jewellery);
    $rates->cover_sports =                        $this->CalcRate->getRateForCoverSports($response->input->cover_sports);
    $rates->security_dog =                        $this->CalcRate->getRateForDog($response->input->security_dog);
    $rates->security_alarm =                      $this->CalcRate->getRateForAlarm($response->input->security_alarm);
    $rates->security_housemates =                 $this->CalcRate->getRateForHousemates($response->input->security_housemates);
    $rates->postcode_suburb =                     $this->CalcRate->getRateForSuburbPostcode($response->input->postcode, $response->input->suburb);
    $rates->excess =                              $this->CalcRate->getRateForExcess($response->input->excess);
    $rates->is_leap_year =                        $this->CalcRate->getRateForLeapYear($response->input->is_leap_year);
    $rates->age =                                 $this->CalcRate->getRateForAge($response->input->birthday_age);
    $rates->promocode =                           $this->CalcPromocode->getRateForPromocode($response->input->promocode);
    $rates->gst =                                 $this->CalcRate->getRateForGST();
    $rates->stamp_duty =                          $this->CalcRate->getRateForStampDuty();

    $response->rates = $rates;

    $response->quote->anchor_adft =               $this->CalcRate->getAnchorRate('ADFT');
    $response->quote->anchor_ft =                 $this->CalcRate->getAnchorRate('FT');
    $response->quote->anchor_to =                 $this->CalcRate->getAnchorRate('TO');
    
    $calculation_steps[] = "Anchor Rate";
    
    $calculation->adft[] = $response->quote->anchor_adft;
    $calculation->ft[] = $response->quote->anchor_ft;
    $calculation->to[] = $response->quote->anchor_to;
    

    $response->quote->rate_adft =                 $response->quote->anchor_adft;
    $response->quote->rate_ft =                   $response->quote->anchor_ft;
    $response->quote->rate_to =                   $response->quote->anchor_to;
        
    $response->quote->rate_adft *=                $rates->cover_household_items;
    $response->quote->rate_ft *=                  $rates->cover_household_items;
    $response->quote->rate_to *=                  $rates->cover_household_items;   
    
    $step = "Household <em>(" . $rates->cover_household_items . ")</em>: ";
    $calculation_steps[] = $step;
    
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;
    
     

    $response->quote->rate_adft *=                $rates->cover_electronics;
    $response->quote->rate_ft *=                  $rates->cover_electronics;
    $response->quote->rate_to *=                  $rates->cover_electronics;    
    
    $step = "Electronics <em>(" . $rates->cover_electronics . ")</em>: ";
    $calculation_steps[] = $step;
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;
    

    $response->quote->rate_adft *=                $rates->cover_jewellery;
    $response->quote->rate_ft *=                  $rates->cover_jewellery;
    $response->quote->rate_to *=                  $rates->cover_jewellery;    
    
    
    $step = "Jewellery <em>(" . $rates->cover_jewellery . ")</em>: ";
    $calculation_steps[] = $step;
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;
    
    

    $response->quote->rate_adft *=                $rates->cover_sports;
    $response->quote->rate_ft *=                  $rates->cover_sports;
    $response->quote->rate_to *=                  $rates->cover_sports;
    
    $step = "Sports <em>(" . $rates->cover_sports . ")</em>: ";
    $calculation_steps[] = $step;
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;
    
    
    
    $response->quote->rate_adft *=                $rates->age;
    $response->quote->rate_ft *=                  $rates->age;
    $response->quote->rate_to *=                  $rates->age; 
    
    $step = "Age <em>(" . $rates->age . ")</em>: ";
    $calculation_steps[] = $step;
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;
    
    

    $response->quote->rate_adft *=                $rates->postcode_suburb;
    $response->quote->rate_ft *=                  $rates->postcode_suburb;
    $response->quote->rate_to *=                  $rates->postcode_suburb; 
    
    $step = "Suburb <em>(" . $rates->postcode_suburb . ")</em>: ";
    $calculation_steps[] = $step;
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;
    
    $response->quote->rate_adft *=                $rates->security_alarm;
    $response->quote->rate_ft *=                  $rates->security_alarm;
    $response->quote->rate_to *=                  $rates->security_alarm;
    
    $step = "Alarm <em>(" . $rates->security_alarm . ")</em>: ";
    $calculation_steps[] = $step;
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;
    
    $response->quote->rate_adft *=                $rates->security_dog;
    $response->quote->rate_ft *=                  $rates->security_dog;
    $response->quote->rate_to *=                  $rates->security_dog;   
    
    $step = "Dog <em>(" . $rates->security_dog . ")</em>: ";
    $calculation_steps[] = $step;
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to; 

    $response->quote->rate_adft *=                $rates->security_housemates;
    $response->quote->rate_ft *=                  $rates->security_housemates;
    $response->quote->rate_to *=                  $rates->security_housemates;    
    
    $step = "Housemates <em>(" . $rates->security_housemates . ")</em>: ";
    $calculation_steps[] = $step;
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;
    
    $response->quote->rate_adft *=                $rates->is_leap_year;
    $response->quote->rate_ft *=                  $rates->is_leap_year;
    $response->quote->rate_to *=                  $rates->is_leap_year;
    
    $step = "Leap Year <em>(" . $rates->is_leap_year . ")</em>: ";
    $calculation_steps[] = $step;
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;
    
    $response->quote->rate_adft *=                $rates->excess;
    $response->quote->rate_ft *=                  $rates->excess;
    $response->quote->rate_to *=                  $rates->excess;    
    
    $step = "Excess <em>(" . $rates->excess . ")</em>: ";
    $calculation_steps[] = $step;
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;

    $response->quote->rate_adft *=                $rates->promocode;
    $response->quote->rate_ft *=                  $rates->promocode;
    $response->quote->rate_to *=                  $rates->promocode;
    
    $step = "Promocode <em>(" . $rates->promocode . ")</em>: ";
    $calculation_steps[] = $step;
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;
    
    $response->quote->rate_adft *=                $rates->gst;
    $response->quote->rate_ft *=                  $rates->gst;
    $response->quote->rate_to *=                  $rates->gst;
    
    $step = "GST <em>(" . $rates->gst . ")</em>: ";
    $calculation_steps[] = $step;
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;
    
    $response->quote->rate_adft *=                $rates->stamp_duty;
    $response->quote->rate_ft *=                  $rates->stamp_duty;
    $response->quote->rate_to *=                  $rates->stamp_duty;
    
    $step = "Stamp Duty <em>(" . $rates->stamp_duty . ")</em>: ";
    $calculation_steps[] = $step;
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;
    
    
    if($response->input->cover_household_items == 0)
    {
      $response->quote->rate_adft = $response->quote->rate_adft - ($response->quote->anchor_adft * 0.25);
      $response->quote->rate_ft = $response->quote->rate_ft - ($response->quote->anchor_ft * 0.25);
      $response->quote->rate_to = $response->quote->rate_to - ($response->quote->anchor_to * 0.25);
      
      $step = "If Household is Zero (Rate - (Anchor *0.25)): ";
      $calculation_steps[] = $step;
      $calculation->adft[] = $response->quote->rate_adft;
      $calculation->ft[]   = $response->quote->rate_ft;
      $calculation->to[]   = $response->quote->rate_to;
      
    }

    
    $calculation_steps[] = "If Rate < MINIMUM (72, 36, 24): ";
    if($response->quote->rate_adft < 72)
    {
      $response->quote->rate_adft = 72;
      $step = "If Rate < MINIMUM (72): ";
      $calculation->adft[] = $response->quote->rate_adft;
      
    }
    else
    {
      $calculation->adft[]   = "";

    }
    
    
    if($response->quote->rate_ft < 36)
    {
      $response->quote->rate_ft = 36;
      
      $step = "If Rate < MINIMUM (36): ";
      $calculation->ft[]   = $response->quote->rate_ft;
      
      
    }
    else
    {
      $calculation->ft[]   = "";

    }
    if($response->quote->rate_to < 24)
    {
      $response->quote->rate_to = 24;
      
      $step = "If Rate < MINIMUM (24): ";
      $calculation->to[]   = $response->quote->rate_to;
    }
    else
    {
      $calculation->to[]   = "";

    }

/*
    $response->quote->rate_adft =                 round($response->quote->rate_adft, 5);
    $response->quote->rate_ft =                   round($response->quote->rate_ft, 5);
    $response->quote->rate_to =                   round($response->quote->rate_to, 5);
    
    $step = "Round to 5 decimal: ";
    $calculation_steps[] = $step;
    
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;
*/
    
/*
    $response->quote->rate_adft_monthly =         round($response->quote->rate_adft/12, 5);
    $response->quote->rate_ft_monthly =           round($response->quote->rate_ft/12, 5);
    $response->quote->rate_to_monthly =           round($response->quote->rate_to/12, 5);
*/
    
    $response->quote->rate_adft_monthly =         $response->quote->rate_adft/12;
    $response->quote->rate_ft_monthly =           $response->quote->rate_ft/12;
    $response->quote->rate_to_monthly =           $response->quote->rate_to/12;
    
    $step = "Monthly Rate (Rate/12): ";
    $calculation_steps[] = $step;
    
    $calculation->adft[] = $response->quote->rate_adft_monthly;
    $calculation->ft[]   = $response->quote->rate_ft_monthly;
    $calculation->to[]   = $response->quote->rate_to_monthly;

/*
    $response->quote->rate_adft_monthly_raw =     round($response->quote->rate_adft/12, 5);
    $response->quote->rate_ft_monthly_raw =       round($response->quote->rate_ft/12, 5);
    $response->quote->rate_to_monthly_raw =       round($response->quote->rate_to/12, 5); 
*/   

    $response->quote->rate_adft_monthly_raw =     $response->quote->rate_adft/12;
    $response->quote->rate_ft_monthly_raw =       $response->quote->rate_ft/12;
    $response->quote->rate_to_monthly_raw =       $response->quote->rate_to/12; 
    
    // if same value fix
    $rate_ft = round($response->quote->rate_ft_monthly, 0);
    $rate_to = round($response->quote->rate_to_monthly, 0);
    
    $response->quote->rate_to_same = false;

    if($rate_ft == $rate_to)
    {
      $response->quote->rate_to_same = true;
      $response->quote->rate_to_monthly = $response->quote->rate_ft_monthly - 1;
      
      $step = "If FT Rate Equals TO Rate (TO Rate - 1): ";
      $calculation_steps[] = $step;
      $calculation->to[]   = $response->quote->rate_to_monthly;
      $calculation->adft[]   = "";
      $calculation->ft[]   = "";
    
    }


    $response->quote->rate_adft = max(0, $response->quote->rate_adft);
    $response->quote->rate_ft = max(0, $response->quote->rate_ft);
    $response->quote->rate_to = max(0, $response->quote->rate_to);
    
    
    $step = "Rate Max(0, RATE): ";
    $calculation_steps[] = $step;
    
    $calculation->adft[] = $response->quote->rate_adft;
    $calculation->ft[]   = $response->quote->rate_ft;
    $calculation->to[]   = $response->quote->rate_to;
    
    
    
    
    
    $response->quote->rate_adft_monthly = max(0, $response->quote->rate_adft_monthly);
    $response->quote->rate_ft_monthly = max(0, $response->quote->rate_ft_monthly);
    $response->quote->rate_to_monthly = max(0, $response->quote->rate_to_monthly);
    
    $step = "Monthly Rate Max(0, RATE): ";
    $calculation_steps[] = $step;
        
    $calculation->adft[] = $response->quote->rate_adft_monthly;
    $calculation->ft[]   = $response->quote->rate_ft_monthly;
    $calculation->to[]   = $response->quote->rate_to_monthly;
    
    
    // round monthly values
    $response->quote->rate_adft_monthly_round = round($response->quote->rate_adft_monthly, 2);
    $response->quote->rate_ft_monthly_round = round($response->quote->rate_ft_monthly, 2);
    $response->quote->rate_to_monthly_round = round($response->quote->rate_to_monthly, 2);

/*
      $response->quote->rate_adft_monthly_round = $response->quote->rate_adft_monthly;
    $response->quote->rate_ft_monthly_round = $response->quote->rate_ft_monthly;
    $response->quote->rate_to_monthly_round = $response->quote->rate_to_monthly;
*/
    
    $step = "Monthly Rate Round (0 decimal): ";   
    $calculation_steps[] = $step;
     
    $calculation->adft[] = $response->quote->rate_adft_monthly_round;
    $calculation->ft[]   = $response->quote->rate_ft_monthly_round;
    $calculation->to[]   = $response->quote->rate_to_monthly_round;
    
    
    $round_num = 10;

/*
    $response->quote->rate_adft_monthly_stamp =   round($response->quote->rate_adft_monthly_round - ($response->quote->rate_adft_monthly_round / $rates->stamp_duty),$round_num);
    $response->quote->rate_ft_monthly_stamp =     round($response->quote->rate_ft_monthly_round - ($response->quote->rate_ft_monthly_round / $rates->stamp_duty), $round_num);
    $response->quote->rate_to_monthly_stamp =     round($response->quote->rate_to_monthly_round - ($response->quote->rate_to_monthly_round / $rates->stamp_duty), $round_num);
*/

    $response->quote->rate_adft_monthly_stamp =   ($response->quote->rate_adft_monthly_round - ($response->quote->rate_adft_monthly_round / $rates->stamp_duty));
    $response->quote->rate_ft_monthly_stamp =     ($response->quote->rate_ft_monthly_round - ($response->quote->rate_ft_monthly_round / $rates->stamp_duty));
    $response->quote->rate_to_monthly_stamp =     ($response->quote->rate_to_monthly_round - ($response->quote->rate_to_monthly_round / $rates->stamp_duty));
    
    $step = "Monthly Rate Stamp (Round 5) : ";  
    $calculation_steps[] = $step;
      
    $calculation->adft[] = $response->quote->rate_adft_monthly_stamp;
    $calculation->ft[]   = $response->quote->rate_ft_monthly_stamp;
    $calculation->to[]   = $response->quote->rate_to_monthly_stamp;
    
     
    
    $total_minus_stamp_adft = $response->quote->rate_adft_monthly_round - $response->quote->rate_adft_monthly_stamp;
    $total_minus_stamp_ft = $response->quote->rate_ft_monthly_round - $response->quote->rate_ft_monthly_stamp;
    $total_minus_stamp_to = $response->quote->rate_to_monthly_round - $response->quote->rate_to_monthly_stamp;
    
    
/*
    $response->quote->rate_adft_monthly_gst =     round($total_minus_stamp_adft - ($total_minus_stamp_adft / $rates->gst), $round_num);
    $response->quote->rate_ft_monthly_gst =       round($total_minus_stamp_ft - ($total_minus_stamp_ft / $rates->gst), $round_num);
    $response->quote->rate_to_monthly_gst =       round($total_minus_stamp_to - ($total_minus_stamp_to / $rates->gst), $round_num);
*/

    $response->quote->rate_adft_monthly_gst =     ($total_minus_stamp_adft - ($total_minus_stamp_adft / $rates->gst));
    $response->quote->rate_ft_monthly_gst =       ($total_minus_stamp_ft - ($total_minus_stamp_ft / $rates->gst));
    $response->quote->rate_to_monthly_gst =       ($total_minus_stamp_to - ($total_minus_stamp_to / $rates->gst));
    


    $step = "Monthly Rate GST (Round 5): ";   
    $calculation_steps[] = $step;
     
    $calculation->adft[] = $response->quote->rate_adft_monthly_gst;
    $calculation->ft[]   = $response->quote->rate_ft_monthly_gst;
    $calculation->to[]   = $response->quote->rate_to_monthly_gst;
    
    
//     $response->calculations = $calculation;
    
    
    if(!$return)
    {
      $this->output->set_header('Access-Control-Allow-Origin: *');
      $output = $this->json($response);
      if($this->input->get_post('pretty'))
      {
        $prices = "<ul><li>ADFT: ".$response->quote->rate_adft_monthly_round."</li>";
        $prices .= "<li>FT: ".$response->quote->rate_ft_monthly_round."</li>";
        $prices .= "<li>TO: ".$response->quote->rate_to_monthly_round."</li></ul>";
        
        $prices .= "<h5>Calculations</h5><table><tr class='headings'><td>Description</td><td></td><td>ADFT</td><td>FT</td><td>TO</td></tr>";
        
        $rows = "";
        $row = "";
        foreach($calculation_steps as $key=>$v)
        {
          
          $highlight = "Monthly Rate Round (0 decimal): " === $v ? 'highlight' : '';
          
          $row = "<tr class='".$highlight ."'>";
          
          $row .= "<td class='desc'>".$v."</td>";
          $row .= "<td></td>";
          $row .= "<td>".$calculation->adft[$key]."</td>";
          $row .= "<td>".$calculation->ft[$key]."</td>";
          $row .= "<td>".$calculation->to[$key]."</td>";
          
          $row .= "</tr>";
          
          $rows .= $row;
          
        }
        
        
        $prices .= $rows . "</table> <br /><br /><br /><br /> <hr>";
        
        
        
        $output = "<html><body><style type='text/css'>body { font-family: 'Helvetica', 'Arial', sans-serif; } td { border-bottom: 1px solid black; padding: 5px; } .headings td { font-weight: bold; } td.desc { color: blue; } td em { color: red; font-style: normal; font-weight: bold; } tr.highlight td { background: #ccc; } </style><h3>Response</h3>" .$prices ."<pre>" . $output . "</pre></body></html>";
      }
      $this->output->set_output($output);
    }
    return $response;
  }

  
  public function saveAjaxPolicyDataFromCalculator()
  {
    $this->load->model('PolicyData');
    $this->load->helper('names');
    $this->load->helper('calculator');
    $record = NULL;
    $policy_data_id = $this->input->get_post('policy_data_id');
    if(isset($policy_data_id))
    {
        $record = $this->db->get_where('policies_data', array('policy_data_id'=>$policy_data_id), 0, 1)->row(0,'PolicyData');
    }

    // receive input
    $input = $this->input->get_post('input');
    $data = array();
    // default values
    $data['date_created'] = date('Y-m-d H:i:s');
    $data['quote_date'] = date('Y-m-d H:i:s');

    // input values
    $data['last_completed_step'] = NULL;
    if(isset($input['last_completed_step'])) $data['last_completed_step'] = $input['last_completed_step'];


    if(isset($input['payment_response'])) $data['payment_response'] = json_encode($input['payment_response']);


    // step 1
    if(isset($input['name'])) {
        $name = split_name($input['name']);
        $data['first_name'] = $name[0];
        $data['last_name'] = $name[1];
    }
    if(isset($input['email'])) $data['email'] = $input['email'];
    if(isset($input['birthday'])) {
        $data['birthday'] = date('Y-m-d', strtotime($input['birthday']));
        $data['policyholder_age'] = getAgeFromBirthday($input['birthday']);
    }
    if(isset($input['age'])) {
        $data['policyholder_age'] = $input['age'];
    }

    // step 2
    if(isset($input['address_formatted'])) $data['address'] = $input['address_formatted'];
    if(isset($input['address_street'])) $data['address_street'] = $input['address_street'];
    if(isset($input['postcode'])) $data['postcode'] = $input['postcode'];
    if(isset($input['suburb'])) $data['suburb'] = $input['suburb'];
    if(isset($input['state'])) $data['state'] = $input['state'];
    if(isset($input['city'])) $data['city'] = $input['city'];
    if(isset($input['country'])) $data['country'] = $input['country'];

    $data['policy_start_date'] = date("Y-m-d H:i:s", time() + 60*60*24);
    if(isset($input['start_date']))
    {
      $data['policy_start_date'] = date("Y-m-d H:i:s", strtotime($input['start_date']));
      $billing_date_str = date("Y-m-d", strtotime($input['start_date']));
      $billing_date = date("Y-m-d H:i:s", strtotime($input['start_date']));

      if($billing_date_str == date("Y-m-d"))
      {
        $billing_date = date("Y-m-d H:i:s", strtotime($input['start_date']) + 24*60*60);
      }
      $data['billing_start_date'] = $billing_date;
    }


    
    // Step 3
    if(isset($input['security_alarm'])) $data['burglar_alarm'] = $input['security_alarm'];
    if(isset($input['security_dog'])) $data['dog'] = $input['security_dog'];
    if(isset($input['security_housemates'])) $data['housemates'] = $input['security_housemates'];

    // Step 4
    if(isset($input['cover_household'])) $data['cover_household'] = $input['cover_household'];
    if(isset($input['cover_electronics'])) $data['cover_electronics'] = $input['cover_electronics'];
    if(isset($input['cover_jewelry'])) $data['cover_jewellery'] = $input['cover_jewelry'];
    if(isset($input['cover_sports'])) $data['cover_sports'] = $input['cover_sports'];

    $cover_total = intval($input['cover_electronics']) + intval($input['cover_household']) + intval($input['cover_jewelry']) + intval($input['cover_sports']);
    $data['cover_total'] = $cover_total;

    // step 5
    if(isset($input['excess'])) $data['excess'] = $input['excess'];

    // get record from database for num_quote
    if($record && $data['last_completed_step'] == 'step5')
    {
        $nums = intval($record->num_quotes);
        $data['num_quotes'] = $nums+1;
    }

    // step 6
    $planType = false;
    if(isset($input['planType']) && $input['planType'] == 'premium') {
        $planType = 'ADFT';
    }elseif(isset($input['planType']) && $input['planType'] == 'normal') {
        $planType = 'FT';
    }elseif(isset($input['planType']) && $input['planType'] == 'basic') {
        $planType = 'TO';
    }
    if(isset($input['planType'])) $data['cover_type'] = $planType;
    $quote = false;
    $quote_input = false;
    // step 7
    if($planType)
    {
        $data['quote_status'] = 'quoted';
        $quote_input = new stdClass();

        $quote_input->cover_household_items =     isset($input['cover_household']) ? $input['cover_household'] : NULL;
        $quote_input->cover_electronics =         isset($input['cover_electronics']) ? $input['cover_electronics'] : NULL;
        $quote_input->cover_jewellery =           isset($input['cover_jewelry']) ? $input['cover_jewelry'] : NULL;
        $quote_input->cover_sports =              isset($input['cover_sports']) ? $input['cover_sports'] : NULL;
        $quote_input->security_dog =              yesOrNoToBOOL($input['security_dog']);
        $quote_input->security_alarm =            yesOrNoToBOOL($input['security_alarm']);
        $quote_input->security_housemates =       yesOrNoToBOOL($input['security_housemates']);
        $quote_input->postcode =                  isset($input['postcode']) ? $input['postcode'] : NULL;
        $quote_input->suburb =                    isset($input['suburb']) ? $input['suburb'] : NULL;
        $quote_input->excess =                    isset($input['excess']) ? $input['excess'] : NULL;
        $quote_input->promocode =                 isset($input['promocode']) ? $input['promocode'] : NULL;
        $quote_input->is_leap_year =              is_leap_year();
        $quote_input->age =                       inputIntVal($input['age']);
        $quote_input->birthday_age =              inputIntVal($input['age']);

        $quote_input->birthday =                  isset($input['birthday']) ? $input['birthday'] : NULL;

        $quote = $this->quote(true, $quote_input);

        $monthly_quote = 0;
        $gst_amount = 0;
        $stamp_amount = 0;

        if($planType == 'ADFT')
        {
            $monthly_quote = $quote->quote->rate_adft_monthly_round;
            $gst_amount = $quote->quote->rate_adft_monthly_gst;
            $stamp_amount = $quote->quote->rate_adft_monthly_stamp;
        }
        else if($planType == 'FT')
        {
            $monthly_quote = $quote->quote->rate_ft_monthly_round;
            $gst_amount = $quote->quote->rate_ft_monthly_gst;
            $stamp_amount = $quote->quote->rate_ft_monthly_stamp;
        }
        else if($planType == 'TO')
        {
            $monthly_quote = $quote->quote->rate_to_monthly_round;
            $gst_amount = $quote->quote->rate_to_monthly_gst;
            $stamp_amount = $quote->quote->rate_to_monthly_stamp;
        }
        $data['quoted_annual_premium'] = $monthly_quote * 12;
        $data['annual_gst'] = $gst_amount * 12;
        $data['annual_stamp_duty'] = $stamp_amount * 12;
        $data['annual_net_premium'] = $data['quoted_annual_premium'] - $data['annual_gst'] - $data['annual_stamp_duty'];

        $data['quoted_monthly_premium'] = $monthly_quote;
        $data['monthly_gst'] = $gst_amount;
        $data['monthly_stamp_duty'] = $stamp_amount;
        $data['monthly_net_premium'] = $data['quoted_monthly_premium'] - $data['monthly_gst'] - $data['monthly_stamp_duty'];
    }
    // $data['column_name'] = $quote->quote->

    // calculations
    // $response_to -> $this->quote->rate_to_monthly_round;
    // $response_ft -> $this->quote->rate_ft_monthly_round;
    // $response_adft -> $this->quote->rate_adft_monthly_round;

    $data['cover_sports'] = $input['cover_sports'];

    $action = 'insert';

    if($policy_data_id)
    {
        $policy_data_id = intval($policy_data_id);
        $action = 'save';
        $this->PolicyData->save(array('policy_data_id'=>$policy_data_id), $data);
    }
    else
    {
        $policy_data_id = $this->PolicyData->insert($data);
    }
    $query = $this->db->last_query();


//     echo $this->json(array('action'=>$action, 'id'=>$policy_data_id));

    echo $this->json(array('action'=>$action, 'id'=>$policy_data_id, 'input'=>$input));

//     echo $this->json(array('action'=>$action, 'record'=>$data, 'id'=>$policy_data_id, 'query'=>$query, 'input'=>$input, 'quote'=>$quote, 'quote_input'=>$quote_input));
  }
  
  function playground ()
  {
    error_reporting(0);
    $this->stylesheet('/css/playground.css', false);
    $this->script('/scripts/calc/playground.js', false);
    $this->render('calculator/playground');
  }
  
}