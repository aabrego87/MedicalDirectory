
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR DOCTOR
    </h3>
    <p class="text-justify">
        Modifique su información, Doctor
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>doctors-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR DOCTOR</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>doctors-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE DOCTORES</a>
        </li>
    </ul>	
</div>

<?php //Obteniendo datos del Doctor
    require_once "./controladores/doctorControlador.php";

    $ins_doctor = new doctorControlador();
    $datos_doctor = $ins_doctor->datos_doctor_controlador("Unico", $pagina[1]);

    if($datos_doctor->rowCount() == 1){
        $campo = $datos_doctor->fetch();
?>

<!-- Content here-->
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/doctorAjax.php" method="POST" data-form="update" autocomplete="off">
        <input type="hidden" name="doctor_id_up" value="<?php echo $pagina[1]; ?>">
        <fieldset>
            <legend><i class="fas fa-user"></i> &nbsp; Información del Doctor</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_nombre" class="bmd-label-floating">Nombre (s)</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="doctor_nombre_up" value="<?php echo $campo['nombre_doctor']; ?>" id="doctor_nombre" maxlength="40">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_apellido" class="bmd-label-floating">Apellido Paterno</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="doctor_apellido_p_up" value="<?php echo $campo['apellido_p_doctor']; ?>" id="doctor_apellido" maxlength="40">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_apellido" class="bmd-label-floating">Apellido Materno</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="doctor_apellido_m_up" value="<?php echo $campo['apellido_m_doctor']; ?>" id="doctor_apellido" maxlength="40">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_telefono" class="bmd-label-floating">Teléfono</label>
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="doctor_telefono_up" value="<?php echo $campo['telefono']; ?>" id="doctor_telefono" maxlength="20">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend><i class="fas fa-store"></i> &nbsp; Información del Negocio</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_negocio" class="bmd-label-floating">Nombre del Negocio</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}" class="form-control" name="doctor_negocio_up" value="<?php echo $campo['nombre_negocio']; ?>" id="doctor_negocio" maxlength="150">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_direccion" class="bmd-label-floating">Dirección del Consultorio</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}" class="form-control" name="doctor_direccion_up" value="<?php echo $campo['direccion_consultorio']; ?>" id="doctor_direccion" maxlength="150">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend><i class="fas fa-user-lock"></i> &nbsp; Información de la Cuenta</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_usuario" class="bmd-label-floating">Nombre de usuario</label>
                            <input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="doctor_usuario_up" value="<?php echo $campo['usuario']; ?>" id="doctor_usuario" maxlength="35" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="doctor_email_up" value="<?php echo $campo['email']; ?>" id="doctor_email" maxlength="70">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_clave_1" class="bmd-label-floating">Nueva Contraseña</label>
                            <input type="password" class="form-control" name="doctor_clave_nueva_1" id="doctor_clave_nueva_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_clave_2" class="bmd-label-floating">Repetir Nueva Contraseña</label>
                            <input type="password" class="form-control" name="doctor_clave_nueva_2" id="doctor_clave_nueva_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
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
                            <input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="usuario_admin" id="usuario_admin" maxlength="35" required="" >
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="clave_admin" class="bmd-label-floating">Contraseña</label>
                            <input type="password" class="form-control" name="clave_admin" id="clave_admin" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="" >
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <?php if($lc->encryption($_SESSION['id_mdirectory']) != $pagina[1]){?>
            <input type="hidden" name="tipo_cuenta" value="Impropia">
        <?php }else{ ?>
            <input type="hidden" name="tipo_cuenta" value="Propia">
        <?php } ?>
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
