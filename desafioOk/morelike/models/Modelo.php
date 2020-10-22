<?php
class Modelo extends CI_Model{
    function loginIntra($rut,$clave){
        $this->db->select("*");
        $this->db->where("rut",$rut);
        $this->db->where("clave",md5($clave));
        $this->db->where("estado",0);
        $res = $this->db->get("usuario")->num_rows();
        if($res > 0){
            return true;
        }
        return false;
    }
    function buscaUsuario($rut){
        $this->db->select("*");
        $this->db->where("rut",$rut);
        $res = $this->db->get("usuario")->result();
        return $res;
    }
    function buscaInfoPersona($rut){
        $this->db->select("*");
        $this->db->where("rut",$rut);
        $res = $this->db->get("usuario")->result();
        $super =0;
        foreach ($res as $row) {
            $super = $row->rol;
        }
        /*if($super == 0){*/
            $sql = "select usuario.id, usuario.nombre, usuario.rut, usuario.acceso, usuario.rol, centro.id as idce, centro.nombre as nombreCentro from usuario 
                join usce on usuario.id = usce.idus
                join centro on centro.id = usce.idce where usuario.rut = '".$rut."' order by centro.nombre";
        /*}else{
            $sql = "select * from usuario where usuario.rut = '".$rut."';";
        }*/
        //echo $sql;
        $res = $this->db->query($sql);
        if($res->num_rows() == 0){
            $sql = "select * from usuario where usuario.rut = '".$rut."';";
            $res = $this->db->query($sql);
        }
        $data['acceso'] = Date("Y-m-d H:i:s");
        $this->db->where("rut",$rut);
        $this->db->update("usuario",$data);
        //$this->historialIntranet("Tabla: usuario - Cambio info Usuario - Rut: ".$rut." acceso: ".$data['acceso']);
        //print_r($res);
        return $res;
    }
    function savePaciente($rut, $nombre,$apellido,$fNac,$edad,$telefono,$correo,$domicilio){
        //Se deberá buscar si es paciente nuevo... si es el mismo solo se actalizará la información.
        $info = array("rut"=>$rut,"nombre"=>$nombre, "apellido"=>$apellido,"fNac"=>$fNac,"edad"=>$edad,"telefono"=>$telefono,"correo"=>$correo,"domicilio"=>$domicilio);

        $this->db->where("rut",$rut);
        $res = $this->db->get("paciente");
        if($res->num_rows()>0){
            //Se actualiza...
            $this->db->where("rut",$rut);
            $this->db->update("paciente",$info);
        }else{
            //Se crea...
            $this->db->insert("paciente",$info);
        }
    }
    function saveProcedimiento($descripcion, $ingreso, $egreso){
        //Falta calcular el saldo...
        //Saldo será la diferencia entre el saldo anterior +Ingreso -Egreso
        $sql = "select saldo from registros order by id desc limit 1";
        $res = $this->db->query($sql);
        $saldo =0;
        foreach ($res->result() as $row) {
            $saldo = $row->saldo;
        }
        $saldo = $saldo + $ingreso - $egreso;
        $data = array("descripcion"=>$descripcion,"fecha"=>Date("Y-m-d H:i:s"),"ingreso"=>$ingreso,"egreso"=>$egreso, "saldo"=>$saldo);
        $this->db->insert("registros",$data);
    }
    function buscarPacienteRut($rut){
        $this->db->where("rut",$rut);
        return $this->db->get("paciente")->result();
    }
    function buscarPacientes(){
        $res = $this->db->get("paciente")->result();
        $result = array();
        foreach ($res as $row) {
            array_push($result, $row->rut." ".$row->nombre." ".$row->apellido);
        }
        return $result;
    }
    function buscarFichasPaciente($rut){
        $sql = "select ficha.*, usuario.nombre as name, usuario.apellido as lastname, usuario.especialidad from ficha join usce on usce.idus = ficha.idus join usuario on usce.idus = usuario.id where idPaciente = '".$rut."' order by fechahora desc";
        /*$this->db->where("idPaciente",$rut);
        $this->db->order_by("fechahora","desc");
        return $this->db->get("ficha");*/
        return $this->db->query($sql);
    }
    /*function saveFirma($firma){
        $data = array("firma"=>$firma);
        $this->db->insert("firmas",$data);
        return $this->db->insert_id();
    }
    function buscaFirma($id){
        $this->db->where("id",$id);
        $res = $this->db->get("firmas");
        foreach ($res->result() as $row) {
            return $row->firma;
        }
    }*/
    function listarAreas(){
        $this->db->select("*");
        $this->db->order_by("estado");
        $this->db->order_by("nombre");
        return $this->db->get("centro")->result();
    }
    function listarAreasActivas(){
        $this->db->select("*");
        $this->db->where("estado",0);
        return $this->db->get("centro")->result();
    }
    function addNewArea($area,$direccion,$op,$id){
        if($op==0){
            //echo "QL";
            $sql = "select * from centro where centro.nombre = '".$area."'";
            $res = $this->db->query($sql)->num_rows();
            if($res > 0 ){
                return true;
            }else{
                $data['nombre'] = $area;
                $data['direccion'] = $direccion;
                $this->db->insert("centro",$data);
                $this->addNewLink($this->session->userdata("id"),$this->db->insert_id(),0,0);
                $this->historialIntranet("Tabla: centro - Insercion centro - nombre: ".$area);
                return false;
            }
        }else{
            $sql = "select * from centro where centro.nombre = '".$area."' and id !=".$id;
            $res = $this->db->query($sql)->num_rows();
            if($res > 0 ){
                return true;
            }else{
                $data['nombre'] = $area;
                $data['direccion'] = $direccion;
                $this->db->where("id",$id);
                $this->db->update("centro",$data);
                $this->historialIntranet("Tabla: centro - Cambio nombre - Id: ".$id." nombre: ".$area);
                return false;
            }
        }
    }
    function cambiarEstadoArea($estado,$id){
        $data['estado'] = $estado;
        $this->db->where("id",$id);
        $this->db->update('centro',$data);
        $this->historialIntranet("Tabla: centro - Cambio de Estado - Id: ".$id." estado: ".$estado);

        $this->db->where("idce",$id);
        $this->db->update('usce',$data);
        $this->historialIntranet("Tabla: ua - Cambio de Estado - Id: ".$id." estado: ".$estado);
    }
    function listarUsers(){
        $this->db->select("*");
        $this->db->where("rol",0);
        $this->db->order_by("nombre");
        return $this->db->get("usuario")->result();
    }
    function listarUsersActivos(){
        $this->db->select("*");
        //$this->db->where("rol",0);
        $this->db->where("estado",0);
        $this->db->order_by("nombre");
        return $this->db->get("usuario")->result();
    }
    function addNewUser($rut, $nombre, $clave,$fNac,$especialidad,$cargo, $op, $id){
        //si op = 0 es Insert de nuevo usuario.. si op = 1 es update.
        if($op == 0){
            $sql = "select * from usuario where rut = '".$rut."'";
            $res = $this->db->query($sql)->num_rows();
            if($res > 0 ){
                return true;
            }else{
                $data['rut'] = $rut;
                $data['nombre'] = $nombre;
                $data['clave'] = md5($clave);
                $data['fnac'] = $fNac;
                $data['especialidad'] = $especialidad;
                $data['rol']    = $cargo;
                $this->db->insert("usuario",$data);
                $this->historialIntranet("Tabla: usuario - Insercion de User - Rut: ".$rut." Nombre: ".$nombre);

                return false;
            }
        }else{
            //Valido que el nuevo usuario no esté repetido con su rut
            $sql = "select * from usuario where rut = '".$rut."' and id !=".$id;
            $res = $this->db->query($sql)->num_rows();
            if($res > 0 ){//Significa que hay otro usuario anterior con el mismo rut
                return true;
            }else{
                //Solo debo actualizar la clave si es que el usuario ingresó una nueva clave, por lo que deberé comparar el hash que viene con el que ya está en la base de datos.
                $sql = "select * from usuario where clave = '".$clave."' and id =".$id;
                $res1 = $this->db->query($sql)->num_rows();
                if($res1 == 0){
                    $data['clave'] = md5($clave);
                }
                $data['rut'] = $rut;
                $data['nombre'] = $nombre;
                $this->db->where("id",$id);
                $this->db->update("usuario",$data);
                $this->historialIntranet("Tabla: usuario - Cambio de User - Id: ".$id." Nombre: ".$nombre);
                return false;
            }
        }
    }
    function cambiarEstadoUser($estado,$id){
        $data['estado'] = $estado;
        $this->db->where("id",$id);
        $this->db->update('usuario',$data);
        $this->historialIntranet("Tabla: usuario - Cambio de Estado User - Id: ".$id." Estado: ".$estado);
    }
    function listarLinks(){
        $sql = "select usuario.id as idu, usuario.nombre, usuario.rut, usuario.estado as estadousuario, centro.id as idc, centro.nombre, centro.estado as estadocentro, usce.estado as estadousce, usce.idce from usce join usuario on usuario.id = usce.idus join centro on centro.id = usce.idce order by usuario.nombre, centro.nombre";
        return $this->db->query($sql)->result();
    }
    function buscaLinks(){
        $sql = "select * from usce join centro on centro.id = usce.idce where idus = ".$this->session->userdata("id")." and centro.estado=0 order by centro.nombre asc";
        $res = $this->db->query($sql);
        return $res;
    }
    function addNewLink($usuario,$area,$op,$id){
        if($op==0){
            $sql = "select * from usce where usce.idus = ".$usuario." and usce.idce = ".$area;
            $res = $this->db->query($sql);
            if($res->num_rows() == 0){
                $data['idce'] = $area;
                $data['idus'] = $usuario;
                $data['fecha'] = Date("Y-m-d");
                $this->db->insert("usce",$data);
                $this->historialIntranet("Tabla: usce - Insercion de Link - Area: ".$area." Usuario: ".$usuario);
                return false;
            }else{
                return true;
            }
        }else{
            $sql = "select * from usce where usce.idus = ".$usuario." and usce.ida = ".$area." and usce.id !=".$id;
            $res = $this->db->query($sql);
            if($res->num_rows() == 0){
                $data['idce'] = $area;
                $data['idus'] = $usuario;
                $data['rol'] = $rol;
                $this->db->where("id",$id);
                $this->db->update("usce",$data);
                $this->historialIntranet("Tabla: usce - Cambio de Link - Area: ".$area." Usuario: ".$usuario." Rol: ".$rol);
                return false;
            }else{
                return true;
            }
        }
    }
    function cambiarEstadoLink($estado,$id){
        $data['estado'] = $estado;
        $this->db->where("id",$id);
        $this->db->update('usce',$data);
        $this->historialIntranet("Tabla: usce - Cambio Estado de Link ".$id." Estado: ".$estado);
    }
    function deleteLink($id){
        $this->db->where("id",$id);
        $this->db->delete("ua");
        $this->historialIntranet("Tabla: ua - Eliminacion de Link ".$id);
    }
    function subirFichero($idarea,$cadenaArchivos,$fecha,$user, $ubicacion,$para){
        $data['area'] = $idarea;
        $data['nombre'] = $cadenaArchivos;
        $data['fecha'] = Date("Y-m-d H:i:s");
        $data['user'] = $user;
        $data['ubicacion'] = $ubicacion;
        $data['para'] = $para;
        
        $this->db->select("*");
        $this->db->where('area',$idarea);
        $this->db->where('nombre',$cadenaArchivos);
        $this->db->where('para',$para);
        $res = $this->db->get('fichero')->num_rows();
        if($res == 0){
            $this->db->insert("fichero",$data);
            $this->historialIntranet("Tabla: Fichero - Archivo: ".$cadenaArchivos." - Insercion el documento en la ubicacion ".$ubicacion);
        }
    }
    function buscaFicherosSubidos($area){
        $sql = "select * from fichero where area = ".$area." and (para = 'all' or para = '".$this->session->userdata("rut")."')";
        return $this->db->query($sql);
        /*$this->db->select("*");
        $this->db->where("area",$area);
        $this->db->where("para",$para);
        return $this->db->get("fichero");*/
    }
    function eliminarFichero($id, $ubicacion,$nombre){
        $this->historialIntranet("Tabla: Fichero - Archivo: ".$id." - Eliminacion de la ubicación ".$ubicacion);
        unlink($ubicacion.$nombre);
        $this->db->where("id",$id);
        return $this->db->delete("fichero");
    }
    function cambiarEstadoFile($estado, $id){
        $data['estado'] = $estado;
        $this->db->where("id",$id);
        $this->db->update('fichero',$data);
        $this->historialIntranet("Tabla: Fichero - Archivo: ".$id." - Cambio de Estado a ".$estado);
    }
    function cambiarClave($clave){
        $data['clave'] = md5($clave);
        $this->db->where("rut",$this->session->userdata("rut"));
        $this->db->update("usuario",$data);
        $this->historialIntranet("Tabla: usuario - Cambio de clave del usuario");
    }
    function historialIntranet($accion){
        $data['user']   = $this->session->userdata("rut");
        $data['fecha']  = Date("Y-m-d H:i:s");
        $data['accion'] = $accion;
        $this->db->insert("historial",$data);
    }
    function leerDocumento($id, $area, $nombre){
        $this->db->select("*");
        $this->db->where("idarchivo",$id);
        $this->db->where("usuario",$this->session->userdata("rut"));
        $res = $this->db->get("archivosleidos")->num_rows();
        if($res == 0){
            //Se abrió por primera vez
            $data['idarchivo'] = $id;
            $data['area'] = $area;
            $data['nombre'] = $nombre;
            $data['usuario'] = $this->session->userdata("rut");
            $data['fecha'] = Date("Y-m-d H:i:s");
            $this->db->insert("archivosleidos",$data);
        }else{
            //Se actualiza la fecha de apertura
            $data['fecha'] = Date("Y-m-d H:i:s");
            $this->db->where("idarchivo",$id);
            $this->db->where("usuario",$this->session->userdata("rut"));
            $this->db->update("archivosleidos",$data);
        }
    }
    function buscarLeidos($id){
        $sql = "select usuario.nombre from usuario join archivosleidos on usuario.rut = archivosleidos.usuario where archivosleidos.idarchivo = ".$id." order by usuario.nombre";
        return $this->db->query($sql);
    }
    function rutCompleto($rut){
        $sql = "select rut from usuario where rut like '".$rut."%'";
        $res = $this->db->query($sql)->result();
        foreach ($res as $row) {
            return $row->rut;
        }
    }

    function buscarUltimosRegistros(){
        $sql = "select * from registros order by fecha desc limit 10";
        return $this->db->query($sql);
    }
    function buscarUltimosRegistrosDesde($desde){
        $sql = "select * from registros where id <".$desde." order by fecha desc limit 10";
        return $this->db->query($sql);
    }
}
?>
