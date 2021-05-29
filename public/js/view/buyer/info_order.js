$(document).ready(function(){
  setCreatedAtFormat();
  setExpiredTimeFormat();
	setOrderStatus();
	setBookItemOnClickListener();
});

function setCreatedAtFormat() {
	var relaseDate = new Date($('#createdDateInfo').html());
	var date = relaseDate.getDate();
	var month = relaseDate.getMonth()+1;
  month = getMonthInBahasa(month);
  var year = relaseDate.getFullYear();
  $('#createdDateInfo').html(date+" "+month+" "+year);
}

function setExpiredTimeFormat() {
	var relaseDate = new Date($('#expiredDateInfo').html());
	var date = relaseDate.getDate();
	var month = relaseDate.getMonth()+1;
  month = getMonthInBahasa(month);
  var year = relaseDate.getFullYear();
  $('#expiredDateInfo').html(date+" "+month+" "+year);
  var expiredTime = $("#expiredTimeInfo").html().substring(0, 5);
  $("#expiredTimeInfo").html(expiredTime);
}

function getMonthInBahasa(intMonth) {
  switch(intMonth) {
    case 1 : return "Januari";
    case 2 : return "Februari";
    case 3 : return "Maret";
    case 4 : return "April";
    case 5 : return "Mei";
    case 6 : return "Juni";
    case 7 : return "Juli";
    case 8 : return "Agustus";
    case 9 : return "September";
    case 10 : return "Oktober";
    case 11 : return "November";
    case 12 : return "Desember";
  }
}

function setOrderStatus() {
	let status = $("#order-status-info").html();
	if (status === "pending") {
		$("#order-status-info").html("Menunggu pembayaran");
	}
	else if (status === "success") {
    $("#order-status-info").html("Selesai");
    $(".expiredTimeInfo").hide();
	}
	else {
    $("#order-status-info").html("Gagal");
    $(".expiredTimeInfo").hide();
	}
}

function setBookItemOnClickListener() {
	$(".book-item").click(function() {
		var bookId = $(this).attr("data-book-id");
		var title = $("#book-item-"+bookId+" .title").html();
		title = string_to_slug(title);
		window.location.href = "/book/detail/"+bookId+"/"+title;
	});
}