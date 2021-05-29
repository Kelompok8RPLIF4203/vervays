@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/dashboard.css') }}">
@endpush

@section('title')
  Vervays ebook store
@endsection

@section('content')
  @isset($bestsellerBook)
    <div class="container-fluid mt-1"> {{-- Bestseller --}}
      <h2>Bestseller</h2>
      <div class="row">
        @foreach ($bestsellerBook as $book)
          <div 
            class="col-6 col-sm-6 col-md-3 col-lg-2 col-xl-2 book-card"
            rating="{{ $book["rating"] }}"
            id="book-card-{{ $book["id"] }}-bestseller">
            <img 
              src="{{ $book["imageURL"] }}" 
              alt=""
              class="book-cover">
            <p class="bookTitle">{{ $book["title"] }}</p>
            <p class="bookAuthor">{{ $book["author"] }}</p>
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline first-star">
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline second-star">
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline third-star">
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline fourth-star">
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline fifth-star">
            <p class="rating-text d-inline">({{ $book["rating"] }})</p>
            <p class="price mt-2">Rp. {{ $book["price"] }}</p>
          </div>
          @endforeach
      </div>
    </div>
  @endisset
  
  @isset($newestBook) {{-- Terbaru --}}
    <div class="container-fluid mt-3">
      <h2>Buku Terbaru</h2>
      <div class="row">
        @foreach ($newestBook as $book)
          <div 
            class="col-6 col-sm-6 col-md-3 col-lg-2 col-xl-2 book-card"
            rating="{{ $book["rating"] }}"
            id="book-card-{{ $book["id"] }}-newest">
            <img 
              src="{{ $book["imageURL"] }}"
              alt=""
              class="book-cover">
            <p class="bookTitle">{{ $book["title"] }}</p>
            <p class="bookAuthor">{{ $book["author"] }}</p>
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline first-star">
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline second-star">
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline third-star">
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline fourth-star">
            <img 
              src="{{ url('image/icon/blank_star.png') }}"
              alt=""
              class="star-image d-inline fifth-star">
            <p class="rating-text d-inline">({{ $book["rating"] }})</p>
            <p class="price mt-2">Rp. {{ $book["price"] }}</p>
          </div>
        @endforeach
      </div> {{-- end row --}}
    </div> {{-- end container --}}
  @endisset

  @isset($editorChoicesBook)
    <div class="container-fluid mt-3 mb-3"> {{-- Pilihan Editor --}}
      <h2>Pilihan Editor</h2>
      <div class="row">
        @foreach ($editorChoicesBook as $book)
        <div 
          class="col-6 col-sm-6 col-md-3 col-lg-2 col-xl-2 book-card"
          rating="{{ $book["rating"] }}"
          id="book-card-{{ $book["id"] }}-editor-choice">
          <img 
            src="{{ $book["imageURL"] }}" 
            alt=""
            class="book-cover">
          <p class="bookTitle">{{ $book["title"] }}</p>
          <p class="bookAuthor">{{ $book["author"] }}</p>
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline first-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline second-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline third-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline fourth-star">
          <img 
            src="{{ url('image/icon/blank_star.png') }}"
            alt=""
            class="star-image d-inline fifth-star">
          <p class="rating-text d-inline">({{ $book["rating"] }})</p>
          <p class="price mt-2">Rp. {{ $book["price"] }}</p>
        </div>
        @endforeach
        
      </div>
    </div>
  @endisset
@endsection

@push('add-on-script')
  <script 
    type="text/javascript"
    src= "{{ url('js/view/buyer/dashboard.js') }}">
  </script>
@endpush