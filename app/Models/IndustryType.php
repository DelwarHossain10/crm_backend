<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryType extends Model
{
    use HasFactory;

    protected $table = 'industry_type';

    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
    ];
}
