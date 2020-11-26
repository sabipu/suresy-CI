<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'SuresyController.php';


class RateEngine extends SuresyController {

  public function __construct()
  {
    error_reporting(0);

    parent::__construct();
    $this->load->model('CalcRate');
    $this->load->model('CalcPromocode');
        
  }
  
  public function viewRates()
  {
    $this->requireLogin();
    $rates = array();
    
    $type = $this->input->get('type');
    $search = $this->input->get('search');
    $searchby = $this->input->get('searchby');

    $page = $this->input->get('page') ? intval($this->input->get('page')) : 1;
    $page = $this->uri->segment(5) ? intval($this->uri->segment(5)) : $page;
    
    $limit = $this->input->get('limit') ? $this->input->get('limit') : 100;
    $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
    $sort = $this->input->get('sort') ? $this->input->get('sort') : NULL;
    
    
    
    
    if($page > 1)
    {
      $offset = ($page-1) * $limit;
    }
    
    
    $this->db->select('*');
    
    if($type)
    {
      $this->db->where('type', $type);
    }
    
    if($search && $searchby)
    {
      $this->db->where($searchby, $search);
/*
      $this->db->or_like('key', $search);
      $this->db->or_like('rate', $search);
      $this->db->or_like('value', $search);
*/

    }
    
    $count = $this->db->count_all_results('calc_rates', false);
    
    if($sort && is_array($sort))
    {
      foreach($sort as $key=>$direction)
      {
        $this->db->order_by($key, $direction);
      }
    }
    
    
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    
    
    parse_str($_SERVER['QUERY_STRING'], $get_array);
    unset($get_array['sort']);
    
    $this->vars('url_query_sort', http_build_query($get_array));
    
    $this->vars('url_query', $_SERVER['QUERY_STRING']);
    $this->vars('page', $page);
    $this->vars('type', $type);
    $this->vars('limit', $limit);
    $this->vars('offset', $offset);
    $this->vars('sort', $sort);
    $this->vars('search', $search);
    $this->vars('searchby', $searchby);

    $this->vars('pages', ceil($count/$limit));
    $this->vars('count', $count);
    $this->vars('rates', $query->result('CalcRate'));    
    $this->vars('nav_tpl', $this->load->view('rates/menu', $this->vars, true));
    
    $this->load->view('rates/view', $this->vars);
  }
  
  
  public function updateRate()
  {
    $id = $this->input->post('calc_rate_id');
    $data = $this->input->post('data');
    $this->CalcRate->save(array('calc_rate_id'=>$id), $data);
    echo $this->json(array('success'=>true, 'data'=>$data, 'id'=>$id));
  }
  
  public function viewPromocodes ()
  {
    $this->requireLogin();
    $rates = array();
    
    $type = $this->input->get('type');
    $page = $this->input->get('page') ? intval($this->input->get('page')) : 1;
    $page = $this->uri->segment(5) ? intval($this->uri->segment(5)) : $page;
    
    $limit = $this->input->get('limit') ? $this->input->get('limit') : 100;
    $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
    $sort = $this->input->get('sort') ? $this->input->get('sort') : NULL;
    
    
    
    
    if($page > 1)
    {
      $offset = ($page-1) * $limit;
    }
    
    
    $this->db->select('*');    
    $count = $this->db->count_all_results('calc_promocodes', false);
    
    if($sort && is_array($sort))
    {
      foreach($sort as $key=>$direction)
      {
        $this->db->order_by($key, $direction);
      }
    }
    
    
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    
    
    parse_str($_SERVER['QUERY_STRING'], $get_array);
    unset($get_array['sort']);
    
    $this->vars('url_query_sort', http_build_query($get_array));
    
    $this->vars('url_query', $_SERVER['QUERY_STRING']);
    $this->vars('page', $page);
    $this->vars('type', $type);
    $this->vars('limit', $limit);
    $this->vars('offset', $offset);
    $this->vars('sort', $sort);

    $this->vars('pages', ceil($count/$limit));
    $this->vars('count', $count);
    $this->vars('promocodes', $query->result('CalcPromocode'));    
    $this->vars('nav_tpl', $this->load->view('rates/menu', $this->vars, true));
    
    $this->load->view('rates/promocodes', $this->vars);

  }
  public function updatePromocode()
  {
    $id = $this->input->post('id');
    $data = $this->input->post('data');
    $this->CalcPromocode->save(array('calc_promocode_id'=>$id), $data);
    echo $this->json(array('success'=>true, 'data'=>$data, 'id'=>$id));
  }
  
  public function addPromocode()
  {
    $data = $this->input->post('data');
    $data['modified'] = date('Y-m-d H:i:s');
    $this->CalcPromocode->insert($data);
   // var_dump($data);
   header('Location: /backstage/admin/promocode/manager');
    
  }
  
  public function deletePromocode()
  {
    $id = $this->input->get('id');
    $this->db->delete('calc_promocodes', array('calc_promocode_id' => $id));
   // var_dump($data);
   header('Location: /backstage/admin/promocode/manager');
    
  }
  
  
}