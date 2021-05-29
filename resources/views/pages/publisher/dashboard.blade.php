@extends('layouts.publishers')

@push('add-on-meta')
  <meta name="balance" content="{{ $publisher["balance"] }}">
@endpush

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/publisher/dashboard.css') }}">
@endpush

@section('title')
  Dashboard Publisher
@endsection

@section('content')
  <div class="container-fluid mt-3">
    <h4 class="d-inline">Data Penerbit</h4>
    <button 
      class="button d-inline float-right"
      id="btnUbahData">Ubah Data</button>
  </div>
  <div class="container-fluid container-data-publisher">
    <div class="row mt-3">
      <div class="col-2">
        <img 
          src="{{ $publisher["photoURL"] }}" 
          alt=""
          class="publisher-brand-image">
      </div>
      <div class="col-10">
        <table>
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $publisher["name"] }}</td>
          </tr>
          <tr>
            <td>Bergabung</td>
            <td>:</td>
            <td>{{ $publisher["month"] }} {{ $publisher["year"] }}</td>
          </tr>
          <tr>
            <td class="align-top">Deskripsi</td>
            <td class="align-top">:</td>
            <td>{{ $publisher["description"] }}</td>
          </tr>
        </table>
      </div>
    </div>
    <hr>
  </div>
  <div class="container-fluid conteiner-saldo">
    <h4 class="ml-2 d-inline">Saldo</h4>
    <h5 class="d-inline ml-5">Rp. {{ $publisher["balanceForHuman"] }}</h5>
    <button class="button d-none ml-5" id="btnCashout">Cairkan Saldo</button>
    <hr>
  </div>
  <div class="container-fluid mt-3" id="containerListBuku">
    <h4 class="d-inline">Daftar Buku</h4>
    <button 
      class="button d-inline float-right"
      @click="redirectToAddBookPage()">Tambah Buku</button>
    <table 
      class="mt-3"
      id="bookTable">
      <thead>
        <tr>
          <th>No</th>
          <th>Judul</th>
          <th>Harga</th>
          <th>Rating</th>
          <th>Terjual</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="book-table-tbody">
        <tr
          id="book-table-row"
          v-for="(book, index) in books"
          :key="book.id">
          <td>@{{ index + 1 }}</td>
          <td>@{{ book.title }}</td>
          <td>@{{ book.price | currencyFormat }}</td>
          <td>@{{ book.rating | formatRating }} (@{{ book.ratingCount }})</td>
          <td>@{{ book.soldCount }}</td>
          <td>
            <button
              class="button"
              @click="redirectToEditBookPage(book.id)">Edit</button>
            <button
              class="button btn-view-buku"
              @click="redirectToBookDetailPage(book.id, book.title)">Lihat detail</button>
            <button
              class="button btn-hapus-buku"
              @click="deleteBook(book.id, book.title)">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
@endsection

@push('add-on-script')
  <script
    src="{{ url('js/view/publisher/dashboard.js') }}"></script>
@endpush