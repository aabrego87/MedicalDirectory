<?php
    require_once "./modelos/servicioModelo.php";

    $doctores = servicioModelo::obtener_doctores_modelo();
    $especialidades = servicioModelo::obtener_especialidades_modelo();
?>
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR SERVICIO
    </h3>
    <p class="text-justify">
        Modifique su información, Doctor
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <?php if($_SESSION['privilegio_mdirectory'] == 1 || $_SESSION['privilegio_mdirectory'] == 3 || $_SESSION['privilegio_mdirectory'] == 4){ ?>
        <li>
            <a href="<?php echo SERVERURL; ?>service-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR SERVICIO</a>
        </li>
        <?php } ?>
        <li>
            <a href="<?php echo SERVERURL; ?>service-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; SERVICIOS</a>
        </li>
    </ul>	
</div>

<?php //Obteniendo datos del Doctor
    require_once "./controladores/servicioControlador.php";

    $ins_servicio = new servicioControlador();
    $datos_servicio = $ins_servicio->datos_servicio_controlador("Unico", $pagina[1]);

    if($datos_servicio->rowCount() == 1){
        $campo = $datos_servicio->fetch();
?>

<!-- Content here-->
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/servicioAjax.php" method="POST" data-form="update" autocomplete="off">
        <input type="hidden" name="servicio_id_up" value="<?php echo $pagina[1]; ?>">
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Información del Servicio</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="servicio_nombre" class="bmd-label-floating">Nombre Del Servicio</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ1-9-., ]{3,500}" class="form-control" name="servicio_nombre_up" id="servicio_nombre" value="<?php echo $campo['nombre_servicio']; ?>" maxlength="500" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="servicio_descripcion" class="bmd-label-floating">Descripción del Servicio</label>
                            <textarea class="form-control" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9-., ]{3,500}" name="servicio_descripcion_up" id="servicio_descripcion" cols="30" rows="10" required=""><?php echo $campo['descripcion']; ?></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="servicio_precio" class="bmd-label-floating">Precio</label>
                            <input type="text" pattern="[0-9. ]{1,35}" class="form-control" name="servicio_precio_up" id="servicio_precio" value="<?php echo $campo['precio']; ?>" maxlength="35" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <select class="form-control" name="servicio_especialidad_up" id="servicio_especialidad">
                                <?php for($i = 0; $i < sizeof($especialidades); $i++){ ?>
                                    <option value="<?php echo $especialidades[$i]['id_especialidad']; ?>" <?php if($campo['id_especialidad'] == $especialidades[$i]['id_especialidad']){ echo 'selected';} ?>><?php echo $especialidades[$i]['especialidad']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="servicio_imagen" class="bmd-label-floating">Imagen del Servicio</label>
                            <input class="form-control btn btn-raised" type="file" name="servicio_imagen_up" id="servicio_imagen">
                        </div>
                    </div> -->
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
        </p>
    </form>

<?php }else{ ?><!--Alerta si no se encuentra el ID-->
    <div class="alert alert-danger text-center" role="alert">
        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
        <h4 class="alert-heading">¡Algo no va bien!</h4>
        <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un problema.</p>
    </div>
<?php } ?>

</div>	
