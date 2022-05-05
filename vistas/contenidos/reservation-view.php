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
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; VER INFORMACIÓN DE LA RESERVACIÓN
    </h3>
    <p class="text-justify">
        Consulta los datos de la reservación
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
            <div class="form-neon">
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
                            <?php if($campo['nota_doctor'] != ""){ ?>
                                
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="reservacion_nota_doctor">Notas del Doctor</label><br/>
                                    <h6 class="text-dark"><?php echo $campo['nota_doctor']; ?></h6>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </fieldset>
            </div>
            <br><br>

    <?php } else { ?>

    <div class="alert alert-danger text-center" role="alert">
        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
        <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
    </div>
    <?php } ?>
</div>
