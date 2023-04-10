<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutgoingMail extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'nomor_surat',
        'tgl_surat',
        'pengirim',
        'lampiran',
        'perihal',
        'menjabat_id',
        'document_id',
        'arsip',
        'penerima',
        'content',
        'kepada',
        'dasar',
        'user_id',
        'reference',
    ];

    public function document()
    {
        return $this->hasOne(Document::class, 'id', 'document_id');
    }

    // public function menjabat()
    // {
    //     return $this->hasOne(Menjabat::class, 'id', 'menjabat_id');
    // }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'penerima');
    }

    public function authUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function menjabat()
    {
        return $this->hasOne(Employee::class, 'nip', 'menjabat_id');
    }

    public function setPenerimaAttribute($value)
    {
        $this->attributes['penerima'] = json_encode($value);
    }

    public function getPenerimaAttribute($value)
    {
        return $this->attributes['penerima'] = json_decode($value);
    }
}
