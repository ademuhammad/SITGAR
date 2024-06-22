<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'informations_name',
        'dinas_name',
    ];

    public function temuans()
    {
        return $this->hasMany(Temuan::class);
    }
}
