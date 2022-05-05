<?php

    require_once "mainModel.php";

    class loginModelo extends mainModel{

         /*----------------Modelo Iniciar Sesion----------------------*/
         protected static function iniciar_sesion_modelo($datos){
            /**----------Comprobando Entrada de Usuario---------- */
            $sql = mainModel::conectar()->prepare("SELECT * FROM usuarios WHERE usuario_usuario=:Usuario AND usuario_clave=:Clave AND usuario_estado='Activa'");
            $sql->bindParam(":Usuario", $datos['Usuario']);
            $sql->bindParam(":Clave", $datos['Clave']);
            $sql->execute();

            /**----------Comprobando Entrada de Doctor---------- */
            if($sql->rowCount() <= 0){
               $sql = mainModel::conectar()->prepare("SELECT * FROM doctores WHERE usuario = :Usuario AND pass = :Clave");
               $sql->bindParam(":Usuario", $datos['Usuario']);
               $sql->bindParam(":Clave", $datos['Clave']);
               $sql->execute();
               
               /**----------Comprobando Entrada de Cliente---------- */
               if($sql->rowCount() <= 0){
                  $sql = mainModel::conectar()->prepare("SELECT * FROM clientes WHERE usuario = :Usuario AND pass = :Clave");
                  $sql->bindParam(":Usuario", $datos['Usuario']);
                  $sql->bindParam(":Clave", $datos['Clave']);
                  $sql->execute();
               }
            }
            
            return $sql;
         }
    }