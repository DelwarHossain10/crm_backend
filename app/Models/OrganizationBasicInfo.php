<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationBasicInfo extends Model
{
    use HasFactory;
    protected $table = 'organization_basic_info';
    protected $fillable = [
        'priority_id',
        'zone_id',
        'campaign_id',
        'information_source_id',
        'service_id',
        'prospect_status_id',
        'contacted_by_id',
        'note',
        'attachment',
        'image',
        'status',
    ];
}
