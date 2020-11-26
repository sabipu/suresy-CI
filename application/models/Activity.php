<?php

require_once 'SuresyModel.php';

class Activity extends SuresyModel {

  public $activity_id;
  public $activity_description;
  public $data;
  public $date;
  public $user_id;
  public $action;
  public $object_id;

	public function __construct()
  {
    parent::__construct();
      $this->tablename = 'activity';
  }
}
?>