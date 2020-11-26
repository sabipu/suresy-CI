<?php

require_once 'SuresyModel.php';

class CalcPromocode extends SuresyModel {

  public $calc_promocode_id;
  public $code;
  public $rate;
  public $enabled = 'no';
  public $modified;

  public function __construct()
  {
        parent::__construct();
      $this->tablename = 'calc_promocodes';
      $this->primarykey = "calc_promocode_id";
      $this->dateupdatedkey = "modified";
      
  }
  
  public function addCode($code, $rate=1.0, $enabled='no')
  {
    return $this->insert(array('code'=>$code, 'rate'=>$rate, 'enabled'=>$enabled, 'modified'=>date('Y-m-d H:i:s')));
    
  }
  
  public function getRateForPromocode($code=NULL)
  {
    if(is_null($code)) return 1.0;
    $res = $this->db->get_where($this->tablename, array('code'=>strtolower($code), 'enabled'=>'yes'), 1, 0)->row(0, 'CalcPromocode');
    if(!$res) return 1.0;
    return floatval($res->rate);
  }
  
  
}
?>