<?php

class User extends CI_Model {

	public $user_id;
	public $user_email;
	public $user_pass;
	public $user_date;
	public $user_modified;
	public $user_last_login;

	// getList con DB.
	public function getList()
	{
			$query = $this->db->get('user');
			return $query->result_array();
	}

	// getList con API.
	public function getListRest(){
		/* Secure
		$this->load->library('rest', array(
			'server' => 'http://localhost/cistack/api/users',
			'http_user' => 'admin',
			'http_pass' => '1234',
			'http_auth' => 'basic' // or 'digest'
		));
		*/
		
		$this->load->library('rest', array(
			'server' => 'http://localhost/cistack/api/users',
			'http_user' => 'admin',
			'http_pass' => '1234',
			'http_auth' => 'basic' // or 'digest'
		));
	
		$user = $this->rest->get('user', array('id' => $id), 'json');
		
		return $user;
	}

	public function getAll()
	{
			$query = $this->db->get('user');
			return $query->result_array();
	}

	public function get($id)
	{
			// Inicio una transacción.
			$this->db->trans_start(); // Query will be rolled back
				$this->db->select('*');
				$this->db->where('user_id',$id);
				$query = $this->db->get('user');
			$this->db->trans_complete();
			return $query->result_array();
	}

	public function insert()
	{
			$this->user_email = $_POST['username']; 
			$this->user_pass  = $_POST['password'];
			$this->user_date = date("Y-m-d H:i:s");  
			$this->user_modified = date("Y-m-d H:i:s");  
			$this->db->insert('user', $this);
	}

	// Obtiene los datos de un usuario, si existe.
	public function getUserData($user){
		// Inicio una transacción.
		$this->db->trans_start(); // Query will be rolled back
			$this->db->select('*');
			$this->db->where('user_email',$user);
			$query = $this->db->get('user');
		$this->db->trans_complete();

		$row = $query->row(0, 'user');
		return $row;

	}

	public function getUserEmail(){
		return $this->user_email;
	}

	public function getUserPass(){
		return $this->user_pass;
	}

}

?>
