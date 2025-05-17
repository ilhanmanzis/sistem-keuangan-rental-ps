<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRewards extends Model
{
    use HasFactory;
    protected $table = 'member_rewards';
    protected $primaryKey = 'id_member_reward';
    protected $fillable = ['kode_member', 'id_transaksi', 'durasi', 'tanggal_klaim'];

    public function member()
    {
        return $this->belongsTo(Members::class, 'kode_member', 'kode_member');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksis::class, 'id_transaksi', 'id_transaksi');
    }
}
