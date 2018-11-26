<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SalaryManagementAdminJefe extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->library('table');
		$this->load->helper('url_helper');
		$this->load->library('form_validation');
		$this->load->library('email');
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

					$dataPost['periodoSeleccionado'] = $periodoSeleccionado;
					$dataPost['parametros'] = $parametros;

					// Nomina de reportes por país del período seleccionado dentro del período.
					// Primer Nivel de búsqueda.
					$dataPost['nomina'] = $this->nomina->getNominaReportesPaisJefe(
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

		/* Configuración del modulo */
		/* Servidor Icsa
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = '10.0.10.185';
		$config['smtp_port'] = '25';
		$config['smtp_user'] = 'pepe@pepe.com';
		$config['smtp_pass'] = 'pepe';
		$config['smtp_timeout'] = 30;
		*/
		/* Berdia */
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'mail.pince.com.ar';
		$config['smtp_port'] = '587';
		$config['smtp_user'] = 'sebastian@berdia.com.ar';
		$config['smtp_pass'] = 'sbruq172';
		$config['smtp_timeout'] = 30;
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
		$this->email->to('sebastian.berdia@datco.net');
		//$this->email->cc('another@another-example.com');
		// $this->email->bcc('them@their-example.com');
		
		$this->email->subject('CENCOSUD - Bonus App');
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
		$this->load->view('general/salarymanagementadminjefe', $dataPost);
		$this->load->view('templates/footer', $dataPost);
   }

   public function loadViewPeriod($dataPost){
		$this->load->view('templates/header', $dataPost);
		$this->load->view('general/viewperiodjefe', $dataPost);
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
		/*$this->nomina->updatePorcentajeSalario(
				$_POST['txtLegajo'],
				$_POST['txtAjusteSalario_'.$_POST['txtLegajo']],
				$_POST['txtNuevoSalario_'.$_POST['txtLegajo']]
		);
		*/
		$empleado = $this->nomina->getNominaLegajo($_POST['txtLegajo']);

		if(isset($_POST["aprobar"])){
			$this->nomina->updateNominaStatus($_POST['txtLegajo'], 'APROBADO');
			
			$contenidoNotificacion =
			$mensaje = '<html>'.
						'<head><title>CENCOSUD- Bonus App</title></head>'.
							'<body><h1>Modificación salarial</h1>'.
							"Se ha APROBADO la modificación salarial para el empleado: ".$empleado->nombre_completo.
							'<hr>'.
							'Número de Legajo  : '.$empleado->legajo.'<br>'.
							'Salario Actual    : '.$empleado->salario_enero.'<br>'.
							'Ajuste Salario (%): '.$empleado->app_porcentaje_propuesto.'<br>'.
							'Ajuste Salario ($): '.$empleado->app_salario_propuesto.'<br>'.
							'<hr>'.
							'POC - Interservices 2018'.
							'</body>'.
						'</html>';			
	
		}

		if(isset($_POST["rechazar"])){
			$this->nomina->updateNominaStatus($_POST['txtLegajo'], 'RECHAZADO');
		
			$contenidoNotificacion =
			$mensaje = '<html>'.
						'<head><title>CENCOSUD- Bonus App</title></head>'.
							'<body><h1>Modificación salarial</h1>'.
							"Se ha RECHAZADO la modificación salarial para el empleado: ".$empleado->nombre_completo.
							'<hr>'.
							'Número de Legajo  : '.$empleado->legajo.'<br>'.
							'Salario Actual    : '.$empleado->salario_enero.'<br>'.
							'Ajuste Salario (%): '.$empleado->app_porcentaje_propuesto.'<br>'.
							'Ajuste Salario ($): '.$empleado->app_salario_propuesto.'<br>'.
							'<hr>'.
							'POC - Interservices 2018'.
							'</body>'.
						'</html>';			
		
		}

		// $this->notificarModificaciones($contenidoNotificacion);

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
}
?>
