<?php
/**
 * Created by PhpStorm.
 * User: zeros
 * Date: 26/05/2018
 * Time: 2:31 AM
 */


class Pensum extends CI_Controller{
					//inicia session y guarda variable en cokies
	public function iniciarSession($usuario,$contraseña){
		if(isset($usuario) && isset($contraseña)){
			$idUsuario = '';
			if(!empty($this->P->iniciarSession(strtolower($usuario),strtolower($contraseña),$idUsuario))){
				//echo json_encode(array("idUsuario" => $this->session->idUsuario,"cedula" => $this->session->cedula,"estado" => true));
				echo json_encode($this->P->iniciarSession(strtolower($usuario),strtolower($contraseña)));
				exit();
			}
			else{
				echo json_encode(array("estado" => false));
				exit();
			}
		}
		else{
			echo json_encode(array("estado" => false));
			exit();
		}
	}
												//idPensumViejo, //idPensumNuevo
	public function obtenerInformacion($cedula,$idPensumV,$idPensumN){
		if(!empty($this->M->cargarDatosEstudiante($cedula,$idPensumV,$idPensumN))){
			echo json_encode($this->M->cargarDatosEstudiante($cedula,$idPensumV,$idPensumN));
		}else{
			echo  json_encode(array("estado"=>false));
		}
	}
									//cualquierIdpensum
	public function obtenerPensum($idPensum,$idusuario = ''){
		if(isset($idusuario)){
			echo json_encode($this->M->buscarPensum($idPensum,$idusuario));
			exit(0);
		}
		redirect("");
	}
					//carga los datos de la sessiones existentes
	public function loadSession($idusuario){
		if(isset($idusuario)){
			if(!empty($this->P->iniciarSession(strtolower(''),strtolower(''),$idusuario))){
				//echo json_encode(array("idUsuario" => $this->session->idUsuario,"cedula" => $this->session->cedula,"estado" => true));
				echo json_encode($this->P->iniciarSession(strtolower(''),strtolower(''),$idusuario));
				exit();
			}
			else{
				echo json_encode(array("estado" => false));
				exit();
			}
		}
	}

	public function index(){
		$this->load->view("welcome_message");
	}

	public function uploadPdf(){

		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'pdf';
		$config['max_filename'] = '255';
		$config['encrypt_name'] = TRUE;
		$config['max_size'] = '1024'; //1 MB

		$this->load->library('upload', $config);

		/*if ( ! $this->upload->do_upload('userfile'))
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$this->load->view('upload_success', $data);
		}
		*/
		echo json_encode($this->input->file());

	}
}
