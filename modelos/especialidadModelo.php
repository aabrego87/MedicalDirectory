<?php 
    require_once "mainModel.php";

    class especialidadModelo extends mainModel{
        /**----------Agregar Especialidad Modelo---------- */
        protected static function agregar_especialidad_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO especialidades (especialidad) VALUES (:Especialidad)");
            $sql->bindParam(":Especialidad", $datos['Especialidad']);
            $sql->execute();

            return $sql;
        }

        /**----------Datos Especialidad Modelo---------- */
        protected static function datos_especialidades_modelo($tipo, $id){
            if($tipo == "Unico"){
                $sql = mainModel::conectar()->prepare("SELECT * FROM especialidades WHERE id_especialidad = $id");
            }else if($tipo == "Conteo"){
                $sql = mainModel::conectar()->prepare("SELECT id_epecialidad FROM especialidades");
            }
            $sql->execute();

            return $sql;
        }

        /**----------Actualizar Especialidad Modelo---------- */
        protected static function actualizar_especialidad_modelo($datos){
            $sql = mainModel::conectar()->prepare("UPDATE especialidades SET especialidad = :Especialidad WHERE id_especialidad = :ID");
            $sql->bindParam(":Especialidad", $datos['Especialidad']);
            $sql->bindParam(":ID", $datos['ID']);
            $sql->execute();

            return $sql;
        }

        /**----------Obtener Especialidades Modelo---------- */
        public static function obtener_especialidades_modelo(){
            $sql = mainModel::conectar()->prepare("SELECT * FROM especialidades");
            $sql->execute();

            $resultado = $sql->fetchAll();

            return $resultado;
        }
    }

?>