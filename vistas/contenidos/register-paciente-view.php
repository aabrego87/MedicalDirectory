<!-- Page header -->
<?php
    require_once "./modelos/clienteModelo.php";

    $tipos_sangre = clienteModelo::obtener_tipos_sangre_modelo();

?>
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR PACIENTE
    </h3>
    <p class="text-justify">
        Agregar los datos para realizar el registro
    </p>
</div>

<!-- Content here-->
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/ClienteAjax.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="tipo_cliente" value="externo">
        <fieldset>
            <legend><i class="fas fa-user"></i> &nbsp; Información básica</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_nombre" class="bmd-label-floating">Nombre</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="cliente_nombre_reg" id="cliente_nombre" maxlength="40" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_apellido" class="bmd-label-floating">Apellido Paterno</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="cliente_apellido_p_reg" id="cliente_apellido_p" maxlength="40" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_apellido" class="bmd-label-floating">Apellido Materno</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="cliente_apellido_m_reg" id="cliente_apellido_m" maxlength="40" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_edad" class="bmd-label-floating">Edad</label>
                            <select class="form-control" name="cliente_edad_reg" id="cliente_edad" required>
                                <option value="0">--Seleccione una Edad--</option>
                                <?php for($i = 1; $i <= 120; $i++){ ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i . ' Años'; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_telefono" class="bmd-label-floating">Teléfono</label>
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="cliente_telefono_reg" id="cliente_telefono" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_direccion" class="bmd-label-floating">Dirección</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}" class="form-control" name="cliente_direccion_reg" id="cliente_direccion" maxlength="150" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_tipo_sangre_reg" class="">Tipo de Sangre</label>
                            <select class="form-control" name="cliente_tipo_sangre_reg" id="cliente_tipo_sangre_reg" required>
                                <?php for($i = 0; $i < sizeof($tipos_sangre); $i++){ ?>
                                    <option class="form-control" value="<?php echo $tipos_sangre[$i]['id_tipo_sangre']; ?>"><?php echo $tipos_sangre[$i]['tipo_sangre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend><i class="fas fa-credit-card"></i> &nbsp; Información de Pago</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_cuenta" class="bmd-label-floating">Número de Cuenta</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,40}" class="form-control" name="cliente_cuenta_reg" id="cliente_cuenta" maxlength="40">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_paypal" class="bmd-label-floating">Paypal</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,40}" class="form-control" name="cliente_paypal_reg" id="cliente_paypal" maxlength="40">
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
                            <label for="cliente_usuario" class="bmd-label-floating">Nombre de usuario</label>
                            <input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="cliente_usuario_reg" id="cliente_usuario" maxlength="35" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="cliente_email_reg" id="cliente_email" maxlength="70">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_clave_1" class="bmd-label-floating">Contraseña</label>
                            <input type="password" class="form-control" name="cliente_clave_1_reg" id="cliente_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_clave_2" class="bmd-label-floating">Repetir contraseña</label>
                            <input type="password" class="form-control" name="cliente_clave_2_reg" id="cliente_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_imagen_reg" class="bmd-label-floating">Foto de Perfil</label>
                            <input type="file" class="form-control" name="cliente_imagen_reg" id="cliente_imagen_reg">
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