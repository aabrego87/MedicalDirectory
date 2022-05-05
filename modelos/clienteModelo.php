<?php
    require_once "mainModel.php";

    class clienteModelo extends mainModel{
        /**----------Agregar Cliente Modelo---------- */
        protected static function agregar_cliente_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO clientes 
                (nombre_cliente, apellido_p_cliente, apellido_m_cliente, edad, direccion, telefono, tipo_sangre, no_tarjeta, paypal, email, usuario, pass, privilegio, imagen) 
                VALUES (:Nombre, :ApellidoP, :ApellidoM, :Edad, :Direccion, :Telefono, :Sangre, :Tarjeta, :Paypal, :Email, :Usuario, :Pass, :Privilegio, :Imagen)");
            $sql->bindParam(":Nombre", $datos['Nombre']);
            $sql->bindParam(":ApellidoP", $datos['ApellidoP']);
            $sql->bindParam(":ApellidoM", $datos['ApellidoM']);
            $sql->bindParam(":Edad", $datos['Edad']);
            $sql->bindParam(":Direccion", $datos['Direccion']);
            $sql->bindParam(":Telefono", $datos['Telefono']);
            $sql->bindParam(":Sangre", $datos['Sangre']);
            $sql->bindParam(":Tarjeta", $datos['Tarjeta']);
            $sql->bindParam(":Paypal", $datos['Paypal']);
            $sql->bindParam(":Email", $datos['Email']);
            $sql->bindParam(":Usuario", $datos['Usuario']);
            $sql->bindParam(":Pass", $datos['Pass']);
            $sql->bindParam(":Privilegio", $datos['Privilegio']);
            $sql->bindParam(":Imagen", $datos['Imagen']);
            $sql->execute();

            return $sql;
        }

        /**----------Obtener Tipos de Sangre Modelo---------- */
        public static function obtener_tipos_sangre_modelo(){
            $sql = mainModel::conectar()->prepare("SELECT * FROM tipo_sangre");
            $sql->execute();

            $resultado = $sql->fetchAll();
            
            return $resultado;
        }

        /**----------Datos Cliente Modelo---------- */
        protected static function datos_cliente_modelo($tipo, $id){
            if($tipo == 'Unico'){
                $sql = mainModel::conectar()->prepare("SELECT * FROM clientes WHERE id_cliente = $id");
            }else if($tipo == 'Conteo'){
                $sql = mainModel::conectar()->prepare("SELECT id_cliente FROM clientes");
            }

            $sql->execute();

            return $sql;
        }

        /**----------Actualizar Cliente Modelo---------- */
        protected static function actualizar_cliente_modelo($datos){
            $sql = mainModel::conectar()->prepare("UPDATE clientes SET 
                nombre_cliente = :Nombre, apellido_p_cliente = :ApellidoP, apellido_m_cliente = :ApellidoM, edad = :Edad, direccion = :Direccion, telefono = :Telefono, tipo_sangre = :Sangre, no_tarjeta = :Tarjeta, paypal = :Paypal, email = :Email, usuario = :Usuario, pass = :Clave WHERE id_cliente = :ID");
            $sql->bindParam(":Nombre", $datos['Nombre']);
            $sql->bindParam(":ApellidoP", $datos['ApellidoP']);
            $sql->bindParam(":ApellidoM", $datos['ApellidoM']);
            $sql->bindParam(":Edad", $datos['Edad']);
            $sql->bindParam(":Direccion", $datos['Direccion']);
            $sql->bindParam(":Telefono", $datos['Telefono']);
            $sql->bindParam(":Sangre", $datos['Sangre']);
            $sql->bindParam(":Tarjeta", $datos['Tarjeta']);
            $sql->bindParam(":Paypal", $datos['Paypal']);
            $sql->bindParam(":Email", $datos['Email']);
            $sql->bindParam(":Usuario", $datos['Usuario']);
            $sql->bindParam(":Clave", $datos['Clave']);
            $sql->bindParam(":ID", $datos['ID']);
            $sql->execute();

            return $sql;
        }

        /**----------Eliminar Cliente Modelo---------- */
        protected static function eliminar_cliente_modelo($id){
            $sql = mainModel::conectar()->prepare("DELETE FROM  clientes WHERE id_cliente = $id");
            $sql->execute();

            return $sql;
        }
    }

?>