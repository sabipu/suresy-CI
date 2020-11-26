<?php

require_once 'SuresyModel.php';

class CalcRate extends SuresyModel {

  public $calc_rate_id;
  public $type;
  public $key;
  public $rate;
  public $modified;
  public $range;

  public function __construct()
  {
      parent::__construct();
      $this->tablename = 'calc_rates';
      $this->primarykey = "calc_rate_id";
      $this->dateupdatedkey = "modified";
  }
  
  public function addRate($type, $key, $rate)
  {
    return $this->insert(array('type'=>$type, 'key'=>$key, 'rate'=>$rate, 'modified'=>date('Y-m-d H:i:s')));
  }
  
  public function getAnchorRate($key='ADFT')
  {
    $key = strtolower($key);
    switch($key)
    {
      case 'adft':
      case 'ft':
      case 'to':  break;
      default:    return NULL;
    }
    $res = $this->db->get_where($this->tablename, array('type'=>'anchor', 'key' => $key), 1, 0)->row(0, 'CalcRate');
    if(!$res) return NULL;
    return floatval($res->rate);
  }

  public function getRateForExcess($input=NULL)
  {
    return $this->getRateByTypeAndKey('excess', $input);
  }
  public function getRateForCoverHousehold($input=NULL)
  {
    return $this->getRateByTypeAndRange('cover_household_items', $input);
  }
  
  public function getRateForCoverElectronics($input=NULL)
  {
    return $this->getRateByTypeAndRange('cover_electronics', $input);
  }
  
  public function getRateForCoverJewellery($input=NULL)
  {
    return $this->getRateByTypeAndRange('cover_jewellery', $input);
  }
  
  public function getRateForCoverSports($input=NULL)
  {
    return $this->getRateByTypeAndRange('cover_sports', $input);
  }
  
  public function getRateForDog($input=NULL)
  {
    if(!$input) return 1.0;
    return $this->getRateByTypeAndKey('security', 'dog');
  }
  
  public function getRateForAlarm($input=NULL)
  {
    if(!$input) return 1.0;
    return $this->getRateByTypeAndKey('security', 'alarm');
  }
  
  public function getRateForHousemates($input=NULL)
  {
    if(!$input) return 1.0;
    return $this->getRateByTypeAndKey('security', 'housemates');
  }
  
  public function getRateForLeapYear($input=NULL)
  {
    if(!$input) return 1.0;
    return $this->getRateByTypeAndKey('leap', 'yes');
  }
  
  public function getRateForAge($input=NULL)
  {
    return $this->getRateByTypeAndKey('age', $input);
  }
  
  public function getRateForSuburbPostcode($postcode=NULL, $suburb=NULL)
  {
    if(!$suburb && $postcode)
    {
      return $this->getRateByTypeAndKey('postcode', trim($postcode));
    }
    else if($suburb && !$postcode)
    {
      return $this->getRateByTypeAndValue('postcode', trim($suburb));
    }
    else if($postcode && $suburb)
    {
      return $this->getRateByTypeAndKeyAndValue('postcode', trim($postcode), trim($suburb), 0);
    }
    return 0;
  }
  
  public function getRateForGST()
  {
    return $this->getRateByTypeAndKey('gst', 'yes');
    
  }

  public function getRateForStampDuty()
  {
    return $this->getRateByTypeAndKey('stamp_duty', 'yes');
    
  }
  
  public function getRateByTypeAndKey($type=NULL, $key=NULL)
  {
    if(is_null($type) || is_null($key)) return 1.0;
    $this->db->where(array('type'=>strtolower($type), 'key' => strtolower($key)));
    $res = $this->db->get($this->tablename)->row(0, 'CalcRate');
    if(!$res) return 1.0;
    return floatval($res->rate);
  }

  public function getRateByTypeAndValue($type=NULL, $key=NULL)
  {
    if(is_null($type) || is_null($key)) return 1.0;
    $this->db->where(array('type'=>strtolower($type), 'value' => strtolower($key)));
    $res = $this->db->get($this->tablename)->row(0, 'CalcRate');
    if(!$res) return 1.0;
    return floatval($res->rate);
  }
  
  public function getRateByTypeAndKeyAndValue($type=NULL, $key=NULL, $key2=NULL, $default=1.0)
  {
    if(is_null($type) || is_null($key)) return 1.0;
    $this->db->where(array('type'=>strtolower($type), 'key' => strtolower($key), 'value' => strtolower($key2)));
    $res = $this->db->get($this->tablename)->row(0, 'CalcRate');
    if(!$res) return $default;
    return floatval($res->rate);
  }

  public function getRateByTypeAndRange($type=NULL, $value=NULL)
  {
    // if there's not a result, then check based on the range columns
    $value = floatval($value);
    $this->db->where(array('type'=>strtolower($type), 'range_min <'=> $value, 'range_max >='=>$value))->order_by('key', 'ASC');
    $res = $this->db->get($this->tablename)->row(0, 'CalcRate');
    if(!$res) return 1.0;
    return floatval($res->rate);
    
  }  
    
  
}
?>