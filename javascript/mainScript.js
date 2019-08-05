
var fileInput = $("#fileInput");
var wrongExtensionLabel = $("#wrongExtensionLabel");
var uploadForm = $("#uploadForm");
var tableBody = $("#tableBody");
var deleteButton = $(".deleteButton");
var modalTitle = $("#modalTitle");
var buttonTriggerModal = $("#buttonTriggerModal");
var fileContent = $("#fileContent");
var saveChangesButton = $("#saveChangesButton");
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
   uploadForm.on("submit", function(event){
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
   if(allowedExtensions.includes(extension)){
      wrongExtensionLabel.text("");
      return true;
   }else{
      wrongExtensionLabel.text("No está permitido cargar archivos con extensión ." + extension);
      return false;
   }
}
