<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessIndustry extends Model
{
    use HasFactory;

    protected $table = 'business_industry';

    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
    ];
}
