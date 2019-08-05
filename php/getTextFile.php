
<?php

   try{
      if(isset($_POST["fileName"])){
         $fileName = $_POST["fileName"];
         $currentFilePath = dirname(__FILE__);
         $absFilePath = str_replace("php", "", $currentFilePath) . "uploads\\$fileName";
         $fileManager = fopen($absFilePath, "r");
         $fileContent = fread($fileManager, filesize($absFilePath));
         fclose($fileManager);
         echo($fileContent);
      }
   }catch(Exception $e){
      die("ERROR: " . $e->getMessage());
   }

?>
