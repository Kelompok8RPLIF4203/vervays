@extends('layouts.publishers')

@push('add-on-style')
  {{-- <link 
    rel="stylesheet" 
    href="{{ url('css/publisher/dashboard.css') }}"> --}}
@endpush

@section('title')
  Cashout
@endsection

@section('content')
<div class="container-fluid">
  <h3 class="font-weight-bold mt-3">Pencairan Saldo</h3>
  <form id="form">
    <div class="form-group row"> 
      <label for="totalBalance" class="col-sm-2 col-form-label">Total Saldo</label>
      <div class="col-sm-10">
        <p id="totalBalance" class="col-sm-2 col-form-label pl-0"><span class="info-balance">{{ $balance }}</span></p>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputAmount" class="col-sm-2 col-form-label">Jumlah Pencairan</label>
      <div class="col-sm-10">
        <input 
          type="number"
          class="form-control"
          id="inputAmount"
          name="amount"
          min="30000"
          max="{{ $balance }}"
          value=""
          required>
        <small>Minimal Rp. 30.000</small>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputBank" class="col-sm-2 col-form-label">Bank Tujuan</label>
      <div class="col-sm-10">
        <select name="bank" id="inputBank" class="form-control" required>
          @for ($i = 0; $i < count($banks); $i++)
            <option value="{{ $banks[$i]->id }}"
              @if ($i == 0)
                selected
              @endif
              >{{ $banks[$i]->name }}</option>
          @endfor
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputAccountOwner" class="col-sm-2 col-form-label">Nama pemilik rekening</label>
      <div class="col-sm-10">
        <input 
          type="text"
          class="form-control"
          id="inputAccountOwner"
          name="accountOwner"
          value=""
          required>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputAccountNumber" class="col-sm-2 col-form-label">Nomor rekening</label>
      <div class="col-sm-10">
        <input 
          type="number"
          class="form-control"
          id="inputAccountNumber"
          name="accountNumber"
          value=""
          required>
      </div>
    </div>
    <input
      type="submit"
      value="Cairkan"
      class="float-right btn btn-danger mr-2">
  </form>
</div>
@endsection

@push('add-on-script')
  <script
    src="{{ url('js/view/publisher/cashout.js') }}"></script>
@endpush