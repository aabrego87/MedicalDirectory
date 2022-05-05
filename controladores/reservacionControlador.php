<?php
    if($peticionAjax){
        require_once "../modelos/reservacionModelo.php";
    }else{
        require_once "./modelos/reservacionModelo.php";
    }

    class reservacionControlador extends reservacionModelo{
        /**----------Datos de Servicio Controlador---------- */
        public function datos_servicio_controlador($id){
            /**----------Recibiendo y Desencriptando ID---------- */
            $id = mainModel::decryption($id);
            $id = mainModel::limpiar_cadena($id);

            return reservacionModelo::datos_servicio_modelo($id);

        }/**----------Fin del Controlador---------- */

        /**----------Datos de Cliente Controlador---------- */
        public function datos_cliente_controlador($id){
            /**----------Recibiendo y Desencriptando ID---------- */
            $id = mainModel::decryption($id);
            $id = mainModel::limpiar_cadena($id);

            return reservacionModelo::datos_cliente_modelo($id);
        }

        /**----------Agregar Reservación Controlador---------- */
        public function agregar_reservacion_controlador(){
            /**----------Recibendo Y Desencriptando IDs---------- */
            $id_cliente = mainModel::decryption($_POST['reservacion_id_cliente']);
            $id_servicio = mainModel::decryption($_POST['reservacion_id_servicio']);
            $id_doctor = mainModel::decryption($_POST['reservacion_id_doctor']);
            
            $id_cliente = mainModel::limpiar_cadena($id_cliente);
            $id_servicio = mainModel::limpiar_cadena($id_servicio);
            $id_doctor = mainModel::limpiar_cadena($id_doctor);

            /**---------Recibiendo Datos del Formulario---------- */
            $notas = mainModel::limpiar_cadena($_POST['reservacion_notas_reg']);
            $visita = mainModel::limpiar_cadena($_POST['reservacion_visita_reg']);
            $fecha = mainModel::limpiar_cadena($_POST['reservacion_fecha_reg']);
            $hora = mainModel::limpiar_cadena($_POST['reservacion_hora_reg']);

            $estatus = 1;

            /**----------Comprobando Campos Vacios---------- */
            if($notas == "" || $visita == ""){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No ha llenado todos los datos obligatorios",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Comprobando Campos y en DB---------- */
            $check_visita = mainModel::ejecutar_consulta_simple("SELECT * FROM visita WHERE id_visita = $visita");
            if($check_visita->rowCount() <= 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta acción",
                    "Texto"=>"El tipo de visita seleccionado no es válido",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**-----Datos Agregar Reservacion----- */
            $datos_reservacion_reg = [
                "Doctor"=>$id_doctor,
                "Servicio"=>$id_servicio,
                "Cliente"=>$id_cliente,
                "Estatus"=>$estatus,
                "Visita"=>$visita,
                "Nota"=>$notas,
                "Fecha"=>$fecha,
                "Hora"=>$hora
            ];

            $agregar_reservacion = reservacionModelo::agregar_reservacion_modelo($datos_reservacion_reg);

            if($agregar_reservacion->rowCount() == 1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Reservación Registrada",
                    "Texto"=>"Los datos han sido agregados con éxito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"No ha sido posible agregar la RESERVACIÓN, intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
        }/**----------Fin del Controlador---------- */

        /**----------Paginador Reservaciones Controlador---------- */
        public function paginador_reservaciones_controlador($pagina, $registros, $privilegio, $id, $url, $busqueda){
            $pagina = mainModel::limpiar_cadena(($pagina));
            $registros = mainModel::limpiar_cadena($registros);
            $privilegio = mainModel::limpiar_cadena($privilegio);
            $id = mainModel::limpiar_cadena($id);

            $url = mainModel::limpiar_cadena($url);
            $url = SERVERURL.$url."/";
            
            $busqueda = mainModel::limpiar_cadena($busqueda);
            $tabla = "";
            $pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1 ;
            $inicio = ($pagina > 0) ? (($pagina * $registros)-$registros) : 0 ;

            if($privilegio == 1 || $privilegio == 2 | $privilegio == 3){ // Si es Usuario o Adminisrador
                if ($busqueda != "") {
                }else{
                    $consulta = "SELECT SQL_CALC_FOUND_ROWS
                    id_reservacion,
                    reservaciones.id_doctor,
                    doctores.nombre_doctor,
                    clientes.nombre_cliente,
                    servicios.nombre_servicio,
                    estatus.estatus,
                    visita.tipo_visita,
                    nota_paciente
                    FROM reservaciones
                    INNER JOIN doctores ON doctores.id_doctor = reservaciones.id_doctor
                    INNER JOIN clientes ON clientes.id_cliente = reservaciones.id_cliente
                    INNER JOIN servicios ON servicios.id_servicio = reservaciones.id_servicio
                    INNER JOIN estatus ON estatus.id_estatus = reservaciones.id_estatus
                    INNER JOIN visita ON visita.id_visita = reservaciones.id_visita
                    ORDER BY id_reservacion ASC LIMIT $inicio, $registros";
                }
            }else if($privilegio == 4){ // Si es Doctor
                if ($busqueda != "") {
                }else{
                    $consulta = "SELECT SQL_CALC_FOUND_ROWS
                    id_reservacion,
                    reservaciones.id_doctor,
                    doctores.nombre_doctor,
                    clientes.nombre_cliente,
                    servicios.nombre_servicio,
                    estatus.estatus,
                    visita.tipo_visita,
                    nota_paciente
                    FROM reservaciones
                    INNER JOIN doctores ON doctores.id_doctor = reservaciones.id_doctor
                    INNER JOIN clientes ON clientes.id_cliente = reservaciones.id_cliente
                    INNER JOIN servicios ON servicios.id_servicio = reservaciones.id_servicio
                    INNER JOIN estatus ON estatus.id_estatus = reservaciones.id_estatus
                    INNER JOIN visita ON visita.id_visita = reservaciones.id_visita
                    WHERE reservaciones.id_doctor = $id AND reservaciones.id_estatus = 1
                    ORDER BY id_reservacion ASC LIMIT $inicio, $registros";
                }
            }else if($privilegio == 5){ // Si es Cliente
                if ($busqueda != "") {
                }else{
                    $consulta = "SELECT SQL_CALC_FOUND_ROWS
                    id_reservacion,
                    reservaciones.id_doctor,
                    doctores.nombre_doctor,
                    clientes.nombre_cliente,
                    servicios.nombre_servicio,
                    estatus.estatus,
                    visita.tipo_visita,
                    nota_paciente
                    FROM reservaciones
                    INNER JOIN doctores ON doctores.id_doctor = reservaciones.id_doctor
                    INNER JOIN clientes ON clientes.id_cliente = reservaciones.id_cliente
                    INNER JOIN servicios ON servicios.id_servicio = reservaciones.id_servicio
                    INNER JOIN estatus ON estatus.id_estatus = reservaciones.id_estatus
                    INNER JOIN visita ON visita.id_visita = reservaciones.id_visita
                    WHERE reservaciones.id_cliente = $id AND reservaciones.id_estatus = 1
                    ORDER BY id_reservacion ASC LIMIT $inicio, $registros";
                }
            }

            $conexion = mainModel::conectar();
            
            $datos = $conexion->query($consulta);
            $datos = $datos->fetchAll();

            $total = $conexion->query("SELECT FOUND_ROWS()");
            $total = (int) $total->fetchColumn();

            $Npaginas = ceil($total/$registros);

            $tabla.= '<div class="table-responsive">
                <table class="table table-dark table-sm">
                    <thead>
                        <tr class="text-center roboto-medium">
                            <th>#</th>
                            <th>Doctor</th>
                            <th>Cliente</th>
                            <th>Servicio</th>
                            <th>Estatus</th>
                            <th>Notas</th>';
                            if($privilegio==1 || $privilegio==2 || $privilegio==4 || $privilegio==5){
                                $tabla.='<th colspan="2">Acciones</th>';
                            }
                            if($privilegio==1){
                                $tabla.='<th>ELIMINAR</th>';
                            }
                            $tabla.='</tr>
                    </thead>
                    <tbody>';

                if ($total>=1 && $pagina<=$Npaginas) {
                    $contador = $inicio + 1;
                    $reg_inicio = $inicio + 1;
                    foreach($datos as $rows){
                        $tabla.= '
                        <tr class="text-center" >
                            <td>'. $contador .'</td>
                            <td>
                                <a href="'.SERVERURL.'doctors-profile/'.mainModel::encryption($rows['id_doctor']).'">
                                    '. $rows['nombre_doctor'] .'
                                </a>
                            </td>
                            <td>'. $rows['nombre_cliente'] .'</td>
                            <td>'. $rows['nombre_servicio'] .'</td>
                            <td>'. $rows['estatus'] .'</td>
                            <td>'. $rows['nota_paciente'] .'</td>';
                            if($privilegio==1 || $privilegio==2 || $privilegio==4){
                                $tabla.='<td>
                                    <form class="FormularioAjax" action="'.SERVERURL.'ajax/reservacionAjax.php" method="POST" data-form="start">
                                        <input type="hidden" name="reservacion_id_start" value="'.mainModel::encryption($rows['id_reservacion']).'">
                                        <button class="btn btn-raised btn-success" title="Iniciar la consulta del paciente">
                                            INICIAR CONSULTA
                                        </button>
                                    </form>
                                </td>';
                            }
                            if($privilegio==1 || $privilegio==2 || $privilegio==4 || $privilegio==5){
                                $tabla .= '<td>
                                    <a class="btn btn-raised btn-info" href="'.SERVERURL.'reservation/'.mainModel::encryption($rows['id_reservacion']).'/" title="Ver información de la consulta">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>';
                            }
                            if($privilegio==1){
                                $tabla.='<td>
                                    <form class="FormularioAjax" action="'.SERVERURL.'ajax/reservacionAjax.php"  method="POST" data-form="delete" autocomplete="off">
                                        <input type="hidden" name="reservacion_id_del" value="'.mainModel::encryption($rows['id_reservacion']).'">                                
                                        <button type="submit" class="btn btn-warning">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>';
                            }
                        $tabla.='</tr>';
                        $contador++;
                    }
                    $reg_final = $contador - 1;
                } else {
                    if ($total>=1) { // No hay registros
                        $tabla .= '<tr class="text-center" ><td colspan="9">
                            <a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Recargar el listado</a>
                        </td></tr>';
                    } else {
                        $tabla.= '<tr class="text-center" ><td colspan="12">No hay registros en el sistema</td></tr>';
                    }
                }
            $tabla.= '</tbody></table></div>';
            
            if ($total>=1 && $pagina<=$Npaginas) {
                $tabla .= '<p class="text-right">Mostrando Reservaciones '. $reg_inicio .' al '. $reg_final .' de un total de '. $total .'</p>';
                $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
            }

            return $tabla;
        }/**----------Fin del Controlador---------- */

        /**----------Datos Reservaciones Controlador---------- */
        public function datos_reservaciones_controlador($tipo, $id){
            /**----------Reciiendo y Desencriptando ID---------- */
            $id = mainModel::decryption($id);
            $id = mainModel::limpiar_cadena($id);

            $tipo = mainModel::limpiar_cadena($tipo);

            return reservacionModelo::datos_reservaciones_modelo($tipo, $id);
        }/**----------Fin del Controlador---------- */

        /**----------Iniciar Consulta Controlador---------- */
        public function iniciar_consulta_controlador(){
            date_default_timezone_set('America/Mexico_City');
            $hoy = getdate();
            $hora_actual = $hoy['hours'] .':'.$hoy['minutes'].':'.$hoy['seconds'];
            /**----------Recibiendo y Desencriptando ID---------- */
            $id = mainModel::decryption($_POST['reservacion_id_start']);
            $id = mainModel::limpiar_cadena($id);

            $estatus = 2;
            
            /**----------Comprobando Reservacion---------- */
            $check_reservacion = mainModel::ejecutar_consulta_simple("SELECT id_reservacion FROM reservaciones WHERE id_reservacion = $id");
            if($check_reservacion->rowCount() < 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No se han encontrado los datos de la Cita",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Comprobando Consulta Modificada---------- */
            $check_reservacion = mainModel::ejecutar_consulta_simple("SELECT id_reservacion FROM reservaciones WHERE id_reservacion = $id AND hora_inicio != '' AND hora_fin != ''");
            if($check_reservacion->rowCount() >= 1){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"La consulta que desea iniciar ya ha sido modificada",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            
            /**----------Datos para actualizar estatus e iniciar la consulta---------- */
            $datos_consulta_up = [
                "Estatus"=>$estatus,
                "HInicio"=>$hora_actual,
                "ID"=>$id
            ];

            $actualizar_reservacion = reservacionModelo::actualizar_reservacion_modelo($datos_consulta_up);
            
            if($actualizar_reservacion->rowCount() == 1){
                //Encriptando ID para URL
                $id = mainModel::encryption($id);
                $url = SERVERURL."reservation-update/".$id;

                $alerta = [
                    "Alerta"=>"redireccionar",
                    "Titulo"=>"La consulta ha dado inicio en este momento ($hora_actual)",
                    "Texto"=>"Asegúrese de tomar el tiempo que sea necesario para atender al paciente",
                    "Tipo"=>"info",
                    "URL"=>$url
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No ha sido posible iniciar con la consulta, intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            exit();
        }/**----------Fin del Controlador---------- */

        /**----------Actualizar Reservacion Controlador---------- */
        public function actualizar_reservacion_controlador(){
            date_default_timezone_set('America/Mexico_City');
            $hoy = getdate();
            $hora_actual = $hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds'];
            /**-----------Recibiendo y Desencriptando ID----------- */
            $id = mainModel::decryption($_POST['reservacion_id_up']);
            $id = mainModel::limpiar_cadena($id);

            $check_reservacion = mainModel::ejecutar_consulta_simple("SELECT * FROM reservaciones WHERE id_reservacion = $id");
            if($check_reservacion->rowCount() <= 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"La RESERVACIÓN que desea actualizar no se encuentra en la base de datos",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos = $check_reservacion->fetch();
            }

            /**----------Recibiendo Datos del Formulario---------- */
            $notas_doctor = mainModel::limpiar_cadena($_POST['reservacion_notas_doctor_up']);
            $estatus = 3;
            $url = SERVERURL.'reservation-list/';

            /**---------Comprobando Campos Vacios---------- */
            if($notas_doctor == ""){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No ha llenado todos los campos obligatorios",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Verificando la Integridad de los Datos---------- */
            if(mainModel::verificar_datos("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#()., ]{1,500}", $notas_doctor)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"Las NOTAS DEL DOCTOR no coinciden con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            /**----------Comprobando campos y en BBDD---------- */
            if($notas_doctor != ""){
                if($notas_doctor != $campos['nota_doctor']){
                    if(mainModel::verificar_datos("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#()., ]{1,500}", $notas_doctor)){
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"No se puede completar la operación",
                            "Texto"=>"Las NOTAS del DOCTOR no coinciden con el formato solicitado",
                            "Tipo"=>"warning"
                        ];
                        echo json_encode($alerta);
                        exit();
                    }
                }
            }

            $datos_reservacion_up = [
                "Estatus"=>$estatus,
                "NotaDoctor"=>$notas_doctor,
                "HInicio"=>$campos['hora_inicio'],
                "HFin"=>$hora_actual,
                "ID"=>$id
            ];

            if(reservacionModelo::actualizar_reservacion_modelo($datos_reservacion_up)){
                $alerta = [
                    "Alerta"=>"redireccionar",
                    "Titulo"=>"Consulta Finalizada",
                    "Texto"=>"Los datos de la consulta han sido guardados con éxito, fin de la consulta: $hora_actual",
                    "Tipo"=>"success",
                    "URL"=>$url
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No ha sido posible actualizar la reservación, intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            exit();
        }/**----------Fin del Controlador---------- */

        /**----------Eliminar Reservacion Controlador---------- */
        public function eliminar_reservacion_controlador(){
            /**----------Recibiendo y Desencriptando ID---------- */
            $id = mainModel::decryption($_POST['reservacion_id_del']);
            $id = mainModel::limpiar_cadena($id);

            $check_reservacion = mainModel::ejecutar_consulta_simple("SELECT id_reservacion FROM reservaciones WHERE id_reservacion = $id");
            if($check_reservacion->rowCount() <= 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"La RESERVACIÓN que desea eliminar no se encuentra en la base de datos",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**-----Comprobando Privilegio----- */
            session_start(['name' => 'MDIRECTORY']);
            if($_SESSION['privilegio_mdirectory'] != 1){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            $eliminar_reservacion = reservacionModelo::eliminar_reservacion_modelo($id);

            if($eliminar_reservacion->rowCount() == 1){
                $alerta = [
                    "Alerta"=>"recargar",
                    "Titulo"=>"Reservación Eliminada",
                    "Texto"=>"Los datos se han eliminado correctamente",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No ha sido posible eliminar la reservación, intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            exit();
        }/**----------Fin del Controlador---------- */
    }
?>