<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Minumans extends Model
{
    use HasFactory;
    protected $table = 'minumans';
    protected $primaryKey = 'id_minuman';
    protected $fillable = ['name', 'harga'];

    public function transaksis()
    {
        return $this->belongsToMany(Transaksis::class, 'transaksi_minumans', 'id_minuman', 'id_transaksi')
            ->withPivot('jumlah', 'total')->withTimestamps();
    }
}
