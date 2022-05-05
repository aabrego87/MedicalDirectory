<?php
    require_once "./controladores/reservacionControlador.php";
    require_once "./modelos/reservacionModelo.php";

    $ins_reservacion = new reservacionControlador();
    $datos_servicio = $ins_reservacion->datos_servicio_controlador($pagina[1]);
    $datos_cliente = $ins_reservacion->datos_cliente_controlador($lc->encryption($_SESSION['id_mdirectory']));
    $tipos_visita = reservacionModelo::datos_visita_modelo();
    
    if($datos_servicio->rowCount() == 1){
        $campo_servicio = $datos_servicio->fetch();
    }else{
        echo 'Hola';
    }

    if($datos_cliente->rowCount() == 1){
        $campo_cliente = $datos_cliente->fetch();
    }else{
        echo 'Holac';
    }

?>
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; NUEVA RESERVACIÓN
    </h3>
    <p class="text-justify">
        Completa los datos para tu reservación.
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>reservation-list/"><i class="far fa-calendar-alt"></i> &nbsp; RESERVACIONES</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>service-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; SERVICIOS</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/reservacionAjax.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="reservacion_id_cliente" value="<?php echo $lc->encryption($_SESSION['id_mdirectory']) ?>">
        <input type="hidden" name="reservacion_id_servicio" value="<?php echo $pagina[1]; ?>">
        <input type="hidden" name="reservacion_id_doctor" value="<?php echo $pagina[2]; ?>">
        <fieldset>
            <legend><i class="fa fa-clipboard-list"></i> &nbsp; Datos del Servicio</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="prestamo_fecha_inicio">Servicio</label>
                            <p>
                                <?php echo $campo_servicio['nombre_servicio']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="prestamo_hora_inicio">Descripción</label>
                            <p>
                                <?php echo $campo_servicio['descripcion']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="prestamo_hora_inicio">Precio</label>
                            <p>
                                <?php echo $campo_servicio['precio']; ?>
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
                            <h6><?php echo $campo_cliente['nombre_cliente']; ?></h6>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Apellido Paterno</label>
                            <h6><?php echo $campo_cliente['apellido_p_cliente']; ?></h6>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Apellido Materno</label>
                            <h6><?php echo $campo_cliente['apellido_m_cliente']; ?></h6>
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <div class="form-group">
                            <label>Edad</label>
                            <h6><?php echo $campo_cliente['edad']; ?></h6>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Dirección</label>
                            <h6><?php echo $campo_cliente['direccion']; ?></h6>
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <div class="form-group">
                            <label>Teléfono</label>
                            <h6><?php echo $campo_cliente['telefono']; ?></h6>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label>Email</label>
                            <h6><?php echo $campo_cliente['email']; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend><i class="fas fa-cubes"></i> &nbsp; Datos de la Cita</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="reservacion_notas">Notas del Paciente</label>
                            <textarea pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#()., ]{1,500}" class="form-control" name="reservacion_notas_reg" id="reservacion_notas" placeholder="Escriba a continuación detalles importantes a tomar en cuenta para su consulta" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="reservacion_visita">Tipo de Visita</label><br/>
                            <select class="form-control" name="reservacion_visita_reg" id="reservacion_visita">
                                <?php for($i = 0; $i < sizeof($tipos_visita); $i++){ ?>
                                    <option value="<?php echo $tipos_visita[$i]['id_visita']; ?>"><?php echo $tipos_visita[$i]['tipo_visita']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="reservacion_fecha">Fecha de la Cita</label><br/>
                            <input class="form-control" type="date" name="reservacion_fecha_reg" id="reservacion_fecha">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="reservacion_fecha">Hora de la Cita</label><br/>
                            <input class="form-control" type="time" name="reservacion_hora_reg" id="reservacion_hora">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <center>
                                <img class="form-neon" src="<?php echo SERVERURL . 'vistas/assets/servicios/' . $campo_servicio['imagen']; ?>" width="25%" title="Imagen de <?php echo $campo_servicio['nombre_servicio']; ?>" alt="Imagen de <?php echo $campo_servicio['nombre_servicio']; ?>">
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <p class="text-center" style="margin-top: 40px;">
            <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
            &nbsp; &nbsp;
            <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; RESERVAR</button>
        </p>
    </form>
</div>


<!-- MODAL CLIENTE -->
<div class="modal fade" id="ModalCliente" tabindex="-1" role="dialog" aria-labelledby="ModalCliente" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCliente">Agregar cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="input_cliente" class="bmd-label-floating">DNI, Nombre, Apellido, Telefono</label>
                        <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_cliente" id="input_cliente" maxlength="30">
                    </div>
                </div>
                <br>
                <div class="container-fluid" id="tabla_clientes">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <tbody>
                                <tr class="text-center">
                                    <td>0000000000 - Nombre del cliente</td>
                                    <td>
                                        <button type="button" class="btn btn-primary"><i class="fas fa-user-plus"></i></button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>0000000000 - Nombre del cliente</td>
                                    <td>
                                        <button type="button" class="btn btn-primary"><i class="fas fa-user-plus"></i></button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>0000000000 - Nombre del cliente</td>
                                    <td>
                                        <button type="button" class="btn btn-primary"><i class="fas fa-user-plus"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                        No hemos encontrado ningún cliente en el sistema que coincida con <strong>“Busqueda”</strong>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
                &nbsp; &nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL ITEM -->
<div class="modal fade" id="ModalItem" tabindex="-1" role="dialog" aria-labelledby="ModalItem" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalItem">Agregar item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="input_item" class="bmd-label-floating">Código, Nombre</label>
                        <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_item" id="input_item" maxlength="30">
                    </div>
                </div>
                <br>
                <div class="container-fluid" id="tabla_items">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">
                            <tbody>
                                <tr class="text-center">
                                    <td>000000000000 - Nombre del item</td>
                                    <td>
                                        <button type="button" class="btn btn-primary"><i class="fas fa-box-open"></i></button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>000000000000 - Nombre del item</td>
                                    <td>
                                        <button type="button" class="btn btn-primary"><i class="fas fa-box-open"></i></button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>000000000000 - Nombre del item</td>
                                    <td>
                                        <button type="button" class="btn btn-primary"><i class="fas fa-box-open"></i></button>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <td>000000000000 - Nombre del item</td>
                                    <td>
                                        <button type="button" class="btn btn-primary"><i class="fas fa-box-open"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="alert alert-warning" role="alert">
                    <p class="text-center mb-0">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                        No hemos encontrado ningún item en el sistema que coincida con <strong>“Busqueda”</strong>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
                &nbsp; &nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL AGREGAR ITEM -->
<div class="modal fade" id="ModalAgregarItem" tabindex="-1" role="dialog" aria-labelledby="ModalAgregarItem" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content FormularioAjax">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalAgregarItem">Selecciona el formato, cantidad de items, tiempo y costo del préstamo del item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_agregar_item" id="id_agregar_item">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="detalle_formato" class="bmd-label-floating">Formato de préstamo</label>
                                <select class="form-control" name="detalle_formato" id="detalle_formato">
                                    <option value="Horas" selected="" >Horas</option>
                                    <option value="Dias">Días</option>
                                    <option value="Evento">Evento</option>
                                    <option value="Mes">Mes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="detalle_cantidad" class="bmd-label-floating">Cantidad de items</label>
                                <input type="num" pattern="[0-9]{1,7}" class="form-control" name="detalle_cantidad" id="detalle_cantidad" maxlength="7" required="" >
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="detalle_tiempo" class="bmd-label-floating">Tiempo (según formato)</label>
                                <input type="num" pattern="[0-9]{1,7}" class="form-control" name="detalle_tiempo" id="detalle_tiempo" maxlength="7" required="" >
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="detalle_costo_tiempo" class="bmd-label-floating">Costo por unidad de tiempo</label>
                                <input type="text" pattern="[0-9.]{1,15}" class="form-control" name="detalle_costo_tiempo" id="detalle_costo_tiempo" maxlength="15" required="" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Agregar</button>
                &nbsp; &nbsp;
                <button type="button" class="btn btn-secondary" >Cancelar</button>
            </div>
        </form>
    </div>
</div>
