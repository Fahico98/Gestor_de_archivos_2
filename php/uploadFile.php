<?php

   include("trGenerator.php");

   if(isset($_FILES["filesArray"])){
      $response = "";
      $filesArray = $_FILES["filesArray"];
      $currentFilePath = dirname(__FILE__);
      for($i = 0; $i < sizeof($filesArray["name"]); $i++){
         $fileTempName = $filesArray["tmp_name"][$i];
         $fileName = basename($filesArray["name"][$i]);
         $fileSize = $filesArray["size"][$i];
         $fileErrors = $filesArray["error"][$i];
         $buffer = explode(".", $fileName);
         $fileType = end($buffer);
         $relFilePath = "../uploads/$fileName";
         $absFilePath = str_replace("php", "", $currentFilePath) . "uploads\\$fileName";
         $status = fileValidation($relFilePath, $fileSize, $fileErrors);
         if($status === ""){
            move_uploaded_file($fileTempName, $relFilePath);
            saveFile($fileName, $fileType, $absFilePath, $fileSize);
            $response .= generateTR($fileName);
         }else{
            $response .= generateTR($fileName, $fileType, $status);
         }
      }
      exit($response);
   }

   function fileValidation($filePath, $fileSize, $fileErrors){
      $output = "";
      if(file_exists($filePath)){
         $output = "exists";
      }else if($fileSize > 10000000){
         $output = "sizeExceeded";
      }else if($fileErrors > 0){
         $output = "error";
      }
      return($output);
   }

   function saveFile($fileName, $fileType, $filePath, $fileSize){
      try{
         global $db_name, $table_name;
         $pdo = connect();
         $query = "USE $db_name";
         $pdo->query($query);
         $query = 
            "INSERT INTO $table_name (
               nombre,
               tipo,
               ruta,
               tamaño
            ) VALUES (
               :fileName,
               :fileType,
               :filePath,
               :fileSize
            )";
         $result = $pdo->prepare($query);
         $result->bindValue(":fileName", $fileName);
         $result->bindValue(":fileType", $fileType);
         $result->bindValue(":filePath", $filePath);
         $result->bindValue(":fileSize", $fileSize);
         $result->execute();
         $pdo = null;
      }catch(Exception $e){
         die("ERROR: " . $e->getMessage());
      }
   }
?>