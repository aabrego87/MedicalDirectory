<?php
    $peticionAjax=true;
    require_once "../config/APP.php";

    if(isset($_POST['reservacion_id_servicio']) || isset($_POST['reservacion_id_start']) || isset($_POST['reservacion_id_up']) || isset($_POST['reservacion_id_del'])){

        /*--------------Instancia al controlador-------------------*/
        require_once "../controladores/reservacionControlador.php";
        $ins_reservacion = new reservacionControlador();
        /*--------------Agregar una Reservacion-------------------*/
        if(isset($_POST['reservacion_id_cliente']) && isset($_POST['reservacion_id_servicio'])){
            echo $ins_reservacion->agregar_reservacion_controlador();
        }
        /**----------Iniciar una Consulta---------- */
        if(isset($_POST['reservacion_id_start'])){
            echo $ins_reservacion->iniciar_consulta_controlador();
        }
        /**-------------Actualizar una Reservacion------------- */
        if(isset($_POST['reservacion_id_up'])){
            echo $ins_reservacion->actualizar_reservacion_controlador();
        }
        /**----------Eliminar una Reservacion---------- */
        if(isset($_POST['reservacion_id_del'])){
            echo $ins_reservacion->eliminar_reservacion_controlador();
        }

    }else{
       session_start(['name'=>'MDIRECTORY']);
       session_unset();
       session_destroy();
       header("Location: ".SERVERURL."login/");
       exit(); 
    }