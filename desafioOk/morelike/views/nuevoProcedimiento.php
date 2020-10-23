
<div class="row">
	<div class="col-12">
		<h3 class="text-center">Registros Contables</h3>
	</div>
	<div class="col-12 col-lg-12">

		<!-- Labels -->
		<div class="row">
			<div class="col-4 text-center">
				<h4>Descripción</h4>
			</div>
			<div class="col-4 text-center">
				<h4>Ingreso</h4>
			</div>
			<div class="col-4 text-center">
				<h4>Egreso</h4>	
			</div>
		</div>

		<!-- Inputs Registros Contables -->
		<div class="row">
			<div class="col-4">
				<input class="form-control" type="text" id="descripcion">
			</div>
			<div class="col-4">
				<input class="ingreso" type="text" id="ingreso" onchange="formato('ingreso')">
			</div>
			<div class="col-4">
				<input class="egreso" type="text" id="egreso" onchange="formato('egreso')">
			</div>
		</div>

		<!-- Botones Guardar y Buscar -->
		<div class="row">
			<div class="col-6">
				<button class="btn btn-success" style="width: 100%; margin-top: 10px;" onclick="guardarNuevoProcedimiento()">Guardar <i class="far fa-save"></i></button>
			</div>
			<div class="col-6">
				<button class="btn btn-warning" style="width: 100%; margin-top: 10px;" onclick="verBusquedas()" id="verBusquedas">Buscar <i class="fas fa-search-plus"></i></button>
				<button class="btn btn-warning" id="ocultarBusquedas" style="display:none; width: 100%; margin-top: 10px;" onclick="ocultarBusquedas()">Buscar <i class="fas fa-search-plus"></i></button>
			</div>
		</div>
	</div>

	<!-- Seccion de Busqueda -->
	<div class="col-12 col-lg-6" style="display: none" id="divBusqueda">
		<fieldset>
			<legend>Búsquedas</legend>
			<label for="from">Desde</label>
			<input type="text" id="from" name="from">
			<label for="to">Hasta</label>
			<input type="text" id="to" name="to">
		</fieldset>
	</div>

	<?php if($cant > 0):?>
		<div class="col-12 col-lg-12" id="ultimosRegistros">
			<table class="table table-striped" id="tablaRegistros">
				<th>Fecha</th>
				<th>Descripción</th>
				<th>Ingreso</th>
				<th>Egreso</th>
				<th>Saldo</th>
				<th>Modificar</th>
				<th>Eliminar</th>
				<?php foreach($data as $row):?>
				<tr>
					<td><?=substr($row->fecha,0,10)?></td>
					<td><?=$row->descripcion?></td>
					<td><?=number_format($row->ingreso,0,",",".")?></td>
					<td><?=number_format($row->egreso,0,",",".")?></td>
					<?php if($row->saldo>0):?>
					<td class="btn-success"><?=number_format($row->saldo,0,",",".")?></td>
					<?php else:?>
					<td class="btn-danger"><?=number_format($row->saldo,0,",",".")?></td>
					<?php endif;?>
					<td>
						<button class='btn btn-warning btn-sm' data-toggle="modal" data-target="#modificarRegistro" 
						data-id="<?=$row->id?>"
						data-descripcion="<?=$row->descripcion?>" 
						data-ingresos="<?=number_format($row->ingreso,0,",",".")?>" 
						data-egresos="<?=number_format($row->egreso,0,",",".")?>">Editar</button>						
					</td>
					<td>
						<button class='btn btn-danger btn-sm'  onclick='eliminarRegistro(<?=$row->id?>)'>Eliminar</button>
					</td>
				</tr>
				<?php endforeach;?>
			</table>
			<input type="hidden" id="idOculto" value="<?=$ultimo?>">
			<button class="btn btn-info" onclick="addRegistros()" style="width: 100%; margin-top:5px;"><i class="fas fa-cloud-download-alt fa-2x"></i></button>
		</div>
	<?php endif;?>

	<div class="modal fade" id="modificarRegistro" tabindex="-1" role="dialog" aria-labelledby="modificarRegistroLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modificarRegistroLabel">Editar Registro</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form >				
				<div class="form-group">
					<input type="hidden" class="form-control" id="idR" >
					<label for="recipient-descripcion" class="col-form-label">Descripcion:</label>
					<input type="text" class="form-control" id="recipient-descripcion"  >
				</div>
				<div class="form-group">
					<label for="recipient-ingreso" class="col-form-label">Ingresos:</label>
					<input type="text" class="form-control" id="recipient-ingreso" >
				</div>
				<div class="form-group">
					<label for="recipient-egreso" class="col-form-label">Egresos:</label>
					<input type="text" class="form-control" id="recipient-egreso" >
				</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<input type="submit" class="btn btn-primary" data-dismiss="modal" onclick="modificarRegistro()"></button>
			</div>
			</div>
		</div>
	</div>
	
