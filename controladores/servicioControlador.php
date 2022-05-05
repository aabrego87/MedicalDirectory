<?php
    if($peticionAjax){
        require_once "../modelos/servicioModelo.php";
    }else{
        require_once "./modelos/servicioModelo.php";
    }

    class servicioControlador extends servicioModelo{
        /**----------Agregar Servicio Controlador---------- */
        public function agregar_servicio_controlador(){
            /**----------Recibiendo Datos del Formulario---------- */
            $nombre = mainModel::limpiar_cadena($_POST['servicio_nombre_reg']);
            $descripcion = mainModel::limpiar_cadena($_POST['servicio_descripcion_reg']);
            $precio = mainModel::limpiar_cadena($_POST['servicio_precio_reg']);
            $imagen = $_FILES['servicio_imagen_reg']['name'];
            $especialidad = mainModel::limpiar_cadena($_POST['servicio_especialidad_reg']);

            /**----------Comprobando Campos Vacios---------- */
            if($nombre == "" || $descripcion == "" || $precio == "" || $especialidad == ""){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No ha llenado todos los datos obligatorios",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Verificando Integridad de los Datos---------- */
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ1-9-. ]{3,500}", $nombre)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El NOMBRE del servicio no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9., ]{3,500}", $descripcion)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"La DESCRIPCIÓN del servicio no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[0-9. ]{1,35}", $precio)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El PRECIO del servicio no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Comprobando Datos y en DB---------- */
            /**----------Comprobando Privilegio---------- */
            session_start(['name' => 'MDIRECTORY']);
            if($_SESSION['privilegio_mdirectory'] != 1 && $_SESSION['privilegio_mdirectory'] != 4){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"No cuentas con los permisos necesarios para realizar esta operación",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit(); 
            }

            //Doctor
            if(isset($_POST['servicio_doctor_reg'])){ //Si se manda el doctor (Registro de Admin)
                $doctor = mainModel::limpiar_cadena($_POST['servicio_doctor_reg']);
                $check_doctor = mainModel::ejecutar_consulta_simple("SELECT *  FROM doctores WHERE id_doctor = $doctor");
                if($check_doctor->rowCount() <= 0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inesperado",
                        "Texto"=>"No cuentas con los permisos necesarios para realizar esta operación",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit(); 
                }
            }else{//Si la sesion es de un doctor
                $doctor = $_SESSION['id_mdirectory'];
            }

            //Especialidad
            $check_especialidad = mainModel::ejecutar_consulta_simple("SELECT id_especialidad FROM especialidades WHERE id_especialidad = $especialidad");
            if($check_especialidad->rowCount() <= 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación",
                    "Texto"=>"La ESPECIALIDAD seleccionada no es válida",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit(); 
            }

            //Imagen
            if(!empty($_FILES)){ //Si no estan vacios los archivos
                if (mainModel::validar_imagen($_FILES['servicio_imagen_reg']['tmp_name'])) { // Comprueba si es una imagen valida
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede realizar esta operación",
                        "Texto"=>"La IMAGEN seleccionada no tiene un formato válido",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit(); 
                } else {
                    $destino = "../vistas/assets/servicios/";
                    $file_upload = $destino . $_FILES['servicio_imagen_reg']['name'];
                    move_uploaded_file($_FILES['servicio_imagen_reg']['tmp_name'], $file_upload); // Sube el archivo a la carpeta

                    $datos_servicio_reg = [ //Datos si no se tiene Imagen del Servicio
                        "Nombre"=>$nombre,
                        "Descripcion"=>$descripcion,
                        "Precio"=>$precio,
                        "Imagen"=>$imagen,
                        "Doctor"=>$doctor,
                        "Especialidad"=>$especialidad
                    ];
                }
            }else{
                $datos_servicio_reg = [ //Datos si no se tiene Imagen del Servicio
                    "Nombre"=>$nombre,
                    "Descripcion"=>$descripcion,
                    "Precio"=>$precio,
                    "Doctor"=>$doctor,
                    "Especialidad"=>$especialidad
                ];
            }

            $agregar_servicio = servicioModelo::agregar_servicio_modelo($datos_servicio_reg);
            if($agregar_servicio->rowCount() == 1){
                $alerta=[
                    "Alerta"=>"limpiar",
                    "Titulo"=>"Servicio Registrado",
                    "Texto"=>"Los datos han sido agregados con éxito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"No ha sido posible agregar el SERVICIO, intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            exit(); 

        }/**----------Fin del Controlador---------- */

        /**----------Paginador Doctores Controlador---------- */
        public function paginador_servicios_controlador($pagina, $registros, $privilegio, $id, $url, $busqueda){
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

            if($privilegio == 4){ // Si es Doctor
                if ($busqueda != "") {
                }else{
                    $consulta = "SELECT SQL_CALC_FOUND_ROWS *, servicios.descripcion, servicios.imagen, doctores.nombre_doctor, especialidades.especialidad
                    FROM servicios
                    INNER JOIN especialidades ON especialidades.id_especialidad = servicios.id_especialidad
                    INNER JOIN doctores ON doctores.id_doctor = servicios.id_doctor
                    WHERE servicios.id_doctor = $id
                    ORDER BY id_servicio ASC LIMIT $inicio, $registros";
                }
            }else{
                if ($busqueda != "") {
                }else{
                    $consulta = "SELECT SQL_CALC_FOUND_ROWS *, servicios.descripcion, servicios.imagen, doctores.nombre_doctor, especialidades.especialidad
                    FROM servicios
                    INNER JOIN especialidades ON especialidades.id_especialidad = servicios.id_especialidad
                    INNER JOIN doctores ON doctores.id_doctor = servicios.id_doctor
                    ORDER BY id_servicio ASC LIMIT $inicio, $registros";
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
                        <tr class="text-left roboto-medium">
                            <th></th>
                            <th>Información Del Servicio</th>
                            <th>Doctor</th>
                            <th>Especialidad</th>
                            <th>RESERVAR</yh>';
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
                            <td>
                                <img src="'. SERVERURL. 'vistas/assets/servicios/' . $rows['imagen'] .'" width="150px">
                            </td>
                            <td>Nombre del Servicio: '. $rows['nombre_servicio'] .'<br/>
                                Descripcion: '. $rows['descripcion'] .'<br/>
                                Precio: $'. $rows['precio'] .'
                            </td>
                            <td>
                                <a href="'.SERVERURL.'doctors-profile/'.mainModel::encryption($rows['id_doctor']).'" title="Visitar el perfil del Doctor">'.
                                    $rows['nombre_doctor']
                                .'</a>
                            </td>
                            <td>
                                <a href="'. SERVERURL .'service-list/'. mainModel::encryption($rows['id_especialidad']) .'">
                                    '. $rows['especialidad'] .'
                                </a>
                            </td>
                            <td>
                                <a href="'. SERVERURL .'reservation-new/'.mainModel::encryption($rows['id_servicio']).'/'.mainModel::encryption($rows['id_doctor']).'">
                                    <i class="fa fa-sync-alt"></i>
                                </a>
                            </td>';
                            if($privilegio==1 || $privilegio==2 || $privilegio==4){
                                $tabla.='<td>
                                    <a href="'.SERVERURL.'service-update/'.mainModel::encryption($rows['id_servicio']).'/" class="btn btn-success">
                                        <i class="fas fa-sync-alt"></i>	
                                    </a>
                                </td>';
                            }
                            if($privilegio==1 || $privilegio == 4){
                                $tabla.='<td>
                                    <form class="FormularioAjax" action="'.SERVERURL.'ajax/servicioAjax.php"  method="POST" data-form="delete" autocomplete="off">
                                        <input type="hidden" name="servicio_id_del" value="'.mainModel::encryption($rows['id_servicio']).'">                                
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
                $tabla .= '<p class="text-right">Mostrando Servicios '. $reg_inicio .' al '. $reg_final .' de un total de '. $total .'</p>';
                $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
            }

            return $tabla;
        }/**----------Fin del Controlador---------- */

        /**----------Datos Servicio Controlador---------- */
        public function datos_servicio_controlador($tipo, $id){
            /**----------Recibiendo y Desencriptando ID---------- */
            $id = mainModel::decryption($id);
            $id = mainModel::limpiar_cadena($id);

            $tipo = mainModel::limpiar_cadena($tipo);

            return servicioModelo::datos_servicio_modelo($tipo, $id);
        }/**----------Fin del Controlador---------- */

        /**----------Eliminar Servicio Controlador---------- */
        public function eliminar_servicio_controlador(){
            /**----------Recibiendo y Desencriptando ID---------- */
            $id = mainModel::decryption($_POST['servicio_id_del']);
            $id = mainModel::limpiar_cadena($id);

            /**----------Comprobando Campos y en DB---------- */
            $check_servicio = mainModel::ejecutar_consulta_simple("SELECT id_servicio FROM servicios WHERE id_servicio = $id");
            if($check_servicio->rowCount() <= 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"El USUARIO que desea ELIMINAR no se encuentra en la base de datos",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Comprobando Privilegios---------- */
            session_start(['name' => 'MDIRECTORY']);
            if($_SESSION['privilegio_mdirectory'] != 1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"No cuentas con los permisos necesarios para realizar esta operación",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            $eliminar_servicio = servicioModelo::eliminar_servicio_modelo($id);

            if($eliminar_servicio->rowCount() == 1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Servicio Eliminado",
                    "Texto"=>"El SERVICIO ha sido eliminado con éxito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"No ha sido posible eliminar el servicio, intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            exit();
        }/**----------Fin del Controlador---------- */

        /**----------Actualizar Servicio Controlador---------- */
        public function actualizar_servicio_controlador(){
            /**----------Recibiendo y Desencriptando ID---------- */
            $id = mainModel::decryption($_POST['servicio_id_up']);
            $id = mainModel::limpiar_cadena($id);

            /**----------Comprobando Servicio en DB---------- */
            $check_servicio = mainModel::ejecutar_consulta_simple("SELECT id_servicio FROM servicios WHERE id_servicio = $id");
            if($check_servicio->rowCount() <= 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"El SERVICIO que desea actualizar no se encuentra en la base de datos",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos = $check_servicio->fetch();
            }

            /**----------Reciiendo Datos de Formulario---------- */
            $nombre = mainModel::limpiar_cadena($_POST['servicio_nombre_up']);
            $descripcion = mainModel::limpiar_cadena($_POST['servicio_descripcion_up']);
            $precio = mainModel::limpiar_cadena($_POST['servicio_precio_up']);
            $especialidad = mainModel::limpiar_cadena($_POST['servicio_especialidad_up']);

            /**---------Comprobando Campos Vacios---------- */
            if($nombre == "" || $descripcion == "" || $precio == "" || $especialidad == ""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"No ha llenado todos los campos obligatorios",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Verificnado la Integridad de los Datos---------- */
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ1-9-., ]{3,500}", $nombre)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"El NOMBRE del servicio no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9-., ]{3,500}", $descripcion)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"La DESCRIPCIÓN del servicio no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[0-9. ]{1,35}", $precio)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"El PRECIO del servicio no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Comprobando campos y en BBDD---------- */
            $check_especialidad = mainModel::ejecutar_consulta_simple("SELECT id_especialidad FROM especialidades WHERE id_especialidad = $especialidad");
            if($check_especialidad->rowCount() <= 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"La ESPECIALIDAD seleccionada no es válida",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**-----Datos para Actualizar----- */
            $datos_servicio_up = [
                "Nombre"=>$nombre,
                "Descripcion"=>$descripcion,
                "Precio"=>$precio,
                "Especialidad"=>$especialidad,
                "ID"=>$id
            ];

            if(servicioModelo::actualizar_servicio_modelo($datos_servicio_up)){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Datos Actualizados",
                    "Texto"=>"Los datos han sido actualizados con éxito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación",
                    "Texto"=>"No ha sido posible actualizar los datos, intente nuevamente",
                    "Tipo"=>"warning"
                ];
            }
            echo json_encode($alerta);
            exit();
        }/**----------Fin del Controlador---------- */

        /**----------Paginador Servicios de Doctor Controlador---------- */
        public function paginador_servicios_doctor_controlador($pagina, $registros, $privilegio, $id, $url, $busqueda, $doctor){
            /**----------Desencriptando al Doctor---------- */
            $doctor = mainModel::decryption($doctor);
            $doctor = mainModel::limpiar_cadena($doctor);

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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS *, servicios.descripcion, servicios.imagen, doctores.nombre_doctor
                FROM servicios
                INNER JOIN doctores ON doctores.id_doctor = servicios.id_doctor
                WHERE servicios.id_doctor = $doctor
                ORDER BY id_servicio ASC LIMIT $inicio, $registros";
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
                            <th>Información Del Servicio</th>
                            <th>Doctor</th>
                            <th>RESERVAR</th>';
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
                            <td>
                                <img src="'. SERVERURL. 'vistas/assets/servicios/' . $rows['imagen'] .'" width="150px">
                            </td>
                            <td>Nombre del Servicio: '. $rows['nombre_servicio'] .'<br/>
                                Descripcion: '. $rows['descripcion'] .'<br/>
                                Precio: $'. $rows['precio'] .'
                            </td>
                            <td>
                                <a href="'.SERVERURL.'doctors-profile/'.mainModel::encryption($rows['id_doctor']).'" title="Visitar el perfil del Doctor">'.
                                    $rows['nombre_doctor']
                                .'</a>
                            </td>
                            <td>
                                <a href="'. SERVERURL .'reservation-new/'.mainModel::encryption($rows['id_servicio']).'/'.mainModel::encryption($rows['id_doctor']).'">
                                    <i class="fa fa-sync-alt"></i>
                                </a>
                            </td>';
                            if($privilegio==1 || $privilegio==2 || $privilegio==4){
                                $tabla.='<td>
                                    <a href="'.SERVERURL.'service-update/'.mainModel::encryption($rows['id_servicio']).'/" class="btn btn-success">
                                        <i class="fas fa-sync-alt"></i>	
                                    </a>
                                </td>';
                            }
                            if($privilegio==1 || $privilegio == 4){
                                $tabla.='<td>
                                    <form class="FormularioAjax" action="'.SERVERURL.'ajax/servicioAjax.php"  method="POST" data-form="delete" autocomplete="off">
                                        <input type="hidden" name="servicio_id_del" value="'.mainModel::encryption($rows['id_servicio']).'">                                
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
                $tabla .= '<p class="text-right">Mostrando Servicios '. $reg_inicio .' al '. $reg_final .' de un total de '. $total .'</p>';
                $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
            }

            return $tabla;
        }/**----------Fin del Controlador---------- */
    }

?>