<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {


	public function __construct()
	{
	    parent::__construct();
     
	    $this->load->helper(array('form', 'url', 'html'));
	    $this->load->library('session');    
	    $this->load->library('form_validation');
	}

        public function index()
        {
		if($this->session->userdata('session_logged_in')=='true'){ 
			$data['session_logged_in'] = 1;
		 }else{
			$data['session_logged_in'] = 0;
		 }
/* To construct 
		$this->load->helper(array('form', 'url', 'html'));

		$this->load->library('session');
		
		$this->load->library('form_validation');
*/
		$this->form_validation->set_rules("username", "Username", "trim|required|min_length[5]|max_length[12]");
		$this->form_validation->set_rules('username', 'Username', 'callback_username_check');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		$dataHtml['userSession'] = $this->session->name;
		$dataHtml['sessionId'] = $this->session->session_id;

                if ($this->form_validation->run() == FALSE)
                {

			$this->load->view('templates/header', $data);
			$this->load->view('general/myform', $dataHtml);
			$this->load->view('templates/footer', $data);
                }
                else
                {
			$this->insert_user();
			$this->load->view('templates/header', $data);
			$this->load->view('general/formsuccess');
			$this->load->view('templates/footer', $data);
			

                }
	}

	public function insert_user(){
		$this->load->model('user','', TRUE);
		$this->user->insert('user', $this);
	}

	public function username_check($str)
        {
                if ($str == 'test')
                {
                        $this->form_validation->set_message('username_check', 'The {field} field can not be the word "test"');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }

}
