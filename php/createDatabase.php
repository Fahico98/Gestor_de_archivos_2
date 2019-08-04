
<?php

   include("connection.php");

   function createDatabase(){
      try{
         global $db_name, $table_name;
         $pdo = connect();
         $query = "CREATE DATABASE IF NOT EXISTS $db_name";
         $pdo->query($query);
         $query = "USE $db_name";
         $pdo->query($query);
         $query = "CREATE TABLE IF NOT EXISTS $table_name (
            id                      INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            nombre                  VARCHAR(100) NOT NULL UNIQUE,
            tipo                    VARCHAR(100) NOT NULL,
            ruta                    VARCHAR(255) NOT NULL,
            tamaño                  INT,
            fecha_creacion          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            fecha_edicion           TIMESTAMP,
            id_usuario_creacion     INT,
            id_usuario_edicion      INT
         )";
         $pdo->query($query);
         $pdo = null;
      }catch(Exception $e){
         die("ERROR: " . $e->getMessage());
      }
   }

?>
