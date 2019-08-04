
var fileInput = $("#fileInput");
var wrongExtensionLabel = $("#wrongExtensionLabel");
var uploadForm = $("#uploadForm");
var tableBody = $("#tableBody");
var deleteButton = $(".deleteButton");
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
      var strArray = fileInput.val().split("\\");
      var fileName = strArray[strArray.length - 1];
      var validExtension = validateExtension(fileName);
      if(fileInput.val() !== "" && validExtension){
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
      wrongExtensionLabel.text("No se está permitido cargar archivos con extensión ." + extension);
      return false;
   }
}
