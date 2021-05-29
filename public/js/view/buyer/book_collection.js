var userBooks = new Vue({
  el : ".row",
  data : {
    books : null,
    isBtnReadShowed : false,
    isBtnGiveRatingShowed : false,
  },
  mounted : function() {
    fetch("/get/get_user_books")
      .then(response => response.json())
      .then(data => {
        for (let i = 0; i < data.length; i++) {
          data[i].isBtnShowed = false;
        }
        this.books = data;
        if (this.books.length > 0) {
          var kelas = $(".main-container").attr("class");
          kelas = kelas.replace("d-none", "");
          $(".main-container").attr("class", kelas);
        }
        else {
          var kelas = $(".exception-container").attr("class");
          kelas = kelas.replace("d-none", "");
          $(".exception-container").attr("class", kelas);
        }
      });
  },
  filters : {
    bookCoverURL : function(ebookCoverId, ebookCoverFileName) {
      return "/ebook/ebook_cover/"+ebookCoverId+"/"+ebookCoverFileName;
    },
    bookDetailURL : function(id, title) {
      return "/book/detail/"+id+"/"+string_to_slug(title);
    }
  },
  methods : {
    onMouseEnter : function(i) {
      this.isBtnReadShowed = true;
      this.isBtnGiveRatingShowed = true;
      this.books[i].isBtnShowed = true;
    },
    onMouseLeave : function(i) {
      this.isBtnReadShowed = false;
      this.isBtnGiveRatingShowed = false;
      this.books[i].isBtnShowed = false;
    },
    redirectToReadBookPage : function(id) {
      window.location.href = "/read/book/"+id;
    },
    redirectToGiveRatingPage : function(id) {
      window.location.href = "/give_rating/"+id;
    }
  },
});
