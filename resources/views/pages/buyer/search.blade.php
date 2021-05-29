@extends('layouts.app')

@push('add-on-style')
  <meta name="keyword" content="{{ $keyword }}">
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/search.css') }}">
@endpush

@section('title')
  Search
@endsection

@section('content')
  <div class="container-fluid" id="searchPage">
    <div class="row justify-content-between mt-3 mx-1 first-row">
      <p class="col" id="keyword">Hasil pencarian untuk "@{{ keywordToShow }}"</p>
      <div class="col" id="orderOptionWrapper1">
        <select 
          name="" 
          id="orderOption" 
          class="d-inline float-right ml-2" 
          v-model="sortingMethod" 
          @change="selectSortingMethodOnChange()">
          <option value="bestseller" selected>Bestseller</option>
          <option value="tertinggi">Harga - Tertinggi ke terendah</option>
          <option value="terendah">Harga - Terendah ke tertinggi</option>
        </select>
        <p class="d-inline float-right">Urutkan berdasarkan : </p>
      </div>
    </div>
    <div 
      class="d-none justify-content-start"
      id="orderOptionWrapper2">
      <p class="">Urutkan berdasarkan : </p>
      <select 
        name="" 
        id="orderOption2"
        class="ml-2" 
        v-model="sortingMethod" 
        @change="selectSortingMethodOnChange()">
        <option value="bestseller" selected>Bestseller</option>
        <option value="tertinggi">Harga - Tertinggi ke terendah</option>
        <option value="terendah">Harga - Terendah ke tertinggi</option>
      </select>
    </div>
    <div class="row second-row">
      <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
        <div class="filter-wrapper"> {{-- Filter kategori --}}
          <div 
            class="collapse-header" 
            id="categoryListCollapseHeader"
            data-toggle="collapse" 
            data-target="#categoryList" 
            aria-expanded="false" 
            aria-controls="categoryList"
            @click="changeIcSortCategory()">
            <p class="d-inline">Kategori</p>
            <i 
              class="fa fa-fw fa-sort-asc d-inline float-right"
              id="ic-sort-asc-category"></i>
          </div>
          <ul class="collapse" id="categoryList">
            <li 
              class="li-category"
              v-for="(category, index) in categories">
              <div
                @click="listCategoryOnClickListener(category.namaKategori)"
                :id="category.namaKategori"
                class="li-category-child">
                <p class="d-inline category-name">@{{ category.namaKategori }}</p>
                <div v-if="categories[index].isUsed === false" class="float-right d-none">
                  <i class="fa fa-fw fa-check d-inline"></i>
                </div>
                <div v-else class="float-right">
                  <i class="fa fa-fw fa-check d-inline"></i>
                </div>
              </div>
            </li>
          </ul>
          <input type="hidden" name="category" id="categoryWrapper" value="">
        </div>

        <div class="filter-wrapper"> {{-- Filter bahasa --}}
          <div 
            class="collapse-header" 
            id="languageListCollapseHeader"
            data-toggle="collapse" 
            data-target="#languageList" 
            aria-expanded="false" 
            aria-controls="languageList"
            @click="changeIcSortLanguage()">
            <p class="d-inline">Bahasa</p>
            <i 
              class="fa fa-fw fa-sort-asc d-inline float-right"
              id="ic-sort-asc-language"></i>
          </div>
          <ul class="collapse" id="languageList">
            <li 
              class="li-category"
              id=""
              v-for="(language, index) in languages">
              <div
                @click="listLanguageOnClickListener(language.namaBahasa)">
                <p class="d-inline category-name">@{{ language.namaBahasa }}</p>
                <div v-if="languages[index].isUsed === false" class="float-right d-none">
                  <i class="fa fa-fw fa-check d-inline"></i>
                </div>
                <div v-else class="float-right">
                  <i class="fa fa-fw fa-check d-inline"></i>
                </div>
              </div>
            </li>
          </ul>
          <input type="hidden" name="category" id="languageWrapper" value="">
        </div>
        
      </div>
      <div class="col-xl-10 col-xl-10 col-md-10 col-sm-10 col-10" id="col-book">
        <h3 class="ml-4 text-info-book-not-found">Maaf, buku tidak ditemukan</h3>
        <p class="ml-4 text-info-book-not-found">Cek lagi kata pencarianmu</p>
        <div v-if="isInfoBookNotFoundAfterFilterShowed">
          <h3 class="ml-4 text-info-book-not-found-after-filter">Oops, buku tidak ditemukan</h3>
        </div>
        <div id="productRow">
          <div
            v-for="(book, index) in books"
            v-if="isBookFiltered(book.Category, book.Language)">
            <div 
              class="row card-book"
              rating="4.5"
              id="book"
              @click="bookOnClickListener(book.id, book.title)">
              <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                <img 
                  :src="book.id | ebookCoverURL(book.ebookCoverId, book.ebookCoverName)" 
                  alt=""
                  class="ebook-image"
                  book-id="id">
              </div>
              <div class="col-xl-10 col-xl-10 col-md-10 col-sm-10 col-10">
                <h4
                  class="book-title"
                  book-id="">@{{ book.title }}</h4>
                <p
                  class="font-weight-bold author-info"><span>Ditulis oleh </span><span class="author-text">@{{ book.author }}</span></p>
                <p
                  class="synopsis">@{{ book.synopsis }}</p>
                <div class="book-rating-container">
                  <div class="star-container d-inline">
                    <img 
                      :src="book.rating | firstStarURL"
                      alt=""
                      class="star-image first-star">
                    <img 
                      :src="book.rating | secondStarURL"
                      alt=""
                      class="star-image second-star">
                    <img 
                      :src="book.rating | thirdStarURL"
                      alt=""
                      class="star-image third-star">
                    <img 
                      :src="book.rating | fourthStarURL"
                      alt=""
                      class="star-image fourth-star">
                    <img
                      :src="book.rating | fifthStarURL"
                      alt=""
                      class="star-image fifth-star">
                  </div>
                  <p class="d-inline mt-1"><span class="rating">@{{ book.rating | formatRating }}</span> &emsp; (<span class="ratingCount">@{{ book.ratingCount }}</span> Ulasan) &emsp; <span class="soldCount">@{{ book.soldCount }}</span>x terjual</p>
                </div>
                <p 
                  class="price font-weight-bold d-inline"><span class="price">@{{ book.price | currencyFormat }}</span></p>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('add-on-script')
  <script 
    type="text/javascript"
    src= "{{ url('js/view/buyer/search.js') }}">
  </script>
@endpush