</div>
<style type="text/css">
	.textArea{
		border:1px solid #ccc;
		border-radius: 10px;
	}
	.wrapper {
		position: relative;
		width: 402px;
		height: 202px;
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	.signature-pad {
		position: absolute;
		left: 0;
		top: 0;
		width:400px;
		height:200px;
		background-color: white;
	}
</style>
<script type="text/javascript" src="js/rut.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script type="text/javascript">

	$(document).ready(function(){
		$.datepicker.regional['es'] = {
			closeText: 'Cerrar',
			prevText: '< Ant',
			nextText: 'Sig >',
			currentText: 'Hoy',
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			weekHeader: 'Sm',
			dateFormat: 'yy-mm-dd',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''
		};
		$.datepicker.setDefaults($.datepicker.regional['es']);
			from = $( "#from" )
				.datepicker({
				//defaultDate: "+1w",
				changeMonth: true,
				numberOfMonths: 1
				})
				.on( "change", function() {
				to.datepicker( "option", "minDate", getDate( this ) );
				}),
			to = $( "#to" ).datepicker({
				defaultDate: "+1w",
				changeMonth: true,
				numberOfMonths: 2
			})
			.on( "change", function() {
				from.datepicker( "option", "maxDate", getDate( this ) );
			});
		
			function getDate( element ) {
			var date;
			try {
				date = $.datepicker.parseDate( dateFormat, element.value );
			} catch( error ) {
				date = null;
			}
		
			return date;
			}
	});

	$('#modificarRegistro').on('show.bs.modal', function (e) {
		var id = $(e.relatedTarget).data('id');
		var descripcion = $(e.relatedTarget).data('descripcion');
		var ingresos = $(e.relatedTarget).data('ingresos');
		var egresos = $(e.relatedTarget).data('egresos');
		
		//console.log(id);
		$(e.currentTarget).find('input[id="idR"]').val(id);
		$(e.currentTarget).find('input[id="recipient-descripcion"]').val(descripcion);
		$(e.currentTarget).find('input[id="recipient-ingreso"]').val(ingresos);
		$(e.currentTarget).find('input[id="recipient-egreso"]').val(egresos);
	});

	function showResponse(responseText, statusText, xhr, $form){
		var res = JSON.parse(responseText);
		$("#nombreOrden").val(res.nombre);
		if(res.estado=="ok"){
			$("#imagenMsj").html("<p>Orden Almacenada</p>");
			$("#imagenMsj").addClass("btn-success");
			$("#imagenMsj").removeClass("btn-danger");
		}else{
			$("#imagenMsj").html(res.error);
			$("#imagenMsj").addClass("btn-danger");
			$("#imagenMsj").removeClass("btn-success");
		}
		$("#imagenMsj").show();
	}
	
	function buscarPacienteRut(){
		var rut = $("#rutPacienteBusqueda").val();
		$.post(base_url+"Principal/buscarPacienteRut",{rut:rut},
			function(data){
				$("#nombrePaciente").val(data[0].nombre);
				$("#apellidosPaciente").val(data[0].apellido);
				$("#fNacimiento").val(data[0].fNac);
				$("#edadPaciente").val(data[0].edad);
				$("#telefonoPaciente").val(data[0].telefono);
				$("#emailPaciente").val(data[0].correo);
				$("#direccionPaciente").val(data[0].domicilio);
			},'json')
	}
	function calcularEdad(){
		var fNac = $("#fNacimiento").val();
		var birthday_arr = fNac.split("-");
	    var birthday_date = new Date(birthday_arr[0], birthday_arr[1] - 1, birthday_arr[2]);
	    var ageDifMs = Date.now() - birthday_date.getTime();
	    //alert(ageDifMs);
	    var ageDate = new Date(ageDifMs);
	    var edad = Math.abs(ageDate.getUTCFullYear() - 1970);
		$("#edadPaciente").val(edad);
	}
	function guardarNuevoProcedimiento(){
		
		var descripcion = $("#descripcion").val();
		var ingreso = ($("#ingreso").val().split(".")).join("");
		var egreso = ($("#egreso").val().split(".")).join("");

		var validation = {
		    isEmailAddress:function(str) {
		        var pattern =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		        return pattern.test(str);  // returns a boolean
		    },
		    isNotEmpty:function (str) {
		        var pattern =/\S+/;
		        return pattern.test(str);  // returns a boolean
		    },
		    isNumber:function(str) {
		        var pattern = /^\d+$/;
		        return pattern.test(str);  // returns a boolean
		    },
		    isText:function(str){
		    	var pattern=/^[a-zA-Z ]*$/;
		    	return pattern.test(str); // returns a boolean
 		    },
 		    isTelefono:function(str){
 		    	var pattern=/^[0-9+]+$/;
 		    	return pattern.test(str);
 		    },
		    isSame:function(str1,str2){
		        return str1 === str2;
		    }
		};
		var fail = 0;
		if(descripcion.length==0 && (ingreso.length == 0 || egreso.length == 0)){
			alert("Debes regstrar Descripción e Ingreso o Egreso");
			fail=1;
		}
		if(descripcion.length>0 && ingreso.length == 0 && egreso.length == 0){
			alert("Falta registrar Ingreso o Egreso");
			fail=1;
		}
		if(ingreso.length> 0 && egreso.length > 0){
			alert("Solo puede ser Ingreso o Egreso!");
			fail=1;
		}

		if(fail == 0){
			$.post(base_url+"Principal/saveProcedimiento",{
				descripcion:descripcion, ingreso:ingreso, egreso:egreso
			},function(){
				$("#contenedor").hide('fast');
	  			nuevoProcedimiento();
			});
		}
	}
	function verBusquedas(){
		$("#divBusqueda").show("fast");
		$("#verBusquedas").hide();
		$("#ocultarBusquedas").show();
	}
	function ocultarBusquedas(){
		$("#divBusqueda").hide("fast");
		$("#verBusquedas").show();
		$("#ocultarBusquedas").hide();
	}
	function formato(campo){
		var cadena = $("#"+campo).val();
		
		$("#"+campo).val(cadena);
	}
	function addRegistros(){
		$.post(
			base_url+"Principal/traeMasRegistros",
			{desde:$("#idOculto").val()},
			function(data){
				if(data.cant > 0){
					var cadena ="";
					for(var i =0;i<data.cant;i++){
						if(data.data[i].saldo>0){
							cadena+="<tr><td>"+(data.data[i].fecha).substring(0,10)+"</td><td>"+data.data[i].descripcion+"</td><td>"+data.data[i].ingreso+"</td><td>"+data.data[i].egreso+"</td><td class='btn-success'>"+data.data[i].saldo+"</td>"+"<td><button class='btn btn-warning btn-sm' onclick='modificarRegistro("+data.data[i].id+")'>Editar</button></td><td><button class='btn btn-danger btn-sm'  onclick='eliminarRegistro("+data.data[i].id+")'>Eliminar</button></td></tr>";
						}else{
							cadena+="<tr><td>"+(data.data[i].fecha).substring(0,10)+"</td><td>"+data.data[i].descripcion+"</td><td>"+data.data[i].ingreso+"</td><td>"+data.data[i].egreso+"</td><td class='btn-danger'>"+data.data[i].saldo+"</td>"+"<td><button class='btn btn-warning btn-sm' onclick='modificarRegistro("+data.data[i].id+")'>Editar</button></td><td><button class='btn btn-danger btn-sm'  onclick='eliminarRegistro("+data.data[i].id+")'>Eliminar</button></td></tr>";
						}
					}
					$("#idOculto").val(data.ultimo);
					$("#tablaRegistros").append(cadena);
				}
			},'json'
		);
	}
	function saveImagen(id,archivo,nombre){
		$.ajax({
        	url:base_url+"Principal/saveImagen",
         	type:"post",
         	data:{file:archivo, id:id, nombre:nombre},
         	processData:false,
         	contentType:false,
         	cache:false,
         	async:false,
  			success: function(data){
              	alert("Upload Image Successful.");
           	}
     	});
		/*$.post(
	  		base_url+"Principal/saveImagen",
	  		{
	  			id:id, archivo:archivo, nombre:nombre
	  		}
  		);*/
	}

	function modificarRegistro(){		
		console.log("uwu");

		//console.log( $("#idR").val());
		//console.log( $("#recipient-descripcion").val());
		//console.log( $("#recipient-ingreso").val());
		//console.log( $("#recipient-ingreso").val());
		// ID = $("#idR").val()
		// Descripcion = $("#recipient-descripcion").val()
		// Ingresos = $("#recipient-ingreso").val()
		// Egresos = $("#recipient-ingreso").val()

		// recipient-descripcion
		// addArea($("#txtAddArea").val(),$("#dirAddArea").val(),0,0);

		var id = $("#idR").val();
		var descripcion = $("#recipient-descripcion").val();
		var ingreso =  ($("#recipient-ingreso").val().split(".")).join("");
		var egreso = ($("#recipient-egreso").val().split(".")).join("");
		

		if(ingreso > 0 && egreso == 0){
			egreso = "";
		}
		else if(egreso > 0 && ingreso == 0){
			ingreso = "";
		}

		var validation = {
		    isEmailAddress:function(str) {
		        var pattern =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		        return pattern.test(str);  // returns a boolean
		    },
		    isNotEmpty:function (str) {
		        var pattern =/\S+/;
		        return pattern.test(str);  // returns a boolean
		    },
		    isNumber:function(str) {
		        var pattern = /^\d+$/;
		        return pattern.test(str);  // returns a boolean
		    },
		    isText:function(str){
		    	var pattern=/^[a-zA-Z ]*$/;
		    	return pattern.test(str); // returns a boolean
 		    },
 		    isTelefono:function(str){
 		    	var pattern=/^[0-9+]+$/;
 		    	return pattern.test(str);
 		    },
		    isSame:function(str1,str2){
		        return str1 === str2;
		    }
		};
		var fail = 0;
		if(descripcion.length==0 && (ingreso.length == 0 || egreso.length == 0)){
			alert("Debes registrar Descripción e Ingreso o Egreso");
			fail=1;
		}
		if(descripcion.length>0 && ingreso.length == 0 && egreso.length == 0){
			alert("Falta registrar Ingreso o Egreso");
			fail=1;
		}
		if(ingreso.length> 0 && egreso.length > 0){
			alert("Solo puede ser Ingreso o Egreso!");
			fail=1;
		}

		if(fail == 0){
			$.post(base_url+"Principal/modificarRegistro",{
				id:id, descripcion:descripcion, ingreso:ingreso, egreso:egreso
			},function(){
				$("#contenedor").hide('fast');
	  			nuevoProcedimiento();
			});
		}		
		$('.modal-backdrop').remove();//Si no modificamos nada, el modal queda abierto (no se porque), esta linea lo cierra si o si
	}

	function eliminarRegistro(id){
		console.log(id);
		$.post(base_url+"Principal/eliminarRegistro",{
			id:id
		},function(){
			$("#contenedor").hide('fast');
			nuevoProcedimiento();
		});
	}

	const ingreso = document.querySelector('.ingreso');
	const egreso = document.querySelector('.egreso');

	function formatNumber (n) {
		n = String(n).replace(/\D/g, "");
		return n === '' ? n : Number(n).toLocaleString();
	}
	ingreso.addEventListener('keyup', (e) => {
		const element = e.target;
		const value = element.value;
	element.value = formatNumber(value);
	});
	egreso.addEventListener('keyup', (e) => {
		const element = e.target;
		const value = element.value;
	element.value = formatNumber(value);
	});


</script>