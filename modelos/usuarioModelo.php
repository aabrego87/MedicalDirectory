<?php
    require_once "mainModel.php";

    class usuarioModelo extends mainModel{
        /*--------------Agregar Usuario---------------------*/
        protected static function agregar_usuario_modelo($datos){
            $sql=mainModel::conectar()->prepare("INSERT INTO usuarios(usuario_nombre,usuario_apellido_p,usuario_apellido_m,usuario_telefono,usuario_direccion,usuario_email,usuario_usuario,usuario_clave,usuario_estado,usuario_privilegio,usuario_imagen) VALUES(:Nombre,:ApellidoP,:ApellidoM,:Telefono,:Direccion,:Email,:Usuario,:Clave,:Estado,:Privilegio,:Imagen)");
            
            $sql->bindParam(":Nombre",$datos['Nombre']);
            $sql->bindParam(":ApellidoP",$datos['ApellidoP']);
            $sql->bindParam(":ApellidoM",$datos['ApellidoM']);
            $sql->bindParam(":Telefono",$datos['Telefono']);
            $sql->bindParam(":Direccion",$datos['Direccion']);
            $sql->bindParam(":Email",$datos['Email']);
            $sql->bindParam(":Usuario",$datos['Usuario']);
            $sql->bindParam(":Clave",$datos['Clave']);
            $sql->bindParam(":Estado",$datos['Estado']);
            $sql->bindParam(":Privilegio",$datos['Privilegio']);
            $sql->bindParam(":Imagen", $datos['Imagen']);
            $sql->execute();
            
            return $sql;
        }

        /**----------Datos Usuario Modelo---------- */
        protected static function datos_usuario_modelo($tipo, $id){
            if($tipo == "Unico"){
                $sql = mainModel::conectar()->prepare("SELECT * FROM usuarios WHERE id_usuario = '$id'");
            }else if($tipo == "Conteo"){
                $sql = mainModel::conectar()->prepare("SELECT id_usuario FROM usuarios");
            }

            $sql->execute();
            
            return $sql;
        }

        /**----------Actualizar Usuario Modelo--------- */
        protected static function actualizar_usuario_modelo($datos){
            $sql = mainModel::conectar()->prepare("UPDATE usuarios 
                SET usuario_nombre = :Nombre,
                usuario_apellido_p = :ApellidoP,
                usuario_apellido_m = :ApellidoM,
                usuario_telefono = :Telefono,
                usuario_direccion = :Direccion,
                usuario_email = :Email,
                usuario_usuario = :Usuario,
                usuario_clave = :Clave,
                usuario_estado = :Estado,
                usuario_privilegio = :Privilegio
                WHERE id_usuario = :ID");
            $sql->bindParam(":Nombre", $datos['Nombre']);
            $sql->bindParam(":ApellidoP", $datos['ApellidoP']);
            $sql->bindParam(":ApellidoM", $datos['ApellidoM']);
            $sql->bindParam(":Telefono", $datos['Telefono']);
            $sql->bindParam(":Direccion", $datos['Direccion']);
            $sql->bindParam(":Email", $datos['Email']);
            $sql->bindParam(":Usuario", $datos['Usuario']);
            $sql->bindParam(":Clave", $datos['Clave']);
            $sql->bindParam(":Estado", $datos['Estado']);
            $sql->bindParam(":Privilegio", $datos['Privilegio']);
            $sql->bindParam(":ID", $datos['ID']);
            $sql->execute();

            return $sql;
        }

        /**----------Eliminar Usuario Modelo---------- */
        protected static function eliminar_usuario_modelo($id){
            $sql = mainModel::conectar()->prepare("DELETE FROM usuarios WHERE id_usuario = $id");
            $sql->execute();

            return $sql;
        }
    }