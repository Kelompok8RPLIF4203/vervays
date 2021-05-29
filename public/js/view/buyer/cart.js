function displayExceptionSection() {
	var kelas = $('.exception-container').attr("class");
	kelas = kelas.replace("none", "block");
  $('.exception-container').attr("class", kelas);
  $('#btnSearchBook').click(function() {
    window.location.href = "/";
  });
}

function getPaymentMethodValue() {
  var radios = document.getElementsByName('paymentMethod');
  for (var i = 0, length = radios.length; i < length; i++) {
    if (radios[i].checked) {
      return radios[i].value;
    }
  }
}

var listBook = new Vue({
  el : "#mainContainer",
  data : {
    books : null
  },
  beforeCreate : function() {
    $("#loader-wrapper").hide();
    fetch("/get/get_user_cart")
      .then(response => response.json())
      .then(data => {
        this.books = data;
        console.log(this.books);
        if (this.books.length == 0) {
          displayExceptionSection();
        }
      })
  },
  filters : {
    cardBookId : function(id) {
      return "book-card-"+id;
    },
    currencyFormat : function(value) {
      return convertToRupiah(value);
    },
    ebookCoverURL : function(value, ebookCoverId, ebookCoverName) {
      return "/ebook/ebook_cover/"+ebookCoverId+"/"+ebookCoverName;
    },
    bookDetailURL : function(value, title) {
      return "/book/detail/"+value+"/"+string_to_slug(title);
    },
  },
  computed : {
    totalAmount : function() {
      var total = 0;
      for (var el of this.books) {
        total = total + Number(el.price);
      }
      return total;
    }
  },
  methods : {
    deleteBook : function(id, title, index) {
      Swal.fire({
        title: "Apakah anda yakin ingin menghapus buku \""+title+"\" dari keranjang belanja?",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText : 'Tidak'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url : "/post/remove_book_from_cart/"+id,
            method : "POST"
          });
          this.books.splice(index, 1);
          showAlert("Buku \""+title+"\" telah dihapus dari keranjang belanja", "success");
          if (this.books.length == 0) {
            displayExceptionSection();
          }
        }
      });
    },
    submit : function() {
      $("#loader-wrapper").show();
      paymentMethod = getPaymentMethodValue();
      console.log({ paymentMethod });
      $(':input[type="submit"]').prop('disabled', true);
      $(':input[type="submit"]').html('....');
      $.ajax({
        url : "http://127.0.0.1:8000/post/create_order",
        method : "POST",
        headers : {
          "Content-Type": "application/json",
        },
        data : JSON.stringify({"paymentMethod":paymentMethod}),
        dataType : "JSON", 
      }).always(function(orderId) {
        console.log(orderId);
        window.location.href = "/info/order/"+orderId;
      });
    }
  }
});