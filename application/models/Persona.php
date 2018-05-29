<?php
/**
 * Created by PhpStorm.
 * User: zeros
 * Date: 27/05/2018
 * Time: 2:27 PM
 */
class Persona extends CI_Model{

	public function __construct()
	{
		parent::__construct();
	}


	public function iniciarSession($usuario,$contraseña){
		$query = $this->db->query("SELECT u.idUsuario,p.cedula, e.idPensum 
									FROM USUARIO u 
									inner join PERSONA p on u.idUsuario = p.idUsuario 
									inner join ESTUDIANTE e on e.idPersona = p.idPersona
									where usuario = '$usuario' and password = '$contraseña'");
		if($query->num_rows() > 0){
			$this->session->idUsuario = $query->row("idUsuario");
			$this->session->cedula = $query->row("cedula");
			$this->session->idPensum = $query->row("idPensum");
			return array("idUsuario"=>$query->row("idUsuario"),"cedula"=>$query->row("cedula"),"idPensum"=>$query->row("idPensum"));
		}
		else{
			return false;
		}
	}


	public function validarOnline(){
		return isset($this->session->idUsuario) ? true : false;
	}

}
