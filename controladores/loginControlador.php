<?php

    if($peticionAjax){
        require_once "../modelos/loginModelo.php";
    }else{
        require_once "./modelos/loginModelo.php";
    }

    class loginControlador extends loginModelo{

         /*----------Controlador Iniciar Sesion----------*/
         public static function iniciar_sesion_controlador(){
            $usuario = mainModel::limpiar_cadena($_POST['usuario_log']);
            $clave = mainModel::limpiar_cadena($_POST['clave_log']);

            // Comprobar Campos Vacios
            if ($usuario == "" || $clave == "") { // Si los campos están vacios, muestra una alerta JS
                echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "No ha llenado todos los campos",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
                exit();
            }

            // Verificar la integridad de los datos
            if(mainModel::verificar_datos("[a-zA-Z0-9]{1,35}", $usuario)) {
                echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "El NOMBRE DE USUARIO no coincide con el formato solicitado",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave)) {
                echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "La CONTRASEÑA no coincide con el formato solicitado",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
                exit();
            }

            $clave=mainModel::encryption($clave);

            $datos_login = [ // Arreglo con los datos de iniciar sesion
                "Usuario" => $usuario,
                "Clave" => $clave
            ];

            $datos_cuenta = loginModelo::iniciar_sesion_modelo($datos_login);

            if($datos_cuenta->rowCount()==1) {
                $row = $datos_cuenta->fetch(); // Variable que almacena los datos del usuario en la BD

                session_start(['name'=>'MDIRECTORY']);
                
                /**----------Comprobando Sesiones para Doctor y Usuario---------- */
                if(!$row['id_usuario'] && $row['id_doctor']){
                    $_SESSION['id_mdirectory'] = $row['id_doctor'];
                    $_SESSION['nombre_mdirectory'] = $row['nombre_doctor'];
                    $_SESSION['apellido_p_mdirectory'] = $row['apellido_p_doctor'];
                    $_SESSION['apellido_m_mdirectory'] = $row['apellido_m_doctor'];
                    $_SESSION['usuario_mdirectory'] = $row['usuario'];
                    $_SESSION['privilegio_mdirectory'] = $row['privilegio'];
                    $_SESSION['imagen_mdirectory'] = $row['imagen'];
                }else if(!$row['id_usuario'] && !$row['id_doctor'] && $row['id_cliente']){
                    $_SESSION['id_mdirectory'] = $row['id_cliente'];
                    $_SESSION['nombre_mdirectory'] = $row['nombre_cliente'];
                    $_SESSION['apellido_p_mdirectory'] = $row['apellido_p_cliente'];
                    $_SESSION['apellido_m_mdirectory'] = $row['apellido_m_cliente'];
                    $_SESSION['usuario_mdirectory'] = $row['usuario'];
                    $_SESSION['privilegio_mdirectory'] = $row['privilegio'];
                    $_SESSION['imagen_mdirectory'] = $row['imagen'];
                }else{
                    $_SESSION['id_mdirectory'] = $row['id_usuario'];
                    $_SESSION['nombre_mdirectory'] = $row['usuario_nombre'];
                    $_SESSION['apellido_p_mdirectory'] = $row['usuario_apellido_p'];
                    $_SESSION['apellido_m_mdirectory'] = $row['usuario_apellido_m'];
                    $_SESSION['usuario_mdirectory'] = $row['usuario_usuario'];
                    $_SESSION['privilegio_mdirectory'] = $row['usuario_privilegio'];
                    $_SESSION['imagen_mdirectory'] = $row['usuario_imagen'];
                }
                $_SESSION['token_mdirectory'] = md5(uniqid(mt_rand(),true)); // Procesar por el hash md5 un numero unico para cada sesion

                return header("Location: " . SERVERURL . "home/");
            } else {
                echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "El USUARIO o CONTRASEÑA son incorrectos",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            }

         } /*= Fin Controlador =*/

         /*----------Controlador Forzar Cierre de Sesion----------*/
         public static function forzar_cierre_sesion_controlador(){
            session_unset();
            session_destroy();
            if (headers_sent()) { //Verifica envio de cabezados / TRUE envia
                return "<script> window.location.href='".SERVERURL."login/'; </script>";
            } else {
                return header("Location: ".SERVERURL."login/");
            }
         } /*= Fin Controlador =*/

          /*----------Controlador Cierre de Sesion----------*/
          public static function cerrar_sesion_controlador(){
            session_start(['name'=>'MDIRECTORY']);
            $token = mainModel::decryption($_POST['token']);
            $usuario = mainModel::decryption($_POST['usuario']);
            if ($token==$_SESSION['token_mdirectory'] && $usuario == $_SESSION['usuario_mdirectory']) { // Si los datos coinciden con la sesion
                session_unset();
                session_destroy();
                $alerta =[ // Indice alerta para que entre en la condicion de alerta JS
                    "Alerta"=>"redireccionar",
                    "Titulo"=>"Sesión Finalizada",
                    "Texto"=>"La sesión ha sido cerrada con éxito",
                    "Tipo"=>"success",
                    "URL"=>SERVERURL."login/"
                ];
            } else {
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un Error Inesperado",
                    "Texto"=>"La SESIÓN no pudo ser cerrada",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
          } /*== Fin Controlador ==*/
    }