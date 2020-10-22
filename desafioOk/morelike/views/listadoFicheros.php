<?if($res->num_rows()==0):?>
	<p class="btn-danger" style="text-align: center">No existen ficheros en esta área.</p>
<?else:?>
<table class="table table-sm table-striped">
	<thead>
		<th>Nombre</th>
		<th>Fecha</th>
		<th>Leer</th>
		<th>Ver</th>
		<?if($rol == 2):?>
		<th></th>
		<th></th>
		<th></th>
		<?endif;?>
	</thead>
	<tbody>
		<?$i=0;foreach($res->result() as $row):?>
		<tr>
			<?if($rol == 1 && $row->estado == 1):?>
				<td><?=$row->nombre?></td>
				<td><?=$row->fecha?></td>
				<td><?if(substr($row->nombre,-4) == ".txt"):?>
						<button class="btn btn-success" style="padding:0" onclick="leerDocumento('<?=$row->id?>','<?=$row->area?>','<?=$row->ubicacion?>','<?=$row->nombre?>','<?=$rol?>')"><i class="far fa-check-square"></i></button>
					<?else:?>
						<button class="btn btn-success" style="padding:0" disabled><i class="far fa-check-square"></i></button>
					<?endif;?>
				</td>
				<td><a href="<?=base_url().$row->ubicacion.$row->nombre?>" target="_blank" data-toggle="tooltip" title="Abrir"><button class="btn" style="padding: 0;"><i class="fas fa-external-link-alt"></i></button></a></td>
			<?endif;?>
			<?if($rol == 2):?>
				<?if($row->estado == 1):?>
					<td><p><?=$row->nombre?></p></td>
					<td><p><?=$row->fecha?></p></td>
				<?else:?>
					<td><p style="color:gray"><?=$row->nombre?></p></td>
					<td><p style="color:gray"><?=$row->fecha?></p></td>
				<?endif?>
				<td><?if(substr($row->nombre,-4) == ".txt"):?>
						<button class="btn btn-success" style="padding:0" onmouseover="eventoFocus(<?=$i?>,'<?=$row->id?>')" onclick="leerDocumento('<?=$row->id?>','<?=$row->area?>','<?=$row->ubicacion?>','<?=$row->nombre?>','<?=$rol?>')" id="btnLeer<?=$i?>"><i class="far fa-check-square"></i></button>
					<?else:?>
						<button class="btn btn-success" style="padding:0" disabled><i class="far fa-check-square"></i></button>
					<?endif;?>
				</td>
				<td><a href="<?=base_url().$row->ubicacion.$row->nombre?>" target="_blank" data-toggle="tooltip" title="Abrir"><button class="btn" style="padding: 0;"><i class="fas fa-external-link-alt"></i></button></a></td>
					<?if($row->estado == 1):?>
						<!--td><i class="far fa-eye fa-x"></i></td-->
						<td><button class="btn btn-warning" onclick="cambiarEstadoFile(0,<?=$row->id?>)" style="padding: 0;" data-toggle="tooltip" title="Ocultar"><i class="far fa-eye-slash"></i></button></td>
					<?else:?>
						<!--td><i class="far fa-eye-slash fa-x"></i></td-->
						<td><button class="btn btn-success" onclick="cambiarEstadoFile(1,<?=$row->id?>)" style="padding: 0;" data-toggle="tooltip" title="Mostrar"><i class="far fa-eye"></i></button></td>
					<?endif;?>
				<td><button class="btn btn-danger" style="padding: 0;" onclick="eliminarFichero('<?=$row->id?>','<?=$row->ubicacion?>','<?=$row->area?>','<?=$row->nombre?>')" data-toggle="tooltip" title="Eliminar"><i class="far fa-trash-alt"></i></button></td>
			<?endif;?>
		</tr>
		<?$i++;endforeach;?>
	</tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modalDoc" tabindex="-1" role="dialog" aria-labelledby="labelDoc" aria-hidden="true">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
    			<h5 class="modal-title text-center" id="labelDoc"></h5>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
     				<span aria-hidden="true">&times;</span>
    			</button>
    		</div>
		  	<div class="modal-body" id="modalDocTxt">
		  	</div>
	  		<div class="modal-footer">
	  			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	  		</div>
	  	</div>
	</div>
</div>
<?endif;?>
<script type="text/javascript">
	$(document).ready(function(){
	  	$('[data-toggle="tooltip"]').tooltip();
	});
	function eliminarFichero(id, ubicacion, area, nombre) {
		$.post(
			base_url+"Principal/eliminarFichero",{
				id:id,
				ubicacion:ubicacion,
				area:area,
				nombre:nombre
			},function(){
				buscaFicherosSubidos();
			}
		);
	}
	function cambiarEstadoFile(estado, id){
		$.post(base_url+"Principal/cambiarEstadoFile",{estado:estado,id:id},function(){
			//$("#contenedor").hide("fast");
			buscaFicherosSubidos();
		});
	}
	function leerDocumento(id, area,ubicacion,nombre,rol){
		//Si el rol es 1 = solo lectura. Si el rol es 2 = ver quien leyó.
		$.post(
			base_url+"Principal/leerDocumento",
			{id:id, area:area, ubicacion:ubicacion,nombre:nombre},
			function(txt){
				$("#labelDoc").text("Documento: "+nombre);
				txt = txt.split("\r\n").join("<br>");
				$("#modalDocTxt").html("<p>"+txt+"</p>");
				$("#modalDoc").modal("show");
			},'json'
		);
	}
	function eventoFocus(i,id){
		$.post(
			base_url+"Principal/buscarLeidos",
			{id:id},
			function(info){
				//info = info.split("+").join("<br>");
				$("#btnLeer"+i).attr("data-title",info);
				$("#btnLeer"+i).attr("data-placement","right");
				$(".tooltip-inner").css("text-align","left");
				$("#btnLeer"+i).tooltip({html: true});
			},'json');
	}
</script>