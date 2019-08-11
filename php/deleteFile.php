
<?php

   include("connection.php");

   try{
      if(isset($_POST["fileName"]) && isset($_POST["tableName"])){
         $pdo = connect();
         $query = "USE $db_name";
         $pdo->query($query);
         $fileName = $_POST["fileName"];
         $tableName = $_POST["tableName"];
         $query = "DELETE FROM $tableName WHERE nombre = '$fileName'";
         $pdo->query($query);
         $pdo = null;
         unlink("../$tableName/$fileName");
      }
   }catch(Exception $e){
      die("ERROR: " . $e->getMessage());
   }

?>
