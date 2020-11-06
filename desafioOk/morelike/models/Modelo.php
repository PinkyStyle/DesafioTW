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
    function rutCompleto($rut){
        $sql = "UPDATE registros SET ";
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



    function modificarRegistro($id,$descripcion, $ingreso, $egreso){
        $sql = "select * from registros where id = $id;";
        $res = $this->db->query($sql);
        $saldo=0;
        foreach($res->result() as $row){
            $saldo = $row->saldo - $row->ingreso + $row->egreso;
        }
        $saldo= $saldo + $ingreso - $egreso;
        $sql = "UPDATE registros SET descripcion = '$descripcion', ingreso = $ingreso, egreso = $egreso, saldo = $saldo WHERE id = $id ;";
        $resultado = $this->db->query($sql);
        $sql = "select * from registros where registros.id > $id ORDER BY id ;";
        $res = $this->db->query($sql);
        foreach($res->result() as $row){
            $saldo = $saldo + $row->ingreso - $row->egreso;
            $sql = "UPDATE registros SET fecha = '$row->fecha', descripcion = '$row->descripcion', ingreso = $row->ingreso, egreso = $row->egreso, saldo = $saldo WHERE id = $row->id ;";
            $this->db->query($sql);
        }
        return $resultado;
    }

    function eliminarRegistro($id){
        $sql = "select * from registros where id = $id;";
        $res = $this->db->query($sql);
        $saldo=0;
        foreach($res->result() as $row){
            $saldo = $row->saldo - $row->ingreso + $row->egreso;
        }
        $sql = "select * from registros where registros.id > $id ORDER BY id ;";
        $res = $this->db->query($sql);
        foreach($res->result() as $row){
            $saldo = $saldo + $row->ingreso - $row->egreso;
            $sql = "UPDATE registros SET fecha = '$row->fecha', descripcion = '$row->descripcion', ingreso = $row->ingreso, egreso = $row->egreso, saldo = $saldo WHERE id = $row->id ;";
            $this->db->query($sql);
        }
        $sql = "DELETE FROM registros WHERE id = $id;";
        return $this->db->query($sql);
    }

    function listarUsersOrdenados(){
        $this->db->select("*");
        $this->db->order_by("acceso", "desc");
        return $this->db->get("usuario")->result();
    }

    function calculoRegistrosPorDia(){
        $sql = "select DISTINCT cast(fecha as date) as fecha from registros ORDER BY `fecha` DESC";
        $res = $this->db->query($sql);
        
        $final=array();
        foreach($res->result() as $row){
            $sql = "select cast(fecha as date) as fecha, SUM(ingreso) AS ingreso, SUM(egreso) AS egreso, saldo from registros WHERE fecha BETWEEN '$row->fecha 00:00:00' AND '$row->fecha 23:59:59' order by fecha;";
            $final= array_merge($final,$this->db->query($sql)->result());
            
        }
        return $final;
    }
}
?>
