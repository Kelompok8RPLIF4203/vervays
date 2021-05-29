@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/book_collection.css') }}">
@endpush

@section('title')
  Koleksi Buku
@endsection

@section('content')
	<div class="container-fluid exception-container d-none">
		<h2 class="text-center mt-5">Wah, kamu belum punya buku</h2>
		<h4 class="text-center">Yuk, beli buku kesukaanmu</h4>
		<div class="button-container w-100 d-flex justify-content-center pt-2">
			<button class="btn btn-danger" id="btnSearchBook" onclick="window.location.href = '/'">Cari buku</button>
		</div>
	</div>
  <div class="container-fluid main-container d-none">
    <h2 class="mt-2 font-weight-bold">Koleksi Buku</h2>
    <div class="row">
      <div 
        class="card-book col-6 col-sm-6 col-md-3 col-lg-2 col-xl-2 mb-3" 
        v-for="(book, index) in books"
        @mouseenter="onMouseEnter(index)"
        @mouseleave="onMouseLeave(index)">
        <div class="card">
          <a 
            :href="book.id | bookDetailURL(book.title)" 
            class="imageLink">
            <img 
              :src="book.ebookCoverId | bookCoverURL(book.ebookCoverFileName)" 
              alt=""
              class="book-cover">
          </a>
          <div class="info-container">
            <a 
              :href="book.id | bookDetailURL(book.title)" 
              class="titleLink">
              <p class="title mx-1">@{{ book.title }}</p>
            </a>
            <p class="author mx-1">@{{ book.author }}</p>
          </div>
          <div
            class="d-flex justify-content-center"
            v-if="books[index].isBtnShowed">
            <button 
              class="button mb-1 mx-auto btnRead"
              @click="redirectToReadBookPage(book.id)">Baca Buku</button>
          </div>
          <div
            class="d-flex justify-content-center" 
            v-if="book.didTheUserGiveAReview === false && books[index].isBtnShowed">
            <button 
              class="button mx-auto btnGiveRating"
              @click="redirectToGiveRatingPage(book.id)">Beri Ulasan</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('add-on-script')
  <script 
    type="text/javascript"
    src= "{{ url('js/view/buyer/book_collection.js') }}">
  </script>
@endpush