
var fileInput = $("#fileInput");
var wrongExtensionLabel = $("#wrongExtensionLabel");
var uploadForm = $("#uploadForm");
var submitButton = $("#submitButton");
var tableBody = $("#tableBody");
var deleteButton = $(".deleteButton");
var modalTitle = $("#modalTitle");
var buttonTriggerModal = $("#buttonTriggerModal");
var fileContent = $("#fileContent");
var fileInputHelp = $("#fileInputHelp");
var fileNameInput = $("#fileNameInput");
var fileNameInputHelp = $("#fileNameInputHelp");
var saveChangesButton = $("#saveChangesButton");
var buttonDropdown1 = $("#buttonDropdown1");
var buttonDropdown2 = $("#buttonDropdown2");
var buttonDropdown3 = $("#buttonDropdown3");
var optionsDropdown2 = $("#optionsDropdown2");
var optionsDropdown3 = $("#optionsDropdown3");
var tableSelectorButton = $("#tableSelectorButton");
var expirationDate = $("#expirationDate");
var expirationDateHelp = $("#expirationDateHelp");
var expirationDateAcepted = false;
var tableSelected = "normatividad";
var allowedExtensions =
   [
      "pdf",
      "txt",
      "dot",
      "docx",
      "docm",
      "doc",
      "dotx",
      "pptx",
      "ppt",
      "pptm",
      "wmv",
      "mpg",
      "mkv",
      "mp4",
      "avi",
      "jpg",
      "jpeg",
      "png",
      "gif"
   ];

