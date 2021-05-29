@extends('layouts.publishers')

@push('add-on-style')
  <link rel="stylesheet" href="{{ url('css/publisher/edit.css') }}">
@endpush

@section('title')
  Input Buku
@endsection

@section('content')
  @if($errors->any())
    @foreach ($errors->all() as $error)
      {{ $error }}
    @endforeach
  @endif
  <div class="container-fluid">
    <h3 class="font-weight-bold mt-3">Tambah Buku</h3>
    <form
      action="{{ route('input-book-POST') }}"
      method="POST"
      enctype="multipart/form-data">
      @csrf
      <div class="form-group row"> {{-- Judul --}}
        <label for="inputJudul" class="col-sm-2 col-form-label">Judul</label>
        <div class="col-sm-10">
          <input 
            type="text"
            class="form-control"
            id="inputJudul"
            name="title"
            value="{{ old('title') }}"
            required>
        </div>
      </div>
      <div class="form-group row"> {{-- Penulis --}}
        <label for="inputPenulis" class="col-sm-2 col-form-label">Penulis</label>
        <div class="col-sm-10">
          <input 
            type="text"
            class="form-control"
            id="inputPenulis"
            value="{{ old('author') }}"
            name="author"
            required>
        </div>
      </div>
      <div class="form-group row"> {{-- Bahasa --}}
        <label for="inputBahasa" class="col-sm-2 col-form-label">Bahasa</label>
        <div class="col-sm-10">
          <select 
            name="languageId" 
            id="inputBahasa"
            value="{{ old('languageId') }}"
            class="custom-select"
            required>
            @foreach ($languages as $language)
              <option value="{{$language->id}}">{{$language->name}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row"> {{-- Jumlah Halaman --}}
        <label for="inputJumlahHalaman" class="col-sm-2 col-form-label">Jumlah Halaman</label>
        <div class="col-sm-10">
          <input 
            type="number"
            class="form-control"
            id="inputJumlahHalaman"
            value="{{ old('numberOfPage') }}"
            name="numberOfPage"
            required>
        </div>
      </div>
      <div class="form-group row"> {{-- Tanggal Rilis --}}
        <label for="inputTanggalRilis" class="col-sm-2 col-form-label">Tanggal rilis</label>
        <div class="col-sm-10">
          <input 
            type="date"
            class="form-control"
            id="inputTanggalRilis"
            max="{{ $currentDate }}"
            name="release_at"
            required>
        </div>
      </div>
      <div class="form-group row"> {{-- Kategori --}}
        <label for="inputCategory" class="col-sm-2 col-form-label">Kategori</label>
        <div class="col-sm-10">
          <select 
            name="categoryId" 
            id="inputCategory"
            class="custom-select"
            value="{{ old('categoryId') }}"
            required>
            @foreach ($categories as $category)
              <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row"> {{-- Sinopsis --}}
        <label for="inputSinopsis" class="col-sm-2 col-form-label">Abstraksi</label>
        <div class="col-sm-10">
          <textarea 
            class="form-control" 
            id="inputSinopsis" 
            rows="3"
            name="synopsis"
            >{{old('synopsis')}}</textarea>
        </div>
      </div>
      <div class="form-group row"> {{-- Harga --}}
        <label for="inputHarga" class="col-sm-2 col-form-label">Harga</label>
        <div class="col-sm-10">
          <input 
            type="number"
            class="form-control"
            min="1"
            id="inputHarga"
            value="{{ old('price') }}"
            name="price"
            required>
        </div>
      </div>
      <div class="form-group row"> {{-- File Ebook --}}
        <label for="inputEbookFile" class="col-sm-2 col-form-label">File Ebook</label>
        <div class="col-sm-10">
          <input 
            type="file"
            class="form-control-file"
            id="inputEbookFile"
            name="ebookFile"
            accept=".pdf">
        </div>
      </div>
      <div class="form-group row"> {{-- File Sample Ebook --}}
        <label for="inputSampleEbookFile" class="col-sm-2 col-form-label">File Sample Ebook</label>
        <div class="col-sm-10">
          <input 
            type="file"
            class="form-control-file"
            id="inputSampleEbookFile"
            name="sampleEbookFile"
            accept=".pdf">
        </div>
      </div>
      <div class="form-group row"> {{-- Foto Cover --}}
        <label for="inputSampleEbookFile" class="col-sm-2 col-form-label">Foto Cover Ebook</label>
        <div class="col-sm-10">
          <input 
            type="file"
            class="form-control-file"
            id="photoCoverFile"
            name="photo"
            accept=".jpg,.jpeg,.png">
        </div>
      </div>
      <input {{-- Submit --}}
        type="submit"
        value="Tambah Buku"
        class="float-right button mb-5">
    </form>
  </div>
@endsection

@push('add-on-script')
  <script
    type="text/javascript"
    src="{{ url('js/view/publisher/input_book.js') }}"></script>
@endpush