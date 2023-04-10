<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Menjabat extends Model
{
    use HasFactory;

    protected $fillable = [
        'jabatan_id',
        'nip',
        'qrcode'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nip');
    }

    // create hasOne relationship with spatie Role model
    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'jabatan_id');
    }
}
