@extends('layouts.app')
@section('content')
<h2 class="text-2xl font-bold mb-4">Booking Lapangan</h2>
<form method="POST" action="/book" class="space-y-4">
  @csrf
  <select name="lapangan_id" class="w-full border p-2 rounded">
    @foreach(App\Models\Lapangan::all() as $lap)
      <option value="{{ $lap->id }}">{{ $lap->nama_lapangan }}</option>
    @endforeach
  </select>
  <input type="date" name="tanggal" class="w-full border p-2 rounded">
  <input type="text" name="jam" placeholder="Jam (misal 18:00 - 19:00)" class="w-full border p-2 rounded">
  <button type="submit" class="bg-blue-500 text-white p-2 rounded">Booking Sekarang</button>
</form>
@endsection
