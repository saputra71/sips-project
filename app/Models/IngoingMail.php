<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngoingMail extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat',
        'tgl_surat',
        'pengirim',
        'lampiran',
        'perihal',
        'document_id',
        'arsip',
        'tgl_terima',
    ];

    public function document()
    {
        return $this->hasOne(Document::class, 'id', 'document_id');
    }
}
