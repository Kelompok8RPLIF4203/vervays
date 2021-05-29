$(document).ready(function() {
  setBalanceInfoFormat();
  setFormOnSubmitListener();
});

function setBalanceInfoFormat() {
  var balance = $("span.info-balance").html();
  $("span.info-balance").html(convertToRupiah(balance));
}

function redirectToDashboard() {
  window.location.href = "/publisher/dashboard";
}

function setFormOnSubmitListener() {
  $("#form").on("submit", function(event) {
    event.preventDefault();
    $.ajax({
      url : "/publisher/post/cashout",
      method : "POST",
      data : {
        amount : $("#inputAmount").val(),
        bankId : $('#inputBank').val(),
        accountOwner : $("#inputAccountOwner").val()
      },
      success : function(text) {
        console.log(text);
      },
      failed : function(text) {
        console.log(text);
      }
    }).done(function(res) {
      console.log(res);
      redirectToDashboard();
    });
  });
}
