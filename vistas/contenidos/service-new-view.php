<?php
    require_once "./modelos/servicioModelo.php";

    if ($_SESSION['privilegio_mdirectory']!=1 && $_SESSION['privilegio_mdirectory']!=3 && $_SESSION['privilegio_mdirectory'] != 4) {
        echo $lc->forzar_cierre_sesion_controlador();
        exit();
    }

    $doctores = servicioModelo::obtener_doctores_modelo();
    $especialidades = servicioModelo::obtener_especialidades_modelo();
?>
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO SERVICIO
    </h3>
    <p class="text-justify">
        Llena todos los datos correctamente para agregar un nuevo Servicio
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>service-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO SERVICIO</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>service-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; SERVICIOS</a>
        </li>
    </ul>	
</div>

<!-- Content -->
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/servicioAjax.php"  method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Información del Servicio</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="servicio_nombre" class="bmd-label-floating">Nombre Del Servicio</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ1-9-., ]{3,500}" class="form-control" name="servicio_nombre_reg" id="servicio_nombre" maxlength="500" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="servicio_apellido_p_" class="bmd-label-floating">Descripción del Servicio</label>
                            <textarea class="form-control" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9., ]{3,500}" name="servicio_descripcion_reg" id="servicio_descripcion" cols="30" rows="10" required=""></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="servicio_precio" class="bmd-label-floating">Precio</label>
                            <input type="text" pattern="[0-9. ]{1,35}" class="form-control" name="servicio_precio_reg" id="servicio_precio" maxlength="35" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="servicio_imagen" class="bmd-label-floating">Imagen del Servicio</label>
                            <input class="form-control btn btn-raised" type="file" name="servicio_imagen_reg" id="servicio_imagen">
                        </div>
                    </div>
                    <?php if($_SESSION['privilegio_mdirectory'] == 1){ ?>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                            <label for="servicio_doctor" class="bmd-label-floating">Seleccionar Doctor</label>
                                <select class="form-control" name="servicio_doctor_reg" id="servicio_doctor">
                                    <?php for($i = 0; $i < sizeof($doctores); $i++){ ?>
                                        <option value="<?php echo $doctores[$i]['id_doctor']; ?>"><?php echo $doctores[$i]['nombre_doctor']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="servicio_doctor" class="bmd-label-floating">Categoría de Servicio</label>
                            <select class="form-control" name="servicio_especialidad_reg" id="servicio_especialidad">
                                <?php for($i = 0; $i < sizeof($especialidades); $i++){ ?>
                                    <option value="<?php echo $especialidades[$i]['id_especialidad']; ?>"><?php echo $especialidades[$i]['especialidad']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <p class="text-center" style="margin-top: 40px;">
            <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
            &nbsp; &nbsp;
            <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
        </p>
    </form>
</div>
