<?php

class Period extends CI_Model {

	public $id_periodo;
	public $pais;
	public $fecha_inicio;
	public $fecha_fin;
	public $habilitado;
	public $estado;

	// getList con DB.
	public function getList()
	{
			$query = $this->db->get('period');
			return $query->result_array();
	}

	// getList con DB por país.
	public function getListByCountry($pais)
	{
			// Inicio una transacción.
			$this->db->select('*');
			$this->db->where('pais', $pais);
			$query = $this->db->get('period');
			return $query->result_array();
	}

	// Obtiene los períodos por país.
	public function getCountryPeriodList($pais){
		// Inicio una transacción.
		$this->db->trans_start(); // Query will be rolled back
			$this->db->select('*');
			$this->db->where('pais', $pais);
			$query = $this->db->get('period');
		$this->db->trans_complete();
		return $query->result_array();
	}

	// Obtiene los períodos por país.
	public function getPeriodList($estado){
		// Inicio una transacción.
		$this->db->trans_start(); // Query will be rolled back
			$this->db->select('*');
			$this->db->where('estado', $estado);
			$query = $this->db->get('period');
		$this->db->trans_complete();
		return $query->result_array();
	}


	// Insert Período.
	public function insert()
	{
			// Obtengo el ultimo id de período.
			$query = $this->db->query('select max(id_periodo) as indice from period');
			$row = $query->row(0, 'period');
			$row->indice++;

			$this->id_periodo = $row->indice;
			$this->pais = $_POST['periodPais']; 
			$this->fecha_inicio  = $_POST['periodInicio'];
			$this->fecha_fin  = $_POST['periodFin'];
			$this->habilitado  = $_POST['periodHabilitado'];
			$this->estado  = $_POST['periodEstado'];
			$this->db->insert('period', $this);
	}

	public function getPeriod($id){
		// Inicio una transacción.
		$this->db->trans_start(); // Query will be rolled back
			$this->db->select('*');
			$this->db->where('id_periodo', $id);
			$query = $this->db->get('period');
		$this->db->trans_complete();
		
		$row = $query->row(0, 'period');
		return $row;
	}
}
?>
