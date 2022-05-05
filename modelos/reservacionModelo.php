<?php
    require_once "mainModel.php";

    class reservacionModelo extends mainModel{
        /**----------Datos de Servicio Modelo---------- */
        protected static function datos_servicio_modelo($id){
            $sql = mainModel::conectar()->prepare("SELECT * FROM servicios WHERE id_servicio = $id");
            $sql->execute();

            return $sql;
        }

        /**----------Datos Cliente Modelo---------- */
        protected static function datos_cliente_modelo($id){
            $sql = mainModel::conectar()->prepare("SELECT * FROM clientes WHERE id_cliente = $id");
            $sql->execute();

            return $sql;
        }

        /**----------Datos de Tipo de Visita Modelo--------- */
        public static function datos_visita_modelo(){
            $sql = mainModel::conectar()->prepare("SELECT * FROM visita");
            $sql->execute();

            $resultado = $sql->fetchAll();

            return $resultado;
        }

        /**----------Datos Doctor Modelo--------- */
        protected static function datos_doctor_modelo($id){
            $sql = mainModel::conectar()->prepare("SELECT * FROM doctores WHERE id_doctor = $id");
            $sql->execute();

            return $sql;
        }

        /**----------Agregar Reservacion Modelo---------- */
        protected static function agregar_reservacion_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO reservaciones (id_doctor, id_servicio, id_cliente, id_estatus, id_visita, nota_paciente, fecha_cita, hora_cita)
                VALUES (:Doctor, :Servicio, :Cliente, :Estatus, :Visita, :Nota, :Fecha, :Hora)");
            $sql->bindParam(":Doctor", $datos['Doctor']);
            $sql->bindParam(":Servicio", $datos['Servicio']);
            $sql->bindParam(":Cliente", $datos['Cliente']);
            $sql->bindParam(":Estatus", $datos['Estatus']);
            $sql->bindParam(":Visita", $datos['Visita']);
            $sql->bindParam(":Nota", $datos['Nota']);
            $sql->bindParam(":Fecha", $datos['Fecha']);
            $sql->bindParam(":Hora", $datos['Hora']);
            $sql->execute();

            return $sql;
        }

        /**----------Datos Reservaciones Controlador---------- */
        protected static function datos_reservaciones_modelo($tipo, $id){
            if($tipo == 'Unico'){
                $sql = mainModel::conectar()->prepare("SELECT 
                id_reservacion,
                doctores.nombre_doctor,
                servicios.nombre_servicio,
                servicios.descripcion,
                servicios.precio,
                clientes.nombre_cliente,
                clientes.apellido_p_cliente,
                clientes.apellido_m_cliente,
                clientes.edad,
                clientes.direccion,
                clientes.telefono,
                clientes.email,
                reservaciones.id_estatus,
                estatus.estatus,
                reservaciones.id_visita,
                visita.tipo_visita,
                nota_paciente,
                nota_doctor,
                fecha_cita,
                hora_cita
                FROM reservaciones
                INNER JOIN doctores ON doctores.id_doctor = reservaciones.id_reservacion
                INNER JOIN servicios ON servicios.id_servicio = reservaciones.id_servicio
                INNER JOIN clientes ON clientes.id_cliente = reservaciones.id_cliente
                INNER JOIN estatus ON estatus.id_estatus = reservaciones.id_estatus
                INNER JOIN visita ON visita.id_visita = reservaciones.id_visita 
                WHERE reservaciones.id_reservacion = $id");
            }else if($tipo == 'Conteo'){
                $sql = mainModel::conectar()->prepare("SELECT * FROM reservaciones WHERE id_estatus = 2");
            }
            $sql->execute();

            return $sql;
        }

        /**----------Obtener Estatus Modelo---------- */
        public static function obtener_estatus_modelo(){
            $sql = mainModel::conectar()->prepare("SELECT * FROM estatus");
            $sql->execute();

            $resultado = $sql->fetchAll();

            return $resultado;
        }

        /**----------Actualizar Reservacion Modelo---------- */
        protected static function actualizar_reservacion_modelo($datos){
            $sql = mainModel::conectar()->prepare("UPDATE reservaciones SET id_estatus = :Estatus, nota_doctor = :NotaDoctor, hora_inicio = :HInicio, hora_fin = :HFin WHERE id_reservacion = :ID");
            $sql->bindParam(":Estatus", $datos['Estatus']);
            $sql->bindParam(":NotaDoctor", $datos['NotaDoctor']);
            $sql->bindParam(":HInicio", $datos['HInicio']);
            $sql->bindParam(":HFin", $datos['HFin']);
            $sql->bindParam(":ID", $datos['ID']);
            $sql->execute();

            return $sql;
        }

        /**----------Eliminar Reservaciono Modelo---------- */
        protected static function eliminar_reservacion_modelo($id){
            $sql = mainModel::conectar()->prepare("DELETE FROM reservaciones WHERE id_reservacion = $id");
            $sql->execute();

            return $sql;
        }
    }
?>