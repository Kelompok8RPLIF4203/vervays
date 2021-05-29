@extends('layouts.app')

@push('add-on-meta')
  <meta name="book-id" content="{{ $book->id }}">
  <meta name="userFullNameWithoutSpace" content="{{ $userFullNameWithoutSpace }}">
@endpush

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/give_review.css') }}">
  <link 
    href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" 
    rel="stylesheet">
@endpush

@section('title')
  Ulas Buku
@endsection

@section('content')
  <div class="container-fluid">
    <h4 class="font-weight-bold">Ulas Buku</h4>
    <div class="row mb-4">
      <div class="col-1">
        <img 
          src="{{ $book->ebookCoverURL }}" 
          alt=""
          class="book-cover w-100">
      </div>
      <div class="col-11">
        <p class="mt-1 mb-1 font-weight-bold">{{ $book->title }}</p>
        <p class="author-info">Ditulis oleh <span>{{ $book->author }}</span></p>
        <p class="publisher-info">{{ $book->publisherName }}</p>
      </div>
    </div>
    <form id="form">
      @csrf
      <h5 class="heading-rating">Beri Rating</h5>
      <div class="form-row mt-0 mb-1">
        <div class="col-12 star-container mb-3">
          <img 
            src="{{ url('image/icon/yellow_star.png') }}"
            alt=""
            class="star-image" id="first-star">
          <img 
            src="{{ url('image/icon/yellow_star.png') }}"
            alt=""
            class="star-image" id="second-star">
          <img 
            src="{{ url('image/icon/yellow_star.png') }}"
            alt=""
            class="star-image" id="third-star">
          <img 
            src="{{ url('image/icon/yellow_star.png') }}"
            alt=""
            class="star-image" id="fourth-star">
          <img
            src="{{ url('image/icon/yellow_star.png') }}"
            alt=""
            class="star-image" id="fifth-star">
          <p class="ml-3 d-inline" id="ratingText">Keren</p>
        </div>
      </div>
      <div class="form-group">
        <label for="reviewTextArea"><h5>Tulis Ulasan</h5></label> <br>
        <textarea class="w-100 form-control" rows="3" id="reviewTextArea" required></textarea>
      </div>
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="anonymousToggle">
        <label class="custom-control-label" for="anonymousToggle" id="toggleLabel">Ulas sebagai anonim (Nama akan ditampilkan sebagai <span>***</span>)</label>
      </div>
      <input type="hidden" name="bookId" value="{{ $book->id }}" id="inputBookId" required>
      <input type="hidden" name="rating" value="5" id="inputRating" required>
      <input type="hidden" name="isAnonymous" value="0" id="inputIsAnonymous" required>
      <button type="submit" class="btn btn-danger float-right mb-3">Simpan</button>
    </form>
  </div>
@endsection

@push('add-on-script')
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <script src="{{ url('js/view/buyer/give_review.js') }}"></script>
@endpush