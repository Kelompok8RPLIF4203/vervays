@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/wishlist.css') }}">
@endpush

@section('title')
  Wishlist
@endsection

@section('content')
  <div class="container-fluid exception-container d-none">
    <h2 class="text-center mt-5">Wah, wishlistmu masih kosong</h2>
    <h4 class="text-center">Yuk, cari buku kesukaanmu</h4>
    <div class="button-container w-100 d-flex justify-content-center pt-2">
      <button class="btn btn-danger" id="btnSearchBook">Cari buku</button>
    </div>
  </div>
  <div class="main-section container-fluid">
    <h2 class="font-weight-bold mt-2">Wishlist</h2>
    <div id="listBook">
      <transition-group 
        name="fade" 
        enter-active-class="animated fadeIn" 
        leave-active-class="animated fadeOutRight">
        <div 
          class="row card-book"
          rating="4.5"
          :id="item.id | cardBookId"
          v-for="(item, index) in books"
          :key="item.id">
          <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 d-flex justify-content-center">
            <a 
              :href="item.id | bookDetailURL(item.title)">
              <img 
                :src="item.id | ebookCoverURL(item.ebookCoverId, item.ebookCoverName)"
                alt=""
                class="ebook-image">
            </a>
          </div>
          <div class="col-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
            <a 
              :href="item.id | bookDetailURL(item.title)">
              <h4
                class="book-title">
                @{{ item.title }}
              </h4>
            </a>
            <p
              class="font-weight-bold author-info"><span>Ditulis oleh </span><span class="author-text">@{{ item.author }}</span></p>
            <p
              class="synopsis">@{{ item.synopsis }}</p>
            <div class="book-rating-container mb-3">
              <div class="star-container d-inline">
                <img 
                  :src="item.rating | firstStarURL"
                  alt=""
                  class="star-image first-star">
                <img 
                  :src="item.rating | secondStarURL"
                  alt=""
                  class="star-image second-star">
                <img 
                  :src="item.rating | thirdStarURL"
                  alt=""
                  class="star-image third-star">
                <img 
                  :src="item.rating | fourthStarURL"
                  alt=""
                  class="star-image fourth-star">
                <img
                  :src="item.rating | fifthStarURL"
                  alt=""
                  class="star-image fifth-star">
              </div>
              <p class="d-inline-block mt-3"><span class="rating">@{{ item.rating }}</span> &emsp; (@{{ item.ratingCount }} Ulasan) &emsp; @{{ item.soldCount }}x terjual</p>
            </div>
            <p class="price font-weight-bold d-inline"><span class="price">@{{ item.price | currencyFormat }}</span></p>
            <img 
              src="{{ url('/image/ic_trash.png') }}" 
              alt="ic_trash"
              class="d-inline float-right ic-trash mt-1"
              @click="deleteBook(item.id, item.title, index)">
            <button 
              class="float-right btn-buy mr-3"
              @click="buyBook(item.id)">
              Beli
            </button>
          </div>
        </div>
      </transition-group>
    </div>
  </div>

@endsection

@push('add-on-script')
  <script src="{{ url('js/view/buyer/wishlist.js') }}"></script>
@endpush