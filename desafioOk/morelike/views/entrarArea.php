<!--button class="btn btn-info btn-lg" onclick="volver()">Volver</button-->
<div class="row">
	<div class="col-12 text-center">
		<h3><?=$area?></h3>
		<hr>
	</div>
		<div class="col-6">
			<!-- Acá debe ir todo lo necesario para subir los ficheros-->
			<h5>Subir Archivos</h5>
			<div id="listadoFicheros">
                <form class="formFicheros" action="<?=base_url()?>Upload_Controller/do_upload" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <input type="file" id="userfile" name="userfile" size="20" class="btn btn-info">
                    <input type="hidden" name="idarea" id="idarea" value="<?=$id;?>">
                    <input type="hidden" name="rolarea" id="rolarea" value="<?=$rol;?>">
                    <input type="hidden" name="nombrearea" value="<?=$area;?>">
                    <input type="submit" name="submit" value="upload" class="btn btn-info">             
                </form>
                <button id="btnRar" class="btn btn-warning" style="display: none" onclick="extract()">Extraer Liquidaciones</button>
            </div>
            <!--div id="listadoArchivos" style="display: none;">
            </div-->
            <div id="infoFicheros"></div>
		</div>
	<div class="col">
		<h5>Ficheros</h5>
		<div id="listadoArchivos" style="display: none;">
        </div>
	</div>
</div>

<script type="text/javascript">
	var nombreFichero="";
	$(document).ready(function(){
        buscaFicherosSubidos();
        $(".formFicheros").submit(
        	function(){
	            var options = {
	            	dataType:'json',
	                target: "#infoFicheros",
	                success: showResponse
	            };
	            $(this).ajaxSubmit(options);
	            return false;
	        });
        }
    );
    function showResponse(responseText, statusText, xhr, $form){
        if(responseText.error.length>0){
            $("#infoFicheros").hide();
            $("#infoFicheros").html(responseText.error);
            $("#infoFicheros").css("color","white");
            $("#infoFicheros").css("margin","20px");
            $("#infoFicheros").css("text-align","center");
            $("#infoFicheros").css("border-radius","10px");
            $("#infoFicheros").css("background-color","rgba(200,0,0,0.7)");
            $("#infoFicheros").show("fast");
        }else{
            $("#infoFicheros").hide();
            $("#infoFicheros").html("<p>Archivo subido correctamente</p>");
            $("#infoFicheros").css("color","white");
            $("#infoFicheros").css("margin","20px");
            $("#infoFicheros").css("text-align","center");
            $("#infoFicheros").css("border-radius","10px");
            $("#infoFicheros").css("background-color","rgba(0,200,10,0.7)");
            $("#infoFicheros").show("fast");
            //console.log(responseText.file);
            cadenaArchivos = responseText.file;
            extension = responseText.ext;
            /*Ya tengo la extensión, si es rar debo habilitar la extracción, pensado solo para las liquidaciones*/
            subirFichero($("#idarea").val(),cadenaArchivos,0);
            if(extension=='.zip'){
            	nombreFichero 	= cadenaArchivos;
            	$("#btnRar").show('slow');
            }
        }
    }
    function subirFichero(idarea,cadenaArchivos,op){
        $.post(base_url+"Principal/subirFichero",{
            idarea: idarea,
            cadenaArchivos:cadenaArchivos//,
            //op:op
            },function(){
                buscaFicherosSubidos();
        });
    }
    function buscaFicherosSubidos(){
        $.post(base_url+"Principal/buscaFicherosSubidos",{idarea:$("#idarea").val(),rolarea:$("#rolarea").val()},
            function(html,data){
                $("#listadoArchivos").html(html,data);
                $("#listadoArchivos").show();
            })
    }
	function volver(){
		$("#contenedor").hide('fast');
		$("#botonesAreas").show('fast');
	}
	function extract(){
		$.post(
			base_url+"Principal/extract",
			{
				fichero :nombreFichero,
				area 	:$("#idarea").val()
			},function(){
                $("#infoFicheros").hide();
                $("#infoFicheros").html("<p>Extracción correcta</p>");
                $("#infoFicheros").css("color","white");
                $("#infoFicheros").css("margin","20px");
                $("#infoFicheros").css("text-align","center");
                $("#infoFicheros").css("border-radius","10px");
                $("#infoFicheros").css("background-color","rgba(0,200,10,0.7)");
                $("#infoFicheros").show("fast");
				buscaFicherosSubidos();
			}
		);
	}
</script>