
<style type="text/css">
  .campo{
    background-color: #ccc;
    padding: 20px;
    color:black;
    border: 1px solid #128c7e;
  }
</style>
<?if($num_rows==0):?>
  <p>No hay fichas encontradas para este paciente</p>
<?else:?>
  <fieldset>
    <legend>Datos Personales</legend>
    <div class="row">
    <div class="col-12 col-lg-4">
      <label for="rutPacienteBusqueda">Rut:</label>
        <input type="text" class="form-control" id="rutB" placeholder="Rut" maxlength="12" readonly>
    </div>
    <div class="col-12 col-lg-4">
      <label for="nombreB">Nombre:</label>
        <input type="text" class="form-control" placeholder="Nombre" id="nombreB" readonly>
    </div>
    <div class="col-12 col-lg-4">
      <label for="apellidosB">Apellidos:</label>
        <input type="text" class="form-control" placeholder="Apellidos" id="apellidosB" readonly>
    </div>
    <div class="col-12 col-lg-4">
      <label for="fNacB">F. Nacimiento:</label>
        <div class="input-group">
          <input type="date" class="form-control" placeholder="2020-06-18" id="fNacB" readonly>
          <input type="number" class="form-control" disabled id="edadB">
        </div>
    </div>
    <div class="col-12 col-lg-4">
      <label for="telefonoB">Teléfono:</label>
        <input type="text" class="form-control"placeholder="(+56)X XXXX XXXX" id="telefonoB" maxlength="12" readonly>
    </div>
    <div class="col-12 col-lg-4">
      <label for="direccionB">Dirección:</label>
        <input type="text" class="form-control" placeholder="Dirección" id="direccionB" readonly>
    </div>
  </div>
  </div>
  </fieldset>
  <hr>
  <div id="accordion">
    <?$i=0;foreach($result as $row):?>
      <div class="card">
        <div class="card-header" id="heading<?=$i?>">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?=$i?>" aria-expanded="true" aria-controls="collapse<?=$i?>" style="text-align:left;width: 100%;">
              <?
                $fecha = explode("-",$row->fecha);
                echo $fecha[2]."-".$fecha[1]."-".$fecha[0];
              ?>
            </button>
          </h5>
        </div>

        <div id="collapse<?=$i?>" class="collapse hide" aria-labelledby="heading<?=$i?>" data-parent="#accordion">
          <div class="card-body">
            <fieldset>
              <label style="font-weight: bold">Atendido por:</label>
              <label><?echo $row->name." ".$row->lastname." - ".$row->especialidad?></label>
            </fieldset>
            <fieldset>
              <legend>Antecedentes Mórbidos</legend>
              <p class="campo"><?=$row->antMorbidos?></p>
            </fieldset>
            <fieldset>
              <legend>Alergias</legend>
              <p class="campo"><?=$row->alergias?></p>
            </fieldset>
            <fieldset>
              <legend>Motivo Consulta</legend>
              <p class="campo"><?=$row->motConsulta?></p>
            </fieldset>
            <fieldset>
              <legend>Procedimiento Efectuado</legend>
              <p class="campo"><?=$row->procEfectuado?></p>
            </fieldset>
            <fieldset>
              <legend>Indicaciones</legend>
              <p class="campo"><?=$row->indicaciones?></p>
            </fieldset>
            <fieldset>
              <legend>Observaciones</legend>
              <p class="campo"><?=$row->observaciones?></p>
            </fieldset>
            <fieldset>
              <legend>Orden Médica</legend>
              <img class="img-fluid" src="<?=base_url()?>uploads/ordenMedica/<?=$row->ordenmedica?>">
            </fieldset>
            <fieldset>
              <legend>Firma</legend>
              <img class="img-fluid" src="<?=$row->firma?>">
            </fieldset>
          </div>
        </div>
      </div>
    <?$i++;endforeach;?>
  </div>
<?endif;?>
<script type="text/javascript">
  $(document).ready(function(){
    $('html, body').animate({ scrollTop: $("#rutB").offset().top }, 500);
  })
</script>