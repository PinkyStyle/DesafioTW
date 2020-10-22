<div class="row">
	<div class="col">
		<h3 class="text-center">Usuarios</h3>
		<hr>
		<button type="button" class="btn btn-dark" onclick="verDivAddUser()"><i class="fas fa-plus-circle fa-2x"></i></button>
		<div class="row mb-3" id="divAddUser" style="display: none;">
			<div class="col-4">
			  <input type="text" class="form-control" placeholder="Rut" aria-label="Rut Usuario" id="txtAddUserRut" maxlength="12">
			</div>
			<div class="col-4">
			  <input type="text" class="form-control" placeholder="Nombre" aria-label="Nombre Usuario" id="txtAddUserNombre">
			</div>
			<div class="col-4">
			  <input type="password" class="form-control" placeholder="Clave" aria-label="Clave Usuario" id="txtAddUserClave">
			</div>
			<div class="col-4">
			  <input type="date" class="form-control" placeholder="Fecha Nacimiento" aria-label="Fecha Nacimiento" id="txtAddUserFNac">
			</div>
			<div class="col-4">
			  <select class="form-control" placeholder="Especialdad" aria-label="Especialidad" id="txtAddUserEspecialidad">
			  	<option selected disabled>Especialidad</option>
			  	<option value="Enfermeria">Enfermeria</option>
			  	<option value="TENS">TENS</option>
			  </select>
			</div>
			<div class="col-4">
			  <select class="form-control" placeholder="Cargo" aria-label="Cargo" id="txtAddUserCargo">
			  	<option selected disabled>Cargo</option>
			  	<option value="Funcionario">Funcionario</option>
			  	<option value="Administrador">Administrador</option>
			  </select>
			</div>
			<div class="col-12">
			  <button class="btn btn-success" onclick="addNewUser()" style="width: 100%;"><i class="far fa-check-square"></i></button>
			</div>
		</div>
		<div style="display: none;" id="mensajeError" class="btn-danger text-center"></div>
	</div>
</div>
<div class="row">
	<div class="col">
		<table class="table table-striped">
			<th>Rut</th>
			<th>Nombre</th>
			<th>Clave</th>
			<th>Estado</th>
			<th></th>
			<th></th>
			<?php foreach($users as $row):?>
				<tr>
					<td><input class="form-control" type="text" id="rut<?=$row->id?>" value="<?=$row->rut?>"></td>
					<td><input class="form-control" type="text" id="nombre<?=$row->id?>" value="<?=$row->nombre?>"></td>
					<td><input class="form-control" type="password" id="clave<?=$row->id?>" value="<?=$row->clave?>"></td>
					<?php if($row->estado == 0):?>
						<td ><i class="far fa-eye fa-2x"></i></td>
						<td><button class="btn btn-info" onclick="cambiarEstadoUser(1,<?=$row->id?>)"><i class="far fa-eye-slash"></i></button></td>
					<?php else:?>
						<td ><i class="far fa-eye-slash fa-2x"></i></td>
						<td ><button class="btn btn-info" onclick="cambiarEstadoUser(0,<?=$row->id?>)"><i class="far fa-eye"></i></button></td>
					<?php endif;?>
					<!--td rowspan="2">
						<button class="btn btn-success" onclick="editUser(<?=$row->id;?>)"><i class="far fa-save"></i></button>
					</td-->
				</tr>
				<!--tr>
					<td>
					  <input type="date" class="form-control" placeholder="Fecha Nacimiento" aria-label="Fecha Nacimiento" id="txtAddUserFNac">
					</td>
					<td>
					  <select class="form-control" placeholder="Especialdad" aria-label="Especialidad" id="txtAddUserEspecialidad">
					  	<option selected disabled>Especialidad</option>
					  	<option value="enfermeria">Enfermería</option>
					  	<option value="tens">TENS</option>
					  </select>
					</td>
					<td>
					  <select class="form-control" placeholder="Cargo" aria-label="Cargo" id="txtAddUserCargo">
					  	<option selected disabled>Cargo</option>
					  	<option value="funcionario">Funcionario</option>
					  	<option value="administrador">Administrador</option>
					  </select>
					</td>
				</tr-->
			<?php endforeach;?>
		</table>
	</div>
</div>
<script type="text/javascript" src="js/rut.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#txtAddUserRut").change(function(){
			Rut($("#txtAddUserRut").val(),$("#txtAddUserRut"));
			console.log("LOL");
			$.post(
				base_url+"Principal/buscaUsuario",
				{rut:$("#txtAddUserRut").val()},
				function(data){
					$("#txtAddUserNombre").val(data[0].nombre);
					$("#txtAddUserClave").val('');
					$("#txtAddUserFNac").val(data[0].fnac);
					$("#txtAddUserEspecialidad").val(data[0].especialidad);
					$("#txtAddUserCargo").val(data[0].rol);
				},'json');
		});
	})
	function verDivAddUser(){
		$("#divAddUser").toggle('fast');
	}
	function addNewUser(){
		addUser(
			$("#txtAddUserRut").val(),
			$("#txtAddUserNombre").val(),
			$("#txtAddUserClave").val(),
			$("#txtAddUserFNac").val(),
			$("#txtAddUserEspecialidad").val(),
			$("#txtAddUserCargo").val(),
			0,
			0
		);
	}
	function cambiarEstadoUser(estado, id){
		$.post(base_url+"Principal/cambiarEstadoUser",{estado:estado,id:id},function(){
			$("#contenedor").hide("fast");
			nuevoUser();
		});
	}
	function editUser(id){
		addUser($("#rut"+id).val(),$("#nombre"+id).val(),$("#clave"+id).val(),1,id);
	}
	function addUser(rut, nombre, clave,fNac,especialidad, cargo, op, id){
		$.post(base_url+"Principal/addNewUser",{
			rut:rut,
			nombre:nombre,
			clave:clave,
			fNac:fNac,
			especialidad:especialidad,
			cargo:cargo,
			op:op,
			id:id
		},function(res){
			if(res.error == true){
				$("#mensajeError").html("<p>Usuario ya existente o datos no válidos</p>");
				$("#mensajeError").show('fast');
			}else{
				$("#contenedor").hide("fast");
				nuevoUser();
			}
		},'json');
	}
</script>