@extends('layouts.publishers')

@push('add-on-style')
  <link rel="stylesheet" href="{{ url('css/publisher/edit.css') }}">
@endpush

@section('title')
  Edit Buku
@endsection

@section('content')
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <div class="container-fluid">
    <h3 class="font-weight-bold mt-3">Edit Buku</h3>
    <form
      action="{{ route('edit-book-POST') }}"
      method="POST"
      enctype="multipart/form-data"
      id="form"
      languageId="{{ $book->languageId }}"
      categoryId="{{ $book->categoryId }}">
      @csrf
      <input type="hidden" value="{{ $book->id }}" name="id">
      <div class="form-group row"> {{-- Judul --}}
        <label for="inputJudul" class="col-sm-2 col-form-label">Judul</label>
        <div class="col-sm-10">
          <input 
            type="text"
            class="form-control"
            id="inputJudul"
            name="title"
            value="{{ old('title') ?? $book->title ?? ""  }}"
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
            value="{{ old('author') ?? $book->author ?? "" }}"
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
            value="{{ old('numberOfPage') ?? $book->numberOfPage ?? "" }}"
            min="1"
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
            value="{{ old('release_at') ?? $book->release_at ?? "" }}"
            {{-- value="2013-09-18" --}}
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
        <label for="inputSinopsis" class="col-sm-2 col-form-label">Sinopsis</label>
        <div class="col-sm-10">
          <textarea 
            class="form-control" 
            id="inputSinopsis" 
            rows="3"
            name="synopsis"
            >{{old('synopsis')??$book->synopsis??""}}</textarea>
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
            value="{{ old('price') ?? $book->price ?? "" }}"
            name="price"
            required>
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
            id="inputCoverEbookFile"
            name="photo"
            accept=".jpg,.jpeg,.png">
        </div>
      </div>
      <input {{-- Submit --}}
        type="submit"
        value="Edit Buku"
        class="float-right button mb-5">
    </form>
  </div>
@endsection

@push('add-on-script')
  <script
    type="text/javascript"
    src="{{ url('js/view/publisher/edit_book.js') }}">
  </script>
@endpush