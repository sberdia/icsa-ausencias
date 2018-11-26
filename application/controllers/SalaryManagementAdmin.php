<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SalaryManagementAdmin extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->library('table');
		$this->load->helper('url_helper');
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->library('fpdf.php');
	}

	public function index(){
		
		$this->load->model('nomina', '', TRUE);
		$this->load->model('period', '', TRUE);
		$this->load->model('param', '', TRUE);

		if ($this->session->has_userdata('session_logged_in') && 
			$this->session->userdata('session_logged_in') == TRUE){
		
				//$dataPost = array('session_logged_in' => $this->session->userdata('session_logged_in'));				
				$dataPost['session_logged_in']= $this->session->userdata('session_logged_in');				
				$dataPostPeriodo['session_logged_in']= $this->session->userdata('session_logged_in');				
				
				/* Obtiene solo los períodos activos por país */
				/*
				$dataPost['periodo'] = $this->period->getCountryPeriodList($this->session->userdata('session_pais'));
				*/

				/* Obtiene todos los períodos activos sin impotar el país */
				$dataPostPeriodo['periodo'] = $this->period->getPeriodList('ACTIVO');

				if(empty($_POST['periodoPais'])){
					$this->loadViewPeriod($dataPostPeriodo);
				}else{
					$periodoSeleccionado = $this->period->getPeriod($_POST['periodoPais']);
					$parametros = $this->param->getList();
					$presupuestoPais = $this->nomina->getPresupuestoPautaPais($periodoSeleccionado->pais);
					$presupuestoPropuesto = $this->nomina->getPresupuestoPropuesto($periodoSeleccionado->pais);

					$dataPost['presupuestoPropuesto'] = $presupuestoPropuesto;
					$dataPost['presupuestoPais'] = $presupuestoPais;
					$dataPost['periodoSeleccionado'] = $periodoSeleccionado;
					$dataPost['parametros'] = $parametros;
					

					// Nomina de reportes por país del período seleccionado dentro del período.
					// Primer Nivel de búsqueda.
					$dataPost['nomina'] = $this->nomina->getNominaReportesPais(
												$periodoSeleccionado->pais,
												$this->session->userdata('session_legajo'),
												$periodoSeleccionado->fecha_inicio,
												$periodoSeleccionado->fecha_fin);

					// Nomina de reportes por país del usuario logueado dentro del período.
					/*
					$dataPost['nomina'] = $this->nomina->getNominaReportesPais(
												$this->session->userdata('session_pais'),
												$this->session->userdata('session_legajo'),
												$periodoSeleccionado->fecha_inicio,
												$periodoSeleccionado->fecha_fin);
					*/

					// Nomina de reportes por país del usuario logueado dentro del período.
					/*
					$dataPost['nomina'] = $this->nomina->getNominaReportes(
												$this->session->userdata('session_legajo'),
												$periodoSeleccionado->fecha_inicio,
												$periodoSeleccionado->fecha_fin);

												$dataPost['parametros'] = $parametros;
					*/
					
					$this->loadViewMain($dataPost);
				}
				
			}
		}
	
	public function seleccionPeriodo($periodo){
		$dataPost['nomina'] = $this->nomina->getList();
		$this->loadViewMain($dataPost);
	}

	public function viewDetail($legajo){

		$this->load->model('nomina', '', TRUE);

		if ($this->session->has_userdata('session_logged_in') && 
			$this->session->userdata('session_logged_in') == TRUE){
		
				//$dataPost = array('session_logged_in' => $this->session->userdata('session_logged_in'));				
				$dataPost['session_logged_in']= $this->session->userdata('session_logged_in');				
				$dataPost['nomina'] = $this->nomina->getNomina($legajo);
				
				$this->loadViewDetail($dataPost);
		
		}
		// $data['nomina_item'] = $this->nomina->getNomina($legajo);
	}

	// Envía un mail al Jefe con las modificaciones efectuadas.
	public function notificarModificaciones($contenido){

		/* Obtengo la dirección de mail en la que se debe notificar */
		$this->load->model('param', '', TRUE);
		$parametros = $this->param->getList();

		/* Configuración del modulo */
		/* Servidor Icsa */
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = '10.0.10.185';
		$config['smtp_port'] = '25';
		$config['smtp_user'] = 'demo@revisionsalarial.com';
		$config['smtp_pass'] = 'e';
		$config['smtp_timeout'] = 30;
		
		/* Berdia */
		/*
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'mail.pince.com.ar';
		$config['smtp_port'] = '587';
		$config['smtp_user'] = 'sebastian@berdia.com.ar';
		$config['smtp_pass'] = 'sbruq172';
		$config['smtp_timeout'] = 30;
		*/
		/* Gmail */ 
		/*
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp.gmail.com';
		$config['smtp_port'] = '587';
		$config['smtp_user'] = 'sberdia@gmail.com';
		$config['smtp_pass'] = 'ruq172google';
		$config['smtp_timeout'] = 120;
		*/

		$this->email->initialize($config);

		$this->email->from('sebastian@berdia.com.ar', 'Sebastian Berdia');
		$this->email->to($parametros->mail_notif);
		//$this->email->cc('them@their-example.com');
		$this->email->bcc('sberdia@gmail.com');
				
		$this->email->subject('CENCOSUD - Modificación Salarial');
		$this->email->message($contenido);
		$this->email->set_mailtype('html');
		
		$this->email->send();		
	}

	public function loadViewDetail($dataPost){
		$this->load->view('templates/header', $dataPost);
		$this->load->view('general/salarymanagementadmindetail', $dataPost);
		$this->load->view('templates/footer', $dataPost);
	}

	// Carga la vista principal.
	public function loadViewMain($dataPost){
		$this->load->view('templates/header', $dataPost);
		$this->load->view('general/salarymanagementadmin', $dataPost);
		$this->load->view('templates/footer', $dataPost);
   }

   public function loadViewPeriod($dataPost){
		$this->load->view('templates/header', $dataPost);
		$this->load->view('general/viewperiod', $dataPost);
		$this->load->view('templates/footer', $dataPost);
   }

   // Guarda el comentario de un empleado.
	public function updateObservaciones(){
		$this->load->model('nomina', '', TRUE);
		$this->nomina->updateObservaciones();
		$this->index();
	}

   // Guarda el porcentaje y el salario propuesto.
   public function proponerPorcentajeSalario(){
		$this->load->model('nomina', '', TRUE);

		$this->nomina->updatePorcentajeSalario(
				$_POST['txtLegajo'],
				$_POST['txtAjusteSalario_'.$_POST['txtLegajo']],
				$_POST['txtNuevoSalario_'.$_POST['txtLegajo']]
		);
		$this->nomina->updateNominaStatus($_POST['txtLegajo'], 'VALIDADO');

		$empleado = $this->nomina->getNominaLegajo($_POST['txtLegajo']);
		$contenidoNotificacion =
		$mensaje = '<html>'.
					'<head><title>CENCOSUD - Modificación Salarial </title></head>'.
						'<body><h1>Modificación salarial</h1>'.
						"Se ha VALIDADO la siguiente modificación salarial para el empleado: ".$empleado->nombre_completo.
						'<hr>'.
						' SALARIO'.'<br>'.
						'Número de Legajo  : '.$empleado->legajo.'<br>'.
						'Salario Actual    : '.$empleado->salario_enero.'<br>'.
						'Ajuste Salario (%): '.$empleado->app_porcentaje_propuesto.'<br>'.
						'Ajuste Salario ($): '.$empleado->app_salario_propuesto.'<br>'.
						'<hr>'.
						' COMPENSACION'.'<br>'.
						'Salario Anual      :'.$empleado->app_salario_propuesto*$empleado->salarios_anuales.'<br>'.
						'Salario Anual (USD):'.($empleado->app_salario_propuesto*$empleado->salarios_anuales/40).'<br>'.
						'<hr>'.
						'POC - Interservices 2018'.
						'</body>'.
					'</html>';			

		$this->notificarModificaciones($contenidoNotificacion);

		$this->index();
	}

	// Guarda las opciones de compensación propuestas.
	public function proponerCompensacion(){
		$this->load->model('nomina', '', TRUE);
		$this->nomina->updateCompensacion(
				$_POST['txtLegajo'],
				$_POST['evaldesempeno_'.$_POST['txtLegajo']],
				$_POST['posdelrango_'.$_POST['txtLegajo']],
				$_POST['prioridaddeajuste_'.$_POST['txtLegajo']],
				$_POST['pauta_'.$_POST['txtLegajo']]
		);
		$this->index();
	}

	public function generarPDF(){
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Image('images/cenco_blue_logo.png',10,8,33);
		$pdf->Ln(60);
		$txt = file_get_contents('files/carta.txt');
		$pdf->MultiCell(0,5,$txt);
		$pdf->Output();
	}


}
?>
