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
    href="{{ url('css/reset_password/begin.css') }}">
  <link rel="shortcut icon" href="/image/icon/favicon.ico" type="image/x-icon">
  <title>Mulai reset passsword</title>
</head>
<body>
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
  <div class="container">
    <h4 class="mt-4">Vervays</h4>
    <h5>Temukan Akunmu</h5>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <p>Masukkan email yang terdaftar pada Vervays</p>
    <form 
      action="/account/begin_reset_password" 
      method="POST"
      id="formResetPassword">
      @csrf
      <input type="email" class="input-email" name="email" required>
      <br>
      <input type="submit" value="Cari Akun" class="btn btn-danger mt-2">
    </form>
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
  <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
  <script 
    type="text/javascript"
    src= "{{ url('js/view/reset_password/begin.js') }}">
  </script>
</body>
</html>