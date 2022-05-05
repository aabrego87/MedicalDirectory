<?php
    require_once "./modelos/doctorModelo.php";

    if ($_SESSION['privilegio_mdirectory']!=1) {
        echo $lc->forzar_cierre_sesion_controlador();
        exit();
    }

    $especialidades = doctorModelo::obtener_especialidades_modelo();
?>
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO DOCTOR
    </h3>
    <p class="text-justify">
        Llena todos los datos correctamente para agregar un nuevo Doctor
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO DOCTOR</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>doctors-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE DOCTORES</a>
        </li>
    </ul>	
</div>

<!-- Content -->
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/doctorAjax.php"  method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
        <fieldset>
            <legend><i class="far fa-address-card"></i> &nbsp; Información del Doctor</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_especialidad" class="bmd-label-floating">Especialidad</label>
                            <select class="form-control" name="doctor_especialidad_reg" id="doctor_especialidad">
                                <?php for($i = 0; $i < sizeof($especialidades); $i++){ ?>
                                    <option value="<?php echo $especialidades[$i]['id_especialidad']; ?>"><?php echo $especialidades[$i]['especialidad']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_nombre" class="bmd-label-floating">Nombre (s)</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ1-9 ]{3,35}" class="form-control" name="doctor_nombre_reg" id="doctor_nombre" maxlength="35" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_apellido_p_" class="bmd-label-floating">Apellido Paterno</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ1-9 ]{3,35}" class="form-control" name="doctor_apellido_p_reg" id="doctor_apellido" maxlength="35" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_apellido_m_" class="bmd-label-floating">Apellido Materno</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ1-9 ]{3,35}" class="form-control" name="doctor_apellido_m_reg" id="doctor_apellido" maxlength="35" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_telefono" class="bmd-label-floating">Teléfono</label>
                            <input type="text" pattern="[0-9 ]{8,15}" class="form-control" name="doctor_telefono_reg" id="doctor_telefono" maxlength="35" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_telefono" class="">Descripción</label>
                            <textarea pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ1-9., ]{3,500}" class="form-control" name="doctor_descripcion_reg" id="doctor_descripcion" cols="30" rows="2" placeholder="Ingrese la descripción que desee mostrar en su perfil"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend><i class="far fa-building"></i> &nbsp; Información Del Consultorio</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_nombre_consultorio" class="bmd-label-floating">Nombre Comercial</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}" class="form-control" name="doctor_consultorio_reg" id="doctor_consultorio" maxlength="190">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="doctor_direccion_consultorio" class="bmd-label-floating">Dirección del Consultorio</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}" class="form-control" name="doctor_direccion_consultorio_reg" id="doctor_direccion_consultorio" maxlength="190">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <fieldset>
            <legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_usuario" class="bmd-label-floating">Nombre de usuario</label>
                            <input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="doctor_usuario_reg" id="doctor_usuario" maxlength="35" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="doctor_email_reg" id="doctor_email" maxlength="70">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_clave_1" class="bmd-label-floating">Contraseña</label>
                            <input type="password" class="form-control" name="doctor_clave_1_reg" id="doctor_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_clave_2" class="bmd-label-floating">Repetir contraseña</label>
                            <input type="password" class="form-control" name="doctor_clave_2_reg" id="doctor_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="doctor_imagen_reg" class="bmd-label-floating">Imagen de Perfil</label>
                            <input type="file" class="form-control btn btn-raised" name="doctor_imagen_reg" id="doctor_imagen_reg">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <input type="hidden" name="tipo_doctor" value="interno">
        <p class="text-center" style="margin-top: 40px;">
            <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
            &nbsp; &nbsp;
            <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
        </p>
    </form>
</div>
