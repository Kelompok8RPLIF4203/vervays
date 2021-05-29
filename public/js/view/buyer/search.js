function getChoicedCategory(categories) {
  var selectedCategory = []
  for (let i = 0; i < categories.length; i++) {
    if (categories[i].isUsed === true) {
      selectedCategory.push(categories[i].namaKategori);
    }
  }
  return selectedCategory;
}

function getChoicedLanguages(languages) {
  var selectedLanguage = []
  for (let i = 0; i < languages.length; i++) {
    if (languages[i].isUsed === true) {
      selectedLanguage.push(languages[i].namaBahasa);
    }
  }
  return selectedLanguage;
}

function anyBookFiltered(categories, languages, books) {
  if (categories.length == 0 && languages.length == 0) {
    return true;
  }
  else if (categories.length > 0 && languages.length > 0) {
    filteredBooks = [];
    for (let i = 0; i < categories.length; i++) {
      for (let j = 0; j < books.length; j++) {
        if (books[j].Category == categories[i]) {
          filteredBooks.push(books[j]);
        }
      }
    }
    
    for (let i = 0; i < languages.length; i++) {
      for (let j = 0; j < filteredBooks.length; j++) {
        if (filteredBooks[j].Language == languages[i]) {
          return true;
        }
      }
    }
    return false;
  }
  else {
    return true;
  }
}

var searchPage = new Vue({
  el : "#searchPage",
  data : {
    books : null,
    keyword : null,
    keywordToShow : null,
    categories : null,
    languages : null,
    sortingMethod : "bestseller",
    choicedCategory : [],
    choicedLanguage : [],
    isInfoBookNotFoundAfterFilterShowed : false,
  },
  beforeCreate : function() {
    $('.text-info-book-not-found').hide();
  },
  mounted : function mounted() {
    this.keyword = $('meta[name=keyword]').attr("content");
    this.keyword = this.keyword.replaceAll('-', '%20');
    this.keywordToShow = this.keyword.replaceAll("%20", " ");
    fetch("/search/book?keyword="+this.keyword)
    .then(response => response.json())
    .then(data => {
      this.books = data;
      this.books.sort(function(a, b){return b.soldCount - a.soldCount});
      if (this.books.length == 0) {
        $('.text-info-book-not-found').show();
      }
      var arrCategory = []
      var arrPureCategory = []
      var arrLanguage = []
      var arrPureLanguage = []
      for (let index = 0; index < data.length; index++) {
        if (!(arrPureCategory.includes(data[index].Category))) {
          var namaKategori = data[index].Category;
          var idKategori = data[index].categoryId;
          var isUsed = false;
          arrCategory.push( { namaKategori, idKategori, isUsed });
          arrPureCategory.push(data[index].Category);
        }
        if (!(arrPureLanguage.includes(data[index].Language))) {
          var namaBahasa = data[index].Language;
          var idBahasa = data[index].languageId;
          var isUsed = false;
          arrLanguage.push({ namaBahasa, idBahasa, isUsed });
          arrPureLanguage.push(data[index].Language);
        }
      }
      this.categories = arrCategory;
      this.languages = arrLanguage;
    });
    $('#categoryList').collapse('show');
    $('#languageList').collapse('show');
  },
  filters : {
    formatRating : function(value) {
      return parseFloat(value).toPrecision(2);
    },
    ebookCoverURL : function(value, ebookCoverId, ebookCoverName) {
      return "/ebook/ebook_cover/"+ebookCoverId+"/"+ebookCoverName;
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
    },
    currencyFormat : function(value) {
      return convertToRupiah(value);
    }
  },
  methods : {
    changeIcSortCategory : function() {
      if ($('#categoryList').is( ":visible" )) { // jika list akan dicollapse
        var kelas = $('#ic-sort-asc-category').attr('class');
        kelas = kelas.replace('fa-sort-asc','fa-sort-desc');
        $('#ic-sort-asc-category').attr("class", kelas);
      }
      else { // jika list akan dishow
        var kelas = $('#ic-sort-asc-category').attr('class');
        kelas = kelas.replace('fa-sort-desc','fa-sort-asc');
        $('#ic-sort-asc-category').attr("class", kelas);
      }
    },
    changeIcSortLanguage : function() {
      if ($('#languageList').is( ":visible" )) { // jika list akan dicollapse
        var kelas = $('#ic-sort-asc-language').attr('class');
        kelas = kelas.replace('fa-sort-asc','fa-sort-desc');
        $('#ic-sort-asc-language').attr("class", kelas);
      }
      else { // jika list akan dishow
        var kelas = $('#ic-sort-asc-language').attr('class');
        kelas = kelas.replace('fa-sort-desc','fa-sort-asc');
        $('#ic-sort-asc-language').attr("class", kelas);
      }
    },
    listCategoryOnClickListener : function(nama) {
      for (let i = 0; i < this.categories.length; i++) {
        if (this.categories[i].namaKategori == nama) {
          if (this.categories[i].isUsed === false) { // jika sebelumnya tidak dipilih
            this.categories[i].isUsed = true;
          }
          else { // jika sebelumnya dipilih
            this.categories[i].isUsed = false;
          }
        }
      }
      this.choicedCategory = getChoicedCategory(this.categories);
      if (anyBookFiltered(this.choicedCategory, this.choicedLanguage, this.books)) { // jika ada buku yang terfilter
        this.isInfoBookNotFoundAfterFilterShowed = false;
      }
      else {
        this.isInfoBookNotFoundAfterFilterShowed = true;
      }
    },
    listLanguageOnClickListener : function(nama) {
      for (let i = 0; i < this.languages.length; i++) {
        if (this.languages[i].namaBahasa == nama) {
          if (this.languages[i].isUsed === false) { // jika sebelumnya tidak dipilih
            this.languages[i].isUsed = true;
          }
          else { // jika sebelumnya dipilih
            this.languages[i].isUsed = false;
          }
        }
      }
      this.choicedLanguage = getChoicedLanguages(this.languages);
      if (anyBookFiltered(this.choicedCategory, this.choicedLanguage, this.books)) { // jika ada buku yang terfilter
        this.isInfoBookNotFoundAfterFilterShowed = false;
      }
      else {
        this.isInfoBookNotFoundAfterFilterShowed = true;
      }
    },
    bookOnClickListener : function(id, title) {
      window.location.href = "/book/detail/"+id+"/"+string_to_slug(title);
    },
    selectSortingMethodOnChange : function() {
      switch (this.sortingMethod) {
        case "bestseller":
          this.books.sort(function(a, b){return b.soldCount - a.soldCount});
          break;
        case "tertinggi" :
          this.books.sort(function(a, b){return b.price - a.price});
          break;
        default:
          this.books.sort(function(a, b){return a.price - b.price});
          break;
      }
    },
    isBookFiltered(category, language) {
      if (this.choicedCategory.length == 0 && this.choicedLanguage.length == 0) {
        return true;
      }
      else if (this.choicedCategory.length > 0 && this.choicedLanguage.length > 0) {
        return this.choicedCategory.includes(category) && this.choicedLanguage.includes(language);
      }
      else if (this.choicedCategory.length > 0) {
        return this.choicedCategory.includes(category);
      }
      else if (this.choicedLanguage.length > 0) {
        return this.choicedLanguage.includes(language);
      }
    }
  }
});
