<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statustgr extends Model
{
    use HasFactory;
    protected $fillable =  [
        'tgr_name',
        'description',
    ];

    public function temuans()
    {
        return $this->hasMany(Temuan::class);
    }
}
