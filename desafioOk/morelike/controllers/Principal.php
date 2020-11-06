<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {
	var $cantidadBlog=5;
    public function __construct() {
        parent::__construct();
        $this->load->model('Modelo');
        $this->load->helper('url');
        //$cantidadBlog = 2;
        header("Content-Type: text/html; charset=utf-8");
        header("Accept-Encoding: gzip | compress | deflate | br| identity| * ");
    }
	public function index(){   
        $this->load->view("ingreso",array("error"=>""));
    }
	function loginIntra(){
		$this->load->view("ingreso",array("error"=>""));
	}
	function loginIntra2(){
		$rut 	= $this->input->post("rut");
		$clave 	= $this->input->post("clave");
		if($this->Modelo->loginIntra($rut,$clave)){//Falta en el modelo
			$infor = $this->Modelo->buscaInfoPersona($rut); //Falta en el modelo
			$nombre = "";
			$acceso = "";
			$id = 0;
			$super =0;
			$areas = array(); $roles = array(); $idAreas = array();
			$i=0;
			//print_r($infor->result());
			foreach ($infor->result() as $row) {
				$nombre = $row->nombre;
				$acceso = $row->acceso;
				$super 	= $row->rol;
				$id 	= $row->id;

				if($infor->num_rows()>=1){
					if(isset($row->nombreCentro) && isset($row->idce) && isset($row->rol)){
						$areas[$i] = $row->nombreCentro;
						$idAreas[$i] = $row->idce;
						$i++;
					}
				}
			}
			$data   =   array(
            	'logged_in' => TRUE,
            	'rut' 		=> $rut,
            	'id' 		=> $id,
            	'acceso'	=> $acceso,
            	'nombre'	=> $nombre,
            	'areas' 	=> $areas,
            	'idAreas' 	=> $idAreas,
            	'super' 	=> $super
        	);
        	$this->session->set_userdata($data);
			echo '{"res":"0"}';
		}else{
			$data   =   array(
	            'logged_in' => FALSE
	        );
			$this->session->set_userdata($data);
			echo '{"res":"1"}';
		}
		
	}
	function intranet(){
		if($this->session->userdata("logged_in")==TRUE){
			$object['controller']=$this; 
			$this->load->view("index", $object);
			$this->load->view("footer2");
		}else{
			$this->loginIntra();
		}
	}
	
	function log_out(){
		$this->session->sess_destroy();
		redirect(base_url()."Intranet");
	}
	function newArea(){
		$res['areas'] = $this->Modelo->listarAreas();
		$this->load->view("newArea",$res);
	}
	function addNewArea(){
		$area = $this->input->post("area");
		$direccion = $this->input->post("direccion");
		$op   = $this->input->post("op");
		$id   = $this->input->post("id");
		if(strlen(trim($area))>0):
			$res['error'] = $this->Modelo->addNewArea($area,$direccion,$op,$id);
			$res['links'] = $this->Modelo->buscaLinks()->result();
		else:
			$res['error'] = true;
		endif;
		echo json_encode($res);
	}
	function cambiarEstadoArea(){
		$estado = $this->input->post("estado");
		$id 	= $this->input->post("id");
		$this->Modelo->cambiarEstadoArea($estado,$id);
	}
	function nuevoProcedimiento(){
		//Buscar los últimos procedimientos almacenados...
		$result = $this->Modelo->buscarUltimosRegistros();
		$res['data'] = $result->result();
		$res['cant'] = $result->num_rows();
		$ultimo =0;
 		foreach ($result->result() as $row) {
			$ultimo = $row->id;
		}
		$res['ultimo'] =$ultimo;
		$this->load->view("nuevoProcedimiento",$res);
	}
	function saveProcedimiento(){
		$descripcion = $this->input->post("descripcion");
		$ingreso 	 = $this->input->post("ingreso");
		$egreso 	 = $this->input->post("egreso");
		$this->Modelo->saveProcedimiento($descripcion,$ingreso,$egreso);
	}
	function traeMasRegistros(){
		$desde = $this->input->post("desde");
		$result = $this->Modelo->buscarUltimosRegistrosDesde($desde);
		$res['data'] = $result->result();
		$res['cant'] = $result->num_rows();
		$ultimo =0;
 		foreach ($result->result() as $row) {
			$ultimo = $row->id;
		}
		$res['ultimo'] =$ultimo;
		echo json_encode($res);
	}
	function newUser(){
		$res['users'] = $this->Modelo->listarUsers();
		$this->load->view("newUser",$res);
	}
	function addNewUser(){
		$rut 			= $this->input->post("rut");
		$nombre 		= $this->input->post("nombre");
		$clave 			= $this->input->post("clave");
		$fNac 			= $this->input->post("fNac");
		$especialidad 	= $this->input->post("especialidad");
		$cargo 			= $this->input->post("cargo");
		$op = $this->input->post("op");
		$id = $this->input->post("id");
		if(strlen(trim($rut))>0 && strlen(trim($nombre))>0 && strlen(trim($clave))>0):
			$res['error'] = $this->Modelo->addNewUser($rut, $nombre, $clave,$fNac,$especialidad,$cargo,$op,$id);
		else:
			$res['error'] = true;
		endif;
		echo json_encode($res);
	}
	function buscaUsuario(){
		$rut = $this->input->post("rut");
		$res = $this->Modelo->buscaUsuario($rut);
		echo json_encode($res);
	}
	function cambiarEstadoUser(){
		$estado = $this->input->post("estado");
		$id 	= $this->input->post("id");
		$this->Modelo->cambiarEstadoUser($estado,$id);
	}
	function newLink(){
		$res['links'] 		= $this->Modelo->listarLinks();
		$res['usuarios'] 	= $this->Modelo->listarUsersActivos();
		$res['areas'] 		= $this->Modelo->listarAreasActivas();
		$this->load->view("newLink",$res);
	}
	function addNewLink(){
		$usuario 	=$this->input->post("usuario");
		$area 		=$this->input->post("area");
		$op 		=$this->input->post("op");
		$id 		=$this->input->post("id");
		$this->Modelo->addNewLink($usuario,$area,$op,$id);
	}
	function cambiarEstadoLink(){
		$estado = $this->input->post("estado");
		$id 	= $this->input->post("id");
		$this->Modelo->cambiarEstadoLink($estado,$id);
	}
	function deleteLink(){
		$id = $this->input->post("id");
		$this->Modelo->deleteLink($id);
	}
	function entrarArea(){
		$idArea 	= $this->input->post("area");
		$nombreArea = $this->input->post("nombre");
		
		$data['area'] 	= $nombreArea;
		$data['id']   	= $idArea;
		
		//Debo buscar el listado de archivos que se han cargado en esa area.
		$this->load->view("entrarArea",$data);
	}
	function validaClave0(){
		$claveVieja = $this->input->post("claveVieja");
		$res = $this->Modelo->loginIntra($this->session->userdata("rut"),$claveVieja);
		echo json_encode(array("res"=>$res));
	}
	function cambiarClave(){
		$clave = $this->input->post("clave");
		$this->Modelo->cambiarClave($clave);
	}
	function modificarRegistro(){
		$id = $this->input->post("id");
		$descripcion = $this->input->post("descripcion");
		$ingreso 	 = $this->input->post("ingreso");
		$egreso 	 = $this->input->post("egreso");
		$fecha 	 = $this->input->post("fecha");
		$this->Modelo->modificarRegistro($id,$descripcion,$ingreso,$egreso,$fecha);
	}

	function eliminarRegistro(){
		$id = $this->input->post("id");
		$this->Modelo->eliminarRegistro($id);
	}

	function newInforme(){
		$result = $this->Modelo->buscarUltimosRegistros();
		$res['data'] = $result->result();
		$res['cant'] = $result->num_rows();
		$ultimo =0;
 		foreach ($result->result() as $row) {
			$ultimo = $row->id;
		}
		$res['ultimo'] =$ultimo;


		$result = $this->Modelo->listarUsersOrdenados();
		$res['users'] = $result;
		$result = $this->Modelo->calculoRegistrosPorDia();
		$res['registros'] = $result;
		$this->load->view("newInforme",$res);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
