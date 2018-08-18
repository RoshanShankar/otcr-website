$(document).ready(function(){
  $(".end").click(function() {
    $.ajax ({
      var clickBtnValue = $(this).val();
      var ajaxurl = 'contactform/DriveAPI/upload_resume.php',

      $.get('ajaxurl', function(data) {
       eval(data);
    });
  });


  });

  $(".form-wrapper .button").click(function(){
    var button = $(this);
    var currentSection = button.parents(".section");
    var currentSectionIndex = currentSection.index();
    var headerSection = $('.steps li').eq(currentSectionIndex);
    currentSection.removeClass("is-active").next().addClass("is-active");
    headerSection.removeClass("is-active").next().addClass("is-active");

    $(".form-wrapper").submit(function(e) {
      e.preventDefault();
    });

    if(currentSectionIndex === 3){
      $(document).find(".form-wrapper .section").first().addClass("is-active");
      $(document).find(".steps li").first().addClass("is-active");
    }
  });

  $(".prev_button").click(function() {
    var button = $(this);
    var currentSection = button.parents(".section");
    var currentSectionIndex = currentSection.index();
    var headerSection = $('.steps li').eq(currentSectionIndex);
    currentSection.removeClass("is-active").prev().addClass("is-active");
    headerSection.removeClass("is-active").prev().addClass("is-active");

    if(currentSectionIndex === 0){
      $(document).find(".form-wrapper .section").last().addClass("is-active");
      $(document).find(".steps li").last().addClass("is-active");
    }
  });
});
