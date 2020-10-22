<div class="row">
	<div class="col">
		<h3 class="text-center">Centros</h3>
		<hr>
		<div>
			<button type="button" class="btn btn-dark" onclick="verDivAddArea()"><i class="fas fa-plus-circle fa-2x"></i></button>
			<div class="input-group mb-3" id="divAddArea" style="display: none;">
			  <input type="text" class="form-control" placeholder="Nombre" aria-label="Nombre Area" id="txtAddArea">
			  <input type="text" class="form-control" placeholder="Dirección" aria-label="Direccion Area" id="dirAddArea">
			  <div class="input-group-append">
			    <button class="btn btn-outline-success" type="button" onclick="addNewArea()"><i class="far fa-check-square"></i></button>
			  </div>
			</div>
			<div style="display: none;" id="mensajeError" class="btn-danger text-center"></div>
		</div>
		<table class="table table-striped">
			<th>Nombre</th>
			<th>Dirección</th>
			<th>Estado</th>
			<th></th>
			<th></th>
			<?php foreach($areas as $row):?>
				<tr>
					<td>
						<input type="text" class="form-control" id="nombreArea<?=$row->id?>" value="<?=$row->nombre?>"/>
					</td>
					<td>
						<input type="text" class="form-control" id="direccionArea<?=$row->id?>" value="<?=$row->direccion?>"/>
					</td>
					<?php if($row->estado == 0):?>
						<td><i class="far fa-eye fa-2x"></i></td>
						<td><button class="btn btn-info" onclick="cambiarEstadoArea(1,<?=$row->id?>)"><i class="far fa-eye-slash"></i></button></td>
					<?php else:?>
						<td><i class="far fa-eye-slash fa-2x"></i></td>
						<td><button class="btn btn-info" onclick="cambiarEstadoArea(0,<?=$row->id?>)"><i class="far fa-eye"></i></button></td>
					<?php endif;?>
					<td>
						<button class="btn btn-success" onclick="editArea(<?=$row->id;?>)"><i class="far fa-save"></i></button>
					</td>
				</tr>
			<?php endforeach;?>
		</table>
	</div>
</div>
<script type="text/javascript">
	function verDivAddArea(){
		$("#divAddArea").toggle('fast');
	}
	function addNewArea(){
		addArea($("#txtAddArea").val(),$("#dirAddArea").val(),0,0);
	}
	function cambiarEstadoArea(estado, id){
		$.post(base_url+"Principal/cambiarEstadoArea",{estado:estado,id:id},function(){
			$("#contenedor").hide("fast");
			nuevaArea();
		});
	}
	function editArea(id){
		addArea($("#nombreArea"+id).val(),$("#direccionArea"+id).val(),1,id);
	}
	function addArea(area,direccion,op,id){
		$.post(base_url+"Principal/addNewArea",{area:area,direccion:direccion,op:op,id:id},function(res){
			if(res.error == true){
				$("#mensajeError").html("<p>Nombre del Centro es repetido o no válido</p>");
				$("#mensajeError").show('fast');
			}else{
				$("#contenedor").hide("fast");
				//console.log(res.links);
				var cadena="";
				for(i=0;i<res.links.length;i++){
					cadena+="<option value='"+res.links[i].idce+"'>"+res.links[i].nombre+"</option>";
				}
				$("#selectCentros").html('');
				$("#selectCentros").html(cadena);
				nuevaArea();
			}
		},'json');
	}
</script>