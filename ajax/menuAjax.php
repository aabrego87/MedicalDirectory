<?php
    $peticionAjax=true;
    require_once "../config/APP.php";

    if(isset($_POST['menu_nombre_reg']) || isset($_POST['menu_id_up']) || isset($_POST['menu_id_del'])){

        /*--------------Instancia al controlador-------------------*/
        require_once "../controladores/menuControlador.php";
        $ins_menus = new menuControlador();
        /*--------------Agregar un Menu-------------------*/
        if(isset($_POST['menu_nombre_reg']) &&  isset($_POST['menu_ruta_reg'])){
            echo $ins_menus->agregar_menu_controlador();
        }
        /**----------Actualizar un Menu---------- */
        if(isset($_POST['menu_id_up'])){
            echo $ins_menus->actualizar_menu_controlador();
        }
        /**----------Eliminar un Menú---------- */
        if(isset($_POST['menu_id_del'])){
            echo $ins_menus->eliminar_menu_controlador();
        }

    }else{
       session_start(['name'=>'MDIRECTORY']);
       session_unset();
       session_destroy();
       header("Location: ".SERVERURL."login/");
       exit(); 
    }