$(document).ready(function(event){
   getDatabase("normatividad");
   $(document).on("change", "#fileInput", function(event){
      event.preventDefault();
      if($(this).val() !== ""){
         var strArray = $(this).val().split("\\");
         var fileName = strArray[strArray.length - 1];
         strArray = fileName.split(".");
         var fileExtension = strArray[strArray.length - 1];
         var fileSize = this.files[0].size;
         if(validateExtension(fileName)){
            if(fileSize <= 10000000){
               fileInputHelp.text("Recuerde que solo puede cargar un archivo a la vez.");
               fileInputHelp.addClass("text-muted");
               fileInputHelp.css("color", "rgb(108, 117, 125)");
               fileNameInput.val(fileName);
               fileNameInput.attr("disabled", false);
               expirationDate.attr("disabled", false);
               submitButton.attr("disabled", false);
            }else{
               fileInputHelp.text("No esta permitido cargar archivos cuyo tamañao sea mayor a 10MB.");
               fileInputHelp.removeClass("text-muted");
               fileInputHelp.css("color", "red");
               fileNameInput.val("(Ninguno)");
               fileNameInput.prop("disabled", true);
               expirationDate.attr("disabled", true);
               submitButton.prop("disabled", true);
            }
         }else{
            fileInputHelp.text("No esta permitido cargar archivos con extensión " + fileExtension + ".");
            fileInputHelp.removeClass("text-muted");
            fileInputHelp.css("color", "red");
            fileNameInput.val("(Ninguno)");
            fileNameInput.prop("disabled", true);
            expirationDate.attr("disabled", true);
            submitButton.prop("disabled", true);
         }
      }else{
         fileInputHelp.text("Recuerde que solo puede cargar un archivo a la vez.");
         fileInputHelp.addClass("text-muted");
         fileInputHelp.css("color", "rgb(108, 117, 125)");
      }
   });
   $(document).on("submit", "#uploadForm", function(event){
      event.preventDefault();
      if(fileInput.val() !== ""){
         var strArray = fileInput.val().split(".");
         var realExtension = strArray[strArray.length - 1];
         var strArray = fileNameInput.val().split(".");
         var newExtension = strArray[strArray.length - 1];
         if(realExtension === newExtension){
            if(expirationDateAcepted){
               fileNameInputHelp.text("Puede cambiar el nombre del archivo si así lo desea.");
               fileNameInputHelp.addClass("text-muted");
               fileNameInputHelp.css("color", "rgb(108, 117, 125)");
               formData = new FormData(this);
               formData.append("tableName", getTableName());
               formData.append("section", buttonDropdown1.text() + buttonDropdown2.text() + buttonDropdown3.text());
               $.ajax({
                  type: "POST",
                  url: "php/uploadFile.php",
                  data: formData,
                  dataType: "html",
                  contentType: false,
                  cache: false,
                  processData:false,
                  success: function(response){
                     if(response === "existingFile"){
                        fileInputHelp.text("El nombre del archivo que intenta cargar ya existe en la base de datos.");
                        fileInputHelp.removeClass("text-muted");
                        fileInputHelp.css("color", "red");
                     }else if(response === "uploadSuccessfull"){
                        if(getTableName() === "normatividad"){
                           tableSelectorButton.text("Normatividad ");
                           tableSelected = "normatividad";
                        }else if(getTableName() === "conac"){
                           tableSelectorButton.text("CONAC ");
                           tableSelected = "conac";
                        }
                        fileInputHelp.text("Recuerde que solo puede cargar un archivo a la vez.");
                        fileInputHelp.addClass("text-muted");
                        fileInputHelp.css("color", "rgb(108, 117, 125)");
                        expirationDateHelp.addClass("text-muted");
                        expirationDateHelp.css("color", "rgb(108, 117, 125)");
                        getDatabase(getTableName());
                     }
                  }
               });
            }
         }else{
            fileNameInputHelp.text("La extensión que acompaña al nuevo nombre del archivo no corresponde con su extensión real.");
            fileNameInputHelp.removeClass("text-muted");
            fileNameInputHelp.css("color", "red");
         }
      }
   });
   $(document).on("click", ".deleteButton", function(event){
      event.preventDefault();
      var fileName = $(this).attr("name");
      var x = window.confirm("Esta seguro que desea eliminar este archivo de la base de datos ?");
      if(x){
         $.ajax({
            type: "POST",
            url: "php/deleteFile.php",
            data: {
               fileName: fileName,
               tableName: tableSelected
            }, success: function(){
               getDatabase(tableSelected);
            }
         });
      }
   });
   $(document).on("click", ".editButton", function(event){
      event.preventDefault();
      var fileName = $(this).attr("name");
      modalTitle.text(fileName);
      buttonTriggerModal.trigger("click");
      $.ajax({
         type: "POST",
         url: "php/getTextFile.php",
         data: {
            fileName: fileName,
            tableName: tableSelected
         },success: function(response){
            fileContent.val(response.trim());
         }
      });
   });
   $(document).on("click", "#saveChangesButton", function(event){
      event.preventDefault();
      var content = fileContent.val();
      var fileName = modalTitle.text();
      $.ajax({
         type: "POST",
         url: "php/updateTextfile.php",
         data: {
            fileName: fileName,
            tableName: tableSelected,
            content: content
         }
      });
   });
   $(document).on("click", ".option1", function(event){
      event.preventDefault();
      var value = $(this).val();
      fileInput.prop("disabled", false);
      buttonDropdown2.prop("disabled", false);
      buttonDropdown3.prop("disabled", false);
      if(value === "normatividad"){
         buttonDropdown1.text("Normatividad ");
         buttonDropdown2.text("Federal ");
         buttonDropdown3.text("Raiz ");
         optionsDropdown2.html(
            "<option value='federal' class='dropdown-item option2'>Federal</option>" +
            "<option value='estatal' class='dropdown-item option2'>Estatal</option>"
         );
         optionsDropdown3.html(
            "<option value='raiz' class='dropdown-item option3'>Raiz</option>" +
            "<option value='salud' class='dropdown-item option3'>Salud</option>"
         );
      }else if(value === "conac"){
         buttonDropdown1.text("CONAC ");
         buttonDropdown2.text("Municipal ");
         buttonDropdown3.text("1 ");
         optionsDropdown2.html(
            "<option value='municipal' class='dropdown-item option2'>Municipal</option>" +
            "<option value='nacional' class='dropdown-item option2'>Nacional</option>"
         );
         optionsDropdown3.html(
            "<option value='1' class='dropdown-item option3'>1...</option>" +
            "<option value='2' class='dropdown-item option3'>2...</option>"
         );
      }
   });
   $(document).on("change", "#expirationDate", function(event){
      event.preventDefault();
      var strArray = $(this).val().split("-");
      var year = parseInt(strArray[0]);
      var month = parseInt(strArray[1]) - 1;
      var day = parseInt(strArray[2]);
      var today = new Date();
      var expirationDateObj = new Date(year, month, day);
      if(today.getTime() > expirationDateObj.getTime()){
         expirationDateHelp.text("La fecha de expiración debe ser posterior al día de hoy.");
         expirationDateHelp.removeClass("text-muted");
         expirationDateHelp.css("color", "red");
         expirationDateAcepted = false;
      }else{
         expirationDateHelp.text("Es obligatirio establecer una fecha de vencimiento para cada archivo cargado.");
         expirationDateHelp.addClass("text-muted");
         expirationDateHelp.css("color", "rgb(108, 117, 125)");
         expirationDateAcepted = true;
      }
   });
   $(document).on("click", ".option2", function(event){
      event.preventDefault();
      var value = $(this).val();
      buttonDropdown3.prop("disabled", false);
      fileInput.prop("disabled", false);
      if(value === "federal"){
         buttonDropdown2.text("Federal ");
         buttonDropdown3.text("Raiz ");
         optionsDropdown3.html(
            "<option value='raiz' class='dropdown-item option3'>Raiz</option>" +
            "<option value='salud' class='dropdown-item option3'>Salud</option>"
         );
      }else if(value === "estatal"){
         buttonDropdown2.text("Estatal ");
         buttonDropdown3.text("A ");
         optionsDropdown3.html(
            "<option value='A' class='dropdown-item option3'>A...</option>" +
            "<option value='B' class='dropdown-item option3'>B...</option>"
         );
      }else if(value === "municipal"){
         buttonDropdown2.text("Municipal ");
         buttonDropdown3.text("1 ");
         optionsDropdown3.html(
            "<option value='1' class='dropdown-item option3'>1...</option>" +
            "<option value='2' class='dropdown-item option3'>2...</option>"
         );
      }else if(value === "nacional"){
         buttonDropdown2.text("Nacional ");
         buttonDropdown3.text("3 ");
         optionsDropdown3.html(
            "<option value='3' class='dropdown-item option3'>3...</option>" +
            "<option value='4' class='dropdown-item option3'>4...</option>"
         );
      }
   });
   $(document).on("click", ".option3", function(event){
      event.preventDefault();
      var value = $(this).val();
      if(value === "raiz"){
         buttonDropdown3.text("Raiz ");
      }else if(value === "salud"){
         buttonDropdown3.text("Salud ");
      }else if(value === "A"){
         buttonDropdown3.text("A ");
      }else if(value === "B"){
         buttonDropdown3.text("B ");
      }else if(value === "1"){
         buttonDropdown3.text("1 ");
      }else if(value === "2"){
         buttonDropdown3.text("2 ");
      }else if(value === "3"){
         buttonDropdown3.text("3 ");
      }else if(value === "4"){
         buttonDropdown3.text("4 ");
      }
   });
   $(document).on("click", ".optionTableSelector", function(event){
      event.preventDefault();
      tableSelected = $(this).val();
      if(tableSelected === "normatividad"){
         tableSelectorButton.text("Normatividad ");
      }else if(tableSelected === "conac"){
         tableSelectorButton.text("CONAC ");
      }
      getDatabase(tableSelected);
   });
});

function getTableName(){
   if(buttonDropdown1.text() === "Normatividad "){
      var tableName = "normatividad";
   }else if(buttonDropdown1.text() === "CONAC "){
      var tableName = "conac";
   }
   return(tableName);
}

function getDatabase(tableName){
   $.ajax({
      type: "POST",
      url: "php/getDatabase.php",
      data: {tableName: tableName},
      dataType: "html",
      success: function(response){
         tableBody.html(response);
      }
   });
}

function validateExtension(fileName){
   var bufferArray = fileName.split(".");
   var extension = bufferArray[bufferArray.length - 1];
   return(allowedExtensions.includes(extension));
}
