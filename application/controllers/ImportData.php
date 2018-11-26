<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ImportData extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
	}

	public function index(){
		if ($this->session->has_userdata('session_logged_in') && 
			$this->session->userdata('session_logged_in') == TRUE){
				
				$dataPost = array('session_logged_in' => $this->session->userdata('session_logged_in'),
									'error'=>' ');
			
				$this->loadView($dataPost);
		}
	}

	public function do_upload()
	{
			$config['upload_path']          = './uploads/';
			$config['allowed_types']        = 'txt|csv|xls';
			$config['max_size']             = 100;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('dataFile'))
			{
				$dataPost = array('session_logged_in' => $this->session->userdata('session_logged_in'),
									'error'=>' ');
				$this->loadView($dataPost);
			}
			else
			{
					$dataPost = array(
							'session_logged_in' => $this->session->userdata('session_logged_in'),
							'upload_data' => $this->upload->data(),
							'upload_date' => $_POST['fechaEfectiva']);
					/* Importa los datos a la DB */
					$this->importData($config['upload_path'].'nomina.csv', $_POST['fechaEfectiva']);
					$this->loadViewSuccess($dataPost);
				}
	}

	// Importa los datos a la DB.
	public function importData($file, $fechaEfectiva){
		
		$this->load->model('nomina', '', TRUE);

		$this->nomina->truncateNomina();
		
		/* Leo e imprimo el archivo */
		if (($gestor = fopen($file, "r")) !== FALSE) {
			while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
				// Cuenta los campos del registro.
				$numero = count($datos);
/*				echo "CANTIDAD DE CAMPOS: ".$numero;
				echo "<br>";
				for ($c=0; $c <= $numero; $c++) {
					echo $datos[$c] . "<br/>\n";
				} */
				// Armo la sentencia SQL para insertar datos.
				$sqlInsertNomina = "INSERT INTO nomina VALUES("."'".$datos[0]."','".
				$datos[1]."','".
				$datos[2]."','".
				$datos[3]."','".
				$datos[4]."','".
				$datos[5]."','".
				$datos[6]."','".
				$datos[7]."','".
				$datos[8]."','".
				$datos[9]."','".
				$datos[10]."','".
				$datos[11]."','".
				$datos[12]."','".
				$datos[13]."','".
				$datos[14]."','".
				$datos[15]."','".
				$datos[16]."','".
				$datos[17]."','".
				$datos[18]."','".
				$datos[19]."','".
				$datos[20]."','".
				$datos[21]."','".
				$datos[22]."','".
				$datos[23]."','".
				$datos[24]."','".
				$datos[25]."','".
				$datos[26]."','".
				$datos[27]."','".
				$datos[28]."','".
				$datos[29]."','".
				$datos[30]."','".
				$datos[31]."','".
				$datos[32]."','".
				$datos[33]."','".
				$datos[34]."','".
				$datos[35]."','".
				$datos[36]."','".
				$datos[37]."','".
				$datos[38]."','".
				$datos[39]."','".
				$datos[40]."','".
				"INICIADO"."','".
				"-"."','".
				$fechaEfectiva."','".
				$this->session->userdata('session_name')."','".
				"0"."','".
				"0"."','".
				"BB"."','".
				"En Crecimiento"."','".
				"Sin Incremento"."','".
				"10"."')";

				$this->nomina->insertByQuery($sqlInsertNomina);
				
				
			}
			fclose($gestor);
		}
	}

	// Guarda un registro.
	public function saveRegister($registro){
		//$this->load->model('nomina', '', TRUE);
		//$this->nomina->updateObservaciones();
		//$this->index();
	}

	// Carga la vista principal.
	public function loadView($dataPost){
		$this->load->view('templates/header', $dataPost);
		$this->load->view('general/importdata', $dataPost);
		$this->load->view('templates/footer', $dataPost);
   }

	// Carga la vista principal.
	public function loadViewSuccess($dataPost){
		$this->load->view('templates/header', $dataPost);
		$this->load->view('general/importdatasuccess', $dataPost);
		$this->load->view('templates/footer', $dataPost);
   }

}

?>
