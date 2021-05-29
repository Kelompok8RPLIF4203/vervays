var beginResetPassword = new Vue({
  el : "body",
  beforeCreate : function() {
    $("#loader-wrapper").hide();
  },
});

$("#formResetPassword").on("submit", function(e) {
  $("#loader-wrapper").show();
  $("#formResetPassword").submit();
});