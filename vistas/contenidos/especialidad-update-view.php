<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR ESPECIALIDAD
    </h3>
    <p class="text-justify">
        Actualiza los datos de la especialidad
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>especialidad-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ESPECIALIDAD</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>especialidad-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; ESPECIALIDADES</a>
        </li>
    </ul>	
</div>

<?php
    require_once "./controladores/especialidadControlador.php";

    $ins_especialidad = new especialidadControlador();
    $datos_especialidad = $ins_especialidad->datos_especialid_controlador("Unico", $pagina[1]);
    if($datos_especialidad->rowCount() == 1){
        $campo = $datos_especialidad->fetch();
?>

<!-- Content here-->
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/especialidadAjax.php" method="POST" data-form="update" autocomplete="off">
    <input type="hidden" name="especialidad_id_up" value="<?php echo $pagina[1]; ?>">
        <fieldset>
            <legend><i class="fas fa-star"></i> &nbsp; Información de la Especialidad</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="especialidad_nombre" class="bmd-label-floating">Nombre de la Especialidad</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,40}" class="form-control" name="especialidad_nombre_up" value="<?php echo $campo['especialidad']; ?>" id="especialidad_nombre" maxlength="40">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <fieldset>
            <p class="text-center">Para poder guardar los cambios en esta cuenta debe de ingresar su nombre de usuario y contraseña</p>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="usuario_admin" class="bmd-label-floating">Nombre de usuario</label>
                            <input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="usuario_admin" id="usuario_admin" maxlength="35" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="clave_admin" class="bmd-label-floating">Contraseña</label>
                            <input type="password" class="form-control" name="clave_admin" id="clave_admin" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
        </p>
    </form>
<?php }else { ?>
    <div class="alert alert-danger text-center" role="alert">
        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
        <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
    </div>
<?php } ?>

</div>	
