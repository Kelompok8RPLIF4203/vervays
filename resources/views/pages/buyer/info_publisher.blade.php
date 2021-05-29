@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/info_publisher.css') }}">
@endpush

@section('title')
  Penerbit {{ $publisher["name"] }}
@endsection

@section('content')
  <div class="container-fluid container-data-publisher">
    <div class="row mt-3">
      <div class="col-2">
        <img 
          src="{{ $publisher["photoURL"] }}" 
          alt=""
          class="publisher-brand-image">
      </div>
      <div class="col-10">
        <h5 id="publisher-name-info" class="font-weight-bold">{{ $publisher["name"] }}</h5>
        <p id="publisher-join-info">Bergabung {{ $publisher["month"] }} {{ $publisher["year"] }}</p>
        <p id="publisher-desc-info">{{ $publisher["description"] }}</p>
      </div>
    </div>
    <hr>
  </div>
  <div class="container-fluid mt-3">
    <h4 class="d-inline">Ebook</h4>
  </div>
  @foreach ($books as $book)
    <div class="container-fluid">
      <div 
        class="row card-book"
        rating="1.0"
        id="book-card-{{ $book["id"] }}">
        <div class="col-2">
          <img 
            src="{{ $book["imageURL"] }}" 
            alt=""
            class="ebook-image"
            book-id="{{ $book["id"] }}">
        </div>
        <div class="col-10">
          <h4
            class="book-title"
            book-id="">{{ $book["title"] }}</h4>
          <p
            class="font-weight-bold author-info"><span>Ditulis oleh </span><span class="author-text">{{ $book["author"] }}</span></p>
          <p
            class="synopsis">{{ $book["synopsis"] }}</p>
          <div class="book-rating-container row">
            <div class="star-container d-inline">
              <img 
                src="{{ url('image/icon/blank_star.png') }}"
                alt=""
                class="star-image first-star">
              <img 
                src="{{ url('image/icon/blank_star.png') }}"
                alt=""
                class="star-image second-star">
              <img 
                src="{{ url('image/icon/blank_star.png') }}"
                alt=""
                class="star-image third-star">
              <img 
                src="{{ url('image/icon/blank_star.png') }}"
                alt=""
                class="star-image fourth-star">
              <img
                src="{{ url('image/icon/blank_star.png') }}"
                alt=""
                class="star-image fifth-star">
            </div>
            <p class="d-inline-block ml-3"><span class="rating">{{ $book["rating"] }}</span> &emsp; (<span>{{ $book["ratingCount"] }}</span> Ulasan) &emsp; <span>{{ $book["soldCount"] }}</span>x terjual</p>
          </div>
          <p 
            class="price font-weight-bold d-inline">Rp. {{ $book["price"] }}</p>
        </div>
      </div>
    </div>
    @endforeach
@endsection

@push('add-on-script')
  <script 
    type="text/javascript"
    src= "{{ url('js/view/buyer/info_publisher.js') }}">
  </script>
@endpush