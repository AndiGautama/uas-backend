<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPulsa extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pulsa';

    protected $fillable = [
        'user_id',
        'nomor',
        'jumlah',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}