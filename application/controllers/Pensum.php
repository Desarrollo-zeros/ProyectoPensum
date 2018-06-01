<?php
/**
 * Created by PhpStorm.
 * User: zeros
 * Date: 26/05/2018
 * Time: 2:31 AM
 */


class Pensum extends CI_Controller{

	public function iniciarSession($usuario,$contraseña){
		if(isset($usuario) && isset($contraseña)){
			if(!empty($this->P->iniciarSession(strtolower($usuario),strtolower($contraseña)))){
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

	public function obtenerInformacion($cedula,$idPensumV,$idPensumN){
		if(isset($this->session->idUsuario)){
			if(!empty($this->M->cargarDatosEstudiante($cedula,$idPensumV,$idPensumN))){
				echo json_encode($this->M->cargarDatosEstudiante($cedula,$idPensumV,$idPensumN));
			}else{
				echo  json_encode(array("estado"=>false));
			}
			exit(0);
		}
		redirect("");
	}

	public function obtenerPensum($id){
		if(isset($this->session->idUsuario)){
			echo json_encode($this->M->buscarPensum($id));
			exit(0);
		}
		redirect("");
	}

	public function loadSession(){
		if(isset($this->session->idUsuario)){
			if(!empty($this->P->iniciarSession(strtolower(''),strtolower('')))){
				//echo json_encode(array("idUsuario" => $this->session->idUsuario,"cedula" => $this->session->cedula,"estado" => true));
				echo json_encode($this->P->iniciarSession(strtolower(''),strtolower('')));
				exit();
			}
			else{
				echo json_encode(array("estado" => false));
				exit();
			}
		}
	}
}
