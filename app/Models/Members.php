<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;
    protected $table = 'members';
    protected $primaryKey = 'kode_member';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['kode_member', 'name', 'nomor_telpon'];

    public function scopeFilter($query, $filters)
    {

        if (isset($filters['name']) && $filters['name']) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return $query;
    }
}
