@extends('layouts.app')

@section('content')

{{-- HERO / HOME --}}
<section id="home" class="d-flex align-items-center justify-content-center text-center"
    style="margin-top: 60px; height: 100vh; background: url('images/zetsusport.jpg') no-repeat center center/cover; color: white; position: relative;">

    {{-- Overlay agar teks terlihat jelas di atas gambar --}}
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.4); z-index: 1;"></div>

    {{-- Isi konten hero --}}
    <div class="container" style="position: relative; z-index: 2;">
        <h1 class="display-3 fw-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">
            ZETSU SPORT CENTER
        </h1>
        <p class="lead fs-4" style="text-shadow: 1px 1px 8px rgba(0,0,0,0.7);">
            PUSAT KEBUGARAN & KOMUNITAS SEHAT<br>TERBAIK DI KOTA ANDA
        </p>
    </div>
</section>

{{-- INTRODUKSI / SLIDER --}}
<section class="py-5 bg-light">
<div class="container py-5">
  <div class="row align-items-center">
    <!-- Kiri: Teks -->
    <div class="col-md-6">
      <h1 class="fw-bold">MULAI GAYA HIDUP SEHAT BERSAMA ZETSU</h1>
      <p class="lead">
        Fasilitas olahraga modern, kelas harian, dan instruktur profesional untuk semua level kebugaran.
      </p>
      <a href="#" class="btn btn-dark btn-lg mt-3">Gabung Sekarang</a>
    </div>

    <!-- Kanan: Carousel -->
    <div class="col-md-6">
      <div id="heroCarousel" class="carousel slide rounded overflow-hidden" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="{{ asset('images/poto1.jpg') }}" class="d-block w-100" alt="Basket Court">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('images/poto2.jpg') }}" class="d-block w-100" alt="Gym Equipment">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('images/slider3.jpg') }}" class="d-block w-100" alt="Yoga Class">
          </div>
        </div>
        <!-- Navigasi panah -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>
  </div>
</div>

</section>

{{-- PRICE LIST --}}
<section id="price-list" class="py-5 text-center">
    <div class="container">
        <h2 class="mb-5">DAFTAR HARGA</h2>
        <div class="row g-4">
            @php
                $fields = [
                    ['title' => 'LAPANGAN FUTSAL', 'image' => 'images/putsal.jpg', 'desc' => 'OUTDOOR ⚽ RUMPUT SINTETIS', 'price' => 'Rp 250.000 / JAM'],
                    ['title' => 'LAPANGAN BASKET', 'image' => 'images/basket.jpeg', 'desc' => 'INDOOR 🏀 LANTAI KAYU', 'price' => 'Rp 200.000 / JAM'],
                    ['title' => 'LAPANGAN TENIS', 'image' =>  'images/badmin.webp', 'desc' => 'INDOOR 🎾 LANTAI BETON', 'price' => 'Rp 180.000 / JAM'],
                    ['title' => 'LAPANGAN BADMINTON', 'image' => 'images/tenis.jpg', 'desc' => 'INDOOR 🟩 LANTAI VINYL', 'price' => 'Rp 150.000 / JAM']
                ];
            @endphp
            @foreach($fields as $field)
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <img src="{{ $field['image'] }}" class="card-img-top" alt="{{ $field['title'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $field['title'] }}</h5>
                        <p>{{ $field['desc'] }}</p>
                        <p class="fw-bold text-success">{{ $field['price'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- BOOK --}}
<section id="booking" class="py-5 bg-light text-center">
    <div class="container">
        <h2>BOOKING JADWAL</h2>
        <p>Pilih Tanggal & Waktu Untuk Booking Lapangan.</p>
        <a href="booking" class="btn btn-dark">Mulai Booking</a>
    </div>
</section>

{{-- ABOUT --}}
<section id="about" class="py-5 text-center">
    <div class="container">
        <h2>TENTANG KAMI</h2>
        <p class="lead">Kami adalah platform penyewaan lapangan olahraga terpercaya. Menyediakan layanan booking online berbagai jenis lapangan seperti futsal, bulutangkis, basket, dan tenis. Dengan dukungan lokasi strategis dan sistem mudah, kami hadir untuk memenuhi kebutuhan olahraga Anda.</p>
    </div>
</section>

{{-- CONTACT --}}
<section id="contact" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">KONTAK & LOKASI</h2>
        <div class="row text-center">
            <div class="col-md-4">
                <p><strong>Email:</strong><br>zetsusport99@gmail.com</p>
                <p><strong>Telepon:</strong><br>+62 899 7654 7897</p>
                <p><strong>Alamat:</strong><br>Jl. Kebanggaan Raya 1 No 99</p>
            </div>
            <div class="col-md-8">
                <iframe src="https://www.google.com/maps?q=Zetsu+Sport+Center&output=embed" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <h4>ADDRESS</h4>
        <div class="row">
            <div class="col-md-4">
                <p>Jl. Sukasuka Kita No 2 Kramat Batu - Kebayoran Baru, Jakarta 12130</p>
                <iframe src="https://www.google.com/maps?q=Jl.+Sukasuka+Kita+No+2+Kramat+Batu,+Kebayoran+Baru,+Jakarta+12130&output=embed" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="col-md-4">
                <p>Jl. Manjasari No 7 Sumur Api - Kebayoran Aja, Jakarta 12198</p>
                <iframe src="https://www.google.com/maps?q=Jl.+Manjasari+No+7+Sumur+Api,+Kebayoran+Aja,+Jakarta+12198&output=embed" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="col-md-4">
                <p>Jl. Jagorawi Maju No 5 Topi - Kebayoran Lama, Jakarta 12145</p>
                <iframe src="https://www.google.com/maps?q=Jl.+Jagorawi+Maju+No+5+Topi,+Kebayoran+Lama,+Jakarta+12145&output=embed" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
        <p class="mt-3">COPYRIGHT © 2025 ALL RIGHTS RESERVED BY ZETSU SPORT CENTER</p>
    </div>
</footer>


@endsection
