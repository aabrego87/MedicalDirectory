<?php

    session_start(['name'=>'MDIRECTORY']);
    require_once "../config/APP.php";

    if (isset($_POST['busqueda_inicial']) || isset($_POST['eliminar_busqueda'])) {
        
        $data_url = [
            "cliente" => "client-list",
            "servicio" => "servicios-list",
        ];

            if (isset($_POST['modulo'])) {
                $modulo = $_POST['modulo'];
                if (!isset($data_url[$modulo])) { // Indice de array definido en formulario
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Error",
                        "Texto"=>"No podemos continuar con la búsqueda",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            } else {
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error",
                    "Texto"=>"Ha ocurrido un error del servidor, no podemos continuar con la búsqueda",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $name_var = "busqueda_" . $modulo;
            

            /*-----Iniciar Busqueda-----*/
            if (isset($_POST['busqueda_inicial'])) {
                if ($_POST['busqueda_inicial'] == "") {
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"No se puede realizar esta acción",
                        "Texto"=>"Por favor introduce un término de búsqueda",
                        "Tipo"=>"warning"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $_SESSION[$name_var] = $_POST['busqueda_inicial'];
               
            }
            /*-----Eliminar Busqueda-----*/
            if (isset($_POST['eliminar_busqueda'])) {
                unset($_SESSION[$name_var]);
                
            }

            //Redireccionar al usuario
            $url = $data_url[$modulo]; // Obtener url del modulo

            $alerta = [
                "Alerta"=>"redireccionar",
                "URL"=>SERVERURL.$url."/"
            ];

            echo json_encode($alerta);

    } else {
        session_start(['name' => 'MDIRECTORY']);
        session_unset();
        session_destroy();
        header("Location: " . SERVERURL. "login/");
        exit();
    }   

?>