$(document).ready(function () {

   var signForm = $("#sign-form");
   $(".sign-up").mousedown(function () {
         $(".jumbotron").css("display", "none");
         signForm.css("position", "relative");
         signForm.addClass("slide-down");
   });

   $("login").click(function () {
      $("#login-form").css("visibility", "visible");
   });
});