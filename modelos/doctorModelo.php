<?php
    
    require_once "mainModel.php";

    class doctorModelo extends mainModel{
        /**----------Agregar Doctor Modelo---------- */
        protected static function agregar_doctor_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO doctores (nombre_doctor, apellido_p_doctor, apellido_m_doctor, nombre_negocio, direccion_consultorio, telefono, descripcion, email, usuario, pass, privilegio, imagen, id_especialidad) 
                VALUES (:Doctor, :ApellidoP, :ApellidoM, :Negocio, :Direccion, :Telefono, :Descripcion, :Email, :Usuario, :Pass, :Privilegio, :Imagen, :Especialidad)");
            $sql->bindParam(":Doctor", $datos['Doctor']);
            $sql->bindParam(":ApellidoP", $datos['ApellidoP']);
            $sql->bindParam(":ApellidoM", $datos['ApellidoM']);
            $sql->bindParam(":Negocio", $datos['Negocio']);
            $sql->bindParam(":Direccion", $datos['Direccion']);
            $sql->bindParam(":Telefono", $datos['Telefono']);
            $sql->bindParam(":Descripcion", $datos['Descripcion']);
            $sql->bindParam(":Email", $datos['Email']);
            $sql->bindParam(":Usuario", $datos['Usuario']);
            $sql->bindParam(":Pass", $datos['Pass']);
            $sql->bindParam(":Privilegio", $datos['Privilegio']);
            $sql->bindParam(":Imagen", $datos['Imagen']);
            $sql->bindParam(":Especialidad", $datos['Especialidad']);
            $sql->execute();

            return $sql;
        }/**----------Fin del Modelo---------- */

        /**----------Obtener Especiaidades Modelo---------- */
        public static function obtener_especialidades_modelo(){
            $sql = mainModel::conectar()->prepare("SELECT * FROM especialidades");
            $sql->execute();

            $resultado = $sql->fetchAll();

            return $resultado;
        }/**----------Fin del Modelo---------- */

        /**----------Datos Doctor Modelo---------- */
        protected static function datos_doctor_modelo($tipo, $id){
            if($tipo == 'Unico'){
                $sql = mainModel::conectar()->prepare("SELECT * FROM doctores WHERE id_doctor = '$id'");
            } else if($tipo == 'Conteo'){
                $sql = mainModel::conectar()->prepare("SELECT id_doctor FROM doctores");
            }
            $sql->execute();

            return $sql;
        }/**----------Fin del Modelo---------- */

        /**----------Actualizar Doctor Controlador---------- */
        protected static function actualizar_doctor_modelo($datos){
            $sql = mainModel::conectar()->prepare("UPDATE doctores
                SET nombre_doctor = :Nombre,
                apellido_p_doctor = :ApellidoP,
                apellido_m_doctor = :ApellidoM,
                nombre_negocio = :Negocio,
                direccion_consultorio = :DirConsultorio,
                telefono = :Telefono,
                email = :Email,
                usuario = :Usuario,
                pass = :Pass 
                WHERE id_doctor = :ID");
            $sql->bindParam(":Nombre", $datos['Nombre']);
            $sql->bindParam(":ApellidoP", $datos['ApellidoP']);
            $sql->bindParam(":ApellidoM", $datos['ApellidoM']);
            $sql->bindParam(":Negocio", $datos['Negocio']);
            $sql->bindParam(":DirConsultorio", $datos['DirConsultorio']);
            $sql->bindParam(":Telefono", $datos['Telefono']);
            $sql->bindParam(":Email", $datos['Email']);
            $sql->bindParam(":Usuario", $datos['Usuario']);
            $sql->bindParam(":Pass", $datos['Pass']);
            $sql->bindParam(":ID", $datos['ID']);
            $sql->execute();

            return $sql;
        }/**----------Fin del Modelo---------- */

        /**----------Eliminar Doctor Controlador---------- */
        protected static function eliminar_doctor_modelo($id){
            $sql = mainModel::conectar()->prepare("DELETE FROM doctores WHERE id_doctor = $id");
            $sql->execute();

            return $sql;
        }
    }

?>