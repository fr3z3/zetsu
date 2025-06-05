@extends('layouts.app')

@section('content')
<main>
<div class="container">
    <h1 class="mb-4">Semua Booking</h1>

    @foreach($bookings as $booking)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Lapangan: {{ $booking->lapangan }}</h5>
                <p class="card-text">
                    Tanggal: {{ $booking->tanggal }} <br>
                    Jam: {{ $booking->jam }} <br>
                    Durasi: {{ $booking->durasi }} jam <br>
                    Metode Pembayaran: {{ $booking->pembayaran }} <br>
                    Dibooking oleh: {{ $booking->user->name ?? 'Tidak diketahui' }}
                </p>
            </div>
        </div>
    @endforeach
</div>
</main>
@endsection
