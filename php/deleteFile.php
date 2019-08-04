
<?php

   include("connection.php");

   try{
      //if(isset($_POST["fileName"])){
         global $db_name, $table_name;
         $pdo = connect();
         $query = "USE $db_name";
         $pdo->query($query);
         $fileName = $_POST["fileName"];
         $query = "DELETE FROM $table_name WHERE nombre = '" . $fileName . "'";
         $pdo->query($query);
         $pdo = null;
         unlink("../uploads/$fileName");
      //}else{
      //   echo("***");
      //}
   }catch(Exception $e){
      die("ERROR: " . $e->getMessage());
   }
?>