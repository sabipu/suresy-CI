<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller {

	public $vars = array();
	public $header = '_base/header';
	public $footer = '_base/footer';
	
	private $cacheTime = NULL;
	
	public function __construct()
	{
		parent::__construct();
		$this->cacheTime = time();
		$this->load->library('session');
    $this->config->load('menu');
		$this->config->load('server');

		$this->vars['page_title']="Suresy";
		$this->vars['scripts']=array();
		$this->vars['css']=array();
		$this->vars['javascript']=array();
		$this->vars['stylesheets']=array();
		
		$this->vars['buffer_scripts']=array();
		$this->vars['buffer_css']=array();
		$this->vars['buffer_javascript']=array();
		$this->vars['buffer_stylesheets']=array();
		
    $this->vars['menu'] = $this->config->item('menu');
		$this->vars['server'] = $this->config->item('server');
		
		$this->stylesheet('/css/bulma.css');
		$this->stylesheet('/css/global.css');
 		$this->script('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js');
		$this->script('https://use.fontawesome.com/releases/v5.0.7/js/all.js');

	}
	

	  public function json($data=NULL)
	{
  	$http_origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : NULL;
    
    if ($http_origin && ($http_origin == "http://www.suresy.com.au" || 
      $http_origin == "http://suresy.dilatedigital.com.au" || 
      $http_origin == "http://suresy.com.au" || 
      $http_origin == "https://www.suresy.com.au" || 
      $http_origin == "https://suresy.dilatedigital.com.au" || 
      $http_origin == "https://suresy.com.au"
    ))
    {  
        $this->output->set_header("Access-Control-Allow-Origin: $http_origin");
    }
    
    
    $mime = "application/json";
	   $response = json_encode($data);
	   if($this->input->get_post('pretty'))
	   {
	     $this->load->helper('json');
	     $response =  jsonReadable($response);
	   }
	   else
	   {
  	    $this->output->set_content_type('application/json');
	   }
	   return $response;
	}
	
	public function css($css_code=NULL)
	{
		if(!is_null($css_code)) $this->vars['css'][] = $css_code;
		$css = NULL;
		foreach($this->vars['css'] as $i=>$val)
		{
			$css .= $val;
		}	
		return $css;
	}
	
	public function javascript($code=NULL)
	{
		if(!is_null($code)) $this->vars['javascript'][] = $code;
		$css = NULL;
		foreach($this->vars['javascript'] as $i=>$val)
		{
			$css .= $val;
		}	
		return $css;
	}
	
	
	public function stylesheet($path=NULL, $shouldCache = true)
	{
		if(!is_null($path) && strlen($path) > 0)
		{
  		$path = $shouldCache ? $path : $path . '?c='.$this->cacheTime;
  		foreach($this->vars['stylesheets'] as $stylesheet) { if($stylesheet == $path) return; }
  		$this->vars['stylesheets'][] = $path;
    }
	}
	
	public function script($path=NULL, $shouldCache = true)
	{
		if(!is_null($path) && strlen($path) > 0)
		{
  		$path = $shouldCache ? $path : $path . '?c='.$this->cacheTime;
  		foreach($this->vars['scripts'] as $stylesheet) { if($stylesheet == $path) return; }
  		$this->vars['scripts'][] = $path;
    }
	}
	
	public function vars($name=NULL, $value=NULL)
	{ 
  	if(isset($name) && $name && is_array($name))
		{
  		  $this->vars = array_merge($this->vars, $name);
  		  return $this->vars;
  		  
  		  
    }
		if(isset($name) && $name)
		{
			$this->vars[$name] = $value;
			return $value;
		}
		return $this->vars;
	}
	
	
	public function render($path, $_vars=NULL, $print=false)
	{
    
    $this->finalRender($path, $_vars, $print);

  	
  }
  public function finalRender($path, $_vars=NULL, $print=false)
	{
		$myvars = $this->vars;
		if(!isset($myvars['menu'])) $myvars['menu'] = $this->config->item('menu');
		if(!isset($myvars['menu_tpl'])) $myvars['menu_tpl'] = $this->load->view('menu/menu', $this->vars($myvars), true);
		if(!isset($myvars['menu_user_tpl'])) $myvars['menu_user_tpl'] = $this->load->view('menu/menu_user', $this->vars($myvars), true);
		if(isset($_vars) && !is_null($_vars)) $myvars = array_merge($myvars, $_vars);

		$this->load->view($this->header, $myvars);
		$this->load->view($path, $myvars);
		$this->load->view($this->footer, $myvars);
	}
}
