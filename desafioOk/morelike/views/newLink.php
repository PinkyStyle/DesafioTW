<div class="row">
	<div class="col">
		<h3 class="text-center">Asignaciones</h3>
		<hr>
		<button type="button" class="btn btn-dark" onclick="verDivAddLink()"><i class="fas fa-plus-circle fa-2x"></i></button>
		<div class="row mb-3" id="divAddLink" style="display: none;">
			<div class="col-4">
			  <select class="form-control" placeholder="Usuario" aria-label="Usuario" id="selectAddUserLink">
			  	<?php foreach($usuarios as $row):?>
			  		<option value="<?=$row->id?>"><?=$row->nombre?></option>
			  	<?php endforeach;?>
			  </select>
			</div>
			<div class="col-4">
			  <select class="form-control" placeholder="Areas" aria-label="Areas" id="selectAddAreaLink">
			  	<?php foreach($areas as $row):?>
			  		<option value="<?=$row->id?>"><?=$row->nombre?></option>
			  	<?php endforeach;?>
			  </select>
			</div>
			<!--div class="col-3">
			  <select class="form-control" placeholder="Rol" aria-label="Rol" id="selectAddRolLink">
			  	<option value="0" selected disabled>Rol</option>
			  	<option value="1">Usuario</option>
			  	<option value="2">Editor</option>
			  </select>
			</div-->
			<div class="col-4">
			  <button class="btn btn-success" onclick="addNewLink()" style="width: 100%;"><i class="far fa-check-square"></i></button>
			</div>
		</div>
		<div style="display: none;" id="mensajeError" class="btn-danger text-center"></div>
	</div>
</div>
<div class="row">
	<div class="col">
		<table class="table table-striped">
			<th>Nombre</th>
			<th>Área</th>
			<th>Rol</th>
			<th>Estado</th>
			<th></th>
			<th></th>
			<th></th>
			<?php foreach($links as $row):?>
				<tr>
					<td>
						<select class="form-control" placeholder="Usuario" aria-label="Usuario" id="nombre<?=$row->id?>">
							<?php foreach($usuarios as $row1):?>
								<?php if($row1->id == $row->idu):?>
									<option selected value="<?=$row1->id?>"><?=$row1->nombre?></option>
								<?php else:?>
									<option value="<?=$row1->id?>"><?=$row1->nombre?></option>
								<?php endif;?>
							<?php endforeach;?>
						</select>
					</td>
					<td>
						<select class="form-control" placeholder="Areas" aria-label="Areas" id="area<?=$row->id?>">
							<?php foreach($areas as $row1):?>
								<?php if($row1->id == $row->idc):?>
									<option selected value="<?=$row1->id?>"><?=$row1->nombre?></option>
								<?php else:?>
									<option value="<?=$row1->id?>"><?=$row1->nombre?></option>
								<?php endif;?>
							<?php endforeach;?>
						</select>
					</td>					
					<?php if($row->estadousce == 0):?>
						<td><i class="far fa-eye fa-2x"></i></td>
						<td><button class="btn btn-info" onclick="cambiarEstadoUA(1,<?=$row->idt?>)"><i class="far fa-eye-slash"></i></button></td>
					<?php else:?>
						<td><i class="far fa-eye-slash fa-2x"></i></td>
						<td><button class="btn btn-info" onclick="cambiarEstadoUA(0,<?=$row->idt?>)"><i class="far fa-eye"></i></button></td>
					<?php endif;?>
					<td>
						<button class="btn btn-success" onclick="editLink(<?=$row->idce;?>)"><i class="far fa-save"></i></button>
					</td>
					<td>
						<button class="btn btn-danger" onclick="deleteLink(<?=$row->id;?>)"><i class="far fa-trash-alt"></i></button>
					</td>
				</tr>
			<?php endforeach;?>
	</div>
</div>
<script type="text/javascript">
	function verDivAddLink(){
		$("#divAddLink").toggle('fast');
	}
	function addNewLink(){
		//alert($("#selectAddRolLink").val());
		/*if($("#selectAddRolLink").val() == null){
			$("#mensajeError").html("<p>Debe seleccionar un rol para el usuario</p>");
			$("#mensajeError").show('fast');
		}else{*/
			addLink($("#selectAddUserLink").val(),$("#selectAddAreaLink").val(),0,0);
		//}
	}
	function cambiarEstadoUA(estado, id){
		$.post(base_url+"Principal/cambiarEstadoLink",{estado:estado,id:id},function(){
			$("#contenedor").hide("fast");
			nuevoLink();
		});
	}
	function editLink(id){
		addLink($("#nombre"+id).val(),$("#area"+id).val(),$("#rol"+id).val(),1,id);
	}
	function addLink(usuario,area,op,id){ //op=0 Insertar, op=1 Editar
		$.post(base_url+"Principal/addNewLink",{
			usuario :usuario,
			area 	:area,
			op 		:op,
			id		:id
		},function(res){
			if(res.error == true){
				$("#mensajeError").html("<p>Asignación ya existente</p>");
				$("#mensajeError").show('fast');
			}else{
				$("#contenedor").hide("fast");
				nuevoLink();
			}
		},'json');
	}
	function deleteLink(id){
		var opcion = confirm("¿Estás seguro de eliminar?\nNombre: "+$("#nombre"+id+" option:selected").text()+"\nÁrea: "+$("#area"+id+" option:selected").text()+"\nRol:"+$("#rol"+id+" option:selected").text());
    	if (opcion == true) {
    		$.post(base_url+"Principal/deleteLink",{id:id},function(){
    			$("#contenedor").hide("fast");
				nuevoLink();
			});
		}
	}
</script>