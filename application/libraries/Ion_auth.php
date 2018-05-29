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
		$notBefore  = $issuedAt + 10;             //Adding 10 seconds
		$expire     = $notBefore + 60;            // Adding 60 seconds
		$serverName = base_url(); // Retrieve the server name from config file



		$data = [
			'iat'  => $issuedAt,         // Issued at: time when the token was generated
			'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
			'iss'  => $serverName,       // Issuer
			'nbf'  => $notBefore,        // Not before
			'exp'  => $expire,           // Expire
			'data' => [                  // Data related to the signer user
				$datos
			]
		];

		$jwt = JWT::encode($data, $this->key);
		return($jwt);

		//$jwt =  'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsImF1ZCI6Imh0dHA6XC9cL2V4YW1wbGUuY29tIiwiaWF0IjoxMzU2OTk5NTI0LCJuYmYiOjEzNTcwMDAwMDB9.KcNaeDRMPwkRHDHsuIh1L2B01VApiu3aTOkWplFjoYI'; //JWT::encode($token, $key);
		//$jwt = JWT::encode($token, $key);
		//JWT::$leeway = 1; // $leeway in seconds
		//$decoded = JWT::decode($jwt, $key, array('HS256'));
		//var_dump($decoded);
	}


	public function jwtDecode($string){
		$decoded = JWT::decode($string, $this->key, array('HS256'));
		return $decoded;
	}



	public function cors() {

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
	}
}
