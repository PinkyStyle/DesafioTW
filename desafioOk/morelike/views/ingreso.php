
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Desafio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core CSS -->
    
    <link href="<?=base_url()?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="<?=base_url()?>js/jquery.form.min.js"></script>
    <!--script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script-->
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
       #footer {
        height: 60px;
      }
      #footer {
        background-color: #f5f5f5;
      }
    </style>
    <script type="text/javascript">
      $(document).ready(function(){
        var options = { 
          dataType  :      'json',
          success   :      showResponse  // post-submit callback
        }; 
        $('#loginForm').ajaxForm(options);
      });
      function showResponse(data)  {  
        //console.log(data.res);
        target = "#errorForm";
        if(data.res=='1'){
          $(target).hide();
          $(target).html("Usuario o clave inconrrecto");
          $(target).show('fast');
        }else{
          window.location.replace('<?=base_url()?>UsoIntranet');
        }
      }
    </script>
  </head>

  <body>

    <div class="container">      
      <form class="form-signin" id="loginForm" style="background-color: #128c7e; box-shadow: 10px 10px 10px 0px #dcf8c6; border: 1px solid #075e54;" method="post" action="Validar">
        <h3 class="text-center" style="color:white;">Desafio</h3>
        <input class="form-control" type="text" style="width: 100%;" placeholder="Rut" name="rut">
        <input class="form-control" type="password" style="width: 100%;" placeholder="Contraseña" name="clave">
        <label class="btn-danger" style="width: 100%; text-align: center; border-radius:5px;" id="errorForm"><?=$error;?></label>
        <button class="btn btn-medium" style="width: 100%; background-color: #34b7f1; color:#dcf8c6" type="submit">Conectar</button>
      </form>
      <div class="row">
        <div class="col-12">
          <center><h3>Indicaciones</h3></center>
          <p>Este proyecto tiene dos partes, la primera se compone solamente de la <b>reparación</b> del sistema, permitiendo desplegar correctamente el flujo base que ya tiene el sistema. Esta primera parte será evaluada como el laboratorio de la sesión.</p>
          <p>A continuación se presenta una serie de requerimientos, que pertenecen a la segunda parte de su trabajo, la que corresponderá a la evaluación de la Unidad.</p>
          <ol>
            <li>Corregir el funcionamiento de la aplicación</li>
            <li>Limpiar todo lo ajeno al proyecto, dejar nota de que elementos fueron descartados y justifcar el motivo</li>
            <li>Conectar con la base de datos</li>
            <li>Establecer y detallar el uso de sesiones</li>
            <li>Agregar nuevas funcionalidades a la aplicación:
              <ol>
                <li>Permitir la edición de registros</li>
                <li>Establecer una validación respecto de los valores ingresados, que implemente el separador de miles</li>
                <li>Permitir la eliminación de registros</li>
                <li>Definir la búsqueda de registros por intervalo de fechas</li>
              </ol>
            </li>
            <li>Establecer un nuevo módulo de <b>Informes</b>, donde el usuario Administrador podrá conocer los tiempos de conexión de cada usuario, así como también los montos finales de los ingresos y egresos por día.</li>
          </ol>
          <p>Para efectos de pruebas, se les pide que se creen ustedes como usuarios, se vinculen con cada área y realicen ingreso de registros contables.</p>
          <h3>Observaciones</h3>
          <ul>
            <li>Para este proyecto pueden trabajar en equipos de hasta <b style="color:red">2 integrantes</b></li>
            <li>La entrega del laboratorio debe considerar un video de no más de 10 minutos, donde se detallen los cambios necesarios para desplegar la aplicación correctamente.</li>
            <li>La entrega, del proyecyo, debe considerar un video, que no sobrepase los 20 mintuso, donde se detallen correctamente los puntos corregidos para lograr el funcionamiento ideal</li>
            <li>En el video además deberá venir la explicación de las nuevas funcionalidades implementadas</li>
          </ul>
        </div>
      </div>
    </div>
    <div id="footer">
      <div class="container" style="text-align:center; font-size:12px;">
        <p class="muted credit">
        Developed by <a href="#">Sebastian Alejandro Ibarra Herrera y Matias Eduardo Pizarro Pinto</a></p>
      </div>
    </div>
  </body>
  <script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</html>
