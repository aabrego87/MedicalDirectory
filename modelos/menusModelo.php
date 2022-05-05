<?php
    require_once "mainModel.php";

    class menusModelo extends mainModel{

        /**-----Funcion Obtener Menus-----*/
        public static function obtener_menus_modelo($privilegio){
            $sql = mainModel::conectar()->prepare("SELECT 
            perfil_menu.id_menu,
            menu.nom_menu,
            menu.icon_menu,
            menu.ruta_menu,
            menu.activo,
            menu.id_padre
            FROM perfil_menu
            INNER JOIN menu ON menu.id_menu = perfil_menu.id_menu
            WHERE activo = 1 AND id_privilegio = $privilegio");
            $sql->execute();

            $resultado = $sql->fetchAll();

            return $resultado;
        }
        
        /**-----------------
            SUBMENUS
         -----------------*/

        /**-----Funcion Obtener Sub Menus Configuracion-----*/
        public static function obtener_submenus1_modelo($privilegio){
            $sql = mainModel::conectar()->prepare("SELECT 
            perfil_menu.id_menu,
            menu.nom_menu,
            menu.icon_menu,
            menu.ruta_menu,
            menu.activo,
            menu.id_padre,
            perfil_menu.id_privilegio
            FROM perfil_menu
            INNER JOIN menu ON menu.id_menu = perfil_menu.id_menu
            WHERE id_padre = 2 AND id_privilegio = $privilegio");
            $sql->execute();

            $resultado = $sql->fetchAll();
            return $resultado;
        }
        
        /**-----Funcion Obtener Sub Menus 2-----*/
        public static function obtener_submenus2_modelo($privilegio){
            $sql = mainModel::conectar()->prepare("SELECT 
            perfil_menu.id_menu,
            menu.nom_menu,
            menu.icon_menu,
            menu.ruta_menu,
            menu.activo,
            menu.id_padre,
            perfil_menu.id_privilegio
            FROM perfil_menu
            INNER JOIN menu ON menu.id_menu = perfil_menu.id_menu
            WHERE id_padre = 3 AND id_privilegio = $privilegio");
            $sql->execute();

            $resultado = $sql->fetchAll();

            return $resultado;
        }

        /**-----Funcion Obtener Sub Menus 3----- */
        public static function obtener_submenus3_modelo($privilegio){
            $sql = mainModel::conectar()->prepare("SELECT 
            perfil_menu.id_menu,
            menu.nom_menu,
            menu.icon_menu,
            menu.ruta_menu,
            menu.activo,
            menu.id_padre,
            perfil_menu.id_privilegio
            FROM perfil_menu
            INNER JOIN menu ON menu.id_menu = perfil_menu.id_menu
            WHERE id_padre = 4 AND id_privilegio = $privilegio");
            $sql->execute();

            $resultado = $sql->fetchAll();

            return $resultado;
        }

        /**----------Funcion Obtener Menus Padres----- */
        public static function obtener_padres_modelo(){
            $sql = mainModel::conectar()->prepare("SELECT * FROM menu WHERE activo = 1");
            $sql->execute();

            $resultado = $sql->fetchAll();

            return $resultado;
        }

        /**-----Agregar Menu Modelo----- */
        protected static function agregar_menu_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO menu (nom_menu, icon_menu, ruta_menu, activo, id_padre) VALUES (:Nombre, :Icono, :Ruta, :Activo, :Padre)");
            $sql->bindParam(":Nombre", $datos['Nombre']);
            $sql->bindParam(":Icono", $datos['Icono']);
            $sql->bindParam(":Ruta", $datos['Ruta']);
            $sql->bindParam(":Activo", $datos['Activo']);
            $sql->bindParam(":Padre", $datos['Padre']);
            $sql->execute();

            return $sql;
        }

        protected static function datos_menu_modelo($tipo, $id){
            if($tipo == "Unico"){
                $sql = mainModel::conectar()->prepare("SELECT * FROM menu WHERE id_menu = $id");
            }else if($tipo == "Conteo"){
                $sql = mainModel::conectar()->prepare("SELECT id_menu FROM menu");
            }
            $sql->execute();

            return $sql;
        }

        /**----------Funcion ctualizar Menu---------- */
        protected static function actualizar_menu_modelo($datos){
            $sql = mainModel::conectar()->prepare("UPDATE menu SET nom_menu = :Nombre, icon_menu = :Icono, ruta_menu = :Ruta, activo = :Activo, id_padre = :Padre WHERE id_menu = :ID");
            $sql->bindParam(":Nombre", $datos['Nombre']);
            $sql->bindParam(":Icono", $datos['Icono']);
            $sql->bindParam(":Ruta", $datos['Ruta']);
            $sql->bindParam(":Activo", $datos['Activo']);
            $sql->bindParam(":Padre", $datos['Padre']);
            $sql->bindParam(":ID", $datos['ID']);
            $sql->execute();

            return $sql;
        }

        /**----------Funcion Eliminar Menu---------- */
        protected static function eliminar_menu_modelo($id){
            $sql = mainModel::conectar()->prepare("DELETE FROM menu WHERE id_menu = $id");
            $sql->execute();

            return $sql;
        }
        
    }
?>