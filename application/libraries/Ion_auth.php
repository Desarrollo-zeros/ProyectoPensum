<?php
/**
 * Created by PhpStorm.
 * User: zeros
 * Date: 27/05/2018
 * Time: 7:50 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require __DIR__ . '/vendor/autoload.php';

USE \Firebase\JWT\JWT;

class Ion_auth {
	public $CI = NULL;
	private $key = "example_key";
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
	}

	function get_hashed_password($username,$password){
			$rest_real = $this->CI->config->item('rest_realm');
			$query = $this->CI->db->query("SELECT *FROM AUTENTIFICACION where usuario = '$username' and password = MD5('$username:$rest_real:$password')");
			//echo json_encode($query->row());
			if($query->num_rows()>0){
				return $query->row("password");
			}

	}
	public function jwt($datos = array()){

		$tokenId    = base64_encode(mcrypt_create_iv(32));
		$issuedAt   = time();
		$notBefore  = $issuedAt + 10;             //se le agrega 10 segundo mas al tocket
		$expire     = $notBefore + 3600;            //tiempo de expiracion, en segundo(60) = 1min
		$serverName = base_url(); // nombre del servidor..

		$data = [
			'iat'  => $issuedAt,         // Tiempo generacion del tocket
			'jti'  => $tokenId,          // identificador unico para el tocket
			'iss'  => $serverName,       // server
			'nbf'  => $notBefore,        // tiempo despues de creacion del tocket
			'exp'  => $expire,           // tiempo de expiracion
			'data' => [                  // array
				$datos
			]
		];
		$jwt = JWT::encode($data, $this->key);
		return($jwt);
	}


	public function jwtDecode($string){
		$decoded = JWT::decode($string, $this->key, array('HS256'));
		return $decoded;
	}



	function cors() {

		// Allow from any origin
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
			// you want to allow, and if so:
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}

		// Access-Control headers are received during OPTIONS requests
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				// may also be using PUT, PATCH, HEAD etc
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

			exit(0);
		}

		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Allow: GET, POST, OPTIONS, PUT, DELETE");
	}
}
