
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
var saveChangesButton = $("#saveChangesButton");
var buttonDropdown1 = $("#buttonDropdown1");
var buttonDropdown2 = $("#buttonDropdown2");
var buttonDropdown3 = $("#buttonDropdown3");
var optionsDropdown2 = $("#optionsDropdown2");
var optionsDropdown3 = $("#optionsDropdown3");
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
   getDatabase();
   $(document).on("change", "#fileInput", function(event){
      event.preventDefault();
      var strArray = $(this).val().split("\\");
      var fileName = strArray[strArray.length - 1];
      strArray = fileName.split(".");
      var fileExtension = strArray[strArray.length - 1];
      if(validateExtension(fileName)){
         fileInputHelp.text("Recuerde que solo puede cargar un archivo a la vez.");
         fileInputHelp.addClass("text-muted");
         fileInputHelp.css("color", "rgb(108, 117, 125)");
         fileNameInput.val(fileName);
         fileNameInput.attr("disabled", false);
         submitButton.attr("disabled", false);
      }else{
         fileInputHelp.text("No esta permitido cargar archivos con estensión " + fileExtension + ".");
         fileInputHelp.removeClass("text-muted");
         fileInputHelp.css("color", "red");
      }
   });
   $(document).on("submit", "#uploadForm", function(event){
      event.preventDefault();
      var data = new FormData($(this)[0]);
      if(fileInput.val() !== ""){
         var strArray = fileInput.val().split("\\");
         var fileName = strArray[strArray.length - 1];
         if(validateExtension(fileName)){
            $.ajax({
               type: "POST",
               url: "php/uploadFile.php",
               data: data,
               processData: false,
               contentType: false,
               dataType: "html",
               success: function(response){
                  tableBody.prepend(response);
               }
            });
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
            data: {fileName: fileName},
            success: function(){
               getDatabase();
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
         data: {fileName: fileName},
         success: function(response){
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
            content: content
         }
      });
   });
   $(document).on("click", ".option1", function(event){
      event.preventDefault();
      var value = $(this).val();
      buttonDropdown2.prop("disabled", false);
      buttonDropdown3.prop("disabled", false);
      if(value === "normatividad"){
         buttonDropdown1.text("Normatividad ");
         buttonDropdown2.text("Federal ");
         buttonDropdown3.text("Raiz ");
         optionsDropdown2.html(
            "<option value='federal' class='dropdown-item option2'>Federal</a>" +
            "<option value='estatal' class='dropdown-item option2'>Estatal</a>"
         );
      }else if(value === "conac"){
         buttonDropdown1.text("CONAC ");
         buttonDropdown2.text("Municipal ");
         buttonDropdown3.text(" 1 ");
         optionsDropdown2.html(
            "<option value='municipal' class='dropdown-item option2'>Municipal</a>" +
            "<option value='nacional' class='dropdown-item option2'>Nacional</a>"
         );
      }
   });
   $(document).on("click", ".option2", function(event){
      event.preventDefault();
      var value = $(this).val();
      buttonDropdown3.prop("disabled", false);
      fileInput.prop("disabled", false);
      if(value === "federal"){
         buttonDropdown2.text("Federal");
         buttonDropdown3.text("Raiz ");
         optionsDropdown3.html(
            "<option value='raiz' class='dropdown-item option3'>Raiz</a>" +
            "<option value='salud' class='dropdown-item option3'>Salud</a>"
         );
      }else if(value === "estatal"){
         buttonDropdown2.text("Estatal");
         buttonDropdown3.text(" A ");
         optionsDropdown3.html(
            "<option value='A' class='dropdown-item option3'>A...</a>" +
            "<option value='B' class='dropdown-item option3'>B...</a>"
         );
      }else if(value === "municipal"){
         buttonDropdown2.text("Municipal");
         buttonDropdown3.text(" 1 ");
         optionsDropdown3.html(
            "<option value='1' class='dropdown-item option3'>1...</a>" +
            "<option value='2' class='dropdown-item option3'>2...</a>"
         );
      }else if(value === "nacional"){
         buttonDropdown2.text("Nacional");
         buttonDropdown3.text(" 3 ");
         optionsDropdown3.html(
            "<option value='3' class='dropdown-item option3'>3...</a>" +
            "<option value='4' class='dropdown-item option3'>4...</a>"
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
         buttonDropdown3.text(" A ");
      }else if(value === "B"){
         buttonDropdown3.text(" B ");
      }else if(value === "1"){
         buttonDropdown3.text(" 1 ");
      }else if(value === "2"){
         buttonDropdown3.text(" 2 ");
      }else if(value === "3"){
         buttonDropdown3.text(" 3 ");
      }else if(value === "4"){
         buttonDropdown3.text(" 4 ");
      }
   });
});

function getDatabase(){
   $.ajax({
      type: "POST",
      url: "php/getDatabase.php",
      processData: false,
      contentType: false,
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
