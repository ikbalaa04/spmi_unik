<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Akreditasi extends Model
{
    protected $table = 'akreditasis';

    protected $fillable = [
        'prodi_id',
        'fakultas',
        'peringkat',
        'sertifikat_url',
        'nomor_sk',
        'tanggal_akreditasi',
    ];

    protected $dates = [
        'tanggal_akreditasi',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}
