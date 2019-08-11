
<?php

   try{
      if(isset($_POST["fileName"]) && isset($_POST["tableName"])){
         $fileName = $_POST["fileName"];
         $tableName = $_POST["tableName"];
         $currentFilePath = dirname(__FILE__);
         $absFilePath = str_replace("php", "", $currentFilePath) . "$tableName\\$fileName";
         $fileManager = fopen($absFilePath, "r");
         $fileContent = fread($fileManager, filesize($absFilePath));
         fclose($fileManager);
         echo($fileContent);
      }
   }catch(Exception $e){
      die("ERROR: " . $e->getMessage());
   }

?>
