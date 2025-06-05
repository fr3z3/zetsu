<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function getJadwal($tanggal, Request $request)
    {
        $lapangan = $request->query('lapangan');

        if (!$lapangan) {
            return response()->json([
                'success' => false,
                'message' => 'Lapangan wajib diisi.',
            ], 400);
        }

        $bookings = Booking::where('tanggal', $tanggal)
            ->where('lapangan', $lapangan)
            ->get(['jam', 'durasi']);

        $all_slots = [
            '07:00', '08:00', '09:00', '10:00', '11:00',
            '12:00', '13:00', '14:00', '15:00', '16:00',
            '17:00', '18:00', '19:00', '20:00', '21:00', '22:00'
        ];

        $available = [];

        foreach ($all_slots as $slot) {
            $is_available = true;
            $slot_time = Carbon::parse($slot);

            foreach ($bookings as $b) {
                $start = Carbon::parse($b->jam);
                $end = $start->copy()->addHours($b->durasi);

                if ($slot_time->between($start, $end->subMinute())) {
                    $is_available = false;
                    break;
                }
            }

            if ($is_available) {
                $available[] = $slot;
            }
        }

        return response()->json([
            'success' => true,
            'available_slots' => $available,
        ]);
    }
}