<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTemuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'jenis_temuan',
        'description'
    ];

    public function temuans()
    {
        return $this->hasMany(Temuan::class);
    }
}
