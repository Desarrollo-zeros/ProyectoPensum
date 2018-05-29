<?php
/**
 * Created by PhpStorm.
 * User: zeros
 * Date: 27/05/2018
 * Time: 10:35 AM
 */
class Materias extends  CI_Model{

	public function __construct()
	{
		parent::__construct();
	}


	public function cargarDatosEstudiante($cedula,$idPensumA, $idPensumN){
		$datos = $this->consultarDatosGenerales($cedula,$idPensumA, $idPensumN);
		$perdidas = $this->unique_multidim_array_obj($this->consultarMateriasPerdidas($cedula,$idPensumA),"codigo");
		$ganadas = $this->unique_multidim_array_obj($this->consultarMateriasGanadas($cedula,$idPensumA),"codigo");
		$perdidas1 = array();

		foreach ($perdidas as $row){
			if(!$this->is_in_array($ganadas,"codigo",$row->codigo,1)){
				array_push($perdidas1,array("codigo"=>$row->codigo,"nombre"=>$row->nombre));
			}
		}

		$ganadasYhomologadas = array();
		$homologadas = $this->consultarHomologadas($cedula,$idPensumN);


		for($i=0;$i<count($ganadas);$i++){
			for($j=0;$j<count($homologadas);$j++){
				if($ganadas[$i]->idMateriaA == $homologadas[$j]->idMateriaA){
					array_push($ganadasYhomologadas,array(
						"codigo" => $ganadas[$i]->codigo,
						"nombre" => $ganadas[$i]->nombre,
						"homologada" => array_filter($this->homologadasYganadas($homologadas,$homologadas[$j]->idMateriaA))
					));
				}
			}
		}


		$ganadasYhomologadas = $this->unique_multidim_array($ganadasYhomologadas,"codigo");


		$data = array(
			"nombre"=> $datos->row("nombre"),
			"apellido" => $datos->row("apellido"),
			"cedula" => $datos->row("cedula"),
			"semestre" => $datos->row("semestre"),
			"vCreditos" => $datos->row("vCreditos"),
			"nCreditos" => $datos->row("nCreditos"),
			"materias" => array(
				"ganadas" => $ganadasYhomologadas,
				"perdidas" => ($perdidas1)
			),
		);


		return ($data);
	}

	public function homologadasYganadas($data = array(),$idMateria){
		$homologadas = array();
		foreach ($data as $row){
			if($row->idMateriaA == $idMateria){
				array_push($homologadas,array("codigo"=>$row->codigo,"nombre"=>$row->nombre));
			}
		}
		return $homologadas;
	}

	public function consultarDatosGenerales($cedula,$idPensumA, $idPensumN){
		return $this->db->query("select p.cedula, CONCAT(p.primerNombre,' ',p.segundoNombre) as nombre, CONCAT(p.primerApellido,' ',p.segundoApellido) as apellido,
								  e.semestre,
								 (select sum(creditos)
									from MATERIA m 
									inner join NOTAS n on m.idMateria = n.idMateria
									inner join ESTUDIANTE e on e.idEstudiante = n.idEstudiante
									inner join PERSONA p on p.idPersona = e.idPersona where p.cedula = '$cedula' and n.nota >= 3.0  and e.idPensum =$idPensumA) as vCreditos,
								 (select sum(mn.creditos)
								 from MATERIA vm
								 inner join NOTAS n on n.idMateria = vm.idMateria
								 inner join ESTUDIANTE e on e.idEstudiante = n.idEstudiante
								 inner join PERSONA p on p.idPersona = e.idPersona
								 inner join REQUISITO eq on eq.idMateriaRequisito = vm.idMateria
								 inner join MATERIA mn on mn.idMateria = eq.idMateriaActual
								 where  p.cedula = '$cedula' and n.nota > 2.9 and mn.idPensum = $idPensumN) as nCreditos
								from PERSONA p 
								inner join ESTUDIANTE e on e.idPersona = p.idPersona 
								where p.cedula = '$cedula' and e.idPensum = $idPensumA");
	}

	public function consultarMateriasGanadas($cedula,$idPensum){
		return $this->db->query("select vm.codigo, vm.nombre,vm.idMateria as idMateriaA
								 from MATERIA vm
								 inner join NOTAS n on n.idMateria = vm.idMateria
								 inner join ESTUDIANTE e on e.idEstudiante = n.idEstudiante
								 inner join PERSONA p on p.idPersona = e.idPersona
								 where  p.cedula = '$cedula' and n.nota>=3.0 and e.idPensum = $idPensum order by vm.idMateria asc;")->result();
	}

	public function consultarMateriasPerdidas($cedula,$idPensum){
		return $this->db->query("select vm.codigo, vm.nombre
								 from MATERIA vm
								 inner join NOTAS n on n.idMateria = vm.idMateria
								 inner join ESTUDIANTE e on e.idEstudiante = n.idEstudiante
								 inner join PERSONA p on p.idPersona = e.idPersona
								 where  p.cedula = '$cedula' and n.nota<3.0 and e.idPensum = $idPensum order by n.nota asc;")->result();
	}

	public function consultarHomologadas($cedula, $idPensumN){
		return $this->db->query("select mn.codigo, mn.nombre, mn.idMateria as idMateriaN, vm.idMateria as idMateriaA
								 from MATERIA vm
								 inner join NOTAS n on n.idMateria = vm.idMateria
								 inner join ESTUDIANTE e on e.idEstudiante = n.idEstudiante
								 inner join PERSONA p on p.idPersona = e.idPersona
								 inner join REQUISITO eq on eq.idMateriaRequisito = vm.idMateria
								 inner join MATERIA mn on mn.idMateria = eq.idMateriaActual
								 where  p.cedula = '$cedula' and n.nota > 2.9 and mn.idPensum = $idPensumN order by vm.idMateria asc;")->result();
	}

	public function unique_multidim_array($array, $key) {
		$temp_array = array();
		$i = 0;
		$key_array = array();

			foreach($array as $val) {
				if (!in_array($val[$key], $key_array)) {
					$key_array[$i] = $val[$key];
					$temp_array[$i] = $val;
				}
				$i++;
			}
		return $temp_array;
	}

	public function unique_multidim_array_obj($array, $key) {
		$temp_array = array();
		$i = 0;
		$key_array = array();

		foreach($array as $val) {
			if (!in_array($val->{$key}, $key_array)) {
				$key_array[$i] = $val->{$key};
				$temp_array[$i] = $val;
			}
			$i++;
		}
		return $temp_array;
	}

	public function is_in_array($array = array(),$key,$value,$tipo){
		$within_array = false;


		if($tipo == 1){
			foreach($array as $row){
				if($row->{$key} == $value){
					return true;
				}
			}
		}
		else{
			foreach($array as $row){
				if($row[$key] == $value){
					return true;
				}
			}
		}
		return $within_array;
	}



}


