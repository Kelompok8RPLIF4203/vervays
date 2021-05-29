<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="bookId" content="{{ $bookId }}">
  <meta name="ebookURL" content="{{ $ebookURL }}">
  <title>{{ $title }}</title>
  <link
    rel="stylesheet"
    href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
    crossorigin="anonymous"
  />
  <link rel="stylesheet" href="{{ url('/css/buyer/read.css') }}" />
</head>
<body>

  <div class="controller">
    <div class="controller-contain">
      <button class="btn" id="prev-page">
        <i class="fas fa-arrow-circle-left"></i> Prev Page
      </button>
      <span class="page-info">
        Halaman <span id="page-num"></span> dari <span id="page-count"></span> halaman
      </span>
      <button class="btn" id="next-page">
        Next Page <i class="fas fa-arrow-circle-right"></i>
      </button>
    </div>
  </div>
  <div class="canvas-container">
    <canvas id="pdf-render"></canvas>
  </div>

  
  <script
    src="{{ url('js/library/jquery-3.4.1.min.js') }}">
  </script>
  <script
    src="{{ url('js/csrf_token.js') }}">
  </script>
  <script src="{{ url('/js/library/pdf.js') }}"></script>
  <script src="{{ url('/js/view/buyer/read_book.js') }}"></script>
</body>
</html>