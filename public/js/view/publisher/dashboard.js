$(document).ready(function() {
  setUpAlert();
  setBtnUbahDataOnClickListener();
  setUpBtnCashout();
  setupBookListContainer();
});

function setupBookListContainer() {
  var containerListBuku = new Vue({
    el : "#containerListBuku",
    data : {
      books : null
    },
    beforeCreate : function() {
      fetch("/get/get_publishers_book")
      .then(response => response.json())
      .then(data => {
        this.books = data;
      })
    },
    filters : {
      currencyFormat : function(value) {
        return "Rp. " + value;
      },
      formatRating : function(value) {
        return parseFloat(value).toPrecision(2);
      }
    },
    methods : {
      redirectToEditBookPage : function(id) {
        window.location.href = "/publisher/edit/book?id="+id;
      },
      redirectToBookDetailPage : function(id, title) {
        window.location.href = "/book/detail/"+id+"/"+string_to_slug(title);
      },
      deleteBook : function(id, title) {
        Swal.fire({
          title: "Apakah anda yakin akan menghapus buku \""+title+' ?',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya',
          cancelButtonText : 'Tidak'
        }).then((result) => {
          if (result.value) {
            $.ajax({
              url : "/publisher/delete/book",
              method : "POST",
              data : {
                "id" : id
              }
            }).done(function() {
              storeFlashMessage("Berhasil menghapus buku "+"\""+title+"\"", "success", 2);
              location.reload();
            });
          }
        });
      },
      redirectToAddBookPage : function() {
        $(location).attr("href", "/publisher/input/book");
      }
    }
  });
}

function setBtnUbahDataOnClickListener() {
  $('#btnUbahData').click(function() {
		$(location).attr("href", "/publisher/edit");
  });
}

function setUpBtnCashout() {
  var balance = $('meta[name=balance]').attr("content");
  balance = parseInt(balance);
  if (balance >= 30000) {
    var kelas = $("#btnCashout").attr("class");
    kelas = kelas.replace("none", "inline");
    $("#btnCashout").attr("class", kelas);
    $("#btnCashout").attr("onclick", "window.location.href = \"/publisher/cashout\"");
  }
}