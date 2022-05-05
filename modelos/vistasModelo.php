<?php
    class vistasModelo{
        /*-------- Modelo obtener las vistas --------*/
        protected static function obtener_vistas_modelo($vistas){
            $listaBlanca=["home",
            "client-list","client-new","client-search","client-update", "client-expediente", "client-carnet",
            "company",
            "item-list","item-new","item-search","item-update",
            "reservation-list","reservation-new","reservation-pending","reservation-reservation","reservation-search","reservation-update", "reservation",
            "user-list","user-new","user-search","user-update",
            "doctors-list", "doctors-new", "doctors-update", "doctors-profile",
            "especialidad-new", "especialidad-list", "especialidad-update",
            "service-list", "service-doctor-list", "service-new", "service-update",
            "reservacion-new",
            "menu-list", "menu-new", "menu-update"];
            if(in_array($vistas, $listaBlanca)){
                if(is_File("./vistas/contenidos/".$vistas."-view.php")){
                    $contenido="./vistas/contenidos/".$vistas."-view.php";
                }else{
                    $contenido="404";
                }
            }elseif($vistas=="login" || $vistas=="index"){
                $contenido ="login";
            }else if($vistas=="register-type"){
                $contenido="register-type";
            }elseif($vistas=="register-doctor"){
                $contenido="register-doctor";
            }else if($vistas=="register-paciente"){
                $contenido="register-paciente";
            }else{
                $contenido="404";
            }
            return $contenido;
        }
    }