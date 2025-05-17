<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shifts extends Model
{
    use HasFactory;
    protected $table = 'shifts';
    protected $primaryKey = 'id_shift';
    protected $fillable = ['name', 'jam_mulai', 'jam_selesai'];
}
