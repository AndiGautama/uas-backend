<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    /** @use HasFactory<\Database\Factories\TopUpFactory> */
    use HasFactory;

    /**
     * Atribut yang boleh diisi massal (mass assignable).
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'game',
        'amount',
        'status',
    ];

    /**
     * Atribut yang dicasting otomatis.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'integer',
        ];
    }

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}