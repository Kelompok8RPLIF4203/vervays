<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link 
    rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" 
    crossorigin="anonymous">
  <link 
    rel="stylesheet" 
    href="{{ url('css/style.css') }}">
  <link 
    href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;600;700;800&display=swap" 
    rel="stylesheet">
  <link 
    rel="stylesheet" 
    href="{{ url('css/reset_password/change_password.css') }}">
  <link rel="shortcut icon" href="/image/icon/favicon.ico" type="image/x-icon">
  <title>Change Password</title>
</head>
<body>
  <div class="container">
    <nav class="navbar navbar-light bg-light">
      <a class="navbar-brand" href="#">
        <img src="{{ url('image/navbar/navbar_brand4.png') }}" alt="" style="height: 40px;">
      </a>
    </nav>
    <div class="col-md-6 mx-auto mt-5">
      <div class="card card-body">
        <h4 class="mt-2 d-flex justify-content-center">Ubah Password</h4>
        <form action="/account/reset/password/from/email" method="POST" id="changePasswordForm">
          @csrf
          <input type="hidden" name="id" value="{{ $id ?? '' }}">
          {{-- <label for="">Masukkan password baru</label>
          <input type="password" name="password" min="8"> --}}
          <div class="form-group">
            <label for="password">Password baru</label>
            <input
              type="password"
              id="password"
              name="password"
              class="form-control"
              minlength="8"
              required>
          </div>
          <div class="form-group">
            <label for="repassword">Ulangi password baru</label>
            <input
              type="password"
              id="repassword"
              name="repassword"
              class="form-control"
              required>
            <small id="repasswordHelp" class="form-text text-danger d-none">Password tidak sama</small>
          </div>
          <div class="text-center">
            <input type="submit" class="btn btn-danger" value="Ubah Password">
          </div>
        </form>
      </div>
    </div>
  </div>
  <script 
    src="https://code.jquery.com/jquery-3.5.1.slim.min.js" 
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" 
    crossorigin="anonymous">
  </script>
  <script 
    src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
    crossorigin="anonymous">
  </script>
  <script 
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" 
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" 
    crossorigin="anonymous">
  </script>
  <script 
    type="text/javascript"
    src= "{{ url('js/view/reset_password/change_password.js') }}">
  </script>
</body>
</html>