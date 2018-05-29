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
		//echo (json_encode($this->M->cargarDatosEstudiante("1065833705",4,5)));
/*
		$curl_handle = curl_init();


		$username = 'admin';
		$password = 'admin';

		curl_setopt($curl_handle, CURLOPT_URL, 'http://localhost/pensum/Rest_server/test');
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
			'$username' => "zeros",
			'password' => "toor"
		));

		// Optional, delete this line if your API is open
		curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);

		$buffer = curl_exec($curl_handle);
		curl_close($curl_handle);

		$result = json_decode($buffer);

		print_r($result);

*/

	$this->load->view("rest_server");

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
