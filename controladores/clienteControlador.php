<?php
    if($peticionAjax){
        require_once "../modelos/clienteModelo.php";
    }else{
        require_once "./modelos/clienteModelo.php";
    }

    class clienteControlador extends clienteModelo{
        /**-----------Agregar Cliente Controlador----------- */
        public function agregar_cliente_controlador(){
            /**----------Recibiendo Datos del Formulario---------- */
            $nombre = mainModel::limpiar_cadena($_POST['cliente_nombre_reg']);
            $apellidop = mainModel::limpiar_cadena($_POST['cliente_apellido_p_reg']);
            $apellidom = mainModel::limpiar_cadena($_POST['cliente_apellido_m_reg']);
            $edad = mainModel::limpiar_cadena($_POST['cliente_edad_reg']);
            $telefono = mainModel::limpiar_cadena($_POST['cliente_telefono_reg']);
            $direccion = mainModel::limpiar_cadena($_POST['cliente_direccion_reg']);
            $tipo_sangre = mainModel::limpiar_cadena($_POST['cliente_tipo_sangre_reg']);

            $usuario = mainModel::limpiar_cadena($_POST['cliente_usuario_reg']);
            $email = mainModel::limpiar_cadena($_POST['cliente_email_reg']);
            $clave1 = mainModel::limpiar_cadena($_POST['cliente_clave_1_reg']);
            $clave2 = mainModel::limpiar_cadena($_POST['cliente_clave_2_reg']);
            $imagen = $_FILES['cliente_imagen_reg']['name'];
            $privilegio = 5;
            $tipo_cliente = mainModel::limpiar_cadena($_POST['tipo_cliente']);
            $url = "login";

            /**----------Comprobando Campos Vacios---------- */
            if($nombre == "" || $apellidop == "" || $apellidom == "" || $telefono == "" || $direccion == "" 
                || $tipo_sangre == "" || $usuario == "" || $email == "" || $clave1 == "" || $clave2 == ""){
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
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}", $nombre)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El NOMBRE ingresado no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}", $apellidop)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El APELLIDO PATERNO ingresado no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}", $apellidom)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El APELLIDO MATERNO ingresado no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[0-9()+]{8,20}", $telefono)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El TELÉFONO ingresado no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}", $direccion)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"La DIRECCIÓN ingresada no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if($_POST['cliente_cuenta_reg'] != ''){
                $cuenta = mainModel::limpiar_cadena($_POST['cliente_cuenta_reg']);
                if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,40}", $cuenta)){
                    $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El NÚMERO DE CUENTA ingresado no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
                }
            }

            if($_POST['cliente_paypal_reg'] != ''){
                $paypal = mainModel::limpiar_cadena($_POST['cliente_paypal_reg']);
                if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,40}", $paypal)){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede completar la operación",
                        "Texto"=>"El USUARIO PAYPAL ingresado no coincide con el formato solicitado",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9]{1,35}", $usuario)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El USUARIO ingresado no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El EMAIL ingresado no coincide con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave1) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave2)){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"Las CONTRASEÑAS ingresadas no coinciden con el formato solicitado",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            /**----------Comprobando Campos y en BBDD---------- */

            //Edad
            if($edad < 0 || $edad > 120){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"La EDAD ingresada no es válida",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            //Usuario
            $check_user = mainModel::ejecutar_consulta_simple("SELECT usuario FROM clientes WHERE usuario = '$usuario'");
            if($check_user->rowCount() > 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El USUARIO ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            //Contraseñas
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

            //Email
            $check_email = mainModel::ejecutar_consulta_simple("SELECT email FROM clientes WHERE email = '$email'");
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

            //Imagen
            if(!empty($_FILES)){ //Si no estan vacios los archivos
                if (mainModel::validar_imagen($_FILES['cliente_imagen_reg']['tmp_name'])) { // Comprueba si es una imagen valida
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inesperado",
                        "Texto"=>"La IMAGEN seleccionada no tiene un formato válido",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit(); 
                } else {
                    $destino = "../vistas/assets/clientes/";
                    $file_upload = $destino . $_FILES['cliente_imagen_reg']['name'];
                    move_uploaded_file($_FILES['cliente_imagen_reg']['tmp_name'], $file_upload); // Sube el archivo a la carpeta
                }
            }
            
            /**----------Comprobando Campos no obiigatorios---------- */
            if(isset($_POST['cliente_cuenta_reg'])){
                if(isset($_POST['cliente_paypal_reg'])){
                    $datos_cliente_reg = [
                        "Nombre"=>$nombre,
                        "ApellidoP"=>$apellidop,
                        "ApellidoM"=>$apellidom,
                        "Edad"=>$edad,
                        "Direccion"=>$direccion,
                        "Telefono"=>$telefono,
                        "Sangre"=>$tipo_sangre,
                        "Tarjeta"=>$_POST['cliente_cuenta_reg'],
                        "Paypal"=>$_POST['cliente_paypal_reg'],
                        "Email"=>$email,
                        "Usuario"=>$usuario,
                        "Pass"=>$clave,
                        "Privilegio"=>$privilegio,
                        "Imagen"=>$imagen
                    ];    
                }else{
                    $datos_cliente_reg = [
                        "Nombre"=>$nombre,
                        "ApellidoP"=>$apellidop,
                        "ApellidoM"=>$apellidom,
                        "Edad"=>$edad,
                        "Direccion"=>$direccion,
                        "Telefono"=>$telefono,
                        "Sangre"=>$tipo_sangre,
                        "Tarjeta"=>$_POST['cliente_cuenta_reg'],
                        "Email"=>$email,
                        "Usuario"=>$usuario,
                        "Pass"=>$clave,
                        "Privilegio"=>$privilegio,
                        "Imagen"=>$imagen
                    ];
                }
            }else{
                $datos_cliente_reg = [
                    "Nombre"=>$nombre,
                    "ApellidoP"=>$apellidop,
                    "ApellidoM"=>$apellidom,
                    "Edad"=>$edad,
                    "Direccion"=>$direccion,
                    "Telefono"=>$telefono,
                    "Sangre"=>$tipo_sangre,
                    "Email"=>$email,
                    "Usuario"=>$usuario,
                    "Pass"=>$clave,
                    "Privilegio"=>$privilegio,
                    "Imagen"=>$imagen
                ];
            }

            $agregar_cliente = clienteModelo::agregar_cliente_modelo($datos_cliente_reg);
            if($agregar_cliente->rowCount() == 1){
                if($tipo_cliente == "interno"){
                    $alerta=[
                        "Alerta"=>"limpiar",
                        "Titulo"=>"Paciente Registrado",
                        "Texto"=>"Los datos han sido registrados con éxito",
                        "Tipo"=>"success"
                    ];
                }else if($tipo_cliente == "externo"){
                    $alerta = [
                        "Alerta"=>"redireccionar",
                        "Titulo"=>"Paciente Registrado",
                        "Texto"=>"El paciente ha sido registrado con éxito",
                        "Tipo"=>"success",
                        "URL"=>$url
                    ];
                }
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"No ha sido posible registrar al Paciente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);

        }/**----------Fin de Controlador---------- */

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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS clientes.id_cliente, clientes.nombre_cliente, clientes.apellido_p_cliente, clientes.apellido_m_cliente, clientes.direccion, clientes.telefono, tipo_sangre.tipo_sangre, clientes.email
                FROM reservaciones 
                INNER JOIN clientes ON reservaciones.id_cliente = clientes.id_cliente
                INNER JOIN tipo_sangre ON clientes.tipo_sangre = tipo_sangre.id_tipo_sangre
                INNER JOIN doctores ON reservaciones.id_doctor = doctores.id_doctor 
                WHERE reservaciones.id_doctor = $id
                GROUP BY reservaciones.id_cliente
                ORDER BY reservaciones.id_cliente ASC LIMIT $inicio, $registros";
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
                            <th>Tipo de Sangre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Email</th>';
                            if($privilegio==1 || $privilegio==4){
                                $tabla.='<th>Expediente</th>';
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
                            <td>'. $rows['tipo_sangre'] .'</td>
                            <td>'. $rows['direccion'] .'</td>
                            <td>'. $rows['telefono'] .'</td>
                            <td>'. $rows['email'] .'</td>';
                            if($privilegio==1 || $privilegio==4){
                                $tabla.='<td>
                                    <a class="btn btn-raised btn-primary" href="'.SERVERURL.'client-expediente/'.mainModel::encryption($rows['id_cliente']).'/" class="btn btn-success" title="Expediente del cliente">
                                        <i class="fas fa-file"></i>	
                                    </a>
                                </td>';
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
        }/**----------Fin del Controlador---------- */

        /**----------Datos Cliente Controlador---------- */
        public function datos_cliente_controlador($tipo, $id){
            $tipo = mainModel::limpiar_cadena($tipo);

            $id = mainModel::decryption($id);
            $id = mainModel::limpiar_cadena($id);

            return clienteModelo::datos_cliente_modelo($tipo, $id);
        }/**----------Fin del Controlador---------- */

        /**----------Actualizar Cliente Controlador---------- */
        public function actualizar_cliente_controlador(){
            /**----------Recibiendo y desencriptando ID---------- */
            $id = mainModel::decryption($_POST['cliente_id_up']);
            $id = mainModel::limpiar_cadena($id);

            /**----------Comprobando Cliente---------- */
            $check_cliente = mainModel::ejecutar_consulta_simple("SELECT * FROM clientes WHERE id_cliente = $id");
            if($check_cliente->rowCount() <= 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El CLIENTE que desea actualizar no se encuentra en la base de datos",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos = $check_cliente->fetch();
            }
            
            /**----------Recibiendo datos del formulario---------- */
            $nombre = mainModel::limpiar_cadena($_POST['cliente_nombre_up']);
            $apellidop = mainModel::limpiar_cadena($_POST['cliente_apellido_p_up']);
            $apellidom = mainModel::limpiar_cadena($_POST['cliente_apellido_m_up']);
            $edad = mainModel::limpiar_cadena($_POST['cliente_edad_up']);
            $telefono = mainModel::limpiar_cadena($_POST['cliente_telefono_up']);
            $direccion = mainModel::limpiar_cadena($_POST['cliente_direccion_up']);
            $tipo_sangre = mainModel::limpiar_cadena($_POST['cliente_tipo_sangre_up']);

            //Cuenta y Paypal

            $usuario = mainModel::limpiar_cadena($_POST['cliente_usuario_up']);
            $email = mainModel::limpiar_cadena($_POST['cliente_email_up']);

            $usuario_admin = mainModel::limpiar_cadena($_POST['usuario_admin']);
            $clave_admin = mainModel::limpiar_cadena($_POST['clave_admin']);

            $tipo_cuenta = mainModel::limpiar_cadena($_POST['tipo_cuenta']);

            /**----------Verificando la Integridad de los Datos---------- */
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}", $nombre)){
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

            if($edad < 0 || $edad > 120){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"La EDAD no es válida",
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

            if(isset($_POST['cliente_cuenta_up']) && $_POST['cliente_cuenta_up'] != ''){
                if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,40}", $_POST['cliente_cuenta_up'])){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede completar la operación",
                        "Texto"=>"El NÚMERO DE TARJETA no coincide con el formato solicitado",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            if(isset($_POST['cliente_paypal_up']) && $_POST['cliente_paypal_up']){
                if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,40}", $_POST['cliente_paypal_up'])){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede completar la operación",
                        "Texto"=>"El USUARIO PAYPAL no coincide con el formato solicitado",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
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
                    "Texto"=>"La CLAVE DEL ADMINISTRADOR no coincide con el formato solicitado",
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
                $check_usuario = mainModel::ejecutar_consulta_simple("SELECT usuario FROM clientes WHERE usuario = '$usuario'");
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
                    $check_email = mainModel::ejecutar_consulta_simple("SELECT email FROM clientes WHERE email = '$email'");
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
            if($_POST['cliente_clave_nueva_1'] != "" || $_POST['cliente_clave_nueva_2'] != ""){
                if($_POST['cliente_clave_nueva_1'] != $_POST['cliente_clave_nueva_2"']){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede completar la operación",
                        "Texto"=>"Las NUEVAS CONTRASEÑAS no coinciden",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }else{
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede completar la operación",
                        "Texto"=>"Las NUEVAS CONTRASEÑAS no coinciden con el formato solicitado",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }else{
                $clave = $campos['pass'];
            }

            /**----------Comprobando Credenciales para Actualizar---------- */
            if($tipo_cuenta == 'Propia'){
                $check_cuenta = mainModel::ejecutar_consulta_simple("SELECT id_cliente FROM clientes WHERE usuario = '$usuario_admin' AND pass = '$clave_admin' AND id_cliente = '$id'");
            }else{
                session_start(['name' => 'MDIRECTORY']);
                if($_SESSION['privilegio_mdirectory'] != 1 && $_SESSION['privilegio_mdirectory'] != 5){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede completar la operación",
                        "Texto"=>"El EMAIL ingresado ya se encuentra registrado en el sistema",
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
                    "Texto"=>"El NOMRE y CLAVE del administrador no son correctas",
                    "Tipo"=>"warning"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(isset($_POST['cliente_cuenta_up'])){
                if(isset($_POST['cliente_paypal_up'])){
                    /**-----Datos para actualizar si se tiene numero de tarjeta y paypal----- */
                    $datos_cliente_up = [
                        "Nombre"=>$nombre,
                        "ApellidoP"=>$apellidop,
                        "ApellidoM"=>$apellidom,
                        "Edad"=>$edad,
                        "Direccion"=>$direccion,
                        "Telefono"=>$telefono,
                        "Sangre"=>$tipo_sangre,
                        "Tarjeta"=>$_POST['cliente_cuenta_up'],
                        "Paypal"=>$_POST['cliente_paypal_up'],
                        "Email"=>$email,
                        "Usuario"=>$usuario,
                        "Clave"=>$clave,
                        "ID"=>$id
                    ];
                }else{
                    /**-----Datos para actualizar si se tiene solo numero de tarjeta----- */
                    $datos_cliente_up = [
                        "Nombre"=>$nombre,
                        "ApellidoP"=>$apellidop,
                        "ApellidoM"=>$apellidom,
                        "Edad"=>$edad,
                        "Direccion"=>$direccion,
                        "Telefono"=>$telefono,
                        "Sangre"=>$tipo_sangre,
                        "Tarjeta"=>$_POST['cliente_cuenta_up'],
                        "Email"=>$email,
                        "Usuario"=>$usuario,
                        "Clave"=>$clave,
                        "ID"=>$id
                    ];
                }
            }else{
                /**-----Datos para actualizar si no se tiene numero de tarjeta ni paypal----- */
                $datos_cliente_up = [
                    "Nombre"=>$nombre,
                    "ApellidoP"=>$apellidop,
                    "ApellidoM"=>$apellidom,
                    "Edad"=>$edad,
                    "Direccion"=>$direccion,
                    "Telefono"=>$telefono,
                    "Sangre"=>$tipo_sangre,
                    "Email"=>$email,
                    "Usuario"=>$usuario,
                    "Clave"=>$clave,
                    "ID"=>$id
                ];
            }

            if(clienteModelo::actualizar_cliente_modelo($datos_cliente_up)){
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
        
        /**----------Eliminar Cliente Controlador---------- */
        public function eliminar_cliente_controlador(){
            /**----------Recibiendo y Desencriptando ID---------- */
            $id = mainmodel::decryption($_POST['cliente_id_del']);
            $id = mainModel::limpiar_cadena($id);

            /**----------Comprobando Cliente en DB---------- */
            $check_cliente = mainModel::ejecutar_consulta_simple("SELECT * FROM clientes WHERE id_cliente = $id");
            if($check_cliente->rowCount() <= 0){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"El CLIENTE que desea eliminar no se encuentra en el sistema",
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

            $eliminar_cliente = clienteModelo::eliminar_cliente_modelo($id);
            if($eliminar_cliente->rowCount() == 1){
                $alerta = [
                    "Alerta"=>"recargar",
                    "Titulo"=>"Cliente Eliminado",
                    "Texto"=>"Los datos se han eliminado correctamente",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"No se puede completar la operación",
                    "Texto"=>"No ha sido posible eliminar al cliente, intente nuevamente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            exit();
        }/**----------Fin del Controlador---------- */
    }
?>