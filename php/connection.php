<?php

   $db_host = "localhost";
   $db_name = "hemerson_database";
   $db_userName = "root";
   $db_password = "";
   $dns = "mysql:host=$db_host;charset=utf8";

   function connect(){
      try{
         global $dns, $db_userName, $db_password;
         $pdo = new PDO($dns, $db_userName, $db_password);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch(Exception $e){
         die("ERROR: " . $e->getMessage());
      }
      return $pdo;
   }

?>