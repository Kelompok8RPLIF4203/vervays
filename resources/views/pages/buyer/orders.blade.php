@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/order.css') }}">
@endpush

@section('title')
  Daftar Transaksi
@endsection

@section('content')
  <div class="container-fluid">
    <div class="exception-container d-none">
      <h2 class="text-center mt-5">Wah, kamu belum pernah membeli buku</h2>
      <h4 class="text-center">Yuk, beli buku kesukaanmu</h4>
      <div class="button-container w-100 d-flex justify-content-center pt-2">
        <button class="btn btn-danger" id="btnSearchBook">Cari buku</button>
      </div>
    </div>
    <div class="main-container d-none">
      <h3 class="mt-2">Daftar Pesanan</h3>
      <template id="orderCardTemplate">
        <div class="order-card mb-3" data-order-id="" id="">
          <div class="order-status-container">
            <p class="order-status text-center">Menunggu Pembayaran</p>
          </div>
          <div class="main-info">
            <section class="first-section row">
              <div class="col">
                <p class="ml-2 date">2 Mei 2020</p>
                <p class="ml-2 order-id">1241</p>
              </div>
              <div class="col second-col">
                <button class="btnLihatDetail  button mr-2" data-order-id>Lihat Detail</button>
              </div>
            </section>
            <hr>
            <section class="second-section">
              {{-- diisi item buku --}}
            </section>
            <section class="third-section">
              <p class="total-price text-right mt-1">Total <span>72.000</span></p>
            </section>
          </div>
        </div>
      </template>
      <template id="bookItemTemplate">
        <div class="book-item book-item-container">
          <div class="row mt-3 justify-content-between">
            <div class="col-2">
              <img 
                src="{{ url('/image/book_placeholder.png') }}" 
                alt="book cover" 
                class="book-cover">
            </div>
            <div class="col-10">
              <p class="title">Judul Buku</p>
              <p class="author-info">Ditulis oleh <span>Nama Penulis</span></p>
              <p class="publisher">Penerbit</p>
              <p class="float-right mt-5 price"><span>34.000</span></p>
            </div>
          </div>
          <hr>
        </div>
      </template>
    </div>
  </div>
@endsection

@push('add-on-script')
  <script 
    type="text/javascript"
    src= "{{ url('js/view/buyer/orders.js') }}">
  </script>
@endpush