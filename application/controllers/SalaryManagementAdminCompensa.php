<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SalaryManagementAdminCompensa extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->library('table');
		$this->load->helper('url_helper');
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->library('fpdf');
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
					$dataPost['nomina'] = $this->nomina->getNominaReportesCompensa(
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
				
				/*				
				//$this->form_validation->set_rules("periodoPais", "Pais", "trim|required");
				if ($this->form_validation->run() == FALSE)
				{
					// Devuelve el listado completo.
					$dataPost['nomina'] = $this->nomina->getList();
					$this->loadViewMain($dataPost);
				}
				else
				{
					//Busco la Nómina por país.
					if($_POST('periodoPais')){
						// Busco el País del Período Seleccionado.
						$data['periodos'] = $this->period->getPeriod($_POST['periodoPais']);			
						// Devuelve el listado filtrado por país.
						$dataPost['nomina'] = $this->nomina->getNominaPais($periodos['pais']);
						$this->loadViewMain($dataPost);
					}
				}
				
*/
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
		$this->email->to($parametros->mail_notif);
		//$this->email->cc('them@their-example.com');
		$this->email->bcc('sberdia@gmail.com');

		
		$this->email->subject('CENCOSUD - Bonus App');
		$this->email->message($contenido);
		$this->email->set_mailtype('html');

		$this->email->attach('files/notificacion.pdf');
		
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
		$this->load->view('general/salarymanagementadmincompensa', $dataPost);
		$this->load->view('templates/footer', $dataPost);
   }

   public function loadViewPeriod($dataPost){
		$this->load->view('templates/header', $dataPost);
		$this->load->view('general/viewperiodcompensa', $dataPost);
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

		if(isset($_POST["finalizar"])){
			$this->nomina->updateNominaStatus($_POST['txtLegajo'], 'FINALIZADO');
		
			$contenidoNotificacion =
			$mensaje = '<html>'.
					'<head><title>CENCOSUD- Bonus App</title></head>'.
						'<body><h1>Modificación salarial</h1>'.
						"Se ha FINALIAADO la modificación salarial para el empleado: ".$empleado->nombre_completo.
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

		if(isset($_POST["revisar"])){
			$this->nomina->updateNominaStatus($_POST['txtLegajo'], 'REVISAR');

			$contenidoNotificacion =
			$mensaje = '<html>'.
					'<head><title>CENCOSUD- Bonus App</title></head>'.
						'<body><h1>Modificación salarial</h1>'.
						"Se debe REVISAR la modificación salarial para el empleado: ".$empleado->nombre_completo.
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

		if(isset($_POST["notificar"])){
			$this->nomina->updateNominaStatus($_POST['txtLegajo'], 'NOTIFICADO');
			// Genero el PDF.
			$this->generarPDF($empleado);
			// Envio el mail con el PDF adjunto.
			$contenidoNotificacion = '<html>'.
					'<head><title>CENCOSUD- Modificación Salarial</title></head>'.
						'<body><h1>Modificación salarial</h1>'.
						"Estimado/a ".$empleado->nombre_completo. ", adjuntamos una notificacion respecto de sus compensaciones.".'<br>'.
						'POC - Interservices 2018'.
						'</body>'.
					'</html>';			

			$this->notificarModificaciones($contenidoNotificacion);
		}
		
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

	public function generarPDF($empleado){
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Helvetica','',10);
		$pdf->Image('images/cenco_blue_logo.png',10,8,33);
		$pdf->Ln(50);
		// $txt = file_get_contents('files/carta.txt');

		// Defino el texto de la carta.
		$txt = '
		
		Estimada/o '.$empleado->nombre_completo.',
		
		Tenemos el agrado de comunicarte que se ha aprobado un ajuste salarial equivalente a un '.$empleado->app_porcentaje_propuesto.' % sobre tu Compensacion Bruta Mensual. Dado lo anterior, a partir de MES tu nueva esctructura de Compensacion estara compuesta por una Compensacion Bruta Mensual de $ '.$empleado->app_salario_propuesto.', mas un Bono Anual Teorico sujeto a evaluacion de resultados personales (FRI) como de la Compania (FRN), equivalente a 1 Compensacion Bruta Mensual. 
		
		Este incremento salarial, conforme a nuestra Politica Corporativa de Compensaciones, se fundamenta en tu Evaluacion de Desempeno del ano 2017, cuyo resultado fue '.$empleado->comp_eval_desempeno.', tu nivel oganizacional correspondiente a tu cargo y el posicionamiento de tu Compensacion Bruta Anual respecto a mercado. 
		
		Gracias por tu valioso aporte... en 2018 vamos por mas!
		
		Saludos Cordiales,
		
		
		
		





		Rodrigo Hetz
		Gerente Corporativo RRHH
		
		
		Pablo Fric
		Gerente de Sistemas de Gestión y Adm. de Compensacione Regional';								

		$pdf->MultiCell(0,5,$txt);
		// Guardar file y enviar por mail.
		$pdf->Output('F','files/notificacion.pdf');
		// Por pantalla.
		// $pdf->Output('notificacion.pdf','I');
	}

}
?>
