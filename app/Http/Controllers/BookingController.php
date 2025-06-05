<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking');
    }

    public function submit(Request $request)
    {
        try {
            $validated = $request->validate([
                'tanggal' => 'required|date',
                'jam' => 'required',
                'lapangan' => 'required',
                'durasi' => 'required|integer|min:1|max:5',
                'pembayaran' => 'required|in:cash,transfer,qris',
            ]);
            $validated['durasi'] = (int) $validated['durasi'];

            // Simpan booking...
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422); // Gunakan 422 Unprocessable Entity
        }        

        // Hitung waktu mulai dan akhir booking baru
$startTime = Carbon::parse($validated['tanggal'] . ' ' . $validated['jam']);
$endTime = $startTime->copy()->addHours($validated['durasi']);

// Ambil semua booking aktif pada tanggal dan lapangan yang sama
$existingBookings = Booking::where('tanggal', $validated['tanggal'])
    ->where('lapangan', $validated['lapangan'])
    ->whereIn('status', ['pending', 'confirmed'])
    ->get();

foreach ($existingBookings as $booking) {
    $existingStart = Carbon::parse($booking->tanggal . ' ' . $booking->jam);
    $existingEnd = $existingStart->copy()->addHours($booking->durasi);

    if ($startTime < $existingEnd && $endTime > $existingStart) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Waktu yang dipilih sudah dibooking oleh orang lain.'
            ], 409);
        } else {
            return redirect()->back()->withInput()->withErrors([
                'jam' => 'Waktu yang dipilih sudah dibooking oleh orang lain.'
            ]);
        }
    }
    
}


        $booking = Booking::create([
            'tanggal' => $validated['tanggal'],
            'jam' => $validated['jam'],
            'durasi' => $validated['durasi'],
            'lapangan' => $validated['lapangan'],
            'pembayaran' => $validated['pembayaran'],
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil!',
                'data' => $booking
            ]);
        }

        return redirect()->route('booking')->with('success', 'Booking berhasil!');
    }

    public function myBooking()
    {
        $userId = Auth::id();
        $bookings = Booking::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('booking.mybooking', compact('bookings'));
    }

    public function cancelBooking($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id != Auth::id()) {
            abort(403);
        }

        $booking->status = 'dibatalkan';
        $booking->save();

        return redirect()->route('mybooking')->with('status', 'Booking berhasil dibatalkan.');
    }

    public function cancel($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (Carbon::now()->gte(Carbon::parse($booking->tanggal)->subDay())) {
            return redirect()->back()->with('error', 'Batas waktu pembatalan sudah lewat.');
        }

        $booking->delete();

        return redirect()->back()->with('success', 'Booking berhasil dibatalkan.');
    }

    public function getAvailableTimes(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $lapangan = $request->input('lapangan');

        // Ambil semua booking valid untuk tanggal & lapangan itu
        $bookings = Booking::where('tanggal', $tanggal)
            ->where('lapangan', $lapangan)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        // Jam buka dari 10:00 - 22:00
        $startTime = 10;
        $endTime = 22;
        $timeSlots = [];

        for ($i = $startTime; $i < $endTime; $i++) {
            $timeSlots[] = sprintf('%02d:00', $i);
        }

        // Hilangkan slot yang bentrok dengan booking yang sudah ada
        foreach ($bookings as $booking) {
            $startHour = (int)Carbon::parse($booking->jam)->format('H');
            $duration = $booking->durasi;

            for ($j = $startHour; $j < $startHour + $duration; $j++) {
                $slot = sprintf('%02d:00', $j);
                $timeSlots = array_filter($timeSlots, fn($time) => $time !== $slot);
            }
        }

        return response()->json(array_values($timeSlots));
    }

    public function getBookedSlots(Request $request)
{
    $tanggal = $request->query('tanggal');
    $lapangan = $request->query('lapangan');

    $bookings = Booking::where('tanggal', $tanggal)
        ->where('lapangan', $lapangan)
        ->get();

    $bookedSlots = [];

    foreach ($bookings as $booking) {
        $jamMulai = Carbon::createFromFormat('H:i', $booking->jam);
        for ($i = 0; $i < $booking->durasi; $i++) {
            $bookedSlots[] = $jamMulai->copy()->addHours($i)->format('H:i');
        }
    }

    return response()->json($bookedSlots);
}

public function allBookings()
{
    if (Auth::check() && Auth::user()->is_admin) {
        $bookings = Booking::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.all-bookings', compact('bookings'));
    }

    return redirect('/dashboard')->with('error', 'Unauthorized');
}


}
