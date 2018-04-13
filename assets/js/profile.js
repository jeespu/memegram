function updateUsername(){
  var newUserName = $("input[name='username']").val();
  $.post( "updateUsername.php", {uusikayttajanimi : newUserName}, console.log("Success!"));
}

function updateFirstName(){
  var newFirstName = $("input[name='firstname']").val();
  $.post( "updateFirstName.php", {uusietunimi : newFirstName}, console.log("Success!"));
}

function updateLastname(){
  var newLastName = $("input[name='lastname']").val();
  $.post( "updateLastName.php", {uusisukunimi : newLastName}, console.log("Success!"));
}

function updateEmail(){
  var newEmail = $("input[name='email']").val();
  $.post( "updateEmail.php", {uusiemail : newEmail}, console.log("Success!"));
}

function postProfilePic(){
  var newProfilePic = $("input[name='profilePicField']").val();
  $.post( "updateProfilePic.php", {uusikuva : newProfilePic}, console.log("Success!"));
}
