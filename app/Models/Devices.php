<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    use HasFactory;
    protected $table = 'devices';
    protected $primaryKey = 'id_device';
    protected $fillable = ['name', 'harga_perjam'];
}
