@extends('layouts.app')

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/info_order.css') }}">
@endpush

@section('title')
  Pesanan {{ $order->id }}
@endsection

@section('content')
  <div class="container-fluid">
		<section id="first-section" class="mb-3">
			<div class="d-flex">
				<div class="left-row">
					<p>Nomor Transaksi&emsp;</p>
					<p>Waktu Pemesanan&emsp;</p>
					<p>Status&emsp;</p>
					<p>Total Harga&emsp;</p>
					<p>Metode Pembayaran&emsp;</p>
					<p>{{ $order->codeName }}&emsp;</p>
					<p class="expiredTimeInfo">Tenggat pembayaran&emsp;</p>
				</div>
				<div class="middle-row">
					<p>:</p>
					<p>:</p>
					<p>:</p>
					<p>:</p>
					<p>:</p>
					<p>:</p>
					<p class="expiredTimeInfo">:</p>
				</div>
				<div class="right-row pl-3">
					<p id="id-info">{{ $order->id }}</p>
					<p id="created-at-info"><span id="createdDateInfo">{{ $order->createdDate }}</span> <span id="createdTimeInfo">{{ $order->createdTime }}</span></p>
					<p id="order-status-info">{{ $order->status }}</p>
					<p>Rp. {{ $order->totalPrice }}</p>
					<p>{{ $order->paymentMethod }}</p>
					<p>{{ $order->paymentCode }}</p>
					<p class="expiredTimeInfo"><span id="expiredDateInfo">{{ $order->expiredDate }}</span> <span id="expiredTimeInfo">{{ $order->expiredTime }}</span></p>
				</div>
			</div>
		</section>
		<section id="second-section">
			<h4 class="font-weight-bold">Daftar Buku</h4>
			@foreach ($books as $book)
				<div class="book-item book-item-container" data-book-id="{{ $book->id }}" id="book-item-{{ $book->id }}">
					<div class="row mt-3 justify-content-between">
						<div class="col-2">
							<img 
								src="{{ $book->coverURL }}" 
								alt="book cover" 
								class="book-cover">
						</div>
						<div class="col-10">
							<h5 class="title font-weight-bold">{{ $book->title }}</h5>
							<p class="author-info">Ditulis oleh <span>{{ $book->author }}</span></p>
							<p class="publisher">{{ $book->publisherName }}</p>
							<h5 class="float-right mt-5 price font-weight-bold">Rp. <span>{{ $book->price }}</span></h5>
						</div>
					</div>
					<hr>
				</div>
			@endforeach
		</section>
		<section class="third-section">
			<h4 class="font-weight-bold mb-2">Cara Bayar</h4>
			@foreach ($arrPaymentMethod as $paymentMethod)
				<h6 class="font-weight-bold">Melalui {{ $paymentMethod->name }}</h6>
				<ol>
					@foreach ($arrStep[$paymentMethod->name] as $step)
						<li>{{ $step }}</li>
					@endforeach
				</ol>
			@endforeach
		</section>
  </div>
@endsection

@push('add-on-script')
  <script src="{{ url('js/view/buyer/info_order.js') }}"></script>
@endpush