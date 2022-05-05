<?php
    $peticionAjax=true;
    require_once "../config/APP.php";

    if(isset($_POST['servicio_nombre_reg']) || isset($_POST['servicio_id_up']) || isset($_POST['servicio_id_del'])){

        /*--------------Instancia al controlador-------------------*/
        require_once "../controladores/servicioControlador.php";
        $ins_servicio = new servicioControlador();
        /*--------------Agregar un Servicio-------------------*/
        if(isset($_POST['servicio_precio_reg']) && isset($_POST['servicio_nombre_reg'])){
            echo $ins_servicio->agregar_servicio_controlador();
        }
        /**----------Actualizar un Servicio---------- */
        if(isset($_POST['servicio_id_up'])){
            echo $ins_servicio->actualizar_servicio_controlador();
        }
        /**----------Eliminar un Servicio---------- */
        if(isset($_POST['servicio_id_del'])){
            echo $ins_servicio->eliminar_servicio_controlador();
        }

    }else{
       session_start(['name'=>'MDIRECTORY']);
       session_unset();
       session_destroy();
       header("Location: ".SERVERURL."login/");
       exit(); 
    }