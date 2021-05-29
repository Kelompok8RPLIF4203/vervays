$(document).ready(function() {
	setStarImageOnClickListener();
	setToggleIsAnonymousOnChangeListener();
	setAnonymousName();
	setFormOnSubmitListener();
});

function setStarImageOnClickListener() {
	$(".star-image").click(function() {
		var id = $(this).attr("id");
		console.log({id});
		if (id === "first-star") {
			$("#ratingText").html("Payah");
			$("#inputRating").val(1);
			setStarImage(1);
		}
		else if (id === "second-star") {
			$("#ratingText").html("Kurang bagus");
			$("#inputRating").val(2);
			setStarImage(2);
		}
		else if (id === "third-star") {
			$("#ratingText").html("Lumayan");
			$("#inputRating").val(3);
			setStarImage(3);
		}
		else if (id === "fourth-star") {
			$("#ratingText").html("Bagus");
			$("#inputRating").val(4);
			setStarImage(4);
		}
		else if (id === "fifth-star") {
			$("#ratingText").html("Keren");
			$("#inputRating").val(5);
			setStarImage(5);
		}
	});
}

function setStarImage(rating) {
	$(".star-image").attr("src", "/image/icon/blank_star.png");
	if (rating >= 1) {
		$('#first-star').attr("src","/image/icon/yellow_star.png");
	}
	if (rating >= 2) {
		$('#second-star').attr("src","/image/icon/yellow_star.png");
	}
	if (rating >= 3) {
		$('#third-star').attr("src","/image/icon/yellow_star.png");
	}
	if (rating >= 4) {
		$('#fourth-star').attr("src","/image/icon/yellow_star.png");
	}
	if (rating == 5) {
		$('#fifth-star').attr("src","/image/icon/yellow_star.png");
	}
}

function setFormOnSubmitListener() {
	$("#form").on("submit", function(event) {
		event.preventDefault();
		var bookId = parseInt($("#inputBookId").val());
		var rating = parseInt($("#inputRating").val());
		var isAnonymous = parseInt($("#inputIsAnonymous").val());
		var review = $("#reviewTextArea").val();
		$.ajax({
			url : "/post/review",
			method : "POST",
			data : {
				bookId : bookId,
				rating : rating,
				isAnonymous : isAnonymous,
				review : review,
			}
		}).done(function() {
			window.history.back();
		});
	});
}

function setToggleIsAnonymousOnChangeListener() {
	$("#anonymousToggle").change(function() {
		if (this.checked) {
			$("#inputIsAnonymous").val(1);
		}
		else {
			$("#inputIsAnonymous").val(0);
		}
	});
}

function setAnonymousName() {
	var UserName = getUserName();
	UserName = UserName.replace(" ", "");
	$("#toggleLabel span").html(UserName[0]+"***"+UserName[UserName.length - 1]);
}

function getUserName() {
  const metas = document.getElementsByTagName('meta');

  for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === "userFullNameWithoutSpace") {
      return metas[i].getAttribute('content');
    }
  }

  return '';
}

