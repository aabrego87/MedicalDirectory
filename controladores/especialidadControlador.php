<?php 
    if($peticionAjax){
        require_once "../modelos/especialidadModelo.php";
    }else{
        require_once "./modelos/especialidadModelo.php";
    }

    class especialidadControlador extends especialidadModelo{
        /**----------Agregar Especialidad Controlador---------- */
        public function agregar_especialidad_controlador(){
            /**----------Recibiendo datos de Formulario---------- */
            $nombre = mainModel::limpiar_cadena($_POST['especialidad_nombre_reg']);

            /**----------Comprobando campos vacios---------- */
            if($nombre == ""){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No ha llenado todos los datos obligatorios",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Verificando la integridad de los datos---------- */
            if(mainModel::verificar_datos("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}", $nombre)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El NOMBRE de la especialidad no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Verificando datos y en DDBB---------- */
            $check_especialidad = mainModel::ejecutar_consulta_simple("SELECT id_especialidad FROM especialidades WHERE especialidad = '$nombre'");
            if($check_especialidad->rowCount() == 1){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"La ESPECIALIDAD que desea agregar ya se encuentra registrada en el sistema",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**-----Datos para agregar especialidad----- */
            $datos_especialidad_reg = [
                "Especialidad"=>$nombre
            ];

            $agregar_especialidad = especialidadModelo::agregar_especialidad_modelo($datos_especialidad_reg);
            if($agregar_especialidad->rowCount() == 1){
                $alerta = [
                    "Alerta"=>"limpiar",
                    "Titulo"=>"Especialidad Registrada",
                    "Texto"=>"Los datos han sido agregados con éxito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No ha sido posible agregar la Especialidad, intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            exit();
        }/**----------Fin del Controlador---------- */

        /**----------Paginador Especialidad Controlador---------- */
        public function paginador_especialidad_controlador($pagina, $registros, $privilegio, $id, $url, $busqueda){
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

            if ($busqueda != "") {
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS *
                FROM especialidades
                ORDER BY id_especialidad ASC LIMIT $inicio, $registros";
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
                            <th>Especialidad</th>';
                            if($privilegio==1 || $privilegio==2){
                                $tabla.='<th>ACTUALIZAR</th>';
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
                            <td>'. $rows['especialidad'] .'</td>';
                            if($privilegio==1 || $privilegio==2){
                                $tabla.='<td>
                                    <a href="'.SERVERURL.'especialidad-update/'.mainModel::encryption($rows['id_especialidad']).'/" class="btn btn-success">
                                        <i class="fas fa-sync-alt"></i>	
                                    </a>
                                </td>';
                            }
                            if($privilegio==1){
                                $tabla.='<td>
                                    <form class="FormularioAjax" action="'.SERVERURL.'ajax/especialidadAjax.php"  method="POST" data-form="delete" autocomplete="off">
                                        <input type="hidden" name="especialidad_id_del" value="'.mainModel::encryption($rows['id_especialidad']).'">                                
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
                $tabla .= '<p class="text-right">Mostrando Especialidades '. $reg_inicio .' al '. $reg_final .' de un total de '. $total .'</p>';
                $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
            }

            return $tabla;
        }/**----------Fin del Controlador---------- */

        /**----------Datos Especialidad Controlador---------- */
        public function datos_especialid_controlador($tipo, $id){
            $id = mainModel::decryption($id);
            $id = mainModel::limpiar_cadena($id);

            $tipo = mainModel::limpiar_cadena($tipo);

            return especialidadModelo::datos_especialidades_modelo($tipo, $id);
        }/**----------Fin del Controlador---------- */

        /**----------Actualizar Especialidad Controlador---------- */
        public function actualizar_especialidad_controlador(){
            /**----------Recibiendo y Desencriptando ID */
            $id = mainModel::decryption($_POST['especialidad_id_up']);
            $id = mainModel::limpiar_cadena($id);

            /**----------Comprobando Especialidad en DDBB---------- */
            $check_especialidad = mainModel::ejecutar_consulta_simple("SELECT * FROM especialidades WHERE id_especialidad = $id");
            if($check_especialidad->rowCount() <= 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"La ESPECIALIDAD que desea actualizar no se encuentra en la base de datos",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos = $check_especialidad->fetch();
            }

            /**----------Recibiendo Datos del Formulario---------- */
            $especialidad = mainModel::limpiar_cadena($_POST['especialidad_nombre_up']);
            
            $usuario_admin = mainModel::limpiar_cadena($_POST['usuario_admin']);
            $clave_admin = mainModel::limpiar_cadena($_POST['clave_admin']);

            /**----------Verificando la Integridad de los datos---------- */
            if(mainModel::verificar_datos("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}", $especialidad)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"La ESPECIALIDAD no coincide con el formto solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            //Encriptando clave de Admin para comprobar en DB
            $clave_admin = mainModel::encryption($clave_admin);

            /**----------Comprobando Campos y en DB---------- */
            if($especialidad != $campos['especialidad']){
                $check_especialidad = mainModel::ejecutar_consulta_simple("SELECT especialidad FROM especialidades WHERE especialidad = '$especialidad'");
                if($check_especialidad->rowCount() > 0){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede completar la operación",
                        "Texto"=>"La ESPECIALIDAD ingresada ya se encuentra registrada en el sistema",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            /**----------Comprobando Credenciales para Actualizar---------- */
            session_start(['name' => 'MDIRECTORY']);
            $id_usuario = $_SESSION['id_mdirectory'];
            if($_SESSION['privilegio_mdirectory'] != 1 && $_SESSION['privilegio_mdirectory'] != 4){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No cuentas con los permisos necesarios para reaizar esta operación",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if($_SESSION['privilegio_mdirectory'] == 1){
                $check_cuenta = mainModel::ejecutar_consulta_simple("SELECT * FROM usuarios WHERE usuario_usuario = '$usuario_admin' AND usuario_clave = '$clave_admin' AND id_usuario = '$id_usuario'");
            }else if($_SESSION['privilegio_mdirectory'] == 4){
                $check_cuenta = mainModel::ejecutar_consulta_simple("SELECT * FROM doctores WHERE usuario = '$usuario_admin' AND pass = '$clave_admin' AND id_doctor = '$id_usuario'");
            }

            if($check_cuenta->rowCount() <= 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El NOMBRE y CLAVE del administrador no son correctas",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**-----Datos para Actualizar----- */
            $datos_especialidad_up = [
                "Especialidad"=>$especialidad,
                "ID"=>$id
            ];

            if(especialidadModelo::actualizar_especialidad_modelo($datos_especialidad_up)){
                $alerta = [
                    "Alerta"=>"recargar",
                    "Titulo"=>"Especialidad Actualizada",
                    "Texto"=>"Los datos de la especialidad han sido actualizados con éxito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No ha sido posible actualizar la especialidad, intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            exit();
        }/**----------Fin del Controlador---------- */
    }

?>