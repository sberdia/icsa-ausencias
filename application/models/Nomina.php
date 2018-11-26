<?php

class Nomina extends CI_Model {

	public $legajo;
	public $nombre;
	public $apellido_paterno;
	public $apellido_materno;
	public $nombre_completo;
	public $email;
	public $genero;
	public $pais;
	public $ciudad;
	public $moneda;
	public $division;
	public $cargo;
	public $rol_privado;
	public $tipo_asignacion;
	public $asignacion_internacional;
	public $perfil;
	public $ggs;
	public $nivel_ejecutivo;
	public $fecha_nacimiento;
	public $fecha_ingreso;
	public $legajo_rrhh;
	public $gerente_rrhh;
	public $salario_diciembre;
	public $salario_enero;
	public $bonos_anuales;
	public $bonos_totales;
	public $salarios_anuales;
	public $ultima_fecha_revision;
	public $ultimo_porcentaje_revision;
	public $firma_jefe_directo;
	public $firma_bp_rrhh;
	public $legajo_bp_compensaciones;
	public $nya_bp_compensaciones;
	public $legajo_bp_rrhh;
	public $nya_bp_rrhh;
	public $legajo_bp_control_gestion;
	public $nya_bp_control_gestion;
	public $mes_carta_compensaciones;
	public $codigo_jefe;
	public $base_importe_calculo_bono;
	public $base_calculo_proporcional;
	public $app_status;
	public $app_observaciones;
	public $app_fecha_efectiva;
	public $app_user;
	public $app_porcentaje_propuesto;
	public $app_salario_propuesto;
	public $comp_eval_desempeno;
	public $comp_pos_de_rango;
	public $comp_prioridad_ajuste;
	public $comp_pauta;

