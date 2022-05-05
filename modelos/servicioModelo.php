<?php
    require_once "mainModel.php";

    class servicioModelo extends mainModel{
        /**----------Agregar Servicio Modelo---------- */
        protected static function agregar_servicio_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO servicios (nombre_servicio, descripcion, precio, imagen, id_doctor, id_especialidad) 
                VALUES (:Nombre, :Descripcion, :Precio, :Imagen, :Doctor, :Especialidad)");
            $sql->bindParam(":Nombre", $datos['Nombre']);
            $sql->bindParam(":Descripcion", $datos['Descripcion']);
            $sql->bindParam(":Precio", $datos['Precio']);
            $sql->bindParam(":Imagen", $datos['Imagen']);
            $sql->bindParam(":Doctor", $datos['Doctor']);
            $sql->bindParam(":Especialidad", $datos['Especialidad']);
            $sql->execute();

            return $sql;

        }/**----------Fin del Modelo---------- */

        /**----------Obtener Especialidades Modelo---------- */
        public static function obtener_especialidades_modelo(){
            $sql = mainModel::conectar()->prepare("SELECT * FROM especialidades");
            $sql->execute();

            $resultado = $sql->fetchAll();

            return $resultado;
        }
        
        /**----------Obtener Doctores Modelo---------- */
        public static function obtener_doctores_modelo(){
            $sql = mainModel::conectar()->prepare("SELECT * FROM doctores");
            $sql->execute();

            $resultado = $sql->fetchAll();

            return $resultado;
        }

        /**---------Datos Servicio Modelo---------- */
        protected static function datos_servicio_modelo($tipo, $id){
            if($tipo == 'Unico'){
                $sql = mainModel::conectar()->prepare("SELECT *, especialidades.id_especialidad, especialidades.especialidad FROM servicios INNER JOIN especialidades ON especialidades.id_especialidad = servicios.id_especialidad WHERE id_servicio = $id");
            }else if($tipo = 'Conteo'){
                $sql = mainModel::conectar()->prepare("SELECT * FROM servicios");
            }
            $sql->execute();

            return $sql;
        }

        /**----------Actualizar Servicio Modelo---------- */
        protected static function actualizar_servicio_modelo($datos){
            $sql = mainModel::conectar()->prepare("UPDATE servicios SET nombre_servicio = :Nombre, descripcion = :Descripcion, precio = :Precio, id_especialidad = :Especialidad WHERE id_servicio = :ID");
            $sql->bindParam(":Nombre", $datos['Nombre']);
            $sql->bindParam(":Descripcion", $datos['Descripcion']);
            $sql->bindParam(":Precio", $datos['Precio']);
            $sql->bindParam(":Especialidad", $datos['Especialidad']);
            $sql->bindParam(":ID", $datos['ID']);
            $sql->execute();

            return $sql;
        }

        /**----------Eliminar Servicio Modelo---------- */
        protected static function eliminar_servicio_modelo($id){
            $sql = mainModel::conectar()->prepare("DELETE FROM servicios WHERE id_servicio = $id");
            $sql->execute();

            return $sql;
        }
    }

?>