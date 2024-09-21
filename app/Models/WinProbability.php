<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinProbability extends Model
{
    use HasFactory;

    protected $table = 'win_probabilty';

    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
    ];
}
