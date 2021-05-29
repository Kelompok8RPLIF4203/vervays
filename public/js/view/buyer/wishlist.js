$(document).ready(function() {
  setUpAlert();
});

function showExceptionContainer() {
	$(".main-section").hide();
	var kelas = $('.exception-container').attr("class");
	kelas = kelas.replace("none", "block");
  $('.exception-container').attr("class", kelas);
  $("#btnSearchBook").click(function() {
    window.location.href = "/";
  });
}

var listBook = new Vue({
  el : "#listBook",
  data : {
    books : null
  },
  beforeCreate : function() {
    fetch("/get/user_wishlist")
      .then(response => response.json())
      .then(data => {
        this.books = data;
        if (this.books.length == 0) {
          showExceptionContainer();
        }
      })
  },
  filters : {
    cardBookId : function(id) {
      return "book-card-"+id;
    },
    ebookCoverURL : function(value, ebookCoverId, ebookCoverName) {
      return "/ebook/ebook_cover/"+ebookCoverId+"/"+ebookCoverName;
    },
    currencyFormat : function(value) {
      return convertToRupiah(value);
    },
    bookDetailURL : function(value, title) {
      return "/book/detail/"+value+"/"+string_to_slug(title);
    },
    firstStarURL : function(rating) {
      return (rating >= 1) ? yellowStarURL : blankStarURL;
    },
    secondStarURL : function(rating) {
      return (rating >= 2) ? yellowStarURL : blankStarURL;
    },
    thirdStarURL : function(rating) {
      return (rating >= 3) ? yellowStarURL : blankStarURL;
    },
    fourthStarURL : function(rating) {
      return (rating >= 4) ? yellowStarURL : blankStarURL;
    },
    fifthStarURL : function(rating) {
      return (rating == 5) ? yellowStarURL : blankStarURL;
    }
  },
  methods : {
    deleteBook : function(id, title, index) {
      Swal.fire({
        title: "Apakah anda yakin ingin menghapus buku \""+title+"\" dari wishlist?",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText : 'Tidak'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url : "/post/remove_book_from_wish_list/"+id,
            method : "POST"
          });
          this.books.splice(index, 1);
          storeFlashMessage("Buku \""+title+"\" telah dihapus dari wishlist", "success", 2);
          setUpAlert();
          if (this.books.length == 0) {
            showExceptionContainer();
          }
        }
      });
    },
    buyBook : function(id) {
      console.log("Beli buku "+ id);
      var bookId = id;
      $.ajax({
        type : "GET",
        url : "/get/whether_the_user_has_added_book_to_cart/"+bookId
      }).done(function(isUserHasAddedBookToCart) {
        isUserHasAddedBookToCart = (isUserHasAddedBookToCart == "true");
        if (!isUserHasAddedBookToCart) { // Jika user belum memasukkan buku ke keranjang
          $.ajax({ // Memasukkan buku ke keranjang
            url : "/post/add_book_to_cart/"+bookId,
            method : "POST"
          }).done(function() {
            window.location.href = "/cart";
          });
        }
        else {
          window.location.href = "/cart";
        }
      });
    }
  }
});