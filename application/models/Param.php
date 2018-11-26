<?php

class Param extends CI_Model {

	public $tipo_cambio;
	public $alerta_eval;
	public $alerta_fecha_ingreso;
	public $presupuesto_argentina;
	public $presupuesto_peru;
	public $presupuesto_chile;
	public $presupuesto_brasil;
	public $mail_notif;
	
	// getList con DB.
	public function getParam() {
			$query = $this->db->get('param');
			return $query->result_array();
	}

	public function getList(){
		$this->db->trans_start(); // Query will be rolled back	
		$this->db->select('*');
		$query = $this->db->get('param');
		$this->db->trans_complete();

		$row = $query->row(0, 'param');
		return $row;
	}


	
	// Actualiza las observaciones por empleado.
	public function updateEmailNotif($email){
		// Inicio una transacción.
		//$control = 'txtComentariosEmpleado_'.$legajo.'';
		//$this->db->set('app_observaciones',$_POST[$control]);
		$this->db->set('mail_notif', $email);
		$this->db->update('param');
	}

}

?>
