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
		$this->load->library("Herramientas");
	}

	public function iniciarSession($usuario,$password,$idusuario = ''){

		if(empty($usuario) && empty($password) && isset($idusuario)){

			$query = $this->db->query("SELECT u.idUsuario,p.cedula, e.idPensum, c.idCarrera, CONCAT(p.primerNombre,' ',p.segundoNombre) as nombre,
								CONCAT(p.primerApellido,' ',p.segundoApellido) as apellido
									FROM USUARIO u 
									inner join PERSONA p on u.idUsuario = p.idUsuario 
									inner join ESTUDIANTE e on e.idPersona = p.idPersona
									inner join PENSUM pe on pe.idPensum = e.idPensum
									inner join CARRERA c on c.idCarrera = pe.idCarrera
									where u.idUsuario = $idusuario ");
		}
		else{
			$query = $this->db->query("SELECT u.idUsuario,p.cedula, e.idPensum, c.idCarrera, CONCAT(p.primerNombre,' ',p.segundoNombre) as nombre,
								CONCAT(p.primerApellido,' ',p.segundoApellido) as apellido
									FROM USUARIO u 
									inner join PERSONA p on u.idUsuario = p.idUsuario 
									inner join ESTUDIANTE e on e.idPersona = p.idPersona
									inner join PENSUM pe on pe.idPensum = e.idPensum
									inner join CARRERA c on c.idCarrera = pe.idCarrera
									where usuario = '$usuario' and password = '$password'");
		}
		if($query->num_rows() > 0){
			$this->session->idUsuario = isset($this->session->idUsuario) ? $this->session->idUsuario : $query->row("idUsuario");
			$idPensumN = $this->obtenerPensumNuevo($query->row("idPensum"),$query->row("idCarrera"))->row("idPensum");
			$data = array(
				"idUsuario" => $query->row("idUsuario"),
				"cedula" => $query->row("cedula"),
				"idPensumV" => $query->row("idPensum"),
				"idPensumN" => $idPensumN,
				"idCarrera" => $query->row("idCarrera"),
				"estado" => true
			);
			$this->session->set_userdata($data);
			return $data;
		}
		else{
			return false;
		}
	}

	public function obtenerPensumNuevo($idPensumN,$idCarrera){
		return $this->db->query("select p.idPensum FROM PENSUM p
						  inner join CARRERA c on c.idCarrera = p.idCarrera 
						  where c.idCarrera = $idCarrera and p.idPensum <> $idPensumN limit 1");
	}

	public function validarOnline(){
		return isset($this->session->idUsuario) ? true : false;
	}

}
