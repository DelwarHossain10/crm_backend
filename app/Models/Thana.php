<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thana extends Model
{
    use HasFactory;

    protected $table = 'thana';

    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
    ];
}
