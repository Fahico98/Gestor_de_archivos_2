
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
               <h2 class="my-3">CONAC</h2>
            </div>
            <button id="buttonTriggerModal" style="display: none;" type="button" data-toggle="modal" data-target="#modal">...</button>
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body text-center">
                        <textarea name="fileContent" id="fileContent" cols="60" rows="10"></textarea>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal" id="saveChangesButton">Guardar cambios</button>
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cancelar</button>
                     </div>
                  </div>
               </div>
            </div>
            <div class="justify-content-start">
               <form enctype="multipart/form-data" id="uploadForm" name="uploadForm">
                  <div class="btn-group mx-1">
                     <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" id="buttonDropdown1" name="buttonDropdown1">
                        Tabla
                     </button>
                     <div class="dropdown-menu" id="optionsDropdown1" name="optionsDropdown1">
                        <option value="normatividad" class="dropdown-item option1">Normatividad</a>
                        <option value="conac" class="dropdown-item option1">CONAC</a>
                     </div>
                  </div>
                  <div class="btn-group mx-1">
                     <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false"  id="buttonDropdown2" name="buttonDropdown2" disabled>
                        Opcion 2
                     </button>
                     <div class="dropdown-menu" id="optionsDropdown2" name="optionsDropdown2"></div>
                  </div>
                  <div class="btn-group mx-1">
                     <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" id="buttonDropdown3" name="buttonDropdown3" disabled>
                        Opcion 3
                     </button>
                     <div class="dropdown-menu" id="optionsDropdown3" name="optionsDropdown3"></div>
                  </div>
                  <hr>
                  <div class="form-group m-0">
                     <input type="file" id="fileInput" name="filesArray[]" disabled>
                     <small id="fileInputHelp" class="form-text text-muted">
                        Recuerde que solo puede cargar un archivo a la vez.
                     </small>
                  </div>
                  <hr>
                  <div class="form-group m-0">
                     <label for="fileNameInput">Nombre del archivo</label>
                     <input type="text" class="form-control" id="fileNameInput" name="fileNameInput" placeholder="(Ninguno)" disabled>
                     <small id="fileNameInputHelp" class="form-text text-muted">
                        Puede cambiar el nombre del archivo si así lo desea.
                     </small>
                  </div>
                  <hr>
                  <div class="form-group m-0">
                     <label for="expirationDate">Fecha de vencimiento del archivo</label>
                     <input type="date" class="form-control" name="expirationDate" id="expirationDate" style="width: 50%;" disabled>
                     <small id="expirationDateHelp" class="form-text text-muted">
                        Es obligatirio establecer una fecha de vencimiento para cada archivo cargado.
                     </small>
                  </div>
                  <hr>
                  <div>
                     <button type="submit" class="btn btn-dark align-center" id="submitButton" name="submitButton" disabled>
                        Cargar archivo
                     </button>
                  </div>
               </form>
               <hr>
               <div class="form-group d-flex justify-content-end align-items-center">
                  <div class="btn-group m-0">
                     <button type="button" class="btn btn-outline-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" id="tableSelectorButton" name="tableSelectorButton">
                        Normatividad
                     </button>
                     <div class="dropdown-menu">
                        <option value='normatividad' class='dropdown-item optionTableSelector'>Normatividad</option>
                        <option value='conac' class='dropdown-item optionTableSelector'>CONAC</option>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row d-flex justify-content-center">
               <table class="table table-hover mt-1">
                  <thead class="thead-dark">
                     <tr>
                        <th scope="col" class="text-center col1">Id</th>
                        <th scope="col" class="col2">Extención</th>
                        <th scope="col" class="col3">Nombre</th>
                        <th scope="col" class="col4">Ruta</th>
                        <th scope="col" class="text-center col5">Fecha de creación</th>
                        <th scope="col" class="text-center col5">Fecha de vencimiento</th>
                        <th scope="col" class="text-center col5">Sección</th>
                        <th scope="col" class="text-center col5">Creado por</th>
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

      <!-- Own Script -->
      <script src="javascript/mainScript.js"></script>
   </body>
</html>