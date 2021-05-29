@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/cart.css') }}">
@endpush

@section('title')
  Keranjang Belanja
@endsection

@section('content')
  <div id="loader-wrapper">
    <div class="content">
      <img 
        id="rotated-image"
        src="/image/icon/loading_screen/background.png">
    </div>
    <div class="content">
      <img src="/image/icon/loading_screen/logo_without_border.png">
    </div>
  </div>
  <div class="container-fluid exception-container d-none">
    <h2 class="text-center mt-5">Wah, keranjang belanjamu masih kosong</h2>
    <h4 class="text-center">Yuk, isi keranjang belanjamu</h4>
    <div class="button-container w-100 d-flex justify-content-center pt-2">
      <button class="btn btn-danger" id="btnSearchBook">Cari buku</button>
    </div>
  </div>
  <div class="container-fluid main-container" id="mainContainer" v-if="books.length > 0">
    <div class="row">
      <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12" id="bookContainer">
        {{-- Book Container with Vue --}}
        <transition-group
          name="fade" 
          enter-active-class="animated fadeIn" 
          leave-active-class="animated fadeOutLeft">
          <div 
            v-for="(book, index) in books"
            :key="book.bookId"
            :id="book.bookId | cardBookId">
            <div class="book-item mt-2">
              <div class="row">
                <div class="col-2">
                  <a 
                    :href="book.bookId | bookDetailURL(book.title)">
                    <img 
                      :src="book.id | ebookCoverURL(book.ebookCoverId, book.ebookCoverName)" 
                      alt=""
                      class="book-cover">
                  </a>
                </div>
                <div class="col-10">
                  <a 
                    :href="book.bookId | bookDetailURL(book.title)">
                    <h4 class="font-weight-bold book-title" data-book-id="">@{{ book.title }}</h4>
                  </a>
                  <p class="authorInfo mb-0">Ditulis oleh <span>@{{ book.author }}</span></p>
                  <p class="publisherDetail mt-1 mb-0">@{{ book.publisherName }}</p>
                  <div class="row justify-content-between mt-4">
                    <div class="col-4">
                      <p class="price d-inline">@{{ book.price | currencyFormat }}</p>
                    </div>
                    <div class="col-4">
                      <img 
                        src="{{ url('/image/ic_trash.png') }}" 
                        alt="Trash Icon"
                        class="ic-trash d-inline mr-3"
                        @click="deleteBook(book.bookId, book.title, index)">
                    </div>
                  </div>
                </div>
              </div>
              <hr>
            </div>
          </div>
        </transition-group>
      </div>
      {{-- Sidebar --}}
      <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12" id="paymentSidebar">
        <div class="card px-2 py-2">
          <div class="card-first-section row pr-3">
            <p class="d-inline col">Total harga</p>
            <p class="d-inline text-right col" id="total-amount"><span>@{{ totalAmount | currencyFormat }}</span></p>
          </div>
          <hr>
          <div class="card-second-section">
            <p>Pilih metode pembayaran</p>
            <form 
              id="orderForm"
              v-on:submit.prevent="submit()"
              class="pl-2 pb-2">
              <input type="radio" name="paymentMethod" id="BNIOption" value="1" required>
              <label for="BNIOption">BNI Virtual Account (Bisa ditansfer dari semua bank)</label><br>
              <input type="radio" name="paymentMethod" id="IndomaretOption" value="2">
              <label for="IndomaretOption">Indomaret</label><br>
              <button class="btn btn-danger w-100 mt-2" type="submit" id="btnMakeOrder">Buat Pesanan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('add-on-script')
  <script src="{{ url('js/view/buyer/cart.js') }}"></script>
@endpush