<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once 'SuresyController.php';



class Claims extends SuresyController {
  // view all claims for a user
  public function __construct() {
    parent::__construct();
    $this->requireLogin();
  }

  public function index() {
    $user_id = $this->requireLogin();
    $this->load->model('Claim');

    $vars = array();

    $this->vars('claims', $this->Claim->getOpenClaimsForUser($user_id));
    $this->vars('user', $this->user());

    // setting up page heading
    $header_vars = array();
    $header_vars['page_title'] = 'Your claims';
    $str = $this->load->view('templates/banner', $header_vars, true);

    $vars['banner_template'] = $str;

    // queuing style files and script files
    $this->stylesheet('/css/claims.css');

    // main render file
    $this->render('claims/claims', $vars);
  }

  public function make() {
    $user = $this->user();
    $this->vars('user', $user);
    $this->vars('policy', $user->getPolicy());

    // setting up page heading
    $header_vars = array();
    $header_vars['page_title'] = 'Make a claim';
    $str = $this->load->view('templates/banner', $header_vars, true);

    $vars['banner_template'] = $str;

    // queuing style files and script files
    $this->stylesheet('/css/makeaclaim.css');
    $this->script('/scripts/lib/mustache.min.js');
    $this->script('/scripts/upload.js', false);
    $this->script('/scripts/util.js', false);
    $this->script('/scripts/claim_make.js', false);

    // main render file
    $this->render('claims/make', $vars);
  }

  public function make_new() {
    $this->load->model('File');
    $this->load->model('Claim');
    $this->load->model('ClaimItem');
    $this->load->model('ClaimContact');
    $this->load->model('ClaimFile');

    $data = $_GET + $_POST;


    $claim = new Claim();
    $new_claim_id = $this->input->get_post('claim_id');

    $data['input_claim_id'] = $new_claim_id;

    $new_claim_id = $new_claim_id ? (int)$new_claim_id : NULL;
    $data['input_claim_id_val'] = $new_claim_id;

    $action = $this->input->get_post('action');
    $claim_input = $this->input->get_post('claim');
    $claim_total = 0.00;

    $claim->claim_details = $claim_input['claim_description'];
    $claim->claim_type = $claim_input['claim_type'];
    $claim->policy_id = $claim_input['policy_no'];
    $claim->customer_user_id = $this->userId();
    $claim->claim_total = $claim_total;
    $claim->updated_date = date('Y-m-d H:i:s');
    $claim->created_date = date('Y-m-d H:i:s');
    $claim->claim_date = $claim_input['claim_incident_date'] . ' ' . $claim_input['claim_incident_time'];

    if($new_claim_id)
    {
      $claim->save(array('claim_id'=>$new_claim_id));
      $data['server_action'] = 'save';
    }
    else
    {
      $claim->created_date = date('Y-m-d H:i:s');
      $new_claim_id = $claim->insert();
      $data['server_action'] = 'insert';
    }

    if($action == 'insert')
    {
      $data['final_save'] = true;

      $dataKey = 'items';
      $data[$dataKey] = array();
      $claim_items = isset($claim_input[$dataKey]) && is_array($claim_input[$dataKey]) ? $claim_input[$dataKey] : false;
      if($claim_items && count($claim_items))
      {
        foreach($claim_items as $item)
        {
          $claimItem = new ClaimItem();
          $claimItem->item_name = $item['name'];
          $claimItem->item_price = $item['price'];
          $claimItem->item_when = $item['when'];
          $claimItem->claim_id = $new_claim_id;
          $data[$dataKey][] = $claimItem->insert();
        }
      }

      $dataKey = 'witness';
      $data[$dataKey] = array();
      $claim_witnesses = isset($claim_input[$dataKey]) && is_array($claim_input[$dataKey]) ? $claim_input[$dataKey] : false;
      if($claim_witnesses && count($claim_witnesses))
      {
        foreach($claim_witnesses as $item)
        {
          $claimWitness = new ClaimContact();
          $claimWitness->contact_name = $item['name'];
          $claimWitness->contact_phone = $item['phone'];
          $claimWitness->contact_type = $item['type'];
          $claimWitness->claim_id = $new_claim_id;
          $data[$dataKey][] = $claimWitness->insert();
        }
      }


      $dataKey = 'files';
      $data[$dataKey] = array();
      $claim_files = isset($claim_input[$dataKey]) && is_array($claim_input[$dataKey]) ? $claim_input[$dataKey] : false;
      if($claim_files && count($claim_files))
      {
        foreach($claim_files as $item)
        {
          $claimFile = new ClaimFile();
          $claimFile->file_id = $item['file_id'];
          $claimFile->claim_id = $new_claim_id;
          $data[$dataKey][] = $claimFile->insert();
        }
      }
    }

    $data['claim_id'] = $new_claim_id;

    echo json_encode($data);
  }

