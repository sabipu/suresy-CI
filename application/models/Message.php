<?php

require_once 'SuresyModel.php';

class Message extends SuresyModel {

  public $message_id;
  public $author_user_id;
  public $message;
  public $date;
  public $status;
  public $admin_private ="no";

	public function __construct()
  {
    parent::__construct();
      $this->tablename = 'messages';
  }
}
?>