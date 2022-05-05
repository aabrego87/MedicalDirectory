<?php
    $peticionAjax=true;
    require_once "../config/APP.php";

    if(isset($_POST['especialidad_nombre_reg']) || isset($_POST['especialidad_id_up'])){

        /*--------------Instancia al controlador-------------------*/
        require_once "../controladores/especialidadControlador.php";
        $ins_especialidad = new especialidadControlador();
        /*--------------Agregar una Especialidad-------------------*/
        if(isset($_POST['especialidad_nombre_reg'])){
            echo $ins_especialidad->agregar_especialidad_controlador();
        }
        /**----------Actualizar una Especialidad---------- */
        if(isset($_POST['especialidad_id_up'])){
            echo $ins_especialidad->actualizar_especialidad_controlador();
        }

    }else{
       session_start(['name'=>'MDIRECTORY']);
       session_unset();
       session_destroy();
       header("Location: ".SERVERURL."login/");
       exit(); 
    }