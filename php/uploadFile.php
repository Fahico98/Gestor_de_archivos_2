<?php

   include("connection.php");

   if(isset($_FILES["filesArray"])){
      $filesArray = $_FILES["filesArray"];
      $fileName = basename($filesArray["name"][0]);
      $fileTempName = $filesArray["tmp_name"][0];
      $fileSize = $filesArray["size"][0];
      $fileErrors = $filesArray["error"][0];
      $newFileName = $_POST["fileNameInput"];
      $fileSection = $_POST["section"];
      $tableName = $_POST["tableName"];
      $currentFilePath = dirname(__FILE__);
      $buffer = explode(".", $fileName);
      $fileType = end($buffer);
      $relFilePath = "../$tableName/$fileName";
      $absFilePath = str_replace("php", "", $currentFilePath) . "$tableName\\$fileName";
      $newAbsFilePath = str_replace($fileName, $newFileName, $absFilePath);
      $status = ($fileErrors > 0) ? "error" : "success";
      $respose = "uploadSuccessfull";
      if($status === "success"){
         $respose = (file_exists($newAbsFilePath)) ? "existingFile" : "uploadSuccessfull";
         if($respose === "uploadSuccessfull"){
            move_uploaded_file($fileTempName, $absFilePath);
            saveFile($tableName, $newFileName, $fileType, $newAbsFilePath, $fileSize, $fileSection);
            if($fileName !== $newFileName){
               rename($absFilePath, $newAbsFilePath);
            }
         }
      }
      exit($respose);
   }

   function saveFile($tableName, $fileName, $fileType, $filePath, $fileSize, $fileSection){
      try{
         global $db_name;
         $pdo = connect();
         $query = "USE $db_name";
         $pdo->query($query);
         $query = 
            "INSERT INTO $tableName (
               nombre,
               tipo,
               ruta,
               tamaño,
               seccion
            ) VALUES (
               :fileName,
               :fileType,
               :filePath,
               :fileSize,
               :fileSection
            )";
         $result = $pdo->prepare($query);
         $result->bindValue(":fileName", $fileName);
         $result->bindValue(":fileType", $fileType);
         $result->bindValue(":filePath", $filePath);
         $result->bindValue(":fileSize", $fileSize);
         $result->bindValue(":fileSection", $fileSection);
         $result->execute();
         $pdo = null;
      }catch(Exception $e){
         die("ERROR: " . $e->getMessage());
      }
   }
?>