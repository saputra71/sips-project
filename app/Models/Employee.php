<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'nip';
    protected $fillable = [
        'nip',
        'name',
        'address',
        'phone',
        'email',
        'password',
        'jabatan',
        'sign',
    ];
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'karyawan_id', 'nip');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'jabatan');
    }
}
