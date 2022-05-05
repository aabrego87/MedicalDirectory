<?php  

    if($peticionAjax){
        require_once "../modelos/usuarioModelo.php";
    }else{
        require_once "./modelos/usuarioModelo.php";
    }

    class usuarioControlador extends usuarioModelo{
        /*--------------Controlador Agregar Usuario---------------------*/
        public function agregar_usuario_controlador(){
            $nombre=mainModel::limpiar_cadena($_POST['usuario_nombre_reg']);
            $apellidop=mainModel::limpiar_cadena($_POST['usuario_apellido_p_reg']);
            $apellidom=mainModel::limpiar_cadena($_POST['usuario_apellido_m_reg']);
            $telefono=mainModel::limpiar_cadena($_POST['usuario_telefono_reg']);
            $direccion=mainModel::limpiar_cadena($_POST['usuario_direccion_reg']);

            $usuario=mainModel::limpiar_cadena($_POST['usuario_usuario_reg']);
            $email=mainModel::limpiar_cadena($_POST['usuario_email_reg']);
            $clave1=mainModel::limpiar_cadena($_POST['usuario_clave_1_reg']);
            $clave2=mainModel::limpiar_cadena($_POST['usuario_clave_2_reg']);
            
            $privilegio=mainModel::limpiar_cadena($_POST['usuario_privilegio_reg']);
            $foto=$_FILES['usuario_imagen_reg']['name'];

            /*== Comprobar Campos Vacios ==*/

            if($nombre=="" || $apellidop=="" || $apellidom=="" || $usuario=="" || $email=="" || $clave1=="" || $clave2=="")
            {
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un Error Inesperado",
                    "Texto"=>"No ha llenado todos los datos obligatorios",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            // Verificar la integridad de los datos

            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $nombre)) {
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"El NOMBRE no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $apellidop)) {
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"El APELLIDO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $apellidom)) {
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"El APELLIDO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if ($telefono != "") {
                if (mainModel::verificar_datos("[0-9()+]{8,20}", $telefono)) {
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inesperado",
                        "Texto"=>"El TELÉFONO no coincide con el formato solicitado",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if ($direccion != "") {
                if (mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $direccion)) {
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inesperado",
                        "Texto"=>"La DIRECCIÓN no coincide con el formato solicitado",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if (mainModel::verificar_datos("[a-zA-Z0-9]{1,35}", $usuario)) {
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"El NOMBRE DE USUARIO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit(); 
            }

            if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave1) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave2)) {
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"Las CONTRASEÑAS no coinciden con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit(); 
            }     

            // else{
            //     echo "Aqui Ejecuta el SI funciono";
            // }

            /*--------------Comprobando Usuario---------------------*/
            $check_user = mainModel::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuarios WHERE usuario_usuario ='$usuario'");
            if ($check_user->rowCount()>0) {
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"El NOMBRE DE USUARIO ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit(); 
            }
            
            /*--------------Comprobando Email---------------------*/
            if ($email != "") {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $check_email=mainmodel::ejecutar_consulta_simple("SELECT usuario_email FROM usuarios WHERE usuario_email ='$email'");
                    if($check_email->rowCount()>0) {
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un Error Inesperado",
                            "Texto"=>"El EMAIL ingresado ya se encuentra registrado en el sistema",
                            "Tipo"=>"warning"
                        ];
                        echo json_encode($alerta);
                        exit(); 
                    }
                } else {
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inesperado",
                        "Texto"=>"El correo ingresado no es válido",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit(); 
                }
            }

            /*--------------Comprobando Claves---------------------*/
            if($clave1 != $clave2) {
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"Las claves ingresadas no coinciden",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit(); 
            } else {
                $clave = mainModel::encryption($clave1);
            }

            /*--------------Comprobando Privilegio---------------------*/
            if ($privilegio<1 || $privilegio>3) {
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"El privilegio seleccionado no es válido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit(); 
            }
            
            /*--------------Comprobando Imagen---------------------*/
            if(!empty($_FILES)){ //Si no estan vacios los archivos
                if (mainModel::validar_imagen($_FILES['usuario_imagen_reg']['tmp_name'])) { // Comprueba si es una imagen valida
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inesperado",
                        "Texto"=>"La IMAGEN seleccionada no tiene un formato válido",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit(); 
                } else {
                    $destino = "../vistas/assets/avatar/";
                    $file_upload = $destino . $_FILES['usuario_imagen_reg']['name'];
                    move_uploaded_file($_FILES['usuario_imagen_reg']['tmp_name'], $file_upload); // Sube el archivo a la carpeta
                }
            }

            $datos_usuario_reg = [ // Arreglo que contiene los datos para insertar
                "Nombre"=>$nombre,
                "ApellidoP"=>$apellidop,
                "ApellidoM"=>$apellidom,
                "Telefono"=>$telefono,
                "Direccion"=>$direccion,
                "Email"=>$email,
                "Usuario"=>$usuario,
                "Clave"=>$clave,
                "Estado"=>"Activa", //Se crea la cuenta y el estado por defecto es activa
                "Privilegio"=>$privilegio,
                "Imagen"=>$foto
            ];

            $agregar_usuario = usuarioModelo::agregar_usuario_modelo($datos_usuario_reg);

            if ($agregar_usuario->rowCount()==1) {
                $alerta=[
                    "Alerta"=>"limpiar",
                    "Titulo"=>"Usuario Registrado",
                    "Texto"=>"Los datos han sido registrados con éxito",
                    "Tipo"=>"success"
                ];
            } else {
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"No ha sido posible registrar el usuario",
                    "Tipo"=>"error"
                ];
            }

            echo json_encode($alerta);

        } /* Fin Controlador */

        /**-------------Controlador Paginador de Uusarios--------------- */
        public function paginador_usuarios_controlador($pagina, $registros, $privilegio, $id, $url, $busqueda){
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
                FROM usuarios 
                WHERE id_usuario != 1
                ORDER BY id_usuario ASC LIMIT $inicio, $registros";
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
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Telefono</th>
                            <th>Dirección</th>
                            <th>Email</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Privilegio</th>';
                            if($privilegio==1 || $privilegio==2){
                                $tabla.='<th>Actualizar</th>';
                            }
                            if($privilegio==1){
                                $tabla.='<th>Eliminar</th>';
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
                            <td>'. $rows['usuario_nombre'] .'</td>
                            <td>'. $rows['usuario_apellido_p'] .'</td>
                            <td>'. $rows['usuario_apellido_m'] .'</td>
                            <td>'. $rows['usuario_telefono'] .'</td>
                            <td>'. $rows['usuario_direccion'] .'</td>
                            <td>'. $rows['usuario_email'] .'</td>
                            <td>'. $rows['usuario_usuario'] .'</td>
                            <td>'. $rows['usuario_estado'] .'</td>
                            <td>'. $rows['usuario_privilegio'] .'</td>';
                            if($privilegio==1 || $privilegio==2){
                                $tabla.='<td>
                                    <a href="'.SERVERURL.'user-update/'.mainModel::encryption($rows['id_usuario']).'/" class="btn btn-success">
                                        <i class="fas fa-sync-alt"></i>	
                                    </a>
                                </td>';
                            }
                            if($privilegio==1){
                                $tabla.='<td>
                                    <form class="FormularioAjax" action="'.SERVERURL.'ajax/usuarioAjax.php"  method="POST" data-form="delete" autocomplete="off">
                                        <input type="hidden" name="usuario_id_del" value="'.mainModel::encryption($rows['id_usuario']).'">                                
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
                $tabla .= '<p class="text-right">Mostrando Usuarios '. $reg_inicio .' al '. $reg_final .' de un total de '. $total .'</p>';
                $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
            }

            return $tabla;
        }/**----------Fin de Controlador----------- */

        /**----------Controlador Datos de Usuario--------- */
        public function datos_usuario_conrolador($tipo, $id){
            /**----------Recibiendo Datos---------- */
            $tipo = mainModel::limpiar_cadena($tipo);

            $id = mainModel::decryption($id);
            $id = mainModel::limpiar_cadena($id);

            return usuarioModelo::datos_usuario_modelo($tipo, $id);
        }/**---------Fin del Controlador---------- */

        /**---------Controlador Actualizar Usuario---------- */
        public function actualizar_usuario_controlador(){
            /**----------Recibiendo Y Desencriptando ID--------- */
            $id = mainModel::decryption($_POST['usuario_id_up']);
            $id = mainModel::limpiar_cadena($id);

            /**----------Comprobando Usuario en DB---------- */
            $check_usuario = mainModel::ejecutar_consulta_simple("SELECT * FROM usuarios WHERE id_usuario = '$id'");
            if($check_usuario->rowCount() <= 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"El USUARIO que desea actualizar no se encuentra en la base de datos",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos = $check_usuario->fetch();
            }

            /**----------Recibiendo Datos del Formulario---------- */
            $nombre = mainModel::limpiar_cadena($_POST['usuario_nombre_up']);
            $apellidop = mainModel::limpiar_cadena($_POST['usuario_apellido_p_up']);
            $apellidom = mainModel::limpiar_cadena($_POST['usuario_apellido_m_up']);
            $telefono = mainModel::limpiar_cadena($_POST['usuario_telefono_up']);
            $direccion = mainModel::limpiar_cadena($_POST['usuario_direccion_up']);

            $usuario = mainModel::limpiar_cadena($_POST['usuario_usuario_up']);
            $email = mainModel::limpiar_cadena($_POST['usuario_email_up']);

            /**---------Comprobando Estado--------- */
            if(isset($_POST['usuario_estado_up'])){
                $estado = mainModel::limpiar_cadena($_POST['usuario_estado_up']);
            }else{
                $estado = $campos['usuario_estado'];
            }

            /**---------Comprobanod Privilegio---------- */
            if(isset($_POST['usuario_privilegio_up'])){
                $privilegio = mainModel::limpiar_cadena($_POST['usuario_privilegio_up']);
            }else{
                $privilegio = $campos['usuario_privilegio'];
            }

            $usuario_admin = mainModel::limpiar_cadena($_POST['usuario_admin']);
            $clave_admin = mainModel::limpiar_cadena($_POST['clave_admin']);

            $tipo_cuenta = mainModel::limpiar_cadena($_POST['tipo_cuenta']);

            /**----------Verificando Integridad de los Datos---------- */
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $nombre)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación",
                    "Texto"=>"El NOMBRE ingresado no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $apellidop)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación",
                    "Texto"=>"El APELLIDO PATERNO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $apellidom)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación",
                    "Texto"=>"El APELLIDO MATERNO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[0-9()+]{8,20}", $telefono)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación",
                    "Texto"=>"El TELÉFONO ingresado no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9]{1,35}", $usuario)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación",
                    "Texto"=>"El USUARIO ingresado no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9]{1,35}", $usuario_admin)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación",
                    "Texto"=>"El USUARIO DEL ADMINISTRADOR no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_admin)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación",
                    "Texto"=>"La CONTRASEÑA DEL ADMINISTRADOR no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            //Encriptando clave de Admin para comprobar en DB
            $clave_admin = mainModel::encryption($clave_admin);

            if($privilegio < 1 || $privilegio > 3){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación",
                    "Texto"=>"El PRIVILEGIO seleccionado no es válido",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if($estado != 'Activa' && $estado != 'Deshabilitada'){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación",
                    "Texto"=>"El ESTADO de la cuenta no es un estado válido",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Comprobando Datos y En DB---------- */
            //Usuario
            if($usuario != $campos['usuario_usuario']){
                $check_user = mainModel::ejecutar_consulta_simple("SELECT usuario FROM usuarios WHERE usuario_usuario = $usuario");
                if($check_user->rowCount() == 1){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede realizar la operación",
                        "Texto"=>"El USUARIO ingresado ya se encuentra registrado",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            //Email
            if($email != $campos['usuario_email'] && $email != ""){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $check_email = mainModel::ejecutar_consulta_simple("SELECT usuario_email FROM usuarios WHERE usuario_email = '$email'");
                    if($check_email->rowCount() > 0){
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"No se puede realizar la operación",
                            "Texto"=>"El EMAIL ingresado ya se encuentra registrado",
                            "Tipo"=>"warning"
                        ];
                        echo json_encode($alerta);
                        exit();
                    }
                }else{
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede realizar la operación",
                        "Texto"=>"El EMAIL ingresado no es válido",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }

            }

            //Contraseñas
            if($_POST['usuario_clave_nueva_1'] != "" || $_POST['usuario_clave_nueva_2'] != ""){
                if($_POST['usuario_clave_nueva_1'] != $_POST['usuario_clave_nueva_2']){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede realizar la operación",
                        "Texto"=>"Las NUEVAS CONTRASEÑAS no coinciden",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }else{
                    if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $_POST['usuario_clave_nueva_1']) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $_POST['usuario_clave_nueva_2'])){
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"No se puede realizar la operación",
                            "Texto"=>"Las NUEVAS CONTRASEÑAS no coinciden con el formato solicitado",
                            "Tipo"=>"warning"
                        ];
                        echo json_encode($alerta);
                        exit();
                    }
                    $clave = mainModel::encryption($_POST['usuario_clave_nueva_1']);
                }
            }else{
                $clave = $campos['usuario_clave'];
            }

            /**----------Comprobando Credenciales Para Actualizar---------- */
            if($tipo_cuenta == "Propia"){
                $check_cuenta = mainModel::ejecutar_consulta_simple("SELECT id_usuario FROM usuarios WHERE usuario_usuario = '$usuario_admin' && usuario_clave = '$clave_admin' && id_usuario = $id");
            }else{
                session_start(['name' => 'MDIRECTORY']);
                if($_SESSION['privilegio_mdirectory'] != 1){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede realizar la operación",
                        "Texto"=>"No cuentas con los permisos necesarios para realizar esta operación",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $check_cuenta = mainModel::ejecutar_consulta_simple("SELECT id_usuario FROM usuarios WHERE usuario_usuario = '$usuario_admin' AND usuario_clave = '$clave_admin'");
            }

            if($check_cuenta->rowCount() <= 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar la operación",
                    "Texto"=>"El NOMBRE y CLAVE del administrador no son correctas",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**-----Datos Para Actualizar----- */
            $datos_usuario_up = [
                "Nombre"=>$nombre,
                "ApellidoP"=>$apellidop,
                "ApellidoM"=>$apellidom,
                "Telefono"=>$telefono,
                "Direccion"=>$direccion,
                "Email"=>$email,
                "Usuario"=>$usuario,
                "Clave"=>$clave,
                "Estado"=>$estado,
                "Privilegio"=>$privilegio,
                "ID"=>$id
            ];

            if(usuarioModelo::actualizar_usuario_modelo($datos_usuario_up)){
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

        /**----------Eliminar Usuario Controlador---------- */
        public function eliminar_usuario_controlador(){
            /**----------Obteniendo y Desencriptando ID---------- */
            $id = mainModel::decryption($_POST['usuario_id_del']);
            $id = mainModel::limpiar_cadena($id);

            /**--------Comprobando Administrador--------- */
            if($id == 1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"El ADMINISTRADOR no puede ser eliminado del sistema",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Comprobando Usuario en DB--------- */
            $check_usuario = mainModel::ejecutar_consulta_simple("SELECT id_usuario FROM usuarios WHERE id_usuario = $id");
            if($check_usuario->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"El USUARIO que desea ELIMINAR no se encuentra en la base de datos",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Comprobando Privilegio---------- */
            session_start(['name' => 'MDIRECTORY']);
            if($_SESSION['privilegio_mdirectory'] != 1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"El USUARIO que desea actualizar no se encuentra en la base de datos",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            $eliminar_usuario = usuarioModelo::eliminar_usuario_modelo($id);

            if($eliminar_usuario->rowCount() == 1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Usuario Eliminado",
                    "Texto"=>"El USUARIO ha sido eliminado con éxito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"No ha sido posible eliminar al usuario, intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            exit();
        }
    }