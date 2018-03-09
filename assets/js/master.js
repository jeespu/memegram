$(document).ready(function () {

   var signForm = $("#sign-form");
   $(".sign-up, .cancel-btn").mousedown(function () {
      $("#login-form").slideUp("fast");
      signForm.slideToggle("fast");
   });

   // $("#login").click(function (event) {
   //    $("#login-form").slideDown("fast");
   //    signForm.slideUp("fast");
   //    event.stopPropagation();
   // });
});