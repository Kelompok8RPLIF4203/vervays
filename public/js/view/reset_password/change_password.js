$("#changePasswordForm").submit(function(e) {
  if ($("#password").val() === $("#repassword").val()) {
    $("#changePasswordForm").submit();
  }
  else {
    e.preventDefault();
    $("#repasswordHelp").removeClass("d-none");
  }
});

$("#repassword").keyup(function() {
  if ($("#password").val() != $("#repassword").val()) {
    $("#repasswordHelp").removeClass("d-none");
  }
  else {
    $("#repasswordHelp").addClass("d-none");
  }
});