<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationServiceInfo extends Model
{
    use HasFactory;
    protected $table = 'organization_service_info';
    protected $fillable = [
        'name',
        'designation_id',
        'industry_id',
        'country_id',
        'district_id',
        'zip',
        'latitude',
        'skype',
        'social_network',
        'department_id',
        'income_range_id',
        'address',
        'division_id',
        'thana_id',
        'website',
        'longitude',
        'phone',
        'image',
    ];
}
