<?php

    if($peticionAjax){
        require_once "../modelos/doctorModelo.php";
    }else{
        require_once "./modelos/doctorModelo.php";
    }

    class doctorControlador extends doctorModelo{

        /**----------Agregar Doctor Controlador---------- */
        public function agregar_doctor_controlador(){
            /**----------Obteniendo Datos de Formulario---------- */
            $nombre = mainModel::limpiar_cadena($_POST['doctor_nombre_reg']);
            $apellidop = mainModel::limpiar_cadena($_POST['doctor_apellido_p_reg']);
            $apellidom = mainModel::limpiar_cadena($_POST['doctor_apellido_m_reg']);
            $consultorio = mainModel::limpiar_cadena($_POST['doctor_consultorio_reg']);
            $consultorio_direccion = mainModel::limpiar_cadena($_POST['doctor_direccion_consultorio_reg']);
            $telefono = mainModel::limpiar_cadena($_POST['doctor_telefono_reg']);
            $descripcion = mainModel::limpiar_cadena($_POST['doctor_descripcion_reg']);

            $usuario = mainModel::limpiar_cadena($_POST['doctor_usuario_reg']);
            $email = mainModel::limpiar_cadena($_POST['doctor_email_reg']);
            $clave1 = mainModel::limpiar_cadena($_POST['doctor_clave_1_reg']);
            $clave2 = mainModel::limpiar_cadena($_POST['doctor_clave_2_reg']);
            $imagen = $_FILES['doctor_imagen_reg']['name'];
            $especialidad = mainModel::limpiar_cadena($_POST['doctor_especialidad_reg']);
            $privilegio = 4;
            $tipo_doctor = mainModel::limpiar_cadena($_POST['tipo_doctor']);
            $url = "login";

            /**----------Comprobando Campos Vacios---------- */
            if($nombre == "" || $apellidop == "" || $apellidom == "" || $consultorio == "" || $consultorio_direccion == "" || $telefono == "" || 
                $descripcion == "" || $usuario == "" || $email == "" || $clave1 == "" || $clave2 == "" || $especialidad == ""){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No ha llenado todos los datos obligatorios",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Comprobando la Interidad de los Datos---------- */
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ1-9 ]{3,35}", $nombre)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El NOMBRE no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ1-9 ]{3,35}", $apellidop)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El APELLIDO PATERNO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ1-9 ]{3,35}", $apellidom)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El APELLIDO MATERNO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $consultorio)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El NOMBRE DEL CONSUTORIO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $consultorio_direccion)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"La DIRECCIÓN DEL CONSULTORIO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[0-9 ]{8,15}", $telefono)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El TELÉFONO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9]{1,35}", $usuario)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El usuario ingresado no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El CORREO ingresado no es válido",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave1) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave2)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"Las CONTRASEÑAS no coinciden con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**Comprobando Campos y En BBDD--------- */
            $check_user = mainModel::ejecutar_consulta_simple("SELECT usuario FROM doctores WHERE usuario = $usuario");
            if($check_user->rowCount() > 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El USUARIO ingresado ya se encuentra registrado en el sistema con otro doctor",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if($clave1 != $clave2){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"Las CONTRASEÑAS no coinciden",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $clave = mainModel::encryption($clave1);
            }

            $check_email = mainModel::ejecutar_consulta_simple("SELECT email FROM doctores WHERE email = $email");
            if($check_email->rowCount() > 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El CORREO ingresado ya se encuentra registrado en el sistema con otro doctor",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*--------------Comprobando Imagen---------------------*/
            if(!empty($_FILES)){ //Si no estan vacios los archivos
                if (mainModel::validar_imagen($_FILES['doctor_imagen_reg']['tmp_name'])) { // Comprueba si es una imagen valida
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inesperado",
                        "Texto"=>"La IMAGEN seleccionada no tiene un formato válido",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit(); 
                } else {
                    $destino = "../vistas/assets/doctores/";
                    $file_upload = $destino . $_FILES['doctor_imagen_reg']['name'];
                    move_uploaded_file($_FILES['doctor_imagen_reg']['tmp_name'], $file_upload); // Sube el archivo a la carpeta
                }
            }

            /**----------Comprobando Especialidad--------- */
            $check_especialidad = mainModel::ejecutar_consulta_simple("SELECT id_especialidad FROM especialidades WHERE id_especialidad = $especialidad");
            if($check_especialidad->rowCount() <= 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"La ESPECIALIDAD seleccionada no es válida",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $datos_doctor_reg = [
                "Doctor"=>$nombre,
                "ApellidoP"=>$apellidop,
                "ApellidoM"=>$apellidom,
                "Negocio"=>$consultorio,
                "Direccion"=>$consultorio_direccion,
                "Telefono"=>$telefono,
                "Descripcion"=>$descripcion,
                "Email"=>$email,
                "Usuario"=>$usuario,
                "Pass"=>$clave,
                "Privilegio"=>$privilegio,
                "Imagen"=>$imagen,
                "Especialidad"=>$especialidad
            ];

            $agregar_doctor = doctorModelo::agregar_doctor_modelo($datos_doctor_reg);

            if ($agregar_doctor->rowCount()==1) {
                if($tipo_doctor == "interno"){
                    $alerta=[
                        "Alerta"=>"limpiar",
                        "Titulo"=>"Doctor Registrado",
                        "Texto"=>"Los datos han sido registrados con éxito",
                        "Tipo"=>"success"
                    ];
                }else if($tipo_doctor == "externo"){
                    $alerta = [
                        "Alerta"=>"redireccionar",
                        "URL"=>$url
                    ];
                }
            } else {
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"No ha sido posible registrar el Doctor",
                    "Tipo"=>"error"
                ];
            }

            echo json_encode($alerta);

        }/**----------Fin del Controlador---------- */

        /**----------Paginador Doctores Controlador---------- */
        public function paginador_doctores_controlador($pagina, $registros, $privilegio, $id, $url, $busqueda){
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
                FROM doctores
                ORDER BY id_doctor ASC LIMIT $inicio, $registros";
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
                            <th>Negocio</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Email</th>';
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
                            <td>
                                <a href="'.SERVERURL.'doctors-profile/'.mainModel::encryption($rows['id_doctor']).'">
                                    '. $rows['nombre_doctor'] .'
                                </a>
                            </td>
                            <td>'. $rows['apellido_p_doctor'] .'</td>
                            <td>'. $rows['apellido_m_doctor'] .'</td>
                            <td>'. $rows['nombre_negocio'] .'</td>
                            <td>'. $rows['direccion_consultorio'] .'</td>
                            <td>'. $rows['telefono'] .'</td>
                            <td>'. $rows['email'] .'</td>';
                            if($privilegio==1 || $privilegio==2){
                                $tabla.='<td>
                                    <a href="'.SERVERURL.'doctors-update/'.mainModel::encryption($rows['id_doctor']).'/" class="btn btn-success">
                                        <i class="fas fa-sync-alt"></i>	
                                    </a>
                                </td>';
                            }
                            if($privilegio==1){
                                $tabla.='<td>
                                    <form class="FormularioAjax" action="'.SERVERURL.'ajax/doctorAjax.php"  method="POST" data-form="delete" autocomplete="off">
                                        <input type="hidden" name="doctor_id_del" value="'.mainModel::encryption($rows['id_doctor']).'">                                
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
                $tabla .= '<p class="text-right">Mostrando Doctores '. $reg_inicio .' al '. $reg_final .' de un total de '. $total .'</p>';
                $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
            }

            return $tabla;
        }/**----------Fin del Controlador---------- */

        /**----------Datos Doctor Controlador---------- */
        public function datos_doctor_controlador($tipo, $id){
            /**----------Recibiendo Datos---------- */
            $tipo = mainModel::limpiar_cadena($tipo);

            $id = mainModel::decryption($id);
            $id = mainModel::limpiar_cadena($id);

            return doctorModelo::datos_doctor_modelo($tipo, $id);
        }/**----------Fin del Controlador---------- */

        /**----------Actualizar Doctor Controlador---------- */
        public function actualizar_doctor_controlador(){
            /**----------Recibiendo y Desencriptando ID---------- */
            $id = mainmodel::decryption($_POST['doctor_id_up']);
            $id = mainModel::limpiar_cadena($id);

            /**----------Comprobando Doctor---------- */
            $check_doctor = mainModel::ejecutar_consulta_simple("SELECT * FROM doctores WHERE id_doctor = $id");
            if($check_doctor->rowCount() <= 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El DOCTOR que desea actualizar no se encuentra en la base de datos",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos = $check_doctor->fetch();
            }

            /**----------Recibiendo datos del formulario */
            $nombre = mainModel::limpiar_cadena($_POST['doctor_nombre_up']);
            $apellidop = mainModel::limpiar_cadena($_POST['doctor_apellido_p_up']);
            $apellidom = mainModel::limpiar_cadena($_POST['doctor_apellido_m_up']);
            $telefono = mainModel::limpiar_cadena($_POST['doctor_telefono_up']);
            $negocio = mainModel::limpiar_cadena($_POST['doctor_negocio_up']);
            $direccion = mainModel::limpiar_cadena($_POST['doctor_direccion_up']);
            
            $email = mainModel::limpiar_cadena($_POST['doctor_email_up']);
            $usuario = mainModel::limpiar_cadena($_POST['doctor_usuario_up']);

            $usuario_admin = mainModel::limpiar_cadena($_POST['usuario_admin']);
            $clave_admin = mainModel::limpiar_cadena($_POST['clave_admin']);

            $tipo_cuenta = mainModel::limpiar_cadena($_POST['tipo_cuenta']);
            
            /**----------Verificando Integridad de los Datos---------- */
            if(mainmodel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}", $nombre)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El NOMBRE no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}", $apellidop)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El APELLIDO PATERNO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}", $apellidom)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El APELLIDO MATERNO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[0-9()+]{8,20}", $telefono)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El TELÉFONO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}", $negocio)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El NOMBRE DEL NEGOCIO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}", $direccion)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"La DIRECCIÓN no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9]{1,35}", $usuario)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El USUARIO no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9]{1,35}", $usuario_admin)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El USUARIO DEL ADMINISTRADOR no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_admin)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"La CONTRASEÑA DEL ADMINISTRADOR no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }
           
            //Encriptando clave de Admin para comprobar en DB
            $clave_admin = mainModel::encryption($clave_admin);

            /**----------Comprobando Datos y en DB---------- */
            //Usuario
            if($usuario != $campos['usuario']){
                $check_usuario = mainModel::ejecutar_consulta_simple("SELECT usuario FROM doctores WHERE usuario = '$usuario'");
                if($check_usuario->rowCount() > 0){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede completar la operación",
                        "Texto"=>"El USUARIO ingresado ya se encuentra registrado en el sistema",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            //Email
            if($email != $campos['email'] && $email != ""){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $check_email = mainModel::ejecutar_consulta_simple("SELECT email FROM doctores WHERE email = '$email'");
                    if($check_email->rowCount() > 0){
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"No se puede completar la operación",
                            "Texto"=>"El EMAIL ingresado ya se encuentra registrado en el sistema",
                            "Tipo"=>"warning"
                        ];
                        echo json_encode($alerta);
                        exit();
                    }
                }else{
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede completar la operación",
                        "Texto"=>"El EMAIL ingresado no coincide con el formato solicitado",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            //Contraseñas
            if($_POST['doctor_clave_nueva_1'] != "" || $_POST['doctor_clave_nueva_2'] != ""){
                if($_POST['doctor_clave_nueva_1'] != $_POST['doctor_clave_nueva_2']){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede completar la operación",
                        "Texto"=>"Las NUEVAS CONTRASEÑAS no coinciden",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }else{
                    if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $_POST['doctor_clave_nueva_1']) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $_POST['doctor_clave_nueva_2'])){
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"No se puede completar la operación",
                            "Texto"=>"Las NUEVAS CONTRASEÑAS no coinciden con el formato solicitado",
                            "Tipo"=>"warning"
                        ];
                        echo json_encode($alerta);
                        exit();
                    }
                    $clave = mainModel::encryption($_POST['doctor_clave_nueva_1']);
                }
            }else{
                $clave = $campos['pass'];
            }

            /**----------Comprobando Credenciales para Actualizar---------- */
            if($tipo_cuenta == 'Propia'){
                $check_cuenta = mainModel::ejecutar_consulta_simple("SELECT id_usuario FROM usuarios WHERE usuario_usuario = '$usuario_admin' AND usuario_clave = '$clave_admin' AND id_usuario = $id");
            }else{
                session_start(['name' => 'MDIRECTORY']);
                if($_SESSION['privilegio_mdirectory'] != 1 && $_SESSION['privilegio_mdirectory'] != 4){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede completar la operación",
                        "Texto"=>"No cuentas con los permisos para realizar esta operación",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $check_cuenta = mainModel::ejecutar_consulta_simple("SELECT id_usuario FROM usuarios WHERE usuario_usuario = '$usuario_admin' AND usuario_clave = '$clave_admin'");
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
            $datos_doctor_up = [
                "Nombre"=>$nombre,
                "ApellidoP"=>$apellidop,
                "ApellidoM"=>$apellidom,
                "Negocio"=>$negocio,
                "DirConsultorio"=>$direccion,
                "Telefono"=>$telefono,
                "Email"=>$email,
                "Usuario"=>$usuario,
                "Pass"=>$clave,
                "ID"=>$id
            ];

            if(doctorModelo::actualizar_doctor_modelo($datos_doctor_up)){
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
        }/**----------Fin del Controlador--------- */

        /**----------Eliminar Doctor Controlador---------- */
        public function eliminar_doctor_controlador(){
            /**----------Recibendo y Desencriptando ID---------- */
            $id = mainModel::decryption($_POST['doctor_id_del']);
            $id = mainModel::limpiar_cadena($id);

            /**-----------Comprobando Doctor en DB---------- */
            $check_doctor = mainModel::ejecutar_consulta_simple("SELECT id_doctor FROM doctores WHERE id_doctor = $id");
            if($check_doctor->rowCount() <= 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El DOCTOR que desea actualizar no se encuentra en la base de datos",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Comprobando Privilegio---------- */
            session_start(['name' => 'MDIRECTORY']);
            if($_SESSION['privilegio_mdirectory'] != 1){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No cuentas con los permisos necesarios para realizar esta operación",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            $eliminar_doctor = doctorModelo::eliminar_doctor_modelo($id);

            if($eliminar_doctor->rowCount() == 1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Doctor Eliminado",
                    "Texto"=>"El DOCTOR ha sido eliminado con éxito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede realizar esta operación",
                    "Texto"=>"No ha sido posible eliminar al doctor, intente nuevamente",
                    "Tipo"=>"warning"
                ];
            }
            echo json_encode($alerta);
            exit();
        }/**----------Fin del Controlador---------- */
    }

?>