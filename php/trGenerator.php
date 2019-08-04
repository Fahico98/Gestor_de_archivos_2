<?php

   include("connection.php");

   function generateTR($fileName, $fileType = "", $status = ""){
      $output = "";
      try{
         global $db_name, $table_name;
         $pdo = connect();
         $query = "USE $db_name";
         $pdo->query($query);
         if($status === ""){
            $query = "SELECT * FROM $table_name WHERE nombre = '$fileName'";
            $result = $pdo->query($query);
            if($result->rowCount() > 0){
               foreach($result as $row){
                  $editLabel = ($row['fecha_edicion'] === "") ? "No se ha editado" : $row['fecha_edicion'];
                  $output .= 
                     "<tr>
                        <th class='text-center col1'>" . $row['id'] . "</th>
                        <td class='col2'>" . generateIcon($row['tipo']) . "&nbsp;&nbsp;" . $row['tipo'] . "</td>
                        <td class='col3'>" . $row['nombre'] . "</td>
                        <td class='col4'>" . $row['ruta'] . "</td>
                        <td class='text-center col5'>" . $row['fecha_creacion'] . "</td>
                        <td class='text-center col5'>" . $editLabel . "</td>
                        <td class='text-center col5'>" . $row['id_usuario_creacion'] . "</td>
                        <td class='text-center col5'>" . $row['id_usuario_edicion'] . "</td>
                        <td class='text-center col6'>
                           <button type='button' class='btn btn-danger deleteButton' name='" . $row['nombre'] . "'>
                              <i class='fas fa-trash-alt fa-xs'></i>
                           </button>
                        </td>
                     </tr>";
               }
            }
         }else{
            $output .=
               "<tr>
                  <th class='text-center'>-</th>
                  <td>" . generateIcon($fileType) . "&nbsp;&nbsp;" . $fileType . "</td>
                  <td>" . $fileName . "</td>
                  <td colspan='6' class='errorLabel'>" . generateErrorLabel($status) . "</td>
               </tr>";
         }
      }catch(Exception $e){
         die("ERROR: " . $e->getMessage());
      }
      return($output);
   }

   function generateIcon($fileType){
      $icon = "";
      $pdf = array("pdf");
      $text = array("txt");
      $word = array("dot", "docx", "docm", "doc", "dotx");
      $powerPoint = array("pptx", "ppt", "pptm");
      $video = array("wmv", "mpg", "mkv", "mp4", "avi");
      $image = array("jpg", "jpeg", "png", "gif");
      if(in_array($fileType, $pdf)){
         $icon = "<i class='fas fa-file-pdf fa-lg pdfFileIcon'></i>";
      }else if(in_array($fileType, $text)){
         $icon = "<i class='fas fa-file-alt fa-lg altFileIcon'></i>";
      }else if(in_array($fileType, $word)){
         $icon = "<i class='fas fa-file-word fa-lg wordFileIcon'></i>";
      }else if(in_array($fileType, $powerPoint)){
         $icon = "<i class='fas fa-file-powerpoint fa-lg pptFileIcon'></i>";
      }else if(in_array($fileType, $video)){
         $icon = "<i class='fas fa-file-video fa-lg videoFileIcon'></i>";
      }else if(in_array($fileType, $image)){
         $icon = "<i class='fas fa-file-image fa-lg imageFileIcon'></i>";
      }
      return($icon);
   }

   function generateErrorLabel($status){
      if($status === "exists"){
         $output = "El archivo ya existe...";
      }else if($status === "sizeExceeded"){
         $output = "El archivo exede el tamaño permitido (10MB)";
      }else if($status === "error"){
         $output = "Ocurrió un error al intentar cargar el archivo...";
      }
      return($output);
   }
?>