<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'nama',
        'username',
        'password',
        'role',
        'foto',
        'alamat',
        'no_hp',
        'cabang',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Relasi dengan penerimaan
    public function penerimaan()
    {
        return $this->hasMany(Penerimaan::class, 'id_user', 'id_user');
    }

    // Relasi dengan pengeluaran
    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class, 'id_user', 'id_user');
    }
}
