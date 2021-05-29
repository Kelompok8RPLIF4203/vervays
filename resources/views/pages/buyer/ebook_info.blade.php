@extends('layouts.app')

@push('add-on-meta')
  <meta name="book-id" content="{{ $book["id"] }}">
  <meta name="publisherId" content="{{ $book["publisherId"] }}">
  <meta name="relaseDate" content="{{ $book["release_at"] }}">
@endpush

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/ebook_info.css') }}">
@endpush

@section('title')
  Jual ebook {{ $book["title"] }}
@endsection

@section('content')
  <div class="container-fluid d-none" id="exception-container">
    <h2 class="text-center mt-3">Hmmm.... Buku telah terhapus</h2>
  </div>
  <div class="container-fluid d-none" id="main-container">
    <div class="row mt-2">
      <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
        <div class="d-flex justify-content-center">
          <img 
            src="{{ $book["imageURL"] }}" 
            alt=""
            class="ebook-cover">
        </div>
        <h5>Rp. {{ $book["priceForHuman"] }}</h5>
        <section class="first-section-clone d-block d-sm-block d-md-none d-lg-none d-xl-none">
          <h2>{{ $book["title"] }}</h2>
          <p class="author-info">Ditulis oleh <span>{{ $book["author"] }}</span></p>
          <div class="row rating-row">
            <img 
              :src="this.rating | starURL(1)"
              alt=""
              class="star-image d-inline first-star">
            <img 
              :src="this.rating | starURL(2)"
              alt=""
              class="star-image d-inline second-star">
            <img 
              :src="this.rating | starURL(3)"
              alt=""
              class="star-image d-inline third-star">
            <img 
              :src="this.rating | starURL(4)"
              alt=""
              class="star-image d-inline fourth-star">
            <img 
              :src="this.rating | starURL(5)"
              alt=""
              class="star-image d-inline fifth-star">
            <p class="d-inline-block rating mt-1 ml-2">{{ $book["rating"] }}</p>
            <p class="d-inline-block rating-count mt-1 ml-3">({{ $book["ratingCount"] }} Ulasan)</p>
          </div>
          <p class="order-sold-info">{{ $book["soldCount"] }} kali terjual</p>
          <hr>
        </section>
        <div class="button-container mt-4" role="1" id="button-container">
          <button class="button-aside" id="btnEdit">Edit Buku</button>
          <button class="button-aside" id="btnDelete" data-title="{{ $book["title"] }}">Hapus Buku</button>
          {{-- //////////////////////////////////////// --}}
          <button class="button-aside" id="btnRead" onclick="redirectToReadPage()">Baca Buku</button>
          <button class="button-aside" id="btnGiveRating">Beri Ulasan</button>
          {{-- //////////////////////////////////////// --}}
          <button class="button-aside" id="btnReadSample" onclick="redirectToReadSamplePage()">Baca Sample</button>
          <button class="button-aside" id="btnAddToCart">Tambah ke Keranjang</button>
          <button class="button-aside" id="btnAddToWishlist">Tambah ke Wishlist</button>
          <button class="button-aside" id="btnBuy">Beli</button>
        </div>
        <hr class="d-block d-sm-block d-md-none d-lg-none d-xl-none">
      </div>
      <div class="col-12 col-sm-12 col-md-10 col-md-10 col-xl-10">
        <section class="first-section d-none d-sm-none d-md-block d-lg-block d-xl-block">
          <h2>{{ $book["title"] }}</h2>
          <p class="author-info">Ditulis oleh <span>{{ $book["author"] }}</span></p>
          <div class="row rating-row">
            <img 
              :src="this.rating | starURL(1)"
              alt=""
              class="star-image d-inline first-star">
            <img 
              :src="this.rating | starURL(2)"
              alt=""
              class="star-image d-inline second-star">
            <img 
              :src="this.rating | starURL(3)"
              alt=""
              class="star-image d-inline third-star">
            <img 
              :src="this.rating | starURL(4)"
              alt=""
              class="star-image d-inline fourth-star">
            <img 
              :src="this.rating | starURL(5)"
              alt=""
              class="star-image d-inline fifth-star">
            <p class="d-inline-block rating mt-1 ml-2">{{ $book["rating"] }}</p>
            <p class="d-inline-block rating-count mt-1 ml-3">({{ $book["ratingCount"] }} Ulasan)</p>
          </div>
          <p class="order-sold-info">{{ $book["soldCount"] }} kali terjual</p>
          <hr>
        </section>
        <section class="synopsis-section">
          <h4>Abstraksi</h4>
          <div id="textSynopsis" style="white-space: pre-wrap">{{ $book["synopsis"] }}</div>
          <hr>
        </section>
        <section class="detail-section">
          <h4>Detail Buku</h4>
          <div class="row">
            <div class="d-inline">
              <p>Bahasa</p>
              <p>Penerbit</p>
              <p>Penulis</p>
              <p>Kategori</p>
              <p>Jumlah halaman &ensp;</p>
              <p>Terbit</p>
            </div>
            <div class="d-inline">
              <p>: {{ $book["language"] }}</p>
              <p id="publisherText" @click="goToInfoPublisherPage()">: <span>{{ $book["publisher"] }}</span></p>
              <p>: {{ $book["author"] }}</p>
              <p>: {{ $book["category"] }}</p>
              <p>: {{ $book["numberOfPage"] }}</p>
              <p id="relaseDate">: <span>@{{ this.relaseDate | relaseDateFormat }}</span></p>
            </div>
          </div>
          <hr>
        </section>
        <section class="rating-section">
          <h4>Rating dan Ulasan</h4>
          <div class="row">
            <div class="d-inline">
              <div class="text-center">
                <h1 class="d-inline rating">{{ $book["rating"] }}</h1>
                <p class="d-inline">/5</p>
              </div>
              <div class="row rating-row mt-1 mb-2">
                <img 
                  :src="this.rating | starURL(1)"
                  alt=""
                  class="star-image d-inline first-star">
                <img 
                  :src="this.rating | starURL(2)"
                  alt=""
                  class="star-image d-inline second-star">
                <img 
                  :src="this.rating | starURL(3)"
                  alt=""
                  class="star-image d-inline third-star">
                <img 
                  :src="this.rating | starURL(4)"
                  alt=""
                  class="star-image d-inline fourth-star">
                <img 
                  :src="this.rating | starURL(5)"
                  alt=""
                  class="star-image d-inline fifth-star">
              </div>
              <p class="rating-count text-center">{{ $book["ratingCount"] }} Ulasan</p>
            </div>
            <div class="d-inline pl-5">
              <div class="row rating-row-progress" id="fifth-rating-row">
                <img 
                  src="{{ url('image/icon/yellow_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <p class="d-inline-block mt-1 ml-1 font-weight-bold">5</p>
                <div class="custom-progress mt-2 ml-2">
                  <div class="loaded" v-bind:style="{ width: ratingLoadedPercentage[4] }"></div>
                </div>
                <p class="mt-1 ml-2">@{{ ratingPerCategory[4] }}</p>       
              </div>
              <div class="row rating-row-progress" id="fourth-rating-row">
                <img 
                  src="{{ url('image/icon/yellow_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <p class="d-inline-block mt-1 ml-1 font-weight-bold">4</p>
                <div class="custom-progress mt-2 ml-2">
                  <div class="loaded" v-bind:style="{ width: ratingLoadedPercentage[3] }"></div>
                </div>
                <p class="mt-1 ml-2">@{{ ratingPerCategory[3] }}</p>       
              </div>
              <div class="row rating-row-progress" id="third-rating-row">
                <img 
                  src="{{ url('image/icon/yellow_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <p class="d-inline-block mt-1 ml-1 font-weight-bold">3</p>
                <div class="custom-progress mt-2 ml-2">
                  <div class="loaded" v-bind:style="{ width: ratingLoadedPercentage[2] }"></div>
                </div>
                <p class="mt-1 ml-2">@{{ ratingPerCategory[2] }}</p>       
              </div>
              <div class="row rating-row-progress" id="second-rating-row">
                <img 
                  src="{{ url('image/icon/yellow_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <p class="d-inline-block mt-1 ml-1 font-weight-bold">2</p>
                <div class="custom-progress mt-2 ml-2">
                  <div class="loaded" v-bind:style="{ width: ratingLoadedPercentage[1] }"></div>
                </div>
                <p class="mt-1 ml-2">@{{ ratingPerCategory[1] }}</p>       
              </div>
              <div class="row rating-row-progress" id="first-rating-row">
                <img 
                  src="{{ url('image/icon/yellow_star.png') }}"
                  alt=""
                  class="star-image d-inline first-star">
                <p class="d-inline-block mt-1 ml-1 font-weight-bold">1</p>
                <div class="custom-progress mt-2 ml-2">
                  <div class="loaded" v-bind:style="{ width: ratingLoadedPercentage[0] }"></div>
                </div>
                <p class="mt-1 ml-2">@{{ ratingPerCategory[0] }}</p>       
              </div>
            </div>
          </div>
        </section>
        <section class="review-section mt-4">
          <div 
            id="reviews-container"
            v-for="(review, index) in reviews"
            v-if="index < loaded">
            <div>
              <div class="card-custom" id="rating-">
                <div class="rating-row">
                  <div class="row rating-row mt-1">
                    <img 
                      :src="review.rating | starURL(1)"
                      alt=""
                      class="star-image d-inline first-star">
                    <img 
                      :src="review.rating | starURL(2)"
                      alt=""
                      class="star-image d-inline second-star">
                    <img 
                      :src="review.rating | starURL(3)"
                      alt=""
                      class="star-image d-inline third-star">
                    <img 
                      :src="review.rating | starURL(4)"
                      alt=""
                      class="star-image d-inline fourth-star">
                    <img 
                      :src="review.rating | starURL(5)"
                      alt=""
                      class="star-image d-inline fifth-star">
                    <p class="reviewer d-inline-block mt-1 ml-4 font-weight-bold">@{{ review.firstName | reviewerFormattedName(review.lastName, review.isAnonymous, review.isDeleted) }}</p>
                  </div>
                </div>
                <p class="review">
                  @{{ review.review }}
                </p>
                <div class="review-date-row">
                  <p class="review-date">@{{ review.created_at | formattedDateForReviewSection }}</p>
                </div>
              </div>
            </div>
          </div>
          <div
            v-if="isLoadMoreButtonShow">
            <button
              class="mb-5 ml-2 button" id="btnLoadMore"
              @click="loadMore()">Muat Lebih</button>
          </div>
        </section>
      </div>
    </div>
  </div>
@endsection

@push('add-on-script')
  <script src="{{ url('js/view/buyer/ebook_info.js') }}"></script>
@endpush