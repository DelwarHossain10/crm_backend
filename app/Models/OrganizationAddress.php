<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationAddress extends Model
{
    use HasFactory;

    protected $table = 'organization_address';

    protected $fillable = [
        'address',
        'zone',
        'zip',
        'phone',
        'website',
        'latitude',
        'longitude',
        'social_network',
        'fax',
    ];
}
