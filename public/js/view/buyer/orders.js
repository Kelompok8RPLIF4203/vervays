$(document).ready(function() {
	setUpOrderCard();
});

function setUpOrderCard() {
	$.ajax({
		url : "http://127.0.0.1:8000/get/get_user_orders_for_orders_page",
		method : "GET"
	}).done(function(data) {
		if (data.length == 0) { // Jika tidak ada pesanan
			setUpExceptionContainer();
		}
		else { // Jika ada pesanan
			setUpMainContainer(data);
		}
	});
}

function setUpExceptionContainer() {
	var kelas = $(".exception-container").attr("class");
	kelas = kelas.replace("d-none", "");
	$(".exception-container").attr("class", kelas);
	$("#btnSearchBook").attr("onclick", "window.location.href = \"/\"");
}

function setUpMainContainer(data) {
	var kelas = $(".main-container").attr("class");
	kelas = kelas.replace("d-none", "");
	$(".main-container").attr("class", kelas);
	showAllOrdersCard(data);
}

function showAllOrdersCard(orders) {
	var template = document.querySelector('#orderCardTemplate');
  var container = document.querySelector(".main-container");
	for (let i = 0; i < orders.length; i++) {
		var clone = template.content.cloneNode(true);
		clone.querySelector(".order-status").innerHTML = orders[i].status;
		clone.querySelector(".date").innerHTML = getFormattedDate(orders[i].created_at);
		clone.querySelector(".order-id").innerHTML = orders[i].id;
		clone.querySelector(".btnLihatDetail").setAttribute("onclick", "window.location.href = \"/info/order/"+orders[i].id+"\"");
		clone.querySelector(".order-card").setAttribute("data-order-id", orders[i].id);
		clone.querySelector(".total-price span").innerHTML = convertToRupiah(orders[i].totalPrice);
		clone.querySelector("div").setAttribute("id", "order-"+orders[i].id);
		clone = setOrderStatus(clone, orders[i].status);
		container.appendChild(clone);
  }
  showAllBook();
}

function setOrderStatus(clone, status) {
	if (status == "success") {
		clone.querySelector(".order-status-container").style.background = "#67E959";
		clone.querySelector(".order-status-container").style.border = "1px solid #67E959";
		clone.querySelector(".order-status").innerHTML = "Sukses";
	}
	else if (status == "pending") {
		clone.querySelector(".order-status-container").style.background = "yellow";
		clone.querySelector(".order-status-container").style.border = "1px solid yellow";
		clone.querySelector(".order-status").innerHTML = "Menunggu Pembayaran";
	}
	else {
		clone.querySelector(".order-status-container").style.background = "rgb(240, 135, 127)";
		clone.querySelector(".order-status-container").style.border = "1px solid rgb(240, 135, 127)";
		clone.querySelector(".order-status").innerHTML = "Gagal";
	}
	return clone;
}

function getFormattedDate(dates) {
  var relaseDate = new Date(dates);
  var date = relaseDate.getDate();
  var month = relaseDate.getMonth()+1;
  month = getMonthInBahasa(month);
  var year = relaseDate.getFullYear();
  return date+" "+month+" "+year;
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

function showAllBook() {
  var template = document.querySelector('#bookItemTemplate');
	$(".order-card").each(function() {
    var orderId = $(this).attr("data-order-id");
    var container = document.querySelector("#order-"+orderId+" .second-section");
    $.ajax({
      url : "/get/get_books_by_order_id/"+orderId,
      method : "GET"
    }).done(function(books){
      for (let i = 0; i < books.length; i++) {
        var clone = template.content.cloneNode(true);
        clone.querySelector("div").setAttribute("id", "book-"+books[i].id);
        clone.querySelector("div").setAttribute("data-book-id", books[i].id);
        clone.querySelector(".title").innerHTML = books[i].title;
        clone.querySelector("p.author-info span").innerHTML = books[i].author;
        clone.querySelector("p.price span").innerHTML = convertToRupiah(books[i].price);
        clone.querySelector("p.publisher").innerHTML = "";
        container.appendChild(clone);
      }
      setPublisherNameByOrder(orderId);
      setImageCoverByOrder(orderId);
      addEventListenerToBookTitleAndBookCoverByOrder(orderId);
    });
  });
}

function setPublisherNameByOrder(orderId) {
  $("#order-"+orderId+" .book-item").each(function() {
    var bookId = $(this).attr("data-book-id");
    $.ajax({
      url : "/get/get_book_s_publisher_name/"+bookId,
      method : "GET"
    }).done(function(publisherName) {
      document.querySelector("#book-"+bookId+" p.publisher").innerHTML = publisherName;
    });
  });
}

function setImageCoverByOrder(orderId) {
  $("#order-"+orderId+" .book-item").each(function() {
    var bookId = $(this).attr("data-book-id");
    $.ajax({
      url : "/get/get_ebook_cover_by_book_id/"+bookId,
      method : "GET"
    }).done(function(data) {
      document.querySelector("#book-"+bookId+" img.book-cover").setAttribute("src", "/ebook/ebook_cover/"+data.id+"/"+data.name);
    });
  });
}

function addEventListenerToBookTitleAndBookCoverByOrder(orderId) {
  $("#order-"+orderId+" .book-item").each(function() {
    var bookId = $(this).attr("data-book-id");
    var title = document.querySelector("#book-"+bookId+" p.title").innerHTML;
    document.querySelector("#book-"+bookId+" p.title").addEventListener("click", function() {
      window.location.href = "/book/detail/"+bookId+"/"+string_to_slug(title);
    });
    document.querySelector("#book-"+bookId+" img.book-cover").addEventListener("click", function() {
      window.location.href = "/book/detail/"+bookId+"/"+string_to_slug(title);
    });
  });
}