<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminUser extends CI_Controller {

	public function __construct()
	{
		parent::__construct();	
		$this->load->helper('html');
		$this->load->library('session');
	}

	public function index()
	{	
		$this->load->model('user', '', TRUE);
		
		$data['ci_user'] = $this->user->getList();

		if($this->session->userdata('session_logged_in')=='true'){ 
			$data['session_logged_in'] = 1;
		 }else{
			$data['session_logged_in'] = 0;
		 }

		$this->load->view('templates/header', $data);
		$this->load->view('admin/user', $data);
		$this->load->view('templates/footer', $data);
	}

	public function insert(){
		$this->load->model('user','', TRUE);
		$this->user->insert('user', $this);
	}

}
