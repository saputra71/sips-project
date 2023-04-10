<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposition extends Model
{
    use HasFactory;

    protected $fillable = [
        'surat_masuk_id',
        'surat_keluar_id',
        'status',
        'user_id',
        'catatan',
        'sender_id',
    ];

    public function IngoingMail()
    {
        return $this->hasOne(IngoingMail::class, 'id', 'surat_masuk_id');
    }

    public function OutgoingMail()
    {
        return $this->hasOne(OutgoingMail::class, 'id', 'surat_keluar_id');
    }

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function Sender()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }
}
