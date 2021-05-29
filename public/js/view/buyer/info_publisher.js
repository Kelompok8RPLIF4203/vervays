$(document).ready(function() {
	setUpRating();
	setCardBookOnClickListener();
});

function setUpRating() {
	$(".card-book").each(function() {
		var id = $(this).attr("id");
		var rating = parseFloat($("#"+id+" span.rating").html());
		if (rating >= 1) {
      $('#'+id+' .first-star').attr("src","/image/icon/yellow_star.png");
    }
    if (rating >= 2) {
      $('#'+id+' .second-star').attr("src","/image/icon/yellow_star.png");
    }
    if (rating >= 3) {
      $('#'+id+' .third-star').attr("src","/image/icon/yellow_star.png");
    }
    if (rating >= 4) {
      $('#'+id+' .fourth-star').attr("src","/image/icon/yellow_star.png");
    }
    if (rating == 5) {
      $('#'+id+' .fifth-star').attr("src","/image/icon/yellow_star.png");
    }
	});
}

function setCardBookOnClickListener() {
	$(".card-book").click(function() {
		var id = $(this).attr("id");
		var title = $("#"+id+" h4.book-title").html();
		id = id.replace("book-card-", "");
		window.location.href = "/book/detail/"+id+"/"+string_to_slug(title);
	});
}