<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->library('form_validation');
	}

	public function index(){
		$this->app();
	}
	
	// Almacena los datos ingresados en el formulario de Login.
	public function app(){
		
		$dataPost = array(
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password'),
					'session_logged_in' => $this->session->userdata('session_logged_in')
					);	
		if ($this->session->has_userdata('session_logged_in') && 
			$this->session->userdata('session_logged_in') == TRUE){
				$this->loadViewMain($dataPost);
			} else {
				$this->login($dataPost);
			};
	}

	// Carga la vista principal.
	public function loadViewMain($dataPost){
		 $this->load->view('templates/header', $dataPost);
		 $this->load->view('main', $dataPost);
		 $this->load->view('templates/footer', $dataPost);
	}

	// Carga el formulario de Login.
	public function loadViewLoginForm($dataPost){
		$this->load->view('templates/headerLogin', $dataPost);
		$this->load->view('general/login', $dataPost);
		$this->load->view('templates/footer', $dataPost);
	}

	// Valida el usuario y la contraseña.
	public function login($dataPost){
		
		// Validación del formulario.
		$this->form_validation->set_rules("username", "Username", "trim|required|min_length[1]|max_length[12]");
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[1]');

		if ($this->form_validation->run() == FALSE){
			$this->loadViewLoginForm($dataPost);
		} else {
			$this->load->model('user', '', TRUE);
			$data = $this->user->getUserData($dataPost['username']);
			if(isset($data)){
				// Validar usuario y contraseña contra la base de datos.
				if (($dataPost['username']==$data->user_email) && ($dataPost['password']==$data->user_pass)){
					// Si el usuario es valido, creo una sesión y la mantengo para que no me pida de nuevo el login 
					// cuando redirijo a la página principal.
					$this->session->set_userdata('session_logged_in', TRUE);
					$this->session->set_userdata('session_name', $dataPost['username']);
					$this->session->set_userdata('session_rol', $data->user_rol);
					$this->session->set_userdata('session_pais', $data->user_pais);
					$this->session->set_userdata('session_legajo', $data->user_legajo);
					$dataPost['session_logged_in'] = TRUE;
					$this->loadViewMain($dataPost);
				}
			}else{
				$this->loadViewLoginForm($dataPost);
			}
		}

	}

	// Cierra la sesion y sale del sistema.
	public function logout(){
		$this->session->unset_userdata('session_logged_in');
		$this->session->unset_userdata('session_name');
		$this->session->sess_destroy();
		$this->app();
	}

	//public function index(){
	public function startApp()
	{

		// Colocar algún modo de inicialiar la sesión con los datos que pudieren ingresarse
		// previo a cargar este controller desde un formulario de login por ejemplo.

		/* To construct 
		$this->load->helper('html');
		$this->load->library('session');
		*/
		$this->session->set_userdata('name', 'Sebastian Session');

		if($this->session->has_userdata('edad')){
			$data['message'] = 'Variable de sesion iniciada';
		}else{
			$data['message'] = 'Variable de sesion no existe';
		}

		$this->load->view('templates/header', $data);
		$this->load->view('main', $data );
		$this->load->view('templates/footer', $data);
		
		// Forma de parsear texto directamente en un template html
		/*
		// En el template
		echo '<br>';
		echo '{page_title}';
		echo '<br>';
		echo '{page_subtitle}';
		// En el controller
		$this->load->library('parser');
		$htmlData = array(
			'page_title'	=> 'Titulo de la Pagina',
			'page_subtitle' => 'Subtitulo de la Pagina'
		);
		$this->parser->parse('main', $htmlData);
		*/
	}
}
