
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
		<div class="row text-center">
			<div class="col-4">
				<input class="boton0" type="text" id="descripcion">
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
			<button class="btn btn-success btn-sm" id="filtro" onclick="filtrarPorFecha()">Filtrar</button>
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
						data-egresos="<?=number_format($row->egreso,0,",",".")?>"
						data-fecha="<?=substr($row->fecha,0,10)?>">Editar</button>						
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
					<label for="descripcion" class="col-form-label">Descripcion:</label>
					<input type="text" class="form-control" id="mod-descripcion"  >
				</div>
				<div class="form-group">
					<label for="ingreso" class="col-form-label">Ingresos:</label>
					<input type="text" class="form-control" id="mod-ingreso" >
				</div>
				<div class="form-group">
					<label for="egreso" class="col-form-label">Egresos:</label>
					<input type="text" class="form-control" id="mod-egreso" >
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

	.boton0{
		width: 90%;
		align: center;
		border:1px solid #ccc;
	}
	.ingreso{
		width: 90%;
		justify: center;	
		border:1px solid #ccc;			
	}
	.egreso{
		width: 90%;
		justify: center;	
		border:1px solid #ccc;			
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
			fecha = $( "#mod-fecha" ).datepicker({
				defaultDate: "+1w",
				changeMonth: true,
				numberOfMonths: 1
			})
			;
		
			function getDate( element ) {
				var date;
				try {
					//date = $.datepicker.parseDate( dateFormat, element.value );
					date = element.value;
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
		var fecha = $(e.relatedTarget).data('fecha');
		
		//console.log(id);
		$(e.currentTarget).find('input[id="idR"]').val(id);
		$(e.currentTarget).find('input[id="mod-descripcion"]').val(descripcion);
		$(e.currentTarget).find('input[id="mod-ingreso"]').val(ingresos);
		$(e.currentTarget).find('input[id="mod-egreso"]').val(egresos);
		$(e.currentTarget).find('input[id="mod-fecha"]').val(fecha);
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

	function filtrarPorFecha(){
		var d = $('#from').datepicker('getDate');
		var h = $('#to').datepicker('getDate');		
	
		var desde = $.datepicker.formatDate('yy-mm-dd',d);
		var hasta = $.datepicker.formatDate('yy-mm-dd',h);		
		if(desde != "" && hasta != ""){		
			$.post(base_url+"Principal/buscarUltimosRegistrosPorFecha",{
				desde:desde, hasta:hasta
			},function(){
				$("#contenedor").hide('fast');							
				filtrar(desde,hasta); 			
			});			
		}
		else{		
			$("#contenedor").hide('fast');
	  		nuevoProcedimiento();	
		}
	}

	function modificarRegistro(){		

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
		if(ingreso.length> 1 && egreso.length > 1 && (ingreso == 0 || egreso == 0)){
			alert("Solo puede ser Ingreso o Egreso!");
			fail=1;
		}
		console.log(ingreso);
		console.log(egreso);
		if(fail == 0){
			$.post(base_url+"Principal/modificarRegistro",{
				id:id, descripcion:descripcion, ingreso:ingreso, egreso:egreso, fecha:fechaFormat
			},function(){
				$("#contenedor").hide('fast');
	  			nuevoProcedimiento();
			});
		}		
		$("#modificarRegistros").modal('hide');//ocultamos el modal
		$('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
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