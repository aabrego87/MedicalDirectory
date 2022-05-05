<?php
    $peticionAjax=true;
    require_once "../config/APP.php";

    if(isset($_POST['doctor_nombre_reg']) || isset($_POST['doctor_nombre_up']) || isset($_POST['doctor_id_del'])){

        /*--------------Instancia al controlador-------------------*/
        require_once "../controladores/doctorControlador.php";
        $ins_doctor = new doctorControlador();
        /*--------------Agregar un Doctor-------------------*/
        if(isset($_POST['doctor_usuario_reg']) && isset($_POST['doctor_nombre_reg'])){
            echo $ins_doctor->agregar_doctor_controlador();
        }
        /**------------Actualizazr un Doctor------------ */
        if(isset($_POST['doctor_id_up'])){
            echo $ins_doctor->actualizar_doctor_controlador();
        }
        /**----------Eliminar un Doctor---------- */
        if(isset($_POST['doctor_id_del'])){
            echo $ins_doctor->eliminar_doctor_controlador();
        }

    }else{
       session_start(['name'=>'MDIRECTORY']);
       session_unset();
       session_destroy();
       header("Location: ".SERVERURL."login/");
       exit(); 
    }