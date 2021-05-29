$(document).ready(function() {
  setUpAlert();
  checkBookAvailability();
});

function checkBookAvailability() {
  var id = $('meta[name=book-id]').attr("content");
  $.ajax({
    url : '/get/is_book_not_deleted',
    method : "GET",
    data : { id }
  }).done(function(isNotDeleted) {
    if (isNotDeleted) {
      $("#main-container").attr("class", "container-fluid");
      setAsideButtonDisplay();
    }
    else {
      $("#exception-container").attr("class", "container-fluid");
    }
  });
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

var firstSectionClone = new Vue({
  el : ".first-section-clone",
  data : {
    rating : null,
  },
  mounted : function mounted(){
    this.rating = Math.floor($('.first-section p.rating').html());
  },
  filters : {
    starURL : function(rating, order) {
      return (rating >= order) ? yellowStarURL : blankStarURL;
    },
  },
});

var firstSection = new Vue({
  el : ".first-section",
  data : {
    rating : null,
  },
  mounted : function mounted(){
    this.rating = Math.floor($('.first-section p.rating').html());
  },
  filters : {
    starURL : function(rating, order) {
      return (rating >= order) ? yellowStarURL : blankStarURL;
    },
  },
});

var detailSection = new Vue({
  el : ".detail-section",
  data : {
    publisherId : null,
    publisherName : null,
    relaseDate : null,
  },
  filters : {
    relaseDateFormat : function(value) {
      value = new Date(value);
      var date = value.getDate();
      var month = value.getMonth()+1;
      month = getMonthInBahasa(month);
      var year = value.getFullYear();
      return date+" "+month+" "+year;
    },
  },
  mounted : function mounted() {
    this.publisherId = $('meta[name=publisherId]').attr("content");
    this.publisherName = $('#publisherText span').html();
    this.relaseDate = $('meta[name=relaseDate]').attr("content");
  },
  methods : {
    goToInfoPublisherPage : function() {
      var publisherSlug = string_to_slug(this.publisherName);
      window.location.href = "/info/publisher/"+this.publisherId+"/"+publisherSlug;
    },
  }
});

var ratingSection = new Vue({
  el : ".rating-section",
  data : {
    bookId : null,
    rating : null,
    ratingAllCount : null,
    ratingPerCategory : [],
    ratingLoadedPercentage : [],
  },
  mounted : function mounted() {
    this.bookId = $('meta[name=book-id]').attr("content");
    this.rating = Math.floor($('.first-section p.rating').html());
    category = ["fifth", "fourth", "third", "second", "first"];
    fetch("/get/get_people_gave_stars_count_all_rating/"+this.bookId) // mendapatkan banyak orang yang mengulas
      .then(response => response.json())
      .then(data => {
        this.ratingAllCount = data;
        for (let i = 1; i < 6; i++) { // mendapatkan banyak orang untuk setiap kategori rating
          fetch("/get/get_people_gave_stars_count_by_rating/"+this.bookId+"/"+i)
            .then(response => response.json())
            .then(data => {
              this.ratingPerCategory.push(data);
              this.ratingLoadedPercentage.push((data / this.ratingAllCount * 100) + "%");
            });
        }
      });
  },
  filters : {
    starURL : function(rating, order) {
      return (rating >= order) ? yellowStarURL : blankStarURL;
    },
  }
});

var reviewSection = new Vue({
  el : ".review-section",
  data : {
    bookId : null,
    reviews : null,
    loaded : 0,
  },
  mounted : function mounted() {
    this.bookId = $('meta[name=book-id]').attr("content");
    fetch("/get/get_reviews_by_book_id/"+this.bookId) // mendapatkan banyak orang yang mengulas
      .then(response => response.json())
      .then(data => {
        this.reviews = data;
        if (data.length >= 3) {
          this.loaded = 3;
        }
        else {
          this.loaded = data.length;
        }
      });
  },
  computed : {
    isLoadMoreButtonShow : function() {
      return this.loaded < this.reviews.length;
    }
  },
  filters : {
    starURL : function(rating, order) {
      return (rating >= order) ? yellowStarURL : blankStarURL;
    },
    formattedDateForReviewSection : function(date) {
      var newDate = new Date(date);
      return newDate.getDate()+" "+getMonthInBahasa(newDate.getMonth()+1)+" "+newDate.getFullYear();
    },
    reviewerFormattedName : function(firstName, lastName, isAnonymous, isUserDeleted) {
      var name = firstName + " " + lastName;
      if (isAnonymous == 1) {
        name = name.substring(0,1) + "***" + name.substring(name.length-1,name.length);
      }
      if (isUserDeleted == 1) {
        name = "Deleted Account";
      }
      return name;
    }
  },
  methods : {
    loadMore : function() {
      var loadedNow = this.loaded;
      for (let i = this.loaded; i < this.reviews.length && i < (loadedNow + 3); i++) {
        this.loaded++;
      }
    }
  }
});

function setAsideButtonDisplay() {
  $(".button-aside").hide();
  var bookId = $('meta[name=book-id]').attr("content");
  $.ajax({
    type : "GET",
    url : "/get/get_user_role_for_ebook_info_page/"+bookId
  }).done(function(role) {
    if (role == 1) {
      $('#btnDelete').show();
      $('#btnEdit').show();
      $('#btnEdit').click(function() {
        window.location.href = "/publisher/edit/book?id="+bookId;
      });
      $('#btnDelete').click(function() {
        Swal.fire({
          title: "Apakah anda yakin ingin menghapus buku \""+$(this).attr("data-title")+'" ?',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya',
          cancelButtonText : 'Tidak'
        }).then((result) => {
          if (result.value) {
            var id = bookId;
            $.ajax({
              url : "/publisher/delete/book",
              method : "POST",
              data : {
                "id" : id
              }
            }).done(function() {
              window.location.href = "/publisher/dashboard";
            });
          }
        });
      });
    }
    else if (role == 3) {
      $.ajax({
        url : "/get/whether_the_transaction_is_pending_or_success/"+bookId,
        method : "GET"
      }).done(function(response){
        if (response == "pending") {
          $('#btnReadSample').show();
        }
        else { // Jika transaksi telah sukses
          $('#btnRead').show();
          $.ajax({ // Cek apakah user sudah memberi rating
            url : "/get/have_user_given_book_rating/"+bookId,
            method : "GET"
          }).done(function(haveUserGivenBookRating) {
            if (!haveUserGivenBookRating) {
              $('#btnGiveRating').show();
              $('#btnGiveRating').attr("onclick", "window.location.href = \"/give_rating/"+bookId+"\"");
            }
          });
        }
      });
    }
    else if (role == 2) {
      $('#btnReadSample').show();
      $('#btnAddToCart').show();
      $('#btnAddToWishlist').show();
      $('#btnBuy').show();
      setUpBtnAddToCart();
      setUpBtnAddToWishList();
      setUpBtnBuy();
    }
  });
}

function setUpBtnBuy() {
  var bookId = $('meta[name=book-id]').attr("content");
  $("#btnBuy").click(function() {
    $(':input[type="submit"]').prop('disabled', true);
    $(':input[type="submit"]').html('....');

    $.ajax({ // mengecek apakah buku sudah dihapus
      url : '/get/is_book_not_deleted',
      method : "GET",
      data : { "id" : bookId }
    }).done(function(isNotDeleted) {
      if (isNotDeleted) { // jika blm dihapus
        $.ajax({
          type : "GET",
          url : "/get/whether_the_user_has_added_book_to_cart/"+bookId
        }).done(function(isUserHasAddedBookToCart) {
          isUserHasAddedBookToCart = (isUserHasAddedBookToCart == "true");
          if (!isUserHasAddedBookToCart) { // Jika user belum memasukkan buku ke keranjang
            $.ajax({ // Memasukkan buku ke keranjang
              url : "/post/add_book_to_cart/"+bookId,
              method : "POST"
            }).done(function(response) {
              window.location.href = "/cart";
            });
          }
          else {
            window.location.href = "/cart";
          }
        });
      }
      else {
        location.reload();
      }
    });
  });
}

function setUpBtnAddToCart() {
  var bookId = $('meta[name=book-id]').attr("content");
  $.ajax({
    type : "GET",
    url : "/get/whether_the_user_has_added_book_to_cart/"+bookId
  }).done(function(isUserHasAddedBookToCart) {
    isUserHasAddedBookToCart = (isUserHasAddedBookToCart == "true");
    if (isUserHasAddedBookToCart) { // Jika user sudah memasukkan buku ke keranjang
      $('#btnAddToCart').html("Hapus dari Keranjang");
      $('#btnAddToCart').attr("onclick", "deleteBookFromCart()");
      $('#btnAddToCart').attr("id", "btnDeleteFromCart");
    }
    else { // Jika user belum memasukkan buku ke keranjang
      $('#btnAddToCart').attr("onclick", "addBookToCart()");
    }
  });
}

function addBookToCart() {
  $('#btnAddToCart').attr("onclick", "");
  $('#btnAddToCart').html("....");
  var bookId = $('meta[name=book-id]').attr("content");
  $.ajax({ // mengecek apakah buku sudah dihapus
    url : '/get/is_book_not_deleted',
    method : "GET",
    data : { "id" : bookId }
  }).done(function(isNotDeleted) {
    if (isNotDeleted) { // jika blm dihapus
      $.ajax({ // memasukkan buku ke keranjang
        url : "/post/add_book_to_cart/"+bookId,
        method : "POST"
      }).done(function() {
        $('#btnAddToCart').html("Hapus dari Keranjang");
        $('#btnAddToCart').attr("onclick", "deleteBookFromCart()");
        $('#btnAddToCart').attr("id", "btnDeleteFromCart");
        storeFlashMessage("Berhasil menambah ebook ke keranjang belanja", "success", 2);
        setUpAlert();
      });
    }
    else {
      location.reload();
    }
  });
}

function deleteBookFromCart() {
  $('#btnDeleteFromCart').html("....");
  $('#btnDeleteFromCart').attr("onclick", "");
  var bookId = $('meta[name=book-id]').attr("content");
  $.ajax({
    url : "/post/remove_book_from_cart/"+bookId,
    method : "POST"
  }).done(function() {
    $('#btnDeleteFromCart').html("Tambah ke Keranjang");
    $('#btnDeleteFromCart').attr("onclick", "addBookToCart()");
    $('#btnDeleteFromCart').attr("id", "btnAddToCart");
    storeFlashMessage("Berhasil menghapus ebook dari keranjang belanja", "success", 2);
    setUpAlert();
  });
}

function setUpBtnAddToWishList() {
  var bookId = $('meta[name=book-id]').attr("content");
  $.ajax({
    type : "GET",
    url : "/get/whether_the_user_has_added_book_to_wish_list/"+bookId
  }).done(function(isUserHasAddedBookToWishList) {
    isUserHasAddedBookToWishList = (isUserHasAddedBookToWishList == "true");
    if (isUserHasAddedBookToWishList) { // Jika user sudah memasukkan buku ke keranjang
      $('#btnAddToWishlist').html("Hapus dari Wishlist");
      $('#btnAddToWishlist').attr("onclick", "removeBookFromWishList()");
      $('#btnAddToWishlist').attr("id", "btnDeleteFromWishList");
    }
    else { // Jika user belum memasukkan buku ke keranjang
      $('#btnAddToWishlist').attr("onclick", "addBookToWishList()");
      $('#btnAddToWishlist').attr("id", "btnAddToWishList");
    }
  });
}

function addBookToWishList() {
  $('#btnAddToWishList').attr("onclick", "");
  $('#btnAddToWishList').html("....");
  var bookId = $('meta[name=book-id]').attr("content");

  $.ajax({ // mengecek apakah buku sudah dihapus
    url : '/get/is_book_not_deleted',
    method : "GET",
    data : { "id" : bookId }
  }).done(function(isNotDeleted) {
    if (isNotDeleted) { // jika blm dihapus
      $.ajax({
        url : "/post/add_book_to_wish_list/"+bookId,
        method : "POST"
      }).done(function() {
        $('#btnAddToWishList').html("Hapus dari Wishlist");
        $('#btnAddToWishList').attr("onclick", "removeBookFromWishList()");
        $('#btnAddToWishList').attr("id", "btnDeleteFromWishList");
        storeFlashMessage("Berhasil menambah ebook ke wishlist", "success", 2);
        setUpAlert();
      });
    }
    else {
      location.reload();
    }
  });
}

function removeBookFromWishList() {
  $('#btnDeleteFromWishList').html("....");
  $('#btnDeleteFromWishList').attr("onclick", "");
  var bookId = $('meta[name=book-id]').attr("content");
  $.ajax({
    url : "/post/remove_book_from_wish_list/"+bookId,
    method : "POST"
  }).done(function() {
    $('#btnDeleteFromWishList').html("Tambah ke Wishlist");
    $('#btnDeleteFromWishList').attr("onclick", "addBookToWishList()");
    $('#btnDeleteFromWishList').attr("id", "btnAddToWishList");
    storeFlashMessage("Berhasil menghapus ebook dari wishlist", "success", 2);
    setUpAlert();
  });
}

function redirectToReadSamplePage() {
  var bookId = $('meta[name=book-id]').attr("content");
  window.location.href = "/read/sample/"+bookId;
}

function redirectToReadPage() {
  var bookId = $('meta[name=book-id]').attr("content");
  window.location.href = "/read/book/"+bookId;
}