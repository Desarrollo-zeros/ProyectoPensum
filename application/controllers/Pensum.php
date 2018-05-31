<?php
/**
 * Created by PhpStorm.
 * User: zeros
 * Date: 26/05/2018
 * Time: 2:31 AM
 */

require APPPATH . 'libraries/Ion_auth.php';

class Pensum extends CI_Controller{


	public function index(){
		//echo json_encode($this->M->pensum(4)); //json_encode($this->M->cargarDatosEstudiante("1065833705",4,5));
		//var_dump($_SERVER['HTTP_ORIGIN']);
		echo 1;
	}

	public function iniciarSession($usuario,$contraseña){
		if(isset($usuario) && isset($contraseña)){
			if($this->P->iniciarSession(strtolower($usuario),strtolower($contraseña))){
				echo json_encode(array("idUsuario" => $this->session->idUsuario,"cedula" => $this->session->cedula,"estado" => true));
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

	public function cargarPensum(){
		if($this->P->validarOnline()){
			echo json_encode($this->M->cargarDatosEstudiante($this->session->cedula,$this->session->idPensum));
		}
	}









}
