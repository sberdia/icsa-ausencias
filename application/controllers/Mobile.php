<?php

class Mobile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->library('table');
		$this->load->helper('url_helper');
		$this->load->library('form_validation');
		$this->load->library('email');

	}

	public function index(){
		$this->appMobile();
	}
	
	// Almacena los datos ingresados en el formulario de Login.
	public function app(){	
		$dataPost['app'] = 'mobile';
		$this->loadViewMobile($dataPost);
	}

	public function appMobile(){
		$this->load->model('nomina', '', TRUE);
		$dataPost['nomina'] = $this->nomina->getNominaMobile();
		$this->loadViewMobile($dataPost);
	}

	public function aprobarSalario(){
		$this->load->model('nomina', '', TRUE);
		$this->nomina->updateNominaStatus($_POST['txtLegajo'], 'FINALIZADO');
		$this->index();
	}


	// Carga la vista principal.
	public function loadViewMobile($dataPost){
		 //$this->load->view('templates/header', $dataPost);
		 $this->load->view('mobile/mobile', $dataPost);
		 //$this->load->view('templates/footer', $dataPost);
	}

}




?>
