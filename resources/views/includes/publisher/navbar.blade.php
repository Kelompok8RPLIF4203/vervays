<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{ route('dashboard') }}">
    <img src="{{ url('image/navbar/navbar_brand4.png') }}" alt="">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="input-group mr-5">
    <input 
      type="text"
      id="defaultSearchBar"
      class="form-control" 
      placeholder="Buku apa yang sedang anda cari?"
      aria-label="Amount (to the nearest dollar)">
    <div class="input-group-append">
      <span class="input-group-text">
        <i class="fa fa-search"></i>
      </span>
    </div>
  </div>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('wishlist') }}">
          <img 
            src="{{ url('image/navbar/ic_heart.png') }}" 
            alt=""
            class="icon">
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('cart') }}">
          <img 
            src="{{ url('image/navbar/ic_cart.png') }}" 
            alt=""
            class="icon">
        </a>
      </li>
      <div class="separator" id="navbarSeparator"></div>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ $firstName }}
          <img 
            src="{{ url('image/navbar/ic_account.png') }}" 
            alt=""
            class="icon">
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('bookCollection') }}">Koleksi Buku</a>
          <a class="dropdown-item linkMenjadiPublisher">Menu Publisher</a>
          <a class="dropdown-item" href="{{ route('orders') }}">Daftar Pesanan</a>
          <a class="dropdown-item" href="{{ route('account-setting') }}">Pengaturan akun</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item linkLogout" href="">Logout</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<nav class="responsive-navbar">
  <section 
    class="d-flex justify-content-between"
    id="firstResponsiveNavbarSection">
    <img 
      src="{{ url('image/navbar/toggler.png') }}" 
      alt=""
      class="icon"
      isCollapsed="1"
      id="nav-toggler">
    <a 
      href="/">
      <img src="/image/navbar/logo_vv.png" alt="">
    </a>
    <div>
      <a class="" href="{{ route('wishlist') }}">
        <img 
          src="{{ url('image/navbar/ic_heart.png') }}" 
          alt=""
          class="icon mr-3">
      </a>
      <a class="" href="{{ route('cart') }}">
        <img 
          src="{{ url('image/navbar/ic_cart.png') }}" 
          alt=""
          class="icon">
      </a>
    </div>
  </section>

  <section id="collapsedSection">
    <div class="input-group mr-5">
      <input 
        type="text"
        id="responsiveSearchBar"
        class="form-control" 
        placeholder="Buku apa yang sedang anda cari?"
        aria-label="Amount (to the nearest dollar)">
      <div class="input-group-append">
        <span class="input-group-text">
          <i class="fa fa-search"></i>
        </span>
      </div>
    </div>
    <a
      class="d-block"
      href="{{ route('bookCollection') }}">Koleksi Buku</a>
    <a
      class="d-block linkMenjadiPublisher"
      href="">Menu Publisher</a>
    <a
      class="d-block"
      href="{{ route('orders') }}">Daftar Pesanan</a>
    <a
      class="d-block"
      href="{{ route('account-setting') }}">Pengaturan Akun</a>
    <hr>
    <a
      class="d-block linkLogout"
      href="">Logout</a>
  </section>
</nav>