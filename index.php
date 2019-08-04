
<?php
   include("php/createDatabase.php");
   createDatabase();
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Hemerson Miguel Morales</title>

      <!-- Own CSS -->
      <link rel="stylesheet" href="css/mainStyle.css">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
         integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

      <!-- Font Awesome CSS -->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
         integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
   </head>
   <body>
      <div class="container my-5">
         <div class="col">
            <div class="row d-flex justify-content-center my-4">
               <h2 class="my-4">Gestor de archivos</h2>
            </div>
            <div class="row d-flex justify-content-start">
               <form enctype="multipart/form-data" id="uploadForm" name="uploadForm">
                  <button type="submit" class="btn btn-dark align-center" id="uploadButton">Cargar archivo</button>
                  <input type="file" class="mr-sm-2" id="fileInput" name="filesArray[]" multiple>
               </form>
            </div>
            <div class="row d-flex justify-content-start mt-2">
               <p id="wrongExtensionLabel"></p>
            </div>
            <div class="row d-flex justify-content-center">
               <table class="table table-hover mt-2">
                  <thead>
                     <tr>
                        <th scope="col" class="text-center col1">Id</th>
                        <th scope="col" class="col2">Extención</th>
                        <th scope="col" class="col3">Nombre</th>
                        <th scope="col" class="col4">Ruta</th>
                        <th scope="col" class="text-center col5">Fecha de creación</th>
                        <th scope="col" class="text-center col5">Ultima modificación</th>
                        <th scope="col" class="text-center col5">Creado por</th>
                        <th scope="col" class="text-center col5">Modificado por</th>
                        <th scope="col" class="text-center col6"></th>
                     </tr>
                  </thead>
                  <tbody id="tableBody"></tbody>
               </table>
            </div>
         </div>
      </div>

      <!-- jQuery Script -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" language="JavaScript" type="text/javascript"></script>
      
      <!-- Bootstrap Scripts -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
         integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
         integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

      <!-- jQuery file upload plugin scripts -->
      <script src="javascript/jQuery_file_upload_plugin/vendor/jquery.ui.widget.js" language="JavaScript" type="text/javascript"></script>
      <script src="javascript/jQuery_file_upload_plugin/jquery.iframe-transport.js" language="JavaScript" type="text/javascript"></script>
      <script src="javascript/jQuery_file_upload_plugin/jquery.fileupload.js" language="JavaScript" type="text/javascript"></script>

      <!-- Own Script -->
      <script src="javascript/mainScript.js"></script>
   </body>
</html>