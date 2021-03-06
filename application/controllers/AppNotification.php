<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AppNotification extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->library('table');
		$this->load->helper('url_helper');
		$this->load->library('form_validation');
	}

	public function index(){
		if ($this->session->has_userdata('session_logged_in') && 
			$this->session->userdata('session_logged_in') == TRUE){
				
				$dataPost = array('session_logged_in' => $this->session->userdata('session_logged_in'));
			
				$this->loadView($dataPost);
		}
	}

	// Carga la vista principal.
	public function loadView($dataPost){
		$this->load->view('templates/header', $dataPost);
		$this->load->view('general/appnotification', $dataPost);
		$this->load->view('templates/footer', $dataPost);
   }

}
?>
