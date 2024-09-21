<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluencingRole extends Model
{
    use HasFactory;

    protected $table = 'influencing_role';

    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
    ];
}
