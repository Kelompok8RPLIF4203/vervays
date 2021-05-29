<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	@include('includes.style')
	<link rel="stylesheet" href="{{ url('css/email_verification.css') }}">
	<link rel="shortcut icon" href="/image/icon/favicon.ico" type="image/x-icon">
	<title>Verifikasi Email</title>
</head>
<body>
  <h1 class="text-center mt-5">Vervays</h1>
  <h6 class="text-center mt-3">Untuk menggunakan layanan Vervays, anda harus memverifikasi email terlebih dahulu</h6>
	<h6 class="text-center mt-1">Email verifikasi sudah dikirimkan ke {{ $email }}</h6>
	<button class="float-right button mr-4 d-block" id="btnLogout">Logout</button>
  @include('includes.script')
  <script
	  type="text/javascript"
	  src="{{ url('js/view/email_verification.js') }}"></script>
</body>
</html>