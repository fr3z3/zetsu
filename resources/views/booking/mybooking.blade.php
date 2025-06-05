@extends('layouts.app')

@section('content')
<main>
<div class="container mx-auto px-4 mt-24">
    <h2 id="my-bookings" class="scroll-mt-32 text-2xl font-bold">My Bookings</h2>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($bookings->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
            @foreach($bookings as $booking)
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-xl font-semibold mb-2">Lapangan: {{ $booking->lapangan }}</h3>
                    <p><strong>Tanggal:</strong> {{ $booking->tanggal }}</p>
                    <p><strong>Jam:</strong> {{ $booking->jam ?? '-' }}</p>
                    <p><strong>Durasi:</strong> {{ $booking->durasi }} jam</p>
                    <p><strong>Pembayaran:</strong> {{ ucfirst($booking->pembayaran ?? '-') }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($booking->status ?? '-') }}</p>

                    <!-- Tombol Cancel -->
                    @if(
                        (\Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($booking->tanggal)->subDay()))
                        && (strtolower(trim($booking->status)) != 'dibatalkan')
                    )
                        <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin membatalkan booking ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="mt-3 w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full shadow-lg border-2 border-red-800">
                                Cancel
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="mt-4">Belum ada booking.</p>
    @endif
</div>
</main>
@endsection
