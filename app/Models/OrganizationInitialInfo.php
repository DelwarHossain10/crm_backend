<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationInitialInfo extends Model
{
    use HasFactory;
    protected $table = 'organization_initial_info';
    protected $fillable = [
        'name',
        'mobile',
        'project_id',
        'prospect_short_name',
        'email',
        'assigned_id',
        'image',
    ];
}
