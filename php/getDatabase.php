<?php

   include("connection.php");
   
   $table_name = $_POST["tableName"];
   $output = "";
   $pdo = connect();
   $query = "USE $db_name";
   $pdo->query($query);
   $query = "SELECT * FROM $table_name ORDER BY fecha_creacion DESC";
   $result = $pdo->query($query);
   if($result->rowCount() > 0){
      foreach($result as $row){
         $output .= 
            "<tr>
               <th class='text-center col1'>" . $row['id'] . "</th>
               <td class='col2'>" . generateIcon($row['tipo']) . "&nbsp;&nbsp;" . $row['tipo'] . "</td>
               <td class='col3'>" . $row['nombre'] . "</td>
               <td class='col4'>" . $row['ruta'] . "</td>
               <td class='text-center col5'>" . $row['fecha_creacion'] . "</td>
               <td class='text-center col6'>" . $row['fecha_vencimiento'] . "</td>
               <td class='text-center col7'>" . $row['seccion'] . "</td>
               <td class='text-center col8'>" . $row['id_usuario_creacion'] . "</td>
               <td class='text-center col6'>
                  <i class='fas fa-trash-alt fa-lg deleteButton' name='" . $row['nombre'] . "'></i>";
         if($row['tipo'] === "txt"){
            $output .= "<i class='fas fa-edit fa-lg ml-2 editButton' name='" . $row['nombre'] . "'></i>";
         }
         $output .= "</td></tr>";
      }
      exit($output);
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

?>