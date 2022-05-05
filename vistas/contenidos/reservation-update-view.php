<?php
    require_once "./controladores/reservacionControlador.php";
    require_once "./modelos/reservacionModelo.php";

    $tipos_visita = reservacionModelo::datos_visita_modelo();
    $estatus = reservacionModelo::obtener_estatus_modelo();
    $ins_reservacion = new reservacionControlador();
    $datos_reservacion = $ins_reservacion->datos_reservaciones_controlador("Unico", $pagina[1]);
    if($datos_reservacion->rowCount() == 1){
        $campo = $datos_reservacion->fetch();
?>

<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR RESERVACIÓN
    </h3>
    <p class="text-justify">
        Actualiza los datos de la reservación
    </p>
    <h4 class="text-center">Estatus de la Cita: <?php echo $campo['estatus']; ?></h4>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>service-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; SERVICIOS</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>reservation-list/"><i class="far fa-calendar-alt"></i> &nbsp; RESERVACIONES</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
        <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/reservacionAjax.php" method="POST" data-form="update" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="reservacion_id_up" value="<?php echo $pagina[1]; ?>">
            <fieldset>
                <legend><i class="fa fa-clipboard-list"></i> &nbsp; Datos del Servicio</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="prestamo_fecha_inicio">Servicio</label>
                                <p class="text-dark">
                                    <?php echo $campo['nombre_servicio']; ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="prestamo_hora_inicio">Descripción</label>
                                <p class="text-dark">
                                    <?php echo $campo['descripcion']; ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="prestamo_hora_inicio">Precio</label>
                                <p class="text-dark">
                                    $ <?php echo $campo['precio']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend><i class="fas fa-user"></i> &nbsp; Datos del Paciente</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label>Nombre (s)</label>
                                <h6 class="text-dark"><?php echo $campo['nombre_cliente']; ?></h6>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label>Apellido Paterno</label>
                                <h6 class="text-dark"><?php echo $campo['apellido_p_cliente']; ?></h6>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label>Apellido Materno</label>
                                <h6 class="text-dark"><?php echo $campo['apellido_m_cliente']; ?></h6>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="form-group">
                                <label>Edad</label>
                                <h6 class="text-dark"><?php echo $campo['edad']; ?></h6>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label>Dirección</label>
                                <h6 class="text-dark"><?php echo $campo['direccion']; ?></h6>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <h6 class="text-dark"><?php echo $campo['telefono']; ?></h6>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <h6 class="text-dark"><?php echo $campo['email']; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend><i class="fas fa-cubes"></i> &nbsp; Datos de la Cita</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="reservacion_notas">Notas del Paciente</label>
                                <h6 class="text-dark"><?php echo $campo['nota_paciente']; ?></h6>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="reservacion_visita">Tipo de Visita</label><br/>
                                <h6 class="text-dark"><?php echo $campo['tipo_visita']; ?></h6>
                                
                                <!-- <select class="form-control" name="reservacion_visita_up" id="reservacion_visita">
                                    <?php for($i = 0; $i < sizeof($tipos_visita); $i++){ ?>
                                        <option value="<?php echo $tipos_visita[$i]['id_visita']; ?>" <?php if($campo['id_visita'] == $tipos_visita[$i]['id_visita']){ echo "selected";} ?>><?php echo $tipos_visita[$i]['tipo_visita']; ?></option>
                                    <?php } ?>
                                </select> -->
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="reservacion_fecha">Fecha de la Cita</label><br/>
                                <h6 class="text-dark"><?php echo $campo['fecha_cita']; ?></h6>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="reservacion_hora">Hora de la Cita</label><br/>
                                <h6 class="text-dark"><?php echo $campo['hora_cita']; ?></h6>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="reservacion_notas_doctor_up">Notas del Doctor</label><br/>
                                <textarea class="form-control" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#()., ]{1,500}" name="reservacion_notas_doctor_up" id="reservacion_notas_doctor" cols="30" rows="3" placeholder="Escriba a continuación las notas que desea dejar al paciente sobre su consulta"><?php if($campo['nota_doctor'] != ""){ echo $campo['nota_doctor']; }?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <br><br><br>
            <p class="text-center" style="margin-top: 40px;">
                <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                &nbsp; &nbsp;
                <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; FINALIZAR CONSULTA</button>
            </p>
        </form>

    <!-- MODAL PAGOS -->
    <div class="modal fade" id="ModalPago" tabindex="-1" role="dialog" aria-labelledby="ModalPago" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalPago">Agregar pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" >
                        <table class="table table-hover table-bordered table-sm">
                            <thead>
                                <tr class="text-center bg-dark">
                                    <th>FECHA</th>
                                    <th>MONTO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>Fecha</td>
                                    <td>Monto</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="container-fluid">
                        <input type="hidden" name="pago_codigo_reg">
                        <div class="form-group">
                            <label for="pago_monto_reg" class="bmd-label-floating">Monto en $</label>
                            <input type="text" pattern="[0-9.]{1,10}" class="form-control" name="pago_monto_reg" id="pago_monto_reg" maxlength="10" required="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-info btn-sm" >Agregar pago</button> &nbsp;&nbsp; 
                    <button type="button" class="btn btn-raised btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <?php } else { ?>

    <div class="alert alert-danger text-center" role="alert">
        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
        <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
    </div>
    <?php } ?>
</div>
