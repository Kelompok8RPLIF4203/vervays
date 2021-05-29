<!DOCTYPE html>
<html lang="en">
<head>
  @include('includes.meta')
  @stack('add-on-meta')
  @include('includes.style')
  @stack('add-on-style')
  <link rel="shortcut icon" href="/image/icon/favicon.ico" type="image/x-icon">
  <title>@yield('title')</title>
</head>
<body>
  @include('includes.navbar')
  @yield('content')
  @include('includes.script')
  @stack('add-on-script')
</body>
</html>