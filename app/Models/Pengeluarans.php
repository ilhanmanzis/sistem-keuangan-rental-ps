<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluarans extends Model
{
    use HasFactory;
    protected $table = 'pengeluarans';
    protected $primaryKey = 'id_pengeluaran';
    protected $fillable = ['id_user', 'id_shift', 'keterangan', 'harga', 'tanggal'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shifts::class, 'id_shift', 'id_shift');
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['user']) && $filters['user']) {
            $query->where('id_user', $filters['user']);
        }

        if (isset($filters['tanggal']) && $filters['tanggal']) {
            $query->where('tanggal', $filters['tanggal']);
        }

        return $query;
    }

    public function scopeTanggal($query, $filters)
    {

        if (isset($filters['tanggal']) && $filters['tanggal']) {
            $query->where('tanggal', $filters['tanggal']);
        }

        return $query;
    }
}
