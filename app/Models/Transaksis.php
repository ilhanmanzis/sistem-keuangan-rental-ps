<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksis extends Model
{
    use HasFactory;
    protected $table = 'transaksis';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = ['id_user', 'kode_member', 'id_device', 'id_shift', 'tanggal', 'durasi_jam', 'bonus_jam', 'total', 'name', 'no_telpon', 'total_device', 'total_minuman', 'total_makanan'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shifts::class, 'id_shift', 'id_shift');
    }

    public function device()
    {
        return $this->belongsTo(Devices::class, 'id_device', 'id_device');
    }

    public function member()
    {
        return $this->belongsTo(Members::class, 'kode_member', 'kode_member');
    }

    public function makanans()
    {
        return $this->belongsToMany(Makanans::class, 'transaksi_makanans', 'id_transaksi', 'id_makanan')->withPivot('jumlah', 'total')->withTimestamps();
    }
    public function minumans()
    {
        return $this->belongsToMany(Minumans::class, 'transaksi_minumans', 'id_transaksi', 'id_minuman')->withPivot('jumlah', 'total')->withTimestamps();
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
