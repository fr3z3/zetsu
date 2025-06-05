<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal', 'jam', 'durasi', 'lapangan', 'pembayaran', 'user_id'];
    protected $table = 'bookings';

    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

}
