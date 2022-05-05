<?php 
    if($peticionAjax){
        require_once "../modelos/menusModelo.php";
    }else{
        require_once "./modelos/menusModelo.php";
    }

    class menuControlador extends menusModelo{
        /**----------Agregar Menu Controlador---------- */
        public function agregar_menu_controlador(){
            /**----------Recibiendo Datos de Formulario---------- */
            $nombre = mainModel::limpiar_cadena($_POST['menu_nombre_reg']);
            $icono = mainModel::limpiar_cadena($_POST['menu_icono_reg']);
            $ruta = mainModel::limpiar_cadena($_POST['menu_ruta_reg']);
            $activo = mainModel::limpiar_cadena($_POST['menu_activo_reg']);
            $padre = mainModel::limpiar_cadena($_POST['menu_padre_reg']);

            /**---------Comprobando Campos Vacios---------- */
            if($nombre == "" || $icono == "" || $ruta == "" || $activo == "" || $padre == ""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"No ha llenado todos los datos obligatorios",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**------------Verificando la INtegridad de los Datos---------- */
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\-., ]{1,40}", $nombre)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"El NOMBRE no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\-., ]{1,40}", $icono)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"EL ÍCONO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if($activo < 0 && $activo > 1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"El estado del menú no es válido",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Comprobando Campos en DDBB---------- */
            $check_padre = mainModel::ejecutar_consulta_simple("SELECT id_menu FROM menu WHERE id_menu = $padre");
            if($check_padre->rowCount() <= 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"El MENÚ PADRE seleccionado no se encuentra en el sistema",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            //Datos para registrar
            $datos_menu_reg = [
                "Nombre"=>$nombre,
                "Icono"=>$icono,
                "Ruta"=>$ruta,
                "Activo"=>$activo,
                "Padre"=>$padre
            ];

            $agregar_menu = menusModelo::agregar_menu_modelo($datos_menu_reg);
            
            if($agregar_menu->rowCount() == 1){
                $alerta=[
                    "Alerta"=>"limpiar",
                    "Titulo"=>"Registro Exitoso",
                    "Texto"=>"Lo datos del MENÚ han sido guardados en el sistema",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"No ha sido posible registrar al menú, por favor, intente nuevamente",
                    "Tipo"=>"warning"
                ];
            }
            echo json_encode($alerta);
            exit();
        }/**----------Fin del Controlador---------- */

        /**----------Paginador Menus Controlador---------- */
        public function paginador_menus_controlador($pagina, $registros, $privilegio, $id, $url, $busqueda){
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM menu ORDER BY id_menu ASC LIMIT $inicio, $registros";
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
                        <tr class="text-left roboto-medium">
                            <th>#</th>
                            <th>Menú</th>
                            <th>ícono</th>
                            <th>Ruta</th>';
                            if($privilegio==1 || $privilegio==2 || $privilegio==4){
                                $tabla.='<th>ACTUALIZAR</th>';
                            }
                            if($privilegio==1 || $privilegio == 4){
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
                        <tr class="text-left" >
                            <td>'. $contador .'</td>
                            <td>'. $rows['nom_menu'] .'</td>
                            <td><i class="'. $rows['icon_menu'] .'"></i></td>
                            <td>'. $rows['ruta_menu'] .'</td>';
                            if($privilegio==1 || $privilegio==2 || $privilegio==4){
                                $tabla.='<td>
                                    <a href="'.SERVERURL.'menu-update/'.mainModel::encryption($rows['id_menu']).'/" class="btn btn-success">
                                        <i class="fas fa-sync-alt"></i>	
                                    </a>
                                </td>';
                            }
                            if($privilegio==1 || $privilegio == 4){
                                $tabla.='<td>
                                    <form class="FormularioAjax" action="'.SERVERURL.'ajax/menuAjax.php"  method="POST" data-form="delete" autocomplete="off">
                                        <input type="hidden" name="menu_id_del" value="'.mainModel::encryption($rows['id_menu']).'">                                
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
                $tabla .= '<p class="text-right">Mostrando Menus '. $reg_inicio .' al '. $reg_final .' de un total de '. $total .'</p>';
                $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
            }

            return $tabla;
        }/**----------Fin del Controlador---------- */

        /**----------Datos Menu Controlador */
        public function datos_menu_controlador($tipo, $id){
            /**----------Recibiendo Y Desencriptando ID---------- */
            $id = mainModel::decryption($id);
            $id = mainModel::limpiar_cadena($id);

            $tipo = mainModel::limpiar_cadena($tipo);

            return menusModelo::datos_menu_modelo($tipo, $id);
        }/**----------Fin del Controlador----------- */

        /**----------Actualizar Menu Controlador */
        public function actualizar_menu_controlador(){
            /**----------Recibiendo y Desencriptando ID---------- */
            $id = mainModel::decryption($_POST['menu_id_up']);
            $id = mainModel::limpiar_cadena($id);

            /**------------Comprobando Menu en DDBB----------- */
            $check_menu = mainModel::ejecutar_consulta_simple("SELECT id_menu FROM menu WHERE id_menu = $id");
            if($check_menu->rowCount() <= 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"El MENÚ que desea actualizar no se encuentra en el sistema",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Recibiendo Datos del Formulario----------- */
            $nombre = mainModel::limpiar_cadena($_POST['menu_nombre_up']);
            $icono = mainModel::limpiar_cadena($_POST['menu_icono_up']);
            $ruta = mainModel::limpiar_cadena($_POST['menu_ruta_up']);
            $activo = mainModel::limpiar_cadena($_POST['menu_activo_up']);
            $padre = mainModel::limpiar_cadena($_POST['menu_padre_up']);

            /**----------Comprobando Campos Vacios---------- */
            if($nombre == "" || $icono == "" || $ruta == "" || $activo == "" || $padre == ""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"No ha llenado todos los datos obligatorios",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Verificando la Integridad de los Datos---------- */
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\-., ]{1,40}", $nombre)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"El NOMBRE del menú no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\-., ]{1,40}", $icono)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"El ICONO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if($activo < 0 && $activo > 1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"El estado del menú no es válido",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Comprobando campos y en DDBB---------- */
            $check_padre = mainModel::ejecutar_consulta_simple("SELECT id_menu FROM menu WHERE id_menu = $padre");
            if($check_padre->rowCount() <= 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"El MENÚ PADRE seleccionado no se encuentra en el sistema",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            $datos_menu_up = [
                "Nombre"=>$nombre,
                "Icono"=>$icono,
                "Ruta"=>$ruta,
                "Activo"=>$activo,
                "Padre"=>$padre,
                "ID"=>$id
            ];

            if(menusModelo::actualizar_menu_modelo($datos_menu_up)){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Datos Actualizados",
                    "Texto"=>"Los datos del Menú han sido actualizados con éxito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"No ha sido posible actualizar el menú, intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            exit();

        }/**-----------Fin del Controlador---------- */

        /**-----------Eliminar Menu Controlador---------- */
        public function eliminar_menu_controlador(){
            /**----------Recibiendo y Desencriptando ID---------- */
            $id = mainModel::decryption($_POST['menu_id_del']);
            $id = mainModel::limpiar_cadena($id);

            /**----------Comprobando Menú en DDBB---------- */
            $check_menu = mainModel::ejecutar_consulta_simple("SELECT id_menu FROM menu WHERE id_menu = $id");
            if($check_menu->rowCount() <= 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"El MENÚ que desea eliminar no se encuentra en el sistema",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Comprobando Privilegios para Eliminar---------- */
            session_start(['name' => 'MDIRECTORY']);
            if($_SESSION['privilegio_mdirectory'] != 1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"No cuentas con los permisos necesarios para eliminar el menú",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $eliminar_menu = menusModelo::eliminar_menu_modelo($id);
            if($eliminar_menu->rowCount() == 1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Menú Eliminado",
                    "Texto"=>"El MENÚ ha sido eliminado correctamente del sistema",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación solicitada",
                    "Texto"=>"No ha sido posible eliminar el menú, intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            exit();
        }
    }
?>