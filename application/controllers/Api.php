<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Ion_auth.php';

class Api extends REST_Controller{

	function __construct()
	{
		// Construct the parent class
		parent::__construct();

		$this->Ion_auth = new Ion_auth();
		header("Access-Control-Allow-Origin: *");
		//$this->Ion_auth->cors();
		// Configure limits on our controller methods
		// Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
		$this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
		$this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
		$this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
	}


	public function test_get(){
		//$this->response((($this->P->iniciarSession($this->get("u"),$this->get("p")))));
	}

	public function test_post(){
		//
	}


	public function login_post(){
		//$this->reponse($this->post("usuario"));
		echo json_encode($this->post("usuario"));
		//$data = $this->response((($this->P->iniciarSession())));
	}


	public function login_get($usuario){
		//$this->Ion_auth->cors();
		//$this->reponse($usuario);
	}

}
