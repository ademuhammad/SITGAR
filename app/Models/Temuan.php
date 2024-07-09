<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'informasis_id',
        'opd_id',
        'status_id',
        'statustgr_id',
        'pegawai_id',
        'penyedia_id',
        'no_lhp',
        'no_sktjm',
        'no_skp2ks',
        'no_skp2k',
        'tgl_lhp',
        'obrik_pemeriksaan',
        'temuan',
        'rekomendasi',
        'nilai_rekomendasi',
        'bukti_surat',
        'nilai_telah_dibayar',
        'sisa_nilai_uang',
        'jumlah_jaminan',
        'jenis_jaminan'
    ];

    // Relasi ke tabel 'opds'
    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    // Relasi ke tabel 'informasis'
    public function informasi()
    {
        return $this->belongsTo(Informasi::class, 'informasis_id');
    }

    // Relasi ke tabel 'statuses'
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    // Relasi ke tabel 'statustgrs'
    public function statustgr()
    {
        return $this->belongsTo(Statustgr::class);
    }

    // Relasi ke tabel 'pegawais'
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    // Relasi ke tabel 'penyedias'
    public function penyedia()
    {
        return $this->belongsTo(Penyedia::class);
    }

    // Relasi ke tabel 'pembayaran'
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
