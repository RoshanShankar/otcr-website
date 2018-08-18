function submitFile(){
  var ajaxurl = 'contactform/DriveAPI/upload_resume.php',

  $.get('ajaxurl', function(data) {
     eval(data);
   });
}
