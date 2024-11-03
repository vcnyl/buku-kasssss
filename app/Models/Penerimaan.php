<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    use HasFactory;

    protected $table = 'penerimaan';
    protected $primaryKey = 'id_penerimaan';
    public $incrementing = false; // Make sure to set this to false if using non-incrementing keys
    protected $keyType = 'string';

    protected $fillable = [
        'id_penerimaan',
        'id_user',
        'id_kategori', // Ensure this is included for the relation with kategori
        'bukti',
        'tanggal',
        'nominal',
        'keterangan',
    ];

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi dengan kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori'); // Make sure this is correct
    }
}
