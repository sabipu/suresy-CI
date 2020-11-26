<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once 'SuresyController.php';
require_once(APPPATH .'libraries'.DIRECTORY_SEPARATOR.'fatzebra_scnet'.DIRECTORY_SEPARATOR . 'FatZebra.class.php');


/*
define("USERNAME", "SC-scnet");
define("TOKEN", "a5e39fa4dd713e37cb45726954e176d4");
define("TEST_MODE", true);
*/

define("USERNAME", "scnet-18052308");
define("TOKEN", "4e2456f5f4b501f52f738a845face660f938d970");
define("TEST_MODE", true);



class Billing extends SuresyController {

  public $fatZebra = NULL;
  public $reference = NULL;
  public $policy = NULL;

  public function __construct()
  {

    parent::__construct();
    $this->load->model('PolicyData');
    $this->fatZebra = new stdClass();


  }


  public function update()
  {

  }

  public function remove()
  {

  }

  public function add()
  {

  }

  public function history()
  {

  }


  public function testTransaction()
  {

    $cc = $this->input->get_post('cc');
    $cvv = $this->input->get_post('cc_cvv');
    $cc_mon = $this->input->get_post('cc_mon');
    $cc_year = $this->input->get_post('cc_year');
    $amount = $this->input->get_post('amount');

    $amount = floatval($amount) * 100;
    
    $card_holder = $this->input->get_post('cc_name');
    $card_expiry = $cc_mon . "/20" . $cc_year;
    $ip = $this->getUserIP();
    
    $test = strtolower($this->input->get_post('test')) == 'yes'; 



//     $service_url = 'https://gateway.sandbox.fatzebra.com.au/v1.0/purchases';
    $service_url = "https://gateway.fatzebra.com.au/v1.0/purchases";


    $datetime = new DateTime();

    $curl = curl_init($service_url);
    $curl_post_data = array( "card_holder" => $card_holder,
      "card_number" => $cc,
      "card_expiry" => $card_expiry,
      "cvv" => $cvv,
      "amount" => $amount,
      "reference" => $datetime->format('YmdHis'),
      "currency" => 'AUD' ,
      "customer_ip" => $ip,
      
    );
    if($test)
    {
      $curl_post_data['test'] = true;
    }
    $curl_json = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_USERPWD, USERNAME . ":" . TOKEN);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_json);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
      array('Content-Type:application/json')
    );
    $curl_response = curl_exec($curl);
    curl_close($curl);

    
    $output = $this->json(json_decode($curl_response));
    
    if($this->input->get_post('pretty'))
    {

      $extra = "";
      $output = "<html><body><style type='text/css'>body { font-family: 'Helvetica', 'Arial', sans-serif; } </style><h3>Response</h3>" .$extra ."<pre>" . $output . "</pre></body></html>";



    }
      
    $this->output->set_output($output);
      
    
  }

  public function playground()
  {
    error_reporting(0);
    $this->stylesheet('/css/playground.css', false);
    $this->script('/scripts/calc/playground.js', false);
    $this->render('billing/playground');

  }





  public function playground_submit ()
  {
    try {


      $this->getPolicyData();
    
      if(!$this->policy)
      {
        show_404();
        return;
      }
      $this->reference = "#" . $this->policy->policy_data_id . '-' . (time());
      $success = false;
      $reason = array();
  
/*
      $authorized = $this->authorizeOnlyTransaction();
      
      if($authorized)
      {
*/
  
         $this->fatZebra->customer = $this->setupCustomer();
    
         $reason = array_merge($reason, $this->fatZebra->customer->errors);
         if($this->fatZebra->customer->successful)
         {
           $this->fatZebra->plan = $this->setupPlanForSubscription();
           $reason = array_merge($reason, $this->fatZebra->plan->errors);
    
           if($this->fatZebra->plan->successful)
           {
             $success = true;
            }
           
         }
/*
       }
       else
       {
         $reason = array_merge($reason, $this->fatZebra->authorization->errors);
       }
*/
       $this->fatZebra->reference = $this->reference;
       
       $this->PolicyData->save(array('policy_data_id'=>$this->policy->policy_data_id), array('payment_response'=>json_encode($this->fatZebra)));
      














      $output = NULL;
      if($this->input->get_post('pretty'))
      {
        $output = $this->json(array('success'=>$success, 'reason'=>$reason , 'response'=>$this->fatZebra));

        $extra = "";
        $output = "<html><body><style type='text/css'>body { font-family: 'Helvetica', 'Arial', sans-serif; } </style><h3>Response</h3>" .$extra ."<pre>" . $output . "</pre></body></html>";



      }
      else
      {
        $output = $this->json(array('success'=>$success, 'reason'=>$reason , 'response'=>$this->fatZebra));
      }
      $this->output->set_output($output);
    }
    catch(Exception $ex) {
      print "Error: " . $ex->getMessage();
    }
  }


  public function authorizeOnlyTransaction()
  {
    
    $cc = $this->input->get_post('cc');
    $cvv = $this->input->get_post('cc_cvv');
    $cc_mon = $this->input->get_post('cc_mon');
    $cc_year = $this->input->get_post('cc_year');
    $card_holder = $this->input->get_post('cc_name');
    $amount = floatval($this->policy->quoted_monthly_premium) * 100;
    $card_expiry = $cc_mon . "/20" . $cc_year;
    $ip = $this->getUserIP();
    
    $test = strtolower($this->input->get_post('test')) == 'yes'; 
    $service_url = "https://gateway.fatzebra.com.au/v1.0/purchases";


    $datetime = new DateTime();

    $curl = curl_init($service_url);
    $curl_post_data = array( 
      "card_holder" => $card_holder,
      "card_number" => $cc,
      "card_expiry" => $card_expiry,
      "cvv" => $cvv,
      "amount" => $amount,
      "reference" => $this->reference . "_AUTH_" . time(),
      "currency" => 'AUD' ,
      "customer_ip" => $ip,
      "capture" => false,
      
    );
    if($test)
    {
      $curl_post_data['test'] = true;
    }
    $curl_json = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_USERPWD, USERNAME . ":" . TOKEN);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_json);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
      array('Content-Type:application/json')
    );
    $curl_response = curl_exec($curl);
    curl_close($curl);

    
    
    $this->fatZebra->authorization = json_decode($curl_response);
    
    return $this->fatZebra->authorization->successful && $this->fatZebra->authorization->response->successful;
    
    
  }

  public function setupCustomer()
  {
    $email = $this->policy->email;
    $reference = $this->reference;
    $first_name = ucfirst($this->policy->first_name);
    $last_name = ucfirst($this->policy->last_name);

    $cc = $this->input->get_post('cc');
    $cvv = $this->input->get_post('cc_cvv');
    $cc_mon = $this->input->get_post('cc_mon');
    $cc_year = $this->input->get_post('cc_year');
    $card_holder = $this->input->get_post('cc_name');
    $card_expiry = $cc_mon . "/20" . $cc_year;
    $ip_address = $this->getUserIP();
    $gateway = new FatZebra\Gateway(USERNAME, TOKEN, TEST_MODE);
    
    $this->fatZebra->customer_input = new stdClass();
    $this->fatZebra->customer_input->email = $email;
    $this->fatZebra->customer_input->first_name = $first_name;
    $this->fatZebra->customer_input->last_name = $last_name;
    $this->fatZebra->customer_input->reference = $reference;
    
    $extras = array();
    $extras['address']=array();
    $extras['address']['address'] = $this->policy->address_street;
    $extras['address']['city'] = $this->policy->suburb;
    $extras['address']['state'] = $this->policy->state;
    $extras['address']['postcode'] = $this->policy->postcode;
    $extras['address']['country'] = $this->policy->country;
    
    
    $customer_response = $gateway->create_customer($first_name, $last_name, $reference, $email, $card_holder, $cc, $card_expiry, $cvv, $ip_address, $extras);
    
    return $customer_response;
    
    
    
  }
  
  public function setupPlanForSubscription()
  {
    $premium_id = $this->policy->policy_data_id;
    $gateway = new FatZebra\Gateway(USERNAME, TOKEN, TEST_MODE);
    $name = "Suresy Insurance Premium";
    $customer = $this->fatZebra->customer->response->id;
    $payment_method = "Credit Card";
    $currency = "AUD";
    $setup_fee = 0;
    $amount = $this->policy->quoted_monthly_premium * 100;

    $total_count = 12;
    $total_amount = $amount * $total_count;
    $frequency = "Monthly";
    $reference = $this->reference;
    $description = $this->reference . ': ' . $this->policy->cover_type;
    $start_date = date("Y-m-d", strtotime($this->policy->policy_start_date));
    $anniversary = intval(date("d", strtotime($this->policy->policy_start_date)));

//     $plan_response = $gateway->create_plan($name, $amount, $reference, $description);
    
    $plan_response = $gateway->create_payment_plan($payment_method, $customer, $reference, $amount, $start_date, $frequency, $anniversary, $total_count, $total_amount, $currency, $setup_fee, $description);
    
    return $plan_response;
  }

  public function setupSubscription()
  {
    $gateway = new FatZebra\Gateway(USERNAME, TOKEN, TEST_MODE);
    $customer_id = $this->fatZebra->customer->response->id;
    $plan_id = $this->fatZebra->plan->response->id;
    $frequency = 'Monthly';
    $start_date = time() + 24*60*60;
    $reference = $this->reference;
    $is_active = true;

    $end_date = $start_date + 365*24*60*60;
    $sub_response = $gateway->create_subscription($customer_id, $plan_id, $frequency, $start_date, $reference, $is_active, $end_date);
    return $sub_response;

  }


  private function getUserIP()
  {
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
      $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
      $ip = $forward;
    }
    else
    {
      $ip = $remote;
    }

    return $ip;
  }
  private function getPolicyData ()
  {
    $policy_id = $this->input->get_post('policy_id');

    if(!$policy_id)
    {
      return;
    }
    $policy = $this->PolicyData->getByPolicyDataId($policy_id);

    $this->policy = $policy;
  }




  /*
  public function charge()
  {


      $cc = $this->input->post('cc');
      $cvv = $this->input->post('cc_cvv');
      $cc_mon = $this->input->post('cc_mon');
      $cc_year = $this->input->post('cc_year');
      $cc_holder = $this->input->post('cc_name');
      $amount = $this->input->post('amount');


      $exp = $cc_mon . "/20" . $cc_year;


     $service_url = 'https://gateway.sandbox.fatzebra.com.au/v1.0/purchases';

     $datetime = new DateTime();

     $curl = curl_init($service_url);
     $curl_post_data = array( "card_holder" => $cc_holder,
        "card_number" => $cc,
        "card_expiry" => $exp,
        "cvv" => $cvv,
        "amount" => $amount,
        "reference" => $datetime->format('YmdHis'),
        "currency" => 'AUD' ,
        "customer_ip" => $this->getUserIP()
       );
      $curl_json = json_encode($curl_post_data);
      curl_setopt($curl, CURLOPT_USERPWD, "SC-scnet" . ":" . "a5e39fa4dd713e37cb45726954e176d4");
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_json);
      curl_setopt($curl, CURLOPT_HTTPHEADER,
      array('Content-Type:application/json')
      );
      $curl_response = curl_exec($curl);
      curl_close($curl);

      return $curl_response;


  }
*/


}