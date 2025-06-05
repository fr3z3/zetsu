<!DOCTYPE html>
<html lang="en">
<head>
  <title>Zetsu Sport Center</title>
  @vite('resources/css/app.css')

  <style>
    html {
      scroll-behavior: smooth;
    }

    .carousel-inner img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .carousel-item {
      height: 400px;
    }

    .navbar {
      padding-top: 0.2rem;
      padding-bottom: 0.2rem;
      height: 60px;
      overflow: visible;
      z-index: 9999;
    }

    .navbar-brand img {
      height: 180px;
      width: auto;
      margin-top: 0px;
    }

    .navbar-nav .nav-link {
      padding-top: 0.2rem;
      padding-bottom: 0.2rem;
      font-size: 0.95rem;
    }

    main {
      padding-top: 80px; /* supaya konten tidak tertutup navbar */
    }

    section {
      scroll-margin-top: 80px; /* kasih jarak agar tidak ketutup navbar saat klik menu */
    }
  </style>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FullCalendar CSS -->
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />

  <!-- Styles dari halaman child -->
  @stack('styles')
</head>
<body class="font-sans">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top" style="background-color: #f6f1fa;">
  <div class="container d-flex justify-content-between align-items-center">

    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{ asset('images/jetsu.png') }}" alt="Zetsu Logo" width="50" height="50" class="me-2">
    </a>

    <!-- Centered Menu -->
    <div class="d-none d-lg-flex justify-content-center flex-grow-1">
      <ul class="navbar-nav gap-4">
        <li class="nav-item">
        <a class="nav-link" href="{{ url('/#home') }}">HOME</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{ url('/#price-list') }}">PRICE LIST</a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/booking') }}" class="nav-link">BOOK</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{ url('/#about') }}">ABOUT</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{ url('/#contact') }}">CONTACT</a>
        </li>
      </ul>
    </div>

    <!-- Buttons -->
    @auth
    <div class="dropdown">
      <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
        {{ Auth::user()->name }}
      </button>
      <ul class="dropdown-menu" aria-labelledby="userMenu">
      <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
      <li><a class="dropdown-item" href="{{ route('mybooking') }}">My Booking</a></li>

      {{-- Tambahkan untuk admin --}}
    @if(Auth::user()->is_admin)
      <li><a class="dropdown-item" href="{{ route('admin.all-bookings') }}">All Bookings</a></li>
    @endif
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item">Logout</button>
          </form>
        </li>
      </ul>
    </div>
@else
    <div class="d-flex gap-2">
      <a href="/login" class="btn btn-light btn-sm shadow-sm">SIGN IN</a>
      <a href="/register" class="btn btn-secondary btn-sm shadow-sm">SIGN UP</a>
    </div>
@endauth

  </div>
</nav>

<!-- Konten utama -->
<main class="p-6">
  @yield('content')
</main>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>

<!-- Scripts dari halaman child -->
@stack('scripts')

</body>
</html>