  public function make_upload() {
    $claim_id = $this->input->get_post('claim_id') ? $this->input->get_post('claim_id') : NULL;

    $uploaddir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR;

    $uploaddir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'claim_'.$claim_id . DIRECTORY_SEPARATOR;
    //    $uploaddir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'claim_'.$claim_id . DIRECTORY_SEPARATOR;

    /*
        if(!is_dir($uploaddir))
        {
          $made = mkdir($uploaddir, 755, true);
          $made = mkdir($uploaddir, 777, true);
          if(!$made)
          {
             $uploaddir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'other' . DIRECTORY_SEPARATOR;
          }
        }
    */

    $filename =  'claim_'.$claim_id . '_' . $_FILES['file']['tmp_name'];

    $config = array();
    $config['upload_path']          = $uploaddir;
    $config['allowed_types']        = 'gif|jpg|png|doc|pdf|txt|rtf|jpeg';
    $config['max_size']             = 100000;
    $config['max_width']            = 0;
    $config['max_height']           = 0;
    $config['file_ext_tolower']     = TRUE;

    $config['file_name']            = $filename;
    $this->load->library('upload', $config);
    $this->load->model('File');

    if ( ! $this->upload->do_upload('file'))
    {
      $error = array('error' => $this->upload->display_errors());
      echo json_encode($error);
    }
    else
    {
      $data = array('upload_data' => $this->upload->data());
      $data2 = $_GET + $_POST + $data;

      $file = new file();
      $file->filename = $data['upload_data']['file_name'];
      $file->original_filename = $data['upload_data']['client_name'];
      $file->url = 'https://' . $_SERVER['SERVER_NAME'] . '/uploads/'.$file->filename;
      $file->path = $data['upload_data']['full_path'];
      $file->size = $data['upload_data']['file_size'];
      $file->mime = $data['upload_data']['file_type'];
      $file->created = date('Y-m-d H:i:s');
      $file->user_id = $this->userid();
      $file->doc_type = $this->input->post('doc_type');
      $file->description = $this->input->post('description');
      $file->claim_id = $claim_id;
      $file_id = $file->insert();

      $data2['file_id'] = $file_id;

      echo json_encode($data2);
    }
  }

  public function make_upload_remove() {
    $file_id = $this->input->get_post('file_id');
    if(!$file_id) return;
    $file_id=(int)$file_id;
    $this->load->model('File');
    $this->load->model('ClaimFile');
    $file_deleted = $this->File->delete($file_id);
    $cfiles_deleted = $this->ClaimFile->delete(array('file_id'=>$file_id));

    echo json_encode(array(
        'file_deleted'=>$file_deleted?true:false,
        'claimFiles_deleted'=>$cfiles_deleted?true:false,
      ));
  }

  public function add() {
    // setting up page heading
    $header_vars = array();
    $header_vars['page_title'] = 'dashboard';
    $str = $this->load->view('templates/banner', $header_vars, true);

    $vars['banner_template'] = $str;

    // queuing style files and script files

    // main render file
    $this->render('claims/make_thankyou');
  }


  public function search() {
    $vars = array();
  }

  // viewing a single claim
  public function view() {
    $vars = array();
    $claim_id = $this->uri->segment(2);
  }

  public function remove() {
    $val = array();
    $val['deleted'] = true;
    $val['claim_id'] = $this->uri->segment(3);

    echo json_encode($val);
  }

  public function edit() {

  }
}