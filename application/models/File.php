<?php

require_once 'SuresyModel.php';

class File extends SuresyModel {

  public $file_id;
  public $user_id;
  public $filename;
  public $path;
  public $size;
  public $created;
  public $url;
  public $doc_type;
  public $mime;
  public $original_filename;
  public $description;
  public $claim_id;
  public $hash;
  
	public function __construct()
  {
    parent::__construct();
    $this->tablename = 'files';
    $this->datecreatedkey = 'created';
    $this->primarykey = "file_id";
  }
  
  public function insert ($data=NULL)
  {
    $this->hash = substr(md5($this->url),0,10);
    return parent::insert($data);
  }
}
