<?php 
    if($peticionAjax){
        require_once "../modelos/expedienteModelo.php";
    }else{
        require_once "./modelos/expedienteModelo.php";
    }

    class expedienteControlador extends expedienteModelo{
        /**----------Paginador de Expedientes Controlador---------- */
        public function paginador_expediente_controlador($pagina, $registros, $privilegio, $id, $url, $busqueda, $cliente){
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

            $cliente = mainModel::decryption($cliente);

            if ($busqueda != "") {
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS *, clientes.apellido_p_cliente, clientes.apellido_m_cliente,servicios.nombre_servicio, estatus.estatus
                FROM reservaciones
                INNER JOIN clientes ON reservaciones.id_cliente = clientes.id_cliente
                INNER JOIN servicios ON reservaciones.id_servicio = servicios.id_servicio
                INNER JOIN estatus ON reservaciones.id_estatus = estatus.id_estatus
                WHERE reservaciones.id_doctor = $id AND reservaciones.id_cliente = $cliente
                ORDER BY reservaciones.id_reservacion ASC LIMIT $inicio, $registros";
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
                            <th>Nombre (s)</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Servicio</th>
                            <th>Esttaus</th>';
                            if($privilegio==1 || $privilegio==4){
                                $tabla.='<th>Consultar<th>';
                            }
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
                            <td>'. $rows['nombre_cliente'] .'</td>
                            <td>'. $rows['apellido_p_cliente'] .'</td>
                            <td>'. $rows['apellido_m_cliente'] .'</td>
                            <td>'. $rows['nombre_servicio'] .'</td>
                            <td>'. $rows['estatus'] .'</td>';
                            if($privilegio== 1 || $privilegio==4){
                                $tabla.='<td>
                                    <a class="btn btn-raised btn-primary" href="'.SERVERURL.'reservation/'.mainModel::encryption($rows['id_reservacion']).'">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                <td>';
                            }
                            if($privilegio==1 || $privilegio==2){
                                $tabla.='<td>
                                    <a href="'.SERVERURL.'client-update/'.mainModel::encryption($rows['id_cliente']).'/" class="btn btn-success" title="Actualizar la información del cliente">
                                        <i class="fas fa-sync-alt"></i>	
                                    </a>
                                </td>';
                            }
                            if($privilegio==1){
                                $tabla.='<td>
                                    <form class="FormularioAjax" action="'.SERVERURL.'ajax/clienteAjax.php"  method="POST" data-form="delete" autocomplete="off">
                                        <input type="hidden" name="cliente_id_del" value="'.mainModel::encryption($rows['id_cliente']).'">                                
                                        <button type="submit" class="btn btn-warning" title="Eliminar al cliente del sistema">
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
                $tabla .= '<p class="text-right">Mostrando Clientes '. $reg_inicio .' al '. $reg_final .' de un total de '. $total .'</p>';
                $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
            }

            return $tabla;
        }
    }

?>