<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AppParameter extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('table');

	}

	public function index(){
		if ($this->session->has_userdata('session_logged_in') && 
			$this->session->userdata('session_logged_in') == TRUE){

				$this->load->model('param', '', TRUE);
				$applicationConfig = $this->param->getList();

				/*$dataPost = array('session_logged_in' => $this->session->userdata('session_logged_in'),
								   'tipo_cambio' => $applicationConfig['tipo_cambio']
								 );
				*/ 
				$dataPost['session_logged_in'] = $this->session->userdata('session_logged_in');
				$dataPost['applicationConfig'] = $applicationConfig;

				$this->loadViewParameter($dataPost);
		}
	}

	// Carga la vista principal.
	public function loadViewParameter($dataPost){
		$this->load->view('templates/header', $dataPost);
		$this->load->view('general/appparameter', $dataPost);
		$this->load->view('templates/footer', $dataPost);
   }

   public function updateEmailNotif(){
		$this->load->model('param', '', TRUE);
		$this->param->updateEmailNotif($_POST['txtEmailNotif']);
		$this->index();
   }

}
?>
