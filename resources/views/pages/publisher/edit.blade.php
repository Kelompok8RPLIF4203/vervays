@extends('layouts.publishers')

@push('add-on-style')
  <link rel="stylesheet" href="{{ url('css/publisher/edit.css') }}">
@endpush

@section('title')
  Edit Data Publisher
@endsection

@section('content')
  @if($errors->any())
    @foreach ($errors->all() as $error)
      {{ $error }}
    @endforeach
  @endif
  <div class="container-fluid">
    <h3 class="font-weight-bold mt-3">Ubah data publisher</h3>
    <form
      action="{{ route('edit-data-publisher-POST') }}"
      method="POST"
      enctype="multipart/form-data">
      @csrf
      <div class="form-group row">
        <label for="foto" class="col-sm-2 col-form-label">Foto</label>
        <div class="col-sm-10">
          <input 
            type="file"
            class="form-control-file d-inline"
            id="foto"
            name="foto"
            accept=".jpg,.jpeg,.png">
          {{-- <p class="d-inline">*Bisa dikosongkan</p> --}}
        </div>
      </div>
      <div class="form-group row">
        <label for="inputNama" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
          <input 
            type="text"
            class="form-control"
            id="inputNama"
            name="nama"
            value="{{ $publisher["name"] ?? ""}}">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputDeskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
        <div class="col-sm-10">
          <textarea 
            class="form-control" 
            id="inputDeskripsi" 
            rows="3"
            name="deskripsi"
            >{{$publisher["description"] ?? ""}}</textarea>
        </div>
      </div>
      <input 
        type="submit"
        value="Ubah"
        class="float-right button">
    </form>
  </div>
@endsection

@push('add-on-script')
  
@endpush