<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $incrementing = false; // Make sure to set this to false if using non-incrementing keys
    protected $keyType = 'string';

    protected $fillable = [
        'id_kategori',
        'nama_kategori',
    ];

    // Relasi dengan pengeluaran
    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class, 'id_kategori', 'id_kategori');
    }

    // Relasi dengan penerimaan
    public function penerimaan()
    {
        return $this->hasMany(Penerimaan::class, 'id_kategori', 'id_kategori'); // Add relation for penerimaan
    }
}
