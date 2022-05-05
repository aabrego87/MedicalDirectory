
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR PACIENTE
    </h3>
    <p class="text-justify">
        Actualiza los datos del cliente
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>client-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR PACIENTE</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>client-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PACIENTES</a>
        </li>
    </ul>	
</div>

<?php
    require_once "./modelos/clienteModelo.php";
    require_once "./controladores/clienteControlador.php";

    $tipos_sangre = clienteModelo::obtener_tipos_sangre_modelo();

    $ins_cliente = new clienteControlador();
    $datos_cliente = $ins_cliente->datos_cliente_controlador('Unico', $pagina[1]);
    if($datos_cliente->rowCount() == 1){
        $campo = $datos_cliente->fetch();
?>

<!-- Content here-->
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/clienteAjax.php" method="POST" data-form="update" autocomplete="off">
    <input type="hidden" name="cliente_id_up" value="<?php echo $pagina[1]; ?>">
        <fieldset>
            <legend><i class="fas fa-user"></i> &nbsp; Información básica</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_nombre" class="bmd-label-floating">Nombre (s)</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="cliente_nombre_up" value="<?php echo $campo['nombre_cliente']; ?>" id="cliente_nombre" maxlength="40">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_apellido" class="bmd-label-floating">Apellido Paterno</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="cliente_apellido_p_up" value="<?php echo $campo['apellido_p_cliente']; ?>" id="cliente_apellido_p" maxlength="40">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_apellido" class="bmd-label-floating">Apellido Materno</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="cliente_apellido_m_up" value="<?php echo $campo['apellido_m_cliente']; ?>" id="cliente_apellido_m" maxlength="40">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_apellido" class="bmd-label-floating">Edad</label>
                            <select class="form-control" name="cliente_edad_up" id="cliente_edad">
                                <?php for($i = 1; $i <= 120; $i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php if($campo['edad'] == $i){ echo 'selected';}?>><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_telefono" class="bmd-label-floating">Teléfono</label>
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="cliente_telefono_up" value="<?php echo $campo['telefono']; ?>" id="cliente_telefono" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="cliente_direccion" class="bmd-label-floating">Dirección</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}" class="form-control" name="cliente_direccion_up" value="<?php echo $campo['direccion']; ?>" id="cliente_direccion" maxlength="150">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="cliente_tipo_sangre_up" id="cliente_tipo_sangre">
                                    <?php for($i = 0; $i < sizeof($tipos_sangre); $i++){ ?>
                                        <option value="<?php echo $tipos_sangre[$i]['id_tipo_sangre']; ?>" <?php if($campo['tipo_sangre'] == $tipos_sangre[$i]['id_tipo_sangre']){ echo 'selected';} ?>><?php echo $tipos_sangre[$i]['tipo_sangre']; ?></option>
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
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,40}" class="form-control" name="cliente_cuenta_up" value="<?php echo $campo['no_tarjeta']; ?>" id="cliente_cuenta" maxlength="40">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_paypal" class="bmd-label-floating">Paypal</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,40}" class="form-control" name="cliente_paypal_up" value="<?php echo $campo['paypal']; ?>" id="cliente_paypal" maxlength="40">
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
                            <input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="cliente_usuario_up" value="<?php echo $campo['usuario']; ?>" id="cliente_usuario" maxlength="35" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_email" class="bmd-label-floating">Email</label>
                            <input type="email" class="form-control" name="cliente_email_up" value="<?php echo $campo['email']; ?>" id="cliente_email" maxlength="70">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_clave_1" class="bmd-label-floating">Nueva Contraseña</label>
                            <input type="password" class="form-control" name="cliente_clave_nueva_1" id="cliente_clave_nueva_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_clave_2" class="bmd-label-floating">Repetir contraseña</label>
                            <input type="password" class="form-control" name="cliente_clave_nueva_2" id="cliente_clave_nueva_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
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
        <?php if($lc->encryption($_SESSION['id_mdirectory']) != $pagina[1]){?>
            <input type="hidden" name="tipo_cuenta" value="Impropia">
        <?php }else{ ?>
            <input type="hidden" name="tipo_cuenta" value="Propia">
        <?php } ?>
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
