<?php

class SuresyModel extends CI_Model {

  public $tablename = NULL;
  public $primarykey = NULL;
  public $datecreatedkey = NULL;
  public $dateupdatedkey = NULL;
  
	public function __construct()
  {
      parent::__construct();
      $this->load->database();
      if(!is_null($this->datecreatedkey)) $this->{$this->datecreatedkey} = date('Y-m-d H:i:s');
  }
  


  public function get_last_ten_entries()
  {
      return $this->db->get($this->tablename, 10)->result();
  }

  public function save($cond=NULL, $data=NULL)
  {
      if(is_null($cond)) return; else $this->db->where($cond);
      if(is_null($data))
      {
          $data = array();
          foreach($this as $key=>$value) $data[$key]=$value;
          $this->db->update($this->tablename, $this->cleanData($data));
      }
      else
      {
          $this->db->update($this->tablename, $data);
      }
      return $this;
  }
  
  public function insert($data=NULL)
  {
      if(is_null($data))
      {
          $data = array();
          foreach($this as $key=>$value) $data[$key]=$value;            
          $this->db->insert($this->tablename, $this->cleanData($data));
      }
      else
      {
          $this->db->insert($this->tablename, $data);
      }        
      return $this->db->insert_id();
  }
  
  public function cleanData($data=NULL)
  {
      unset($data['tablename']);
      unset($data['primarykey']);
      unset($data['datecreatedkey']);
      unset($data['dateupdatedkey']);
      if(!is_null($this->primarykey)) unset($data[$this->primarykey]);
      return $data;
  }
  public function delete($cond=NULL)
  {
    if(is_numeric($cond))
    {
      $ncond = array();
      $ncond[$this->primarykey] = $cond;
      $cond = $ncond;
    }
    if(is_null($cond)) return; else $this->db->where($cond);
    return $this->db->delete($this->tablename);
  }

  public function isDataValid($data=NULL)
  {
    return array('valid'=>true, 'invalid'=>false);
  }
  
  public function isValidRequired($value=NULL)
  {
    return !is_null($value) && strlen($value) > 0;
  }
  public function isValidMinLength($value=NULL, $length=0)
  {
    if(!$this->isValidRequired($value)) return false;
/*
print '<pre>';
    var_dump($value);
    var_dump($length);
    var_dump(strlen($value));
*/
    return strlen($value) >= $length;
  }
  public function isValidMaxLength($value=NULL, $length=0)
  {
    return strlen($value) <= $length;
  }
  public function isValidDate($value=NULL)
  {
    if(!$this->isValidRequired($value)) return false;
    return strtotime($value) ? true :  false;    
  }
  public function isValidEmail($value=NULL)
  {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }
  public function isValidPhone($value=NULL)
  {
    $newvalue = preg_replace("/[^0-9]/", '', $value);
      //if we have 10 digits left, it's probably valid.
    if (strlen($newvalue) < 10) return false;
    return true;
  } 
  public function isValidState($value=NULL)
  {
    $value = strtolower($value);
    if($value == 'wa') return true;
    if($value == 'vic') return true;
    if($value == 'act') return true;
    if($value == 'nsw') return true;
    if($value == 'nt') return true;
    if($value == 'qld') return true;
    if($value == 'sa') return true;
    if($value == 'tas') return true;    
    return false;
  }

  
}
?>