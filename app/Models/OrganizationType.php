<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationType extends Model
{
    use HasFactory;

    protected $table = 'organization_type';

    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
    ];
}
