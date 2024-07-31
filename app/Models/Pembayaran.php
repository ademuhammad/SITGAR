<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'temuan_id',
        'jumlah_pembayaran',
        'tgl_pembayaran',
        'bukti_pembayaran'
    ];

    public function temuan()
    {
        return $this->belongsTo(Temuan::class);
    }
}
