<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ManagePeriod extends CI_Controller {

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
		$this->load->model('period', '', TRUE);
		if ($this->session->has_userdata('session_logged_in') && 
			$this->session->userdata('session_logged_in') == TRUE){
				
				//$dataPost = array('session_logged_in' => $this->session->userdata('session_logged_in'));
				$dataPost['session_logged_in']= $this->session->userdata('session_logged_in');				
				//$dataPost['period'] = $this->period->getListByCountry($this->session->userdata('session_pais'));
				$dataPost['period'] = $this->period->getList();

				$this->form_validation->set_rules("periodPais", "Pais", "trim|required");
	
				if ($this->form_validation->run() == FALSE)
				{
					$this->loadView($dataPost);
				}
				else
				{
					$this->insert_period();
					$this->loadView($dataPost);
				}
		}
	}

	// Carga la vista principal.
	public function loadView($dataPost){
		$this->load->view('templates/header', $dataPost);
		$this->load->view('general/manageperiod', $dataPost);
		$this->load->view('templates/footer', $dataPost);
   }

   public function insert_period(){
		$this->load->model('period','', TRUE);
		$this->period->insert('period', $this);
	}

}

?>
