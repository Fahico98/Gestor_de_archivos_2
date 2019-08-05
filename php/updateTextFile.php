
<?php

   try{
      if(isset($_POST["fileName"])){
         $fileName = $_POST["fileName"];
         $content = $_POST["content"];
         $currentFilePath = dirname(__FILE__);
         $absFilePath = str_replace("php", "", $currentFilePath) . "uploads\\$fileName";
         $fileManager = fopen($absFilePath, "w");
         fwrite($fileManager, $content);
         fclose($fileManager);
      }
   }catch(Exception $e){
      die("ERROR: " . $e->getMessage());
   }

?>