	// getList con DB.
	public function getList()
	{
			$query = $this->db->get('nomina');
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
			'server' => 'http://localhost/cistack/api/nomina',
			'http_user' => 'admin',
			'http_pass' => '1234',
			'http_auth' => 'basic' // or 'digest'
		));
	
		$user = $this->rest->get('nomina', array('id' => $id), 'json');
		
		return $user;
	}

	public function getAll()
	{
			$query = $this->db->get('nomina');
			return $query->result_array();
	}

	public function insertByQuery($query){
		$this->db->query($query);
	}

	public function truncateNomina(){
		$queryTruncate = "DELETE FROM nomina";
		$this->db->query($queryTruncate);
	}

	public function getNomina($legajo)
	{
			// Inicio una transacción.
			$this->db->trans_start(); // Query will be rolled back
				$this->db->select('*');
				$this->db->where('legajo',$legajo);
				$query = $this->db->get('nomina');
			$this->db->trans_complete();
			return $query->result_array();
	}

	public function getNominaMobile()
	{
			// Inicio una transacción.
			$this->db->trans_start(); // Query will be rolled back
				$this->db->select('*');
				$this->db->where('app_status','REVISAR');
				$query = $this->db->get('nomina');
			$this->db->trans_complete();
			return $query->result_array();
	}

	public function getNominaLegajo($legajo){
	// Inicio una transacción.
			$this->db->trans_start(); // Query will be rolled back
			$this->db->select('*');
			$this->db->where('legajo',$legajo);
			$query = $this->db->get('nomina');
		$this->db->trans_complete();

		$row = $query->row(0, 'nomina');
		return $row;
	}


	public function getNominaPais($pais)
	{
		// Inicio una transacción.
			$this->db->select('*');
			$this->db->where('pais', $pais);
			$query = $this->db->get('nomina');
		return $query->result_array();

	}

	// Obtiene los reportes por pais y con fecha dentro del período.
	public function getNominaReportesPais($pais, $superior, $fechaDesde, $fechaHasta)
	{
			// Anda
			$this->db->select('*');
			$this->db->where('pais', $pais);
			$this->db->where_in('legajo_rrhh', $superior);
			$this->db->where('app_fecha_efectiva >=', $fechaDesde);
			$this->db->where('app_fecha_efectiva <=', $fechaHasta);
			$query = $this->db->get('nomina');
			return $query->result_array();
	}

		// Obtiene los reportes por pais y con fecha dentro del período.
		public function getNominaReportesCompensa($pais, $superior, $fechaDesde, $fechaHasta)
		{
				// Anda
				$this->db->select('*');
				$this->db->where('pais', $pais);
				$this->db->where('app_fecha_efectiva >=', $fechaDesde);
				$this->db->where('app_fecha_efectiva <=', $fechaHasta);
				$query = $this->db->get('nomina');
				return $query->result_array();
		}

		// Obtiene los reportes por pais y con fecha dentro del período.
		public function getNominaReportesDirector($pais, $superior, $fechaDesde, $fechaHasta)
		{
				// Anda
				$this->db->select('*');
				$this->db->where('pais', $pais);
				$this->db->where('app_fecha_efectiva >=', $fechaDesde);
				$this->db->where('app_fecha_efectiva <=', $fechaHasta);
				$query = $this->db->get('nomina');
				return $query->result_array();
		}
		

		// Devuelve el presupuesto SUELDO * PAUTA por País.
		public function getPresupuestoPautaPais($pais){
			$query = $this->db->query('SELECT sum(salario_enero + (salario_enero * comp_pauta / 100)) as presupuesto FROM nomina WHERE pais = "'.$pais.'"');
			$row = $query->row(0, 'nomina');
			return $row;
		}
	

		// Devuelve el presupuesto SUELDO * PAUTA por País.
		public function getPresupuestoPropuesto($pais){
			//$query = $this->db->query('SELECT sum(salario_enero + (salario_enero * comp_pauta)) as presupuesto FROM nomina WHERE pais = "'.$pais.'"');
			//$row = $query->row(0, 'nomina');
			//return $row;
			$presupuestoPropuesto = 0;
			$this->db->select('*');
			$this->db->where('pais', $pais);
			$query = $this->db->get('nomina');
			foreach ($query->result_array() as $row):
				$totalEmpleado = 0;
				if($row['app_porcentaje_propuesto']>0){
					$totalEmpleado = $row['salario_enero'] + ($row['salario_enero'] * $row['app_porcentaje_propuesto'] / 100 );
				}else{
					if($row['app_porcentaje_propuesto']==0){
						$totalEmpleado = $row['salario_enero'] + ($row['salario_enero'] * $row['comp_pauta'] / 100);
					}
				}
				$presupuestoPropuesto = $presupuestoPropuesto + $totalEmpleado;
			endforeach;
			return $presupuestoPropuesto;
		}
		

	// Obtiene los reportes por pais y con fecha dentro del período.
	public function getNominaReportesPaisJefe($pais, $superior, $fechaDesde, $fechaHasta)
	{
			$legajos = array();

			$query = $this->db->query('select legajo from nomina where legajo_rrhh ='.$superior);
			$row = $query->row(0,'nomina');

			// Agregolos legajos a visualizar.			
			$legajos[]=$row->legajo;
			$legajos[]=$superior;

			$this->db->select('*');
			$this->db->where('pais', $pais);
			$this->db->where_in('legajo_rrhh', $legajos);
			$this->db->where('app_fecha_efectiva >=', $fechaDesde);
			$this->db->where('app_fecha_efectiva <=', $fechaHasta);
			$query = $this->db->get('nomina');
			return $query->result_array();

			// Anda
			/*
			$this->db->select('*');
			$this->db->where('pais', $pais);
			$this->db->where_in('legajo_rrhh', $superior);
			$this->db->where('app_fecha_efectiva >=', $fechaDesde);
			$this->db->where('app_fecha_efectiva <=', $fechaHasta);
			$query = $this->db->get('nomina');
			return $query->result_array();
			*/
	}


	// Obtiene los reportes con fecha dentro del período.
	public function getNominaReportes($superior, $fechaDesde, $fechaHasta)
	{
		// Inicio una transacción.
			$this->db->select('*');
			$this->db->where('legajo_rrhh', $superior);
			$this->db->where('app_fecha_efectiva >=', $fechaDesde);
			$this->db->where('app_fecha_efectiva <=', $fechaHasta);
			$query = $this->db->get('nomina');
		return $query->result_array();

	}

	// Actualiza las observaciones por empleado.
	public function updateObservaciones(){
		// Inicio una transacción.
		//$control = 'txtComentariosEmpleado_'.$legajo.'';
		//$this->db->set('app_observaciones',$_POST[$control]);
		$this->db->set('app_observaciones', $_POST['txtObservacionesEmpleado']);
		$this->db->where('legajo',$_POST['txtLegajo']);
		$this->db->update('nomina');
	}

	// Actualiza el porcentaje propuesto y el salario resultante.
	public function updatePorcentajeSalario($legajo, $porcentaje, $salario){
		$this->db->set('app_porcentaje_propuesto', $porcentaje);
		$this->db->set('app_salario_propuesto', $salario);
		$this->db->where('legajo',$legajo);
		$this->db->update('nomina');
	}

	// Actualiza los valores de Compensacion.
	public function updateCompensacion($legajo, $evalDesempeno, $posDeRango, $prioridadAjuste, $pauta){
		$this->db->set('comp_eval_desempeno', $evalDesempeno);
		$this->db->set('comp_pos_de_rango', $posDeRango);
		$this->db->set('comp_prioridad_ajuste', $prioridadAjuste);
		$this->db->set('comp_pauta', $pauta);
		$this->db->where('legajo',$legajo);
		$this->db->update('nomina');
	}

	// Actualiza el status de un registro de la nomina.
	public function updateNominaStatus($legajo, $status){
		$this->db->set('app_status', $status);
		$this->db->where('legajo',$legajo);
		$this->db->update('nomina');
	}



}


?>
