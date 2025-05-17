<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanans extends Model
{
    use HasFactory;
    protected $table = 'makanans';
    protected $primaryKey = 'id_makanan';
    protected $fillable = ['name', 'harga'];

    public function transaksis()
    {
        return $this->belongsToMany(Transaksis::class, 'transaksi_makanans', 'id_makanan', 'id_transaksi')
            ->withPivot('jumlah', 'total')->withTimestamps();
    }
}
