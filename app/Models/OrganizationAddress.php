<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationAddress extends Model
{
    use HasFactory;

    protected $table = 'organization_address';

    protected $fillable = [
        'address', 'zip', 'phone', 'website', 'latitude', 'zone_id', 'fax',
        'social_network', 'longitude', 'image', 'status'
    ];
}
